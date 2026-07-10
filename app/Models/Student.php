<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $table = 'students';
    protected $fillable = [
        'fullname',
        'course',
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
}