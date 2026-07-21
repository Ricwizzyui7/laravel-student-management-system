<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $table = 'students';
    protected $fillable = [
        'user_id',
        'fullname',
        'course',
        'course_id',
        'gender',
        'email',
        'phone',
        'age',
        'date_of_birth',
        'photo'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class)->latest('date');
    }

    /** The course this student is enrolled in (optional link). */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /** The user login this student is linked to (optional). */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Department resolved from the linked course.
     * ($student->course is the denormalised name string, so read the relation.)
     */
    public function getDepartmentNameAttribute(): ?string
    {
        return $this->getRelationValue('course')->department ?? null;
    }

    /**
     * Age calculated from date_of_birth when available,
     * otherwise falls back to the manually stored age.
     */
    public function getCalculatedAgeAttribute(): ?int
    {
        if ($this->date_of_birth) {
            return Carbon::parse($this->date_of_birth)->age;
        }

        return $this->age;
    }

    /**
     * Deterministic student number for ID cards, e.g. "STU-2026-0007".
     * Derived from the enrolment year and record id (no extra column needed).
     */
    public function getStudentNumberAttribute(): string
    {
        $year = $this->created_at ? $this->created_at->format('Y') : date('Y');

        return 'STU-' . $year . '-' . str_pad((string) $this->id, 4, '0', STR_PAD_LEFT);
    }

    /**
     * ID card expiry date: four years after enrolment (end of that month).
     */
    public function getIdCardExpiryAttribute(): Carbon
    {
        $base = $this->created_at ? $this->created_at->copy() : Carbon::now();

        return $base->addYears(4)->endOfMonth();
    }

    /**
     * Attendance percentage: (present + late) / (total excluding excused).
     * Excused days are authorised absences and don't count against the rate.
     * Returns 0 when there are no countable records.
     *
     * @param  \Illuminate\Support\Collection|null  $records  Optional pre-loaded set.
     */
    public function attendancePercentage($records = null): int
    {
        $records = $records ?? $this->attendances;

        $countable = $records->whereNotIn('status', ['excused']);
        $total = $countable->count();

        if ($total === 0) {
            return 0;
        }

        $attended = $countable->whereIn('status', Attendance::ATTENDED)->count();

        return (int) round($attended / $total * 100);
    }

    /**
     * Check if attendance is below the threshold and send a warning email to the student
     * if linked to a user account, or to their direct email. Silently fails (logs only).
     *
     * @param  int  $threshold  Minimum allowed percentage (default 75)
     */
    public function checkAttendanceAndNotify(int $threshold = 75): void
    {
        $percentage = $this->attendancePercentage();

        if ($percentage < $threshold && !empty($this->email)) {
            try {
                \Mail::to($this->email)->queue(new \App\Mail\AttendanceWarningMail(
                    $this,
                    $percentage,
                    $threshold,
                ));
            } catch (\Throwable $e) {
                report($e);
            }
        }
    }
}