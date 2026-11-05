<?php

namespace App\Support;

use App\Models\Setting;

/**
 * Розміри (ширина, px) мініатюр зображень, що задаються в адмінці («Налаштування → Розміри зображень»).
 * Читаються під час генерації conversions Media Library; без збереженого значення діє дефолт.
 */
final class ImageSizes
{
    public const KEY = 'image_sizes';

    public const MIN = 100;

    public const MAX = 3000;

    /** Дефолти: обкладинки — thumb/large для десктопа й мобільного, аватари й логотипи — одна ширина. */
    public const DEFAULTS = [
        'cover.thumb.desktop' => 640,
        'cover.thumb.mobile' => 360,
        'cover.large.desktop' => 1280,
        'cover.large.mobile' => 720,
        'avatar.thumb' => 480,
        'logo.thumb' => 480,
    ];

    /** @var array<string, int>|null */
    private static ?array $memo = null;

    public static function width(string $key): int
    {
        return self::all()[$key] ?? self::DEFAULTS[$key];
    }

    /**
     * @return array<string, int>
     */
    public static function all(): array
    {
        if (self::$memo === null) {
            $stored = Setting::query()->where('key', self::KEY)->value('value');
            $stored = is_array($stored) ? $stored : [];

            self::$memo = collect(self::DEFAULTS)
                ->map(fn (int $default, string $key): int => self::sanitize($stored[$key] ?? null, $default))
                ->all();
        }

        return self::$memo;
    }

    /**
     * @param  array<string, mixed>  $sizes
     */
    public static function save(array $sizes): void
    {
        $values = collect(self::DEFAULTS)
            ->map(fn (int $default, string $key): int => self::sanitize($sizes[$key] ?? null, $default))
            ->all();

        Setting::query()->updateOrCreate(['key' => self::KEY], ['value' => $values]);

        self::forget();
    }

    /** Скидає кеш у памʼяті (тести, зміна налаштувань у межах одного процесу). */
    public static function forget(): void
    {
        self::$memo = null;
    }

    private static function sanitize(mixed $value, int $default): int
    {
        $int = filter_var($value, FILTER_VALIDATE_INT);

        return $int !== false && $int >= self::MIN && $int <= self::MAX ? $int : $default;
    }
}
