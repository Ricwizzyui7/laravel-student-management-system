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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        if(Auth::user()->role != 'admin'){
            abort(403);
        }

        $request->validate([
            'fullname' => 'required|min:3',
            'course' => 'required',
            'gender' => 'required',
            'photo' => 'nullable|image|max:2048' // Safe validation parameter
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            // Upload the image straight to Cloudinary and fetch its secure URL link
            $uploadedFileUrl = $request->file('photo')->storeOnCloudinary('students');
            $photoPath = $uploadedFileUrl->getSecurePath();
        }

        Student::create([
            'fullname' => $request->fullname,
            'course' => $request->course,
            'gender' => $request->gender,
            'photo' => $photoPath // This now safely saves a permanent https link!
        ]);

        return redirect('/students');
    }

    /**
     * Display executive analytics workspace details.
     */
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
       
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {        
        if(Auth::user()->role != 'admin'){
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

    /**
     * Display a specific student profile.
     */
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
        if(Auth::user()->role != 'admin'){
            abort(403);
        }
        
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect('/students');
    }
}