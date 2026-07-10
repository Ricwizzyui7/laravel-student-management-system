<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /** Abort unless the current user is an administrator. */
    private function requireAdmin(): void
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }
    }

    /** Shared validation rules; $id excludes the current row on update. */
    private function rules($id = null): array
    {
        return [
            'code' => ['required', 'string', 'max:20', Rule::unique('courses', 'code')->ignore($id)],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * Display a listing of courses with enrolment counts.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $courses = Course::withCount('students')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%")
                      ->orWhere('department', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString();

        $stats = [
            'total'        => Course::count(),
            'departments'  => Course::whereNotNull('department')->distinct('department')->count('department'),
            'withStudents' => Course::has('students')->count(),
        ];

        return view('courses.index', compact('courses', 'search', 'stats'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $this->requireAdmin();

        return view('courses.create');
    }

    /**
     * Store a newly created course.
     */
    public function store(Request $request)
    {
        $this->requireAdmin();

        $validated = $request->validate($this->rules());

        Course::create($validated);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course created successfully.');
    }

    /**
     * Display a single course and its enrolled students.
     */
    public function show($id)
    {
        $course = Course::withCount('students')
            ->with(['students' => fn ($q) => $q->orderBy('fullname')])
            ->findOrFail($id);

        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the course.
     */
    public function edit($id)
    {
        $this->requireAdmin();

        $course = Course::findOrFail($id);

        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified course.
     */
    public function update(Request $request, $id)
    {
        $this->requireAdmin();

        $course = Course::findOrFail($id);

        $validated = $request->validate($this->rules($id));

        $course->update($validated);

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified course.
     */
    public function destroy($id)
    {
        $this->requireAdmin();

        $course = Course::withCount('students')->findOrFail($id);

        if ($course->students_count > 0) {
            return redirect()
                ->route('courses.index')
                ->with('error', "Cannot delete \"{$course->name}\" — {$course->students_count} student(s) are still enrolled.");
        }

        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with('success', 'Course deleted successfully.');
    }
}
