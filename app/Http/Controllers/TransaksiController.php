<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransaksiRequest;
use App\Http\Requests\UpdateTransaksiRequest;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\NomorMeja;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        // Mengambil semua data transaksi dari database
        $transaksis = Transaksi::all();  // Atau bisa juga dengan query yang lebih spesifik
        return view('kasir.pesanan', compact('transaksis'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_baru' => 'required|in:aktif,nonaktif',
        ]);
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = $request->status_baru;
        $transaksi->waktu_diantar = $request->status_baru === 'nonaktif'
            ? now()
            : null;
        $transaksi->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function updateStatusBayar(Request $request, $id)
    {
        $request->validate([
            'statusbayar_baru' => 'required|in:sudah bayar,belum bayar',
        ]);
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status_bayar = $request->statusbayar_baru;
        $transaksi->waktu_bayar = $request->statusbayar_baru === 'sudah bayar'
            ? now()
            : null;

        // dd($request->statusbayar_baru);

        $transaksi->save();

        if ($request->statusbayar_baru === 'sudah bayar') {
            $meja = NomorMeja::where('nomor', $transaksi->nomor_meja)->first();
            if ($meja) {
                $meja->status = 'tersedia';
                $meja->save();
            }
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

}
