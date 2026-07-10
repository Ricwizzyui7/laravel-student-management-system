<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Record (or update) a student's attendance for a given day.
     */
    public function store(Request $request, $studentId)
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'status' => 'required|in:present,absent,late',
        ]);

        $student = Student::findOrFail($studentId);

        // One record per student per day: overwrite if it already exists.
        $student->attendances()->updateOrCreate(
            ['date' => $validated['date']],
            ['status' => $validated['status']]
        );

        return redirect()
            ->route('students.show', $student->id)
            ->with('success', 'Attendance recorded successfully.');
    }

    /**
     * Remove an attendance record.
     */
    public function destroy($studentId, $attendanceId)
    {
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $student = Student::findOrFail($studentId);

        $attendance = $student->attendances()->findOrFail($attendanceId);
        $attendance->delete();

        return redirect()
            ->route('students.show', $student->id)
            ->with('success', 'Attendance record removed.');
    }
}
