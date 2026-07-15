@extends('reports.pdf.layout')

@section('content')
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 14px;">
        <tr>
            <td style="width: 90px; vertical-align: top;">
                @if($student->photo)
                    <img src="{{ $student->photo }}" style="width: 80px; height: 96px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb;">
                @else
                    <div style="width: 80px; height: 96px; background: #e5e7eb; border-radius: 8px; text-align: center; line-height: 96px; color: #9ca3af; font-size: 9px;">No Photo</div>
                @endif
            </td>
            <td style="vertical-align: top; padding-left: 12px;">
                <div style="font-size: 18px; font-weight: bold; color: #111827;">{{ $student->fullname }}</div>
                <div style="font-size: 11px; color: #1d4ed8; font-weight: bold; margin-top: 2px;">{{ $student->student_number }}</div>
                <div style="font-size: 10px; color: #6b7280; margin-top: 4px;">{{ $student->course ?? '—' }} · {{ $student->department_name ?? '—' }}</div>
            </td>
        </tr>
    </table>

    <h2 class="section">Personal Information</h2>
    <table class="data">
        <tbody>
            <tr><td style="width: 30%;"><strong>Full Name</strong></td><td>{{ $student->fullname }}</td></tr>
            <tr><td><strong>Student Number</strong></td><td>{{ $student->student_number }}</td></tr>
            <tr><td><strong>Gender</strong></td><td>{{ ucfirst($student->gender) }}</td></tr>
            <tr><td><strong>Course</strong></td><td>{{ $student->course ?? '—' }}</td></tr>
            <tr><td><strong>Department</strong></td><td>{{ $student->department_name ?? '—' }}</td></tr>
            <tr><td><strong>Email</strong></td><td>{{ $student->email ?? '—' }}</td></tr>
            <tr><td><strong>Phone</strong></td><td>{{ $student->phone ?? '—' }}</td></tr>
            <tr><td><strong>Age</strong></td><td>{{ $student->calculated_age ?? '—' }}</td></tr>
            <tr><td><strong>Enrolled</strong></td><td>{{ optional($student->created_at)->format('d M Y') ?? '—' }}</td></tr>
        </tbody>
    </table>

    <h2 class="section">Attendance Summary</h2>
    <table class="data">
        <thead>
            <tr>
                <th class="text-center">Present</th>
                <th class="text-center">Absent</th>
                <th class="text-center">Late</th>
                <th class="text-center">Excused</th>
                <th class="text-center">Total Records</th>
                <th class="text-center">Attendance %</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center"><span class="badge b-green">{{ $summary['present'] }}</span></td>
                <td class="text-center"><span class="badge b-red">{{ $summary['absent'] }}</span></td>
                <td class="text-center"><span class="badge b-yellow">{{ $summary['late'] }}</span></td>
                <td class="text-center"><span class="badge b-blue">{{ $summary['excused'] }}</span></td>
                <td class="text-center"><strong>{{ $summary['total'] }}</strong></td>
                <td class="text-center"><strong>{{ $percentage }}%</strong></td>
            </tr>
        </tbody>
    </table>
@endsection
