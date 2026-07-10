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
}