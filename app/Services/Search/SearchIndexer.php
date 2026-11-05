<?php

namespace App\Services\Search;

use Elastic\Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;
use Throwable;

/**
 * Наповнення індексу: точкова (ре)індексація моделей і повна перебудова з перемиканням псевдоніма.
 */
class SearchIndexer
{
    private readonly SearchClient $client;

    public function __construct(SearchClient $client, private readonly DocumentMapper $mapper)
    {
        $this->client = $client->forIndexing();
    }

    /**
     * Індексує модель або видаляє її документ, якщо вона не підлягає індексації.
     */
    public function sync(Model $model): void
    {
        $type = $this->mapper->type($model);

        if ($type === null) {
            return;
        }

        $document = $this->mapper->map($model);

        if ($document === null) {
            $this->delete($type, $model->getKey());

            return;
        }

        // require_alias: до першої повної індексації псевдоніма ще немає, і Elasticsearch не має створювати
        // звичайний індекс з таким самим іменем (він заблокував би перемикання псевдоніма).
        $this->client->callOrNull(fn (Client $es) => $es->index([
            'index' => $this->client->alias(),
            'id' => DocumentMapper::documentId($type, $model->getKey()),
            'body' => $document,
            'refresh' => false,
            'require_alias' => true,
        ]));
    }

    public function delete(string $type, int|string $id): void
    {
        $this->client->callOrNull(fn (Client $es) => $es->delete([
            'index' => $this->client->alias(),
            'id' => DocumentMapper::documentId($type, $id),
            'refresh' => false,
        ]));
    }

    /**
     * @param  iterable<Model>  $models
     */
    public function syncMany(iterable $models): int
    {
        $body = [];
        $count = 0;

        foreach ($models as $model) {
            $type = $this->mapper->type($model);
            $document = $type === null ? null : $this->mapper->map($model);

            if ($document === null) {
                continue;
            }

            $body[] = ['index' => ['_index' => $this->client->alias(), '_id' => DocumentMapper::documentId($type, $model->getKey())]];
            $body[] = $document;
            $count++;
        }

        if ($body !== []) {
            $this->bulk($body, $this->client->alias(), aliasTarget: true);
        }

        return $count;
    }

    /**
     * Ідентифікатори (з переданих), для яких у індексі ще немає документа.
     *
     * @param  list<int|string>  $ids
     * @return list<int|string>
     */
    public function missingIds(string $type, array $ids): array
    {
        if ($ids === []) {
            return [];
        }

        $docs = $this->client->callOrNull(fn (Client $es) => $es->mget([
            'index' => $this->client->alias(),
            'body' => ['ids' => array_map(fn ($id): string => DocumentMapper::documentId($type, $id), $ids)],
            '_source' => false,
        ]));

        if ($docs === null) {
            return $ids;
        }

        $found = [];
        foreach ($docs['docs'] ?? [] as $doc) {
            if (($doc['found'] ?? false) === true) {
                $found[] = $doc['_id'];
            }
        }

        return array_values(array_filter(
            $ids,
            fn ($id): bool => ! in_array(DocumentMapper::documentId($type, $id), $found, true),
        ));
    }

    /**
     * Повна перебудова: новий версійований індекс → наповнення → атомарне перемикання псевдоніма →
     * видалення старих індексів. При помилці псевдонім не змінюється, а новий індекс видаляється.
     *
     * @param  (callable(string $type, int $count): void)|null  $progress
     * @return array<string, int> Кількість документів за типами.
     */
    public function reindex(?callable $progress = null, bool $keepPrevious = false): array
    {
        $alias = $this->client->alias();
        $index = $alias.'_v'.now()->format('YmdHis').random_int(10, 99);

        $this->client->call(fn (Client $es) => $es->indices()->create(['index' => $index, 'body' => IndexDefinition::body()]));

        $counts = [];

        try {
            foreach ((array) config('search.models') as $type => $class) {
                $counts[$type] = $this->fill($index, (string) $type, $class, $progress);
            }

            $this->client->call(fn (Client $es) => $es->indices()->refresh(['index' => $index]));
        } catch (Throwable $e) {
            $this->client->callOrNull(fn (Client $es) => $es->indices()->delete(['index' => $index]));

            throw $e;
        }

        $this->swapAlias($alias, $index, $keepPrevious);

        return $counts;
    }

