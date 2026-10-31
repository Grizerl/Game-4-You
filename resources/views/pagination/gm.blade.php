{{-- Компактний пагінатор для сторінок ігор (коментарі). Сторінки показуються вікном навколо поточної. --}}
@if ($paginator->hasPages())
    <nav class="gm-pager" role="navigation" aria-label="{{ __('game.comments') }}">
        @if ($paginator->onFirstPage())
            <span class="gm-pager__item gm-pager__item--nav is-disabled" aria-disabled="true">‹ <span class="gm-pager__label">{{ __('game.prev') }}</span></span>
        @else
            <a class="gm-pager__item gm-pager__item--nav" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹ <span class="gm-pager__label">{{ __('game.prev') }}</span></a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="gm-pager__item gm-pager__gap" aria-hidden="true">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page === $paginator->currentPage())
                        <span class="gm-pager__item is-current" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="gm-pager__item" href="{{ $url }}" aria-label="{{ $page }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="gm-pager__item gm-pager__item--nav" href="{{ $paginator->nextPageUrl() }}" rel="next"><span class="gm-pager__label">{{ __('game.next') }}</span> ›</a>
        @else
            <span class="gm-pager__item gm-pager__item--nav is-disabled" aria-disabled="true"><span class="gm-pager__label">{{ __('game.next') }}</span> ›</span>
        @endif
    </nav>
@endif
