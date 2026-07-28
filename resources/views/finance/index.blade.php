<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">Finance Dashboard</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Overview of fees, payments, and outstanding balances.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="/finance/assign" class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium text-sm rounded-xl px-4 py-2.5 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Assign Fee
                    </a>
                    <a href="/finance/payments/create" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-4 py-2.5 shadow-sm transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Record Payment
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-5">
                <div class="flex items-center justify-between mb-2">
                    <div class="h-10 w-10 rounded-xl bg-emerald-50 dark:bg-emerald-950 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">TSh {{ number_format($totalCollected, 2) }}</div>
                <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-0.5">Total Collected</div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-5">
                <div class="flex items-center justify-between mb-2">
                    <div class="h-10 w-10 rounded-xl bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">TSh {{ number_format($totalFees, 2) }}</div>
                <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-0.5">Total Fees</div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-5">
                <div class="flex items-center justify-between mb-2">
                    <div class="h-10 w-10 rounded-xl bg-amber-50 dark:bg-amber-950 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">TSh {{ number_format($outstandingBalance, 2) }}</div>
                <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-0.5">Outstanding Balance</div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-5">
                <div class="flex items-center justify-between mb-2">
                    <div class="h-10 w-10 rounded-xl bg-purple-50 dark:bg-purple-950 text-purple-600 dark:text-purple-400 flex items-center justify-center">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">{{ $totalStudentsWithFees }}</div>
                <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-0.5">Students with Fees</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-4">Recent Payments</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider border-b border-gray-100 dark:border-gray-700">
                                    <th class="py-3 pr-4">Student</th>
                                    <th class="py-3 pr-4">Category</th>
                                    <th class="py-3 pr-4">Amount</th>
                                    <th class="py-3 pr-4">Date</th>
                                    <th class="py-3">Method</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50 text-sm">
                                @forelse($recentPayments as $payment)
                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                        <td class="py-3 pr-4 font-medium text-gray-900 dark:text-gray-100">{{ $payment->student?->fullname ?? 'N/A' }}</td>
                                        <td class="py-3 pr-4 text-gray-600 dark:text-gray-400">{{ $payment->studentFee?->feeCategory?->name ?? 'N/A' }}</td>
                                        <td class="py-3 pr-4 font-semibold text-emerald-600 dark:text-emerald-400">TSh {{ number_format($payment->amount, 2) }}</td>
                                        <td class="py-3 pr-4 text-gray-500 dark:text-gray-400">{{ $payment->payment_date->format('M d, Y') }}</td>
                                        <td class="py-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 capitalize">
                                                {{ str_replace('_', ' ', $payment->payment_method) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-sm text-gray-400 dark:text-gray-500">No payments recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($recentPayments->count() > 0)
                        <div class="mt-4 text-right">
                            <a href="/finance/payments/create" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">Record Payment &rarr;</a>
                        </div>
                    @endif
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-4">Fee Categories Breakdown</h3>
                    <div class="space-y-3">
                        @forelse($categoryBreakdown as $category)
                            <div class="flex items-center justify-between py-2 border-b border-gray-50 dark:border-gray-700/50 last:border-0">
                                <div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $category->name }}</span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 ml-2">({{ $category->student_fees_count ?? 0 }} assignments)</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">TSh {{ number_format($category->student_fees_sum_amount ?? 0, 2) }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 dark:text-gray-500 text-center py-4">No fee categories defined yet.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            <div class="space-y-6">

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="/finance/assign" class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-900/50 hover:bg-blue-50 dark:hover:bg-blue-950/50 transition group">
                            <div class="h-9 w-9 rounded-lg bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:scale-110 transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Assign Fee to Student</div>
                                <div class="text-xs text-gray-400 dark:text-gray-500">Add tuition, hostel, or other fees</div>
                            </div>
                        </a>
                        <a href="/finance/payments/create" class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-900/50 hover:bg-emerald-50 dark:hover:bg-emerald-950/50 transition group">
                            <div class="h-9 w-9 rounded-lg bg-emerald-100 dark:bg-emerald-900 text-emerald-600 dark:text-emerald-400 flex items-center justify-center group-hover:scale-110 transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Record a Payment</div>
                                <div class="text-xs text-gray-400 dark:text-gray-500">Log payment from a student</div>
                            </div>
                        </a>
                        <a href="/finance/categories" class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-900/50 hover:bg-indigo-50 dark:hover:bg-indigo-950/50 transition group">
                            <div class="h-9 w-9 rounded-lg bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 flex items-center justify-center group-hover:scale-110 transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5a2 2 0 011.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A2 2 0 013 9V4a1 1 0 011-1z"/></svg>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Manage Categories</div>
                                <div class="text-xs text-gray-400 dark:text-gray-500">Configure fee types (admin)</div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                    <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-4">Fee Categories</h3>
                    <div class="space-y-2">
                        @forelse($feeCategories as $category)
                            <div class="flex items-center gap-2 text-sm">
                                <span class="h-2 w-2 rounded-full bg-blue-500 shrink-0"></span>
                                <span class="text-gray-600 dark:text-gray-400">{{ $category->name }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 dark:text-gray-500">No categories defined.</p>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>
