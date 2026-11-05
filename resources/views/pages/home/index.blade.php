@extends('layouts.main')

@php
    $poster = asset('assets/video/hero-poster.jpg');
    $steamUrl = config('services.social.steam');
    $discordUrl = config('services.social.discord');
    $titleWords = preg_split('/\s+/u', trim(__('home.title')), -1, PREG_SPLIT_NO_EMPTY);
    $structuredData = [
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        'name' => 'Games 4 You',
        'url' => route('home.page'),
        'inLanguage' => app()->getLocale(),
        'potentialAction' => [
            '@type' => 'SearchAction',
            'target' => ['@type' => 'EntryPoint', 'urlTemplate' => route('games.page').'?q={search_term_string}'],
            'query-input' => 'required name=search_term_string',
        ],
    ];
@endphp

@section('title', __('home.meta_title'))

@push('styles')
    @include('pages.home.partials.assets')
@endpush

@push('head')
    <script>document.documentElement.classList.add('hm-js')</script>
    <meta name="description" content="{{ __('home.meta_description') }}">
    <link rel="canonical" href="{{ route('home.page') }}">
    @foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $code => $locale)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($code, route('home.page')) }}">
    @endforeach
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ __('home.meta_title') }}">
    <meta property="og:description" content="{{ __('home.meta_description') }}">
    <meta property="og:image" content="{{ $poster }}">
    <meta property="og:url" content="{{ route('home.page') }}">
    <meta name="twitter:card" content="summary_large_image">
    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/home/home.js') }}" defer></script>
@endpush

