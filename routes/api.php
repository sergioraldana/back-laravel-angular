<?php

use App\Http\Controllers\api\v1\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/auth')->group(function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
    });
});
