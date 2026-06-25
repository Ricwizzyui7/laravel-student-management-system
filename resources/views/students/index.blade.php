<x-app-layout>
    <div class="container py-5">
        <div class="card shadow-sm p-4 bg-white rounded">
            
            {{-- Flexbox container layout to hold title and admin button side-by-side --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-dark font-weight-bold m-0">Students List</h2>
                <form method="GET" action="{{ url('/students') }}" class="mb-3">
    <div class="input-group">
        <input type="text"
               name="search"
               value="{{ $search ?? '' }}"
               class="form-control"
               placeholder="Search by name or course">

        <button class="btn btn-primary">
            Search
        </button>
    </div>
</form>
                {{-- ONLY SHOW THIS BUTTON TO ADMINS --}}
                @if(Auth::user()?->role == 'admin')
                    <a href="/students/create" class="btn btn-primary d-inline-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5a.5.5 0 0 1 .5-.5Z"/>
                        </svg>
                        Add New Student
                    </a>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle m-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Course</th>
                            <th>Gender</th>
                            <th>Photo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->fullname }}</td>
                                <td>{{ $student->course }}</td>
                                <td>{{ $student->gender }}</td>
                                <td>
                                    @if($student->photo)
                                        <img src="{{ asset('storage/'.$student->photo) }}" width="80" class="img-thumbnail">
                                    @endif
                                </td>
                                <td>
                                    @if(Auth::user()?->role == 'admin')
                                        <a href="/students/{{ $student->id }}/edit" class="btn btn-warning btn-sm me-1">Edit</a>
                                        <form action="/students/{{ $student->id }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                                        </form>
                                    @else
                                        <span class="text-muted small">No Actions</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-danger fw-bold">
                                    ⚠️ No student records were found in the database table!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($students instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $students->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                   {{ $students->appends(request()->query())->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>