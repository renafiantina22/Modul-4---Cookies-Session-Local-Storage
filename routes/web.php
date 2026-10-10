<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('/', [ProductController::class, 'index'])
    ->name('products.index');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');
    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

    Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])
        ->name('cart.index');

    Route::post('/keranjang/tambah/{id}', [CartController::class, 'add'])
        ->name('cart.add');

    Route::post('/keranjang/update/{id}', [CartController::class, 'update'])
        ->name('cart.update');

    Route::post('/keranjang/hapus/{id}', [CartController::class, 'remove'])
        ->name('cart.remove');
        
    Route::post('/checkout', [CartController::class, 'checkout'])
    ->name('checkout');

    Route::get('/pesanan/{id}', [OrderController::class, 'show'])
        ->name('orders.show');

    Route::get('/riwayat-pesanan', [OrderController::class, 'index'])
        ->name('orders.index');
});