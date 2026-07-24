<div class="max-w-md space-y-6">
    {{-- Theme --}}
    <div>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Theme</h2>
        <form method="POST" action="{{ route('settings.user.theme') }}" class="space-y-3">
            @csrf
            <div class="space-y-2">
                @foreach(['system' => 'System (Auto)', 'light' => 'Light', 'dark' => 'Dark'] as $value => $label)
                    <label class="flex items-center gap-3 cursor-pointer p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 transition" :class="{'border-blue-500 bg-blue-50' : '{{ $user->theme }}' === '{{ $value }}'}">
                        <input type="radio" name="theme" value="{{ $value }}" {{ $user->theme === $value ? 'checked' : '' }} class="cursor-pointer">
                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                Save Theme
            </button>
        </form>
    </div>

    {{-- Language --}}
    <div class="border-t pt-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Language</h2>
        <form method="POST" action="{{ route('settings.user.language') }}" class="space-y-3">
            @csrf
            <select name="language" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="en" {{ $user->language === 'en' ? 'selected' : '' }}>English</option>
                <option value="es" {{ $user->language === 'es' ? 'selected' : '' }}>Español (Spanish)</option>
                <option value="fr" {{ $user->language === 'fr' ? 'selected' : '' }}>Français (French)</option>
                <option value="de" {{ $user->language === 'de' ? 'selected' : '' }}>Deutsch (German)</option>
            </select>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                Save Language
            </button>
        </form>
    </div>
</div>
