<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $table = 'attendances';

    protected $fillable = [
        'student_id',
        'date',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /** All valid attendance statuses. */
    public const STATUSES = ['present', 'absent', 'late', 'excused'];

    /**
     * Statuses that count as "attended" when computing attendance percentage.
     * Late still counts as attended; excused is authorised and excluded from
     * the denominator entirely (see Student::attendancePercentage()).
     */
    public const ATTENDED = ['present', 'late'];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /** Scope: only records within the given Y-m month string (e.g. "2026-07"). */
    public function scopeForMonth(Builder $query, string $month): Builder
    {
        [$year, $m] = array_pad(explode('-', $month), 2, null);

        return $query->whereYear('date', $year)->whereMonth('date', $m);
    }

    /** Scope: filter by a specific status when provided. */
    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        return $status ? $query->where('status', $status) : $query;
    }

    /** Human label for the status. */
    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }

    /** Tailwind badge classes for the status. */
    public function getStatusBadgeAttribute(): string
    {
        return self::badgeFor($this->status);
    }

    /** Shared badge class map so views stay consistent. */
    public static function badgeFor(string $status): string
    {
        return match ($status) {
            'present' => 'bg-green-100 text-green-800',
            'absent'  => 'bg-red-100 text-red-800',
            'late'    => 'bg-yellow-100 text-yellow-800',
            'excused' => 'bg-blue-100 text-blue-800',
            default   => 'bg-gray-100 text-gray-800',
        };
    }
}
