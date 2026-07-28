<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <a href="/finance/student/{{ $studentFee->student_id }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Student Fees
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Payment History</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        {{ $studentFee->student?->fullname }} —
                        <span class="font-semibold">{{ $studentFee->feeCategory?->name }}</span> —
                        TSh {{ number_format($studentFee->amount, 2) }}
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-gray-400 uppercase">Status:</span>
                    @php
                        $badge = match($studentFee->status) {
                            'paid' => 'bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300',
                            'partial' => 'bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-300',
                            default => 'bg-red-50 dark:bg-red-950 text-red-700 dark:text-red-300',
                        };
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }} capitalize">{{ $studentFee->status }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/70 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-700 text-gray-600 dark:text-gray-400 text-xs font-semibold uppercase tracking-wider">
                            <th class="py-4 px-6">#</th>
                            <th class="py-4 px-6">Date</th>
                            <th class="py-4 px-6 text-right">Amount</th>
                            <th class="py-4 px-6">Method</th>
                            <th class="py-4 px-6">Reference</th>
                            <th class="py-4 px-6">Recorded By</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700 text-sm">
                        @forelse($studentFee->payments as $payment)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                <td class="py-4 px-6 text-gray-400 dark:text-gray-500 font-medium">#{{ $payment->id }}</td>
                                <td class="py-4 px-6 text-gray-900 dark:text-gray-100">{{ $payment->payment_date->format('M d, Y') }}</td>
                                <td class="py-4 px-6 text-right font-semibold text-emerald-600 dark:text-emerald-400">TSh {{ number_format($payment->amount, 2) }}</td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 capitalize">
                                        {{ str_replace('_', ' ', $payment->payment_method) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-gray-500 dark:text-gray-400">{{ $payment->reference_number ?? '—' }}</td>
                                <td class="py-4 px-6 text-gray-500 dark:text-gray-400">{{ $payment->user?->name ?? '—' }}</td>
                                <td class="py-4 px-6 text-right">
                                    <form action="/finance/payments/{{ $payment->id }}" method="POST" class="inline m-0" onsubmit="return confirm('Delete this payment record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950 h-8 w-8 rounded-lg transition">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="h-12 w-12 rounded-2xl bg-gray-50 dark:bg-gray-900 text-gray-400 dark:text-gray-500 flex items-center justify-center mb-3">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        </div>
                                        <h3 class="text-sm font-semibold text-gray-900 dark:text-gray-100">No Payments Yet</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">No payments have been recorded for this fee.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($studentFee->payments->count() > 0)
            <div class="mt-6 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">Total Paid:</span>
                    <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">TSh {{ number_format($studentFee->paid_amount, 2) }}</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <span class="text-sm font-semibold text-gray-500 dark:text-gray-400">Remaining Balance:</span>
                    <span class="text-lg font-bold text-amber-600 dark:text-amber-400">TSh {{ number_format($studentFee->balance, 2) }}</span>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
