<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * Перетворює збережений шлях зображення на URL: повний URL лишається як є,
 * статичні файли з `public/` (сід-дані) віддаються через asset(),
 * а файли, завантажені з адмінки, лежать на диску `public` (`storage/`).
 */
final class PublicImage
{
    public static function url(?string $path, ?string $placeholder = null): ?string
    {
        if (blank($path)) {
            return $placeholder === null ? null : asset($placeholder);
        }

        return match (true) {
            Str::startsWith($path, ['http://', 'https://']) => $path,
            Str::startsWith($path, ['/', 'assets/', 'uploads/']) => asset(ltrim($path, '/')),
            default => asset('storage/'.$path),
        };
    }

    /**
     * URL легкого WebP-варіанта шириною $width (див. ImageVariants); якщо варіант ще не згенеровано —
     * URL оригіналу.
     */
    public static function variant(?string $path, int $width, ?string $placeholder = null): ?string
    {
        if (filled($path) && ImageVariants::exists($path, $width)) {
            return asset(ImageVariants::relativePath($path, $width));
        }

        return self::url($path, $placeholder);
    }
}
