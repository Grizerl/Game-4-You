<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::prefix('games-4-you')->group(function(){
    
    Route::get('/', [App\Http\Controllers\ViewsControllers\PageController::class, 'index'])->name('home');

    Route::get('/creators', [App\Http\Controllers\ViewsControllers\PageController::class, 'creator'])->name('creators');

    Route::get('/stores', [App\Http\Controllers\ViewsControllers\PageController::class, 'store'])->name('stores');
    
    Route::get('/games', [App\Http\Controllers\ViewsControllers\PageController::class, 'game'])->name('games');

});

