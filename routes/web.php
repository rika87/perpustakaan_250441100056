<?php

use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BukuController as BukuApiController;


Route::get('/', function () {
    return view('home');
})->name('home');


    // Autentikasi
    Route::middleware('auth')->group(function () {

    Route::get('/buku-cari', [BukuController::class, 'cari'])
    ->name('buku.cari');

    Route::get('/buku/{buku}/hapus', [BukuApiController::class, 'destroy'])
    ->name('buku.hapus-get');

    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])
    
    ->whereNumber('id')->name('peminjaman.show');

    Route::get('/buku', [BukuController::class, 'index'])
        ->middleware('permission:lihat daftar buku')->name('components.buku.index');
    Route::get('/buku/{id}', [BukuController::class, 'show'])
        ->middleware('permission:lihat daftar buku')->whereNumber('id')->name('components.buku.show');

    Route::get('/kelola/buku', [BukuController::class, 'index'])
        ->middleware('permission:kelola data buku')->name('kelola.buku');

    // Dashboard umum (semua yang sudah login)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->middleware(['role:admin', 'permission:akses dashboard admin'])->name('admin.dashboard');

    Route::get('/petugas/dashboard', [DashboardController::class, 'petugas'])
       
    ->middleware(['role:petugas', 'permission:akses dashboard petugas'])->name('petugas.dashboard');
    // Untuk membatasi akses hanya untuk petugas.


    Route::get('/siswa/dashboard', [DashboardController::class, 'siswa'])
      
    ->middleware('role:siswa')->name('siswa.dashboard');


    
    Route::get('/admin/pengguna', [PenggunaController::class, 'index'])
        ->middleware('permission:kelola data pengguna')->name('admin.pengguna.index');


    Route::patch('/admin/pengguna/{user}/role', [PenggunaController::class, 'updateRole'])
        ->middleware('permission:kelola role pengguna')->name('admin.pengguna.role');
    Route::delete('/admin/pengguna/{user}', [PenggunaController::class, 'destroy'])


        ->middleware('permission:kelola data pengguna')->name('admin.pengguna.destroy');

        Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->middleware('permission:kelola peminjaman')->name('peminjaman.index');
    Route::patch('/peminjaman/{id}/proses', [PeminjamanController::class, 'proses'])
        ->middleware('permission:memproses persetujuan peminjaman')->whereNumber('id')->name('peminjaman.proses');

    Route::get('/pengembalian', [PeminjamanController::class, 'pengembalian'])
        ->middleware('permission:kelola pengembalian')->name('pengembalian.index');
    Route::patch('/pengembalian/{id}/catat', [PeminjamanController::class, 'catatKembali'])
        ->middleware('permission:mencatat pengembalian buku')->whereNumber('id')->name('pengembalian.catat');

    Route::get('/peminjaman/ajukan', [PeminjamanController::class, 'formAjukan'])
        ->middleware('permission:mengajukan peminjaman buku')->name('peminjaman.form-ajukan');
    Route::post('/peminjaman/ajukan', [PeminjamanController::class, 'ajukan'])
        ->middleware('permission:mengajukan peminjaman buku')->name('peminjaman.ajukan');

    // Riwayat milik sendiri (data difilter berdasarkan user yang login)
    Route::get('/riwayat', [PeminjamanController::class, 'riwayat'])
        ->middleware('permission:melihat riwayat peminjaman sendiri')->name('riwayat.index');
    Route::get('/riwayat/{id}', [PeminjamanController::class, 'show'])
        ->middleware('permission:melihat riwayat peminjaman sendiri')->whereNumber('id')->name('riwayat.show');

    // Laporan (admin dan petugas)
    Route::get('/laporan', [LaporanController::class, 'index'])
    


    // ot

    ->middleware(['role:admin|petugas', 'permission:lihat laporan perpustakaan'])->name('laporan.index');

    // Profil milik sendiri (controller bawaan Breeze memakai $request->user())
    Route::get('/profile', [ProfileController::class, 'edit'])
       
        ->middleware('permission:lihat profil sendiri')->name('profile.edit');
        
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware('permission:ubah profil sendiri')->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->middleware('permission:ubah profil sendiri')->name('profile.destroy');
});

// Route login, registrasi, logout (middleware guest) dibuat oleh Breeze
require __DIR__ . '/auth.php';



    Route::patch('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])
        ->middleware('permission:memproses persetujuan peminjaman')->whereNumber('id')->name('peminjaman.tolak');