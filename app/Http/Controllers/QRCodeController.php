<?php

namespace App\Http\Controllers;

use App\Models\Koleksi;
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

        $query = Koleksi::query();

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_koleksi', 'like', '%' . $request->cari . '%')
                    ->orWhere('no_registrasi', 'like', '%' . $request->cari . '%')
                    ->orWhere('no_registrasi_lama', 'like', '%' . $request->cari . '%');
            });
        }

        $koleksis = $query->latest()->paginate(12)->withQueryString();

        $totalKoleksi = Koleksi::count();
        $totalQr = Koleksi::whereNotNull('qr_code')->count();
        $totalKosong = Koleksi::whereNull('qr_code')->count();

        return view('admin.qrcode.index', compact(
            'koleksis',
            'totalKoleksi',
            'totalQr',
            'totalKosong'
        ));
    }

    public function generate(Koleksi $koleksi)
    {
        $this->pastikanFolderQRCode();

        $namaQr = 'upload/qrcode/koleksi-' . $koleksi->id . '.svg';

        QrCode::size(300)->generate(
            route('collection.show', $koleksi->id),
            public_path($namaQr)
        );

        $koleksi->update([
            'qr_code' => $namaQr
        ]);

        return back()->with('success', 'QR Code berhasil dibuat');
    }

    public function download(Koleksi $koleksi)
    {
        if (!$koleksi->qr_code || !file_exists(public_path($koleksi->qr_code))) {
            return back()->with('error', 'QR Code belum tersedia');
        }

        return response()->download(
            public_path($koleksi->qr_code),
            'QR-' . $koleksi->nama_koleksi . '.svg'
        );
    }

    public function destroy(Koleksi $koleksi)
    {
        $nama = $koleksi->nama_koleksi;

        if ($koleksi->qr_code) {
            $path = public_path($koleksi->qr_code);

            if (file_exists($path)) {
                unlink($path);
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