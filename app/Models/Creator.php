<?php

namespace App\Models;

use App\Support\PublicImage;
use App\Support\SocialLinks;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

/**
 * Лічильник ігор береться лише через `withCount('games')`: його аліас `games_count`
 * збігається з назвою застарілої колонки і перекриває збережене значення.
 */
class Creator extends Model
{
    use HasFactory, HasTranslations;

    public const SOCIAL_KEYS = SocialLinks::KEYS;

    public const SORTS = ['new', 'games', 'name'];

    public const PLACEHOLDER_AVATAR = 'assets/images/creators/placeholder.svg';

    protected $fillable = [
        'first_name',
        'last_name',
        'slug',
        'avatar',
        'bio',
        'role',
        'country',
        'career_start',
        'socials',
        'company_id',
    ];

    public $translatable = ['bio', 'role', 'country'];

    protected $casts = [
        'bio' => 'array',
        'role' => 'array',
        'country' => 'array',
        'socials' => 'array',
        'career_start' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $creator): void {
            if (blank($creator->slug)) {
                $creator->slug = static::uniqueSlug($creator->first_name, $creator->last_name);
            }
        });
    }

    public static function uniqueSlug(string $firstName, ?string $lastName = null): string
    {
        $base = Str::slug(trim($firstName.' '.$lastName), '-', 'uk') ?: 'creator';
        $slug = $base;

        for ($suffix = 2; static::where('slug', $slug)->exists(); $suffix++) {
            $slug = $base.'-'.$suffix;
        }

        return $slug;
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'creator_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    protected function fullName(): Attribute
    {
        return Attribute::get(fn (): string => trim($this->first_name.' '.$this->last_name));
    }

    /**
     * Єдине місце, де визначається URL фото: плейсхолдер, статичний файл із
     * `public/` (сід-дані) або файл, завантажений з адмінки на диск `public`.
     */
    protected function avatarUrl(): Attribute
    {
        return Attribute::get(fn (): string => PublicImage::url($this->avatar, self::PLACEHOLDER_AVATAR));
    }

    /**
     * Ролі як список (значення `role` — перелік через кому).
     *
     * @return list<string>
     */
    public function roleList(): array
    {
        return array_values(array_filter(array_map('trim', explode(',', (string) $this->role))));
    }

    /**
     * Соціальні посилання, придатні для виводу: лише відомі ключі та лише http(s).
     *
     * @return array<string, string>
     */
    public function socialLinks(): array
    {
        return SocialLinks::safe($this->socials);
    }

    /**
     * Унікальні ролі поточної мови (значення `role` — список через кому).
     *
     * @return Collection<int, string>
     */
    public static function roleOptions(): Collection
    {
        return static::query()->select('role')->get()
            ->flatMap(fn (self $creator): array => explode(',', (string) $creator->role))
            ->map(fn (string $role): string => trim($role))
            ->filter()
            ->unique()
            ->sort(SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        if ($term === '') {
            return $query;
        }

        $like = '%'.addcslashes($term, '\\%_').'%';

        return $query->where(function (Builder $query) use ($like): void {
            $query->where('first_name', 'like', $like)
                ->orWhere('last_name', 'like', $like)
                ->orWhereRaw("CONCAT_WS(' ', first_name, last_name) like ?", [$like]);
        });
    }

    public function scopeForCompany(Builder $query, ?int $companyId): Builder
    {
        return $companyId ? $query->where('company_id', $companyId) : $query;
    }

    public function scopeWithRole(Builder $query, ?string $role): Builder
    {
        $role = trim((string) $role);

        if ($role === '') {
            return $query;
        }

        $path = '$."'.preg_replace('/[^A-Za-z_-]/', '', app()->getLocale()).'"';

        return $query->whereRaw(
            "CONCAT(',', REPLACE(JSON_UNQUOTE(JSON_EXTRACT(role, ?)), ', ', ','), ',') like ?",
            [$path, '%,'.addcslashes($role, '\\%_').',%']
        );
    }

    public function scopeSortedBy(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'games' => $query
                ->orderByDesc(Game::query()->selectRaw('count(*)')->whereColumn('games.creator_id', 'creators.id'))
                ->orderBy('first_name'),
            'name' => $query->orderBy('first_name')->orderBy('last_name'),
            default => $query->orderByDesc('id'),
        };
    }
}
