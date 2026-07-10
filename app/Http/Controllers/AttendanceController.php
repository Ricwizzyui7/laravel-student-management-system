<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    /* -----------------------------------------------------------------
     |  Access helpers
     | -----------------------------------------------------------------
     */

    /** Abort unless the current user is an administrator. */
    private function requireAdmin(): void
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Only administrators can perform this action.');
        }
    }

    /** The student record linked to the current (non-admin) user, if any. */
    private function currentStudent(): ?Student
    {
        return Student::where('user_id', Auth::id())->first();
    }

    /* -----------------------------------------------------------------
     |  Attendance Dashboard
     | -----------------------------------------------------------------
     */
    public function dashboard()
    {
        // Non-admins are routed straight to their own attendance profile.
        if (!Auth::user()->isAdmin()) {
            $student = $this->currentStudent();

            if (!$student) {
                return view('attendance.no-record');
            }

            return redirect()->route('attendance.student', $student->id);
        }

        $today = Carbon::today();

        $totalStudents = Student::count();

        // Today's status breakdown.
        $todayCounts = Attendance::whereDate('date', $today)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $today = [
            'present'  => (int) ($todayCounts['present'] ?? 0),
            'absent'   => (int) ($todayCounts['absent'] ?? 0),
            'late'     => (int) ($todayCounts['late'] ?? 0),
            'excused'  => (int) ($todayCounts['excused'] ?? 0),
        ];
        $today['marked'] = array_sum($today);
        $today['unmarked'] = max(0, $totalStudents - $today['marked']);

        // Overall status distribution (all time) for the doughnut chart.
        $distribution = Attendance::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');
        $distribution = collect(Attendance::STATUSES)
            ->mapWithKeys(fn ($s) => [$s => (int) ($distribution[$s] ?? 0)]);

        // Overall attendance rate across every record.
        $totalRecords = $distribution->sum();
        $countable = $totalRecords - $distribution['excused'];
        $overallRate = $countable > 0
            ? (int) round(($distribution['present'] + $distribution['late']) / $countable * 100)
            : 0;

        // Last 14 days present-count trend (line chart).
        $trend = collect(range(13, 0))->map(function ($daysAgo) {
            $day = Carbon::today()->subDays($daysAgo);
            return [
                'label'   => $day->format('M d'),
                'present' => Attendance::whereDate('date', $day)->where('status', 'present')->count(),
                'absent'  => Attendance::whereDate('date', $day)->where('status', 'absent')->count(),
            ];
        });

        // Most recent marks.
        $recent = Attendance::with('student')->latest('date')->latest('id')->take(8)->get();

        return view('attendance.dashboard', compact(
            'totalStudents',
            'today',
            'distribution',
            'overallRate',
            'trend',
            'recent'
        ));
    }

    /* -----------------------------------------------------------------
     |  Mark Attendance (bulk, admin only)
     | -----------------------------------------------------------------
     */
    public function markForm(Request $request)
    {
        $this->requireAdmin();

        $date = $request->input('date', Carbon::today()->format('Y-m-d'));

        $students = Student::orderBy('fullname')->get();

        // Existing marks for the chosen date, keyed by student id.
        $existing = Attendance::whereDate('date', $date)
            ->pluck('status', 'student_id');

        return view('attendance.mark', compact('students', 'date', 'existing'));
    }

    public function markStore(Request $request)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'date' => ['required', 'date', 'before_or_equal:today'],
            'statuses' => ['required', 'array'],
            'statuses.*' => ['nullable', Rule::in(Attendance::STATUSES)],
        ]);

        $saved = 0;

        foreach ($validated['statuses'] as $studentId => $status) {
            if (empty($status)) {
                continue; // Skip students left blank / not marked.
            }

            Attendance::updateOrCreate(
                ['student_id' => $studentId, 'date' => $validated['date']],
                ['status' => $status]
            );
            $saved++;
        }

        return redirect()
            ->route('attendance.mark', ['date' => $validated['date']])
            ->with('success', "Attendance saved for {$saved} student(s) on {$validated['date']}.");
    }

    /* -----------------------------------------------------------------
     |  Attendance History (filterable)
     | -----------------------------------------------------------------
     */
    public function history(Request $request)
    {
        $this->requireAdmin();

        $filters = $request->only(['status', 'from', 'to', 'search']);

        $records = Attendance::with('student')
            ->status($filters['status'] ?? null)
            ->when($filters['from'] ?? null, fn ($q, $from) => $q->whereDate('date', '>=', $from))
            ->when($filters['to'] ?? null, fn ($q, $to) => $q->whereDate('date', '<=', $to))
            ->when($filters['search'] ?? null, function ($q, $search) {
                $q->whereHas('student', fn ($s) => $s->where('fullname', 'like', "%{$search}%"));
            })
            ->latest('date')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('attendance.history', compact('records', 'filters'));
    }

    /* -----------------------------------------------------------------
     |  Monthly Report
     | -----------------------------------------------------------------
     */
    public function report(Request $request)
    {
        $this->requireAdmin();

        $month = $request->input('month', Carbon::today()->format('Y-m'));
        // Guard against malformed input.
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = Carbon::today()->format('Y-m');
        }

        $students = Student::with(['attendances' => fn ($q) => $q->forMonth($month)])
            ->orderBy('fullname')
            ->get();

        $rows = $students->map(function (Student $student) {
            $records = $student->attendances;
            return [
                'student'    => $student,
                'present'    => $records->where('status', 'present')->count(),
                'absent'     => $records->where('status', 'absent')->count(),
                'late'       => $records->where('status', 'late')->count(),
                'excused'    => $records->where('status', 'excused')->count(),
                'total'      => $records->count(),
                'percentage' => $student->attendancePercentage($records),
            ];
        });

        $totals = [
            'present' => $rows->sum('present'),
            'absent'  => $rows->sum('absent'),
            'late'    => $rows->sum('late'),
            'excused' => $rows->sum('excused'),
        ];

        $monthLabel = Carbon::createFromFormat('Y-m', $month)->format('F Y');

        return view('attendance.report', compact('rows', 'totals', 'month', 'monthLabel'));
    }

    /* -----------------------------------------------------------------
     |  Student Attendance Profile
     | -----------------------------------------------------------------
     */
    public function student($id)
    {
        $student = Student::with('attendances')->findOrFail($id);

        // Non-admins may only view the profile linked to their own account.
        if (!Auth::user()->isAdmin()) {
            $own = $this->currentStudent();
            if (!$own || $own->id !== $student->id) {
                abort(403, 'You can only view your own attendance record.');
            }
        }

        $records = $student->attendances;

        $summary = [
            'present' => $records->where('status', 'present')->count(),
            'absent'  => $records->where('status', 'absent')->count(),
            'late'    => $records->where('status', 'late')->count(),
            'excused' => $records->where('status', 'excused')->count(),
        ];
        $summary['total'] = $records->count();

        $percentage = $student->attendancePercentage($records);

        // Current-month day-by-day counts for the mini chart.
        $month = Carbon::today()->format('Y-m');
        $monthly = collect(Attendance::STATUSES)->mapWithKeys(function ($s) use ($records, $month) {
            return [$s => $records->filter(function ($r) use ($s, $month) {
                return $r->status === $s && $r->date->format('Y-m') === $month;
            })->count()];
        });

        return view('attendance.student', compact('student', 'summary', 'percentage', 'monthly', 'records'));
    }

    /* -----------------------------------------------------------------
     |  Per-student quick mark (used by the student profile page)
     | -----------------------------------------------------------------
     */
    public function store(Request $request, $studentId)
    {
        $this->requireAdmin();

        $validated = $request->validate([
            'date' => ['required', 'date', 'before_or_equal:today'],
            'status' => ['required', Rule::in(Attendance::STATUSES)],
        ]);

        $student = Student::findOrFail($studentId);

        // One record per student per day: overwrite if it already exists.
        $student->attendances()->updateOrCreate(
            ['date' => $validated['date']],
            ['status' => $validated['status']]
        );

        return redirect()
            ->route('students.show', $student->id)
            ->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Remove an attendance record.
     */
    public function destroy($studentId, $attendanceId)
    {
        $this->requireAdmin();

        $student = Student::findOrFail($studentId);

        $attendance = $student->attendances()->findOrFail($attendanceId);
        $attendance->delete();

        return redirect()
            ->route('students.show', $student->id)
            ->with('success', 'Attendance record removed.');
    }
}
