<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-blue-600 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Courses
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 sm:p-8 border-b border-gray-50 bg-gray-50/50">
                <h2 class="text-xl font-bold text-gray-900">Edit Course</h2>
                <p class="text-sm text-gray-500 mt-1">Update the details for <span class="font-semibold text-gray-700">{{ $course->name }}</span>.</p>
            </div>

            <form action="{{ route('courses.update', $course->id) }}" method="POST" class="p-6 sm:p-8 space-y-6 m-0">
                @csrf
                @method('PUT')
                @include('courses._form', ['course' => $course])

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50">
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm rounded-xl px-5 py-2.5 transition">Cancel</a>
                    <button type="submit" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl px-6 py-2.5 shadow-sm transition">Update Course</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
