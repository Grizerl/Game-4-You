{{-- Компактна картка творця: уся картка — посилання на профіль. Очікує $creator з company, games та games_count. --}}
<a class="cr-card" href="{{ route('creator.show.page', $creator) }}">
    <div class="cr-card__head">
        <img class="cr-card__avatar" src="{{ $creator->avatar_thumb_url }}" alt="{{ $creator->full_name }}" loading="lazy" width="96" height="96">
        <div class="cr-card__title">
            <h4 class="cr-card__name">{{ $creator->full_name }}</h4>
            @if ($roles = array_slice($creator->roleList(), 0, 2))
                <ul class="cr-badges">
                    @foreach ($roles as $role)
                        <li class="cr-badge">{{ $role }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    @if ($creator->company)
        <div class="cr-card__company">
            @if ($creator->company->hasImage())
                <img src="{{ $creator->company->logo_thumb_url }}" alt="" loading="lazy" width="22" height="22">
            @endif
            <span>{{ $creator->company->name }}</span>
        </div>
    @endif

    @if (filled($creator->bio))
        <p class="cr-card__bio">{{ $creator->bio }}</p>
    @endif

    <div class="cr-card__foot">
        <span class="cr-card__count">🎮 {{ trans_choice('creators.games_plural', $creator->games_count) }}</span>
        <ul class="cr-covers">
            @foreach ($creator->games->take(3) as $game)
                <li><img src="{{ $game->cover_thumb_url }}" alt="{{ $game->name }}" title="{{ $game->name }}" loading="lazy" width="40" height="40"></li>
            @endforeach
        </ul>
    </div>
</a>
