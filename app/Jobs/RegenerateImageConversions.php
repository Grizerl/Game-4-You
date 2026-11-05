<?php

namespace App\Jobs;

use App\Support\ImageSizes;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Artisan;

/**
 * Перегенерує всі conversions Media Library після зміни розмірів зображень в адмінці.
 */
class RegenerateImageConversions implements ShouldQueue
{
    use Queueable;

    public int $timeout = 3600;

    public function handle(): void
    {
        // Воркер живе довго й міг закешувати старі розміри.
        ImageSizes::forget();

        Artisan::call('media-library:regenerate', ['--force' => true]);
    }
}
