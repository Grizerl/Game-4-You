<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Vite;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Media Library кладе файли в storage/app/public/{id}, а id із тестової БД збігаються з id dev-медіа:
        // без фейкового диска тести перезаписували б і видаляли справжні зображення.
        Storage::fake('public');

        // Media Library кладе файли в storage/app/public/{id}, а id із тестової БД збігаються з id dev-медіа:
        // без фейкового диска тести перезаписували б і видаляли справжні зображення.
        Storage::fake('public');

        // Без Accept-Language локалізація редіректить на /en; тести працюють у дефолтній (uk) локалі.
        $this->withHeader('Accept-Language', config('app.locale'));

        // public/build не комітиться, а справжній @vite без manifest кидає виняток. Підміняємо Vite
        // заглушкою, яка виводить теги з іменами входів (resources/scss/...), тож тести бачать,
        // які стилі підключила сторінка, і не залежать від збірки.
        $this->app->instance(Vite::class, new class extends Vite
        {
            public function __invoke($entrypoints, $buildDirectory = null): HtmlString
            {
                $tags = collect((array) $entrypoints)->map(fn (string $entry) => str_ends_with($entry, '.js')
                    ? '<script type="module" src="/build/'.$entry.'"></script>'
                    : '<link rel="stylesheet" href="/build/'.$entry.'">');

                return new HtmlString($tags->implode("\n"));
            }
        });
    }
}
