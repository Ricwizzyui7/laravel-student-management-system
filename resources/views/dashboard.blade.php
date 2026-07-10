<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-sm p-6 sm:p-8 mb-8 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Welcome Back, {{ Auth::user()->name }}!</h2>
                <p class="text-blue-100 text-sm sm:text-base mt-1.5 max-w-xl">
                    Here is an overview of what is happening across your student ecosystem today. Manage records, monitor enrollments, and check security access rules.
                </p>
            </div>
            <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-xl pointer-events-none"></div>
            <div class="absolute right-20 -bottom-20 h-48 w-48 rounded-full bg-indigo-500/20 blur-2xl pointer-events-none"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Total Registered</span>
                    <span class="block text-3xl font-bold text-gray-900 mt-1 tracking-tight">{{ number_format($totalStudents) }}</span>
                    <a href="/students" class="text-xs text-blue-600 font-medium mt-1.5 inline-flex items-center gap-1 hover:underline">
                        View Complete Directory →
                    </a>
                </div>
                <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Male Students</span>
                    <span class="block text-3xl font-bold text-gray-900 mt-1 tracking-tight">{{ number_format($maleStudents) }}</span>
                    <span class="block text-xs text-gray-400 font-medium mt-1.5">
                        {{ $totalStudents > 0 ? round($maleStudents / $totalStudents * 100) : 0 }}% of cohort
                    </span>
                </div>
                <div class="h-12 w-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Female Students</span>
                    <span class="block text-3xl font-bold text-gray-900 mt-1 tracking-tight">{{ number_format($femaleStudents) }}</span>
                    <span class="block text-xs text-gray-400 font-medium mt-1.5">
                        {{ $totalStudents > 0 ? round($femaleStudents / $totalStudents * 100) : 0 }}% of cohort
                    </span>
                </div>
                <div class="h-12 w-12 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Your Access Level</span>
                    <span class="block text-2xl font-bold text-gray-900 mt-2 tracking-tight uppercase">
                        {{ Auth::user()->role ?? 'Staff' }}
                    </span>
                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 border border-emerald-100 px-2 py-0.5 rounded-md mt-2">
                        ● Connection Secure
                    </span>
                </div>
                <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-1">
                <h3 class="text-base font-bold text-gray-900 mb-4">Quick Navigation Links</h3>
                <div class="space-y-3">

                    <a href="/students" class="group flex items-center justify-between p-3.5 rounded-xl bg-gray-50 hover:bg-blue-50 border border-gray-100 hover:border-blue-100 transition-all">
                        <div class="flex items-center gap-3">
                            <div class="text-gray-400 group-hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-900 transition-colors">View All Students</span>
                        </div>
                        <span class="text-gray-400 group-hover:text-blue-500 text-xs font-semibold transition-transform group-hover:translate-x-0.5">→</span>
                    </a>

                    <a href="{{ route('courses.index') }}" class="group flex items-center justify-between p-3.5 rounded-xl bg-gray-50 hover:bg-indigo-50 border border-gray-100 hover:border-indigo-100 transition-all">
                        <div class="flex items-center gap-3">
                            <div class="text-gray-400 group-hover:text-indigo-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-900 transition-colors">Course Catalog</span>
                        </div>
                        @if(($totalCourses ?? 0) > 0)
                            <span class="text-[11px] font-semibold text-indigo-700 bg-indigo-100 px-2 py-0.5 rounded-md">{{ $totalCourses }} courses</span>
                        @else
                            <span class="text-gray-400 group-hover:text-indigo-500 text-xs font-semibold transition-transform group-hover:translate-x-0.5">→</span>
                        @endif
                    </a>

                    <a href="{{ route('attendance.dashboard') }}" class="group flex items-center justify-between p-3.5 rounded-xl bg-gray-50 hover:bg-emerald-50 border border-gray-100 hover:border-emerald-100 transition-all">
                        <div class="flex items-center gap-3">
                            <div class="text-gray-400 group-hover:text-emerald-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-emerald-900 transition-colors">Attendance Dashboard</span>
                        </div>
                        @if(($markedToday ?? 0) > 0)
                            <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md">{{ $presentToday }} present today</span>
                        @else
                            <span class="text-gray-400 group-hover:text-emerald-500 text-xs font-semibold transition-transform group-hover:translate-x-0.5">→</span>
                        @endif
                    </a>

                    @if(Auth::user()?->role == 'admin')
                        <a href="/students/create" class="group flex items-center justify-between p-3.5 rounded-xl bg-gray-50 hover:bg-blue-50 border border-gray-100 hover:border-blue-100 transition-all">
                            <div class="flex items-center gap-3">
                                <div class="text-gray-400 group-hover:text-blue-600 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-blue-900 transition-colors">Add New Record</span>
                            </div>
                            <span class="text-gray-400 group-hover:text-blue-500 text-xs font-semibold transition-transform group-hover:translate-x-0.5">→</span>
                        </a>
                    @endif

                    <a href="/profile" class="group flex items-center justify-between p-3.5 rounded-xl bg-gray-50 hover:bg-blue-50 border border-gray-100 hover:border-blue-100 transition-all">
                        <div class="flex items-center gap-3">
                            <div class="text-gray-400 group-hover:text-blue-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-blue-900 transition-colors">Account Settings</span>
                        </div>
                        <span class="text-gray-400 group-hover:text-blue-500 text-xs font-semibold transition-transform group-hover:translate-x-0.5">→</span>
                    </a>

                </div>

                <h3 class="text-base font-bold text-gray-900 mt-6 mb-4">Enrollment by Course</h3>
                <div class="space-y-3">
                    @forelse($courseData as $course)
                        <div>
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="font-medium text-gray-700 truncate pr-2">{{ $course->course }}</span>
                                <span class="font-semibold text-gray-500 shrink-0">{{ $course->total }}</span>
                            </div>
                            <div class="h-2 w-full rounded-full bg-gray-100 overflow-hidden">
                                <div class="h-full rounded-full bg-blue-500" style="width: {{ $totalStudents > 0 ? max(4, round($course->total / $totalStudents * 100)) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400">No course data available yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-gray-900">Recently Added Students</h3>
                    <a href="/students" class="text-xs font-semibold text-blue-600 hover:underline">View all</a>
                </div>

                <div class="divide-y divide-gray-50">
                    @forelse($recentStudents as $student)
                        <a href="/students/{{ $student->id }}" class="flex items-center gap-3 py-3 group">
                            <div class="h-10 w-10 rounded-xl bg-gray-100 overflow-hidden shrink-0 border border-gray-100 flex items-center justify-center">
                                @if($student->photo)
                                    <img src="{{ $student->photo }}" class="h-full w-full object-cover" alt="">
                                @else
                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-semibold text-gray-900 group-hover:text-blue-600 transition-colors truncate">{{ $student->fullname }}</div>
                                <div class="text-xs text-gray-400 truncate">{{ $student->course }}</div>
                            </div>
                            <div class="text-xs text-gray-400 shrink-0">{{ $student->created_at?->diffForHumans() }}</div>
                        </a>
                    @empty
                        <div class="py-12 text-center">
                            <h3 class="text-sm font-semibold text-gray-900">No students yet</h3>
                            <p class="text-xs text-gray-500 mt-1">Records you add will appear here.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4 p-4 rounded-xl bg-blue-50/50 border border-blue-100/40 flex gap-3 items-start">
                    <div class="text-blue-600 mt-0.5 shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="text-xs text-blue-800 leading-relaxed">
                        <strong>Access notice:</strong> Users with the <strong>Staff</strong> role can view student records, while creating, editing, and deleting records is restricted to <strong>System Administrators</strong>.
                    </div>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
