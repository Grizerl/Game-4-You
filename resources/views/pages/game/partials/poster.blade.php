{{-- Постерна картка гри. Очікує $game з category. --}}
<a class="gm-poster" href="{{ route('games.show.page', $game) }}">
    <span class="gm-poster__img">
        <img src="{{ $game->cover_thumb_url }}" alt="{{ $game->name }}" loading="lazy" width="300" height="450">
        <span class="gm-poster__rating">★ {{ number_format($game->rating, 0, '.', ' ') }}</span>
        @if ($game->isNew)
            <span class="gm-poster__new">{{ __('games.new_badge') }}</span>
        @endif
    </span>
    <span class="gm-poster__body">
        @if ($game->category)
            <span class="gm-poster__genre">{{ $game->category->title }}</span>
        @endif
        <span class="gm-poster__title">{{ $game->name }}</span>
    </span>
</a>