@section('media_content')
    <div class="gm-page hm-page">
        {{-- ============ HERO З ВІДЕО ============ --}}
        <section class="hm-hero" data-hm-hero>
            <video class="hm-hero__video" data-hm-video muted loop autoplay playsinline preload="metadata"
                   poster="{{ $poster }}" aria-hidden="true" tabindex="-1">
                <source src="{{ asset('assets/video/hero.webm') }}" type="video/webm">
                <source src="{{ asset('assets/video/hero.mp4') }}" type="video/mp4">
            </video>
            <div class="hm-hero__shade" aria-hidden="true"></div>
            <div class="hm-hero__glow" data-hm-glow aria-hidden="true"></div>

            <div class="container hm-hero__inner">
                <p class="hm-badge">{{ __('home.badge') }}</p>

                <h1 class="hm-hero__title">
                    @foreach ($titleWords as $i => $word)
                        <span class="hm-word" style="--i: {{ $i }}">{{ $word }}</span>{{ ' ' }}
                    @endforeach
                </h1>

                <p class="hm-hero__lead">{{ __('home.description') }}</p>

                <div class="hm-hero__cta">
                    <a class="gm-btn" href="{{ route('games.page') }}">{{ __('home.cta_catalog') }}</a>
                    <a class="gm-btn gm-btn--ghost" href="{{ $steamUrl }}" target="_blank" rel="noopener noreferrer">🎮 {{ __('home.play_now') }}</a>
                </div>

                <dl class="hm-stats">
                    <div>
                        <dt>{{ __('home.stat_games') }}</dt>
                        <dd data-hm-count="{{ $stats['games'] }}">{{ $stats['games'] }}</dd>
                    </div>
                    <div>
                        <dt>{{ __('home.stat_companies') }}</dt>
                        <dd data-hm-count="{{ $stats['companies'] }}">{{ $stats['companies'] }}</dd>
                    </div>
                    <div>
                        <dt>{{ __('home.stat_creators') }}</dt>
                        <dd data-hm-count="{{ $stats['creators'] }}">{{ $stats['creators'] }}</dd>
                    </div>
                </dl>
            </div>

            <a class="hm-scroll" href="#trending" aria-label="{{ __('home.scroll_down') }}">↓</a>
        </section>

        {{-- ============ ТРЕНДИ ============ --}}
        @if ($newGames->isNotEmpty())
            <section class="hm-section" id="trending">
                <div class="container">
                    <div class="hm-head hm-reveal">
                        <div>
                            <h2 class="gm-h2">{{ __('home.trending_title') }}</h2>
                            <p class="hm-hint">{{ __('home.trending_hint') }}</p>
                        </div>
                        <div class="hm-head__side">
                            <div class="hm-tabs" role="tablist" aria-label="{{ __('home.trending_title') }}">
                                <button type="button" role="tab" id="tab-new" aria-controls="panel-new" aria-selected="true" data-hm-tab="new">{{ __('home.tab_new') }}</button>
                                <button type="button" role="tab" id="tab-top" aria-controls="panel-top" aria-selected="false" data-hm-tab="top" tabindex="-1">{{ __('home.tab_top') }}</button>
                            </div>
                            <a class="hm-link" href="{{ route('games.page') }}">{{ __('home.see_all') }} →</a>
                        </div>
                    </div>

                    <div class="hm-panel is-active hm-reveal" role="tabpanel" id="panel-new" aria-labelledby="tab-new" data-hm-panel="new">
                        <h3 class="hm-panel__title">{{ __('home.tab_new') }}</h3>
                        <div class="gm-strip hm-strip">
                            @foreach ($newGames as $game)
                                @include('pages.game.partials.poster', ['game' => $game])
                            @endforeach
                        </div>
                    </div>

                    <div class="hm-panel hm-reveal" role="tabpanel" id="panel-top" aria-labelledby="tab-top" data-hm-panel="top">
                        <h3 class="hm-panel__title">{{ __('home.tab_top') }}</h3>
                        <div class="gm-strip hm-strip">
                            @foreach ($topGames as $game)
                                @include('pages.game.partials.poster', ['game' => $game])
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- ============ SPOTLIGHT ============ --}}
        @if ($spotlight)
            <section class="hm-spot hm-reveal" aria-labelledby="spot-title">
                <div class="hm-spot__bg" aria-hidden="true"><img src="{{ $spotlight->cover_url }}" alt="" loading="lazy"></div>
                <div class="container hm-spot__grid">
                    <a class="hm-spot__poster" href="{{ route('games.show.page', $spotlight) }}" tabindex="-1" aria-hidden="true">
                        <img src="{{ $spotlight->cover_url }}" alt="" loading="lazy" width="300" height="450">
                    </a>
                    <div class="hm-spot__body">
                        <p class="hm-label">{{ __('home.spotlight_label') }}</p>
                        <h2 class="hm-spot__title" id="spot-title">{{ $spotlight->name }}</h2>
                        <ul class="hm-meta">
                            @if ($spotlight->category)
                                <li>{{ $spotlight->category->title }}</li>
                            @endif
                            <li class="hm-meta__rating">★ {{ number_format($spotlight->rating, 0, '.', ' ') }}</li>
                            @foreach (array_slice($spotlight->platformList(), 0, 3) as $platform)
                                <li>{{ $platform }}</li>
                            @endforeach
                        </ul>
                        <p class="hm-spot__text">{{ \Illuminate\Support\Str::limit(strip_tags((string) $spotlight->description), 240) }}</p>
                        <div class="hm-spot__cta">
                            <a class="gm-btn" href="{{ route('games.show.page', $spotlight) }}">{{ __('home.spotlight_cta') }}</a>
                            @if ($spotlight->trailerId())
                                <a class="gm-btn gm-btn--ghost" href="{{ route('games.show.page', $spotlight) }}#trailer">▶ {{ __('home.spotlight_trailer') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- ============ ЖАНРИ ============ --}}
        @if ($genres->isNotEmpty())
            <section class="hm-section">
                <div class="container">
                    <div class="hm-head hm-reveal">
                        <div>
                            <h2 class="gm-h2">{{ __('home.genres_title') }}</h2>
                            <p class="hm-hint">{{ __('home.genres_hint') }}</p>
                        </div>
                    </div>
                    <ul class="hm-genres">
                        @foreach ($genres as $i => $genre)
                            <li class="hm-reveal" style="--d: {{ min($i, 8) * 50 }}ms">
                                <a class="hm-genre" style="--hue: {{ ($i * 47 + 170) % 360 }}" href="{{ route('games.page', ['category' => $genre->id]) }}">
                                    <span class="hm-genre__name">{{ $genre->title }}</span>
                                    <span class="hm-genre__count">{{ trans_choice('home.games_plural', $genre->games_count) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </section>
        @endif

        {{-- ============ ОСТАННІ НОВИНИ ============ --}}
        @if ($latestNews->isNotEmpty())
            <section class="hm-section" id="news">
                <div class="container">
                    <div class="hm-head hm-reveal">
                        <div>
                            <h2 class="gm-h2">{{ __('news.home_title') }}</h2>
                            <p class="hm-hint">{{ __('news.home_hint') }}</p>
                        </div>
                        <a class="hm-link" href="{{ route('news.page') }}">{{ __('news.all_news') }} →</a>
                    </div>
                    <div class="nw-grid">
                        @foreach ($latestNews as $i => $article)
                            <div class="hm-reveal" style="--d: {{ $i * 80 }}ms">
                                @include('pages.news.partials.card', ['article' => $article])
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- ============ СТУДІЇ ТА ТВОРЦІ ============ --}}
        @if ($companies->isNotEmpty() || $creators->isNotEmpty())
            <section class="hm-section">
                <div class="container">
                    @if ($companies->isNotEmpty())
                        <div class="hm-head hm-reveal">
                            <div>
                                <h2 class="gm-h2">{{ __('home.studios_title') }}</h2>
                                <p class="hm-hint">{{ __('home.studios_hint') }}</p>
                            </div>
                            <a class="hm-link" href="{{ route('company.page') }}">{{ __('home.see_all_studios') }} →</a>
                        </div>
                        <div class="hm-marquee hm-reveal" data-hm-marquee>
                            <ul class="hm-marquee__track">
                                @foreach ([1, 2] as $copy)
                                    @foreach ($companies as $company)
                                        <li @if ($copy === 2) aria-hidden="true" class="hm-marquee__dup" @endif>
                                            <a class="hm-logo" href="{{ route('company.show.page', $company) }}" @if ($copy === 2) tabindex="-1" @endif title="{{ $company->name }}">
                                                @if ($company->logo_path)
                                                    <img src="{{ $company->logo_url }}" alt="{{ $copy === 1 ? $company->name : '' }}" loading="lazy" height="44">
                                                @else
                                                    <span>{{ $company->name }}</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($creators->isNotEmpty())
                        <div class="hm-head hm-head--spaced hm-reveal">
                            <div>
                                <h2 class="gm-h2">{{ __('home.creators_title') }}</h2>
                                <p class="hm-hint">{{ __('home.creators_hint') }}</p>
                            </div>
                            <a class="hm-link" href="{{ route('creator.page') }}">{{ __('home.see_all_creators') }} →</a>
                        </div>
                        <div class="hm-people">
                            @foreach ($creators as $i => $creator)
                                <a class="hm-person hm-reveal" style="--d: {{ $i * 70 }}ms" href="{{ route('creator.show.page', $creator) }}">
                                    <img src="{{ $creator->avatar_url }}" alt="" loading="lazy" width="64" height="64">
                                    <span class="hm-person__body">
                                        <strong>{{ $creator->full_name }}</strong>
                                        <small>{{ implode(', ', array_slice($creator->roleList(), 0, 2)) }}</small>
                                        <em>🎮 {{ trans_choice('home.games_plural', $creator->games_count) }}</em>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        @endif

        {{-- ============ ВІДГУКИ ============ --}}
        @if ($comments->isNotEmpty())
            <section class="hm-section">
                <div class="container">
                    <div class="hm-head hm-reveal">
                        <div>
                            <h2 class="gm-h2">{{ __('home.comments_title') }}</h2>
                            <p class="hm-hint">{{ __('home.comments_hint') }}</p>
                        </div>
                    </div>
                    <div class="hm-reviews">
                        @foreach ($comments as $i => $comment)
                            <article class="hm-review hm-reveal" style="--d: {{ $i * 60 }}ms">
                                <header>
                                    <span class="gm-comment__avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr($comment->name, 0, 1)) }}</span>
                                    <div>
                                        <strong>{{ $comment->name }}</strong>
                                        <time datetime="{{ $comment->created_at?->toIso8601String() }}">{{ $comment->created_at?->diffForHumans() }}</time>
                                    </div>
                                </header>
                                <p>{{ $comment->content }}</p>
                                <a href="{{ route('games.show.page', $comment->game) }}#comments">{{ $comment->game->name }} →</a>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- ============ СПІЛЬНОТА ============ --}}
        <section class="hm-community hm-reveal">
            <div class="container hm-community__inner">
                <h2 class="hm-community__title">{{ __('home.join') }} <span>{{ __('home.community') }}</span></h2>
                <p class="hm-community__text">{{ __('home.join_text') }}</p>
                <div class="hm-community__cta">
                    <a class="gm-btn" href="{{ $discordUrl }}" target="_blank" rel="noopener noreferrer">{{ __('home.join_discord') }}</a>
                    <a class="gm-btn gm-btn--ghost" href="{{ $steamUrl }}" target="_blank" rel="noopener noreferrer">{{ __('home.join_steam') }}</a>
                </div>
            </div>
        </section>
    </div>
@endsection
