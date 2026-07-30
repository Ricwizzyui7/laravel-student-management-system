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

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function courseFees(): HasMany
    {
        return $this->hasMany(CourseFee::class);
    }
}
