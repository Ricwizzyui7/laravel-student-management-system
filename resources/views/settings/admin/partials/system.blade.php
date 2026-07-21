<div class="max-w-md">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">System Name</h2>
    <form method="POST" action="{{ route('settings.admin.system-name') }}" class="space-y-4">
        @csrf
        <div>
            <label for="system_name" class="block text-sm font-medium text-gray-700 mb-1">
                System Name
            </label>
            <input id="system_name" name="system_name" type="text" value="{{ $settings['system_name'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <p class="text-xs text-gray-500 mt-1">The name displayed in browser tabs and headers.</p>
            @error('system_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
            Save
        </button>
    </form>
</div>
