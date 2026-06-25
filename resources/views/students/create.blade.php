<x-app-layout>

<h2>Add Student</h2>

<form action="/students" method="POST" enctype="multipart/form-data">
    @if ($errors->any())

        <div class="alert alert-danger">


    <ul>

        @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>

@endif

    @csrf

    <div class="mb-3">
        <label>Name</label>
        <input type="text"
       name="fullname"
       value="{{ old('fullname') }}"
       class="form-control">
    </div>

    <div class="mb-3">
        <label>Course</label>
        <input type="text"
               name="course"
               value="{{ old('course') }}"
               class="form-control">
    </div>

    <div class="mb-3">
        <label>Gender</label>

        <select name="gender"
                class="form-control">

            <option {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
            <option {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>

        </select>
    </div>

    <div class="mb-3">
       <label>Photo</label>

         <input
             type="file"
             name="photo"
             class="form-control">
    </div>

    <button class="btn btn-primary">
        Save Student
    </button>

</form>

</x-app-layout>