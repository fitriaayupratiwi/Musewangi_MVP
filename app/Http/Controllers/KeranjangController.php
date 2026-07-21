<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKeranjangRequest;
use App\Http\Requests\UpdateKeranjangRequest;
use App\Models\Keranjang;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\NomorMeja;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{

    public function index(Request $request)
    {
        $sessionId = $request->session()->getId();
        $nomor_mejas = NomorMeja::where('status', 'tersedia')->orderBy('nomor')->get();
        $keranjangs = Keranjang::where('session_id', $sessionId)->with('menu')->get();
        $totalBayar = $keranjangs->sum('total_harga');

        // Tambahan untuk popup detail
        $pesanan = Transaksi::where('session_id', $sessionId)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($request->from === 'kasir') {
            session(['from_kasir' => true]);
        }

        return view('customer.keranjang', compact('keranjangs', 'totalBayar', 'nomor_mejas', 'pesanan'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'quantity' => 'nullable|integer|min:1',
            'catatan' => 'nullable|string|max:255',
        ]);

        $menu = Menu::findOrFail($request->menu_id);

        $sessionId = $request->session()->getId();

        // ambil quantity dari request, default = 1
        $jumlah = $request->input('quantity', 1);

        $keranjang = Keranjang::where('menu_id', $request->menu_id)
            ->where('session_id', $sessionId)
            ->first();

        if ($keranjang) {
            $keranjang->jumlah += $jumlah;
            $keranjang->total_harga = $keranjang->jumlah * $menu->harga;
            $keranjang->catatan = $request->catatan ?? $keranjang->catatan;
            $keranjang->save();
        } else {
            Keranjang::create([
                'session_id' => $sessionId,
                'menu_id' => $request->menu_id,
                'harga_satuan' => $menu->harga,
                'jumlah' => $jumlah,
                'total_harga' => $menu->harga * $jumlah,
                'catatan' => $request->catatan,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function destroy($id)
    {
        $keranjang = Keranjang::findOrFail($id);
        $keranjang->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {

        $sessionId = $request->session()->getId();


        $keranjangs = Keranjang::where('session_id', $sessionId)->get();


      
        // $request->validate([
        //     "nomor_meja"=>"unique:transaksis,nomor_meja,required",
        // ]);
  
        if ($keranjangs->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong, tidak ada yang bisa dibayar.');
        }

        if (auth()->check() && auth()->user()->role == 'kasir') {
            $request->validate([
                'nomor_meja' => 'nullable|string|max:10',
                'nomor_meja_manual' => 'nullable|string|max:10',
            ]);
            $nomorMejaInput = $request->nomor_meja_manual ?: $request->nomor_meja;
        } else {
            $request->validate([
                'nomor_meja' => 'required|exists:nomor_mejas,nomor',
            ]);
            $nomorMejaInput = $request->nomor_meja;
        }

        if (!$nomorMejaInput) {
            return redirect()->back()->with('error', 'Nomor meja wajib diisi.');
        }

        $totalBayar = $keranjangs->sum('total_harga');

        $details = $keranjangs->map(function ($keranjang) {
            return [
                'menu_id' => $keranjang->menu_id,
                'nama' => $keranjang->menu->nama,
                'jumlah' => $keranjang->jumlah,
                'harga' => $keranjang->harga_satuan,
                'subtotal' => $keranjang->total_harga,
                'catatan' => $keranjang->catatan,
            ];
        });

        $nomorMeja = $request->session()->get('nomor_meja', $request->nomor_meja);

        $transaksi = Transaksi::create([
            'total_bayar' => $totalBayar,
            'nomor_meja' => $nomorMejaInput,
            'session_id' => $sessionId,
            'details' => $details->toJson(),
            'status' => 'aktif',
            'status_bayar' => 'belum bayar',
        ]);

        // Update nomor meja menjadi tidak tersedia
        $nomorMejaModel = NomorMeja::where('nomor', $nomorMejaInput)->first();
        if ($nomorMejaModel) {
            $nomorMejaModel->status = 'terisi';
            $nomorMejaModel->save();
        }

        //simpan nomor meja di session
        $request->session()->put('nomor_meja', $nomorMeja);

        Keranjang::where('session_id', $sessionId)->delete();

        return redirect()->route('customer.detailPesanan', $transaksi->id)->with('success', "Pesanan berhasil dibuat. Pesanan Anda akan segera diantarkan, silakan bayar nanti sebesar Rp. $totalBayar");
    }

    public function detailPesanan($id)
    {
        $pesanan = Transaksi::findOrFail($id);

        return view('customer.detailpesanan', compact('pesanan'));
    }

    public function update(Request $request, $id)
    {
        $keranjang = Keranjang::findOrFail($id);

        // aksi sesuai tombol
        if ($request->action === 'increment') {
            $keranjang->jumlah += 1;
        } elseif ($request->action === 'decrement' && $keranjang->jumlah > 1) {
            $keranjang->jumlah -= 1;
        } else {
            $keranjang->jumlah = $request->jumlah; // fallback jika user langsung edit input
        }

        // update total harga
        $keranjang->total_harga = $keranjang->jumlah * $keranjang->harga_satuan;
        $keranjang->save();

        return back()->with('success', 'Jumlah keranjang berhasil diperbarui.');
    }

    public function riwayatPesanan($nomor_meja)
    {
        $riwayat = Transaksi::where('nomor_meja', $nomor_meja)
            ->where('status', 'aktif')
            ->where('status_bayar', 'belum bayar')
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung total semua transaksi aktif & belum bayar
        $grandTotal = $riwayat->sum('total_bayar');

        return view('customer.riwayatPesanan', compact('riwayat', 'nomor_meja', 'grandTotal'));
    }

    public function pesanLagi(Request $request)
    {
        $nomorMeja = $request->session()->get('nomor_meja');

        if (!$nomorMeja) {
            return redirect()->route('customer.menu')->with('error', 'Nomor meja tidak ditemukan.');
        }

        return redirect()->route('customer.menu')->with('success', 'Pesan lagi untuk Meja ' . $nomorMeja);
    }
}
