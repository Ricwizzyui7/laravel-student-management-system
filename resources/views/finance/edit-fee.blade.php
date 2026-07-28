<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <a href="/finance/student/{{ $studentFee->student_id }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Student Fees
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">Edit Fee Record</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">{{ $studentFee->student?->fullname }} &mdash; Current: ${{ number_format($studentFee->amount, 2) }}</p>

            <form method="POST" action="/finance/fees/{{ $studentFee->id }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Fee Category</label>
                    <select name="fee_category_id" required
                            class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('fee_category_id', $studentFee->fee_category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Amount ($)</label>
                    <input type="number" name="amount" value="{{ old('amount', $studentFee->amount) }}" step="0.01" min="0" required
                           class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Due Date</label>
                        <input type="date" name="due_date" value="{{ old('due_date', $studentFee->due_date?->format('Y-m-d')) }}"
                               class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" required
                                class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                            <option value="unpaid" @selected(old('status', $studentFee->status) === 'unpaid')>Unpaid</option>
                            <option value="partial" @selected(old('status', $studentFee->status) === 'partial')>Partial</option>
                            <option value="paid" @selected(old('status', $studentFee->status) === 'paid')>Paid</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Academic Year</label>
                        <input type="text" name="academic_year" value="{{ old('academic_year', $studentFee->academic_year) }}"
                               class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Term</label>
                        <input type="text" name="term" value="{{ old('term', $studentFee->term) }}"
                               class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea name="description" rows="2"
                              class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">{{ old('description', $studentFee->description) }}</textarea>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-6 py-2.5 shadow-sm transition">Update Fee</button>
                    <a href="/finance/student/{{ $studentFee->student_id }}" class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition">Cancel</a>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
