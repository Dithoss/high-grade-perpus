<?php

use App\Enums\UserRole;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PreOrderController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {    
    Route::post('login', [AuthController::class, 'loginAdmin']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('update-forgot-password', [AuthController::class, 'updateForgotPassword']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('update-password', [AuthController::class, 'updatePassword']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

//Role Admin
Route::middleware(['auth:sanctum', 'role:' . UserRole::ADMIN->value])->group(function () {
 //
});

//Role Gudang
Route::middleware(['auth:sanctum', 'role:' . UserRole::GUDANG->value])->group(function () {
//
});

