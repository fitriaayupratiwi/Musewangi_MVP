<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Admin Musewangi | Detail Koleksi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .page-bg { background: linear-gradient(135deg, #F5EFE3 0%, #EDE3CF 40%, #F0E8D5 100%); min-height: 100vh; }

        .detail-card {
            background: white;
            border-radius: 22px;
            border: 1.5px solid #EDD9A3;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(183,137,33,0.1);
        }

        .detail-header {
            background: linear-gradient(135deg, #1D2745 0%, #253256 100%);
            padding: 28px 32px;
            position: relative;
            overflow: hidden;
        }
        .detail-header::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 160px; height: 160px;
            border-radius: 50%;
            background: rgba(199,152,28,0.12);
        }
        .detail-header::after {
            content: '';
            position: absolute;
            bottom: -30px; left: 60px;
            width: 100px; height: 100px;
            border-radius: 50%;
            background: rgba(199,152,28,0.07);
        }

        .info-row {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .info-label {
            font-size: 11px;
            font-weight: 600;
            color: #9A8F7A;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #1D2745;
        }

        .badge-kondisi {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }
        .badge-baik { background: #ECFDF5; color: #065F46; border: 1.5px solid #A7F3D0; }
        .badge-rusak_ringan { background: #FFFBEB; color: #92400E; border: 1.5px solid #FDE68A; }
        .badge-rusak_berat { background: #FEF2F2; color: #991B1B; border: 1.5px solid #FECACA; }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            border: none;
        }
        .btn-edit-col { background: linear-gradient(135deg,#3B5BDB,#7048E8); color: white; box-shadow: 0 4px 12px rgba(59,91,219,0.3); }
        .btn-edit-col:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(59,91,219,0.4); }
        .btn-back { background: white; color: #555; border: 1.5px solid #DDD0A8; }
        .btn-back:hover { border-color: #B78921; color: #1D2745; background: #FFF8E8; }
        .btn-delete-col { background: #FEF2F2; color: #DC2626; border: 1.5px solid #FECACA; }
        .btn-delete-col:hover { background: #DC2626; color: white; border-color: #DC2626; }

        .media-section { background: #FAFAFA; border-radius: 16px; border: 1.5px solid #F0E4C2; padding: 16px; }

        .qr-box {
            background: white;
            border: 2px solid #EDD9A3;
            border-radius: 16px;
            padding: 16px;
            text-align: center;
        }
    </style>
</head>

<body x-data="{ 'darkMode': false, 'sidebarToggle': false }"
    x-init="darkMode = JSON.parse(localStorage.getItem('darkMode') || 'false');
    $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{ 'dark bg-gray-900': darkMode === true }"
    class="relative min-w-screen page-bg">

    @include('admin.body.sidebar')
    <div x-show="sidebarToggle" @click="sidebarToggle = false"
        class="fixed inset-0 z-40 bg-black/50 lg:hidden" x-transition.opacity></div>
    @include('admin.body.header')

    <main class="pt-16 transition-all duration-300 p-5 lg:ml-64 z-10">
        <div class="mx-auto max-w-5xl">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-[#7A6F5C] mb-5">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#B78921] transition flex items-center gap-1">
                    <i class="fa-solid fa-house text-xs"></i> Dashboard
                </a>
                <i class="fa-solid fa-chevron-right text-xs text-[#B0A080]"></i>
                <a href="{{ route('admin.koleksi.index') }}" class="hover:text-[#B78921] transition">Koleksi</a>
                <i class="fa-solid fa-chevron-right text-xs text-[#B0A080]"></i>
                <span class="text-[#1D2745] font-semibold truncate max-w-xs">{{ $koleksi->nama }}</span>
            </nav>

            <div class="detail-card">

                {{-- Card Header --}}
                <div class="detail-header">
                    <div class="relative z-10 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-semibold text-yellow-300 bg-white/10 px-3 py-1 rounded-full">
                                    {{ $koleksi->kategori->nama ?? 'Tanpa Kategori' }}
                                </span>
                                @php
                                    $kondisiData = match($koleksi->kondisi) {
                                        'baik' => ['badge-baik', 'fa-circle-check', 'Baik'],
                                        'rusak_ringan' => ['badge-rusak_ringan', 'fa-circle-exclamation', 'Rusak Ringan'],
                                        'rusak_berat' => ['badge-rusak_berat', 'fa-circle-xmark', 'Rusak Berat'],
                                        default => ['', '', '-']
                                    };
                                @endphp
                                <span class="badge-kondisi {{ $kondisiData[0] }}">
                                    <i class="fa-solid {{ $kondisiData[1] }} text-xs"></i> {{ $kondisiData[2] }}
                                </span>
                            </div>
                            <h1 class="text-2xl font-bold text-white leading-tight">{{ $koleksi->nama }}</h1>
                            <p class="text-blue-200 text-sm mt-1 font-mono">{{ $koleksi->no_registrasi_baru }}</p>
                        </div>
                        <div class="flex gap-2 flex-shrink-0">
                            <a href="{{ route('admin.koleksi.edit', $koleksi->id) }}" class="action-btn btn-edit-col">
                                <i class="fa-solid fa-pen text-xs"></i> Edit
                            </a>
                            <a href="{{ route('admin.koleksi.index') }}" class="action-btn btn-back">
                                <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        {{-- LEFT: Foto + Media --}}
                        <div class="lg:col-span-1 space-y-4">

                            {{-- Foto --}}
                            <div class="aspect-square rounded-2xl overflow-hidden bg-[#F5EFE3] border-2 border-[#EDD9A3] flex items-center justify-center">
                                @if ($koleksi->foto)
                                    <img src="{{ asset($koleksi->foto) }}" class="w-full h-full object-cover" alt="{{ $koleksi->nama }}">
                                @else
                                    <div class="text-center">
                                        <i class="fa-solid fa-image text-5xl text-[#D9C28F] mb-3"></i>
                                        <p class="text-xs text-[#9A8F7A]">Belum ada foto</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Audio Player --}}
                            @if ($koleksi->audio)
                                <div class="media-section">
                                    <p class="text-xs font-bold text-[#1D2745] mb-2 flex items-center gap-2">
                                        <i class="fa-solid fa-headphones text-[#3B5BDB]"></i> Narasi Audio
                                    </p>
                                    <audio controls class="w-full rounded-xl">
                                        <source src="{{ asset($koleksi->audio) }}">
                                        Browser Anda tidak mendukung audio.
                                    </audio>
                                </div>
                            @endif

                            {{-- QR Code --}}
                            @if ($koleksi->qr_code)
                                <div class="qr-box">
                                    <p class="text-xs font-bold text-[#1D2745] mb-3 flex items-center justify-center gap-2">
                                        <i class="fa-solid fa-qrcode text-[#B78921]"></i> QR Code Koleksi
                                    </p>
                                    <img src="{{ asset($koleksi->qr_code) }}" class="w-32 h-32 mx-auto" alt="QR Code">
                                    <a href="{{ route('admin.koleksi.qrcode.download', $koleksi->id) }}"
                                        class="inline-flex items-center gap-1.5 mt-3 text-xs font-semibold text-[#B78921] hover:text-[#9A7219] transition">
                                        <i class="fa-solid fa-download"></i> Unduh QR Code
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- RIGHT: Detail Info --}}
                        <div class="lg:col-span-2">
                            <h2 class="text-base font-bold text-[#1D2745] mb-5 flex items-center gap-2">
                                <span class="w-1 h-5 bg-[#B78921] rounded-full inline-block"></span>
                                Informasi Koleksi
                            </h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5 mb-6">
                                <div class="info-row">
                                    <span class="info-label">Nama Koleksi</span>
                                    <span class="info-value">{{ $koleksi->nama }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Kategori</span>
                                    <span class="info-value">
                                        <span class="bg-[#FFF3D1] text-[#7B5200] px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ $koleksi->kategori->nama ?? '-' }}
                                        </span>
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">No. Registrasi Baru</span>
                                    <span class="info-value font-mono text-[#B78921]">{{ $koleksi->no_registrasi_baru }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">No. Registrasi Lama</span>
                                    <span class="info-value font-mono">{{ $koleksi->no_registrasi_lama ?? '-' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Jenis Benda</span>
                                    <span class="info-value">{{ $koleksi->jenis_benda }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Tahun Pembuatan</span>
                                    <span class="info-value">{{ $koleksi->tahun_pembuatan ?? '-' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Asal / Daerah</span>
                                    <span class="info-value">{{ $koleksi->asal ?? '-' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Kondisi</span>
                                    <span>
                                        <span class="badge-kondisi {{ $kondisiData[0] }}">
                                            <i class="fa-solid {{ $kondisiData[1] }} text-xs"></i> {{ $kondisiData[2] }}
                                        </span>
                                    </span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Ditambahkan</span>
                                    <span class="info-value">{{ $koleksi->created_at ? $koleksi->created_at->format('d M Y, H:i') : '-' }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Terakhir Diperbarui</span>
                                    <span class="info-value">{{ $koleksi->updated_at ? $koleksi->updated_at->format('d M Y, H:i') : '-' }}</span>
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            @if ($koleksi->deskripsi)
                                <div class="bg-[#F9F5EC] border border-[#EDD9A3] rounded-xl p-5 mb-6">
                                    <p class="text-xs font-bold text-[#7B5200] uppercase tracking-widest mb-2">Deskripsi</p>
                                    <p class="text-sm text-[#3A3026] leading-relaxed">{{ $koleksi->deskripsi }}</p>
                                </div>
                            @endif

                            {{-- Action row --}}
                            <div class="flex flex-wrap gap-3 pt-4 border-t border-[#F0E4C2]">
                                <a href="{{ route('admin.koleksi.edit', $koleksi->id) }}" class="action-btn btn-edit-col">
                                    <i class="fa-solid fa-pen text-xs"></i> Edit Koleksi
                                </a>
                                <form action="{{ route('admin.koleksi.destroy', $koleksi->id) }}" method="POST" id="deleteForm">
                                    @csrf @method('DELETE')
                                </form>
                                <button type="button" onclick="confirmDelete()" class="action-btn btn-delete-col">
                                    <i class="fa-solid fa-trash text-xs"></i> Hapus
                                </button>
                                <a href="{{ route('admin.koleksi.index') }}" class="action-btn btn-back">
                                    <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete() {
            Swal.fire({
                title: 'Hapus Koleksi?',
                html: `Yakin ingin menghapus koleksi <strong>"{{ $koleksi->nama }}"</strong>?<br>Data, foto, audio, dan QR Code akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#6B7280',
                confirmButtonText: '<i class="fa-solid fa-trash mr-1"></i> Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: { popup: 'rounded-2xl' }
            }).then(result => {
                if (result.isConfirmed) document.getElementById('deleteForm').submit();
            });
        }
    </script>
</body>
</html>
