<x-app-layout>
<div class="mt-4">

    <a href="{{ url('/students') }}"
       class="btn btn-primary">
        View Students
    </a>

    @if(Auth::user()->role == 'admin')
        <a href="{{ url('/students/create') }}"
           class="btn btn-success">
            Add Student
        </a>
    @endif

</div>

<div class="row">

    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h3>{{ $totalStudents }}</h3>
                <p>Total Students</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h3>{{ $maleStudents }}</h3>
                <p>Male Students</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <h3>{{ $femaleStudents }}</h3>
                <p>Female Students</p>
            </div>
        </div>
    </div>

</div>

<br>

<h3>Recent Students</h3>

<table class="table table-bordered">

<tr>
    <th>Name</th>
    <th>Course</th>
</tr>

@foreach($recentStudents as $student)

<tr>
    <td>{{ $student->fullname }}</td>
    <td>{{ $student->course }}</td>
</tr>

@endforeach
</table>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('genderChart');

    if (canvas) {
        const ctx = canvas.getContext('2d');

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: [
                        {{ $maleStudents }},
                        {{ $femaleStudents }}
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

});
</script>

<tr>
    
<div class="row mt-4">

    <div class="col-md-6">
        <div class="card shadow p-3">
            <h5 class="text-center">Students by Gender</h5>
            <div style="height:300px;">
                <canvas id="genderChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow p-3">
            <h5 class="text-center">Students by Course</h5>
            <div style="height:300px;">
                <canvas id="courseChart"></canvas>
            </div>
        </div>
    </div>

</div>
</tr>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const courseCanvas = document.getElementById('courseChart');

    if (courseCanvas) {

        const courseCtx = courseCanvas.getContext('2d');

        new Chart(courseCtx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($courseData as $course)
                        '{{ $course->course }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Students',
                    data: [
                        @foreach($courseData as $course)
                            {{ $course->total }},
                        @endforeach
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

});
</script>

</x-app-layout>