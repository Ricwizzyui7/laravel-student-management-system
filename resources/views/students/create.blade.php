<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-6">
            <a href="/students" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Directory
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-6 sm:p-8 border-b border-gray-50 bg-gray-50/50">
                <h2 class="text-xl font-bold text-gray-900">Add New Student Record</h2>
                <p class="text-sm text-gray-500 mt-1">Fill out the administrative profile below to register a new student path into the system.</p>
            </div>

            <form action="/students" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6 m-0">
                @csrf

                @if ($errors->any())
                    <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                        <div class="flex items-center gap-2 text-red-800 font-semibold text-sm mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            Please correct the errors listed below:
                        </div>
                        <ul class="list-disc pl-5 space-y-1 text-xs text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                    
                    <div class="flex flex-col items-center text-center p-4 bg-gray-50/60 rounded-xl border border-dashed border-gray-200">
                        <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Avatar Preview</span>
                        <div class="relative h-28 w-28 rounded-full bg-white shadow-inner border border-gray-100 overflow-hidden flex items-center justify-center">
                            <svg id="defaultAvatarIcon" class="w-14 h-14 text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <img id="profileImagePreview" src="#" alt="preview" class="hidden h-full w-full object-cover">
                        </div>
                        <p class="text-[11px] text-gray-400 mt-2">Select a file below to populate this frame preview dynamically.</p>
                    </div>

                    <div class="md:col-span-2 space-y-5">
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Full Name</label>
                            <input type="text"
                                   name="fullname"
                                   value="{{ old('fullname') }}"
                                   class="w-full bg-white border @error('fullname') border-red-300 focus:ring-red-500 focus:border-red-500 @else border-gray-200 focus:ring-blue-500 focus:border-blue-500 @enderror text-gray-900 text-sm rounded-xl px-4 py-2.5 transition"
                                   placeholder="e.g. John Doe">
                            @error('fullname')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Course / Department</label>
                            <input type="text"
                                   name="course"
                                   value="{{ old('course') }}"
                                   class="w-full bg-white border @error('course') border-red-300 focus:ring-red-500 focus:border-red-500 @else border-gray-200 focus:ring-blue-500 focus:border-blue-500 @enderror text-gray-900 text-sm rounded-xl px-4 py-2.5 transition"
                                   placeholder="e.g. Cyber Security">
                            @error('course')
                                <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Gender Designation</label>
                            <select name="gender"
                                    class="w-full bg-white border border-gray-200 text-gray-900 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500 transition appearance-none cursor-pointer">
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Email <span class="text-gray-400 font-medium normal-case">(optional)</span></label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   class="w-full bg-white border @error('email') border-red-300 focus:ring-red-500 focus:border-red-500 @else border-gray-200 focus:ring-blue-500 focus:border-blue-500 @enderror text-gray-900 text-sm rounded-xl px-4 py-2.5 transition"
                                   placeholder="e.g. student@example.com">
                            @error('email') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Phone <span class="text-gray-400 font-medium normal-case">(optional)</span></label>
                                <input type="text"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       class="w-full bg-white border border-gray-200 focus:ring-blue-500 focus:border-blue-500 text-gray-900 text-sm rounded-xl px-4 py-2.5 transition"
                                       placeholder="e.g. +255 7XX XXX XXX">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Date of Birth <span class="text-gray-400 font-medium normal-case">(optional)</span></label>
                                <input type="date"
                                       name="date_of_birth"
                                       value="{{ old('date_of_birth') }}"
                                       max="{{ now()->format('Y-m-d') }}"
                                       class="w-full bg-white border @error('date_of_birth') border-red-300 @else border-gray-200 @enderror focus:ring-blue-500 focus:border-blue-500 text-gray-900 text-sm rounded-xl px-4 py-2.5 transition">
                                @error('date_of_birth') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <hr class="border-gray-100 my-2">

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Upload Student Photo</label>
                    <input type="file"
                           name="photo"
                           id="photoUploadInputElement"
                           onchange="runLiveAvatarPreviewFrame(event)"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 file:cursor-pointer border border-gray-200 p-1.5 rounded-xl transition bg-gray-50/30">
                    @error('photo')
                        <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50">
                    <a href="/students" class="inline-flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm rounded-xl px-5 py-2.5 transition">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl px-6 py-2.5 shadow-sm transition">
                        Save Student Record
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function runLiveAvatarPreviewFrame(event) {
            const inputField = event.target;
            
            if (inputField.files && inputField.files[0]) {
                const readerEngine = new FileReader();
                
                readerEngine.onload = function(e) {
                    const previewImage = document.getElementById('profileImagePreview');
                    const placeholderIcon = document.getElementById('defaultAvatarIcon');
                    
                    // Assign source data, swap visibilities
                    previewImage.src = e.target.result;
                    previewImage.classList.remove('hidden');
                    placeholderIcon.classList.add('hidden');
                };
                
                readerEngine.readAsDataURL(inputField.files[0]);
            }
        }
    </script>
</x-app-layout>