<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Students Directory</h2>
                    <p class="text-sm text-gray-500 mt-1">Manage, filter, and review student academic enrollment details.</p>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
                    
                    <form method="GET" action="{{ url('/students') }}" class="relative w-full sm:w-72 m-0">
                        <div class="relative">
                            <input type="text"
                                   name="search"
                                   value="{{ $search ?? '' }}"
                                   class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block pl-10 pr-4 py-2.5 transition"
                                   placeholder="Search by name or course...">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </form>

                    @if(Auth::user()?->role == 'admin')
                        <a href="/students/create" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-5 py-2.5 shadow-sm hover:shadow transition-all gap-2 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add New Student
                        </a>
                    @endif
                </div>

            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse align-middle">
                    <thead>
                        <tr class="bg-gray-50/70 border-b border-gray-100 text-gray-600 text-xs font-semibold uppercase tracking-wider">
                            <th class="py-4 px-6 w-16 text-center">ID</th>
                            <th class="py-4 px-6">Student Info</th>
                            <th class="py-4 px-6">Course Path</th>
                            <th class="py-4 px-6 text-center">Gender</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-sm">
                        @forelse($students as $student)
                            <tr class="hover:bg-gray-50/50 transition-colors group">
                                
                                <td class="py-4 px-6 font-medium text-gray-400 text-center">
                                    #{{ $student->id }}
                                </td>

                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="h-11 w-11 rounded-xl bg-gray-100 overflow-hidden shrink-0 border border-gray-100 flex items-center justify-center">
                                            @if($student->photo)
                                                <img src="{{ $student->photo }}"
     class="h-full w-full object-cover">
                                            @else
                                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="/students/{{ $student->id }}" class="font-semibold text-gray-900 group-hover:text-blue-600 hover:underline transition-colors">
                                                {{ $student->fullname }}
                                            </a>
                                            <div class="text-xs text-gray-400 mt-0.5">Enrolled Student</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-gray-600 font-medium">
                                    {{ $student->course }}
                                </td>

                                <td class="py-4 px-6 text-center">
                                    @if(strtolower($student->gender) === 'female')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-pink-50 text-pink-700 border border-pink-100/60">
                                            Female
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100/60">
                                            Male
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="/students/{{ $student->id }}" class="inline-flex items-center justify-center text-gray-500 hover:text-blue-600 hover:bg-blue-50 h-8 px-3 rounded-lg text-xs font-semibold transition">
                                            View
                                        </a>
                                        <a href="/students/{{ $student->id }}/id-card" class="inline-flex items-center justify-center text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 h-8 px-3 rounded-lg text-xs font-semibold transition">
                                            ID Card
                                        </a>
                                        @if(Auth::user()?->role == 'admin')
                                            <a href="/students/{{ $student->id }}/edit" class="inline-flex items-center justify-center text-gray-500 hover:text-blue-600 hover:bg-blue-50 h-8 px-3 rounded-lg text-xs font-semibold transition">
                                                Edit
                                            </a>
                                            <form action="/students/{{ $student->id }}" method="POST" class="inline m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button class="inline-flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 h-8 px-3 rounded-lg text-xs font-semibold transition" onclick="return confirm('Are you sure you want to completely remove this record?')">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 px-6 text-center">
                                    <div class="max-w-sm mx-auto flex flex-col items-center">
                                        <div class="h-12 w-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-semibold text-gray-900">No Student Records Found</h3>
                                        <p class="text-xs text-gray-500 mt-1">There are no students listed matching those filters or your query parameters.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($students instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $students->hasPages())
                <div class="bg-gray-50/50 border-t border-gray-100 px-6 py-4">
                    {{ $students->appends(request()->query())->links() }}
                </div>
            @endif

        </div>

    </div>
</x-app-layout>