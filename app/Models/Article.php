<?php

namespace App\Models;

use App\Support\PublicImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use Spatie\Translatable\HasTranslations;

class Article extends Model
{
    use HasFactory, HasTranslations;

    public const PLACEHOLDER_COVER = 'assets/images/news/placeholder.svg';

    /** Slug-и, зайняті службовими адресами (`/news/feed`). */
    public const RESERVED_SLUGS = ['feed'];

    private const WORDS_PER_MINUTE = 200;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'published_at',
    ];

    public $translatable = ['title', 'excerpt', 'body'];

    protected $casts = [
        'title' => 'array',
        'excerpt' => 'array',
        'body' => 'array',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $article): void {
            if (blank($article->slug)) {
                $titles = array_filter($article->getTranslations('title'), 'filled');
                $title = $titles['en'] ?? (string) (reset($titles) ?: '');

                $article->slug = static::uniqueSlug($title);
            }
        });
    }

    public static function uniqueSlug(string $title): string
    {
        $base = Str::slug($title, '-', 'uk') ?: 'article';

        // Службові й суто числові slug-и конфліктували б з RSS і зі старими адресами за id.
        if (in_array($base, self::RESERVED_SLUGS, true)) {
            $base .= '-news';
        }

        if (ctype_digit($base)) {
            $base = 'news-'.$base;
        }

        $slug = $base;

        for ($suffix = 2; static::where('slug', $slug)->exists(); $suffix++) {
            $slug = $base.'-'.$suffix;
        }

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'article_tag');
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'article_game');
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'article_company');
    }

    protected function coverUrl(): Attribute
    {
        return Attribute::get(fn (): string => PublicImage::url($this->cover_image, self::PLACEHOLDER_COVER));
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at->lte(now());
    }

    /**
     * @return 'draft'|'scheduled'|'published'
     */
    public function status(): string
    {
        return match (true) {
            $this->published_at === null => 'draft',
            $this->published_at->gt(now()) => 'scheduled',
            default => 'published',
        };
    }

    /**
     * Текст у безпечному Markdown: вбудований HTML ігнорується, небезпечні схеми посилань
     * блокуються, зовнішні посилання отримують rel="noopener noreferrer".
     */
    public function bodyHtml(): string
    {
        return Str::markdown((string) $this->body, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
            'external_link' => [
                'internal_hosts' => parse_url((string) config('app.url'), PHP_URL_HOST) ?: 'localhost',
                'open_in_new_window' => true,
                'html_class' => 'nw-external',
            ],
        ], [new ExternalLinkExtension]);
    }

    /**
     * Орієнтовний час читання в хвилинах (не менше однієї).
     */
    public function readingTime(): int
    {
        $words = preg_match_all('/[\p{L}\p{N}]+/u', strip_tags($this->bodyHtml()));

        return max(1, (int) ceil(($words ?: 0) / self::WORDS_PER_MINUTE));
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function scopeNewest(Builder $query): Builder
    {
        return $query->orderByDesc('published_at')->orderByDesc('id');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        if ($term === '') {
            return $query;
        }

        $like = '%'.addcslashes($term, '\\%_').'%';
        $path = '$."'.preg_replace('/[^A-Za-z_-]/', '', app()->getLocale()).'"';

        return $query->where(function (Builder $query) use ($like, $path): void {
            $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(articles.title, ?)) COLLATE utf8mb4_unicode_ci like ?', [$path, $like])
                ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(articles.title, '$.en')) COLLATE utf8mb4_unicode_ci like ?", [$like]);
        });
    }

    public function scopeWithTag(Builder $query, ?string $slug): Builder
    {
        $slug = trim((string) $slug);

        return $slug === '' ? $query : $query->whereHas('tags', fn (Builder $tags) => $tags->where('slug', $slug));
    }
}
