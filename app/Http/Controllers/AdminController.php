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


        $collection->delete();


        return redirect()
            ->back()
            ->with([
                'message'=>'Koleksi berhasil dihapus',
                'alert-type'=>'success'
            ]);
    }



    // ======================
    // KATEGORI
    // ======================

    public function KategoriMenu()
    {
        $kategori = Category::latest()->get();

        return view(
            'admin.kategoriMenu',
            compact('kategori')
        );
    }


    public function tambahKategori()
    {
        return view('admin.tambahKategori');
    }


    public function storeKategori(Request $request)
    {
        $request->validate([
            'nomor' => 'required|integer|min:1|unique:nomor_mejas,nomor',
            'status' => 'required|in:tersedia,terisi,reservasi,rusak',
        ]);

        // Cek apakah nomor meja sudah ada
        $existingMeja = NomorMeja::where('nomor', $request->nomor)->first();
        if ($existingMeja) {
            $notification = array(
                'message' => 'Nomor meja sudah ada',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        // Jika belum ada, simpan nomor meja baru
        if ($request->status == 'tersedia') {
            NomorMeja::create([
                'nomor' => $request->nomor,
                'status' => 'tersedia',
            ]);
        } else {
            NomorMeja::create([
                'nomor' => $request->nomor,
                'status' => $request->status,
            ]);
        }

        $notification = array(
            'message' => 'Nomor meja berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.nomormeja')->with($notification);

    }
    // End Method

    public function editNomorMeja($id){
        $nomor_meja = NomorMeja::find($id);
        return view('admin.editNomormeja', compact('nomor_meja'));
    }

    public function updateNomorMeja(Request $request){

        $nomor_meja_id = $request->id;

            NomorMeja::find($nomor_meja_id)->update([
                'nomor' => $request->nomor,
                'status' => $request->status,
            ]);

            $notification = array(
                'message' => 'Nomor Meja Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('admin.nomormeja')->with($notification);

    }

    public function deleteNomorMeja($id){
        $item = NomorMeja::find($id);
        
    $item->delete();

        $notification = array(
            'message' => 'Nomor Meja Delete Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

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

    public function KategoriMenu(){
     $kategori = Category::all();
        return view('admin.kategoriMenu', compact('kategori'));
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

    return redirect()->route('admin.kategori.menu')->with([
        'message' => 'Kategori berhasil diperbarui',
        'alert-type' => 'success',
    ]);
}

 public function deleteKategori($id){
    $item = Category::findOrFail($id);
    $item->save();

    $item->delete();

    $notification = [
        'message' => 'Kategori berhasil dihapus',
        'alert-type' => 'success'
    ];

    return redirect()->back()->with($notification);
    }

    public function akunKasir()
    {
        $kasirs = DB::table('users')
            ->where('role','kasir')
            ->get();


        return view(
            'admin.akunkasir',
            compact('kasirs')
        );
    }



    // ======================
    // DASHBOARD MUSEWANGI
    // ======================

    public function dashboard()
    {
        $totalKoleksi = Collection::count();

        $totalKategori = Category::count();


        $koleksiTerbaru = Collection::latest()
            ->take(5)
            ->get();


        return view(
            'admin.dashboard',
            compact(
                'totalKoleksi',
                'totalKategori',
                'koleksiTerbaru'
            )
        );
    }

}
