<div class="max-w-2xl">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Notification Preferences</h2>
    <form method="POST" action="{{ route('settings.user.notifications') }}" class="space-y-4">
        @csrf
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Choose which notifications you'd like to receive.</p>

        {{-- Email Notifications --}}
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4 mb-6">
            <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">Email Notifications</h3>
            <div class="space-y-3">
                @foreach([
                    'email_student_registered' => 'New Student Registration',
                    'email_profile_updated' => 'Profile Updates',
                    'email_attendance_warning' => 'Attendance Warnings',
                    'email_password_reset' => 'Password Reset Requests',
                ] as $field => $label)
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="hidden" name="{{ $field }}" value="0">
                        <input type="checkbox" name="{{ $field }}" value="1" {{ $preferences->$field ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500 cursor-pointer">
                        <span class="text-gray-700 dark:text-gray-300">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- In-App Notifications --}}
        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4">
            <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-4">In-App Notifications</h3>
            <div class="space-y-3">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="in_app_notifications" value="0">
                    <input type="checkbox" name="in_app_notifications" value="1" {{ $preferences->in_app_notifications ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500 cursor-pointer">
                    <span class="text-gray-700 dark:text-gray-300">Enable in-app notifications</span>
                </label>
            </div>
        </div>

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition mt-6">
            Save Preferences
        </button>
    </form>
</div>