    /**
     * @param  class-string<Model>  $class
     * @param  (callable(string, int): void)|null  $progress
     */
    private function fill(string $index, string $type, string $class, ?callable $progress): int
    {
        $total = 0;

        $query = $class::query()->with(DocumentMapper::relationsFor($type));

        $query->chunkById((int) config('search.reindex_chunk'), function ($models) use ($index, $type, &$total): void {
            $body = [];

            foreach ($models as $model) {
                $document = $this->mapper->map($model);

                if ($document === null) {
                    continue;
                }

                $body[] = ['index' => ['_index' => $index, '_id' => DocumentMapper::documentId($type, $model->getKey())]];
                $body[] = $document;
                $total++;
            }

            if ($body !== []) {
                $this->bulk($body, $index);
            }
        });

        if ($progress !== null) {
            $progress($type, $total);
        }

        return $total;
    }

    /**
     * @param  list<array<string, mixed>>  $body
     */
    private function bulk(array $body, string $index, bool $aliasTarget = false): void
    {
        $params = ['body' => $body, 'refresh' => false] + ($aliasTarget ? ['require_alias' => true] : []);
        $response = $aliasTarget
            ? $this->client->callOrNull(fn (Client $es) => $es->bulk($params))
            : $this->client->call(fn (Client $es) => $es->bulk($params));

        if ($response === null) {
            return; // псевдонім ще не створено — дочекаємось search:reindex
        }

        if (($response['errors'] ?? false) === true) {
            $reason = 'unknown';

            foreach ($response['items'] ?? [] as $item) {
                $error = $item['index']['error'] ?? null;

                if ($error !== null && ! ($aliasTarget && ($error['type'] ?? '') === 'index_not_found_exception')) {
                    $reason = json_encode($error, JSON_UNESCAPED_UNICODE);
                    break;
                }
            }

            throw new SearchUnavailableException('Bulk indexing into '.$index.' failed: '.$reason);
        }
    }

    private function swapAlias(string $alias, string $newIndex, bool $keepPrevious): void
    {
        $old = $this->aliasedIndices($alias);

        // Звичайний індекс з іменем псевдоніма (автостворений раніше) блокує перемикання — видаляємо його.
        if ($old === [] && $this->client->call(fn (Client $es) => $es->indices()->exists(['index' => $alias]))->asBool()) {
            $this->client->callOrNull(fn (Client $es) => $es->indices()->delete(['index' => $alias]));
        }

        $actions = array_map(fn (string $name): array => ['remove' => ['index' => $name, 'alias' => $alias]], $old);
        $actions[] = ['add' => ['index' => $newIndex, 'alias' => $alias]];

        $this->client->call(fn (Client $es) => $es->indices()->updateAliases(['body' => ['actions' => $actions]]));

        if (! $keepPrevious) {
            foreach ($old as $name) {
                $this->client->callOrNull(fn (Client $es) => $es->indices()->delete(['index' => $name]));
            }
        }

        $this->deleteStale($alias, $newIndex, $old, $keepPrevious);
    }

    /**
     * Прибирає версійовані індекси, що лишилися від перерваних перебудов.
     *
     * @param  list<string>  $previous
     */
    private function deleteStale(string $alias, string $current, array $previous, bool $keepPrevious): void
    {
        $all = $this->client->callOrNull(fn (Client $es) => $es->indices()->get(['index' => $alias.'_v*']));

        foreach (array_keys($all?->asArray() ?? []) as $name) {
            if ($name === $current || ($keepPrevious && in_array($name, $previous, true))) {
                continue;
            }

            $this->client->callOrNull(fn (Client $es) => $es->indices()->delete(['index' => $name]));
        }
    }

    /**
     * @return list<string>
     */
    private function aliasedIndices(string $alias): array
    {
        $response = $this->client->callOrNull(fn (Client $es) => $es->indices()->getAlias(['name' => $alias]));

        return $response === null ? [] : array_keys($response->asArray());
    }
}
