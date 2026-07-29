<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">{{ __('Assign Fees') }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('Assign fee types to students for the academic period.') }}</p>
                </div>
                <a href="/finance" class="inline-flex items-center gap-2 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium text-sm rounded-xl px-4 py-2.5 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    {{ __('Back to Dashboard') }}
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-4">{{ __('New Fee Assignment') }}</h3>
                <form method="POST" action="/finance/assign">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">{{ __('Student') }}</label>
                        <select name="student_id" required
                                class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">{{ __('Select a student...') }}</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>{{ $student->fullname }} (ID #{{ $student->id }})</option>
                            @endforeach
                        </select>
                        @error('student_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">{{ __('Category') }}</label>
                        <select name="fee_category_id" required
                                class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">{{ __('Select category...') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('fee_category_id') == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('fee_category_id') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">{{ __('Amount (TSh)') }}</label>
                        <input type="number" name="amount" value="{{ old('amount') }}" step="0.01" min="0" required
                               class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="0.00">
                        @error('amount') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">{{ __('Due Date') }}</label>
                            <input type="date" name="due_date" value="{{ old('due_date') }}"
                                   class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">{{ __('Academic Year') }}</label>
                            <input type="text" name="academic_year" value="{{ old('academic_year') }}"
                                   class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="{{ __('e.g. 2025/2026') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">{{ __('Term') }}</label>
                        <input type="text" name="term" value="{{ old('term') }}"
                               class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="{{ __('e.g. Term 1, Semester 1') }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">{{ __('Description') }}</label>
                        <textarea name="description" rows="2"
                                  class="w-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 text-sm rounded-xl px-4 py-2.5 focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-xl px-4 py-2.5 shadow-sm transition">{{ __('Assign Fee') }}</button>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">
                <h3 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-4">{{ __('Recently Assigned Fees') }}</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider border-b border-gray-100 dark:border-gray-700">
                                <th class="py-3 pr-3">{{ __('Student') }}</th>
                                <th class="py-3 pr-3">{{ __('Category') }}</th>
                                <th class="py-3 pr-3 text-right">{{ __('Amount') }}</th>
                                <th class="py-3 text-center">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50 text-sm">
                            @forelse($assignedFees as $fee)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="py-3 pr-3 font-medium text-gray-900 dark:text-gray-100 truncate max-w-[140px]">{{ $fee->student?->fullname ?? 'N/A' }}</td>
                                    <td class="py-3 pr-3 text-gray-600 dark:text-gray-400">{{ $fee->feeCategory?->name ?? 'N/A' }}</td>
                                    <td class="py-3 pr-3 text-right font-semibold text-gray-900 dark:text-gray-100">TSh {{ number_format($fee->amount, 2) }}</td>
                                    <td class="py-3 text-center">
                                        @php
                                            $badge = match($fee->status) {
                                                'paid' => 'bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300',
                                                'partial' => 'bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-300',
                                                default => 'bg-red-50 dark:bg-red-950 text-red-700 dark:text-red-300',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $badge }} capitalize">{{ __(ucfirst($fee->status)) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-sm text-gray-400">{{ __('No fees assigned yet.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($assignedFees instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $assignedFees->hasPages())
                    <div class="mt-4 border-t border-gray-100 dark:border-gray-700 pt-4">
                        {{ $assignedFees->links() }}
                    </div>
                @endif
            </div>

        </div>

    </div>
</x-app-layout>
