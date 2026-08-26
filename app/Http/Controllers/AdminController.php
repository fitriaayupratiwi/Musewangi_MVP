<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Collection;
use App\Models\Category;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Transaksi;
use App\Models\PesananDetail;
use App\Models\Pesanan;
use Carbon\Carbon;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;



class AdminController extends Controller
{
    public function index()
    {
        $collections = Collection::all();
        return view('admin.koleksi.index', compact('collections'));
    }

    public function tambahkoleksi()
    {
        return view('admin.koleksi.create');
    }


    public function storeKoleksi(Request $request)
    {
        $request->validate([
            'no_registrasi'=>'required',
            'nama_koleksi'=>'required',
            'asal'=>'required',
            'kondisi'=>'required',
            'foto'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'voice_over'=>'nullable|mimes:mp3,wav,ogg,webm|max:10240'
        ]);


        $foto = null;
        $voice = null;


        if($request->hasFile('foto')){
            $foto = $request->file('foto')
                ->store('koleksi','public');
        }


        if($request->hasFile('voice_over')){
            $voice = $request->file('voice_over')
                ->store('rekam-suara','public');
        }


        Collection::create([
            'no_registrasi'=>$request->no_registrasi,
            'no_registrasi_lama'=>$request->no_registrasi_lama,
            'nama_koleksi'=>$request->nama_koleksi,
            'kategori'=>$request->kategori,
            'jenis_benda'=>$request->jenis_benda,
            'tahun_pembuatan'=>$request->tahun_pembuatan,
            'asal'=>$request->asal,
            'kondisi'=>$request->kondisi,
            'deskripsi'=>$request->deskripsi,
            'foto'=>$foto,
            'voice_over'=>$voice
        ]);

            DB::table('aktivitas')->insert([
            'aktivitas' => 'Tambah Koleksi',
            'objek' => $request->nama_koleksi,
            'keterangan' => 'Koleksi berhasil ditambahkan ke sistem',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.koleksi')
            ->with([
                'message'=>'Koleksi berhasil ditambahkan',
                'alert-type'=>'success'
            ]);
    }


    public function editCollection($id)
    {
        $collection = Collection::findOrFail($id);

        return view(
            'admin.koleksi.edit',
            compact('collection')
        );
    }


    public function updateCollection(Request $request)
    {
        $collection = Collection::findOrFail($request->id);


        $request->validate([
            'no_registrasi'=>'required',
            'nama_koleksi'=>'required',
            'asal'=>'required',
            'kondisi'=>'required',
            'foto'=>'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'voice_over'=>'nullable|mimes:mp3,wav,ogg,webm|max:10240'
        ]);


        $data = [
            'no_registrasi'=>$request->no_registrasi,
            'no_registrasi_lama'=>$request->no_registrasi_lama,
            'nama_koleksi'=>$request->nama_koleksi,
            'kategori'=>$request->kategori,
            'jenis_benda'=>$request->jenis_benda,
            'tahun_pembuatan'=>$request->tahun_pembuatan,
            'asal'=>$request->asal,
            'kondisi'=>$request->kondisi,
            'deskripsi'=>$request->deskripsi
        ];


        if($request->hasFile('foto')){

            if($collection->foto){
                Storage::disk('public')->delete($collection->foto);
            }

            $data['foto'] = $request->file('foto')
                ->store('koleksi','public');
        }


        if($request->hasFile('voice_over')){

            if($collection->voice_over){
                Storage::disk('public')->delete($collection->voice_over);
            }

            $data['voice_over'] = $request->file('voice_over')
                ->store('rekam-suara','public');
        }


        $collection->update($data);
        DB::table('aktivitas')->insert([
        'aktivitas' => 'Edit Koleksi',
        'objek' => $request->nama_koleksi,
        'keterangan' => 'Data koleksi berhasil diperbarui',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

        return redirect()
            ->route('admin.koleksi')
            ->with([
                'message'=>'Koleksi berhasil diperbarui',
                'alert-type'=>'success'
            ]);
    }


    public function deleteCollection($id)
    {
        $collection = Collection::findOrFail($id);


        if($collection->foto){
            Storage::disk('public')->delete($collection->foto);
        }


        if($collection->voice_over){
            Storage::disk('public')->delete($collection->voice_over);
        }

        DB::table('aktivitas')->insert([
        'aktivitas' => 'Hapus Koleksi',
        'objek' => $collection->nama_koleksi,
        'keterangan' => 'Koleksi berhasil dihapus dari sistem',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
        $collection->delete();


        return redirect()
            ->back()
            ->with([
                'message'=>'Koleksi berhasil dihapus',
                'alert-type'=>'success'
            ]); }


    public function AdminLaporan(){
        return view('admin.laporan');
    }

   public function AdminSearchByDate(Request $request)
    {
        $tanggalAwal = Carbon::parse($request->tanggal_awal)->startOfDay();
        $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();

        $transaksis = Transaksi::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])->get();
        $totalPendapatan = $transaksis->sum('total_bayar');

        return view('admin.search_by_date', compact('transaksis', 'tanggalAwal', 'tanggalAkhir', 'totalPendapatan'));
    }

    public function detail($id)
    {
        $pesanan = Transaksi::with('details.menu')->findOrFail($id);
        $pesanan->details = json_decode($pesanan->details, true);
        return view('admin.detail', compact('pesanan'));
    }

    public function AdminInvoiceDownload($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $details = json_decode($transaksi->details, true); // true = hasil array

        // Pastikan hasilnya array
        if (!is_array($details)) {
            abort(500, 'Format data details tidak valid.');
        }

        $totalPrice = 0;
        foreach ($details as $item) {
            $totalPrice += $item['harga'] * $item['jumlah'];
        }

        $pdf = Pdf::loadView('admin.invoice_download', [
            'transaksi' => $transaksi,
            'details' => $details,
            'totalPrice' => $totalPrice,
        ])->setPaper('a4');

        return $pdf->download('invoice.pdf');

    }

    public function generatePDF(Request $request)
{
     $tanggalAwal = Carbon::parse($request->tanggalAwal)->startOfDay();
    $tanggalAkhir = Carbon::parse($request->tanggalAkhir)->endOfDay();

    $transaksis = Transaksi::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])->get();
    $totalPendapatan = $transaksis->sum('total_bayar');

    if ($transaksis->isEmpty()) {
        return back()->with('error', 'Tidak ada data transaksi pada rentang tanggal tersebut.');
    }

    $pdf = Pdf::loadView('admin.pdf', compact('transaksis', 'tanggalAwal', 'tanggalAkhir', 'totalPendapatan'));
    return $pdf->download('laporan_transaksi.pdf');
}

public function tambahKategori()
    {
        $kategori = Category::all();
        return view('admin.tambahKategori', compact('kategori'));
    }

    public function storeKategori(Request $request){

        $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama',
            ]);

            Category::create([
            'nama' => $request->nama,
            ]);
            DB::table('aktivitas')->insert([
            'aktivitas' => 'Tambah Kategori',
            'objek' => $request->nama,
            'keterangan' => 'Kategori berhasil ditambahkan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $notification = array(
            'message' => 'Kategori berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.kategori.menu')->with($notification);

    }
    // End Method
    public function editKategori($id){
        $kategori  = Category::find($id);
        return view('admin.editKategori', compact('kategori'));
    }

     public function updateKategori(Request $request)
{
    $request->validate([
        'id' => 'required|exists:categories,id',
        'nama' => 'required|string|max:255',
    ]);

    Category::findOrFail($request->id)->update([
        'nama' => $request->nama,
    ]);
        DB::table('aktivitas')->insert([
        'aktivitas' => 'Edit Kategori',
        'objek' => $request->nama,
        'keterangan' => 'Kategori berhasil diperbarui',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('admin.kategori.menu')->with([
        'message' => 'Kategori berhasil diperbarui',
        'alert-type' => 'success',
    ]);
}

 public function deleteKategori($id){
    $item = Category::findOrFail($id);
    $item->save();

        DB::table('aktivitas')->insert([
        'aktivitas' => 'Hapus Kategori',
        'objek' => $item->nama,
        'keterangan' => 'Kategori berhasil dihapus',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    $item->delete();

    $notification = [
        'message' => 'Kategori berhasil dihapus',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
    }
// ======================
// DASHBOARD MUSEWANGI
// ======================

public function dashboard()
{
    $totalKoleksi = Collection::count();

    $totalKategori = Category::count();

    $aktivitas = DB::table('aktivitas')
        ->latest()
        ->take(5)
        ->get();

    return view(
        'admin.dashboard',
        compact(
            'totalKoleksi',
            'totalKategori',
            'aktivitas'
        )
    );
}

public function riwayat()
{
    $search = request('search');

    $aktivitas = DB::table('aktivitas')
        ->when($search, function ($query) use ($search) {

            $query->where(function ($q) use ($search) {

                $q->where('aktivitas', 'like', '%' . $search . '%')
                  ->orWhere('objek', 'like', '%' . $search . '%')
                  ->orWhere('keterangan', 'like', '%' . $search . '%');

            });

        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view(
        'admin.riwayat',
        compact('aktivitas')
    );
}
public function hapusRiwayat($id)
{
    DB::table('aktivitas')
        ->where('id', $id)
        ->delete();

    return redirect()
        ->route('admin.riwayat')
        ->with('success', 'Riwayat berhasil dihapus');
}


public function bulkDeleteRiwayat(Request $request)
{
    $request->validate([
        'ids' => 'required|string',
    ]);

    $ids = explode(',', $request->ids);

    DB::table('aktivitas')
        ->whereIn('id', $ids)
        ->delete();

    return redirect()
        ->route('admin.riwayat')
        ->with([
            'message' => 'Riwayat aktivitas berhasil dihapus.',
            'alert-type' => 'success'
        ]);
}

}