@extends('layouts.main')

@section('title', __('news.meta_title'))

@push('styles')
    @include('pages.news.partials.assets')
@endpush

@push('head')
    <meta name="description" content="{{ __('news.meta_description') }}">
    <link rel="canonical" href="{{ route('news.page') }}">
    @foreach (\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $code => $locale)
        <link rel="alternate" hreflang="{{ $code }}" href="{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($code, route('news.page')) }}">
    @endforeach
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ __('news.meta_title') }}">
    <meta property="og:description" content="{{ __('news.meta_description') }}">
    <meta property="og:url" content="{{ route('news.page') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/js/games/games.js') }}" defer></script>
@endpush

@section('media_content')
    <div class="gm-page nw-page">
        <section class="nw-hero">
            <div class="container">
                <p class="gm-eyebrow">{{ __('news.eyebrow') }}</p>
                <h1 class="nw-title">{{ __('news.title') }}</h1>
                <p class="nw-subtitle">{{ __('news.subtitle') }}</p>

                <div class="nw-tools">
                    <form class="gm-search nw-search" method="GET" action="{{ route('news.page') }}" role="search">
                        @if ($filters['tag'])
                            <input type="hidden" name="tag" value="{{ $filters['tag'] }}">
                        @endif
                        <span class="gm-sr">{{ __('news.search_label') }}</span>
                        <input type="search" name="q" value="{{ $filters['q'] }}" maxlength="100" placeholder="{{ __('news.search_placeholder') }}" aria-label="{{ __('news.search_label') }}">
                        <button type="submit">{{ __('news.search_button') }}</button>
                    </form>
                </div>

                @if ($tags->isNotEmpty())
                    <div class="gm-chips-wrap" data-gm-chips>
                        <button type="button" class="gm-chips__arrow gm-chips__arrow--prev" data-gm-chips-prev aria-label="{{ __('news.chips_prev') }}">‹</button>
                        <nav class="gm-chips" data-gm-rail aria-label="{{ __('news.all_tags') }}">
                            <a class="gm-chip @if (! $filters['tag']) is-active @endif" href="{{ route('news.page', array_filter(['q' => $filters['q']])) }}">{{ __('news.all_tags') }}</a>
                            @foreach ($tags as $tag)
                                <a class="gm-chip @if ($filters['tag'] === $tag->slug) is-active @endif" href="{{ route('news.page', array_filter(['tag' => $tag->slug, 'q' => $filters['q']])) }}">
                                    {{ $tag->name }} <small>{{ $tag->articles_count }}</small>
                                </a>
                            @endforeach
                        </nav>
                        <button type="button" class="gm-chips__arrow gm-chips__arrow--next" data-gm-chips-next aria-label="{{ __('news.chips_next') }}">›</button>
                    </div>
                @endif
            </div>
        </section>

        <div class="container nw-body">
            @if ($featured)
                @php($featuredTag = $featured->tags->first())
                <article class="nw-featured">
                    <img class="nw-featured__bg" src="{{ $featured->cover_url }}" alt="" width="1280" height="720">
                    <div class="nw-featured__shade" aria-hidden="true"></div>
                    <div class="nw-featured__body">
                        <p class="nw-featured__badge">{{ __('news.featured_badge') }}</p>
                        <div class="nw-card__meta">
                            @if ($featuredTag)
                                <a class="nw-tag" href="{{ route('news.page', ['tag' => $featuredTag->slug]) }}">{{ $featuredTag->name }}</a>
                            @endif
                            <time datetime="{{ $featured->published_at?->toIso8601String() }}">{{ $featured->published_at?->translatedFormat('j F Y') }}</time>
                            <span>{{ __('news.min_read', ['count' => $featured->readingTime()]) }}</span>
                        </div>
                        <h2 class="nw-featured__title"><a href="{{ route('news.show.page', $featured) }}">{{ $featured->title }}</a></h2>
                        <p class="nw-featured__excerpt">{{ $featured->excerpt }}</p>
                        <a class="gm-btn" href="{{ route('news.show.page', $featured) }}">{{ __('news.read_more') }} →</a>
                    </div>
                </article>
            @endif

            @if ($articles->isEmpty() && ! $featured)
                <div class="gm-empty">
                    <p class="gm-empty__title">{{ __('news.nothing_found') }}</p>
                    <p>{{ __('news.nothing_found_hint') }}</p>
                    <a class="gm-btn" href="{{ route('news.page') }}">{{ __('news.reset') }}</a>
                </div>
            @elseif ($articles->isNotEmpty())
                <div class="nw-grid">
                    @foreach ($articles as $article)
                        @include('pages.news.partials.card', ['article' => $article])
                    @endforeach
                </div>
            @endif

            {{ $articles->links() }}
        </div>
    </div>
@endsection
