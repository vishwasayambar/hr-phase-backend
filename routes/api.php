<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

Route::middleware(['cors'])->group(function () {
    Route::group([
        'prefix' => "register",
    ], function () {
        Route::post('/', [TenantController::class, 'store']);
        Route::post('/resendActivationEmail', [TenantController::class, 'resendActivationEmail']);
    });
    Route::prefix('auth')->group(function () {
        Route::get('verifyToken', [AuthController::class, 'verifyToken']);
        Route::post('accountActivate', [AuthController::class, 'accountActivate']);
        Route::post('login', [AuthController::class, 'login']);
    });
});

