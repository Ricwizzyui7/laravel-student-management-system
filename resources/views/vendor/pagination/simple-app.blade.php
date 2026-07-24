@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-2">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span aria-disabled="true" class="inline-flex items-center gap-1 px-4 py-2 text-sm font-medium text-gray-300 bg-gray-50 border border-gray-100 rounded-xl cursor-default dark:bg-gray-800 dark:border-gray-700 dark:text-gray-600">
                Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               class="inline-flex items-center gap-1 px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-blue-50 hover:text-blue-600 hover:border-blue-100 transition dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-blue-400">
                Previous
            </a>
        @endif

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="inline-flex items-center gap-1 px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-blue-50 hover:text-blue-600 hover:border-blue-100 transition dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-blue-400">
                Next
            </a>
        @else
            <span aria-disabled="true" class="inline-flex items-center gap-1 px-4 py-2 text-sm font-medium text-gray-300 bg-gray-50 border border-gray-100 rounded-xl cursor-default dark:bg-gray-800 dark:border-gray-700 dark:text-gray-600">
                Next
            </span>
        @endif
    </nav>
@endif
