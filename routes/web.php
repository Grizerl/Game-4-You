<?php

use App\Http\Controllers\Pages\CommentController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pages\CompanyController;
use App\Http\Controllers\Pages\CreatorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Pages\GamesController;
use App\Http\Controllers\Pages\HomeController;
use App\Http\Controllers\ViewsControllers\PageController;

Route::get('/', function (): RedirectResponse {
    return redirect()->route('home.page');
});

Route::prefix('games-4-you')->group(function (): void {

    Route::get('/', [HomeController::class, 'index'])->name('home.page');

    Route::get('/creators', [CreatorController::class, 'index'])->name('creator.page');

    Route::get('/company', [CompanyController::class, 'index'])->name('company.page');

    Route::get('/games', [GamesController::class, 'index'])->name('games.page');

    Route::get('/games/{id}', [GamesController::class, 'show'])->name('games.show.page');

    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

    Route::get('/category', [PageController::class, 'getGames'])->name('games');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

