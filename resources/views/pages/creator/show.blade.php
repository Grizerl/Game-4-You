@extends('layouts.main')

@php
    $pageTitle = $creator->full_name . ' — ' . __('creators.title_span') . ' — Games 4 You';
    $description = filled($creator->bio)
        ? \Illuminate\Support\Str::limit(strip_tags((string) $creator->bio), 160)
        : __('creators.meta_description', ['name' => $creator->full_name, 'role' => $creator->role]);
    $socialIcons = ['website' => '🌐', 'x' => '𝕏', 'youtube' => '▶', 'twitch' => '🎮', 'instagram' => '📷'];
    $years = $creator->career_start ? max(0, now()->year - $creator->career_start) : null;
@endphp

@section('title', $pageTitle)

@push('styles')
    @include('pages.creator.partials.assets')
@endpush

@push('head')
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ route('creator.show.page', $creator) }}">
    @foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $code => $locale)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($code, route('creator.show.page', $creator)) }}">
    @endforeach
    <meta property="og:type" content="profile">
    <meta property="og:title" content="{{ $creator->full_name }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $creator->avatar_url }}">
    <meta property="og:url" content="{{ route('creator.show.page', $creator) }}">
    <meta name="twitter:card" content="summary">
    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/creators/creators.js') }}" defer></script>
@endpush

@section('media_content')
    <div class="section-creators cr-page cr-profile">
        <div class="container">
            <a class="cr-back" href="{{ route('creator.page') }}">← {{ __('creators.back_to_list') }}</a>

            <header class="cr-hero">
                <img class="cr-hero__avatar" src="{{ $creator->avatar_url }}" alt="{{ $creator->full_name }}" width="220" height="220">

                <div class="cr-hero__body">
                    <h1 class="cr-hero__name">{{ $creator->full_name }}</h1>

                    @if ($creator->roleList())
                        <ul class="cr-badges">
                            @foreach ($creator->roleList() as $role)
                                <li class="cr-badge">{{ $role }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <ul class="cr-facts">
                        @if ($creator->company)
                            <li>
                                <span class="cr-facts__label">{{ __('creators.company') }}</span>
                                <a class="cr-facts__value" href="{{ route('company.page') }}">
                                    @if ($creator->company->logo_path)
                                        <img src="{{ asset($creator->company->logo_path) }}" alt="" width="22" height="22">
                                    @endif
                                    {{ $creator->company->name }}
                                </a>
                            </li>
                        @endif
                        @if (filled($creator->country))
                            <li>
                                <span class="cr-facts__label">{{ __('creators.country') }}</span>
                                <span class="cr-facts__value">{{ $creator->country }}</span>
                            </li>
                        @endif
                        @if ($creator->career_start)
                            <li>
                                <span class="cr-facts__label">{{ __('creators.career') }}</span>
                                <span class="cr-facts__value">{{ __('creators.since', ['year' => $creator->career_start]) }} · {{ trans_choice('creators.years', $years) }}</span>
                            </li>
                        @endif
                    </ul>

                    <div class="cr-hero__actions">
                        @foreach ($socials as $key => $url)
                            <a class="cr-social" href="{{ $url }}" target="_blank" rel="noopener noreferrer" aria-label="{{ __('creators.social.' . $key) }}">
                                <span class="cr-social__icon" aria-hidden="true">{{ $socialIcons[$key] }}</span>
                                {{ __('creators.social.' . $key) }}
                            </a>
                        @endforeach

                        <button type="button" class="cr-btn cr-btn--ghost" data-cr-share
                                data-url="{{ route('creator.show.page', $creator) }}"
                                data-title="{{ $creator->full_name }}"
                                data-copied="{{ __('creators.share_copied') }}">
                            🔗 {{ __('creators.share') }}
                        </button>
                    </div>
                </div>
            </header>

            @if (filled($creator->bio))
                <section class="cr-section">
                    <h2 class="cr-section-title">{{ __('creators.bio') }}</h2>
                    <p class="cr-bio">{{ $creator->bio }}</p>
                </section>
            @endif

            <section class="cr-section">
                <h2 class="cr-section-title">{{ __('creators.stats_title') }}</h2>
                @if ($stats['count'] === 0)
                    <p class="cr-muted">{{ __('creators.no_games_profile') }}</p>
                @else
                    <dl class="cr-stats">
                        <div class="cr-stat">
                            <dt>{{ __('creators.stat_games') }}</dt>
                            <dd>{{ $stats['count'] }}</dd>
                        </div>
                        <div class="cr-stat">
                            <dt>{{ __('creators.stat_avg_rating') }}</dt>
                            <dd>{{ number_format($stats['average'], 0, '.', ' ') }} ⭐</dd>
                        </div>
                        <div class="cr-stat">
                            <dt>{{ __('creators.stat_max_rating') }}</dt>
                            <dd>{{ number_format($stats['max'], 0, '.', ' ') }} ⭐</dd>
                        </div>
                        @if ($stats['main_genre'])
                            <div class="cr-stat">
                                <dt>{{ __('creators.stat_main_genre') }}</dt>
                                <dd>{{ $stats['main_genre']->title }}</dd>
                            </div>
                        @endif
                    </dl>
                @endif
            </section>

            @if ($genres->isNotEmpty())
                <section class="cr-section">
                    <h2 class="cr-section-title">{{ __('creators.genres_title') }}</h2>
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
                    <h2 class="cr-section-title">{{ __('creators.timeline_title') }}</h2>
                    <p class="cr-muted">{{ __('creators.timeline_hint') }}</p>
                    <ol class="cr-timeline">
                        @foreach ($games as $game)
                            <li class="cr-timeline__item">
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
                    </ol>
                </section>
            @endif

            @if ($coCreators->isNotEmpty())
                <section class="cr-section">
                    <h2 class="cr-section-title">{{ __('creators.co_creators_title') }}</h2>
                    <div class="cr-stars__grid">
                        @foreach ($coCreators as $coCreator)
                            @include('pages.creator.partials.mini', ['creator' => $coCreator])
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($previous || $next)
                <nav class="cr-pager" aria-label="{{ __('creators.title_span') }}">
                    @if ($previous)
                        <a class="cr-pager__link cr-pager__link--prev" rel="prev" href="{{ route('creator.show.page', $previous) }}">
                            <span class="cr-muted">← {{ __('creators.prev') }}</span>
                            <span>{{ $previous->full_name }}</span>
                        </a>
                    @endif
                    @if ($next)
                        <a class="cr-pager__link cr-pager__link--next" rel="next" href="{{ route('creator.show.page', $next) }}">
                            <span class="cr-muted">{{ __('creators.next') }} →</span>
                            <span>{{ $next->full_name }}</span>
                        </a>
                    @endif
                </nav>
            @endif
        </div>
    </div>
@endsection
