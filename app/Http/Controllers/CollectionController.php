<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollectionController extends Controller
{

    // public function index()
    // {
    //     dd('Masuk Controller');
    //     $collections = Collection::latest()->get();
    //     return view(
    //         'Admin.koleksi.index',
    //         compact('collections')
    //     );
    // }

    public function index(Request $request)
{
    $query = Collection::query();

    if ($request->filled('cari')) {
        $query->where('nama_koleksi', 'like', '%' . $request->cari . '%')
              ->orWhere('no_registrasi', 'like', '%' . $request->cari . '%');
    }

    $collections = $query->paginate(10);

    return view('admin.koleksi.index', compact('collections'));
}



    public function create()
{
    $categories = Category::orderBy('nama')->get();

    return view('admin.koleksi.create', compact('categories'));
}

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'no_registrasi' => 'required|string|max:100',
            'nama_koleksi' => 'required|string|max:255',
            'asal' => 'required|string|max:255',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',

        ]);

        $foto = null;
        if ($request->hasFile('foto')) {

            $foto = $request->file('foto')
                ->store('koleksi', 'public');

        }

        Collection::create([
            'foto' => $foto,
            'no_registrasi' => $request->no_registrasi,
            'nama_koleksi' => $request->nama_koleksi,
            'asal' => $request->asal,
            'kondisi' => $request->kondisi,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.koleksi.index')
            ->with([
                'message' => 'Koleksi berhasil ditambahkan',
                'alert-type' => 'success'
            ]);
    }

    public function show(Collection $collection)
    {
        return view(
            'admin.koleksi.detail',
            compact('collection')
        );
    }

    public function edit(Collection $collection)
    {
        return view(
            'admin.koleksi.edit',
            compact('collection')
        );
    }

    public function update(Request $request, Collection $collection)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'no_registrasi' => 'required|string|max:100',
            'nama_koleksi' => 'required|string|max:255',
            'asal' => 'required|string|max:255',
            'kondisi' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        ]);

        $data = [
            'no_registrasi' => $request->no_registrasi,
            'nama_koleksi' => $request->nama_koleksi,
            'asal' => $request->asal,
            'kondisi' => $request->kondisi,
        ];

        if ($request->hasFile('foto')) {
            if ($collection->foto) {
                Storage::disk('public')
                    ->delete($collection->foto);
            }

            $data['foto'] = $request->file('foto')
                ->store('koleksi', 'public');
        }

        $collection->update($data);

        return redirect()
            ->route('admin.koleksi.index')
            ->with([
                'message' => 'Koleksi berhasil diperbarui',
                'alert-type' => 'success'
            ]);

    }

    public function destroy(Collection $collection)
    {
        if ($collection->foto) {
            Storage::disk('public')
                ->delete($collection->foto);
        }
        $collection->delete();


        return redirect()
            ->route('admin.koleksi.index')
            ->with([
                'message' => 'Koleksi berhasil dihapus',
                'alert-type' => 'success'
            ]);

    }

}
