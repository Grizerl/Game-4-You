<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', function (): RedirectResponse {
    return redirect()->route('home');
});

Route::prefix('games-4-you')->group(function (): void {

    Route::get('/', [App\Http\Controllers\ViewsControllers\PageController::class, 'index'])->name('home');

    Route::get('/category', [App\Http\Controllers\ViewsControllers\PageController::class, 'getGames'])->name('games');

    Route::get('/creators', [App\Http\Controllers\ViewsControllers\PageController::class, 'creator'])->name('creators');

    Route::get('/stores', [App\Http\Controllers\ViewsControllers\PageController::class, 'store'])->name('stores');

    Route::get('/games', [App\Http\Controllers\ViewsControllers\PageController::class, 'game'])->name('all.games');

    Route::get('/games/{id}', [App\Http\Controllers\ViewsControllers\PageController::class, 'details'])->name('detail');

});
