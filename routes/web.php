<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BackupController;

// Langsung arahkan root ke dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Langsung buka dashboard tanpa middleware
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Arsip (bisa langsung akses tanpa login)
Route::get('/arsip', [ArchiveController::class, 'index'])->name('archives.index');
Route::get('/arsip/create', [ArchiveController::class, 'create'])->name('archive.create');
Route::post('/arsip', [ArchiveController::class, 'store'])->name('archives.store');
Route::get('/arsip/{archive}/download', [ArchiveController::class, 'download'])->name('archives.download');
Route::get('/arsip/{archive}/view-pdf', [ArchiveController::class, 'viewPdf'])->name('archives.view-pdf');
Route::resource('archives', \App\Http\Controllers\ArchiveController::class);

// Jika tetap ingin profile, tapi tidak pakai auth
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// Route Kategori
Route::resource('kategori', CategoryController::class);

// Jika ingin tetap ada route /home (opsional)
Route::get('/home', function () {
    return redirect('/dashboard');
})->name('home');

// Riwayat Akses
Route::get('/riwayat', [DashboardController::class, 'riwayat_akses'])->name('logs.index');

// Backup / Restore
Route::get('/backup', [BackupController::class, 'index'])->name('backup.index');
Route::post('/backup/create', [BackupController::class, 'create'])->name('backup.create');
Route::post('/backup/restore/{id}', [BackupController::class, 'restore'])->name('backup.restore');
