<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\UniqueConstraintViolationException;

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
            'nama' => 'required|string|max:255|unique:categories,nama',
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Kategori "' . $request->nama . '" sudah ada di dalam sistem.',
        ]);

        try {
            Category::create([
                'nama' => trim($request->nama),
            ]);

            DB::table('aktivitas')->insert([
                'aktivitas' => 'Tambah Kategori',
                'objek' => trim($request->nama),
                'keterangan' => 'Kategori berhasil ditambahkan',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()
                ->route('admin.kategori.index')
                ->with([
                    'message' => 'Kategori "' . $request->nama . '" berhasil ditambahkan.',
                    'alert-type' => 'success'
                ])
                ->with('success', 'Kategori berhasil ditambahkan');
        } catch (UniqueConstraintViolationException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Kategori "' . $request->nama . '" sudah ada di dalam sistem!',
                    'alert-type' => 'warning'
                ])
                ->withErrors(['nama' => 'Kategori "' . $request->nama . '" sudah ada di sistem.']);
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Gagal menambahkan kategori: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }

    public function edit(Category $category)
    {
        return view('admin.editKategori', ['kategori' => $category, 'category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama,' . $category->id,
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Kategori "' . $request->nama . '" sudah digunakan.',
        ]);

        try {
            $namaLama = $category->nama;
            $category->update([
                'nama' => trim($request->nama),
            ]);

            DB::table('aktivitas')->insert([
                'aktivitas' => 'Edit Kategori',
                'objek' => trim($request->nama),
                'keterangan' => 'Kategori ' . $namaLama . ' diperbarui menjadi ' . trim($request->nama),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()
                ->route('admin.kategori.index')
                ->with([
                    'message' => 'Kategori berhasil diperbarui.',
                    'alert-type' => 'success'
                ])
                ->with('success', 'Kategori berhasil diupdate');
        } catch (UniqueConstraintViolationException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Kategori "' . $request->nama . '" sudah ada di dalam sistem!',
                    'alert-type' => 'warning'
                ])
                ->withErrors(['nama' => 'Kategori "' . $request->nama . '" sudah ada di sistem.']);
        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Gagal memperbarui kategori: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }

    public function destroy(Category $category)
    {
        try {
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
                ->with([
                    'message' => 'Kategori "' . $namaKategori . '" berhasil dihapus.',
                    'alert-type' => 'success'
                ])
                ->with('success', 'Kategori berhasil dihapus');
        } catch (\Throwable $e) {
            return redirect()
                ->route('admin.kategori.index')
                ->with([
                    'message' => 'Gagal menghapus kategori: ' . $e->getMessage(),
                    'alert-type' => 'error'
                ]);
        }
    }
}