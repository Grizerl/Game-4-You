<?php

namespace App\Services\Search;

use Elastic\Elasticsearch\Client;

/**
 * Пошук для випадаючого списку в шапці: єдиний рейтинг по всіх типах сутностей.
 */
class SearchService
{
    public function __construct(private readonly SearchClient $client) {}

    public function enabled(): bool
    {
        return $this->client->enabled();
    }

    /**
     * @return list<SearchResult>
     *
     * @throws SearchUnavailableException
     */
    public function suggest(string $query, string $locale): array
    {
        $response = $this->client->call(fn (Client $es) => $es->search([
            'index' => $this->client->alias(),
            'body' => [
                'size' => (int) config('search.suggest_limit'),
                '_source' => ['type', 'model_id', 'slug', 'title', 'card.label'],
                'query' => ['bool' => ['should' => [
                    // Повнотекстовий збіг: словоформи, одна помилка, назви/додаткові поля/опис.
                    ['multi_match' => [
                        'query' => $query,
                        'type' => 'best_fields',
                        'fields' => [
                            'title.'.$locale.'^6',
                            'title.uk^4',
                            'title.en^4',
                            'extra.uk^2',
                            'extra.en^2',
                            'body.uk',
                            'body.en',
                        ],
                        'fuzziness' => 'AUTO',
                        'prefix_length' => 1,
                        'minimum_should_match' => '75%',
                    ]],
                    // Початок слова в назві (поки відвідувач ще друкує).
                    ['multi_match' => [
                        'query' => $query,
                        'type' => 'best_fields',
                        'operator' => 'and',
                        'fields' => ['title.'.$locale.'.ngram^2', 'title.uk.ngram', 'title.en.ngram'],
                    ]],
                ], 'minimum_should_match' => 1]],
            ],
        ]));

        return array_map(
            fn (array $hit): SearchResult => SearchResult::fromHit($hit, $locale),
            $response['hits']['hits'] ?? [],
        );
    }
}
