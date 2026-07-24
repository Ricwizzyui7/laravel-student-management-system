<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ }">

        <div class="mb-6">
            <a href="{{ route('attendance.dashboard') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-blue-600 transition dark:text-gray-400 dark:hover:text-blue-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Dashboard
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50">
                <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100">Mark Attendance</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Select a date and set each student's status. Existing marks for the date are pre-filled.</p>
            </div>

            {{-- Date picker (GET reloads roster with existing marks) --}}
            <form method="GET" action="{{ route('attendance.mark') }}" class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-end gap-3 m-0">
                <div>
                    <label class="block text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wider mb-1">Attendance Date</label>
                    <input type="date" name="date" value="{{ $date }}" max="{{ now()->format('Y-m-d') }}"
                           class="border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:focus:border-blue-400">
                </div>
                <button type="submit" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg px-4 py-2 transition dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-300">Load</button>
            </form>

            @if($students->isEmpty())
                <div class="p-12 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">No students found. Add students before marking attendance.</p>
                </div>
            @else
                <form method="POST" action="{{ route('attendance.mark.store') }}" class="m-0">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}">

                    {{-- Quick set-all --}}
                    <div class="px-6 py-3 bg-blue-50/40 dark:bg-blue-950/30 border-b border-gray-100 dark:border-gray-700 flex flex-wrap items-center gap-2 text-xs">
                        <span class="font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mr-1">Set all:</span>
                        @foreach(\App\Models\Attendance::STATUSES as $s)
                            <button type="button"
                                    onclick="document.querySelectorAll('select[data-status]').forEach(el => el.value='{{ $s }}')"
                                    class="px-2.5 py-1 rounded-lg font-semibold {{ \App\Models\Attendance::badgeFor($s) }} hover:opacity-80 transition">
                                {{ ucfirst($s) }}
                            </button>
                        @endforeach
                        <button type="button"
                                onclick="document.querySelectorAll('select[data-status]').forEach(el => el.value='')"
                                class="px-2.5 py-1 rounded-lg font-semibold bg-gray-100 text-gray-600 hover:opacity-80 transition dark:bg-gray-700 dark:text-gray-400">Clear</button>
                    </div>

                    <div class="divide-y divide-gray-50 dark:divide-gray-700">
                        @foreach($students as $student)
                            <div class="flex items-center justify-between gap-4 px-6 py-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="h-9 w-9 rounded-lg bg-gray-100 dark:bg-gray-700 overflow-hidden shrink-0 border border-gray-100 dark:border-gray-700 flex items-center justify-center">
                                        @if($student->photo)
                                            <img src="{{ $student->photo }}" class="h-full w-full object-cover" alt="">
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">{{ $student->fullname }}</div>
                                        <div class="text-xs text-gray-400 dark:text-gray-500 truncate">{{ $student->course }}</div>
                                    </div>
                                </div>
                                <select name="statuses[{{ $student->id }}]" data-status
                                        class="border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 shrink-0 w-36">
                                    <option value="">— Not marked —</option>
                                    @foreach(\App\Models\Attendance::STATUSES as $s)
                                        <option value="{{ $s }}" @selected(($existing[$student->id] ?? '') === $s)>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>

                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 flex items-center justify-between">
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $students->count() }} students · Blank rows are skipped.</p>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl px-6 py-2.5 shadow-sm transition">
                            Save Attendance
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
