<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BeritaAcaraController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EskalasiController;
use App\Http\Controllers\KajurController;
use App\Http\Controllers\PenugasanController;
use App\Http\Controllers\StatistikController;
use Illuminate\Support\Facades\Route;

// ─── Auth Routes ───────────────────────────────────────────────────────────
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ─── Protected Routes (Admin Jurusan + Kajur) ──────────────────────────────
Route::middleware(['auth', 'admin'])->group(function () {

    // Dashboard (UC-05)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Laporan — halaman terpisah dengan filter lengkap
    Route::get('/laporan', [DashboardController::class, 'laporan'])->name('laporan.index');

    // Detail Laporan + Penugasan Teknisi (UC-05)
    Route::get('/laporan/{formulirId}', [PenugasanController::class, 'show'])->name('laporan.show');
    Route::post('/laporan/{formulirId}/assign', [PenugasanController::class, 'assign'])->name('laporan.assign');

    // Eskalasi (UC-06)
    Route::get('/eskalasi', [EskalasiController::class, 'index'])->name('eskalasi.index');
    Route::get('/eskalasi/{formulirId}', [EskalasiController::class, 'show'])->name('eskalasi.show');
    Route::post('/eskalasi/{formulirId}/teruskan', [EskalasiController::class, 'teruskanKeKajur'])->name('eskalasi.teruskan');
    Route::post('/eskalasi/{formulirId}/tolak', [EskalasiController::class, 'tolakEskalasi'])->name('eskalasi.tolak');

    // Kajur — Persetujuan Eskalasi (UC-07) — Khusus Kajur
    Route::middleware('kajur')->group(function () {
        Route::get('/kajur', [KajurController::class, 'index'])->name('kajur.index');
        Route::get('/kajur/{formulirId}', [KajurController::class, 'show'])->name('kajur.show');
        Route::post('/kajur/{formulirId}/setujui', [KajurController::class, 'setujuiEskalasi'])->name('kajur.setujui');
    });

    // Berita Acara & Kunci Laporan (UC-08)
    Route::get('/berita-acara', [BeritaAcaraController::class, 'index'])->name('berita-acara.index');
    Route::get('/berita-acara/{formulirId}/pdf', [BeritaAcaraController::class, 'generate'])->name('berita-acara.generate');
    Route::post('/berita-acara/{formulirId}/kunci', [BeritaAcaraController::class, 'kunciLaporan'])->name('berita-acara.kunci');

    // Statistik (UC-09)
    Route::get('/statistik', [StatistikController::class, 'index'])->name('statistik.index');
    Route::get('/statistik/performa', [StatistikController::class, 'performaTeknisi'])->name('statistik.performa');

});