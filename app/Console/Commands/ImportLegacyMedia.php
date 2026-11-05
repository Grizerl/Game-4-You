<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Company;
use App\Models\Creator;
use App\Models\Game;
use Illuminate\Console\Command;
use Throwable;

class ImportLegacyMedia extends Command
{
    protected $signature = 'media:import-legacy';

    protected $description = 'Імпортує зображення зі старих колонок-шляхів (cover_image, avatar, logo_path) у Media Library і генерує WebP-мініатюри';

    /** @var list<class-string<Game|Article|Creator|Company>> */
    private const MODELS = [Game::class, Article::class, Creator::class, Company::class];

    public function handle(): int
    {
        // Розпакований великий JPEG може займати сотні МБ.
        @ini_set('memory_limit', '2048M');

        $imported = $skipped = $failed = 0;

        foreach (self::MODELS as $class) {
            $column = (new $class)->legacyImageColumn();
            $collection = $class::imageCollectionName();

            $class::query()
                ->whereNotNull($column)
                ->where($column, '!=', '')
                ->whereDoesntHave('media', fn ($query) => $query->where('collection_name', $collection))
                ->orderBy('id')
                ->chunkById(25, function ($models) use ($collection, $class, &$imported, &$skipped, &$failed): void {
                    foreach ($models as $model) {
                        $file = $model->legacyImageFile();

                        if ($file === null) {
                            $skipped++;
                            $this->warn("{$class} #{$model->getKey()}: файл недоступний або зовнішній URL — пропущено");

                            continue;
                        }

                        try {
                            $model->addMedia($file)->preservingOriginal()->toMediaCollection($collection);
                            $imported++;
                        } catch (Throwable $e) {
                            $failed++;
                            report($e);
                            $this->error("{$class} #{$model->getKey()}: {$e->getMessage()}");
                        }
                    }
                });

            $this->line(class_basename($class).': оброблено');
        }

        $this->info("Імпортовано: {$imported}; пропущено: {$skipped}; помилок: {$failed}.");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
