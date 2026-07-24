<div class="space-y-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Profile Picture</h2>
        <form method="POST" action="{{ route('settings.user.profile-picture') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="flex items-center gap-6">
                <div class="h-24 w-24 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center shrink-0">
                    @if($user->photo)
                        <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}" class="h-full w-full object-cover">
                    @else
                        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    @endif
                </div>
                <div>
                    <label for="photo" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Choose Photo
                    </label>
                    <input id="photo" name="photo" type="file" accept="image/*" class="block w-full text-sm text-gray-500 dark:text-gray-400
                        file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Max 5 MB. JPG, PNG, GIF</p>
                    @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                Update Picture
            </button>
        </form>
    </div>

    {{-- Name & Email --}}
    <div class="border-t pt-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Account Information</h2>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                <input type="text" value="{{ $user->name }}" disabled class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-900/50 text-gray-500 dark:text-gray-400">
            </div>
            <form method="POST" action="{{ route('settings.user.email') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address</label>
                    <input id="email" name="email" type="email" value="{{ $user->email }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                    Update Email
                </button>
            </form>
        </div>
    </div>
</div>
