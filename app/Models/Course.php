<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'code',
        'name',
        'department',
        'duration',
        'description',
    ];

    /**
     * Students enrolled in this course (linked by course_id).
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
