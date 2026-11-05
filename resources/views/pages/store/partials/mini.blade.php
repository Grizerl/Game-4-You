{{-- Міні-картка студії («Топ-студії»). Очікує $company з games_count. --}}
<a class="cr-mini" href="{{ route('company.show.page', $company) }}">
    <img class="co-logo co-logo--mini" src="{{ $company->logo_url }}" alt="{{ $company->name }}" loading="lazy" width="56" height="56">
    <span class="cr-mini__body">
        <span class="cr-mini__name">{{ $company->name }}</span>
        <span class="cr-mini__meta">{{ $company->country }}</span>
        <span class="cr-mini__count">🎮 {{ trans_choice('companies.games_plural', $company->games_count) }}</span>
    </span>
</a>
