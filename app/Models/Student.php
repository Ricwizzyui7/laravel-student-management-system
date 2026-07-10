<?php

namespace App\Models;

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
        'photo'
    ];

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class)->latest('date');
    }
}