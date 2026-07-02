<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $search = $request->search;

    $students = Student::when($search, function ($query, $search) {
        return $query->where('fullname', 'like', "%{$search}%")
                     ->orWhere('course', 'like', "%{$search}%");
    })->paginate(5);

    return view('students.index', compact('students', 'search'));
}
    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    if(Auth::user()->role != 'admin'){
        abort(403);
    }

    return view('students.create');
}

public function store(Request $request)
{   if(Auth::user()->role != 'admin'){
    abort(403);
    }
    $request->validate([
        'fullname' => 'required|min:3',
        'course' => 'required',
        'gender' => 'required'
    ]);

    $photoPath = null;

    if ($request->hasFile('photo')) {

        $photoPath = $request
            ->file('photo')
            ->store('students', 'public');
    }

    Student::create([
        'fullname' => $request->fullname,
        'course' => $request->course,
        'gender' => $request->gender,
        'photo' => $photoPath
    ]);

    return redirect('/students');
}


    public function dashboard()
{
    $totalStudents = Student::count();

    $maleStudents = Student::where('gender', 'Male')->count();

    $femaleStudents = Student::where('gender', 'Female')->count();

    $recentStudents = Student::latest()->take(5)->get();

    $courseData = Student::select('course', DB::raw('count(*) as total'))
    ->groupBy('course')
    ->get();

    return view('dashboard', compact(
        'totalStudents',
        'maleStudents',
        'femaleStudents',
        'recentStudents',
        'courseData'
    ));
}
   
    public function edit($id)
{
    $student = Student::findOrFail($id);

    return view('students.edit', compact('student'));
}

    /**
     * Show the form for editing the specified resource.
     */
public function update(Request $request, $id)
{        if(Auth::user()->role != 'admin'){
        abort(403);
    }
    $request->validate([
        'fullname' => 'required|min:3',
        'course' => 'required',
        'gender' => 'required'
    ]);

    $student = Student::findOrFail($id);

    $student->update([
        'fullname' => $request->fullname,
        'course' => $request->course,
        'gender' => $request->gender
    ]);

    return redirect('/students');
}
     public function show($id)
{
    $student = Student::findOrFail($id);
    
    return view('students.show', compact('student'));
}
    /**
     * Remove the specified resource from storage.
     */
  public function destroy($id)
{       
    
}
public function up(): void
{
    Schema::table('students', function (Blueprint $table) {
        $table->string('photo')->nullable();
    });
}
}
