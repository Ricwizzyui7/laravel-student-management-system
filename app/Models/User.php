<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The student record linked to this user login (optional).
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }

    /**
     * User's notification preferences.
     */
    public function preferences()
    {
        return $this->hasOne(UserPreference::class);
    }

    /** Convenience: is this user an administrator? */
    public function isAdmin(): bool
    {
        return strtolower((string) $this->role) === 'admin';
    }

    /** Query scope: administrators only. */
    public function scopeAdmins($query)
    {
        return $query->whereRaw('LOWER(role) = ?', ['admin']);
    }

    /**
     * Send a system notification to every administrator.
     * Safe to call from anywhere; failures are swallowed so a notification
     * problem never blocks the primary action (creating a student, etc.).
     */
    public static function notifyAdmins(\Illuminate\Notifications\Notification $notification): void
    {
        try {
            static::admins()->get()->each->notify($notification);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'theme',
        'language',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Override the default password reset notification to use our custom PasswordResetMail.
     */
    public function sendPasswordResetNotification($token): void
    {
        $url = route('password.reset', ['token' => $token, 'email' => $this->email]);

        \Mail::to($this->email)->queue(new \App\Mail\PasswordResetMail(
            $this->name,
            $url,
            60, // expires in 60 minutes
        ));
    }
}
