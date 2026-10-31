@extends('layouts.main')

@php
    $pageTitle = $company->name . ' — ' . __('companies.title_span') . ' — Games 4 You';
    $description = filled($company->description)
        ? \Illuminate\Support\Str::limit(strip_tags((string) $company->description), 160)
        : __('companies.meta_description', ['name' => $company->name]);
    $socialIcons = ['website' => '🌐', 'x' => '𝕏', 'youtube' => '▶', 'twitch' => '🎮', 'instagram' => '📷'];
    $years = $company->founded_year ? max(0, now()->year - $company->founded_year) : null;
@endphp

@section('title', $pageTitle)

@push('styles')
    @include('pages.store.partials.assets')
@endpush

@push('head')
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ route('company.show.page', $company) }}">
    @foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $code => $locale)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($code, route('company.show.page', $company)) }}">
    @endforeach
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $company->name }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $company->logo_url }}">
    <meta property="og:url" content="{{ route('company.show.page', $company) }}">
    <meta name="twitter:card" content="summary">
    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/creators/creators.js') }}" defer></script>
@endpush

@section('media_content')
    <div class="section-creators cr-page cr-profile">
        <div class="container">
            <a class="cr-back" href="{{ route('company.page') }}">← {{ __('companies.back_to_list') }}</a>

            <header class="cr-hero">
                <img class="co-hero__logo" src="{{ $company->logo_url }}" alt="{{ $company->name }}" width="200" height="200">

                <div class="cr-hero__body">
                    <h1 class="cr-hero__name">{{ $company->name }}</h1>

                    <ul class="cr-facts">
                        @if (filled($company->country))
                            <li>
                                <span class="cr-facts__label">{{ __('companies.country') }}</span>
                                <span class="cr-facts__value">{{ $company->country }}</span>
                            </li>
                        @endif
                        @if ($company->founded_year)
                            <li>
                                <span class="cr-facts__label">{{ __('companies.founded') }}</span>
                                <span class="cr-facts__value">{{ __('companies.since', ['year' => $company->founded_year]) }} · {{ trans_choice('companies.years', $years) }}</span>
                            </li>
                        @endif
                    </ul>

                    <div class="cr-hero__actions">
                        @foreach ($socials as $key => $url)
                            <a class="cr-social" href="{{ $url }}" target="_blank" rel="noopener noreferrer" aria-label="{{ __('companies.social.' . $key) }}">
                                <span class="cr-social__icon" aria-hidden="true">{{ $socialIcons[$key] }}</span>
                                {{ __('companies.social.' . $key) }}
                            </a>
                        @endforeach

                        <button type="button" class="cr-btn cr-btn--ghost" data-cr-share
                                data-url="{{ route('company.show.page', $company) }}"
                                data-title="{{ $company->name }}"
                                data-copied="{{ __('companies.share_copied') }}">
                            🔗 {{ __('companies.share') }}
                        </button>
                    </div>
                </div>
            </header>

            @if (filled($company->description))
                <section class="cr-section">
                    <h2 class="cr-section-title">{{ __('companies.about_title') }}</h2>
                    <p class="cr-bio">{{ $company->description }}</p>
                </section>
            @endif

            <section class="cr-section">
                <h2 class="cr-section-title">{{ __('companies.stats_title') }}</h2>
                @if ($stats['count'] === 0)
                    <p class="cr-muted">{{ __('companies.no_games_profile') }}</p>
                @else
                    <dl class="cr-stats">
                        <div class="cr-stat">
                            <dt>{{ __('companies.stat_games') }}</dt>
                            <dd>{{ $stats['count'] }}</dd>
                        </div>
                        <div class="cr-stat">
                            <dt>{{ __('companies.stat_creators') }}</dt>
                            <dd>{{ $stats['creators'] }}</dd>
                        </div>
                        <div class="cr-stat">
                            <dt>{{ __('companies.stat_avg_rating') }}</dt>
                            <dd>{{ number_format($stats['average'], 0, '.', ' ') }} ⭐</dd>
                        </div>
                        <div class="cr-stat">
                            <dt>{{ __('companies.stat_max_rating') }}</dt>
                            <dd>{{ number_format($stats['max'], 0, '.', ' ') }} ⭐</dd>
                        </div>
                        @if ($stats['main_genre'])
                            <div class="cr-stat">
                                <dt>{{ __('companies.stat_main_genre') }}</dt>
                                <dd>{{ $stats['main_genre']->title }}</dd>
                            </div>
                        @endif
                    </dl>
                @endif
            </section>

            @if ($genres->isNotEmpty())
                <section class="cr-section">
                    <h2 class="cr-section-title">{{ __('companies.genres_title') }}</h2>
                    <ul class="cr-genres">
                        @foreach ($genres as $genre)
                            <li class="cr-genre">
                                <span class="cr-genre__name">{{ $genre['category']->title }}</span>
                                <span class="cr-genre__bar" role="img" aria-label="{{ $genre['percent'] }}%"><span style="width: {{ $genre['percent'] }}%"></span></span>
                                <span class="cr-genre__value">{{ $genre['percent'] }}% · {{ $genre['count'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if ($games->isNotEmpty())
                <section class="cr-section">
                    <h2 class="cr-section-title">{{ __('companies.games_title') }}</h2>
                    <p class="cr-muted">{{ __('companies.games_hint') }}</p>
                    <ul class="co-games">
                        @foreach ($games as $game)
                            <li>
                                <a class="cr-game" href="{{ route('games.show.page', $game) }}">
                                    <img src="{{ $game->cover_url }}" alt="{{ $game->name }}" loading="lazy" width="96" height="64">
                                    <span class="cr-game__body">
                                        <span class="cr-game__name">{{ $game->name }}</span>
                                        <span class="cr-game__meta">
                                            @if ($game->category){{ $game->category->title }} · @endif{{ number_format($game->rating, 0, '.', ' ') }} ⭐
                                        </span>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if ($team->isNotEmpty())
                <section class="cr-section">
                    <h2 class="cr-section-title">{{ __('companies.team_title') }}</h2>
                    <div class="cr-stars__grid">
                        @foreach ($team as $creator)
                            @include('pages.creator.partials.mini', ['creator' => $creator])
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($previous || $next)
                <nav class="cr-pager" aria-label="{{ __('companies.title_span') }}">
                    @if ($previous)
                        <a class="cr-pager__link cr-pager__link--prev" rel="prev" href="{{ route('company.show.page', $previous) }}">
                            <span class="cr-muted">← {{ __('companies.prev') }}</span>
                            <span>{{ $previous->name }}</span>
                        </a>
                    @endif
                    @if ($next)
                        <a class="cr-pager__link cr-pager__link--next" rel="next" href="{{ route('company.show.page', $next) }}">
                            <span class="cr-muted">{{ __('companies.next') }} →</span>
                            <span>{{ $next->name }}</span>
                        </a>
                    @endif
                </nav>
            @endif
        </div>
    </div>
@endsection
