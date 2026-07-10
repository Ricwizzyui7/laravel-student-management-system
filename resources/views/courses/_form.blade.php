@if ($errors->any())
    <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
        <div class="flex items-center gap-2 text-red-800 font-semibold text-sm mb-1">
            <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            Please correct the errors below:
        </div>
        <ul class="list-disc pl-5 space-y-1 text-xs text-red-700">
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Course Code</label>
        <input type="text" name="code" value="{{ old('code', $course->code ?? '') }}"
               class="w-full bg-white border @error('code') border-red-300 @else border-gray-200 @enderror focus:ring-blue-500 focus:border-blue-500 text-gray-900 text-sm rounded-xl px-4 py-2.5 transition uppercase"
               placeholder="e.g. CS101">
        @error('code') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
    </div>
    <div class="sm:col-span-2">
        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Course Name</label>
        <input type="text" name="name" value="{{ old('name', $course->name ?? '') }}"
               class="w-full bg-white border @error('name') border-red-300 @else border-gray-200 @enderror focus:ring-blue-500 focus:border-blue-500 text-gray-900 text-sm rounded-xl px-4 py-2.5 transition"
               placeholder="e.g. Cyber Security">
        @error('name') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Department <span class="text-gray-400 font-medium normal-case">(optional)</span></label>
        <input type="text" name="department" value="{{ old('department', $course->department ?? '') }}"
               class="w-full bg-white border border-gray-200 focus:ring-blue-500 focus:border-blue-500 text-gray-900 text-sm rounded-xl px-4 py-2.5 transition"
               placeholder="e.g. Computing & IT">
        @error('department') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Duration <span class="text-gray-400 font-medium normal-case">(optional)</span></label>
        <input type="text" name="duration" value="{{ old('duration', $course->duration ?? '') }}"
               class="w-full bg-white border border-gray-200 focus:ring-blue-500 focus:border-blue-500 text-gray-900 text-sm rounded-xl px-4 py-2.5 transition"
               placeholder="e.g. 3 Years">
        @error('duration') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
    </div>
</div>

<div>
    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Description <span class="text-gray-400 font-medium normal-case">(optional)</span></label>
    <textarea name="description" rows="4"
              class="w-full bg-white border border-gray-200 focus:ring-blue-500 focus:border-blue-500 text-gray-900 text-sm rounded-xl px-4 py-2.5 transition"
              placeholder="Brief overview of the course...">{{ old('description', $course->description ?? '') }}</textarea>
    @error('description') <p class="text-xs text-red-600 mt-1 font-medium">{{ $message }}</p> @enderror
</div>
