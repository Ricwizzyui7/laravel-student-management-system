<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Reports</h1>
            <p class="text-sm text-gray-500 mt-1">Generate professional PDF reports. Preview in-browser or download.</p>
        </div>

        {{-- Quick stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            @foreach([
                ['label' => 'Students', 'value' => $stats['students'], 'bg' => 'bg-blue-50', 'text' => 'text-blue-600'],
                ['label' => 'Courses', 'value' => $stats['courses'], 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-600'],
                ['label' => 'Departments', 'value' => $stats['departments'], 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600'],
                ['label' => 'Attendance Records', 'value' => $stats['attendance'], 'bg' => 'bg-amber-50', 'text' => 'text-amber-600'],
            ] as $s)
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($s['value']) }}</div>
                    <div class="text-xs font-medium text-gray-400 uppercase tracking-wider mt-0.5">{{ $s['label'] }}</div>
                </div>
            @endforeach
        </div>

        {{-- Report cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @php
                $reports = [
                    ['title' => 'Student List', 'desc' => 'All students with course, department, and contact details.', 'route' => route('reports.students'), 'icon_bg' => 'bg-blue-50', 'icon_text' => 'text-blue-600'],
                    ['title' => 'Attendance Report', 'desc' => 'Monthly per-student attendance breakdown and rates.', 'route' => route('reports.attendance'), 'icon_bg' => 'bg-emerald-50', 'icon_text' => 'text-emerald-600'],
                    ['title' => 'Course Report', 'desc' => 'All courses with enrolment counts and duration.', 'route' => route('reports.courses'), 'icon_bg' => 'bg-indigo-50', 'icon_text' => 'text-indigo-600'],
                    ['title' => 'Department Report', 'desc' => 'Courses and students grouped by department.', 'route' => route('reports.departments'), 'icon_bg' => 'bg-purple-50', 'icon_text' => 'text-purple-600'],
                ];
            @endphp

            @foreach($reports as $r)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 p-6 flex flex-col">
                    <div class="h-11 w-11 rounded-xl {{ $r['icon_bg'] }} {{ $r['icon_text'] }} flex items-center justify-center mb-4">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">{{ $r['title'] }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed mt-1 flex-1">{{ $r['desc'] }}</p>
                    <div class="mt-4 flex items-center gap-2">
                        <a href="{{ $r['route'] }}" target="_blank" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg px-3.5 py-2 transition">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Preview
                        </a>
                        <a href="{{ $r['route'] }}?download=1" class="inline-flex items-center gap-1.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold rounded-lg px-3.5 py-2 transition">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download
                        </a>
                    </div>
                </div>
            @endforeach

            {{-- Student profile report needs a student picker --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col">
                <div class="h-11 w-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center mb-4">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <h3 class="text-base font-bold text-gray-900">Student Profile</h3>
                <p class="text-xs text-gray-500 leading-relaxed mt-1 flex-1">Individual student report — open any student's profile and click <strong>PDF</strong>, or enter an ID below.</p>
                <form onsubmit="event.preventDefault(); const id=this.sid.value.trim(); if(id) window.open('{{ url('reports/students') }}/'+id, '_blank');" class="mt-4 flex items-center gap-2">
                    <input type="number" name="sid" min="1" placeholder="Student ID" class="w-full border border-gray-200 text-gray-900 text-xs rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-lg px-4 py-2 transition shrink-0">Generate</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
