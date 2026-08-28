<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    private function pastikanFolderQRCode(): void
    {
        if (!file_exists(public_path('upload/qrcode'))) {
            mkdir(public_path('upload/qrcode'), 0755, true);
        }
    }

    public function index(Request $request)
    {
        $this->pastikanFolderQRCode();

        $query = Collection::query();

        if ($request->filled('cari')) {
            $keyword = $request->cari;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_koleksi', 'like', '%' . $keyword . '%')
                    ->orWhere('no_registrasi', 'like', '%' . $keyword . '%')
                    ->orWhere('no_registrasi_lama', 'like', '%' . $keyword . '%')
                    ->orWhere('kategori', 'like', '%' . $keyword . '%');
            });
        }

        $koleksis = $query->latest()->paginate(12)->withQueryString();

        $totalKoleksi = Collection::count();
        $totalQr = Collection::whereNotNull('qr_code')->count();
        $totalKosong = Collection::whereNull('qr_code')->count();

        return view('admin.qrcode.index', compact(
            'koleksis',
            'totalKoleksi',
            'totalQr',
            'totalKosong'
        ));
    }

    public function generate(Collection $koleksi)
    {
        $this->pastikanFolderQRCode();

        $namaQr = 'upload/qrcode/koleksi-' . $koleksi->kode_unik . '.svg';

        QrCode::size(300)->generate(
            $koleksi->publicUrl(),
            public_path($namaQr)
        );

        $koleksi->update([
            'qr_code' => $namaQr
        ]);

        return back()->with('success', 'QR Code berhasil dibuat');
    }

    public function download(Collection $koleksi)
    {
        $this->pastikanFolderQRCode();

        if (!$koleksi->qr_code || !file_exists(public_path($koleksi->qr_code))) {
            $namaQr = 'upload/qrcode/koleksi-' . $koleksi->kode_unik . '.svg';
            QrCode::size(300)->generate(
                $koleksi->publicUrl(),
                public_path($namaQr)
            );
            $koleksi->update(['qr_code' => $namaQr]);
        }

        return response()->download(
            public_path($koleksi->qr_code),
            'QR-' . \Illuminate\Support\Str::slug($koleksi->nama_koleksi) . '.svg'
        );
    }

    /**
     * Tampilan Cetak Label Etalase Koleksi Museum (Sesuai Standar Placard Museum)
     */
    public function cetakLabel(Collection $koleksi)
    {
        return view('admin.qrcode.label-cetak', compact('koleksi'));
    }

    public function destroy(Collection $koleksi)
    {
        $nama = $koleksi->nama_koleksi;

        if ($koleksi->qr_code) {
            $path = public_path($koleksi->qr_code);

            if (file_exists($path)) {
                @unlink($path);
            }
        }

        $koleksi->update([
            'qr_code' => null
        ]);

        return redirect()
            ->route('admin.qrcode.index')
            ->with('success', 'QR Code "' . $nama . '" berhasil dihapus.');
    }
}