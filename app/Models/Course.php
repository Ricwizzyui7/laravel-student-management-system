<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'code',
        'name',
        'department',
        'department_id',
        'duration',
        'description',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function courseFees(): HasMany
    {
        return $this->hasMany(CourseFee::class);
    }

    public function getDepartmentNameAttribute(): ?string
    {
        return $this->department?->name ?? $this->getRawOriginal('department');
    }
}
