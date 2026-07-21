<?php

use App\Http\Controllers\CustomerController;
// use App\Http\Controllers\KasirController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminController;
// use App\Http\Controllers\KelolaKasirController;
use Illuminate\Support\Facades\Route;

Route::get(
    '/menu',
    [MenuController::class, 'index']
)->name('customer.menu');
Route::get(
    '/',
    function () {
        return view('auth.login');
    }
);

Route::get('customer/keranjang', [KeranjangController::class, 'index'])->name('customer.keranjang.view');
Route::post('/customer/keranjang/add', [KeranjangController::class, 'addToCart'])->name('customer.keranjang.add');
Route::delete('/customer/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('customer.keranjang.delete');
Route::post('/customer/keranjang/checkout', [KeranjangController::class, 'checkout'])->name('customer.keranjang.checkout');
Route::get('/pesan-lagi', [KeranjangController::class, 'pesanLagi'])->name('customer.pesan.lagi');
Route::put('/keranjang/{id}/update', [KeranjangController::class, 'update'])->name('customer.keranjang.update');
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.show');
Route::get('/pesanan/{id}', [KeranjangController::class, 'detailPesanan'])->name('customer.detailPesanan');
Route::get('/riwayat/{nomor_meja}', [KeranjangController::class, 'riwayatPesanan'])->name('customer.riwayat');
Route::get('/menu', [CustomerController::class, 'menu'])->name('customer.menu');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    // Route::get('/kasir/dashboard', function () {
    //     return view('kasir.dashboard');
    // })->name('kasir.dashboard');
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Pesanan Kasir
    // Route::get('/kasir/pesanan', [KasirController::class, 'index'])->name('kasir.pesanan');
    // Route::get('/kasir/pesanan/{id}/bayar', [PesananController::class, 'showBayar'])->name('pesanan.bayar');
    // Route::post('/kasir/pesanan/{id}/bayar', [PesananController::class, 'prosesBayar'])->name('pesanan.bayar.proses');

});

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
    Route::get('/admin/tambah/kategori', [AdminController::class, 'tambahKategori'])->name('admin.tambah.kategori');
    Route::post('/admin/store/kategori', [AdminController::class, 'storeKategori'])->name('admin.store.kategori');
    Route::get('/admin/edit/kategori/{id}', [AdminController::class, 'editKategori'])->name('admin.edit.kategori');
    Route::post('/admin/update/kategori', [AdminController::class, 'updateKategori'])->name('admin.update.kategori');
    Route::get('/admin/delete/kategori/{id}', [AdminController::class, 'deleteKategori'])->name('admin.delete.kategori');
    // Route::get('/admin/kelolakasir', [KelolaKasirController::class, 'index'])->name('admin.kelolakasir');
    // Route::post('/admin/kelolakasir/tambah', [KelolaKasirController::class, 'tambahkasir'])->name('admin.kelolakasir.tambah');
    // Route::get('/admin/edit/kasir/{id}', [KelolaKasirController::class, 'edit'])->name('admin.edit.kasir');
    // Route::get('/admin/delete/kasir/{id}', [KelolaKasirController::class, 'delete'])->name('admin.delete.kasir');
    // Route::put('/admin/update/kasir/{id}', [KelolaKasirController::class, 'update'])->name('admin.update.kasir');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::put('/admin/menu/{id}/rekomendasi', [MenuController::class, 'updateRekomendasi'])->name('admin.update.rekomendasi');
});



require __DIR__ . '/auth.php';
