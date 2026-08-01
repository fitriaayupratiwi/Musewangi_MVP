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


Route::middleware('auth')->group(function () {
    // Route::get('/kasir/pesanan', [KasirController::class, 'index'])->name('kasir.pesanan');
    // Route::get('/kasir/pesan-lagi/{id}', [KasirController::class, 'pesanLagi'])->name('kasir.pesan.lagi');
    // Route::post('/keranjang/checkout-pesanan', [KeranjangController::class, 'checkoutToPesanan'])->name('keranjang.checkoutPesanan');
    // Route::get('/kasir/pesanan/{id}/bayar', [PesananController::class, 'showBayar'])->name('kasir.bayar');
    // Route::put('/pesanan/{id}/bayar/', [PesananController::class, 'prosesBayar'])->name('pesanan.bayar.proses');
    // Route::post('/kasir/pesanan/{id}/konfirmasi', [PesananController::class, 'konfirmasi'])->name('pesanan.konfirmasi');
    // Route::get('/kasir/pesanan/{id}/detail', [KasirController::class, 'detail'])->name('kasir.pesanan.detail');
    // Route::put('/kasir/pesanan/status/{id}', [KasirController::class, 'updateStatusPesanan'])->name('pesanan.update.status');
    // Route::delete('/kasir/pesanan/{id}', [KasirController::class, 'destroy'])->name('kasir.destroy');
    // Route::put('/kasir/pesanan/update/{id}', [KasirController::class, 'update'])->name('kasir.update');
    // Route::put('/kasir/transaksi/{id}/status', [TransaksiController::class, 'updateStatus'])->name('kasir.transaksi.updateStatus');
    // Route::put('/kasir/transaksi/{id}/status/bayar', [TransaksiController::class, 'updateStatusBayar'])->name('kasir.transaksi.updateStatusBayar');
    // Route::get('/kasir/pesanan/{id}/cetak-struk', [KasirController::class, 'cetakStruk'])->name('kasir.pesanan.cetak');

    Route::get('/admin/menu', [AdminController::class, 'index'])->name('admin.menu');
    Route::get('/admin/nomormeja', [AdminController::class, 'nomorMeja'])->name('admin.nomormeja');

    Route::get('/admin/tambah/menu', [AdminController::class, 'tambahMenu'])->name('admin.tambah.menu');
    Route::get('/admin/tambah/nomormeja', [AdminController::class, 'tambahNomorMeja'])->name('admin.tambah.nomormeja');
    Route::post('/admin/store/menu', [AdminController::class, 'storeMenu'])->name('admin.store.menu');
    Route::post('/admin/store/nomormeja', [AdminController::class, 'storeNomorMeja'])->name('admin.store.nomormeja');
    Route::get('/admin/edit/menu/{id}', [AdminController::class, 'editMenu'])->name('admin.edit.menu');
    Route::get('/admin/edit/nomormeja/{id}', [AdminController::class, 'editNomorMeja'])->name('admin.edit.nomormeja');
    Route::post('/admin/update/menu', [AdminController::class, 'updateMenu'])->name('admin.update.menu');
    Route::post('/admin/update/nomormeja', [AdminController::class, 'updateNomorMeja'])->name('admin.update.nomormeja');
    Route::get('/admin/delete/menu/{id}', [AdminController::class, 'deleteMenu'])->name('admin.delete.menu');
    Route::get('/admin/delete/nomormeja/{id}', [AdminController::class, 'deleteNomorMeja'])->name('admin.delete.nomormeja');
    Route::put('/admin/update/stok/{id}', [AdminController::class, 'updateStok'])->name('admin.update.stok');
    Route::get('/admin/laporan', [AdminController::class, 'AdminLaporan'])->name('admin.laporan');
    Route::post('/admin/search/bydate', [AdminController::class, 'AdminSearchByDate'])->name('admin.search.bydate');
    Route::get('/admin/pesanan/{id}/detail', [AdminController::class, 'detail'])->name('admin.pesanan.detail');
    Route::get('/admin/invoice/download/{id}', [AdminController::class, 'AdminInvoiceDownload'])->name('admin.invoice.download');
    Route::get('/admin/laporan/pdf', [AdminController::class, 'generatePDF'])->name('laporan.pdf');
    Route::get('/admin/kategori/menu', [AdminController::class, 'KategoriMenu'])->name('admin.kategori.menu');
    Route::get('/admin/qr-code-koleksi', [AdminController::class, 'QRCodeKoleksi'])->name('admin.qrcode.koleksi');
    Route::get('/admin/tambah/kategori', [AdminController::class, 'tambahKategori'])->name('admin.tambah.kategori');
    Route::post('/admin/store/kategori', [AdminController::class, 'storeKategori'])->name('admin.store.kategori');
    Route::get('/admin/edit/kategori/{id}', [AdminController::class, 'editKategori'])->name('admin.edit.kategori');
    Route::put('/admin/update/kategori/{id}', [AdminController::class, 'updateKategori'])->name('admin.update.kategori');
    Route::delete('/admin/delete/kategori/{id}', [AdminController::class, 'deleteKategori'])->name('admin.delete.kategori');
    // Route::get('/admin/kelolakasir', [KelolaKasirController::class, 'index'])->name('admin.kelolakasir');
    // Route::post('/admin/kelolakasir/tambah', [KelolaKasirController::class, 'tambahkasir'])->name('admin.kelolakasir.tambah');
    // Route::get('/admin/edit/kasir/{id}', [KelolaKasirController::class, 'edit'])->name('admin.edit.kasir');
    // Route::get('/admin/delete/kasir/{id}', [KelolaKasirController::class, 'delete'])->name('admin.delete.kasir');
    // Route::put('/admin/update/kasir/{id}', [KelolaKasirController::class, 'update'])->name('admin.update.kasir');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
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
    Route::get('/admin/koleksi/detail/{id}', [CollectionController::class, 'show'])->name('admin.koleksi.detail');
    Route::get('/admin/koleksi/tambah', [CollectionController::class, 'create'])->name('admin.koleksi.create');
    Route::post('/admin/koleksi', [CollectionController::class, 'store'])->name('admin.koleksi.store');
    Route::get('/admin/koleksi/edit/{id}', [CollectionController::class, 'edit'])->name('admin.koleksi.edit');
    Route::put('/admin/koleksi/{id}', [CollectionController::class, 'update'])->name('admin.koleksi.update');
    Route::delete('/admin/koleksi/{id}', [CollectionController::class, 'destroy'])->name('admin.koleksi.delete');
});


require __DIR__ . '/auth.php';