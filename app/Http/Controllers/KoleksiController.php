<?php

namespace App\Http\Controllers;

use App\Models\Koleksi;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KoleksiController extends Controller
{
    /**
     * Folder-folder upload yang dipakai fitur koleksi.
     */
    private function pastikanFolderUpload(): void
    {
        foreach (['upload/koleksi', 'upload/audio', 'upload/qrcode'] as $folder) {
            if (!file_exists(public_path($folder))) {
                mkdir(public_path($folder), 0755, true);
            }
        }
    }

    /**
     * Daftar seluruh koleksi (admin).
     */
    public function index(Request $request)
    {
        $query = Koleksi::with('kategori')->latest();

        if ($request->filled('cari')) {
            $keyword = $request->cari;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('no_registrasi_baru', 'like', "%{$keyword}%")
                    ->orWhere('no_registrasi_lama', 'like', "%{$keyword}%");
            });
        }

        $koleksis = $query->paginate(10)->withQueryString();

        return view('admin.koleksi.index', compact('koleksis'));
    }

    /**
     * Form tambah koleksi.
     */
    public function create()
    {
        $categories = Category::orderBy('nama')->get();
        return view('admin.koleksi.create', compact('categories'));
    }

    /**
     * Simpan koleksi baru + generate QR Code.
     */
    public function store(Request $request)
    {
        $this->pastikanFolderUpload();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_registrasi_baru' => 'required|string|max:100|unique:koleksis,no_registrasi_baru',
            'no_registrasi_lama' => 'nullable|string|max:100',
            'kategori_id' => 'required|exists:categories,id',
            'jenis_benda' => 'required|string|max:255',
            'tahun_pembuatan' => 'nullable|string|max:50',
            'asal' => 'nullable|string|max:255',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'audio' => 'nullable|mimes:mp3,wav,ogg|max:10240',
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $manager = new ImageManager(new Driver());
            $namaFile = hexdec(uniqid()) . '.' . $foto->getClientOriginalExtension();
            $img = $manager->read($foto);
            $img->resize(600, 600)->save(public_path('upload/koleksi/' . $namaFile));
            $validated['foto'] = 'upload/koleksi/' . $namaFile;
        }

        if ($request->hasFile('audio')) {
            $audio = $request->file('audio');
            $namaAudio = hexdec(uniqid()) . '.' . $audio->getClientOriginalExtension();
            $audio->move(public_path('upload/audio'), $namaAudio);
            $validated['audio'] = 'upload/audio/' . $namaAudio;
        }

        $koleksi = Koleksi::create($validated);

        // Generate QR Code yang mengarah ke halaman detail publik koleksi ini
        $namaQr = 'upload/qrcode/koleksi-' . $koleksi->id . '.svg';
        QrCode::size(300)->generate(route('koleksi.show', $koleksi->id), public_path($namaQr));
        $koleksi->update(['qr_code' => $namaQr]);

        $notification = [
            'message' => 'Koleksi berhasil ditambahkan',
            'alert-type' => 'success',
        ];

        return redirect()->route('admin.koleksi.index')->with($notification);
    }

    /**
     * Detail koleksi untuk admin (lihat lengkap + riwayat singkat).
     */
    public function show(Koleksi $koleksi)
    {
        $koleksi->load('kategori');
        return view('admin.koleksi.show', compact('koleksi'));
    }

    /**
     * Form edit koleksi.
     */
    public function edit(Koleksi $koleksi)
    {
        $categories = Category::orderBy('nama')->get();
        return view('admin.koleksi.edit', compact('koleksi', 'categories'));
    }

    /**
     * Update koleksi.
     */
    public function update(Request $request, Koleksi $koleksi)
    {
        $this->pastikanFolderUpload();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_registrasi_baru' => 'required|string|max:100|unique:koleksis,no_registrasi_baru,' . $koleksi->id,
            'no_registrasi_lama' => 'nullable|string|max:100',
            'kategori_id' => 'required|exists:categories,id',
            'jenis_benda' => 'required|string|max:255',
            'tahun_pembuatan' => 'nullable|string|max:50',
            'asal' => 'nullable|string|max:255',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'audio' => 'nullable|mimes:mp3,wav,ogg|max:10240',
        ]);

        if ($request->hasFile('foto')) {
            if ($koleksi->foto && file_exists(public_path($koleksi->foto))) {
                unlink(public_path($koleksi->foto));
            }
            $foto = $request->file('foto');
            $manager = new ImageManager(new Driver());
            $namaFile = hexdec(uniqid()) . '.' . $foto->getClientOriginalExtension();
            $img = $manager->read($foto);
            $img->resize(600, 600)->save(public_path('upload/koleksi/' . $namaFile));
            $validated['foto'] = 'upload/koleksi/' . $namaFile;
        }

        if ($request->hasFile('audio')) {
            if ($koleksi->audio && file_exists(public_path($koleksi->audio))) {
                unlink(public_path($koleksi->audio));
            }
            $audio = $request->file('audio');
            $namaAudio = hexdec(uniqid()) . '.' . $audio->getClientOriginalExtension();
            $audio->move(public_path('upload/audio'), $namaAudio);
            $validated['audio'] = 'upload/audio/' . $namaAudio;
        }

        $koleksi->update($validated);

        $notification = [
            'message' => 'Koleksi berhasil diperbarui',
            'alert-type' => 'success',
        ];

        return redirect()->route('admin.koleksi.index')->with($notification);
    }

    /**
     * Hapus koleksi beserta file-file terkait (foto, audio, qr code).
     */
    public function destroy(Koleksi $koleksi)
    {
        foreach (['foto', 'audio', 'qr_code'] as $field) {
            if ($koleksi->$field && file_exists(public_path($koleksi->$field))) {
                unlink(public_path($koleksi->$field));
            }
        }

        $koleksi->delete();

        $notification = [
            'message' => 'Koleksi berhasil dihapus',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    /**
     * Halaman daftar QR Code seluruh koleksi (admin).
     */
    public function qrcode(Request $request)
    {
        $query = Koleksi::with('kategori')->latest();

        if ($request->filled('cari')) {
            $keyword = $request->cari;
            $query->where('nama', 'like', "%{$keyword}%");
        }

        $koleksis = $query->paginate(10)->withQueryString();

        return view('admin.koleksi.qrcode', compact('koleksis'));
    }

    /**
     * Unduh file QR Code satu koleksi.
     */
    public function qrcodeDownload(Koleksi $koleksi)
    {
        if (!$koleksi->qr_code || !file_exists(public_path($koleksi->qr_code))) {
            abort(404, 'QR Code belum tersedia untuk koleksi ini.');
        }

        return response()->download(
            public_path($koleksi->qr_code),
            'qrcode-' . \Illuminate\Support\Str::slug($koleksi->nama) . '.svg'
        );
    }

    /**
     * Halaman publik: detail koleksi setelah QR Code dipindai pengunjung.
     */
    public function publicShow(Koleksi $koleksi)
    {
        $koleksi->load('kategori');
        return view('koleksi.show', compact('koleksi'));
    }
}
