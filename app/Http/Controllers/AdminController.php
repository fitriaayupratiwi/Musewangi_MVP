<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Collection;
use App\Models\Category;

class AdminController extends Controller
{
    public function index()
    {
        $collections = Collection::latest()->get();

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
            'nama'=>'required|string|max:255|unique:categories,nama'
        ]);


        Category::create([
            'nama'=>$request->nama
        ]);


        return redirect()
            ->route('admin.kategori.menu')
            ->with([
                'message'=>'Kategori berhasil ditambahkan',
                'alert-type'=>'success'
            ]);
    }


    public function editKategori($id)
    {
        $kategori = Category::findOrFail($id);

        return view(
            'admin.editKategori',
            compact('kategori')
        );
    }


    public function updateKategori(Request $request)
    {
        $request->validate([
            'id'=>'required|exists:categories,id',
            'nama'=>'required|string|max:255'
        ]);


        Category::findOrFail($request->id)
            ->update([
                'nama'=>$request->nama
            ]);


        return redirect()
            ->route('admin.kategori.menu')
            ->with([
                'message'=>'Kategori berhasil diperbarui',
                'alert-type'=>'success'
            ]);
    }


    public function deleteKategori($id)
    {
        $kategori = Category::findOrFail($id);

        $kategori->delete();


        return redirect()
            ->back()
            ->with([
                'message'=>'Kategori berhasil dihapus',
                'alert-type'=>'success'
            ]);
    }



    // ======================
    // AKUN KASIR
    // ======================

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