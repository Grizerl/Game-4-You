<?php

namespace App\Jobs\Search;

use App\Services\Search\DocumentMapper;
use App\Services\Search\SearchIndexer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Індексує одну модель (або видаляє її документ, якщо вона вже не публічна чи видалена).
 * Модель завантажується за типом/id під час виконання, тож джоб безпечний і для видалених записів.
 */
class IndexModelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public int $tries = 5;

    /**
     * @param  string  $type  Ключ із config('search.models').
     */
    public function __construct(public string $type, public int|string $id)
    {
        $this->afterCommit();
    }

    /**
     * @return list<int>
     */
    public function backoff(): array
    {
        return [10, 30, 60, 120];
    }

    public function handle(SearchIndexer $indexer): void
    {
        $class = config('search.models.'.$this->type);

        if ($class === null || ! config('search.enabled')) {
            return;
        }

        $model = $class::query()->find($this->id);

        if ($model === null) {
            $indexer->delete($this->type, $this->id);

            return;
        }

        $model->loadMissing(DocumentMapper::relationsFor($this->type));

        $indexer->sync($model);
    }
}
