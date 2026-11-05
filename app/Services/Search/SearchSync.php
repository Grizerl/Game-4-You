<?php

namespace App\Services\Search;

use App\Jobs\Search\IndexModelJob;
use App\Jobs\Search\ReindexDependentsJob;
use App\Models\Article;
use App\Models\Category;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Єдина точка постановки індексації в чергу. Ніколи не кидає винятків: збій черги чи Elasticsearch
 * не повинен ламати збереження даних в адмінці.
 */
final class SearchSync
{
    /**
     * Моделі, що самі є документами.
     *
     * @var list<class-string<Model>>
     */
    public const INDEXED = [Game::class, Category::class, Creator::class, Company::class, Article::class];

    public static function index(Model $model): void
    {
        $type = self::typeOf($model);

        if ($type !== null) {
            self::safely(fn () => IndexModelJob::dispatch($type, $model->getKey()));
        }

        self::dependents($model);
    }

    public static function dependents(Model $model): void
    {
        $dependentType = match (true) {
            $model instanceof Category => 'category',
            $model instanceof Company => 'company',
            $model instanceof Creator => 'creator',
            $model instanceof Tag => 'tag',
            default => null,
        };

        if ($dependentType !== null) {
            self::safely(fn () => ReindexDependentsJob::dispatch($dependentType, (int) $model->getKey()));
        }
    }

    private static function typeOf(Model $model): ?string
    {
        $type = array_search($model::class, (array) config('search.models'), true);

        return $type === false ? null : (string) $type;
    }

    private static function safely(callable $dispatch): void
    {
        if (! config('search.enabled')) {
            return;
        }

        try {
            $dispatch();
        } catch (Throwable $e) {
            Log::warning('Search sync was not queued: '.$e->getMessage());
        }
    }
}
