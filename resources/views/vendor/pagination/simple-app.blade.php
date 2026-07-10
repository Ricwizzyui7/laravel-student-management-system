@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-2">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span aria-disabled="true" class="inline-flex items-center gap-1 px-4 py-2 text-sm font-medium text-gray-300 bg-gray-50 border border-gray-100 rounded-xl cursor-default">
                Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               class="inline-flex items-center gap-1 px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-blue-50 hover:text-blue-600 hover:border-blue-100 transition">
                Previous
            </a>
        @endif

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="inline-flex items-center gap-1 px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-blue-50 hover:text-blue-600 hover:border-blue-100 transition">
                Next
            </a>
        @else
            <span aria-disabled="true" class="inline-flex items-center gap-1 px-4 py-2 text-sm font-medium text-gray-300 bg-gray-50 border border-gray-100 rounded-xl cursor-default">
                Next
            </span>
        @endif
    </nav>
@endif
