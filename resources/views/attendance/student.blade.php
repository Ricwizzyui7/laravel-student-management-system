<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6 flex items-center justify-between">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('attendance.dashboard') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-blue-600 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to Dashboard
                </a>
            @else
                <span></span>
            @endif
            <a href="{{ route('students.show', $student->id) }}" class="text-sm font-semibold text-blue-600 hover:underline">Full Profile →</a>
        </div>

        {{-- Header --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="h-16 w-16 rounded-2xl bg-gray-100 dark:bg-gray-900 overflow-hidden shrink-0 border border-gray-100 dark:border-gray-700 flex items-center justify-center">
                    @if($student->photo)
                        <img src="{{ $student->photo }}" class="h-full w-full object-cover" alt="">
                    @else
                        <svg class="w-8 h-8 text-gray-300 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    @endif
                </div>
                <div class="min-w-0">
                    <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 truncate">{{ $student->fullname }}</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $student->course }} · Attendance Record</p>
                </div>
                <div class="ml-auto text-right">
                    <div class="text-3xl font-bold {{ $percentage >= 75 ? 'text-green-600' : ($percentage >= 50 ? 'text-yellow-600' : 'text-red-600') }}">{{ $percentage }}%</div>
                    <div class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider">Attendance Rate</div>
                </div>
            </div>
        </div>

        {{-- Summary cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            @foreach(['present' => ['Present','text-green-600'], 'absent' => ['Absent','text-red-600'], 'late' => ['Late','text-yellow-600'], 'excused' => ['Excused','text-blue-600']] as $key => $meta)
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-md transition">
                    <div class="text-2xl font-bold {{ $meta[1] }}">{{ $summary[$key] }}</div>
                    <div class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-0.5">{{ $meta[0] }} Days</div>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- This-month chart --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-4">This Month</h3>
                <div class="h-56 flex items-center justify-center">
                    <canvas id="studentChart"></canvas>
                </div>
            </div>

            {{-- Full record --}}
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-4">Attendance Log ({{ $summary['total'] }} records)</h3>
                <div class="divide-y divide-gray-50 dark:divide-gray-700 max-h-96 overflow-y-auto">
                    @forelse($records as $record)
                        <div class="flex items-center justify-between py-2.5">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $record->date->format('l, M d, Y') }}</span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $record->status_badge }}">{{ $record->status_label }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400 py-6 text-center">No attendance has been recorded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof window.Chart === 'undefined') return;
            const monthly = @json($monthly);
            const total = monthly.present + monthly.absent + monthly.late + monthly.excused;
            const el = document.getElementById('studentChart');
            if (!total) { el.parentElement.innerHTML = '<p class="text-sm text-gray-400 dark:text-gray-500">No records this month.</p>'; return; }

            new Chart(el, {
                type: 'doughnut',
                data: {
                    labels: ['Present', 'Absent', 'Late', 'Excused'],
                    datasets: [{
                        data: [monthly.present, monthly.absent, monthly.late, monthly.excused],
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
