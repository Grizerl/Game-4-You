<?php

namespace App\Models;

use App\Models\Concerns\HasImageMedia;
use App\Support\PublicImage;
use App\Support\YouTube;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Translatable\HasTranslations;

class Game extends Model implements HasMedia
{
    use HasFactory, HasImageMedia, HasTranslations;

    public const SORTS = ['new', 'rating', 'name'];

    public const MAX_SCREENSHOTS = 6;

    public const PLACEHOLDER_COVER = 'assets/images/games/placeholder.svg';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image',
        'rating',
        'platforms',
        'released_at',
        'trailer_url',
        'screenshots',
        'isNew',
        'category_id',
        'creator_id',
        'company_id',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'screenshots' => 'array',
        'released_at' => 'date',
        'isNew' => 'boolean',
    ];

    public $translatable = ['name', 'description'];

    protected static function booted(): void
    {
        static::creating(function (self $game): void {
            if (blank($game->slug)) {
                $names = array_filter($game->getTranslations('name'), 'filled');
                $name = $names['en'] ?? (string) (reset($names) ?: '');

                $game->slug = static::uniqueSlug($name);
            }
        });
    }

    public static function uniqueSlug(string $name): string
    {
        $base = Str::slug($name, '-', 'uk') ?: 'game';

        // Суто числовий slug конфліктував би зі старими адресами за id.
        if (ctype_digit($base)) {
            $base = 'game-'.$base;
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

    /**
     * Сторінка гри відкривається за slug; старі числові адреси (`/games/12`) теж знаходять гру,
     * а контролер перенаправляє їх на канонічний slug.
     */
    public function resolveRouteBinding($value, $field = null): ?Model
    {
        $game = $this->where($field ?? 'slug', $value)->first();

        if ($game === null && $field === null && is_string($value) && ctype_digit($value)) {
            $game = $this->whereKey((int) $value)->first();
        }

        return $game;
    }

    /**
     * @return list<string>
     */
    public function screenshotUrls(): array
    {
        return collect($this->screenshots ?? [])
            ->filter(fn (mixed $path): bool => is_string($path) && $path !== '')
            ->map(fn (string $path): string => (string) PublicImage::url($path))
            ->values()
            ->all();
    }

    /**
     * Платформи як список (значення — перелік через кому).
     *
     * @return list<string>
     */
    public function platformList(): array
    {
        return array_values(array_filter(array_map('trim', explode(',', (string) $this->platforms))));
    }

    public function trailerId(): ?string
    {
        return YouTube::id($this->trailer_url);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class, 'creator_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'game_id');
    }

    /**
     * Унікальні платформи (токени) усіх ігор.
     *
     * @return Collection<int, string>
     */
    public static function platformOptions(): Collection
    {
        return static::query()->whereNotNull('platforms')->pluck('platforms')
            ->flatMap(fn (string $platforms): array => explode(',', $platforms))
            ->map(fn (string $platform): string => trim($platform))
            ->filter()
            ->unique()
            ->sort(SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
    }

    private static function jsonPath(): string
    {
        return '$."'.preg_replace('/[^A-Za-z_-]/', '', app()->getLocale()).'"';
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        if ($term === '') {
            return $query;
        }

        $like = '%'.addcslashes($term, '\\%_').'%';

        return $query->where(function (Builder $query) use ($like): void {
            $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(games.name, ?)) COLLATE utf8mb4_unicode_ci like ?', [self::jsonPath(), $like])
                ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(games.name, '$.en')) COLLATE utf8mb4_unicode_ci like ?", [$like]);
        });
    }

    public function scopeInCategory(Builder $query, ?int $categoryId): Builder
    {
        return $categoryId ? $query->where('category_id', $categoryId) : $query;
    }

    public function scopeOnPlatform(Builder $query, ?string $platform): Builder
    {
        $platform = trim((string) $platform);

        return $platform === ''
            ? $query
            : $query->whereRaw("CONCAT(',', REPLACE(platforms, ', ', ','), ',') like ?", ['%,'.addcslashes($platform, '\\%_').',%']);
    }

    public function scopeSortedBy(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'rating' => $query->orderByDesc('rating')->orderByDesc('id'),
            'name' => $query->orderByRaw('JSON_UNQUOTE(JSON_EXTRACT(games.name, ?)) COLLATE utf8mb4_unicode_ci', [self::jsonPath()]),
            default => $query->orderByRaw('COALESCE(released_at, DATE(created_at)) DESC')->orderByDesc('id'),
        };
    }

    public static function imageCollectionName(): string
    {
        return 'cover';
    }

    public function legacyImageColumn(): string
    {
        return 'cover_image';
    }

    /** @return array<string, string> */
    protected function imageSizeKeys(): array
    {
        return [
            'thumb' => 'cover.thumb.desktop',
            'thumb_mobile' => 'cover.thumb.mobile',
            'large' => 'cover.large.desktop',
            'large_mobile' => 'cover.large.mobile',
        ];
    }

    protected function imagePlaceholder(): string
    {
        return self::PLACEHOLDER_COVER;
    }

    /** Оригінал (для og:image та структурованих даних). */
    protected function coverUrl(): Attribute
    {
        return Attribute::get(fn (): string => $this->imageUrl());
    }

    /** Легкий WebP для карток, списків і мініатюр. */
    protected function coverThumbUrl(): Attribute
    {
        return Attribute::get(fn (): string => $this->imageUrl('thumb'));
    }

    /** Легкий WebP для великих банерів. */
    protected function coverLargeUrl(): Attribute
    {
        return Attribute::get(fn (): string => $this->imageUrl('large'));
    }
}
