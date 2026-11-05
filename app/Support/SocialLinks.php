<?php

namespace App\Support;

/**
 * Підтримувані соціальні посилання (творці й студії) та безпечна фільтрація для виводу.
 */
final class SocialLinks
{
    public const KEYS = ['website', 'x', 'youtube', 'twitch', 'instagram'];

    /**
     * Лише відомі ключі та лише посилання зі схемою http(s).
     *
     * @param  array<string, mixed>|null  $socials
     * @return array<string, string>
     */
    public static function safe(?array $socials): array
    {
        $links = [];

        foreach (self::KEYS as $key) {
            $url = $socials[$key] ?? null;

            if (is_string($url) && in_array(strtolower((string) parse_url($url, PHP_URL_SCHEME)), ['http', 'https'], true)) {
                $links[$key] = $url;
            }
        }

        return $links;
    }
}
