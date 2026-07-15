@extends('reports.pdf.layout')

@section('content')
    <table style="width: 100%; margin: 0 0 10px 0;">
        <tr>
            <td class="muted">Total courses: <strong>{{ $courses->count() }}</strong></td>
            <td class="text-right muted">Total enrolments: <strong>{{ $totalStudents }}</strong></td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th style="width: 90px;">Code</th>
                <th>Course Name</th>
                <th>Department</th>
                <th>Duration</th>
                <th class="text-center">Students</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $i => $course)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $course->code }}</strong></td>
                    <td>{{ $course->name }}</td>
                    <td>{{ $course->department ?? '—' }}</td>
                    <td class="muted">{{ $course->duration ?? '—' }}</td>
                    <td class="text-center"><strong>{{ $course->students_count }}</strong></td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center muted" style="padding: 20px;">No courses found.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
