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

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes untuk User (Petugas Security)
    Route::prefix('absensi')->group(function () {
        Route::get('/', [AbsensiController::class, 'index'])->name('absensi.index');
<<<<<<< HEAD
        Route::get('/create', [AbsensiController::class, 'create'])->name('absensi.create');
        Route::post('/', [AbsensiController::class, 'store'])->name('absensi.store');
        Route::get('/{absensi}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
        Route::patch('/{absensi}', [AbsensiController::class, 'update'])->name('absensi.update');
=======
        Route::get('/create', [AbsensiController::class, 'create'])->name('absensi.add-absensi');
        Route::post('/', [AbsensiController::class, 'store'])->name('absensi.store');
        Route::get('/{absensi}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
        Route::put('/{absensi}', [AbsensiController::class, 'update'])->name('absensi.update');
        Route::delete('/{absensi}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');
>>>>>>> 265ba4e75b1291db4c2d1b59534719822ae27df9
    });

    // Routes untuk Admin
    Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

<<<<<<< HEAD
        Route::get('/data-absensi', [AbsensiController::class, 'index'])->name('admin.data-absensi');
        Route::post('/data-absensi', [AbsensiController::class, 'store'])->name('admin.data-absensi.store');
        Route::put('/data-absensi/{id}', [AbsensiController::class, 'update'])->name('admin.data-absensi.update');
        Route::delete('/data-absensi/{id}', [AbsensiController::class, 'destroy'])->name('admin.data-absensi.destroy');
        Route::get('/data-absensi/data', [AbsensiController::class, 'data'])->name('admin.data-absensi.data');

        
=======
        Route::get('/data-absensi/data', [AbsensiController::class, 'getAbsensi'])->name('admin.data-absensi.get');
        Route::resource('/data-absensi', AbsensiController::class)->except(['create', 'edit']);
>>>>>>> 265ba4e75b1291db4c2d1b59534719822ae27df9

        Route::get('/data-pengguna', [UserController::class, 'index'])->name('admin.data-pengguna');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
    });
});

require __DIR__ . '/auth.php';
