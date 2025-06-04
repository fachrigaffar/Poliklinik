<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Dokter\ObatController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

    Route::prefix('obat')->group(function () {
            Route::get('/', [ObatController::class, 'index'])->name('dokter.obat.index');
            Route::get('/create', [ObatController::class, 'create'])->name('dokter.obat.create');
            Route::post('/', [ObatController::class, 'store'])->name('dokter.obat.store');
            Route::get('/{id}/edit', [ObatController::class, 'edit'])->name('dokter.obat.edit');
            Route::patch('/{id}', [ObatController::class, 'update'])->name('dokter.obat.update');
            Route::delete('/{id}', [ObatController::class, 'destroy'])->name('dokter.obat.destroy');
    });

    Route::prefix('jadwal-periksa')->group(function () {
        Route::get('/', [JadwalPeriksaController::class, 'index'])->name('dokter.jadwal.index');
        Route::get('/create', [JadwalPeriksaController::class, 'create'])->name('dokter.jadwal.create');
        Route::post('/', [JadwalPeriksaController::class, 'store'])->name('dokter.jadwal.store');
        Route::get('/{id}/edit', [JadwalPeriksaController::class, 'edit'])->name('dokter.jadwal.edit');
        Route::put('/{id}', [JadwalPeriksaController::class, 'update'])->name('dokter.jadwal.update');
        Route::delete('/{id}', [JadwalPeriksaController::class, 'destroy'])->name('dokter.jadwal.destroy');

        Route::patch('/{jadwal}/status', [JadwalPeriksaController::class, 'updateStatus'])->name('dokter.jadwal.status');
    });
});

Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');


});

require __DIR__.'/auth.php';
