<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Services\Search\DocumentMapper;
use App\Services\Search\SearchClient;
use App\Services\Search\SearchIndexer;
use App\Services\Search\SearchUnavailableException;
use Illuminate\Console\Command;

class SearchSyncScheduled extends Command
{
    protected $signature = 'search:sync-scheduled';

    protected $description = 'Індексує новини, дата публікації яких настала, але яких ще немає в індексі';

    public function handle(SearchClient $client, SearchIndexer $indexer): int
    {
        if (! $client->enabled()) {
            return self::SUCCESS;
        }

        try {
            $ids = Article::query()->published()->pluck('id')->all();
            $missing = $indexer->missingIds('news', $ids);

            if ($missing === []) {
                return self::SUCCESS;
            }

            $articles = Article::query()->whereIn('id', $missing)->with(DocumentMapper::relationsFor('news'))->get();
            $count = $indexer->syncMany($articles);

            $this->info("Проіндексовано новин: {$count}.");
        } catch (SearchUnavailableException $e) {
            $this->warn('Elasticsearch недоступний: '.$e->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
