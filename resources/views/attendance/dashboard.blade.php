<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Attendance Dashboard</h1>
                <p class="text-sm text-gray-500 mt-1">Overview of attendance across all students · {{ now()->format('l, M d, Y') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('attendance.mark') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl px-4 py-2.5 shadow-sm transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Mark Attendance
                </a>
                <a href="{{ route('attendance.report') }}" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-xl px-4 py-2.5 transition">
                    Monthly Report
                </a>
            </div>
        </div>

        {{-- Stat cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            @php
                $cards = [
                    ['label' => 'Overall Rate', 'value' => $overallRate.'%', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                    ['label' => 'Present Today', 'value' => $today['present'], 'bg' => 'bg-green-50', 'text' => 'text-green-600', 'icon' => 'M5 13l4 4L19 7'],
                    ['label' => 'Absent Today', 'value' => $today['absent'], 'bg' => 'bg-red-50', 'text' => 'text-red-600', 'icon' => 'M6 18L18 6M6 6l12 12'],
                    ['label' => 'Not Marked', 'value' => $today['unmarked'], 'bg' => 'bg-gray-100', 'text' => 'text-gray-500', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ];
            @endphp
            @foreach($cards as $card)
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <div class="h-10 w-10 rounded-xl {{ $card['bg'] }} {{ $card['text'] }} flex items-center justify-center">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/></svg>
                    </div>
                    <div class="mt-3 text-2xl font-bold text-gray-900 tracking-tight">{{ $card['value'] }}</div>
                    <div class="text-xs font-medium text-gray-400 uppercase tracking-wider mt-0.5">{{ $card['label'] }}</div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            {{-- Trend line chart --}}
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4">Last 14 Days</h3>
                <div class="h-64">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            {{-- Distribution doughnut --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4">Status Distribution</h3>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="distChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Today breakdown + recent --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-base font-bold text-gray-900 mb-4">Today at a Glance</h3>
                <div class="space-y-3">
                    @foreach(['present' => 'Present', 'late' => 'Late', 'excused' => 'Excused', 'absent' => 'Absent'] as $key => $label)
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-2 text-sm text-gray-600">
                                <span class="h-2.5 w-2.5 rounded-full {{ \App\Models\Attendance::badgeFor($key) }}"></span>
                                {{ $label }}
                            </span>
                            <span class="text-sm font-semibold text-gray-900">{{ $today[$key] }}</span>
                        </div>
                    @endforeach
                    <div class="flex items-center justify-between border-t border-gray-100 pt-3">
                        <span class="text-sm text-gray-500">Marked / Total</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $today['marked'] }} / {{ $totalStudents }}</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-gray-900">Recent Marks</h3>
                    <a href="{{ route('attendance.history') }}" class="text-xs font-semibold text-blue-600 hover:underline">View history</a>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($recent as $record)
                        <div class="flex items-center justify-between py-2.5">
                            <a href="{{ route('attendance.student', $record->student_id) }}" class="text-sm font-medium text-gray-800 hover:text-blue-600 transition">
                                {{ $record->student->fullname ?? 'Unknown' }}
                            </a>
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-gray-400">{{ $record->date->format('M d, Y') }}</span>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $record->status_badge }}">{{ $record->status_label }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 py-4 text-center">No attendance recorded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof window.Chart === 'undefined') return;

            const trendData = @json($trend);
            const distData = @json($distribution);

            new Chart(document.getElementById('trendChart'), {
                type: 'line',
                data: {
                    labels: trendData.map(d => d.label),
                    datasets: [
                        { label: 'Present', data: trendData.map(d => d.present), borderColor: '#16a34a', backgroundColor: 'rgba(22,163,74,0.1)', tension: 0.35, fill: true },
                        { label: 'Absent', data: trendData.map(d => d.absent), borderColor: '#dc2626', backgroundColor: 'rgba(220,38,38,0.1)', tension: 0.35, fill: true },
                    ],
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } }, scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } },
            });

            new Chart(document.getElementById('distChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Present', 'Absent', 'Late', 'Excused'],
                    datasets: [{
                        data: [distData.present, distData.absent, distData.late, distData.excused],
                        backgroundColor: ['#16a34a', '#dc2626', '#ca8a04', '#2563eb'],
                        borderWidth: 0,
                    }],
                },
                options: { responsive: true, maintainAspectRatio: false, cutout: '62%', plugins: { legend: { position: 'bottom' } } },
            });
        });
    </script>
    @endpush
</x-app-layout>
