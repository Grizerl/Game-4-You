<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Полегшені WebP-варіанти обкладинок: оригінали бувають по 1–15 МБ, а в картках вони показуються
 * 300–640 px завширшки. Варіанти лежать у `public/assets/_v/{ширина}/{хеш}.webp` (у .gitignore) і
 * генеруються командою `images:optimize` та під час завантаження з адмінки. Поки варіанта немає,
 * PublicImage::variant() віддає оригінал, тож сторінки працюють і без генерації.
 */
final class ImageVariants
{
    /** Ширини варіантів: картки/постери (2× від 300 px) і великі банери. */
    public const WIDTHS = [640, 1280];

    private const QUALITY = 80;

    public static function relativePath(string $stored, int $width): string
    {
        return 'assets/_v/'.$width.'/'.md5(ltrim($stored, '/')).'.webp';
    }

    /** Абсолютний шлях локального файлу за збереженим значенням (null — зовнішній URL чи файлу немає). */
    public static function sourcePath(?string $stored): ?string
    {
        if (blank($stored) || Str::startsWith($stored, ['http://', 'https://'])) {
            return null;
        }

        $path = Str::startsWith($stored, ['/', 'assets/', 'uploads/'])
            ? public_path(ltrim($stored, '/'))
            : Storage::disk('public')->path($stored);

        return is_file($path) ? $path : null;
    }

    public static function exists(string $stored, int $width): bool
    {
        return is_file(public_path(self::relativePath($stored, $width)));
    }

    /**
     * Створює (або оновлює, якщо оригінал новіший) усі варіанти для файлу.
     *
     * @return int кількість створених/оновлених файлів
     */
    public static function generate(?string $stored): int
    {
        $source = self::sourcePath($stored);
        if ($source === null || ! function_exists('imagewebp')) {
            return 0;
        }

        $info = @getimagesize($source);
        $loader = match ($info[2] ?? null) {
            IMAGETYPE_JPEG => 'imagecreatefromjpeg',
            IMAGETYPE_PNG => 'imagecreatefrompng',
            IMAGETYPE_WEBP => 'imagecreatefromwebp',
            default => null,
        };
        if ($loader === null) {
            return 0;
        }

        $todo = array_filter(
            self::WIDTHS,
            fn (int $w): bool => ! is_file($t = public_path(self::relativePath($stored, $w))) || filemtime($t) < filemtime($source),
        );
        if ($todo === []) {
            return 0;
        }

        // Розпакований великий JPEG може займати сотні МБ.
        @ini_set('memory_limit', '1536M');

        $image = @$loader($source);
        if ($image === false) {
            return 0;
        }
        imagepalettetotruecolor($image);

        $created = 0;
        foreach ($todo as $width) {
            $target = public_path(self::relativePath($stored, $width));
            if (! is_dir(dirname($target))) {
                mkdir(dirname($target), 0775, true);
            }

            $scaled = $info[0] > $width ? imagescale($image, $width, -1, IMG_BICUBIC) : $image;
            if ($scaled !== false) {
                imagealphablending($scaled, false);
                imagesavealpha($scaled, true);
                $created += imagewebp($scaled, $target, self::QUALITY) ? 1 : 0;
            }
            if ($scaled !== $image && $scaled !== false) {
                imagedestroy($scaled);
            }
        }
        imagedestroy($image);

        return $created;
    }
}
