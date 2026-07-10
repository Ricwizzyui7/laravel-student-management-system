<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:30',
            'date_of_birth' => 'nullable|date|before:today',
            'photo' => 'nullable|image|max:2048'
        ]);

        try {
            $photoPath = null;

            if ($request->hasFile('photo')) {
                $cloudinary = app(\Cloudinary\Cloudinary::class);

                $result = $cloudinary->uploadApi()->upload(
                    $request->file('photo')->getRealPath(),
                    ['folder' => 'students']
                );

                $photoPath = $result['secure_url'];
            }

            Student::create([
                'fullname' => $request->fullname,
                'course' => $request->course,
                'gender' => $request->gender,
                'email' => $request->email,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
                'photo' => $photoPath
            ]);

            return redirect('/students')->with('success', 'Student record created successfully.');

        } catch (\Exception $e) {
            report($e);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Could not save the student record. Please try again.');
        }
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
            'gender' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:30',
            'date_of_birth' => 'nullable|date|before:today',
            'photo' => 'nullable|image|max:2048'
        ]);

        $student = Student::findOrFail($id);

        try {
            $data = [
                'fullname' => $request->fullname,
                'course' => $request->course,
                'gender' => $request->gender,
                'email' => $request->email,
                'phone' => $request->phone,
                'date_of_birth' => $request->date_of_birth,
            ];

            if ($request->hasFile('photo')) {
                $cloudinary = app(\Cloudinary\Cloudinary::class);

                $result = $cloudinary->uploadApi()->upload(
                    $request->file('photo')->getRealPath(),
                    ['folder' => 'students']
                );

                $data['photo'] = $result['secure_url'];
            }

            $student->update($data);

            return redirect('/students')->with('success', 'Student record updated successfully.');

        } catch (\Exception $e) {
            report($e);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Could not update the student record. Please try again.');
        }
    }

    /**
     * Display a specific student profile.
     */
    public function show($id)
    {
        $student = Student::with('attendances')->findOrFail($id);

        $summary = [
            'present' => $student->attendances->where('status', 'present')->count(),
            'absent'  => $student->attendances->where('status', 'absent')->count(),
            'late'    => $student->attendances->where('status', 'late')->count(),
        ];

        $recentAttendances = $student->attendances->take(10);

        // Attendance rate across all recorded days.
        $totalRecords = $student->attendances->count();
        $attendanceRate = $totalRecords > 0
            ? round(($summary['present'] + $summary['late']) / $totalRecords * 100)
            : 0;

        // Profile completion — how many key fields are filled in.
        $profileFields = [
            'fullname'      => $student->fullname,
            'course'        => $student->course,
            'gender'        => $student->gender,
            'email'         => $student->email,
            'phone'         => $student->phone,
            'date_of_birth' => $student->date_of_birth,
            'photo'         => $student->photo,
        ];
        $filled = collect($profileFields)->filter(fn ($value) => !empty($value))->count();
        $profileCompletion = (int) round($filled / count($profileFields) * 100);

        // Recent activity feed built from real timestamps (no fabricated data).
        $activities = collect();

        if ($student->created_at) {
            $activities->push([
                'icon'  => 'user-plus',
                'color' => 'blue',
                'title' => 'Student record created',
                'time'  => $student->created_at,
            ]);
        }

        if ($student->updated_at && $student->created_at && $student->updated_at->gt($student->created_at)) {
            $activities->push([
                'icon'  => 'pencil',
                'color' => 'amber',
                'title' => 'Profile information updated',
                'time'  => $student->updated_at,
            ]);
        }

        foreach ($student->attendances->take(3) as $record) {
            $activities->push([
                'icon'  => 'calendar-check',
                'color' => $record->status === 'present' ? 'emerald' : ($record->status === 'late' ? 'amber' : 'red'),
                'title' => 'Marked '.$record->status.' on '.$record->date->format('M d, Y'),
                'time'  => $record->created_at ?? $record->date,
            ]);
        }

        $activities = $activities->sortByDesc('time')->take(5)->values();

        return view('students.show', compact(
            'student',
            'summary',
            'recentAttendances',
            'attendanceRate',
            'profileCompletion',
            'activities'
        ));
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

        return redirect('/students')->with('success', 'Student record deleted successfully.');
    }
}