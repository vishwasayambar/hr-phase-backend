<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


Route::middleware(['cors'])->group(function () {
   Route::post('registerTenant', [TenantController::class, 'store']);
   Route::post('register', [AuthController::class, 'registerUser']);
   Route::post('login', [AuthController::class, 'login']);
});

Route::prefix('auth')->middleware(['cors'])->group(function () {
    Route::get('verifyToken', [AuthController::class, 'verifyToken']);
    Route::post('accountActivate', [AuthController::class, 'accountActivate']);
    Route::post('login', [AuthController::class, 'login']);
});
