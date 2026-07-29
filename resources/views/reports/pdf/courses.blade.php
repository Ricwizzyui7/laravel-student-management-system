@extends('reports.pdf.layout')

@section('content')
    <table style="width: 100%; margin: 0 0 10px 0;">
        <tr>
            <td class="muted">{{ __('Total courses:') }} <strong>{{ $courses->count() }}</strong></td>
            <td class="text-right muted">{{ __('Total enrolments:') }} <strong>{{ $totalStudents }}</strong></td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th style="width: 90px;">{{ __('Code') }}</th>
                <th>{{ __('Course Name') }}</th>
                <th>{{ __('Department') }}</th>
                <th>{{ __('Duration') }}</th>
                <th class="text-center">{{ __('Students') }}</th>
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
                <tr><td colspan="6" class="text-center muted" style="padding: 20px;">{{ __('No courses found.') }}</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
