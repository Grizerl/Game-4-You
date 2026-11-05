<?php

namespace App\Jobs\Search;

use App\Models\Article;
use App\Models\Creator;
use App\Models\Game;
use App\Services\Search\DocumentMapper;
use App\Services\Search\SearchIndexer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

/**
 * Переіндексує документи, у яких є дані зміненої сутності: ігри категорії/студії/творця,
 * творців студії, новини з тегом.
 */
class ReindexDependentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public int $tries = 5;

    /**
     * @param  string  $type  category|company|creator|tag
     */
    public function __construct(public string $type, public int $id)
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
        if (! config('search.enabled')) {
            return;
        }

        $chunk = (int) config('search.reindex_chunk');

        $queries = match ($this->type) {
            'category' => [Game::query()->where('category_id', $this->id)->with(DocumentMapper::relationsFor('game'))],
            'company' => [
                Game::query()->where('company_id', $this->id)->with(DocumentMapper::relationsFor('game')),
                Creator::query()->where('company_id', $this->id)->with(DocumentMapper::relationsFor('creator')),
            ],
            'creator' => [Game::query()->where('creator_id', $this->id)->with(DocumentMapper::relationsFor('game'))],
            'tag' => [Article::query()->whereHas('tags', fn ($tags) => $tags->where('tags.id', $this->id))->with(DocumentMapper::relationsFor('news'))],
            default => [],
        };

        foreach ($queries as $query) {
            $query->chunkById($chunk, fn ($models) => $indexer->syncMany($models));
        }
    }
}
