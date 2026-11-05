<?php

namespace App\Providers;

use App\Models\Tag;
use App\Observers\SearchIndexObserver;
use App\Services\Search\SearchClient;
use App\Services\Search\SearchSync;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SearchClient::class, fn (): SearchClient => new SearchClient);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        foreach ([...SearchSync::INDEXED, Tag::class] as $model) {
            $model::observe(SearchIndexObserver::class);
        }
    }
}
