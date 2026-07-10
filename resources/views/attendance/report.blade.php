<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <a href="{{ route('attendance.dashboard') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-blue-600 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Dashboard
            </a>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-bold text-gray-900">Monthly Attendance Report</h1>
                <p class="text-sm text-gray-500 mt-1">{{ $monthLabel }}</p>
            </div>
            <form method="GET" action="{{ route('attendance.report') }}" class="flex items-end gap-2 m-0">
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Select Month</label>
                    <input type="month" name="month" value="{{ $month }}"
                           class="border border-gray-200 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg px-4 py-2 transition">View</button>
                <button type="button" onclick="window.print()" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg px-4 py-2 transition">Print</button>
            </form>
        </div>

        {{-- Totals summary --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            @foreach(['present' => ['Present','text-green-600','bg-green-50'], 'absent' => ['Absent','text-red-600','bg-red-50'], 'late' => ['Late','text-yellow-600','bg-yellow-50'], 'excused' => ['Excused','text-blue-600','bg-blue-50']] as $key => $meta)
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="text-2xl font-bold {{ $meta[1] }}">{{ $totals[$key] }}</div>
                    <div class="text-xs font-medium text-gray-400 uppercase tracking-wider mt-0.5">{{ $meta[0] }} (month)</div>
                </div>
            @endforeach
        </div>

        {{-- Chart --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 mb-6">
            <h3 class="text-base font-bold text-gray-900 mb-4">Attendance % by Student</h3>
            <div class="h-72">
                <canvas id="reportChart"></canvas>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/70 border-b border-gray-100 text-gray-600 text-xs font-semibold uppercase tracking-wider">
                            <th class="py-4 px-6">Student</th>
                            <th class="py-4 px-6 text-center">Present</th>
                            <th class="py-4 px-6 text-center">Absent</th>
                            <th class="py-4 px-6 text-center">Late</th>
                            <th class="py-4 px-6 text-center">Excused</th>
                            <th class="py-4 px-6 text-center">Total</th>
                            <th class="py-4 px-6 w-48">Attendance %</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($rows as $row)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-3.5 px-6">
                                    <a href="{{ route('attendance.student', $row['student']->id) }}" class="font-medium text-gray-900 hover:text-blue-600 hover:underline transition">
                                        {{ $row['student']->fullname }}
                                    </a>
                                    <div class="text-xs text-gray-400">{{ $row['student']->course }}</div>
                                </td>
                                <td class="py-3.5 px-6 text-center text-gray-700">{{ $row['present'] }}</td>
                                <td class="py-3.5 px-6 text-center text-gray-700">{{ $row['absent'] }}</td>
                                <td class="py-3.5 px-6 text-center text-gray-700">{{ $row['late'] }}</td>
                                <td class="py-3.5 px-6 text-center text-gray-700">{{ $row['excused'] }}</td>
                                <td class="py-3.5 px-6 text-center font-semibold text-gray-900">{{ $row['total'] }}</td>
                                <td class="py-3.5 px-6">
                                    @php
                                        $pct = $row['percentage'];
                                        $bar = $pct >= 75 ? 'bg-green-500' : ($pct >= 50 ? 'bg-yellow-500' : 'bg-red-500');
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 h-2 rounded-full bg-gray-100 overflow-hidden">
                                            <div class="h-full rounded-full {{ $bar }}" style="width: {{ $pct }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-700 w-9 text-right">{{ $pct }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="py-12 px-6 text-center text-sm text-gray-500">No students to report.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof window.Chart === 'undefined') return;
            const rows = @json($rows->map(fn ($r) => ['name' => $r['student']->fullname, 'pct' => $r['percentage']])->values());
            if (!rows.length) return;

            new Chart(document.getElementById('reportChart'), {
                type: 'bar',
                data: {
                    labels: rows.map(r => r.name),
                    datasets: [{
                        label: 'Attendance %',
                        data: rows.map(r => r.pct),
                        backgroundColor: rows.map(r => r.pct >= 75 ? '#22c55e' : (r.pct >= 50 ? '#eab308' : '#ef4444')),
                        borderRadius: 6,
                    }],
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, max: 100, ticks: { callback: v => v + '%' } } },
                },
            });
        });
    </script>
    @endpush
</x-app-layout>
