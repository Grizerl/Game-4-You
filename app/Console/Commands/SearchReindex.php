<?php

namespace App\Console\Commands;

use App\Services\Search\SearchClient;
use App\Services\Search\SearchIndexer;
use App\Services\Search\SearchUnavailableException;
use Illuminate\Console\Command;

class SearchReindex extends Command
{
    protected $signature = 'search:reindex {--keep : Залишити попередній індекс (для ручного відкату)}';

    protected $description = 'Повна перебудова пошукового індексу з БД без простою (новий індекс + перемикання псевдоніма)';

    public function handle(SearchClient $client, SearchIndexer $indexer): int
    {
        if (! $client->enabled()) {
            $this->error('Пошук вимкнено (SEARCH_ENABLED=false) або не задано ELASTICSEARCH_HOST.');

            return self::FAILURE;
        }

        try {
            $counts = $indexer->reindex(
                fn (string $type, int $count) => $this->line(sprintf('  %-10s %d', $type, $count)),
                (bool) $this->option('keep'),
            );
        } catch (SearchUnavailableException $e) {
            $this->error('Індексацію перервано: '.$e->getMessage());
            $this->line('Псевдонім індексу не змінено.');

            return self::FAILURE;
        }

        $this->info(sprintf('Готово: %d документів, псевдонім "%s".', array_sum($counts), $client->alias()));

        return self::SUCCESS;
    }
}
