<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPreference extends Model
{
    protected $fillable = [
        'user_id',
        'email_student_registered',
        'email_profile_updated',
        'email_attendance_warning',
        'email_password_reset',
        'in_app_notifications',
    ];

    protected $casts = [
        'email_student_registered' => 'bool',
        'email_profile_updated' => 'bool',
        'email_attendance_warning' => 'bool',
        'email_password_reset' => 'bool',
        'in_app_notifications' => 'bool',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
