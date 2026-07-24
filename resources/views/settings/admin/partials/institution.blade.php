<div class="space-y-6">
    {{-- Name --}}
    <div class="max-w-md">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Institution Name</h2>
        <form method="POST" action="{{ route('settings.admin.institution') }}" class="space-y-4">
            @csrf
            <div>
                <label for="institution_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Name
                </label>
                <input id="institution_name" name="institution_name" type="text" value="{{ $settings['institution_name'] }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('institution_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
                Save
            </button>
        </form>
    </div>

    {{-- Logo --}}
    <div class="border-t pt-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Institution Logo</h2>
        <form method="POST" action="{{ route('settings.admin.logo') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="flex items-center gap-6">
                <div class="h-20 w-32 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900 flex items-center justify-center shrink-0">
                    @if($settings['institution_logo'])
                        <img src="{{ Storage::url($settings['institution_logo']) }}" alt="Logo" class="h-full w-full object-contain p-2">
                    @else
                        <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    @endif
                </div>
                <div>
                    <label for="institution_logo" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Choose Logo
                    </label>
                    <input id="institution_logo" name="institution_logo" type="file" accept="image/*" class="block w-full text-sm text-gray-500 dark:text-gray-400
                        file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Max 2 MB. PNG recommended for transparency.</p>
                    @error('institution_logo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                Update Logo
            </button>
        </form>
    </div>
</div>
