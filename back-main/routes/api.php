<?php
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'loginWithToken']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resources([
        'user'                                  =>  'App\Http\Controllers\UserController',
        'customer'                              =>  'App\Http\Controllers\CustomerController',
        'vehicle-brand'                         =>  'App\Http\Controllers\VehiclesBrandController',
        'vehicle-model'                         =>  'App\Http\Controllers\VehiclesModelController',
        'vehicle'                               =>  'App\Http\Controllers\VehiclesController',
    ]);
});

