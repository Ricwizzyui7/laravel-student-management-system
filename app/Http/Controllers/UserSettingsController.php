<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserSettingsController extends Controller
{
    /**
     * Show user settings dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $preferences = $user->preferences()->firstOrCreate(['user_id' => $user->id]);

        return view('settings.user.index', [
            'user' => $user,
            'preferences' => $preferences,
        ]);
    }

    /**
     * Update profile picture.
     */
    public function updateProfilePicture(Request $request)
    {
        $validated = $request->validate([
            'photo' => ['required', 'image', 'max:5120'],
        ]);

        $user = $request->user();

        // Delete old photo if exists
        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        // Store new photo
        $path = $request->file('photo')->store('users', 'public');
        $user->update(['photo' => $path]);

        return redirect()->back()->with('success', 'Profile picture updated successfully.');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    /**
     * Update email.
     */
    public function updateEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:users,email,' . $request->user()->id],
        ]);

        $request->user()->update($validated);

        return redirect()->back()->with('success', 'Email updated successfully.');
    }

    /**
     * Update theme preference.
     */
    public function updateTheme(Request $request)
    {
        $validated = $request->validate([
            'theme' => ['required', 'in:system,light,dark'],
        ]);

        $request->user()->update($validated);

        return redirect()->back()->with('success', 'Theme updated successfully.');
    }

    /**
     * Update language preference.
     */
    public function updateLanguage(Request $request)
    {
        $validated = $request->validate([
            'language' => ['required', 'in:en,es,fr,de'],
        ]);

        $request->user()->update($validated);

        return redirect()->back()->with('success', 'Language updated successfully.');
    }

    /**
     * Update notification preferences.
     */
    public function updateNotificationPreferences(Request $request)
    {
        $validated = $request->validate([
            'email_student_registered' => ['boolean'],
            'email_profile_updated' => ['boolean'],
            'email_attendance_warning' => ['boolean'],
            'email_password_reset' => ['boolean'],
            'in_app_notifications' => ['boolean'],
        ]);

        $preferences = $request->user()->preferences()->firstOrCreate(['user_id' => $request->user()->id]);
        $preferences->update($validated);

        return redirect()->back()->with('success', 'Notification preferences updated successfully.');
    }
}
