<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk User dan Admin
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes untuk User (Petugas Security)
    Route::prefix('absensi')->group(function () {
        Route::get('/', [AbsensiController::class, 'index'])->name('absensi.index'); // Menampilkan daftar absensi user
        Route::get('/create', [AbsensiController::class, 'create'])->name('absensi.create'); // Menampilkan form absensi masuk
        Route::post('/', [AbsensiController::class, 'store'])->name('absensi.store'); // Menyimpan data absensi masuk
        Route::get('/{absensi}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit'); // Menampilkan form absensi keluar
        Route::patch('/{absensi}', [AbsensiController::class, 'update'])->name('absensi.update'); // Menyimpan data absensi keluar
    });

    // Routes untuk Admin
    Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // Absensi Routes untuk Admin
        Route::get('/data-absensi/data', [AbsensiController::class, 'getAbsensi'])->name('admin.data-absensi'); // Rute untuk mendapatkan data absensi

        // Resource Route untuk Absensi Admin (CRUD)
        Route::resource('/data-absensi', AbsensiController::class)->except(['create', 'edit']);

        // Data Pengguna (User Management) untuk Admin
        Route::get('/data-pengguna', [UserController::class, 'index'])->name('admin.data-pengguna');

        // Laporan khusus Admin
        Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
    });
});

require __DIR__.'/auth.php';
