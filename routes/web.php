<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\KelolaAdminController;
use Illuminate\Support\Facades\Route;


// Halaman utama
Route::get('/', function () {
    return view('auth.login');
});


// =========================
// COLLECTION PUBLIC

Route::get('/koleksi', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/koleksi/{id}', [CollectionController::class, 'show'])->name('collection.show');


// =========================
// DASHBOARD USER
// =========================

Route::get('/dashboard', function () {
    return view('dashboard');
})
->middleware(['auth', 'verified'])
->name('dashboard');


// =========================
// PROFILE
// =========================

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});


// =========================
// ADMIN
// =========================

Route::middleware('auth')->group(function () {


    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');


// Kategori
Route::prefix('admin')->middleware('auth')->group(function () {

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

    // Kelola Admin
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

    // =========================
    // KOLEKSI
    // =========================

    Route::get('/admin/index', [CollectionController::class, 'index'])
        ->name('admin.index');

    Route::get('/admin/koleksi', [CollectionController::class, 'index'])
        ->name('admin.koleksi.index');

    Route::get('/admin/koleksi/detail/{id}', [CollectionController::class, 'show'])
        ->name('admin.koleksi.detail');

    Route::get('/admin/koleksi/tambah', [CollectionController::class, 'create'])
        ->name('admin.koleksi.create');

    Route::post('/admin/koleksi', [CollectionController::class, 'store'])
        ->name('admin.koleksi.store');

    Route::get('/admin/koleksi/edit/{id}', [CollectionController::class, 'edit'])
        ->name('admin.koleksi.edit');

    Route::put('/admin/koleksi/{id}', [CollectionController::class, 'update'])
        ->name('admin.koleksi.update');

    Route::delete('/admin/koleksi/{id}', [CollectionController::class, 'destroy'])
        ->name('admin.koleksi.delete');
    



    // =========================
    // QR CODE
    // =========================
    Route::prefix('admin/qrcode')
    ->name('admin.qrcode.')
    ->group(function(){


    Route::get('/', 
    [QRCodeController::class,'index'])
    ->name('index');


    Route::get('/generate/{koleksi}',
    [QRCodeController::class,'generate'])
    ->name('generate');


    Route::get('/download/{koleksi}',
    [QRCodeController::class,'download'])
    ->name('download');


    Route::delete('/destroy/{koleksi}',
    [QRCodeController::class,'destroy'])
    ->name('destroy');


    });



    // Riwayat Admin
    Route::get('/riwayat', [AdminController::class, 'riwayat'])
        ->name('admin.riwayat');

    Route::delete('/riwayat/bulk-delete', [AdminController::class, 'bulkDeleteRiwayat'])
        ->name('admin.riwayat.bulkDelete');

    Route::delete('/riwayat/{id}', [AdminController::class, 'hapusRiwayat'])
        ->name('admin.riwayat.delete');

    });

});
require __DIR__ . '/auth.php';