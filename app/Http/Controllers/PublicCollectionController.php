<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Category;
use App\Models\CollectionReview;
use Illuminate\Http\Request;

class PublicCollectionController extends Controller
{
    /**
     * Halaman Dashboard Mobile Pengunjung (Screen 2 & Screen 1)
     */
    public function home()
    {
        $collections = Collection::with('category')->latest()->get();
        $categories = Category::withCount('koleksis')->get();
        $totalCollections = Collection::count();
        $totalCategories = Category::count();
        $featuredCollection = Collection::with('category')->first();

        return view('public.home', compact('collections', 'categories', 'totalCollections', 'totalCategories', 'featuredCollection'));
    }

    /**
     * Halaman Scanner QR Code di Browser HP (Screen 3)
     */
    public function scanner()
    {
        return view('public.scanner');
    }

    /**
     * Halaman Layar Transisi Verifikasi QR Berhasil (Screen 4)
     *
     * @param string $kode UUID unik koleksi
     */
    public function verify(string $kode)
    {
        $collection = Collection::where('kode_unik', $kode)
            ->when(is_numeric($kode), function ($query) use ($kode) {
                $query->orWhere('id', $kode);
            })
            ->first();

        if (!$collection) {
            return response()->view('public.koleksi-404', ['kode' => $kode], 404);
        }

        return view('public.verify', compact('collection'));
    }

    /**
     * Halaman Detail Koleksi untuk Pengunjung (Screen 5 & Screen 6)
     *
     * @param string $kode UUID unik koleksi (kode_unik)
     */
    public function show(string $kode)
    {
        $collection = Collection::with('reviews')
            ->where('kode_unik', $kode)
            ->when(is_numeric($kode), function ($query) use ($kode) {
                $query->orWhere('id', $kode);
            })
            ->first();

        if (!$collection) {
            return response()->view('public.koleksi-404', [
                'kode' => $kode
            ], 404);
        }

        return view('public.koleksi-detail', compact('collection'));
    }

    /**
     * Simpan ulasan dan rating baru dari pengunjung
     *
     * @param Request $request
     * @param string $kode
     */
    public function storeReview(Request $request, string $kode)
    {
        $collection = Collection::where('kode_unik', $kode)
            ->when(is_numeric($kode), function ($query) use ($kode) {
                $query->orWhere('id', $kode);
            })
            ->firstOrFail();

        $validated = $request->validate([
            'nama_pengunjung' => 'nullable|string|max:60',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|max:1000',
        ]);

        CollectionReview::create([
            'collection_id' => $collection->id,
            'nama_pengunjung' => $validated['nama_pengunjung'] ?: 'Pengunjung Museum',
            'rating' => $validated['rating'],
            'komentar' => $validated['komentar'],
            'status' => CollectionReview::STATUS_PENDING,
        ]);

        return redirect()->route('public.koleksi.show', $collection->kode_unik)
            ->with('success', 'Ulasan Anda berhasil dikirim! Ulasan akan tampil setelah diverifikasi oleh petugas museum.');
    }
}
