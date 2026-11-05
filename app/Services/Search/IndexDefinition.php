<?php

namespace App\Services\Search;

/**
 * Налаштування й мапінг індексу. Українські текстові поля використовують аналізатор
 * плагіна `analysis-ukrainian`, англійські — вбудований `english`; підполе `.ngram` — для підказок.
 */
final class IndexDefinition
{
    /**
     * @return array<string, mixed>
     */
    public static function body(): array
    {
        return [
            'settings' => [
                'number_of_shards' => 1,
                'number_of_replicas' => 0,
                'analysis' => [
                    'filter' => [
                        'edge_filter' => ['type' => 'edge_ngram', 'min_gram' => 2, 'max_gram' => 15],
                    ],
                    'analyzer' => [
                        'autocomplete' => [
                            'type' => 'custom',
                            'tokenizer' => 'standard',
                            'filter' => ['lowercase', 'edge_filter'],
                        ],
                        'autocomplete_search' => [
                            'type' => 'custom',
                            'tokenizer' => 'standard',
                            'filter' => ['lowercase'],
                        ],
                    ],
                ],
            ],
            'mappings' => [
                'dynamic' => 'strict',
                'properties' => [
                    'type' => ['type' => 'keyword'],
                    'model_id' => ['type' => 'keyword'],
                    'slug' => ['type' => 'keyword'],
                    'published_at' => ['type' => 'date'],
                    'title' => self::localized(withNgram: true),
                    'body' => self::localized(),
                    'extra' => self::localized(),
                    // Дані для картки результату; не індексуються, лише зберігаються в _source.
                    'card' => ['type' => 'object', 'enabled' => false],
                ],
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private static function localized(bool $withNgram = false): array
    {
        $field = fn (string $analyzer): array => array_filter([
            'type' => 'text',
            'analyzer' => $analyzer,
            'fields' => $withNgram ? [
                'ngram' => [
                    'type' => 'text',
                    'analyzer' => 'autocomplete',
                    'search_analyzer' => 'autocomplete_search',
                ],
            ] : null,
        ]);

        return [
            'properties' => [
                'uk' => $field('ukrainian'),
                'en' => $field('english'),
            ],
        ];
    }
}
