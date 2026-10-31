<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Pages\ArticleController;
use App\Http\Controllers\Dashboard\Pages\CategoryController;
use App\Http\Controllers\Dashboard\Pages\CompanyController;
use App\Http\Controllers\Dashboard\Pages\CreatorController;
use App\Http\Controllers\Dashboard\Pages\GameController;
use App\Http\Controllers\Pages\CommentController;
use App\Http\Controllers\Pages\CompanyController as PagesCompanyController;
use App\Http\Controllers\Pages\CreatorController as PagesCreatorController;
use App\Http\Controllers\Pages\GamesController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Pages\NewsController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
    ], function () {
        Route::get('/', [HomeController::class, 'index'])
            ->name('home.page');

        Route::get('/creators', [PagesCreatorController::class, 'index'])
            ->name('creator.page');

        Route::get('/creators/{creator:slug}', [PagesCreatorController::class, 'show'])
            ->name('creator.show.page');

        Route::get('/company', [PagesCompanyController::class, 'index'])
            ->name('company.page');

        Route::get('/company/{company:slug}', [PagesCompanyController::class, 'show'])
            ->name('company.show.page');

        Route::get('/games', [GamesController::class, 'index'])
            ->name('games.page');

        Route::get('/games/{game}', [GamesController::class, 'show'])
            ->name('games.show.page');

        Route::get('/news', [NewsController::class, 'index'])
            ->name('news.page');

        // RSS оголошено раніше за {article:slug}, щоб адреса /news/feed не вважалася slug-ом.
        Route::get('/news/feed', [NewsController::class, 'feed'])
            ->name('news.feed.page');

        Route::get('/news/{article:slug}', [NewsController::class, 'show'])
            ->name('news.show.page');

        Route::post('/comments', [CommentController::class, 'store'])
            ->middleware('throttle:5,1')
            ->name('comments.store');
    });

Route::middleware(['auth', 'verified'])->prefix('control')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('companies', CompanyController::class);

    Route::resource('creator', CreatorController::class);

    Route::resource('category', CategoryController::class);

    Route::resource('game', GameController::class);

    Route::resource('news', ArticleController::class)->parameters(['news' => 'article']);
});

require __DIR__.'/auth.php';
