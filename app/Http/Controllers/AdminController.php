<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Category;
use App\Models\NomorMeja;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Transaksi;
use App\Models\PesananDetail;
use App\Models\Pesanan;
use Carbon\Carbon;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;



class AdminController extends Controller
{
    public function index(Request $request)
{
    $query = Collection::query();

    // Pencarian
    if ($request->filled('cari')) {
        $query->where('nama_koleksi', 'like', '%' . $request->cari . '%')
              ->orWhere('no_registrasi', 'like', '%' . $request->cari . '%');
    }

    $koleksis = $query->paginate(10);

    return view('admin.koleksi.index', compact('koleksis'));
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
        'foto'=>'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);
    $foto=null;

    if($request->hasFile('foto')){
        $foto=$request->file('foto')
        ->store('koleksi','public');
    }

    Collection::create([
        'no_registrasi'=>$request->no_registrasi,
        'nama_koleksi'=>$request->nama_koleksi,
        'asal'=>$request->asal,
        'kondisi'=>$request->kondisi,
        'deskripsi'=>$request->deskripsi,
        'foto'=>$foto
    ]);


    $notification = array(
        'message'=>'Koleksi berhasil ditambahkan',
        'alert-type'=>'success'
    );
    return redirect()
    ->route('admin.koleksi')
    ->with($notification);

}
    // End Method
public function editCollection($id)
{
    $collection = Collection::find($id);
    return view(
        'admin.koleksi.edit',
        compact('collection')
    );
}
     // End Method

     public function updateCollection(Request $request){
 $collection = Collection::find($request->id);
    $request->validate([
        'no_registrasi'=>'required',
        'nama_koleksi'=>'required',
        'asal'=>'required',
        'kondisi'=>'required'
    ]);
    $data=[
        'no_registrasi'=>$request->no_registrasi,
        'nama_koleksi'=>$request->nama_koleksi,
        'asal'=>$request->asal,
        'kondisi'=>$request->kondisi,
        'aksi'=>$request->aksi
    ];

    if($request->hasFile('foto')){
        if($collection->foto){
            Storage::disk('public')
            ->delete($collection->foto);

        }

        $data['foto']=$request->file('foto')
        ->store('koleksi','public');
    }
    $collection->update($data);



    return redirect()
    ->route('admin.koleksi')
    ->with([
        'message'=>'Koleksi berhasil diperbarui',
        'alert-type'=>'success'
    ]);

    }
    // End Method

    public function deleteCollection($id)
{

    $item = Collection::find($id);


    if($item->foto){

        Storage::disk('public')
        ->delete($item->foto);

    }


    $item->delete();


    return redirect()
    ->back()
    ->with([
        'message'=>'Koleksi berhasil dihapus',
        'alert-type'=>'success'
    ]);

}

    public function nomorMeja()
    {
        $nomor_mejas = NomorMeja::all();
        return view('admin.nomormeja', compact('nomor_mejas'));
    }

    public function tambahNomorMeja()
    {
        $nomor_mejas = NomorMeja::all();
        return view('admin.tambahNomormeja', compact('nomor_mejas'));
    }

    public function storeNomorMeja(Request $request){

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

    public function KategoriMenu()
{
    $kategori = Category::withCount('koleksis')
        ->orderBy('nama')
        ->get();

    return view('admin.kategoriMenu', compact('kategori'));
}

    public function QRCodeKoleksi()
{
    $kategori = Category::withCount('koleksis')
        ->orderBy('nama')
        ->get();

    return view('admin.qrcodeKoleksi', compact('kategori'));
}

    public function tambahKategori()
    {
        return redirect()->route('admin.kategori.menu');
    }

    public function storeKategori(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255|unique:categories,nama',
    ], [
        'nama.unique' => 'Kategori dengan nama tersebut sudah ada.',
    ]);

    Category::create([
        'nama' => $request->nama,
    ]);

