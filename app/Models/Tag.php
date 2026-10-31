<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = ['name', 'slug'];

    public $translatable = ['name'];

    protected $casts = [
        'name' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $tag): void {
            if (blank($tag->slug)) {
                $names = array_filter($tag->getTranslations('name'), 'filled');
                $tag->slug = static::slugFor($names['en'] ?? (string) (reset($names) ?: ''));
            }
        });
    }

    public static function slugFor(string $name): string
    {
        $slug = Str::slug($name, '-', 'uk') ?: 'tag';

        return ctype_digit($slug) ? 'tag-'.$slug : $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_tag');
    }

    /**
     * Розбирає рядок тегів `Назва|Name, Інша назва` на пари мов; дублікати за slug і порожні відкидаються.
     *
     * @return list<array{uk: string, en: string}>
     */
    public static function parseInput(?string $input): array
    {
        $parsed = [];

        foreach (explode(',', (string) $input) as $chunk) {
            [$uk, $en] = array_pad(array_map('trim', explode('|', $chunk, 2)), 2, '');

            $uk = $uk !== '' ? $uk : $en;
            $en = $en !== '' ? $en : $uk;

            if ($uk === '') {
                continue;
            }

            $parsed[static::slugFor($en)] ??= ['uk' => $uk, 'en' => $en];
        }

        return array_values($parsed);
    }

    /**
     * Знаходить тег за slug або створює новий.
     *
     * @param  array{uk: string, en: string}  $names
     */
    public static function resolve(array $names): self
    {
        $slug = static::slugFor($names['en']);

        return static::firstWhere('slug', $slug) ?? static::create(['name' => $names, 'slug' => $slug]);
    }
}
