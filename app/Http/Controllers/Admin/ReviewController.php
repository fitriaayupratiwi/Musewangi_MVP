<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\CollectionReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Tampilkan daftar moderasi ulasan pengunjung
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search');
        $collectionId = $request->query('koleksi_id');

        // Statistik ringkasan
        $stats = [
            'total'    => CollectionReview::count(),
            'pending'  => CollectionReview::pending()->count(),
            'approved' => CollectionReview::approved()->count(),
            'rejected' => CollectionReview::rejected()->count(),
            'avg_rating' => round((float)(CollectionReview::approved()->avg('rating') ?: 0), 1),
        ];

        // Query ulasan
        $query = CollectionReview::with('collection')->latest();

        if ($status === 'pending') {
            $query->pending();
        } elseif ($status === 'approved') {
            $query->approved();
        } elseif ($status === 'rejected') {
            $query->rejected();
        }

        if (!empty($collectionId)) {
            $query->where('collection_id', $collectionId);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_pengunjung', 'like', "%{$search}%")
                  ->orWhere('komentar', 'like', "%{$search}%")
                  ->orWhereHas('collection', function ($sub) use ($search) {
                      $sub->where('nama_koleksi', 'like', "%{$search}%");
                  });
            });
        }

        $reviews = $query->paginate(12)->withQueryString();
        $collections = Collection::orderBy('nama_koleksi')->select('id', 'nama_koleksi')->get();

        return view('admin.ulasan.index', compact('reviews', 'stats', 'status', 'search', 'collectionId', 'collections'));
    }

    /**
     * Setujui ulasan (Tampil di halaman publik)
     */
    public function approve($id)
    {
        $review = CollectionReview::with('collection')->findOrFail($id);
        $review->update(['status' => CollectionReview::STATUS_APPROVED]);

        try {
            DB::table('aktivitas')->insert([
                'aktivitas'  => 'Moderasi Ulasan',
                'objek'      => $review->nama_pengunjung . ' (' . ($review->collection->nama_koleksi ?? 'Koleksi') . ')',
                'keterangan' => 'Ulasan disetujui untuk tampil di halaman publik',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // ignore
        }

        return redirect()->back()->with([
            'message'    => "Ulasan dari {$review->nama_pengunjung} berhasil disetujui!",
            'alert-type' => 'success',
        ]);
    }

    /**
     * Tolak ulasan (Sembunyikan dari halaman publik)
     */
    public function reject($id)
    {
        $review = CollectionReview::with('collection')->findOrFail($id);
        $review->update(['status' => CollectionReview::STATUS_REJECTED]);

        try {
            DB::table('aktivitas')->insert([
                'aktivitas'  => 'Moderasi Ulasan',
                'objek'      => $review->nama_pengunjung . ' (' . ($review->collection->nama_koleksi ?? 'Koleksi') . ')',
                'keterangan' => 'Ulasan ditolak dan disembunyikan dari publik',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // ignore
        }

        return redirect()->back()->with([
            'message'    => "Ulasan dari {$review->nama_pengunjung} ditolak dan disembunyikan.",
            'alert-type' => 'warning',
        ]);
    }

    /**
     * Setujui semua ulasan yang pending sekaligus
     */
    public function bulkApprove(Request $request)
    {
        $count = CollectionReview::pending()->count();
        if ($count === 0) {
            return redirect()->back()->with([
                'message'    => 'Tidak ada ulasan baru yang menunggu moderasi.',
                'alert-type' => 'info',
            ]);
        }

        CollectionReview::pending()->update(['status' => CollectionReview::STATUS_APPROVED]);

        try {
            DB::table('aktivitas')->insert([
                'aktivitas'  => 'Moderasi Ulasan Massal',
                'objek'      => "{$count} Ulasan",
                'keterangan' => "Menyetujui {$count} ulasan pending sekaligus",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // ignore
        }

        return redirect()->back()->with([
            'message'    => "Berhasil menyetujui {$count} ulasan pengunjung sekaligus!",
            'alert-type' => 'success',
        ]);
    }

    /**
     * Hapus ulasan secara permanen
     */
    public function destroy($id)
    {
        $review = CollectionReview::with('collection')->findOrFail($id);
        $nama = $review->nama_pengunjung;
        $review->delete();

        try {
            DB::table('aktivitas')->insert([
                'aktivitas'  => 'Hapus Ulasan',
                'objek'      => $nama,
                'keterangan' => "Menghapus ulasan secara permanen dari sistem",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // ignore
        }

        return redirect()->back()->with([
            'message'    => 'Ulasan berhasil dihapus secara permanen.',
            'alert-type' => 'success',
        ]);
    }
}
