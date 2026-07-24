<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-blue-600 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Courses
            </a>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('courses.edit', $course->id) }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl px-4 py-2.5 shadow-sm transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Course
                </a>
            @endif
        </div>

        {{-- Header --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 sm:p-8 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-start gap-4">
                <div class="h-14 w-14 rounded-2xl bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center shrink-0">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 border border-blue-100/60 dark:border-blue-800/60 tracking-wider">{{ $course->code }}</span>
                        @if($course->department)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 dark:bg-gray-900 text-gray-600 dark:text-gray-400">{{ $course->department }}</span>
                        @endif
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight mt-2">{{ $course->name }}</h1>
                    @if($course->description)
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mt-2">{{ $course->description }}</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Stat cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $course->students_count }}</div>
                <div class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-0.5">Enrolled Students</div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $course->duration ?? '—' }}</div>
                <div class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-0.5">Duration</div>
            </div>
            <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm col-span-2 sm:col-span-1">
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 truncate">{{ $course->department ?? '—' }}</div>
                <div class="text-xs font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-0.5">Department</div>
            </div>
        </div>

        {{-- Enrolled students --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">Enrolled Students</h3>
            </div>
            <div class="divide-y divide-gray-50 dark:divide-gray-700">
                @forelse($course->students as $student)
                    <a href="{{ route('students.show', $student->id) }}" class="flex items-center gap-3 px-6 py-3 hover:bg-gray-50/50 dark:hover:bg-gray-700/50 transition group">
                        <div class="h-10 w-10 rounded-xl bg-gray-100 dark:bg-gray-900 overflow-hidden shrink-0 border border-gray-100 dark:border-gray-700 flex items-center justify-center">
                            @if($student->photo)
                                <img src="{{ $student->photo }}" class="h-full w-full object-cover" alt="">
                            @else
                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition truncate">{{ $student->fullname }}</div>
                            <div class="text-xs text-gray-400 dark:text-gray-500">{{ ucfirst($student->gender) }}</div>
                        </div>
                        <span class="text-gray-300 dark:text-gray-600 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition">→</span>
                    </a>
                @empty
                    <p class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-400">No students are enrolled in this course yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