    return redirect()->route('admin.kategori.menu')->with('success', 'Kategori berhasil ditambahkan');
}
    // End Method

    public function editKategori($id)
    {
        return redirect()->route('admin.kategori.menu')->with([
            'message' => 'Gunakan tombol edit pada tabel kategori.',
            'alert-type' => 'info',
        ]);
    }
     // End Method

     public function updateKategori(UpdateCategoryRequest $request, $id)
    {
        $kategori = Category::findOrFail($id);

        $kategori->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kategori.menu')->with([
            'message' => 'Kategori berhasil diperbarui',
            'alert-type' => 'success',
        ]);
    }

 public function deleteKategori($id)
    {
        $item = Category::findOrFail($id);
        $item->delete();

        return redirect()->back()->with([
            'message' => 'Kategori berhasil dihapus',
            'alert-type' => 'success',
        ]);
    }

    public function akunKasir()
    {
        $kasirs = DB::table('users')->where('role', 'kasir')->get();
        return view('admin.akunkasir', compact('kasirs'));
    }

    public function dashboard()
    {
        //Customer
        $todayCustomer = Transaksi::whereDate('created_at', Carbon::today())->count();
        $yesterdayCustomer = Transaksi::whereDate('created_at', Carbon::yesterday())->count();
        $customerChange = $this->calculatePercentage($todayCustomer, $yesterdayCustomer);

        //Order
        $todayMenu = 0;

        $transaksis = Transaksi::whereDate('created_at', Carbon::today())->get();

        foreach ($transaksis as $transaksi) {
            $details = json_decode($transaksi->details);

            foreach ($details as $item) {
                $todayMenu += $item->jumlah;
            }
        }
        $yesterdayMenu = 0;

        $transaksis = Transaksi::whereDate('created_at', Carbon::yesterday())->get();

        foreach ($transaksis as $transaksi) {
            $details = json_decode($transaksi->details);

            foreach ($details as $item) {
                $yesterdayMenu += $item->jumlah;
            }
        }
        $menuChange = $this->calculatePercentage($todayMenu, $yesterdayMenu);

        //Income
        $todayIncome = Transaksi::whereDate('created_at', Carbon::today())
                            ->where('status_bayar', 'sudah bayar') 
                            ->sum('total_bayar');
        $yesterdayIncome = Transaksi::whereDate('created_at', Carbon::yesterday())
                    ->where('status_bayar', 'sudah bayar')
                    ->sum('total_bayar');

        $incomeChange = $this->calculatePercentage($todayIncome, $yesterdayIncome);

        // Income per bulan (total_bayar)
        $incomeDataRaw = Transaksi::selectRaw('MONTH(created_at) as month, SUM(total_bayar) as total')
        ->whereYear('created_at', Carbon::now()->year)
        ->where('status_bayar', 'sudah bayar')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        $customerDataRaw = Transaksi::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Buat array 12 bulan, default 0
        $incomeData = array_fill(0, 12, 0);

        // Masukkan data sesuai bulan
        foreach ($incomeDataRaw as $item) {
            // $item->month = 1..12, array index = 0..11
            $incomeData[$item->month - 1] = $item->total;
        }

        // Buat array 12 bulan, default 0
        $customerData = array_fill(0, 12, 0);

        // Masukkan data sesuai bulan
        foreach ($customerDataRaw as $item) {
            // $item->month = 1..12, array index = 0..11
            $customerData[$item->month - 1] = $item->total;
        }

        // === Tambahan: Menu Best Seller ===


            // Ambil semua transaksi yang sudah bayar
            $transaksiAll = Transaksi::where('status_bayar', 'sudah bayar')->get();

            $menuSales = [];
            foreach ($transaksiAll as $transaksi) {
                $details = json_decode($transaksi->details, true);

                if ($details && is_array($details)) {
                    foreach ($details as $item) {
                        if (!isset($menuSales[$item['nama']])) {
                            $menuSales[$item['nama']] = 0;
                        }
                        $menuSales[$item['nama']] += $item['jumlah'];
                    }
                }
            }

            $bestSeller = null;
            if (!empty($menuSales)) {
                arsort($menuSales);
                $bestSellerName = array_key_first($menuSales);
                $bestSellerCount = $menuSales[$bestSellerName];
                $bestSeller = Menu::where('nama', $bestSellerName)->first();
                if ($bestSeller) {
                    $bestSeller->jumlah_terjual = $bestSellerCount;
                }
            }

            // === Tambahan: Best Seller Per Kategori ===
        $kategoriCamilan = Category::where('nama', 'Camilan')->first();
        $kategoriMinuman = Category::where('nama', 'Minuman')->first();
        $kategoriMakanan = Category::where('nama', 'Makanan')->first();

        $bestSellerCamilan = null;
        $bestSellerMinuman = null;
        $bestSellerMakanan = null;

        if ($kategoriMakanan) {
            $menuSalesMakanan = [];
            foreach ($transaksiAll as $transaksi) {
                $details = json_decode($transaksi->details, true);
                if ($details && is_array($details)) {
                    foreach ($details as $item) {
                        $menu = Menu::where('nama', $item['nama'])->first();
                        if ($menu && $menu->kategori_id == $kategoriMakanan->id) {
                            if (!isset($menuSalesMakanan[$menu->nama])) {
                                $menuSalesMakanan[$menu->nama] = 0;
                            }
                            $menuSalesMakanan[$menu->nama] += $item['jumlah'];
                        }
                    }
                }
            }

            if (!empty($menuSalesMakanan)) {
                arsort($menuSalesMakanan);
                $bestSellerNameMakanan = array_key_first($menuSalesMakanan);
                $bestSellerCountMakanan = $menuSalesMakanan[$bestSellerNameMakanan];
                $bestSellerMakanan = Menu::where('nama', $bestSellerNameMakanan)->first();
                if ($bestSellerMakanan) {
                    $bestSellerMakanan->jumlah_terjual = $bestSellerCountMakanan;
                }
            }
        }

        if ($kategoriCamilan) {
            $menuSalesCamilan = [];
            foreach ($transaksiAll as $transaksi) {
                $details = json_decode($transaksi->details, true);
                if ($details && is_array($details)) {
                    foreach ($details as $item) {
                        $menu = Menu::where('nama', $item['nama'])->first();
                        if ($menu && $menu->kategori_id == $kategoriCamilan->id) {
                            if (!isset($menuSalesCamilan[$menu->nama])) {
                                $menuSalesCamilan[$menu->nama] = 0;
                            }
                            $menuSalesCamilan[$menu->nama] += $item['jumlah'];
                        }
                    }
                }
            }

            if (!empty($menuSalesCamilan)) {
                arsort($menuSalesCamilan);
                $bestSellerNameCamilan = array_key_first($menuSalesCamilan);
                $bestSellerCountCamilan = $menuSalesCamilan[$bestSellerNameCamilan];
                $bestSellerCamilan = Menu::where('nama', $bestSellerNameCamilan)->first();
                if ($bestSellerCamilan) {
                    $bestSellerCamilan->jumlah_terjual = $bestSellerCountCamilan;
                }
            }
        }

        if ($kategoriMinuman) {
            $menuSalesMinuman = [];
            foreach ($transaksiAll as $transaksi) {
                $details = json_decode($transaksi->details, true);
                if ($details && is_array($details)) {
                    foreach ($details as $item) {
                        $menu = Menu::where('nama', $item['nama'])->first();
                        if ($menu && $menu->kategori_id == $kategoriMinuman->id) {
                            if (!isset($menuSalesMinuman[$menu->nama])) {
                                $menuSalesMinuman[$menu->nama] = 0;
                            }
                            $menuSalesMinuman[$menu->nama] += $item['jumlah'];
                        }
                    }
                }
            }

            if (!empty($menuSalesMinuman)) {
                arsort($menuSalesMinuman);
                $bestSellerNameMinuman = array_key_first($menuSalesMinuman);
                $bestSellerCountMinuman = $menuSalesMinuman[$bestSellerNameMinuman];
                $bestSellerMinuman = Menu::where('nama', $bestSellerNameMinuman)->first();
                if ($bestSellerMinuman) {
                    $bestSellerMinuman->jumlah_terjual = $bestSellerCountMinuman;
                }
            }
        }

        // Tandai best seller utama
        if ($bestSeller) {
            $bestSeller->update(['is_best_seller' => 1]);
        }

        // Tandai best seller per kategori
        if ($bestSellerMakanan) {
            $bestSellerMakanan->update(['is_best_seller' => 1]);
        }
        if ($bestSellerMinuman) {
            $bestSellerMinuman->update(['is_best_seller' => 1]);
        }
        if ($bestSellerCamilan) {
            $bestSellerCamilan->update(['is_best_seller' => 1]);
        }



        return view('admin.dashboard', compact('todayCustomer', 'customerChange', 'customerData', 'todayMenu', 'menuChange', 'todayIncome', 'incomeChange', 'incomeData', 'bestSeller', 'bestSellerMakanan', 'bestSellerMinuman', 'bestSellerCamilan'));
    }

    private function calculatePercentage($today, $yesterday)
    {
        if ($yesterday == 0) {
            return $today > 0 ? 100 : 0;
        }

        return (($today - $yesterday) / $yesterday) * 100;
    }
}