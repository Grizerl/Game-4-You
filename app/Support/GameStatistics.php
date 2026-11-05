<?php

namespace App\Support;

use App\Models\Category;
use App\Models\Game;
use Illuminate\Support\Collection;

/**
 * Статистика за колекцією ігор (з завантаженою категорією): кількість, рейтинги, жанри.
 */
final class GameStatistics
{
    /**
     * @param  Collection<int, Game>  $games
     * @return array{
     *     stats: array{count: int, average: ?int, max: mixed, main_genre: ?Category},
     *     genres: Collection<int, array{category: Category, count: int, percent: int}>
     * }
     */
    public static function for(Collection $games): array
    {
        $genres = self::genres($games);

        return [
            'stats' => [
                'count' => $games->count(),
                'average' => $games->isEmpty() ? null : (int) round($games->avg('rating')),
                'max' => $games->max('rating'),
                'main_genre' => $genres->first()['category'] ?? null,
            ],
            'genres' => $genres,
        ];
    }

    /**
     * Розподіл за жанрами: від найпоширенішого; за рівності — менший id категорії.
     *
     * @param  Collection<int, Game>  $games
     * @return Collection<int, array{category: Category, count: int, percent: int}>
     */
    private static function genres(Collection $games): Collection
    {
        $categorized = $games->filter(fn (Game $game): bool => $game->category !== null);

        return $categorized
            ->groupBy('category_id')
            ->map(fn (Collection $group): array => [
                'category' => $group->first()->category,
                'count' => $group->count(),
                'percent' => (int) round($group->count() / $categorized->count() * 100),
            ])
            ->sort(fn (array $a, array $b): int => [$b['count'], $a['category']->id] <=> [$a['count'], $b['category']->id])
            ->values();
    }
}
