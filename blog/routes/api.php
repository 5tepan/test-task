<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::get('posts', [PostController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('posts', [PostController::class, 'store']);
});
