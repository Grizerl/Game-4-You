<?php

namespace App\Observers;

use App\Services\Search\SearchSync;
use Illuminate\Database\Eloquent\Model;

class SearchIndexObserver
{
    public function saved(Model $model): void
    {
        SearchSync::index($model);
    }

    public function deleted(Model $model): void
    {
        // Той самий джоб: модель уже не знайдеться в БД, тож документ буде видалено.
        SearchSync::index($model);
    }
}
