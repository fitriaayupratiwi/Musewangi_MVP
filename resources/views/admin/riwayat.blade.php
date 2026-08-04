<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Admin Musewangi | Riwayat </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .page-bg {
            background: #F5EFE3;
        }

        table {
            border-collapse: separate;
            border-spacing: 0 16px;
        }

        tbody tr {
            background: white;
            border-radius: 18px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, .08);
        }

        tbody td:first-child {
            border-radius: 16px 0 0 16px;
        }

        tbody td:last-child {
            border-radius: 0 16px 16px 0;
        }

        tbody td {
            padding: 20px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body x-data="qrPage()" x-init="init()" :class="{ 'dark bg-gray-900': darkMode === true }"
    class="relative min-w-screen page-bg font-sans antialiased">
    @include('admin.body.sidebar')

    <div x-show="sidebarToggle" @click="sidebarToggle = false" class="fixed inset-0 z-40 bg-black/50 lg:hidden"
        x-transition.opacity></div>

    @include('admin.body.header')

    <main class="pt-16 transition-all duration-300 p-5 lg:ml-64 z-10">
        <div class="mx-auto max-w-6xl">
            <div class="mb-6 flex items-start justify-between gap-4 flex-wrap">
                <div class="mb-3">

                    <h1 class="text-3xl font-extrabold text-[#1D2745]">
                        Riwayat
                    </h1>

                    <p class="text-[#5D5D5D] mt-2">
                        Lihat riwayat aktivitas admin serta perubahan data koleksi yang terjadi dalam sistem.
                    </p>

                </div>
                {{-- <div>
                    <div class="flex items-center gap-3 mb-1">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#B78921] to-[#E8B84B] flex items-center justify-center shadow-lg shadow-yellow-400/30">
                            <i class="fa-solid fa-qrcode text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-[#1D2745]">QR Code Koleksi</h1>
                            <p class="text-sm text-[#7A6F5C]">Lihat, unduh, dan kelola QR Code setiap koleksi agar mudah
                                dipindai.</p>
                        </div>
                    </div>
                </div> --}}

                {{-- <a href="{{ url('/admin/koleksi') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#B78921] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:brightness-110">
                    <i class="fa-solid fa-layer-group"></i>
                    Ke Data Koleksi
                </a> --}}
            </div>

            {{-- @php
                $koleksis = $koleksis ?? collect();
                $collection = method_exists($koleksis, 'getCollection')
                    ? $koleksis->getCollection()
                    : collect($koleksis);
                $isPaginator = method_exists($koleksis, 'total');
                $totalKoleksi = $totalKoleksi ?? ($isPaginator ? $koleksis->total() : $collection->count());
                $totalQr = $totalQr ?? $collection->filter(fn($k) => !empty($k->qr_code))->count();
                $totalKosong = $totalKosong ?? $collection->filter(fn($k) => empty($k->qr_code))->count();
            @endphp --}}



            {{-- <div class="stat-card bg-[#A87200]">
                <div class="stat-icon"><i class="fa-solid fa-qrcode"></i></div>
                <div class="stat-label">QR Tersedia</div>
                <div class="stat-value">{{ number_format($totalQr) }}</div>
                <div class="stat-sub">Koleksi yang sudah punya QR</div>
            </div>

            <div class="stat-card bg-[#A33636]">
                <div class="stat-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="stat-label">Belum Ada QR</div>
                <div class="stat-value">{{ number_format($totalKosong) }}</div>
                <div class="stat-sub">Perlu dibuatkan QR Code</div>
            </div> --}}
        </div>

        <div class="section-header">
            {{-- <div class="flex items-center gap-3 flex-wrap">
                <div>
                    <h2 class="text-base font-bold text-[#1D2745]">Daftar QR Code</h2>
                    <p class="text-sm text-[#7A6F5C]">{{ $totalKoleksi }} koleksi ditemukan</p>
                </div>
                <span class="badge-count">{{ $totalKoleksi }} koleksi</span>
            </div> --}}

            {{-- <form method="GET" action="{{ route('admin.qrcode.koleksi') }}" class="w-full sm:w-[320px]">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#B78921]"></i>
                    <input id="searchInput" type="text" name="cari" value="{{ request('cari') }}"
                        placeholder="Cari nama / no. registrasi...">
                    @if (request('cari'))
                        <a href="{{ route('admin.qrcode.koleksi') }}" title="Hapus pencarian"
                            class="clear-search absolute right-4 top-1/2 -translate-y-1/2 text-[#B0A080] hover:text-[#B78921]">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </a>
                    @endif
                </div>
            </form> --}}
        </div>

        <div class="overflow-hidden rounded-[22px] border border-[#C9981C] bg-[#EFE5D2] mt-6">

            <div class="px-6 py-4">
                <table class="w-full">

                    <thead>
                        <tr class="text-[#1D2745] text-sm font-bold">
                            {{-- <th class="py-4 w-24"></th> --}}
                            <th>Foto</th>
                            <th>No. Registrasi</th>
                            <th>Nama Koleksi</th>
                            <th>Kategori</th>
                            <th>Asal</th>
                            <th>Kondisi</th>
                        </tr>
                    </thead>

                </table>
            </div>

            <div class="bg-white rounded-t-[24px] shadow-lg mx-2 mb-2 p-2">

                <table class="w-full">

                    <tbody>

                        {{-- @forelse($koleksis as $koleksi) --}}
                        <tr class="border-b border-gray-100 hover:bg-[#faf8f3] transition">

                            <td class="py-5 w-24">

                                {{-- @if ($koleksi->foto) --}}
                                {{-- <img src="{{ asset($koleksi->foto) }}" class="w-16 h-16 rounded-xl object-cover"> --}}
                                {{-- @else
                                <div class="w-16 h-16 rounded-xl bg-[#E7D9B7]"></div>
                                @endif --}}

                            </td>

                            <td class="text-sm text-gray-600">
                                {{-- {{ $koleksi->no_registrasi_baru }} --}}
                            </td>

                            <td class="font-medium text-gray-700">
                                {{-- {{ $koleksi->nama }} --}}
                            </td>

                            <td>
                                {{-- {{ $koleksi->kategori->nama ?? '-' }} --}}
                            </td>

                            <td>
                                {{-- {{ $koleksi->asal }} --}}
                            </td>

                            <td>

                                {{-- @if ($koleksi->kondisi == 'baik') --}}
                                {{-- <span class="px-4 py-1 rounded-full text-xs bg-green-100 text-green-700 font-semibold">
                                    Baik
                                </span> --}}
                                {{-- @elseif($koleksi->kondisi == 'rusak_ringan') --}}
                                {{-- <span
                                    class="px-4 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700 font-semibold">
                                    Rusak Ringan
                                </span> --}}
                                {{-- @else
                                <span class="px-4 py-1 rounded-full text-xs bg-red-100 text-red-600 font-semibold">
                                    Rusak Berat
                                </span>
                                @endif --}}

                            </td>

                        </tr>

                        {{-- @empty --}}

                        <tr>

                            <td colspan="6" class="py-10 text-center text-gray-400">
                                Belum ada data.
                            </td>

                        </tr>
                        {{-- @endforelse --}}

                    </tbody>

                </table>

            </div>

        </div>

        <div class="mt-6">
            {{-- @if (method_exists($koleksis, 'links'))
                {{ $koleksis->links() }}
            @endif --}}
        </div>
        </div>
    </main>

    {{-- QR MODAL --}}
    <div x-cloak x-show="qrOpen"
        class="fixed inset-0 z-[60] flex items-center justify-center bg-black/55 p-4 modal-overlay"
        x-transition.opacity>
        <div class="relative w-full max-w-md qr-modal-card px-8 py-7"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            <button type="button" @click="qrOpen = false" class="absolute right-5 top-4 icon-close"
                aria-label="Tutup modal">
                <i class="fa-solid fa-xmark text-[15px]"></i>
            </button>

            <div>
                <h2 class="qr-modal-title" x-text="qrName"></h2>
                <p class="qr-modal-reg" x-text="qrReg"></p>
            </div>

            <div class="mt-6 flex flex-col items-center">
                <div class="rounded-2xl bg-white p-4 shadow-sm ring-1 ring-[#E7D7B1]">
                    <img :src="qrText" alt="QR Code" class="h-[190px] w-[190px] object-contain">
                </div>
            </div>

            <div class="mt-6 flex items-center justify-center gap-3">
                <button type="button" @click="printQr()" class="btn-modal-print">
                    <i class="fa-solid fa-print"></i> Cetak
                </button>
                <a :href="qrDownload" download class="btn-modal-download">
                    <i class="fa-solid fa-download"></i> Download
                </a>
            </div>
        </div>
    </div>

    <script>
        function qrPage() {
            return {
                darkMode: false,
                sidebarToggle: false,
                qrOpen: false,
                qrName: '',
                qrReg: '',
                qrText: '',
                qrDownload: '',
                init() {
                    const stored = localStorage.getItem('darkMode');
                    this.darkMode = stored ? JSON.parse(stored) : false;
                    this.$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)));
                },
                openQrModal(payload) {
                    if (!payload.text) return;
                    this.qrName = payload.name || 'Koleksi';
                    this.qrReg = payload.reg || '';
                    this.qrText = payload.text;
                    this.qrDownload = payload.download || '#';
                    this.qrOpen = true;
                },
                printQr() {
                    if (!this.qrText) return;
                    const win = window.open('', '_blank', 'width=420,height=560');
                    if (!win) return;
                    const name = this.qrName;
                    const reg = this.qrReg;
                    win.document.write(
                        '<html><head><title>QR - ' + name + '</title><style>' +
                        'body{font-family:sans-serif;text-align:center;padding:32px;}' +
                        'img{width:220px;height:220px;object-fit:contain;margin-bottom:16px;}' +
                        'h2{margin:0 0 4px;font-size:16px;}p{margin:0;color:#555;font-size:13px;}' +
                        '</style></head><body>' +
                        '<img src="' + this.qrText + '" />' +
                        '<h2>' + name + '</h2><p>' + reg + '</p>' +
                        '<script>window.onload=function(){window.print();}<' + '/script>' +
                        '</body></html>'
                    );
                    win.document.close();
                },
            }
        }
    </script>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;
                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;
                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;
                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>
</body>

</html>
