@extends('layouts.main')

@php
    $description = \Illuminate\Support\Str::limit(strip_tags((string) $article->excerpt), 160);
    $published = $article->published_at?->translatedFormat('j F Y');
    $status = $article->status();
@endphp

@section('title', $article->title.' — Games 4 You')

@push('styles')
    @include('pages.news.partials.assets')
@endpush

@push('head')
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ route('news.show.page', $article) }}">
    @foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $code => $locale)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($code, route('news.show.page', $article)) }}">
    @endforeach
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $article->title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:image" content="{{ $article->cover_url }}">
    <meta property="og:url" content="{{ route('news.show.page', $article) }}">
    @if ($article->published_at)
        <meta property="article:published_time" content="{{ $article->published_at->toIso8601String() }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/news/news.js') }}" defer></script>
@endpush

@section('media_content')
    <div class="gm-page nw-page">
        <div class="nw-progress" data-nw-progress aria-hidden="true"><span></span></div>

        @if ($status !== 'published')
            <p class="nw-notice" role="status">
                {{ $status === 'draft' ? __('news.draft_notice') : __('news.scheduled_notice', ['date' => $article->published_at->translatedFormat('j F Y, H:i')]) }}
            </p>
        @endif

        <header class="nw-cover">
            <img class="nw-cover__img" src="{{ $article->cover_url }}" alt="" width="1280" height="720">
            <div class="nw-cover__shade" aria-hidden="true"></div>
            <div class="container nw-cover__inner">
                <nav class="gm-crumbs" aria-label="breadcrumb">
                    <a href="{{ route('home.page') }}">{{ __('header.home') }}</a>
                    <span aria-hidden="true">/</span>
                    <a href="{{ route('news.page') }}">{{ __('header.news') }}</a>
                </nav>

                @if ($article->tags->isNotEmpty())
                    <ul class="nw-tags">
                        @foreach ($article->tags as $tag)
                            <li><a class="nw-tag" href="{{ route('news.page', ['tag' => $tag->slug]) }}">{{ $tag->name }}</a></li>
                        @endforeach
                    </ul>
                @endif

                <h1 class="nw-cover__title">{{ $article->title }}</h1>

                <div class="nw-meta">
                    @if ($published)
                        <span>{{ __('news.published') }}: <time datetime="{{ $article->published_at->toIso8601String() }}">{{ $published }}</time></span>
                    @endif
                    <span>{{ __('news.min_read', ['count' => $article->readingTime()]) }}</span>
                    <button type="button" class="nw-share" data-nw-share
                            data-url="{{ route('news.show.page', $article) }}" data-title="{{ $article->title }}"
                            data-copied="{{ __('news.share_copied') }}">🔗 {{ __('news.share') }}</button>
                </div>
            </div>
        </header>

        <div class="container nw-layout">
            <article class="nw-article">
                <p class="nw-lead">{{ $article->excerpt }}</p>
                <div class="nw-prose" data-nw-body>{!! $article->bodyHtml() !!}</div>
            </article>
        </div>

        @if ($article->games->isNotEmpty() || $article->companies->isNotEmpty())
            <section class="container nw-section">
                @if ($article->games->isNotEmpty())
                    <h2 class="gm-h2">{{ __('news.mentioned_games') }}</h2>
                    <div class="gm-strip">
                        @foreach ($article->games as $game)
                            @include('pages.game.partials.poster', ['game' => $game])
                        @endforeach
                    </div>
                @endif

                @if ($article->companies->isNotEmpty())
                    <h2 class="gm-h2 nw-section__gap">{{ __('news.mentioned_studios') }}</h2>
                    <ul class="nw-studios">
                        @foreach ($article->companies as $company)
                            <li>
                                <a class="nw-studio" href="{{ route('company.show.page', $company) }}">
                                    <img src="{{ $company->logo_url }}" alt="" loading="lazy" width="44" height="44">
                                    <span>{{ $company->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
        @endif

        @if ($related->isNotEmpty())
            <section class="container nw-section nw-section--last">
                <h2 class="gm-h2">{{ __('news.read_next') }}</h2>
                <div class="nw-grid">
                    @foreach ($related as $item)
                        @include('pages.news.partials.card', ['article' => $item])
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
