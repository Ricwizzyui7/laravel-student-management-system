<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class IdCardController extends Controller
{
    /**
     * Display the printable student ID card.
     *
     * Access: administrators may view any card; a linked student may view
     * only their own (consistent with the attendance profile rules).
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);

        if (Auth::user()->role != 'admin') {
            $own = Student::where('user_id', Auth::id())->first();
            if (!$own || $own->id !== $student->id) {
                abort(403, 'You can only view your own ID card.');
            }
        }

        // Department comes from the linked course (the `course` attribute is the
        // denormalised name string, so resolve the Course model explicitly).
        $course = $student->course_id ? Course::find($student->course_id) : null;
        $department = $course->department ?? '—';

        // Institution identity (falls back to the app name).
        $institution = config('app.institution_name', 'Global Institute of Technology');

        // QR payload: compact verification string scanners can read.
        $qrPayload = implode(' | ', array_filter([
            $student->student_number,
            $student->fullname,
            $student->course,
        ]));

        return view('students.id-card', [
            'student'     => $student,
            'department'  => $department,
            'institution' => $institution,
            'issued'      => $student->created_at,
            'expiry'      => $student->id_card_expiry,
            'qrPayload'   => $qrPayload,
        ]);
    }
}
