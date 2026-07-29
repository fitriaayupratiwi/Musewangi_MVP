<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Admin Musewangi | QR Code Koleksi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .page-bg {
            background: linear-gradient(135deg, #F5EFE3 0%, #EDE3CF 40%, #F0E8D5 100%);
            min-height: 100vh;
        }

        .stat-card {
            background: linear-gradient(135deg, #1D2745 0%, #253256 100%);
            border-radius: 20px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            color: #fff;
            min-height: 132px;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(199, 152, 28, 0.15);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(199, 152, 28, 0.08);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(29, 39, 69, 0.25);
        }

        .stat-card .stat-label {
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .stat-card .stat-value {
            font-size: 36px;
            line-height: 1;
            font-weight: 800;
            margin-top: 12px;
        }

        .stat-card .stat-sub {
            font-size: 12px;
            opacity: .95;
            margin-top: 4px;
        }

        .stat-card .stat-icon {
            position: absolute;
            right: 18px;
            top: 18px;
            opacity: .18;
            font-size: 42px;
        }

        .section-header {
            background: white;
            border-radius: 18px;
            border: 1.5px solid #EDD9A3;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 20px;
        }

        #searchInput {
            background: white;
            border: 1.5px solid #DDD0A8;
            border-radius: 12px;
            padding: 10px 40px 10px 42px;
            font-size: 14px;
            color: #333;
            width: 100%;
            transition: all 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        #searchInput:focus {
            outline: none;
            border-color: #B78921;
            box-shadow: 0 0 0 3px rgba(183, 137, 33, 0.15);
        }

        .qr-card {
            background: white;
            border-radius: 18px;
            border: 1.5px solid #EDD9A3;
            transition: all 0.25s ease;
            overflow: hidden;
            position: relative;
            opacity: 0;
            animation: fadeInUp .45s ease both;
        }

        .qr-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #B78921, #E8B84B);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .qr-card:hover::before {
            transform: scaleX(1);
        }

        .qr-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(183, 137, 33, 0.15);
            border-color: #C9981C;
        }

        /* "Ticket stub" notch — the divider inside each card reads like a
           perforated museum tag, cut cleanly by the card's own edges. */
        .tag-divider {
            position: relative;
        }

        .tag-divider .notch {
            position: absolute;
            top: 50%;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #F5EFE3;
            transform: translateY(-50%);
        }

        .tag-divider .notch.left { left: -29px; }
        .tag-divider .notch.right { right: -29px; }

        .qr-icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, #FFF3D1, #FFE5A0);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .badge-count {
            background: linear-gradient(135deg, #1D2745, #2A3860);
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .reg-number {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            letter-spacing: 0.02em;
        }

        .btn-action {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            cursor: pointer;
            border: 1.5px solid transparent;
        }

        .btn-action:focus-visible {
            outline: 2px solid #B78921;
            outline-offset: 2px;
        }

        .btn-view {
            background: #F0F4FF;
            color: #3B5BDB;
            border-color: #C5D0F7;
        }

        .btn-view:hover {
            background: #3B5BDB;
            color: white;
            border-color: #3B5BDB;
            transform: scale(1.08);
        }

        .btn-download {
            background: #FFF0F0;
            color: #E03131;
            border-color: #FFCACA;
        }

        .btn-download:hover {
            background: #E03131;
            color: white;
            border-color: #E03131;
            transform: scale(1.08);
        }

        .empty-state {
            padding: 56px 20px;
            text-align: center;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFF3D1, #FFE5A0);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .modal-overlay {
            backdrop-filter: blur(8px);
        }

        .qr-modal-card {
            background: linear-gradient(160deg, #FFFDF7 0%, #FFF8E8 100%);
            border-radius: 24px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.22);
            border: 1px solid rgba(199, 152, 28, 0.22);
        }

        .qr-modal-title {
            font-size: 18px;
            font-weight: 800;
            color: #1D2745;
        }

        .qr-modal-reg {
            font-size: 12px;
            color: #8A7D6A;
        }

        .btn-modal-download,
        .btn-modal-print {
            border: none;
            border-radius: 8px;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-modal-download {
            background: #1D2745;
            color: white;
        }

        .btn-modal-download:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(29, 39, 69, 0.25);
        }

        .btn-modal-print {
            background: white;
            color: #1D2745;
            border: 1.5px solid #E3D6AC;
        }

        .btn-modal-print:hover {
            border-color: #B78921;
            color: #B78921;
        }

        .icon-close {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1D2745;
            background: rgba(29, 39, 69, 0.06);
            transition: all .2s ease;
        }

        .icon-close:hover {
            background: rgba(29, 39, 69, 0.12);
            transform: scale(1.04);
        }

        .clear-search {
            transition: color .15s ease;
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

        @media (prefers-reduced-motion: reduce) {
            .qr-card {
                animation: none;
                opacity: 1;
            }
        }
    </style>
</head>

<body x-data="qrPage()" x-init="init()" :class="{ 'dark bg-gray-900': darkMode === true }" class="relative min-w-screen page-bg font-sans antialiased">
    @include('admin.body.sidebar')

    <div x-show="sidebarToggle" @click="sidebarToggle = false" class="fixed inset-0 z-40 bg-black/50 lg:hidden" x-transition.opacity></div>

    @include('admin.body.header')

    <main class="pt-16 transition-all duration-300 p-5 lg:ml-64 z-10">
        <div class="mx-auto max-w-6xl">
            <div class="mb-6 flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#B78921] to-[#E8B84B] flex items-center justify-center shadow-lg shadow-yellow-400/30">
                            <i class="fa-solid fa-qrcode text-white"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-[#1D2745]">QR Code Koleksi</h1>
                            <p class="text-sm text-[#7A6F5C]">Lihat, unduh, dan kelola QR Code setiap koleksi agar mudah dipindai.</p>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/admin/koleksi') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#B78921] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:brightness-110">
                    <i class="fa-solid fa-layer-group"></i>
                    Ke Data Koleksi
                </a>
            </div>

            @php
                $koleksis = $koleksis ?? collect();
                $collection = method_exists($koleksis, 'getCollection') ? $koleksis->getCollection() : collect($koleksis);
                $isPaginator = method_exists($koleksis, 'total');
                $totalKoleksi = $totalKoleksi ?? ($isPaginator ? $koleksis->total() : $collection->count());
                $totalQr = $totalQr ?? $collection->filter(fn ($k) => !empty($k->qr_code))->count();
                $totalKosong = $totalKosong ?? $collection->filter(fn ($k) => empty($k->qr_code))->count();
            @endphp

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3 mb-6">
                <div class="stat-card bg-[#1D2745]">
                    <div class="stat-icon"><i class="fa-solid fa-box-archive"></i></div>
                    <div class="stat-label">Total Koleksi</div>
                    <div class="stat-value">{{ number_format($totalKoleksi) }}</div>
                    <div class="stat-sub">Data koleksi terdaftar</div>
                </div>

                <div class="stat-card bg-[#A87200]">
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
                </div>
            </div>

            <div class="section-header">
                <div class="flex items-center gap-3 flex-wrap">
                    <div>
                        <h2 class="text-base font-bold text-[#1D2745]">Daftar QR Code</h2>
                        <p class="text-sm text-[#7A6F5C]">{{ $totalKoleksi }} koleksi ditemukan</p>
                    </div>
                    <span class="badge-count">{{ $totalKoleksi }} koleksi</span>
                </div>

                <form method="GET" action="{{ route('admin.qrcode.koleksi') }}" class="w-full sm:w-[320px]">
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#B78921]"></i>
                        <input id="searchInput" type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama / no. registrasi...">
                        @if (request('cari'))
                            <a href="{{ route('admin.qrcode.koleksi') }}" title="Hapus pencarian"
                                class="clear-search absolute right-4 top-1/2 -translate-y-1/2 text-[#B0A080] hover:text-[#B78921]">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($koleksis as $koleksi)
                    @php
                        $qrUrl = $koleksi->qr_code ? asset($koleksi->qr_code) : null;
                    @endphp

                    <article class="qr-card p-5" style="animation-delay: {{ min($loop->index, 9) * 60 }}ms">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-start gap-3">
                                <div class="qr-icon-wrap">
                                    <i class="fa-solid fa-qrcode text-[#B78921] text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-[#1D2745] leading-snug">{{ $koleksi->nama }}</h3>
                                    <p class="text-xs text-[#8A7D6A] mt-1">ID #{{ $koleksi->id }}</p>
                                </div>
                            </div>

                            <span class="badge-count shrink-0">{{ $koleksi->kondisiLabel() }}</span>
                        </div>

                        <div class="mt-4 rounded-2xl border border-[#E9DEBF] bg-[#FBF8F1] p-4">
                            <div class="flex items-center justify-between text-sm gap-4">
                                <span class="text-[#7A6F5C]">No. Registrasi</span>
                                <span class="reg-number font-semibold text-[#1D2745] text-right">{{ $koleksi->no_registrasi_baru }}</span>
                            </div>
                            <div class="mt-2 flex items-center justify-between text-sm gap-4">
                                <span class="text-[#7A6F5C]">Kategori</span>
                                <span class="font-semibold text-[#1D2745] truncate max-w-[55%] text-right">{{ $koleksi->kategori->nama ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="tag-divider my-4">
                            <span class="notch left"></span>
                            <span class="notch right"></span>
                            <div class="border-t-2 border-dashed border-[#E3D6AC]"></div>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                @if ($qrUrl)
                                    <div class="rounded-xl border border-[#E9DEBF] bg-white p-2 shadow-sm">
                                        <img src="{{ $qrUrl }}" alt="QR {{ $koleksi->nama }}" class="h-16 w-16 object-contain">
                                    </div>
                                @else
                                    <div class="rounded-xl border border-dashed border-[#E9DEBF] bg-[#FBF8F1] px-4 py-6 text-center text-xs text-[#8A7D6A]">
                                        <i class="fa-solid fa-qrcode text-base mb-1 block text-[#D8CBA0]"></i>
                                        QR belum tersedia
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-2">
                                <button type="button"
                                    @click="openQrModal({ name: @js($koleksi->nama), text: @js($qrUrl), download: @js(route('admin.koleksi.qrcode.download', ['koleksi' => $koleksi->id])), reg: @js($koleksi->no_registrasi_baru) })"
                                    class="btn-action btn-view" title="Lihat QR" @disabled(!$qrUrl)>
                                    <i class="fa-solid fa-eye text-sm"></i>
                                </button>

                                <a href="{{ $koleksi->qr_code ? route('admin.koleksi.qrcode.download', ['koleksi' => $koleksi->id]) : '#' }}" class="btn-action btn-download {{ $koleksi->qr_code ? '' : 'pointer-events-none opacity-50' }}" title="Unduh QR">
                                    <i class="fa-solid fa-download text-sm"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-2 xl:col-span-3 qr-card empty-state">
                        <div class="empty-icon">
                            <i class="fa-solid {{ request('cari') ? 'fa-magnifying-glass' : 'fa-box-open' }} text-[#B78921] text-3xl"></i>
                        </div>
                        @if (request('cari'))
                            <h3 class="text-lg font-bold text-[#1D2745]">Tidak ada hasil untuk "{{ request('cari') }}"</h3>
                            <p class="mt-2 text-sm text-[#7A6F5C]">Coba kata kunci lain, atau reset pencarian.</p>
                            <a href="{{ route('admin.qrcode.koleksi') }}" class="mt-4 inline-flex items-center gap-2 rounded-xl border-2 border-[#DDD0A8] bg-white px-5 py-2.5 text-sm font-semibold text-[#1D2745] hover:border-[#B78921] transition">
                                <i class="fa-solid fa-rotate-left text-xs"></i> Reset Pencarian
                            </a>
                        @else
                            <h3 class="text-lg font-bold text-[#1D2745]">Belum ada data koleksi</h3>
                            <p class="mt-2 text-sm text-[#7A6F5C]">Tambahkan koleksi terlebih dahulu agar QR Code bisa dibuat.</p>
                        @endif
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                @if (method_exists($koleksis, 'links'))
                    {{ $koleksis->links() }}
                @endif
            </div>
        </div>
    </main>

    {{-- QR MODAL --}}
    <div x-cloak x-show="qrOpen" class="fixed inset-0 z-[60] flex items-center justify-center bg-black/55 p-4 modal-overlay" x-transition.opacity>
        <div class="relative w-full max-w-md qr-modal-card px-8 py-7" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            <button type="button" @click="qrOpen = false" class="absolute right-5 top-4 icon-close" aria-label="Tutup modal">
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
