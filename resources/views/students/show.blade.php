<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Back link --}}
        <div class="mb-6">
            <a href="{{ route('students.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Directory
            </a>
        </div>

        {{-- ===== HERO / PROFILE HEADER ===== --}}
        <div class="relative bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
            <div class="h-28 sm:h-32 bg-gradient-to-r from-blue-600 to-indigo-700 relative">
                <div class="absolute -right-8 -top-8 h-40 w-40 rounded-full bg-white/10 blur-xl"></div>
                <div class="absolute right-24 -bottom-16 h-40 w-40 rounded-full bg-indigo-500/20 blur-2xl"></div>
            </div>

            <div class="px-6 sm:px-8 pb-6">
                <div class="flex flex-col sm:flex-row sm:items-end gap-4 -mt-14 sm:-mt-16">
                    {{-- Photo --}}
                    <div class="h-28 w-28 sm:h-32 sm:w-32 rounded-2xl bg-gray-100 border-4 border-white shadow-md overflow-hidden shrink-0 flex items-center justify-center">
                        @if($student->photo)
                            <img src="{{ $student->photo }}" alt="{{ $student->fullname }}" class="h-full w-full object-cover">
                        @else
                            <svg class="w-14 h-14 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        @endif
                    </div>

                    {{-- Name + meta --}}
                    <div class="flex-1 min-w-0 sm:pb-1">
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight truncate">{{ $student->fullname }}</h1>
                        <div class="flex flex-wrap items-center gap-2 mt-2">
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-gray-500 bg-gray-100 px-2.5 py-1 rounded-lg">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5a2 2 0 011.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A2 2 0 013 9V4a1 1 0 011-1z"/></svg>
                                ID #{{ $student->id }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-blue-700 bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-100/60">
                                {{ $student->course }}
                            </span>
                            @if(strtolower($student->gender) === 'female')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-pink-50 text-pink-700 border border-pink-100/60">Female</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-sky-50 text-sky-700 border border-sky-100/60">Male</span>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 sm:pb-1">
                        <a href="{{ route('students.idcard', $student->id) }}" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-xl px-4 py-2.5 shadow-sm transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            ID Card
                        </a>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('reports.student', $student->id) }}" target="_blank" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-xl px-4 py-2.5 shadow-sm transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                PDF
                            </a>
                            <a href="{{ route('students.edit', $student->id) }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl px-4 py-2.5 shadow-sm hover:shadow transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit Profile
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== STATISTICS CARDS ===== --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            @php
                $stats = [
                    ['label' => 'Attendance Rate', 'value' => $attendanceRate.'%', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600'],
                    ['label' => 'Present Days', 'value' => $summary['present'], 'icon' => 'M5 13l4 4L19 7', 'bg' => 'bg-blue-50', 'text' => 'text-blue-600'],
                    ['label' => 'Profile Complete', 'value' => $profileCompletion.'%', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-600'],
                    ['label' => 'Age', 'value' => $student->calculated_age ?? 'N/A', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'bg' => 'bg-amber-50', 'text' => 'text-amber-600'],
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div class="h-10 w-10 rounded-xl {{ $stat['bg'] }} {{ $stat['text'] }} flex items-center justify-center">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                        </div>
                    </div>
                    <div class="mt-3 text-2xl font-bold text-gray-900 tracking-tight">{{ $stat['value'] }}</div>
                    <div class="text-xs font-medium text-gray-400 uppercase tracking-wider mt-0.5">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>

        {{-- ===== MAIN GRID ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- LEFT COLUMN --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Academic Information --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="h-8 w-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900">Academic Information</h3>
                    </div>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                        <div class="flex flex-col">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Course / Department</dt>
                            <dd class="text-sm font-medium text-gray-900 mt-1">{{ $student->course ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Student ID</dt>
                            <dd class="text-sm font-medium text-gray-900 mt-1">#{{ $student->id }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Registration Date</dt>
                            <dd class="text-sm font-medium text-gray-900 mt-1">{{ $student->created_at?->format('M d, Y') ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Last Updated</dt>
                            <dd class="text-sm font-medium text-gray-900 mt-1">{{ $student->updated_at?->diffForHumans() ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Personal Information --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="h-8 w-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900">Personal Information</h3>
                    </div>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                        <div class="flex flex-col">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Full Name</dt>
                            <dd class="text-sm font-medium text-gray-900 mt-1">{{ $student->fullname }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Gender</dt>
                            <dd class="text-sm font-medium text-gray-900 mt-1">{{ $student->gender ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Date of Birth</dt>
                            <dd class="text-sm font-medium text-gray-900 mt-1">{{ $student->date_of_birth?->format('M d, Y') ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex flex-col">
                            <dt class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Age</dt>
                            <dd class="text-sm font-medium text-gray-900 mt-1">{{ $student->calculated_age ? $student->calculated_age.' years' : 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>

                {{-- Attendance Summary + admin record form (existing working feature) --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="h-8 w-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900">Attendance Summary</h3>
                    </div>

                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div class="bg-green-50 p-4 rounded-xl">
                            <div class="text-2xl font-bold text-green-600">{{ $summary['present'] }}</div>
                            <div class="text-xs text-green-700 font-medium mt-0.5">Present Days</div>
                        </div>
                        <div class="bg-red-50 p-4 rounded-xl">
                            <div class="text-2xl font-bold text-red-600">{{ $summary['absent'] }}</div>
                            <div class="text-xs text-red-700 font-medium mt-0.5">Absent Days</div>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-xl">
                            <div class="text-2xl font-bold text-yellow-600">{{ $summary['late'] }}</div>
                            <div class="text-xs text-yellow-700 font-medium mt-0.5">Late Days</div>
                        </div>
                    </div>

                    @if(auth()->user()->role === 'admin')
                        <form action="{{ route('attendance.store', $student->id) }}" method="POST"
                              class="mt-6 flex flex-col sm:flex-row items-stretch sm:items-end gap-3 border-t border-gray-100 pt-5">
                            @csrf
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Date</label>
                                <input type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}"
                                       class="w-full border border-gray-200 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Status</label>
                                <select name="status" class="w-full border border-gray-200 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="present" @selected(old('status') === 'present')>Present</option>
                                    <option value="absent" @selected(old('status') === 'absent')>Absent</option>
                                    <option value="late" @selected(old('status') === 'late')>Late</option>
                                    <option value="excused" @selected(old('status') === 'excused')>Excused</option>
                                </select>
                            </div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg px-5 py-2 shadow-sm transition shrink-0">
                                Record Attendance
                            </button>
                        </form>
                        @error('date') <p class="text-xs text-red-600 mt-2 font-medium">{{ $message }}</p> @enderror
                        @error('status') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
                    @endif
                </div>

                {{-- Recent Attendance (existing working feature) --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-base font-bold text-gray-900 border-b border-gray-100 pb-3 mb-4">Recent Attendance</h3>
                    <div class="divide-y divide-gray-50">
                        @forelse($recentAttendances as $record)
                            <div class="flex justify-between items-center py-2.5">
                                <span class="text-sm text-gray-600">{{ $record->date->format('M d, Y') }}</span>
                                <div class="flex items-center gap-3">
                                    @php
                                        $badge = match($record->status) {
                                            'present' => 'bg-green-100 text-green-800',
                                            'absent'  => 'bg-red-100 text-red-800',
                                            'late'    => 'bg-yellow-100 text-yellow-800',
                                            'excused' => 'bg-blue-100 text-blue-800',
                                            default   => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $badge }}">{{ ucfirst($record->status) }}</span>
                                    @if(auth()->user()->role === 'admin')
                                        <form action="{{ route('attendance.destroy', [$student->id, $record->id]) }}" method="POST" class="inline m-0"
                                              onsubmit="return confirm('Remove this attendance record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-gray-400 hover:text-red-600 text-xs font-semibold transition">Remove</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 py-4 text-center">No attendance has been recorded for this student yet.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="space-y-6">

                {{-- Profile Completion --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Profile Completion</h3>
                    <div class="flex items-center gap-4">
                        <div class="relative h-20 w-20 shrink-0">
                            <svg class="h-20 w-20 -rotate-90" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" r="15.9155" fill="none" stroke="#f1f5f9" stroke-width="3.5"/>
                                <circle cx="18" cy="18" r="15.9155" fill="none" stroke="#2563eb" stroke-width="3.5"
                                        stroke-dasharray="{{ $profileCompletion }}, 100" stroke-linecap="round"/>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center text-sm font-bold text-gray-900">{{ $profileCompletion }}%</div>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            @if($profileCompletion === 100)
                                All key profile fields are complete. 🎉
                            @else
                                Add missing details like photo, email, phone, or date of birth to reach 100%.
                            @endif
                        </p>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="h-8 w-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900">Contact Information</h3>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 hover:bg-sky-50 transition group">
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-sky-600 transition shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <div class="min-w-0">
                                <div class="text-[11px] text-gray-400 uppercase tracking-wider font-semibold">Email</div>
                                <div class="text-sm font-medium text-gray-900 truncate">{{ $student->email ?? 'Not provided' }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 hover:bg-sky-50 transition group">
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-sky-600 transition shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <div class="min-w-0">
                                <div class="text-[11px] text-gray-400 uppercase tracking-wider font-semibold">Phone</div>
                                <div class="text-sm font-medium text-gray-900 truncate">{{ $student->phone ?? 'Not provided' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Recent Activities --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Recent Activities</h3>
                    <ol class="relative border-l border-gray-100 ml-2 space-y-5">
                        @forelse($activities as $activity)
                            @php
                                $dot = match($activity['color']) {
                                    'emerald' => 'bg-emerald-500',
                                    'amber'   => 'bg-amber-500',
                                    'red'     => 'bg-red-500',
                                    default   => 'bg-blue-500',
                                };
                            @endphp
                            <li class="ml-5">
                                <span class="absolute -left-1.5 h-3 w-3 rounded-full {{ $dot }} ring-4 ring-white"></span>
                                <p class="text-sm font-medium text-gray-800 leading-snug">{{ $activity['title'] }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ \Illuminate\Support\Carbon::parse($activity['time'])->diffForHumans() }}</p>
                            </li>
                        @empty
                            <li class="ml-5"><p class="text-sm text-gray-500">No recent activity.</p></li>
                        @endforelse
                    </ol>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
