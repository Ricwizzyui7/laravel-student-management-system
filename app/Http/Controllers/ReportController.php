<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Course;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /** Abort unless the current user is an administrator. */
    private function requireAdmin(): void
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }
    }

    /**
     * Build a PDF from a report view with shared metadata (logo, title, dates).
     * Streams inline so the browser preview/print works; ?download=1 forces save.
     */
    private function makePdf(string $view, array $data, string $filename, Request $request)
    {
        $data = array_merge([
            'institution' => config('app.institution_name', 'Global Institute of Technology'),
            'generatedAt' => Carbon::now(),
        ], $data);

        $pdf = Pdf::loadView($view, $data)
            ->setPaper('a4', $data['orientation'] ?? 'portrait')
            ->setOption(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);

        return $request->boolean('download')
            ? $pdf->download($filename)
            : $pdf->stream($filename);
    }

    /**
     * Landing page listing all available reports.
     */
    public function index()
    {
        $this->requireAdmin();

        $stats = [
            'students'    => Student::count(),
            'courses'     => Course::count(),
            'departments' => Course::whereNotNull('department')->distinct('department')->count('department'),
            'attendance'  => Attendance::count(),
        ];

        return view('reports.index', compact('stats'));
    }

    /**
     * 1. Student List — all students with course, department, gender.
     */
    public function studentList(Request $request)
    {
        $this->requireAdmin();

        $students = Student::with('course')->orderBy('fullname')->get();

        return $this->makePdf('reports.pdf.student-list', [
            'title'       => 'Student List Report',
            'students'    => $students,
            'orientation' => 'landscape',
        ], 'student-list.pdf', $request);
    }

    /**
     * 2. Student Profile — single student with attendance summary.
     */
    public function studentProfile(Request $request, $id)
    {
        $this->requireAdmin();

        $student = Student::with(['course', 'attendances'])->findOrFail($id);

        $summary = [
            'present' => $student->attendances->where('status', 'present')->count(),
            'absent'  => $student->attendances->where('status', 'absent')->count(),
            'late'    => $student->attendances->where('status', 'late')->count(),
            'excused' => $student->attendances->where('status', 'excused')->count(),
            'total'   => $student->attendances->count(),
        ];

        return $this->makePdf('reports.pdf.student-profile', [
            'title'      => 'Student Profile Report',
            'student'    => $student,
            'summary'    => $summary,
            'percentage' => $student->attendancePercentage(),
        ], 'student-profile-'.$student->id.'.pdf', $request);
    }

    /**
     * 3. Attendance Report — monthly per-student breakdown.
     */
    public function attendance(Request $request)
    {
        $this->requireAdmin();

        $month = $request->input('month', Carbon::today()->format('Y-m'));
        if (!preg_match('/^\d{4}-\d{2}$/', $month)) {
            $month = Carbon::today()->format('Y-m');
        }

        $students = Student::with(['attendances' => fn ($q) => $q->forMonth($month)])
            ->orderBy('fullname')
            ->get();

        $rows = $students->map(fn (Student $s) => [
            'student'    => $s,
            'present'    => $s->attendances->where('status', 'present')->count(),
            'absent'     => $s->attendances->where('status', 'absent')->count(),
            'late'       => $s->attendances->where('status', 'late')->count(),
            'excused'    => $s->attendances->where('status', 'excused')->count(),
            'total'      => $s->attendances->count(),
            'percentage' => $s->attendancePercentage($s->attendances),
        ]);

        $totals = [
            'present' => $rows->sum('present'),
            'absent'  => $rows->sum('absent'),
            'late'    => $rows->sum('late'),
            'excused' => $rows->sum('excused'),
        ];

        return $this->makePdf('reports.pdf.attendance', [
            'title'       => 'Attendance Report',
            'subtitle'    => Carbon::createFromFormat('Y-m', $month)->format('F Y'),
            'rows'        => $rows,
            'totals'      => $totals,
            'orientation' => 'landscape',
        ], 'attendance-'.$month.'.pdf', $request);
    }

    /**
     * 4. Course Report — all courses with enrolment counts.
     */
    public function courses(Request $request)
    {
        $this->requireAdmin();

        $courses = Course::withCount('students')->orderBy('name')->get();

        return $this->makePdf('reports.pdf.courses', [
            'title'    => 'Course Report',
            'courses'  => $courses,
            'totalStudents' => $courses->sum('students_count'),
        ], 'course-report.pdf', $request);
    }

    /**
     * 5. Department Report — courses & students grouped by department.
     */
    public function departments(Request $request)
    {
        $this->requireAdmin();

        $courses = Course::withCount('students')->orderBy('name')->get();

        $groups = $courses->groupBy(fn ($c) => $c->department ?: 'Unassigned')
            ->map(fn ($items, $dept) => [
                'department'    => $dept,
                'courses'       => $items,
                'courseCount'   => $items->count(),
                'studentCount'  => $items->sum('students_count'),
            ])
            ->sortKeys()
            ->values();

        return $this->makePdf('reports.pdf.departments', [
            'title'   => 'Department Report',
            'groups'  => $groups,
            'totalCourses'  => $courses->count(),
            'totalStudents' => $courses->sum('students_count'),
        ], 'department-report.pdf', $request);
    }
}
