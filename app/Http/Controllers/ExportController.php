<?php

namespace App\Http\Controllers;

use App\Exports\AttendanceExport;
use App\Exports\CoursesExport;
use App\Exports\DepartmentsExport;
use App\Exports\StudentsExport;
use App\Models\Course;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /** Abort unless the current user is an administrator. */
    private function requireAdmin(): void
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }
    }

    /**
     * Export landing page with filter forms for each dataset.
     */
    public function index()
    {
        $this->requireAdmin();

        return view('exports.index', [
            'courses'     => Course::orderBy('name')->get(),
            'departments' => Course::whereNotNull('department')->distinct()->orderBy('department')->pluck('department'),
            'students'    => Student::orderBy('fullname')->get(['id', 'fullname']),
        ]);
    }

    /**
     * Export students (filters: search, course_id, gender).
     */
    public function students(Request $request)
    {
        $this->requireAdmin();

        $filters = $request->only(['search', 'course_id', 'gender']);
        $filename = 'students_'.now()->format('Ymd_His').'.xlsx';

        return Excel::download(new StudentsExport($filters), $filename);
    }

    /**
     * Export courses (filters: search, department).
     */
    public function courses(Request $request)
    {
        $this->requireAdmin();

        $filters = $request->only(['search', 'department']);
        $filename = 'courses_'.now()->format('Ymd_His').'.xlsx';

        return Excel::download(new CoursesExport($filters), $filename);
    }

    /**
     * Export department summary.
     */
    public function departments(Request $request)
    {
        $this->requireAdmin();

        $filename = 'departments_'.now()->format('Ymd_His').'.xlsx';

        return Excel::download(new DepartmentsExport(), $filename);
    }

    /**
     * Export attendance (filters: month, status, from, to, student_id).
     */
    public function attendance(Request $request)
    {
        $this->requireAdmin();

        $filters = $request->only(['month', 'status', 'from', 'to', 'student_id']);

        // Validate month format if supplied.
        if (!empty($filters['month']) && !preg_match('/^\d{4}-\d{2}$/', $filters['month'])) {
            unset($filters['month']);
        }

        $filename = 'attendance_'.now()->format('Ymd_His').'.xlsx';

        return Excel::download(new AttendanceExport($filters), $filename);
    }
}
