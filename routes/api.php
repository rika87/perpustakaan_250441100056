<?php

use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\Api\RekapController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::middleware('permission:lihat daftar buku')->group(function () {
        Route::apiResource('buku', BukuController::class)->only(['index', 'show']);
    });

    Route::middleware('permission:kelola data buku')->group(function () {
        Route::apiResource('buku', BukuController::class)->only(['store', 'update', 'destroy']);
    });

    Route::prefix('rekap')
        ->middleware('permission:kelola data buku|lihat laporan perpustakaan')
        ->group(function () {
            Route::get('buku-per-kategori', [RekapController::class, 'bukuPerKategori']);
            Route::get('peminjaman-per-buku', [RekapController::class, 'peminjamanPerBuku']);
        });
});