<?php

namespace App\Services\Search;

/**
 * Один результат пошуку для випадаючого списку: текст уже вибрано для поточної мови,
 * URL побудовано локалізованими маршрутами.
 */
final class SearchResult
{
    public function __construct(
        public readonly string $type,
        public readonly string $id,
        public readonly string $title,
        public readonly ?string $label,
        public readonly string $url,
    ) {}

    /**
     * @param  array<string, mixed>  $hit  Один елемент hits.hits відповіді Elasticsearch.
     */
    public static function fromHit(array $hit, string $locale): self
    {
        $source = (array) ($hit['_source'] ?? []);
        $type = (string) ($source['type'] ?? '');
        $label = self::pick((array) ($source['card']['label'] ?? []), $locale);

        return new self(
            type: $type,
            id: (string) ($source['model_id'] ?? ''),
            title: self::pick((array) ($source['title'] ?? []), $locale),
            label: $label !== '' ? $label : null,
            url: self::url($type, (string) ($source['slug'] ?? ''), (string) ($source['model_id'] ?? '')),
        );
    }

    /**
     * @param  array<string, mixed>  $values  [locale => текст]
     */
    private static function pick(array $values, string $locale): string
    {
        foreach ([$locale, 'uk', 'en'] as $key) {
            $value = $values[$key] ?? null;

            if (is_string($value) && trim($value) !== '') {
                return trim($value);
            }
        }

        return '';
    }

    private static function url(string $type, string $slug, string $id): string
    {
        return match ($type) {
            'game' => route('games.show.page', $slug),
            'creator' => route('creator.show.page', $slug),
            'company' => route('company.show.page', $slug),
            'news' => route('news.show.page', $slug),
            'category' => route('games.page', ['category' => $id]),
            default => route('home.page'),
        };
    }
}
