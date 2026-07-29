@extends('reports.pdf.layout')

@section('content')
    <table style="width: 100%; margin: 0 0 10px 0;">
        <tr>
            <td class="muted">{{ __('Departments:') }} <strong>{{ $groups->count() }}</strong></td>
            <td class="text-center muted">{{ __('Courses:') }} <strong>{{ $totalCourses }}</strong></td>
            <td class="text-right muted">{{ __('Students:') }} <strong>{{ $totalStudents }}</strong></td>
        </tr>
    </table>

    @forelse($groups as $group)
        <h2 class="section">{{ $group['department'] }}
            <span class="muted" style="font-size: 10px; font-weight: normal;">
                — {{ $group['courseCount'] }} {{ __('course(s)') }}, {{ $group['studentCount'] }} {{ __('student(s)') }}
            </span>
        </h2>
        <table class="data">
            <thead>
                <tr>
                    <th style="width: 90px;">{{ __('Code') }}</th>
                    <th>{{ __('Course Name') }}</th>
                    <th>{{ __('Duration') }}</th>
                    <th class="text-center">{{ __('Students') }}</th>
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
        <p class="text-center muted" style="padding: 20px;">{{ __('No departments found.') }}</p>
    @endforelse
@endsection
