<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\KelolaAdminController;
use App\Http\Controllers\PublicCollectionController;
use App\Http\Controllers\Admin\ReviewController;
use Illuminate\Support\Facades\Route;

// =====================================================
// HALAMAN PENGUNJUNG MUSEWANGI (MOBILE-FIRST)
// =====================================================
// Dashboard Pengunjung (Screen 2 & Screen 1)
Route::get('/', [PublicCollectionController::class, 'home'])
    ->name('home');

// Kamera Scan QR Code di Browser Mobile (Screen 3)
Route::get('/scan', [PublicCollectionController::class, 'scanner'])
    ->name('public.scan');

// Layar Transisi Verifikasi QR Berhasil (Screen 4)
Route::get('/scan/verify/{kode}', [PublicCollectionController::class, 'verify'])
    ->name('public.scan.verify');

// Halaman Publik Detail Koleksi (Screen 5 & 6)
Route::get('/koleksi/{kode}', [PublicCollectionController::class, 'show'])
    ->name('public.koleksi.show');

// Kirim Ulasan & Rating Pengunjung
Route::post('/koleksi/{kode}/ulasan', [PublicCollectionController::class, 'storeReview'])
    ->name('public.koleksi.review');

// Kompatibilitas jika diakses tanpa kode
Route::get('/koleksi', [CollectionController::class, 'index'])
    ->name('collection.index');

// =====================================================
// DASHBOARD USER (Breeze default)
// =====================================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// =====================================================
// PROFILE
// =====================================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =====================================================
// ADMIN PANEL (Semua rute admin ber-prefix /admin)
// =====================================================
Route::middleware('auth')->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // ── KOLEKSI MUSEUM ─────────────────────────────────
    Route::get('/koleksi', [CollectionController::class, 'index'])
        ->name('admin.koleksi.index');

    // Alias untuk rute admin.index (dipakai di sidebar)
    Route::get('/koleksi/daftar', [CollectionController::class, 'index'])
        ->name('admin.index');

    Route::get('/koleksi/tambah', [CollectionController::class, 'create'])
        ->name('admin.koleksi.create');

    Route::post('/koleksi', [CollectionController::class, 'store'])
        ->name('admin.koleksi.store');

    Route::get('/koleksi/detail/{id}', [CollectionController::class, 'show'])
        ->name('admin.koleksi.detail');

    Route::get('/koleksi/edit/{id}', [CollectionController::class, 'edit'])
        ->name('admin.koleksi.edit');

    Route::put('/koleksi/{id}', [CollectionController::class, 'update'])
        ->name('admin.koleksi.update');

    Route::delete('/koleksi/{id}', [CollectionController::class, 'destroy'])
        ->name('admin.koleksi.delete');

    Route::get('/koleksi/{id}/qrcode', [CollectionController::class, 'qrcode'])
        ->name('admin.koleksi.qrcode');

    // ── KATEGORI ───────────────────────────────────────
    Route::get('/kategori', [CategoryController::class, 'index'])
        ->name('admin.kategori.index');

    Route::get('/tambah/kategori', [CategoryController::class, 'create'])
        ->name('admin.tambah.kategori');

    Route::post('/kategori', [CategoryController::class, 'store'])
        ->name('admin.store.kategori');

    Route::get('/kategori/{category}/edit', [CategoryController::class, 'edit'])
        ->name('admin.edit.kategori');

    Route::put('/kategori/{category}', [CategoryController::class, 'update'])
        ->name('admin.update.kategori');

    Route::delete('/kategori/{category}', [CategoryController::class, 'destroy'])
        ->name('admin.delete.kategori');

    // ── QR CODE KOLEKSI ────────────────────────────────
    Route::prefix('qrcode')->name('admin.qrcode.')->group(function () {
        Route::get('/', [QRCodeController::class, 'index'])
            ->name('index');

        Route::get('/generate/{koleksi}', [QRCodeController::class, 'generate'])
            ->name('generate');

        Route::get('/download/{koleksi}', [QRCodeController::class, 'download'])
            ->name('download');

        Route::get('/cetak-label/{koleksi}', [QRCodeController::class, 'cetakLabel'])
            ->name('cetakLabel');

        Route::delete('/destroy/{koleksi}', [QRCodeController::class, 'destroy'])
            ->name('destroy');
    });

    // ── MODERASI ULASAN PENGUNJUNG ─────────────────────
    Route::prefix('ulasan')->name('admin.ulasan.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])
            ->name('index');

        Route::post('/{id}/approve', [ReviewController::class, 'approve'])
            ->name('approve');

        Route::post('/{id}/reject', [ReviewController::class, 'reject'])
            ->name('reject');

        Route::post('/bulk-approve', [ReviewController::class, 'bulkApprove'])
            ->name('bulkApprove');

        Route::delete('/{id}', [ReviewController::class, 'destroy'])
            ->name('destroy');
    });

    // ── RIWAYAT AKTIVITAS ──────────────────────────────
    Route::get('/riwayat', [AdminController::class, 'riwayat'])
        ->name('admin.riwayat');

    Route::delete('/riwayat/bulk-delete', [AdminController::class, 'bulkDeleteRiwayat'])
        ->name('admin.riwayat.bulkDelete');

    Route::delete('/riwayat/{id}', [AdminController::class, 'hapusRiwayat'])
        ->name('admin.riwayat.delete');

    // ── KELOLA ADMIN / PENGGUNA ────────────────────────
    Route::get('/kelolaadmin', [KelolaAdminController::class, 'index'])
        ->name('admin.kelolaadmin');

    Route::post('/kelolaadmin/tambah', [KelolaAdminController::class, 'tambahAdmin'])
        ->name('admin.kelolaadmin.tambah');

    Route::get('/kelolaadmin/{id}/edit', [KelolaAdminController::class, 'edit'])
        ->name('admin.edit.admin');

    Route::put('/kelolaadmin/{id}', [KelolaAdminController::class, 'update'])
        ->name('admin.update.admin');

    Route::delete('/kelolaadmin/{id}', [KelolaAdminController::class, 'delete'])
        ->name('admin.delete.admin');
});

require __DIR__ . '/auth.php';