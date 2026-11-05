<?php

namespace App\Models;

use App\Support\PublicImage;
use App\Support\SocialLinks;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Company extends Model
{
    use HasFactory, HasTranslations;

    public const SORTS = ['new', 'games', 'name'];

    public const PLACEHOLDER_LOGO = 'assets/images/companies/placeholder.svg';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'country',
        'founded_year',
        'socials',
        'logo_path',
    ];

    public $translatable = ['name', 'description', 'country'];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'country' => 'array',
        'socials' => 'array',
        'founded_year' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $company): void {
            if (blank($company->slug)) {
                $names = array_filter($company->getTranslations('name'), 'filled');
                $name = $names['en'] ?? (string) (reset($names) ?: '');

                $company->slug = static::uniqueSlug($name);
            }
        });
    }

    public static function uniqueSlug(string $name): string
    {
        $base = Str::slug($name, '-', 'uk') ?: 'company';
        $slug = $base;

        for ($suffix = 2; static::where('slug', $slug)->exists(); $suffix++) {
            $slug = $base.'-'.$suffix;
        }

        return $slug;
    }

    /**
     * Творці студії (команда).
     */
    public function creator(): HasMany
    {
        return $this->hasMany(Creator::class);
    }

    public function creators(): HasMany
    {
        return $this->creator();
    }

    /**
     * Ігри студії (Game.company_id).
     */
    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'company_id');
    }

    protected function logoUrl(): Attribute
    {
        return Attribute::get(fn (): string => PublicImage::url($this->logo_path, self::PLACEHOLDER_LOGO));
    }

    /**
     * @return array<string, string>
     */
    public function socialLinks(): array
    {
        return SocialLinks::safe($this->socials);
    }

    /**
     * Унікальні країни поточної мови.
     *
     * @return Collection<int, string>
     */
    public static function countryOptions(): Collection
    {
        return static::query()->select('country')->get()
            ->map(fn (self $company): string => trim((string) $company->country))
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
            $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(name, ?)) COLLATE utf8mb4_unicode_ci like ?', [self::jsonPath(), $like])
                ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.en')) COLLATE utf8mb4_unicode_ci like ?", [$like]);
        });
    }

    public function scopeInCountry(Builder $query, ?string $country): Builder
    {
        $country = trim((string) $country);

        return $country === ''
            ? $query
            : $query->whereRaw('JSON_UNQUOTE(JSON_EXTRACT(country, ?)) = ?', [self::jsonPath(), $country]);
    }

    public function scopeSortedBy(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'games' => $query
                ->orderByDesc(Game::query()->selectRaw('count(*)')->whereColumn('games.company_id', 'companies.id'))
                ->orderByRaw('JSON_UNQUOTE(JSON_EXTRACT(name, ?)) COLLATE utf8mb4_unicode_ci', [self::jsonPath()]),
            'name' => $query->orderByRaw('JSON_UNQUOTE(JSON_EXTRACT(name, ?)) COLLATE utf8mb4_unicode_ci', [self::jsonPath()]),
            default => $query->orderByDesc('id'),
        };
    }
}
