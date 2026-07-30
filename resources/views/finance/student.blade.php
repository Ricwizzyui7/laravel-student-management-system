<x-app-layout>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-6">
            <a href="/students/{{ $student->id }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                {{ __('Back to Directory') }}
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">{{ __('Fee Records') }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $student->fullname }} &mdash; {{ $student->course }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="/finance/assign?student_id={{ $student->id }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-4 py-2.5 shadow-sm transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        {{ __('Add Fee') }}
                    </a>
                    <a href="/finance/payments/create?student_id={{ $student->id }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm rounded-xl px-4 py-2.5 shadow-sm transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        {{ __('Record Payment') }}
                    </a>
                </div>
            </div>
        </div>

        @php
            $totalFees = $student->studentFees->sum('amount');
            $totalPaid = $student->studentFees->sum(fn ($f) => $f->paid_amount);
            $totalBalance = $totalFees - $totalPaid;
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-5">
                <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Total Fees') }}</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">TSh {{ number_format($totalFees, 2) }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-5">
                <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Total Paid') }}</div>
                <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">TSh {{ number_format($totalPaid, 2) }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-5">
                <div class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Balance') }}</div>
                <div class="text-2xl font-bold {{ $totalBalance > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400' }} mt-1">
                    TSh {{ number_format($totalBalance, 2) }}
                </div>
            </div>
        </div>

        @forelse($student->studentFees as $fee)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden mb-4">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-base font-bold text-gray-900 dark:text-gray-100">{{ $fee->feeCategory?->name ?? 'N/A' }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ __('Due') }}: {{ $fee->due_date?->format('M d, Y') ?? __('No due date') }}
                                @if($fee->course) &middot; {{ $fee->course->name }} @endif
                                @if($fee->academic_year) &middot; {{ $fee->academic_year }} @endif
                                @if($fee->term) &middot; {{ $fee->term }} @endif
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            @php
                                $badge = match($fee->status) {
                                    'paid' => 'bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300',
                                    'partial' => 'bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-300',
                                    default => 'bg-red-50 dark:bg-red-950 text-red-700 dark:text-red-300',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }} capitalize">{{ __(ucfirst($fee->status)) }}</span>
                            <a href="/finance/fees/{{ $fee->id }}/edit" class="inline-flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-950 h-8 w-8 rounded-lg transition" title="{{ __('Edit') }}">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="/finance/fees/{{ $fee->id }}" method="POST" class="inline m-0" onsubmit="return confirm('{{ __("Delete this fee record and all associated payments?") }}')">
                                @csrf
                                @method('DELETE')
                                <button class="inline-flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950 h-8 w-8 rounded-lg transition" title="{{ __('Delete') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    @if($fee->description)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $fee->description }}</p>
                    @endif

                    <div class="flex items-center gap-6">
                        <div>
                            <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase">{{ __('Amount') }}</span>
                            <div class="text-lg font-bold text-gray-900 dark:text-gray-100">TSh {{ number_format($fee->amount, 2) }}</div>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase">{{ __('Total Paid') }}</span>
                            <div class="text-lg font-bold text-emerald-600 dark:text-emerald-400">TSh {{ number_format($fee->paid_amount, 2) }}</div>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase">{{ __('Balance') }}</span>
                            <div class="text-lg font-bold {{ $fee->balance > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400' }}">
                                TSh {{ number_format($fee->balance, 2) }}
                            </div>
                        </div>
                    </div>

                    @if($fee->payments->count() > 0)
                        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('Payments') }} ({{ $fee->payments->count() }})</span>
                                <a href="/finance/payments/{{ $fee->id }}/history" class="text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline">{{ __('View All') }}</a>
                            </div>
                            <div class="space-y-1">
                                @foreach($fee->payments->sortByDesc('payment_date')->take(3) as $payment)
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-500 dark:text-gray-400">{{ $payment->payment_date->format('M d, Y') }} &mdash; {{ str_replace('_', ' ', $payment->payment_method) }}</span>
                                        <span class="font-semibold text-emerald-600 dark:text-emerald-400">TSh {{ number_format($payment->amount, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-8 text-center">
                <div class="h-14 w-14 rounded-2xl bg-gray-50 dark:bg-gray-900 text-gray-400 dark:text-gray-500 flex items-center justify-center mx-auto mb-4">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ __('No Fee Records') }}</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 mb-4">{{ __('This student has no fee assignments yet.') }}</p>
                <a href="/finance/assign?student_id={{ $student->id }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-4 py-2.5 shadow-sm transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    {{ __('Assign First Fee') }}
                </a>
            </div>
        @endforelse

    </div>
</x-app-layout>
