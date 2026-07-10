<x-app-layout>
    <div class="py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            
            <div class="flex justify-between items-center border-b pb-4 mb-6">
                <h2 class="text-xl font-bold text-gray-800">Student Profile</h2>
                
                <div class="space-x-2">
                    <a href="{{ route('students.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-sm font-medium">
                        Back to List
                    </a>
                    
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('students.edit', $student->id) }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium">
                            Edit Profile
                        </a>
                    @endif
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-1/3 flex flex-col items-center border-r pr-0 md:pr-6 border-gray-100">
                    <div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 overflow-hidden shadow-inner mb-2">
                        @if($student->photo)
                           <img src="{{ $student->photo }}"
     class="h-full w-full object-cover" alt="Profile Photo">
                        @else
                            <span class="text-xs uppercase font-semibold">No Photo</span>
                        @endif
                    </div>
                </div>

                <div class="w-full md:w-2/3 space-y-3">
                    <div class="grid grid-cols-3 gap-2 border-b pb-2"><span class="font-semibold text-gray-600">Name:</span> <span class="col-span-2 text-gray-800">{{ $student->fullname }}</span></div>
                    <div class="grid grid-cols-3 gap-2 border-b pb-2"><span class="font-semibold text-gray-600">Course:</span> <span class="col-span-2 text-gray-800">{{ $student->course ?? 'N/A' }}</span></div>
                    <div class="grid grid-cols-3 gap-2 border-b pb-2"><span class="font-semibold text-gray-600">Gender:</span> <span class="col-span-2 text-gray-800">{{ $student->gender ?? 'N/A' }}</span></div>
                    <div class="grid grid-cols-3 gap-2 border-b pb-2"><span class="font-semibold text-gray-600">Email:</span> <span class="col-span-2 text-gray-800">{{ $student->email ?? 'N/A' }}</span></div>
                    <div class="grid grid-cols-3 gap-2 border-b pb-2"><span class="font-semibold text-gray-600">Phone:</span> <span class="col-span-2 text-gray-800">{{ $student->phone ?? 'N/A' }}</span></div>
                    <div class="grid grid-cols-3 gap-2 border-b pb-2"><span class="font-semibold text-gray-600">Age:</span> <span class="col-span-2 text-gray-800">{{ $student->age ?? 'N/A' }}</span></div>
                    <div class="grid grid-cols-3 gap-2"><span class="font-semibold text-gray-600">Joined:</span> <span class="col-span-2 text-gray-800">{{ $student->created_at->format('Y-m-d') }}</span></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Attendance Summary</h3>
            <div class="grid grid-cols-3 gap-4 text-center">
                <div class="bg-green-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">{{ $summary['present'] }}</div>
                    <div class="text-sm text-green-700 font-medium">Present Days</div>
                </div>
                <div class="bg-red-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-red-600">{{ $summary['absent'] }}</div>
                    <div class="text-sm text-red-700 font-medium">Absent Days</div>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="text-2xl font-bold text-yellow-600">{{ $summary['late'] }}</div>
                    <div class="text-sm text-yellow-700 font-medium">Late Days</div>
                </div>
            </div>

            @if(auth()->user()->role === 'admin')
                <form action="{{ route('attendance.store', $student->id) }}" method="POST"
                      class="mt-6 flex flex-col sm:flex-row items-stretch sm:items-end gap-3 border-t pt-5">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Date</label>
                        <input type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" max="{{ now()->format('Y-m-d') }}"
                               class="w-full border border-gray-200 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">Status</label>
                        <select name="status" class="w-full border border-gray-200 text-gray-900 text-sm rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="present" @selected(old('status') === 'present')>Present</option>
                            <option value="absent" @selected(old('status') === 'absent')>Absent</option>
                            <option value="late" @selected(old('status') === 'late')>Late</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg px-5 py-2 shadow-sm transition shrink-0">
                        Record Attendance
                    </button>
                </form>
                @error('date') <p class="text-xs text-red-600 mt-2 font-medium">{{ $message }}</p> @enderror
                @error('status') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
            @endif
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Recent Attendance</h3>
            <div class="divide-y divide-gray-100">
                @forelse($recentAttendances as $record)
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">{{ $record->date->format('Y-m-d') }}</span>
                        <div class="flex items-center gap-3">
                            @php
                                $badge = match($record->status) {
                                    'present' => 'bg-green-100 text-green-800',
                                    'absent'  => 'bg-red-100 text-red-800',
                                    'late'    => 'bg-yellow-100 text-yellow-800',
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
</x-app-layout>