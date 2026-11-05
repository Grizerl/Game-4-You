<?php

namespace App\Services\Search;

use App\Models\Article;
use App\Models\Category;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Перетворює модель на документ індексу. Повертає null, якщо модель не підлягає індексації
 * (наприклад, новина-чернетка чи запланована).
 */
class DocumentMapper
{
    private const BODY_LIMIT = 5000;

    private const SUMMARY_LIMIT = 220;

    /**
     * @return array<string, mixed>|null
     */
    public function map(Model $model): ?array
    {
        return match (true) {
            $model instanceof Game => $this->game($model),
            $model instanceof Category => $this->category($model),
            $model instanceof Creator => $this->creator($model),
            $model instanceof Company => $this->company($model),
            $model instanceof Article => $this->article($model),
            default => null,
        };
    }

    public function type(Model $model): ?string
    {
        $type = array_search($model::class, (array) config('search.models'), true);

        return $type === false ? null : (string) $type;
    }

    public static function documentId(string $type, int|string $id): string
    {
        return $type.'-'.$id;
    }

    /**
     * Eager-load зв'язків, потрібних мапперу, щоб уникнути N+1 під час перебудови.
     *
     * @return list<string>
     */
    public static function relationsFor(string $type): array
    {
        return match ($type) {
            'game' => ['category', 'creator', 'company'],
            'creator' => ['company'],
            'news' => ['tags'],
            default => [],
        };
    }

    // ---------- типи ----------

    /**
     * @return array<string, mixed>
     */
    private function game(Game $game): array
    {
        $platforms = (string) $game->platforms;

        return $this->document('game', $game, [
            'title' => $this->translations($game, 'name'),
            'body' => $this->clean($this->translations($game, 'description')),
            'extra' => $this->merge(
                $this->translations($game->category, 'title'),
                $game->creator ? $this->same($game->creator->full_name) : [],
                $game->company ? $this->translations($game->company, 'name') : [],
                $this->same($platforms),
            ),
            'card' => [
                'summary' => $this->summary($this->translations($game, 'description')),
                'label' => $this->translations($game->category, 'title'),
                'image' => $game->cover_image,
                'rating' => $game->rating,
            ],
        ], $game->released_at?->toIso8601String());
    }

    /**
     * @return array<string, mixed>
     */
    private function category(Category $category): array
    {
        return $this->document('category', $category, [
            'title' => $this->translations($category, 'title'),
            'card' => ['summary' => [], 'label' => [], 'image' => null],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function creator(Creator $creator): array
    {
        $roles = $this->translations($creator, 'role');

        return $this->document('creator', $creator, [
            'title' => $this->same($creator->full_name),
            'body' => $this->clean($this->translations($creator, 'bio')),
            'extra' => $this->merge(
                $roles,
                $this->translations($creator, 'country'),
                $creator->company ? $this->translations($creator->company, 'name') : [],
            ),
            'card' => [
                'summary' => $this->summary($this->translations($creator, 'bio')),
                'label' => $roles,
                'image' => $creator->avatar,
            ],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function company(Company $company): array
    {
        $country = $this->translations($company, 'country');

        return $this->document('company', $company, [
            'title' => $this->translations($company, 'name'),
            'body' => $this->clean($this->translations($company, 'description')),
            'extra' => $this->merge($country, $this->same((string) $company->founded_year)),
            'card' => [
                'summary' => $this->summary($this->translations($company, 'description')),
                'label' => $country,
                'image' => $company->logo_path,
            ],
        ]);
    }

    /**
     * @return array<string, mixed>|null
     */
    private function article(Article $article): ?array
    {
        if (! $article->isPublished()) {
            return null;
        }

        $tags = [];
        foreach ($article->tags as $tag) {
            $tags = $this->merge($tags, $this->translations($tag, 'name'));
        }

        $excerpt = $this->translations($article, 'excerpt');
        $body = [];
        foreach ($this->locales() as $locale) {
            $text = trim(($excerpt[$locale] ?? '').' '.$this->markdown($this->translations($article, 'body')[$locale] ?? ''));
            if ($text !== '') {
                $body[$locale] = Str::limit($text, self::BODY_LIMIT, '');
            }
        }

        return $this->document('news', $article, [
            'title' => $this->translations($article, 'title'),
            'body' => $body,
            'extra' => $tags,
            'card' => [
                'summary' => $this->summary($excerpt),
                'label' => $this->translations($article->tags->first(), 'name'),
                'image' => $article->cover_image,
            ],
        ], $article->published_at?->toIso8601String());
    }

    // ---------- допоміжне ----------

    /**
     * @param  array<string, mixed>  $parts
     * @return array<string, mixed>
     */
    private function document(string $type, Model $model, array $parts, ?string $publishedAt = null): array
    {
        return array_filter([
            'type' => $type,
            'model_id' => (string) $model->getKey(),
            'slug' => $model->getAttribute('slug'),
            'published_at' => $publishedAt,
            'title' => $parts['title'] ?? [],
            'body' => $parts['body'] ?? [],
            'extra' => $parts['extra'] ?? [],
            'card' => $parts['card'] ?? [],
        ], fn (mixed $value): bool => $value !== null);
    }

    /**
     * Переклади поля як [locale => текст]; порожні значення відкидаються.
     *
     * @return array<string, string>
     */
    private function translations(?Model $model, string $field): array
    {
        if ($model === null) {
            return [];
        }

        $result = [];
        foreach ($this->locales() as $locale) {
            $value = $model->getTranslation($field, $locale, false);

            if (is_string($value) && trim($value) !== '') {
                $result[$locale] = trim($value);
            }
        }

        return $result;
    }

    /**
     * @return array<string, string>
     */
    private function same(string $value): array
    {
        $value = trim($value);

        return $value === '' ? [] : array_fill_keys($this->locales(), $value);
    }

    /**
     * Зливає кілька мап [locale => текст] у одну, з'єднуючи значення пробілом.
     *
     * @param  array<string, string>  ...$maps
     * @return array<string, string>
     */
    private function merge(array ...$maps): array
    {
        $result = [];

        foreach ($maps as $map) {
            foreach ($map as $locale => $text) {
                $result[$locale] = trim(($result[$locale] ?? '').' '.$text);
            }
        }

        return $result;
    }

    /**
     * @param  array<string, string>  $texts
     * @return array<string, string>
     */
    private function clean(array $texts): array
    {
        return array_map(fn (string $text): string => Str::limit($this->plain($text), self::BODY_LIMIT, ''), $texts);
    }

    /**
     * @param  array<string, string>  $texts
     * @return array<string, string>
     */
    private function summary(array $texts): array
    {
        return array_map(fn (string $text): string => Str::limit($this->plain($text), self::SUMMARY_LIMIT), $texts);
    }

    private function plain(string $text): string
    {
        return trim((string) preg_replace('/\s+/u', ' ', strip_tags($text)));
    }

    private function markdown(string $markdown): string
    {
        if (trim($markdown) === '') {
            return '';
        }

        return $this->plain(Str::markdown($markdown, ['html_input' => 'strip', 'allow_unsafe_links' => false]));
    }

    /**
     * @return list<string>
     */
    private function locales(): array
    {
        return (array) config('search.locales');
    }
}
