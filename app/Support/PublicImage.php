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
            Str::startsWith($path, ['/', 'assets/']) => asset(ltrim($path, '/')),
            default => asset('storage/'.$path),
        };
    }
}
