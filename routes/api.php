<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/category', [ApiController::class, 'getGames']);

Route::get('/creators', [ApiController::class, 'creators']);

Route::get('/games', [ApiController::class, 'games']);

Route::get('/details/{id}', [ApiController::class, 'details']);
