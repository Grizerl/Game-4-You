@extends('layouts.main')

@php
    $pageTitle = $game->name . ' — Games 4 You';
    $description = filled($game->description)
        ? \Illuminate\Support\Str::limit(strip_tags((string) $game->description), 160)
        : __('game.meta_description', ['name' => $game->name]);
    $released = $game->released_at?->translatedFormat('j F Y');
    $ratingText = number_format($game->rating, 0, '.', ' ');
    $tabs = array_filter([
        'overview' => __('game.nav_overview'),
        'trailer' => $trailerId ? __('game.nav_trailer') : null,
        'screenshots' => $screenshots ? __('game.nav_screenshots') : null,
        'comments' => __('game.nav_comments').' · '.$comments->total(),
    ]);
@endphp

@section('title', $pageTitle)

@push('styles')
    @include('pages.game.partials.assets')
@endpush

@push('head')
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ route('games.show.page', $game) }}">
    @foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $code => $locale)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($code, route('games.show.page', $game)) }}">
    @endforeach
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $game->name }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $game->cover_url }}">
    <meta property="og:url" content="{{ route('games.show.page', $game) }}">
    <meta name="twitter:card" content="summary_large_image">
    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/games/games.js') }}" defer></script>
@endpush

@section('media_content')
    <div class="gm-page gm-game">
        <header class="gm-hero">
            <div class="gm-hero__bg" aria-hidden="true">
                <img src="{{ $game->cover_url }}" alt="">
            </div>

            <div class="container gm-hero__inner">
                <nav class="gm-crumbs" aria-label="breadcrumb">
                    <a href="{{ route('home.page') }}">{{ __('game.home') }}</a>
                    <span aria-hidden="true">/</span>
                    <a href="{{ route('games.page') }}">{{ __('game.games') }}</a>
                    <span aria-hidden="true">/</span>
                    <span>{{ $game->name }}</span>
                </nav>

                <div class="gm-hero__grid">
                    <img class="gm-hero__poster" src="{{ $game->cover_url }}" alt="{{ $game->name }}" width="300" height="450">

                    <div class="gm-hero__info">
                        <div class="gm-hero__tags">
                            @if ($game->isNew)
                                <span class="gm-tag gm-tag--new">{{ __('game.new_badge') }}</span>
                            @endif
                            @if ($game->category)
                                <a class="gm-tag" href="{{ route('games.page', ['category' => $game->category_id]) }}">{{ $game->category->title }}</a>
                            @endif
                        </div>

                        <h1 class="gm-hero__title">{{ $game->name }}</h1>

                        @if ($platforms)
                            <ul class="gm-platforms">
                                @foreach ($platforms as $platform)
                                    <li><a href="{{ route('games.page', ['platform' => $platform]) }}">{{ $platform }}</a></li>
                                @endforeach
                            </ul>
                        @endif

                        <dl class="gm-hero__facts">
                            <div class="gm-fact gm-fact--rating">
                                <dt>{{ __('game.rating') }}</dt>
                                <dd><span class="gm-star" aria-hidden="true">★</span> {{ $ratingText }}</dd>
                            </div>
                            @if ($released)
                                <div class="gm-fact">
                                    <dt>{{ __('game.release_date') }}</dt>
                                    <dd>{{ $released }}</dd>
                                </div>
                            @endif
                            @if ($game->company)
                                <div class="gm-fact">
                                    <dt>{{ __('game.company') }}</dt>
                                    <dd><a href="{{ route('company.show.page', $game->company) }}">{{ $game->company->name }}</a></dd>
                                </div>
                            @endif
                            @if ($game->creator)
                                <div class="gm-fact">
                                    <dt>{{ __('game.creators') }}</dt>
                                    <dd><a href="{{ route('creator.show.page', $game->creator) }}">{{ $game->creator->full_name }}</a></dd>
                                </div>
                            @endif
                        </dl>

                        <div class="gm-hero__cta">
                            @if ($trailerId)
                                <a class="gm-btn" href="#trailer">▶ {{ __('game.watch_trailer') }}</a>
                            @endif
                            <a class="gm-btn gm-btn--ghost" href="#comments">💬 {{ __('game.to_comments') }} · {{ $comments->total() }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <nav class="gm-tabs" aria-label="{{ $game->name }}" data-gm-tabs>
            <div class="container gm-tabs__inner">
                @foreach ($tabs as $id => $label)
                    <a href="#{{ $id }}" data-gm-tab="{{ $id }}">{{ $label }}</a>
                @endforeach
            </div>
        </nav>

        <div class="container gm-body">
            <section class="gm-section gm-overview" id="overview">
                <div>
                    <h2 class="gm-h2">{{ __('game.overview_title') }}</h2>
                    <p class="gm-prose">{{ $game->description }}</p>
                </div>

                <aside class="gm-details">
                    <h3 class="gm-h3">{{ __('game.details_title') }}</h3>
                    <dl>
                        @if ($game->category)
                            <div><dt>{{ __('game.genre') }}</dt><dd>{{ $game->category->title }}</dd></div>
                        @endif
                        @if ($platforms)
                            <div><dt>{{ __('game.platforms') }}</dt><dd>{{ implode(', ', $platforms) }}</dd></div>
                        @endif
                        @if ($released)
                            <div><dt>{{ __('game.release_date') }}</dt><dd>{{ $released }}</dd></div>
                        @endif
                        @if ($game->company)
                            <div><dt>{{ __('game.company') }}</dt><dd><a href="{{ route('company.show.page', $game->company) }}">{{ $game->company->name }}</a></dd></div>
                        @endif
                        @if ($game->creator)
                            <div><dt>{{ __('game.creators') }}</dt><dd><a href="{{ route('creator.show.page', $game->creator) }}">{{ $game->creator->full_name }}</a></dd></div>
                        @endif
                        <div><dt>{{ __('game.rating') }}</dt><dd>★ {{ $ratingText }}</dd></div>
                    </dl>
                </aside>
            </section>

            @if ($trailerId)
                <section class="gm-section" id="trailer">
                    <h2 class="gm-h2">{{ __('game.trailer_title') }}</h2>
                    <div class="gm-trailer" data-gm-trailer="{{ $trailerId }}">
                        <img src="https://i.ytimg.com/vi/{{ $trailerId }}/hqdefault.jpg" alt="" loading="lazy" width="480" height="360">
                        <button type="button" class="gm-trailer__play" aria-label="{{ __('game.play_trailer') }}">▶</button>
                    </div>
                </section>
            @endif

            @if ($screenshots)
                <section class="gm-section" id="screenshots">
                    <h2 class="gm-h2">{{ __('game.screenshots_title') }}</h2>
                    <ul class="gm-shots">
                        @foreach ($screenshots as $index => $url)
                            <li>
                                <button type="button" data-gm-shot="{{ $url }}" aria-label="{{ __('game.screenshot_open', ['n' => $index + 1]) }}">
                                    <img src="{{ $url }}" alt="{{ $game->name }} — {{ $index + 1 }}" loading="lazy" width="480" height="270">
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            <section class="gm-section" id="comments">
                <h2 class="gm-h2">{{ __('game.comments') }} <small>{{ trans_choice('game.comments_plural', $comments->total()) }}</small></h2>

                <div class="gm-comments">
                    <div class="gm-comments__list">
                        @if (session('comment_status'))
                            <p class="gm-alert gm-alert--ok" role="status">{{ session('comment_status') }}</p>
                        @endif

                        @forelse ($comments as $comment)
                            <article class="gm-comment">
                                <span class="gm-comment__avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($comment->name, 0, 1)) }}</span>
                                <div class="gm-comment__main">
                                    <header>
                                        <strong>{{ $comment->name }}</strong>
                                        <time datetime="{{ $comment->created_at?->toIso8601String() }}">{{ $comment->created_at?->diffForHumans() }}</time>
                                    </header>
                                    <p>{{ $comment->content }}</p>
                                </div>
                            </article>
                        @empty
                            <p class="gm-muted">{{ __('game.no_comments') }}</p>
                        @endforelse

                        {{ $comments->links('pagination.gm') }}
                    </div>

                    <form class="gm-form" action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <h3 class="gm-h3">{{ __('game.add_comment') }}</h3>
                        <input type="hidden" name="game_id" value="{{ $game->id }}">

                        {{-- Приховане поле-пастка проти ботів --}}
                        <div class="gm-hp" aria-hidden="true">
                            <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                        </div>

                        <label>
                            <span class="gm-sr">{{ __('game.your_name') }}</span>
                            <input type="text" name="name" value="{{ old('name') }}" maxlength="50" placeholder="{{ __('game.your_name') }}" required>
                        </label>
                        @error('name')<p class="gm-error">{{ $message }}</p>@enderror

                        <label>
                            <span class="gm-sr">{{ __('game.your_comment') }}</span>
                            <textarea name="content" maxlength="255" rows="4" placeholder="{{ __('game.your_comment') }}" required>{{ old('content') }}</textarea>
                        </label>
                        @error('content')<p class="gm-error">{{ $message }}</p>@enderror

                        <button type="submit" class="gm-btn">{{ __('game.submit') }}</button>
                    </form>
                </div>
            </section>

            @if ($similar->isNotEmpty())
                <section class="gm-section">
                    <h2 class="gm-h2">{{ __('game.similar_title') }}</h2>
                    <div class="gm-strip">
                        @foreach ($similar as $item)
                            @include('pages.game.partials.poster', ['game' => $item])
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($more->isNotEmpty())
                <section class="gm-section">
                    <h2 class="gm-h2">{{ __('game.more_title') }}</h2>
                    <div class="gm-strip">
                        @foreach ($more as $item)
                            @include('pages.game.partials.poster', ['game' => $item])
                        @endforeach
                    </div>
                </section>
            @endif
        </div>

        @if ($screenshots)
            <div class="gm-lightbox" data-gm-lightbox hidden role="dialog" aria-modal="true" aria-label="{{ __('game.screenshots_title') }}">
                <button type="button" class="gm-lightbox__close" data-gm-close aria-label="{{ __('game.close') }}">×</button>
                <button type="button" class="gm-lightbox__nav gm-lightbox__nav--prev" data-gm-prev aria-label="{{ __('game.prev') }}">‹</button>
                <img src="" alt="">
                <button type="button" class="gm-lightbox__nav gm-lightbox__nav--next" data-gm-next aria-label="{{ __('game.next') }}">›</button>
            </div>
        @endif
    </div>
@endsection
