<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Collection;
use App\Models\Category;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Transaksi;
use App\Models\PesananDetail;
use App\Models\Pesanan;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;



class AdminController extends Controller
{
//     public function index(Request $request)
// {
//     $query = Collection::query();

//     // Pencarian
//     if ($request->filled('cari')) {
//         $query->where('nama_koleksi', 'like', '%' . $request->cari . '%')
//               ->orWhere('no_registrasi', 'like', '%' . $request->cari . '%');
//     }

//     $koleksis = $query->paginate(10);

//     return view('admin.koleksi.index', compact('koleksis'));
// }
public function dashboard()
{
    return view('admin.dashboard');
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
    ->route('admin.koleksi.index')
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
    ->route('admin.koleksi.index')
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


    public function editKategori($id)
    {
        return redirect()->route('admin.kategori.menu')->with([
            'message' => 'Gunakan tombol edit pada tabel kategori.',
            'alert-type' => 'info',
        ]);
    }

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

//     public function akunKasir()
//     {
//         $kasirs = DB::table('users')->where('role', 'kasir')->get();
//         return view('admin.akunkasir', compact('kasirs'));
//     }

 public function AdminRiwayat(){
        return view('admin.riwayat');
    }
}
