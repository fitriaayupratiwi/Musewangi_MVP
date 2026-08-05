<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollectionController extends Controller
{

    public function index()
    {
        $collections = Collection::latest()->get();

        return view(
            'admin.koleksi.index',
            compact('collections')
        );
    }


    public function create()
{
    $categories = Category::orderBy('nama')->get();

    return view('admin.koleksi.create', compact('categories'));
}

    public function show($id)
    {
        $collection = Collection::findOrFail($id);

        return view(
            'admin.koleksi.detail',
            compact('collection')
        );
    }


    public function store(Request $request)
    {
        $request->validate([
            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            'voice_over' => [
                'nullable',
                'mimes:mp3,wav,ogg,webm',
                'max:10240'
            ],


            'no_registrasi' => 'required',
            'nama_koleksi' => 'required',
            'asal' => 'required',
            'kondisi' => 'required',

        ]);


        // UPLOAD FOTO

        $foto = null;
        if($request->hasFile('foto')){
            $foto = $request->file('foto')
                ->store('koleksi','public');

        }

        // UPLOAD VOICE OVER
  
        $voiceOver = null;
        if($request->hasFile('voice_over')){

            $voiceOver = $request->file('voice_over')
                ->store('rekam-suara','public');

        }

        // SIMPAN DATABASE

        Collection::create([

            'foto' => $foto,
            'voice_over' => $voiceOver,
            'no_registrasi' => $request->no_registrasi,
            'no_registrasi_lama' => $request->no_registrasi_lama,
            'nama_koleksi' => $request->nama_koleksi,
            'kategori' => $request->kategori,
            'jenis_benda' => $request->jenis_benda,
            'tahun_pembuatan' => $request->tahun_pembuatan,
            'asal' => $request->asal,
            'kondisi' => $request->kondisi,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.koleksi.index')
            ->with([
                'message'=>'Koleksi berhasil ditambahkan',
                'alert-type'=>'success'

            ]);

    }

    public function edit($id)
    {

        $collection = Collection::findOrFail($id);

        return view(
            'admin.koleksi.edit',
            compact('collection')
        );

    }

    public function update(Request $request, $id)
    {
    $collection = Collection::findOrFail($id);
        $request->validate([
            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],


            'voice_over' => [
                'nullable',
                'mimes:mp3,wav,ogg,webm',
                'max:10240'
            ],


            'no_registrasi' => 'required',
            'nama_koleksi' => 'required',
            'asal' => 'required',
            'kondisi' => 'required',
        ]);




        $data = [
            'no_registrasi' => $request->no_registrasi,
            'no_registrasi_lama' => $request->no_registrasi_lama,
            'nama_koleksi' => $request->nama_koleksi,
            'kategori' => $request->kategori,
            'jenis_benda' => $request->jenis_benda,
            'tahun_pembuatan' => $request->tahun_pembuatan,
            'asal' => $request->asal,
            'kondisi' => $request->kondisi,
            'deskripsi' => $request->deskripsi,
        ];

        // UPDATE FOTO

        if($request->hasFile('foto')){

            if($collection->foto){
                Storage::disk('public')
                    ->delete($collection->foto);

            }

            $data['foto'] = $request->file('foto')
                ->store('koleksi','public');


        }

        // UPDATE VOICE

        if($request->hasFile('voice_over')){
            if($collection->voice_over){


                Storage::disk('public')
                    ->delete($collection->voice_over);
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


  public function destroy($id)
{

    $collection = Collection::findOrFail($id);


    // Hapus Foto
    if($collection->foto){

        Storage::disk('public')
            ->delete($collection->foto);

    }


    // Hapus Voice
    if($collection->voice_over){

        Storage::disk('public')
            ->delete($collection->voice_over);

    }


    $collection->delete();


    return redirect()

        ->route('admin.koleksi')

        ->with([

            'message'=>'Koleksi berhasil dihapus',

            'alert-type'=>'success'

        ]);

}
}
