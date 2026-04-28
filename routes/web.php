<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\CommentController;
use App\Http\Controllers\Pages\GamesController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\Pages\CategoryController;
use App\Http\Controllers\Dashboard\Pages\CompanyController;
use App\Http\Controllers\Dashboard\Pages\CreatorController;
use App\Http\Controllers\Dashboard\Pages\GameController;
use App\Http\Controllers\ViewsControllers\PageController;
use App\Http\Controllers\Pages\CompanyController as PagesCompanyController;
use App\Http\Controllers\Pages\CreatorController as PagesCreatorController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('/', function (): RedirectResponse {
    return redirect()->route('home.page');
});

Route::group(
[
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
], function(){ 
    Route::prefix('games-4-you')->group(function (): void {
        Route::get('/', [HomeController::class, 'index'])
            ->name('home.page');
        
        Route::get('/creators', [PagesCreatorController::class, 'index'])
            ->name('creator.page');
        
        Route::get('/company', [PagesCompanyController::class, 'index'])
            ->name('company.page');
        
        Route::get('/games', [GamesController::class, 'index'])
            ->name('games.page');
        
        Route::get('/games/{id}', [GamesController::class, 'show'])
            ->name('games.show.page');
        
        Route::post('/comments', [CommentController::class, 'store'])
            ->name('comments.store');
        
        Route::get('/category', [PageController::class, 'getGames'])
            ->name('games');
    });
});

Route::middleware(['auth', 'verified'])->prefix('control')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('companies', CompanyController::class);
    
    Route::resource('creator', CreatorController::class);
    
    Route::resource('category', CategoryController::class);
    
    Route::resource('game', GameController::class);
});

require __DIR__.'/auth.php';

