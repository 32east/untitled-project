<?php

use App\Http\Controllers\Login\AuthController;
use App\Http\Controllers\Login\LogoutController;
use App\Http\Controllers\Login\RegisterController;
use App\Http\Controllers\Login\TokenController;
use Illuminate\Support\Facades\Route;

Route::prefix("api/v1/")->group(function() {
    Route::prefix("user")->group(function() {
        Route::get('/register', [RegisterController::class, "register"]);
        Route::get('/auth', [AuthController::class, "auth"]);
        Route::get('/logout', [LogoutController::class, "logout"]);
        Route::get('/refresh-token', [TokenController::class, "refresh"]);
    });
});
