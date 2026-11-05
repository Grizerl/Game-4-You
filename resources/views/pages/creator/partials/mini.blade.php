{{-- Міні-картка творця («Зірки», співавтори). Очікує $creator з games_count. --}}
<a class="cr-mini" href="{{ route('creator.show.page', $creator) }}">
    <img class="cr-mini__avatar" src="{{ $creator->avatar_thumb_url }}" alt="{{ $creator->full_name }}" loading="lazy" width="64" height="64">
    <span class="cr-mini__body">
        <span class="cr-mini__name">{{ $creator->full_name }}</span>
        <span class="cr-mini__meta">{{ implode(', ', array_slice($creator->roleList(), 0, 2)) }}</span>
        <span class="cr-mini__count">🎮 {{ trans_choice('creators.games_plural', $creator->games_count) }}</span>
    </span>
</a>
