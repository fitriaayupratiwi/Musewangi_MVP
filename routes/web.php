<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\KelolaAdminController;
use Illuminate\Support\Facades\Route;


// Halaman utama
Route::get('/', function () {
    return view('auth.login');
});


// Collection / Musewangi
Route::get('/koleksi', [CollectionController::class, 'index'])->name('collection.index');
Route::get('/koleksi/{id}', [CollectionController::class, 'show'])->name('collection.show');


// Route Warung Seblang (tetap)
Route::get('/menu', [CustomerController::class, 'menu'])->name('customer.menu');
Route::get('customer/keranjang', [KeranjangController::class, 'index'])->name('customer.keranjang.view');
Route::post('/customer/keranjang/add', [KeranjangController::class, 'addToCart'])->name('customer.keranjang.add');
Route::delete('/customer/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('customer.keranjang.delete');
Route::post('/customer/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('customer.keranjang.checkout');
Route::get('/pesan-lagi', [KeranjangController::class, 'pesanLagi'])->name('customer.pesan.lagi');
Route::put('/keranjang/{id}/update', [KeranjangController::class, 'update'])->name('customer.keranjang.update');
Route::get('/pesanan/{id}', [KeranjangController::class, 'detailPesanan'])->name('customer.detailPesanan');
Route::get('/riwayat/{nomor_meja}', [KeranjangController::class, 'riwayatPesanan'])->name('customer.riwayat');

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})
->middleware(['auth', 'verified'])
->name('dashboard');


// Profile
Route::middleware('auth')->group(function () {
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin
Route::middleware('auth')->group(function () {


    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');


    // Admin Menu (lama)
    Route::get('/admin/menu', [AdminController::class, 'index'])
        ->name('admin.menu');


    Route::get('/admin/nomormeja', [AdminController::class, 'nomorMeja'])
        ->name('admin.nomormeja');


    Route::get('/admin/tambah/menu', [AdminController::class, 'tambahMenu'])
        ->name('admin.tambah.menu');

    Route::get('/admin/tambah/nomormeja', [AdminController::class, 'tambahNomorMeja'])
        ->name('admin.tambah.nomormeja');


    Route::post('/admin/store/menu', [AdminController::class, 'storeMenu'])
        ->name('admin.store.menu');

    Route::post('/admin/store/nomormeja', [AdminController::class, 'storeNomorMeja'])
        ->name('admin.store.nomormeja');


    Route::get('/admin/edit/menu/{id}', [AdminController::class, 'editMenu'])
        ->name('admin.edit.menu');

    Route::get('/admin/edit/nomormeja/{id}', [AdminController::class, 'editNomorMeja'])
        ->name('admin.edit.nomormeja');


    Route::post('/admin/update/menu', [AdminController::class, 'updateMenu'])
        ->name('admin.update.menu');

    Route::post('/admin/update/nomormeja', [AdminController::class, 'updateNomorMeja'])
        ->name('admin.update.nomormeja');


    Route::get('/admin/delete/menu/{id}', [AdminController::class, 'deleteMenu'])
        ->name('admin.delete.menu');

    Route::get('/admin/delete/nomormeja/{id}', [AdminController::class, 'deleteNomorMeja'])
        ->name('admin.delete.nomormeja');


    Route::put('/admin/update/stok/{id}', [AdminController::class, 'updateStok'])
        ->name('admin.update.stok');


    // Laporan

    Route::get('/admin/laporan', [AdminController::class, 'AdminLaporan'])
        ->name('admin.laporan');

    Route::post('/admin/search/bydate', [AdminController::class, 'AdminSearchByDate'])
        ->name('admin.search.bydate');


    // Detail pesanan

    Route::get('/admin/pesanan/{id}/detail', [AdminController::class, 'detail'])
        ->name('admin.pesanan.detail');


    Route::get('/admin/invoice/download/{id}', [AdminController::class, 'AdminInvoiceDownload'])
        ->name('admin.invoice.download');


    Route::get('/admin/laporan/pdf', [AdminController::class, 'generatePDF'])
        ->name('laporan.pdf');



    // Kategori (lama)
    Route::get('/admin/kategori/menu', [AdminController::class, 'KategoriMenu'])
        ->name('admin.kategori.menu');

    Route::get('/admin/tambah/kategori', [AdminController::class, 'tambahKategori'])
        ->name('admin.tambah.kategori');

    Route::post('/admin/store/kategori', [AdminController::class, 'storeKategori'])
        ->name('admin.store.kategori');

    Route::get('/admin/edit/kategori/{id}', [AdminController::class, 'editKategori'])
        ->name('admin.edit.kategori');

    Route::post('/admin/update/kategori', [AdminController::class, 'updateKategori'])
        ->name('admin.update.kategori');

    Route::get('/admin/delete/kategori/{id}', [AdminController::class, 'deleteKategori'])
        ->name('admin.delete.kategori');

    //Akun Admin
    Route::get('/admin/kelolaadmin', [KelolaAdminController::class, 'index'])->name('admin.kelolaadmin');
    Route::post('/admin/kelolaadmin/tambah', [KelolaAdminController::class, 'tambahAdmin'])->name('admin.kelolaadmin.tambah');
    Route::get('/admin/edit/admin/{id}', [KelolaAdminController::class, 'edit'])->name('admin.edit.admin');
    Route::get('/admin/delete/admin/{id}', [KelolaAdminController::class, 'delete'])->name('admin.delete.admin');
    Route::put('/admin/update/admin/{id}', [KelolaAdminController::class, 'update'])->name('admin.update.admin');

    // Collection Musewangi
    Route::get('/admin/koleksi', [CollectionController::class, 'index'])->name('admin.koleksi');
    Route::get('/admin/koleksi/tambah', [CollectionController::class, 'create'])->name('admin.koleksi.create');
    Route::post('/admin/koleksi', [CollectionController::class, 'store'])->name('admin.koleksi.store');
    Route::get('/admin/koleksi/edit/{id}', [CollectionController::class, 'edit'])->name('admin.koleksi.edit');
    Route::put('/admin/koleksi/{id}', [CollectionController::class, 'update'])->name('admin.koleksi.update');
    Route::delete('/admin/koleksi/{id}', [CollectionController::class, 'destroy'])->name('admin.koleksi.delete');
});


require __DIR__ . '/auth.php';
