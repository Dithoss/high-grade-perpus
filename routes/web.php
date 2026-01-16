<?php

use App\Enums\UserRole;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AUTH (SESSION BASED)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'updateForgotPassword'])->name('password.update');
Route::resource('products', ProductController::class)->except('show');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USERS (Both Admin & User)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::get('books', [BookController::class, 'index'])->name('books.index');
    
    /*
    |--------------------------------------------------------------------------
    | ROLE: ADMIN ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:' . UserRole::ADMIN->value])->group(function () {
        Route::get('books/create', [BookController::class, 'create'])->name('books.create');
        Route::post('books', [BookController::class, 'store'])->name('books.store');
        Route::get('books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::put('books/{book}', [BookController::class, 'update'])->name('books.update');
        Route::delete('books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
        
        Route::get('books-trash', [BookController::class, 'trash'])->name('books.trash');
        Route::put('books/{id}/restore', [BookController::class, 'restore'])->name('books.restore');

        Route::resource('categories', CategoryController::class);
    });

    Route::get('books/{book}', [BookController::class, 'show'])->name('books.show');

    /*
    |--------------------------------------------------------------------------
    | ROLE: USER
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:' . UserRole::USER->value])->group(function () {
        Route::resource('transactions', TransactionController::class);
    });
});