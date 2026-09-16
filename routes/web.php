<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\KerjaSamaIndustriController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Landing Page SMKN 4 Tanjungpinang
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authenticated Routes
Route::middleware(['auth', 'role'])->group(function () {
    // Beranda & Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifikasi Web
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');

    // Modul Agenda
    Route::resource('agenda', AgendaController::class);

    // Modul Surat Masuk (TU, Kepala Sekolah, Humas, Guru, Admin)
    Route::resource('surat-masuk', SuratMasukController::class);

    // Modul Disposisi Surat
    Route::get('/disposisi/antrian', [DisposisiController::class, 'antrian'])->name('disposisi.antrian');
    Route::post('/disposisi', [DisposisiController::class, 'store'])->name('disposisi.store');
    Route::patch('/disposisi/{disposisi}/status', [DisposisiController::class, 'updateStatus'])->name('disposisi.status');
    Route::delete('/disposisi/{disposisi}', [DisposisiController::class, 'destroy'])->name('disposisi.destroy');

    // Modul Surat Keluar (TU, Kepala Sekolah, Admin)
    Route::get('/surat-keluar/{suratKeluar}/pdf', [SuratKeluarController::class, 'cetakPdf'])->name('surat-keluar.pdf');
    Route::post('/surat-keluar/{suratKeluar}/approve', [SuratKeluarController::class, 'approve'])->name('surat-keluar.approve');
    Route::patch('/surat-keluar/{suratKeluar}/status', [SuratKeluarController::class, 'updateStatus'])->name('surat-keluar.status');
    Route::resource('surat-keluar', SuratKeluarController::class);

    // Modul Kerja Sama Industri (Humas, Admin, TU, Kepsek)
    Route::resource('kerja-sama', KerjaSamaIndustriController::class)->parameters([
        'kerja-sama' => 'kerjaSama'
    ]);

    // Modul Sertifikat PKL (TU, Humas, Kepsek, Siswa)
    Route::get('/sertifikat/{sertifikat}/pdf', [SertifikatController::class, 'cetakPdf'])->name('sertifikat.pdf');
    Route::patch('/sertifikat/{sertifikat}/status', [SertifikatController::class, 'updateStatus'])->name('sertifikat.status');
    Route::resource('sertifikat', SertifikatController::class);

    // Modul Pengaturan & Kelola User (Khusus Admin)
    Route::prefix('pengaturan')->name('pengaturan.')->middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});

require __DIR__.'/auth.php';
