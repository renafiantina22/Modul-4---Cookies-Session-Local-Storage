<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeranjangController;

Route::get('/', [KeranjangController::class, 'index'])->name('barang.index');

Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])
    ->name('keranjang.tambah');

Route::get('/keranjang', [KeranjangController::class, 'indexKeranjang'])
    ->name('keranjang.index');

    Route::post('/keranjang/tambah-jumlah/{id}', [KeranjangController::class, 'tambahJumlah'])
    ->name('keranjang.tambahJumlah');

Route::post('/keranjang/kurang/{id}', [KeranjangController::class, 'kurangJumlah'])
    ->name('keranjang.kurang');

Route::post('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])
    ->name('keranjang.hapus');

Route::post('/keranjang/kosongkan', [KeranjangController::class, 'kosongkan'])
    ->name('keranjang.kosongkan');