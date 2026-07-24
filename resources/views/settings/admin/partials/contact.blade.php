<div class="max-w-md">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Contact Information</h2>
    <form method="POST" action="{{ route('settings.admin.contact') }}" class="space-y-4">
        @csrf
        <div>
            <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Email
            </label>
            <input id="contact_email" name="contact_email" type="email" value="{{ $settings['contact_email'] }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('contact_email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Phone
            </label>
            <input id="contact_phone" name="contact_phone" type="tel" value="{{ $settings['contact_phone'] }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @error('contact_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="contact_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Address
            </label>
            <textarea id="contact_address" name="contact_address" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ $settings['contact_address'] }}</textarea>
            @error('contact_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
            Save
        </button>
    </form>
</div>
