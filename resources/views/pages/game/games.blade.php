@extends('layouts.main')

@section('title', __('games.all') . ' ' . __('games.games') . ' — Games 4 You')

@push('styles')
    @include('pages.game.partials.assets')
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/games/games.js') }}" defer></script>
@endpush

@section('media_content')
    <div class="gm-page">
        <section class="gm-cat-hero">
            <div class="container">
                <p class="gm-eyebrow">{{ trans_choice('games.found_plural', $total) }}</p>
                <h1 class="gm-cat-title">{{ __('games.all') }} <span>{{ __('games.games') }}</span></h1>

                <form class="gm-filters" method="GET" action="{{ route('games.page') }}" data-gm-filters>
                    @if ($filters['category'])
                        <input type="hidden" name="category" value="{{ $filters['category'] }}">
                    @endif

                    <label class="gm-search">
                        <span class="gm-sr">{{ __('games.search_label') }}</span>
                        <input type="search" name="q" value="{{ $filters['q'] }}" maxlength="100" placeholder="{{ __('games.search_placeholder') }}">
                        <button type="submit">{{ __('games.apply') }}</button>
                    </label>

                    <div class="gm-selects">
                        <label>
                            <span class="gm-sr">{{ __('games.platform') }}</span>
                            <select name="platform" data-gm-auto>
                                <option value="">{{ __('games.all_platforms') }}</option>
                                @foreach ($platforms as $platform)
                                    <option value="{{ $platform }}" @selected($filters['platform'] === $platform)>{{ $platform }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label>
                            <span class="gm-sr">{{ __('games.sort_label') }}</span>
                            <select name="sort" data-gm-auto>
                                @foreach (\App\Models\Game::SORTS as $sort)
                                    <option value="{{ $sort }}" @selected($filters['sort'] === $sort)>{{ __('games.sort_' . $sort) }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </form>

                <div class="gm-chips-wrap" data-gm-chips>
                    <button type="button" class="gm-chips__arrow gm-chips__arrow--prev" data-gm-chips-prev aria-label="{{ __('games.chips_prev') }}">‹</button>
                    <nav class="gm-chips" data-gm-rail aria-label="{{ __('games.all_genres') }}">
                    <a class="gm-chip @if (! $filters['category']) is-active @endif"
                       href="{{ route('games.page', array_filter(['q' => $filters['q'], 'platform' => $filters['platform'], 'sort' => $filters['sort'] !== 'new' ? $filters['sort'] : null])) }}">
                        {{ __('games.all_genres') }}
                    </a>
                    @foreach ($categories as $category)
                        <a class="gm-chip @if ($filters['category'] === $category->id) is-active @endif"
                           href="{{ route('games.page', array_filter(['category' => $category->id, 'q' => $filters['q'], 'platform' => $filters['platform'], 'sort' => $filters['sort'] !== 'new' ? $filters['sort'] : null])) }}">
                            {{ $category->title }} <small>{{ $category->games_count }}</small>
                        </a>
                    @endforeach
                    </nav>
                    <button type="button" class="gm-chips__arrow gm-chips__arrow--next" data-gm-chips-next aria-label="{{ __('games.chips_next') }}">›</button>
                </div>
            </div>
        </section>

        <div class="container gm-catalog">
            @if ($games->isEmpty())
                <div class="gm-empty">
                    <p class="gm-empty__title">{{ __('games.nothing_found') }}</p>
                    <p>{{ __('games.nothing_found_hint') }}</p>
                    <a class="gm-btn" href="{{ route('games.page') }}">{{ __('games.reset') }}</a>
                </div>
            @else
                <div class="gm-posters">
                    @foreach ($games as $game)
                        @include('pages.game.partials.poster', ['game' => $game])
                    @endforeach
                </div>
            @endif

            {{ $games->links() }}
        </div>
    </div>
@endsection
