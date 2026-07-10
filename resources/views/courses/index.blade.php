<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Course Catalog</h2>
                    <p class="text-sm text-gray-500 mt-1">Manage academic programs, departments, and enrolment.</p>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
                    <form method="GET" action="{{ route('courses.index') }}" class="relative w-full sm:w-72 m-0">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                               class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block pl-10 pr-4 py-2.5 transition"
                               placeholder="Search code, name, department...">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </form>
                    @if(Auth::user()?->role == 'admin')
                        <a href="{{ route('courses.create') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-5 py-2.5 shadow-sm hover:shadow transition-all gap-2 shrink-0">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                            Add Course
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Statistics cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            @php
                $cards = [
                    ['label' => 'Total Courses', 'value' => $stats['total'], 'bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'icon' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'],
                    ['label' => 'Departments', 'value' => $stats['departments'], 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-600', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                    ['label' => 'Active (with students)', 'value' => $stats['withStudents'], 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ];
            @endphp
            @foreach($cards as $card)
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-between">
                    <div>
                        <div class="text-2xl font-bold text-gray-900 tracking-tight">{{ $card['value'] }}</div>
                        <div class="text-xs font-medium text-gray-400 uppercase tracking-wider mt-0.5">{{ $card['label'] }}</div>
                    </div>
                    <div class="h-11 w-11 rounded-xl {{ $card['bg'] }} {{ $card['text'] }} flex items-center justify-center shrink-0">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/></svg>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Course cards grid --}}
        @if($courses->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="mx-auto h-12 w-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h3 class="text-sm font-semibold text-gray-900">No courses found</h3>
                <p class="text-xs text-gray-500 mt-1">{{ $search ? 'Try a different search term.' : 'Add your first course to get started.' }}</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($courses as $course)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col overflow-hidden">
                        <div class="p-5 flex-1">
                            <div class="flex items-start justify-between gap-3">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100/60 tracking-wider">{{ $course->code }}</span>
                                <span class="inline-flex items-center gap-1 text-xs font-medium text-gray-500">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    {{ $course->students_count }}
                                </span>
                            </div>
                            <h3 class="mt-3 text-base font-bold text-gray-900 leading-snug">
                                <a href="{{ route('courses.show', $course->id) }}" class="hover:text-blue-600 transition">{{ $course->name }}</a>
                            </h3>
                            <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-500">
                                @if($course->department)
                                    <span class="inline-flex items-center gap-1"><svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>{{ $course->department }}</span>
                                @endif
                                @if($course->duration)
                                    <span class="inline-flex items-center gap-1"><svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>{{ $course->duration }}</span>
                                @endif
                            </div>
                            @if($course->description)
                                <p class="mt-3 text-xs text-gray-500 leading-relaxed line-clamp-2">{{ $course->description }}</p>
                            @endif
                        </div>
                        <div class="px-5 py-3 border-t border-gray-50 bg-gray-50/40 flex items-center justify-between">
                            <a href="{{ route('courses.show', $course->id) }}" class="text-xs font-semibold text-blue-600 hover:underline">View details</a>
                            @if(Auth::user()?->role == 'admin')
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('courses.edit', $course->id) }}" class="text-xs font-semibold text-gray-500 hover:text-blue-600 hover:bg-blue-50 px-2.5 py-1 rounded-lg transition">Edit</a>
                                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="inline m-0" onsubmit="return confirm('Delete this course?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-xs font-semibold text-gray-400 hover:text-red-600 hover:bg-red-50 px-2.5 py-1 rounded-lg transition">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($courses->hasPages())
                <div class="mt-6">{{ $courses->links() }}</div>
            @endif
        @endif
    </div>
</x-app-layout>
