<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {return $request->user();})->middleware('auth:sanctum');

Route::get('/category', [App\Http\Controllers\Api\ApiController::class, 'getGames']);

Route::get('/creators', [App\Http\Controllers\Api\ApiController::class, 'creators']);

Route::get('/games', [App\Http\Controllers\Api\ApiController::class, 'games']);

Route::get('/details/{id}', [App\Http\Controllers\Api\ApiController::class, 'details']);