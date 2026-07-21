<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\Menu;
use App\Models\Category;
use App\Models\PesananDetail;

class CustomerController extends Controller
{
    /**
     * Menampilkan daftar menu untuk pelanggan
     * dengan ikon Best Seller & Rekomendasi Chef
     */
    
    public function menu(Request $request)
    {
        // Ambil semua kategori beserta menu-nya
        $kategoris = Category::with('menus')->get();

                $bestSellers = Menu::where('is_best_seller', 1)->pluck('id')->toArray();

        // Ambil menu yang direkomendasikan oleh chef
        $recommendedMenus = Menu::where('is_recommended', true)->pluck('id')->toArray();

        // Ambil nomor meja dari session
        $nomorMeja = $request->session()->get('nomor_meja');
        return view('home', compact('kategoris', 'nomorMeja', 'bestSellers', 'recommendedMenus'));
    }

    public function riwayat(Request $request)
    {
        $sessionId = $request->session()->getId();
        $pesanan = Transaksi::where('session_id', $sessionId)->orderBy('created_at','desc')->first();

        if (!$pesanan) {
            return redirect()->back()->with('error', 'Anda belum memesan apapun.');
        }

        return view('customer.riwayat', compact('pesanan'));
    }
}
