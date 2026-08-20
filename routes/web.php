<?php

use App\Http\Controllers\Admin\AplikasiController;
use App\Http\Controllers\Admin\AplikasiDetailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [KatalogController::class, 'dashboard'])->name('dashboard');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{aplikasi:slug}', [KatalogController::class, 'show'])->name('katalog.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin_provinsi,admin_satker'])
    ->group(function () {
        Route::resource('aplikasi', AplikasiController::class)->except(['show']);
        Route::get('aplikasi/{aplikasi}/detail', [AplikasiDetailController::class, 'edit'])->name('aplikasi.detail.edit');
        Route::post('aplikasi/{aplikasi}/detail/fitur', [AplikasiDetailController::class, 'storeFitur'])->name('aplikasi.detail.fitur.store');
        Route::delete('aplikasi/{aplikasi}/detail/fitur/{fitur}', [AplikasiDetailController::class, 'destroyFitur'])->name('aplikasi.detail.fitur.destroy');
        Route::post('aplikasi/{aplikasi}/detail/tim', [AplikasiDetailController::class, 'storeTim'])->name('aplikasi.detail.tim.store');
        Route::delete('aplikasi/{aplikasi}/detail/tim/{tim}', [AplikasiDetailController::class, 'destroyTim'])->name('aplikasi.detail.tim.destroy');
        Route::post('aplikasi/{aplikasi}/detail/dokumen', [AplikasiDetailController::class, 'storeDokumen'])->name('aplikasi.detail.dokumen.store');
        Route::delete('aplikasi/{aplikasi}/detail/dokumen/{dokumen}', [AplikasiDetailController::class, 'destroyDokumen'])->name('aplikasi.detail.dokumen.destroy');
        Route::post('aplikasi/{aplikasi}/detail/versi', [AplikasiDetailController::class, 'storeVersi'])->name('aplikasi.detail.versi.store');
        Route::delete('aplikasi/{aplikasi}/detail/versi/{versi}', [AplikasiDetailController::class, 'destroyVersi'])->name('aplikasi.detail.versi.destroy');
        Route::post('aplikasi/{aplikasi}/verify', [AplikasiController::class, 'verify'])
            ->middleware('role:admin_provinsi')
            ->name('aplikasi.verify');
    });