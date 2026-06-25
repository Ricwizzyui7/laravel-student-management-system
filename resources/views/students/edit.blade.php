<h1>Edit Student</h1>

<form action="/students/{{ $student->id }}" method="POST">

    @csrf

    @method('PUT')

    <input
        type="text"
        name="fullname"
        value="{{ $student->fullname }}">

    <br><br>

    <input
        type="text"
        name="course"
        value="{{ $student->course }}">

    <br><br>

    <select name="gender">

        <option value="Male"
            {{ $student->gender == 'Male' ? 'selected' : '' }}>
            Male
        </option>

        <option value="Female"
            {{ $student->gender == 'Female' ? 'selected' : '' }}>
            Female
        </option>

    </select>

    <br><br>

    <button type="submit">
        Update Student
    </button>

</form>