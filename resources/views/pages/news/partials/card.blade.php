{{-- Картка новини. Очікує $article із tags. --}}
@php($tag = $article->tags->first())
<article class="nw-card">
    <a class="nw-card__media" href="{{ route('news.show.page', $article) }}" tabindex="-1" aria-hidden="true">
        <img src="{{ $article->cover_url }}" alt="" loading="lazy" width="640" height="360">
    </a>
    <div class="nw-card__body">
        <div class="nw-card__meta">
            @if ($tag)
                <a class="nw-tag" href="{{ route('news.page', ['tag' => $tag->slug]) }}">{{ $tag->name }}</a>
            @endif
            <time datetime="{{ $article->published_at?->toIso8601String() }}">{{ $article->published_at?->translatedFormat('j F Y') }}</time>
        </div>
        <h3 class="nw-card__title"><a href="{{ route('news.show.page', $article) }}">{{ $article->title }}</a></h3>
        <p class="nw-card__excerpt">{{ $article->excerpt }}</p>
    </div>
</article>
