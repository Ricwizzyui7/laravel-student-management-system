<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Excel Exports</h1>
            <p class="text-sm text-gray-500 mt-1">Apply filters, then export any dataset to an .xlsx spreadsheet.</p>
        </div>

        <div class="space-y-6">

            {{-- STUDENTS --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="h-9 w-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Students</h3>
                </div>
                <form method="GET" action="{{ route('exports.students') }}" class="p-6 grid grid-cols-1 sm:grid-cols-4 gap-3 items-end m-0">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Search (name / email)</label>
                        <input type="text" name="search" class="w-full border border-gray-200 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Optional">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Course</label>
                        <select name="course_id" class="w-full border border-gray-200 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Gender</label>
                        <select name="gender" class="w-full border border-gray-200 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="sm:col-span-4">
                        <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg px-5 py-2.5 shadow-sm transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Export Students
                        </button>
                    </div>
                </form>
            </div>

            {{-- COURSES --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="h-9 w-9 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Courses</h3>
                </div>
                <form method="GET" action="{{ route('exports.courses') }}" class="p-6 grid grid-cols-1 sm:grid-cols-4 gap-3 items-end m-0">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Search (name / code)</label>
                        <input type="text" name="search" class="w-full border border-gray-200 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Optional">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Department</label>
                        <select name="department" class="w-full border border-gray-200 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}">{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-4">
                        <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg px-5 py-2.5 shadow-sm transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Export Courses
                        </button>
                    </div>
                </form>
            </div>

            {{-- DEPARTMENTS --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="h-9 w-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Departments</h3>
                </div>
                <form method="GET" action="{{ route('exports.departments') }}" class="p-6 flex items-center justify-between gap-4 m-0">
                    <p class="text-sm text-gray-500">Summary of all departments with course and student counts.</p>
                    <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg px-5 py-2.5 shadow-sm transition shrink-0">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Export Departments
                    </button>
                </form>
            </div>

            {{-- ATTENDANCE --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="h-9 w-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Attendance</h3>
                </div>
                <form method="GET" action="{{ route('exports.attendance') }}" class="p-6 grid grid-cols-1 sm:grid-cols-4 gap-3 items-end m-0">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Month</label>
                        <input type="month" name="month" class="w-full border border-gray-200 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Status</label>
                        <select name="status" class="w-full border border-gray-200 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All</option>
                            @foreach(\App\Models\Attendance::STATUSES as $s)
                                <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">From</label>
                        <input type="date" name="from" class="w-full border border-gray-200 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">To</label>
                        <input type="date" name="to" class="w-full border border-gray-200 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Student</label>
                        <select name="student_id" class="w-full border border-gray-200 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">All students</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-4">
                        <button type="submit" class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-lg px-5 py-2.5 shadow-sm transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Export Attendance
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
