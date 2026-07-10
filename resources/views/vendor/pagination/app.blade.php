@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between gap-4">
        {{-- Mobile: Previous / Next --}}
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 border border-gray-200 rounded-xl cursor-default">
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                    Previous
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                    Next
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 border border-gray-200 rounded-xl cursor-default">
                    Next
                </span>
            @endif
        </div>

        {{-- Desktop: full controls --}}
        <div class="hidden sm:flex sm:items-center sm:justify-between sm:flex-1">
            <p class="text-sm text-gray-500">
                Showing
                <span class="font-semibold text-gray-700">{{ $paginator->firstItem() }}</span>
                to
                <span class="font-semibold text-gray-700">{{ $paginator->lastItem() }}</span>
                of
                <span class="font-semibold text-gray-700">{{ $paginator->total() }}</span>
                results
            </p>

            <div class="inline-flex items-center gap-1">
                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" class="inline-flex items-center justify-center h-9 w-9 rounded-lg text-gray-300 bg-gray-50 border border-gray-100 cursor-default">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous"
                       class="inline-flex items-center justify-center h-9 w-9 rounded-lg text-gray-500 bg-white border border-gray-200 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-100 transition">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </a>
                @endif

                {{-- Page numbers --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="inline-flex items-center justify-center h-9 min-w-9 px-2 text-sm text-gray-400">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="inline-flex items-center justify-center h-9 min-w-9 px-3 rounded-lg text-sm font-semibold text-white bg-blue-600 border border-blue-600">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="inline-flex items-center justify-center h-9 min-w-9 px-3 rounded-lg text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-100 transition">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next"
                       class="inline-flex items-center justify-center h-9 w-9 rounded-lg text-gray-500 bg-white border border-gray-200 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-100 transition">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                    </a>
                @else
                    <span aria-disabled="true" class="inline-flex items-center justify-center h-9 w-9 rounded-lg text-gray-300 bg-gray-50 border border-gray-100 cursor-default">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
