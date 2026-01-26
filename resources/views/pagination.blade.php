@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
    <div class="flex justify-between flex-1 sm:hidden">
        @if ($paginator->onFirstPage())
        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-200 cursor-default leading-5 rounded-lg">
            {!! __('pagination.previous') !!}
        </span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 bg-white border border-gray-200 leading-5 rounded-lg hover:text-indigo-500 hover:bg-indigo-50 transition-all duration-200 shadow-sm">
            {!! __('pagination.previous') !!}
        </a>
        @endif

        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-indigo-600 bg-white border border-gray-200 leading-5 rounded-lg hover:text-indigo-500 hover:bg-indigo-50 transition-all duration-200 shadow-sm">
            {!! __('pagination.next') !!}
        </a>
        @else
        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-400 bg-white border border-gray-200 cursor-default leading-5 rounded-lg">
            {!! __('pagination.next') !!}
        </span>
        @endif
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-600 leading-5">
                {!! __('Showing') !!}
                @if ($paginator->firstItem())
                <span class="font-bold text-indigo-600">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="font-bold text-indigo-600">{{ $paginator->lastItem() }}</span>
                @else
                {{ $paginator->count() }}
                @endif
                {!! __('of') !!}
                <span class="font-bold text-indigo-600">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        <div>
            <span class="relative z-0 inline-flex shadow-sm rounded-lg overflow-hidden border border-gray-200">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <span class="relative inline-flex items-center px-2 py-2 bg-white text-gray-300 text-sm font-medium leading-5" aria-hidden="true">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </span>
                @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 bg-white text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 text-sm font-medium leading-5" aria-label="{{ __('pagination.previous') }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                <span aria-disabled="true">
                    <span class="relative inline-flex items-center px-4 py-2 bg-white text-gray-400 text-sm font-medium leading-5 cursor-default">{{ $element }}</span>
                </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <span aria-current="page">
                    <span class="relative inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-bold leading-5 cursor-default shadow-inner">{{ $page }}</span>
                </span>
                @else
                <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 bg-white text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 text-sm font-medium leading-5" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                    {{ $page }}
                </a>
                @endif
                @endforeach
                @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 bg-white text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all duration-200 text-sm font-medium leading-5" aria-label="{{ __('pagination.next') }}">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
                @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <span class="relative inline-flex items-center px-2 py-2 bg-white text-gray-300 text-sm font-medium leading-5" aria-hidden="true">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </span>
                @endif
            </span>
        </div>
    </div>
</nav>
@endif