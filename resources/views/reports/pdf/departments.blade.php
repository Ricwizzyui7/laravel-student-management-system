@extends('reports.pdf.layout')

@section('content')
    <table style="width: 100%; margin: 0 0 10px 0;">
        <tr>
            <td class="muted">Departments: <strong>{{ $groups->count() }}</strong></td>
            <td class="text-center muted">Courses: <strong>{{ $totalCourses }}</strong></td>
            <td class="text-right muted">Students: <strong>{{ $totalStudents }}</strong></td>
        </tr>
    </table>

    @forelse($groups as $group)
        <h2 class="section">{{ $group['department'] }}
            <span class="muted" style="font-size: 10px; font-weight: normal;">
                — {{ $group['courseCount'] }} course(s), {{ $group['studentCount'] }} student(s)
            </span>
        </h2>
        <table class="data">
            <thead>
                <tr>
                    <th style="width: 90px;">Code</th>
                    <th>Course Name</th>
                    <th>Duration</th>
                    <th class="text-center">Students</th>
                </tr>
            </thead>
            <tbody>
                @foreach($group['courses'] as $course)
                    <tr>
                        <td><strong>{{ $course->code }}</strong></td>
                        <td>{{ $course->name }}</td>
                        <td class="muted">{{ $course->duration ?? '—' }}</td>
                        <td class="text-center"><strong>{{ $course->students_count }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @empty
        <p class="text-center muted" style="padding: 20px;">No departments found.</p>
    @endforelse
@endsection
