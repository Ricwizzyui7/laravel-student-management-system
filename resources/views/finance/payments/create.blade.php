<x-app-layout>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <a href="/finance" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Dashboard
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">Record Payment</h2>

            <form method="POST" action="/finance/payments">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Fee Assignment</label>
                    <select name="student_fee_id" required
                            class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select a fee assignment...</option>
                        @foreach($fees as $fee)
                            <option value="{{ $fee->id }}" @selected(isset($fee) && $fee->id == $fee->id)>
                                {{ $fee->student?->fullname }} - {{ $fee->feeCategory?->name }} (${{ number_format($fee->amount, 2) }}, Due: {{ $fee->due_date?->format('M d, Y') ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('student_fee_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Amount ($)</label>
                    <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="0.01" required
                           class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="0.00">
                    @error('amount') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Payment Date</label>
                        <input type="date" name="payment_date" value="{{ old('payment_date', now()->format('Y-m-d')) }}" required
                               class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                        @error('payment_date') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Payment Method</label>
                        <select name="payment_method" required
                                class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                            <option value="cash" @selected(old('payment_method') === 'cash')>Cash</option>
                            <option value="bank_transfer" @selected(old('payment_method') === 'bank_transfer')>Bank Transfer</option>
                            <option value="cheque" @selected(old('payment_method') === 'cheque')>Cheque</option>
                            <option value="mobile_money" @selected(old('payment_method') === 'mobile_money')>Mobile Money</option>
                        </select>
                        @error('payment_method') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Reference Number (optional)</label>
                    <input type="text" name="reference_number" value="{{ old('reference_number') }}"
                           class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Receipt/transaction number">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Notes (optional)</label>
                    <textarea name="notes" rows="2"
                              class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-4 py-2.5 shadow-sm transition">Record Payment</button>
            </form>
        </div>

    </div>
</x-app-layout>
