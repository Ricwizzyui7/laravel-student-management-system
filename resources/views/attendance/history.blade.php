<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <a href="{{ route('attendance.dashboard') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-blue-600 transition dark:text-gray-400 dark:hover:text-blue-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Dashboard
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 mb-6">
            <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Attendance History</h1>

            <form method="GET" action="{{ route('attendance.history') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 m-0">
                <div class="lg:col-span-2">
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1">Search Student</label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Name..."
                           class="w-full border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900">
                        <option value="">All</option>
                        @foreach(\App\Models\Attendance::STATUSES as $s)
                            <option value="{{ $s }}" @selected(($filters['status'] ?? '') === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1">From</label>
                    <input type="date" name="from" value="{{ $filters['from'] ?? '' }}"
                           class="w-full border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1">To</label>
                    <input type="date" name="to" value="{{ $filters['to'] ?? '' }}"
                           class="w-full border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900">
                </div>
                <div class="sm:col-span-2 lg:col-span-5 flex items-center gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg px-5 py-2 transition">Filter</button>
                    <a href="{{ route('attendance.history') }}" class="text-sm font-semibold text-gray-500 hover:text-gray-700 px-3 py-2 dark:text-gray-400 dark:hover:text-gray-200">Reset</a>
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/70 dark:bg-gray-900/70 border-b border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-400 text-xs font-semibold uppercase tracking-wider">
                            <th class="py-4 px-6">Date</th>
                            <th class="py-4 px-6">Student</th>
                            <th class="py-4 px-6">Course</th>
                            <th class="py-4 px-6 text-center">Status</th>
                            <th class="py-4 px-6 text-right">Recorded</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700 text-sm">
                        @forelse($records as $record)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="py-3.5 px-6 font-medium text-gray-700 dark:text-gray-300">{{ $record->date->format('M d, Y') }}</td>
                                <td class="py-3.5 px-6">
                                    <a href="{{ route('attendance.student', $record->student_id) }}" class="font-medium text-gray-900 hover:text-blue-600 hover:underline transition dark:text-gray-100 dark:hover:text-blue-400">
                                        {{ $record->student->fullname ?? 'Unknown' }}
                                    </a>
                                </td>
                                <td class="py-3.5 px-6 text-gray-500 dark:text-gray-400">{{ $record->student->course ?? '—' }}</td>
                                <td class="py-3.5 px-6 text-center">
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $record->status_badge }}">{{ $record->status_label }}</span>
                                </td>
                                <td class="py-3.5 px-6 text-right text-xs text-gray-400 dark:text-gray-500">{{ $record->created_at?->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 px-6 text-center text-sm text-gray-500 dark:text-gray-400">No attendance records match your filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($records->hasPages())
                <div class="bg-gray-50/50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-700 px-6 py-4">
                    {{ $records->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
