<div class="max-w-md">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Academic Year</h2>
    <form method="POST" action="{{ route('settings.admin.academic-year') }}" class="space-y-4">
        @csrf
        <div>
            <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-1">
                Academic Year
            </label>
            <input id="academic_year" name="academic_year" type="text" placeholder="2024-2025" value="{{ $settings['academic_year'] }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <p class="text-xs text-gray-500 mt-1">Format: YYYY-YYYY (e.g., 2024-2025)</p>
            @error('academic_year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
            Save
        </button>
    </form>
</div>
