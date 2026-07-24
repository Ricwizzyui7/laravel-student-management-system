<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-10 text-center">
            <div class="mx-auto h-14 w-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100">No Student Record Linked</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 max-w-md mx-auto">
                Your account isn't linked to a student profile yet, so there's no attendance to display.
                Please ask an administrator to link your account to your student record.
            </p>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 mt-6 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl px-5 py-2.5 transition">
                Return to Dashboard
            </a>
        </div>
    </div>
</x-app-layout>
