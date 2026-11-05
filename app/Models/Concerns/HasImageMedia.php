<?php

namespace App\Models\Concerns;

use App\Support\ImageSizes;
use App\Support\PublicImage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Одне зображення запису (обкладинка, аватар, логотип) у Spatie Media Library з WebP-мініатюрами.
 *
 * Модель задає колекцію, стару колонку-шлях і плейсхолдер. Поки зображення не імпортовано в Media Library
 * (`php artisan media:import-legacy`) або conversion не згенеровано, віддається оригінал за старим шляхом.
 *
 * @property-read Collection<int, Media> $media
 */
trait HasImageMedia
{
    use InteractsWithMedia;

    /** Назва колекції Media Library (`cover`, `avatar`, `logo`). */
    abstract public static function imageCollectionName(): string;

    /** Колонка зі старим шляхом до файлу (запасний варіант). */
    abstract public function legacyImageColumn(): string;

    /** Шлях до плейсхолдера в `public/`. */
    abstract protected function imagePlaceholder(): string;

    /**
     * Conversions запису: ім'я conversion → ключ розміру з `ImageSizes` (налаштовується в адмінці).
     * Для обкладинок: thumb, thumb_mobile, large, large_mobile; для аватарів і логотипів — лише thumb.
     *
     * @return array<string, string>
     */
    abstract protected function imageSizeKeys(): array;

    /** Ім'я `media` додається в `$with`, щоб картки не робили запит на кожен запис. */
    public function initializeHasImageMedia(): void
    {
        if (! in_array('media', $this->with, true)) {
            $this->with[] = 'media';
        }
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(static::imageCollectionName())->singleFile();
    }

    /**
     * Conversions у WebP без збільшення (`Fit::Max`), пропорції зберігаються; ширини — з налаштувань.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        foreach ($this->imageSizeKeys() as $name => $sizeKey) {
            $width = ImageSizes::width($sizeKey);

            $this->addMediaConversion($name)
                ->performOnCollections(static::imageCollectionName())
                ->fit(Fit::Max, $width, $width * 3)
                ->format('webp')
                ->quality(80)
                ->nonQueued();
        }
    }

    /**
     * Зберігає завантажений файл із запиту в Media Library (нове замінює попереднє) і прибирає
     * старий файл за колонкою-шляхом, якщо він був завантажений з адмінки.
     */
    public function replaceImageFromRequest(string $field): void
    {
        $this->addMediaFromRequest($field)->toMediaCollection(static::imageCollectionName());

        $this->deleteLegacyImage();
    }

    /** Видаляє старий файл (лише завантажений з адмінки; сід-файли з `public/assets` не чіпає) і обнуляє колонку. */
    public function deleteLegacyImage(): void
    {
        $column = $this->legacyImageColumn();
        $path = $this->getAttribute($column);

        if (blank($path)) {
            return;
        }

        if (Str::startsWith($path, ['uploads/', '/uploads/'])) {
            @unlink(public_path(ltrim($path, '/')));
        } elseif (! Str::startsWith($path, ['http://', 'https://', 'assets/', '/assets/'])) {
            Storage::disk('public')->delete($path);
        }

        $this->forceFill([$column => null])->saveQuietly();
    }

    /** Абсолютний шлях до локального файлу за старою колонкою (null — зовнішній URL, порожнє значення чи файлу немає). */
    public function legacyImageFile(): ?string
    {
        $path = $this->getAttribute($this->legacyImageColumn());

        if (blank($path) || Str::startsWith($path, ['http://', 'https://'])) {
            return null;
        }

        $file = Str::startsWith($path, ['/', 'assets/', 'uploads/'])
            ? public_path(ltrim($path, '/'))
            : Storage::disk('public')->path($path);

        return is_file($file) ? $file : null;
    }

    public function imageMedia(): ?Media
    {
        return $this->getFirstMedia(static::imageCollectionName());
    }

    /** Чи є зображення: в Media Library або за старим шляхом. */
    public function hasImage(): bool
    {
        return $this->imageMedia() !== null || filled($this->getAttribute($this->legacyImageColumn()));
    }

    /**
     * URL зображення: conversion (якщо згенеровано) → оригінал із Media Library → старий шлях → плейсхолдер.
     */
    public function imageUrl(string $conversion = ''): string
    {
        $media = $this->imageMedia();

        if ($media === null) {
            return (string) PublicImage::url($this->getAttribute($this->legacyImageColumn()), $this->imagePlaceholder());
        }

        return $conversion !== '' && $media->hasGeneratedConversion($conversion)
            ? $media->getUrl($conversion)
            : $media->getUrl();
    }

    /**
     * Адреси для адаптивної подачі: десктопний conversion і (якщо згенеровано) мобільний `{kind}_mobile`
     * з ширинами для srcset.
     *
     * @return array{desktop: string, mobile: string|null, desktop_width: int, mobile_width: int}
     */
    public function imageSources(string $kind): array
    {
        $media = $this->imageMedia();
        $mobile = $kind.'_mobile';
        $keys = $this->imageSizeKeys();

        return [
            'desktop' => $this->imageUrl($kind),
            'mobile' => $media?->hasGeneratedConversion($mobile) ? $media->getUrl($mobile) : null,
            'desktop_width' => ImageSizes::width($keys[$kind] ?? 'cover.thumb.desktop'),
            'mobile_width' => ImageSizes::width($keys[$mobile] ?? 'cover.thumb.mobile'),
        ];
    }

    /** Відносний шлях до мініатюри для пошукового індексу (або старий шлях). */
    public function imageSearchPath(): ?string
    {
        if ($this->imageMedia() === null) {
            return $this->getAttribute($this->legacyImageColumn()) ?: null;
        }

        return parse_url($this->imageUrl('thumb'), PHP_URL_PATH) ?: null;
    }
}
