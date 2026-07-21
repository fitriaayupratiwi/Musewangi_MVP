<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class KasirPesananController extends Controller
{
 /*   public function detail($id)
    {
        $pesanan = Pesanan::with('details.menu')->findOrFail($id);

        return view('kasir.detail', compact('pesanan'));
    }

    public function bayar($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Update status pembayaran
        $pesanan->status = 'lunas'; // contoh
        $pesanan->save();
x
        return redirect()->route(route: 'kasir.pesanan.detail', $pesanan->id)->with('success', 'Pembayaran berhasil!');
    }*/

    public function detail($id)
{
    $pesanan = Transaksi::with('details.menu')->findOrFail($id);
    return view('kasir.detail', compact('pesanan')); // Mengirimkan variabel $pesanan
}
}