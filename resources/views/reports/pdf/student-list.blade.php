@extends('reports.pdf.layout')

@section('content')
    <p class="muted" style="margin: 0 0 8px 0;">Total students: <strong>{{ $students->count() }}</strong></p>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th>Full Name</th>
                <th>Course</th>
                <th>Department</th>
                <th class="text-center">Gender</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $i => $student)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $student->fullname }}</strong></td>
                    <td>{{ $student->course ?? '—' }}</td>
                    <td>{{ $student->department_name ?? '—' }}</td>
                    <td class="text-center">{{ ucfirst($student->gender) }}</td>
                    <td class="muted">{{ $student->email ?? '—' }}</td>
                    <td class="muted">{{ $student->phone ?? '—' }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center muted" style="padding: 20px;">No students found.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
