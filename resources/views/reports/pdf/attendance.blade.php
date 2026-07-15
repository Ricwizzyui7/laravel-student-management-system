@extends('reports.pdf.layout')

@section('content')
    <table style="width: 100%; margin: 0 0 10px 0;">
        <tr>
            <td class="muted">Students: <strong>{{ $rows->count() }}</strong></td>
            <td class="text-right muted">
                <span class="badge b-green">Present {{ $totals['present'] }}</span>
                <span class="badge b-red">Absent {{ $totals['absent'] }}</span>
                <span class="badge b-yellow">Late {{ $totals['late'] }}</span>
                <span class="badge b-blue">Excused {{ $totals['excused'] }}</span>
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th>Student</th>
                <th>Course</th>
                <th class="text-center">Present</th>
                <th class="text-center">Absent</th>
                <th class="text-center">Late</th>
                <th class="text-center">Excused</th>
                <th class="text-center">Total</th>
                <th class="text-center">Rate</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><strong>{{ $row['student']->fullname }}</strong></td>
                    <td class="muted">{{ $row['student']->course ?? '—' }}</td>
                    <td class="text-center">{{ $row['present'] }}</td>
                    <td class="text-center">{{ $row['absent'] }}</td>
                    <td class="text-center">{{ $row['late'] }}</td>
                    <td class="text-center">{{ $row['excused'] }}</td>
                    <td class="text-center"><strong>{{ $row['total'] }}</strong></td>
                    <td class="text-center">
                        @php $p = $row['percentage']; $cls = $p >= 75 ? 'b-green' : ($p >= 50 ? 'b-yellow' : 'b-red'); @endphp
                        <span class="badge {{ $cls }}">{{ $p }}%</span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center muted" style="padding: 20px;">No attendance data for this period.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
