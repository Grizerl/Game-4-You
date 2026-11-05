<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use App\Support\ImageVariants;
use Illuminate\Console\Command;

class OptimizeImages extends Command
{
    protected $signature = 'images:optimize';

    protected $description = 'Генерує легкі WebP-варіанти (640/1280 px) обкладинок ігор і новин, аватарів творців і логотипів компаній у public/assets/_v';

    public function handle(): int
    {
        $created = 0;
        $skipped = 0;

        $covers = collect()
            ->merge(Game::query()->whereNotNull('cover_image')->pluck('cover_image'))
            ->merge(Article::query()->whereNotNull('cover_image')->pluck('cover_image'))
            ->merge(Creator::query()->whereNotNull('avatar')->pluck('avatar'))
            ->merge(Company::query()->whereNotNull('logo_path')->pluck('logo_path'))
            ->filter()
            ->unique()
            ->values();

        $this->withProgressBar($covers, function (string $path) use (&$created, &$skipped): void {
            $made = ImageVariants::generate($path);
            $made > 0 ? $created += $made : $skipped++;
        });

        $this->newLine(2);
        $this->info("Створено/оновлено варіантів: {$created}; пропущено (вже є, зовнішні чи не растрові): {$skipped}.");

        return self::SUCCESS;
    }
}
