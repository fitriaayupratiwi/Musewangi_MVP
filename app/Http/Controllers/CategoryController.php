<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $kategori = Category::withCount('koleksis')->get();

        return view('admin.kategoriKoleksi', compact('kategori'));
    }

    public function create()
    {
        return redirect()->route('admin.kategori.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
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

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(Category $category)
    {
        return view('admin.kategori.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $category->update([
            'nama' => $request->nama,
        ]);
        DB::table('aktivitas')->insert([
            'aktivitas' => 'Edit Kategori',
            'objek' => $request->nama,
            'keterangan' => 'Kategori berhasil diperbarui',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(Category $category)
    {
        $namaKategori = $category->nama;

        $category->delete();

        DB::table('aktivitas')->insert([
            'aktivitas' => 'Hapus Kategori',
            'objek' => $namaKategori,
            'keterangan' => 'Kategori berhasil dihapus',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}