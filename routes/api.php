<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
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

    Route::middleware([ 'auth:sanctum'])->group(function () {
        Route::get('logout', [AuthController::class, 'logout']);

        Route::middleware('role:admin')->group(function () {
            Route::post('roles', [RoleController::class, 'store']);
        });
        Route::get('roles/getRoles', [RoleController::class, 'getEmployeeRoles']);
        Route::get('permissions', [PermissionController::class, 'index']);
        Route::get('permissions/getAll', [PermissionController::class, 'getAllPermissions']);
        Route::get('permissions/getByRoleId/{roleId}', [PermissionController::class, 'getByRoleId']);
        Route::get('permissions/getByUserId/{userId}', [PermissionController::class, 'getByUserId']);
        Route::put('permissions/saveRolePermissions/{userId}', [PermissionController::class, 'update']);

        Route::prefix('employees')->group(function () {
            Route::post('/', [EmployeeController::class, 'store']);
            Route::get('/', [EmployeeController::class, 'index']);
        });
    });
});

