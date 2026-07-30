<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    private function requireAdmin(): void
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }
    }

    private function rules($id = null): array
    {
        return [
            'code' => ['required', 'string', 'max:20', Rule::unique('courses', 'code')->ignore($id)],
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'duration' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function index(Request $request)
    {
        $search = $request->search;

        $courses = Course::withCount('students')
            ->with('department')
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%")
                      ->orWhere('department', 'like', "%{$search}%")
                      ->orWhereHas('department', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            })
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString();

        $stats = [
            'total'        => Course::count(),
            'departments'  => Department::count(),
            'withStudents' => Course::has('students')->count(),
        ];

        return view('courses.index', compact('courses', 'search', 'stats'));
    }

    public function create()
    {
        $this->requireAdmin();

        $departments = Department::orderBy('name')->get();

        return view('courses.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $this->requireAdmin();

        $validated = $request->validate($this->rules());

        $department = $validated['department_id'] ? Department::find($validated['department_id']) : null;
        $validated['department'] = $department?->name;

        Course::create($validated);

        return redirect()
            ->route('courses.index')
            ->with('success', __('Course created successfully.'));
    }

    public function show($id)
    {
        $course = Course::withCount('students')
            ->with(['department', 'students' => fn ($q) => $q->orderBy('fullname')])
            ->findOrFail($id);

        return view('courses.show', compact('course'));
    }

    public function edit($id)
    {
        $this->requireAdmin();

        $course = Course::with('department')->findOrFail($id);
        $departments = Department::orderBy('name')->get();

        return view('courses.edit', compact('course', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $this->requireAdmin();

        $course = Course::findOrFail($id);

        $validated = $request->validate($this->rules($id));

        $department = $validated['department_id'] ? Department::find($validated['department_id']) : null;
        $validated['department'] = $department?->name;

        $course->update($validated);

        return redirect()
            ->route('courses.index')
            ->with('success', __('Course updated successfully.'));
    }

    public function destroy($id)
    {
        $this->requireAdmin();

        $course = Course::withCount('students')->findOrFail($id);

        if ($course->students_count > 0) {
            return redirect()
                ->route('courses.index')
                ->with('error', __('Cannot delete ":name" — :count student(s) are still enrolled.', ['name' => $course->name, 'count' => $course->students_count]));
        }

        $course->delete();

        return redirect()
            ->route('courses.index')
            ->with('success', __('Course deleted successfully.'));
    }
}
