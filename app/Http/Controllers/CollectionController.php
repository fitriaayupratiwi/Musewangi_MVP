<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CollectionController extends Controller
{
    /**
     * Tampilkan daftar koleksi
     */
    public function index()
    {
        $collections = Collection::latest()->get();

        return view('admin.koleksi.index', compact('collections'));
    }

    /**
     * Form tambah koleksi
     */
    public function create()
    {
        $categories = Category::orderBy('nama')->get();

        return view('admin.koleksi.create', compact('categories'));
    }

    /**
     * Detail koleksi admin
     */
    public function show($id)
    {
        $collection = Collection::findOrFail($id);

        return view('admin.koleksi.detail', compact('collection'));
    }

    /**
     * Simpan koleksi baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
            'foto_samping' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
            'foto_belakang' => [
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
            'nama_koleksi'  => 'required',
            'asal'          => 'required',
            'kondisi'       => 'required',
        ]);

        // UPLOAD FOTO dengan proteksi try/catch GD extension
        $foto = null;
        if ($request->hasFile('foto')) {
            try {
                $foto = $request->file('foto')->store('koleksi', 'public');
            } catch (\Throwable $e) {
                return redirect()->back()->withInput()->withErrors([
                    'foto' => 'Gagal memproses gambar. Pastikan ekstensi PHP GD aktif di server. (Error: ' . $e->getMessage() . ')'
                ]);
            }
        }

        // UPLOAD FOTO SAMPING
        $fotoSamping = null;
        if ($request->hasFile('foto_samping')) {
            try {
                $fotoSamping = $request->file('foto_samping')->store('koleksi', 'public');
            } catch (\Throwable $e) {
                // ignore or continue
            }
        }

        // UPLOAD FOTO BELAKANG
        $fotoBelakang = null;
        if ($request->hasFile('foto_belakang')) {
            try {
                $fotoBelakang = $request->file('foto_belakang')->store('koleksi', 'public');
            } catch (\Throwable $e) {
                // ignore or continue
            }
        }

        // UPLOAD VOICE OVER / AUDIO
        $voiceOver = null;
        if ($request->hasFile('voice_over')) {
            try {
                $voiceOver = $request->file('voice_over')->store('rekam-suara', 'public');
            } catch (\Throwable $e) {
                return redirect()->back()->withInput()->withErrors([
                    'voice_over' => 'Gagal mengunggah file audio.'
                ]);
            }
        }

        // Hubungkan kategori
        $category = null;
        if ($request->filled('kategori')) {
            $category = Category::where('nama', $request->kategori)->first();
        }

        // SIMPAN DATABASE
        $collection = Collection::create([
            'foto'               => $foto,
            'foto_samping'       => $fotoSamping,
            'foto_belakang'      => $fotoBelakang,
            'voice_over'         => $voiceOver,
            'rekam_suara'        => $voiceOver,
            'no_registrasi'      => $request->no_registrasi,
            'no_registrasi_lama' => $request->no_registrasi_lama,
            'nama_koleksi'       => $request->nama_koleksi,
            'kategori'           => $request->kategori,
            'category_id'        => $category ? $category->id : null,
            'jenis_benda'        => $request->jenis_benda,
            'tahun_pembuatan'    => $request->tahun_pembuatan,
            'asal'               => $request->asal,
            'kondisi'            => $request->kondisi,
            'deskripsi'          => $request->deskripsi,
        ]);

        // Auto-generate QR code SVG
        try {
            if (!file_exists(public_path('upload/qrcode'))) {
                mkdir(public_path('upload/qrcode'), 0755, true);
            }
            $namaQr = 'upload/qrcode/koleksi-' . $collection->kode_unik . '.svg';
            QrCode::size(300)->generate($collection->publicUrl(), public_path($namaQr));
            $collection->update(['qr_code' => $namaQr]);
        } catch (\Throwable $e) {
            // QR code generation error shouldn't block collection save
        }

        DB::table('aktivitas')->insert([
            'aktivitas'  => 'Tambah Koleksi',
            'objek'      => $request->nama_koleksi,
            'keterangan' => 'Koleksi berhasil ditambahkan ke sistem',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.koleksi.index')
            ->with([
                'message'    => 'Koleksi berhasil ditambahkan',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Form edit koleksi
     */
    public function edit($id)
    {
        $collection = Collection::findOrFail($id);
        $categories = Category::orderBy('nama')->get();

        return view('admin.koleksi.edit', compact('collection', 'categories'));
    }

    /**
     * Update koleksi
     */
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
            'foto_samping' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],
            'foto_belakang' => [
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
            'nama_koleksi'  => 'required',
            'asal'          => 'required',
            'kondisi'       => 'required',
        ]);

        $category = null;
        if ($request->filled('kategori')) {
            $category = Category::where('nama', $request->kategori)->first();
        }

        $data = [
            'no_registrasi'      => $request->no_registrasi,
            'no_registrasi_lama' => $request->no_registrasi_lama,
            'nama_koleksi'       => $request->nama_koleksi,
            'kategori'           => $request->kategori,
            'category_id'        => $category ? $category->id : $collection->category_id,
            'jenis_benda'        => $request->jenis_benda,
            'tahun_pembuatan'    => $request->tahun_pembuatan,
            'asal'               => $request->asal,
            'kondisi'            => $request->kondisi,
            'deskripsi'          => $request->deskripsi,
        ];

        // UPDATE FOTO dengan try/catch
        if ($request->hasFile('foto')) {
            try {
                if ($collection->foto) {
                    Storage::disk('public')->delete($collection->foto);
                }
                $data['foto'] = $request->file('foto')->store('koleksi', 'public');
            } catch (\Throwable $e) {
                return redirect()->back()->withInput()->withErrors([
                    'foto' => 'Gagal memproses gambar. Pastikan ekstensi PHP GD aktif di server.'
                ]);
            }
        }

        // UPDATE FOTO SAMPING
        if ($request->hasFile('foto_samping')) {
            try {
                if ($collection->foto_samping) {
                    Storage::disk('public')->delete($collection->foto_samping);
                }
                $data['foto_samping'] = $request->file('foto_samping')->store('koleksi', 'public');
            } catch (\Throwable $e) {
                // continue
            }
        }

        // UPDATE FOTO BELAKANG
        if ($request->hasFile('foto_belakang')) {
            try {
                if ($collection->foto_belakang) {
                    Storage::disk('public')->delete($collection->foto_belakang);
                }
                $data['foto_belakang'] = $request->file('foto_belakang')->store('koleksi', 'public');
            } catch (\Throwable $e) {
                // continue
            }
        }

        // UPDATE VOICE
        if ($request->hasFile('voice_over')) {
            try {
                if ($collection->voice_over) {
                    Storage::disk('public')->delete($collection->voice_over);
                }
                $uploadedVoice = $request->file('voice_over')->store('rekam-suara', 'public');
                $data['voice_over'] = $uploadedVoice;
                $data['rekam_suara'] = $uploadedVoice;
            } catch (\Throwable $e) {
                return redirect()->back()->withInput()->withErrors([
                    'voice_over' => 'Gagal mengunggah file audio.'
                ]);
            }
        }

        $collection->update($data);

        DB::table('aktivitas')->insert([
            'aktivitas'  => 'Edit Koleksi',
            'objek'      => $collection->nama_koleksi,
            'keterangan' => 'Data koleksi berhasil diperbarui',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.koleksi.index')
            ->with([
                'message'    => 'Koleksi berhasil diperbarui',
                'alert-type' => 'success'
            ]);
    }

    /**
     * Hapus koleksi
     */
    public function destroy($id)
    {
        $collection = Collection::findOrFail($id);

        // Hapus Foto
        if ($collection->foto) {
            Storage::disk('public')->delete($collection->foto);
        }

        if ($collection->foto_samping) {
            Storage::disk('public')->delete($collection->foto_samping);
        }

        if ($collection->foto_belakang) {
            Storage::disk('public')->delete($collection->foto_belakang);
        }

        // Hapus Voice
        if ($collection->voice_over) {
            Storage::disk('public')->delete($collection->voice_over);
        }

        // Hapus QR file jika ada
        if ($collection->qr_code && file_exists(public_path($collection->qr_code))) {
            @unlink(public_path($collection->qr_code));
        }

        $namaKoleksi = $collection->nama_koleksi;
        $collection->delete();

        DB::table('aktivitas')->insert([
            'aktivitas'  => 'Hapus Koleksi',
            'objek'      => $namaKoleksi,
            'keterangan' => 'Koleksi berhasil dihapus dari sistem',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.koleksi.index')
            ->with([
                'message'    => 'Koleksi berhasil dihapus',
                'alert-type' => 'success'
            ]);
    }

    /**
     * QR Code Generator / Modal per item
     */
    public function qrcode($id)
    {
        $collection = Collection::findOrFail($id);

        if (!$collection->qr_code || !file_exists(public_path($collection->qr_code))) {
            if (!file_exists(public_path('upload/qrcode'))) {
                mkdir(public_path('upload/qrcode'), 0755, true);
            }
            $namaQr = 'upload/qrcode/koleksi-' . $collection->kode_unik . '.svg';
            QrCode::size(300)->generate($collection->publicUrl(), public_path($namaQr));
            $collection->update(['qr_code' => $namaQr]);
        }

        return response()->download(
            public_path($collection->qr_code),
            'QR-' . \Illuminate\Support\Str::slug($collection->nama_koleksi) . '.svg'
        );
    }
}
