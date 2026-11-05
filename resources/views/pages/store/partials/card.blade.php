{{-- Картка студії: уся картка — посилання на профіль. Очікує $company з games та лічильниками games_count, creators_count. --}}
<a class="cr-card" href="{{ route('company.show.page', $company) }}">
    <div class="cr-card__head">
        <img class="co-logo" src="{{ $company->logo_thumb_url }}" alt="{{ $company->name }}" loading="lazy" width="72" height="72">
        <div class="cr-card__title">
            <h4 class="cr-card__name">{{ $company->name }}</h4>
            <ul class="cr-badges">
                @if (filled($company->country))
                    <li class="cr-badge">🌍 {{ $company->country }}</li>
                @endif
                @if ($company->founded_year)
                    <li class="cr-badge">{{ __('companies.since', ['year' => $company->founded_year]) }}</li>
                @endif
            </ul>
        </div>
    </div>

    @if (filled($company->description))
        <p class="cr-card__bio">{{ $company->description }}</p>
    @endif

    <div class="cr-card__foot">
        <span class="cr-card__count">
            🎮 {{ trans_choice('companies.games_plural', $company->games_count) }}
            · 👥 {{ trans_choice('companies.creators_plural', $company->creators_count) }}
        </span>
        <ul class="cr-covers">
            @foreach ($company->games->take(3) as $game)
                <li><img src="{{ $game->cover_thumb_url }}" alt="{{ $game->name }}" title="{{ $game->name }}" loading="lazy" width="40" height="40"></li>
            @endforeach
        </ul>
    </div>
</a>
