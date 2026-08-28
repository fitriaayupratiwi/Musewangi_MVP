<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>MUSEWANGI — Museum Blambangan Banyuwangi</title>
    <meta name="description" content="Sistem Informasi Inventaris dan Pemandu Digital Koleksi Museum Blambangan Banyuwangi.">

    <!-- Favicon HD Multi-Resolution -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=5">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=5">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=5">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=5">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Tailwind CSS & Vite -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8F5ED;
            color: #162544;
            -webkit-font-smoothing: antialiased;
            padding-bottom: 96px;
        }

        [x-cloak] {
            display: none !important;
        }

        .gold-gradient-bg {
            background: linear-gradient(135deg, #D4AF37 0%, #C9981C 50%, #997314 100%);
        }

        .navy-gradient-card {
            background: linear-gradient(145deg, #162544 0%, #1D2E54 60%, #0F1A30 100%);
        }

        .shadow-pro-card {
            box-shadow: 0 10px 30px -5px rgba(22, 37, 68, 0.06), 0 4px 12px -2px rgba(201, 152, 28, 0.05);
        }

        .pulse-ring {
            box-shadow: 0 0 0 0 rgba(201, 152, 28, 0.5);
            animation: pulse-ring 2s infinite cubic-bezier(0.66, 0, 0, 1);
        }

        @keyframes pulse-ring {
            to {
                box-shadow: 0 0 0 14px rgba(201, 152, 28, 0);
            }
        }

        /* ── Scroll Reveal System ── */
        .reveal-item {
            opacity: 0;
            transform: translateY(18px);
            transition: opacity 0.55s cubic-bezier(0.16, 1, 0.3, 1), transform 0.55s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .reveal-item.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ── Elastic Micro-Interactions ── */
        .spring-tap {
            transition: transform 0.18s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease, filter 0.15s ease;
        }
        .spring-tap:active {
            transform: scale(0.95);
        }

        .spring-card {
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.25s ease, border-color 0.2s ease;
        }
        .spring-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 28px -6px rgba(22, 37, 68, 0.08), 0 6px 14px -2px rgba(201, 152, 28, 0.14);
        }
        .spring-card:active {
            transform: scale(0.98);
        }

        /* Hide scrollbar for category horizontal scroll */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Custom Slim Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #F0E8D5;
        }
        ::-webkit-scrollbar-thumb {
            background: #C9981C;
            border-radius: 9999px;
        }
    </style>
</head>

<body x-data="homeApp()" x-init="init()" class="min-h-screen flex flex-col justify-between relative bg-[#F8F5ED]">

    <!-- DRAWER NAVIGASI MOBILE -->
    <div x-show="mobileDrawer" x-cloak class="fixed inset-0 z-50 flex" role="dialog" aria-modal="true">
        <!-- Overlay Backdrop -->
        <div x-show="mobileDrawer" @click="mobileDrawer = false"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/60 backdrop-blur-xs"></div>

        <!-- Drawer Panel -->
        <div x-show="mobileDrawer"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="relative max-w-xs w-full bg-[#162544] text-white flex flex-col justify-between p-6 shadow-2xl z-10 border-r border-[#C9981C]/20">

            <div>
                <!-- Top Brand -->
                <div class="flex items-center justify-between pb-6 border-b border-white/10">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-[#C9981C] bg-[#162544] flex-shrink-0 shadow-md">
                            <img src="{{ asset('src/images/logo-museum.jpeg') }}" alt="Logo Musewangi" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold tracking-wide text-[#FFD86B] uppercase leading-tight">MUSEWANGI</h2>
                            <p class="text-[11px] text-gray-300 leading-tight">Museum Blambangan</p>
                        </div>
                    </div>

                    <button type="button" @click="mobileDrawer = false"
                        class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition spring-tap">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>
                </div>

                <!-- Nav Menu List -->
                <nav class="mt-6 space-y-2">
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-xl bg-[#C9981C] text-white font-bold text-xs shadow-md transition spring-tap">
                        <i class="fa-solid fa-house text-sm w-5 text-center"></i>
                        <span>Beranda Pengunjung</span>
                    </a>

                    <a href="{{ route('public.scan') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-white/85 hover:bg-white/10 hover:text-white font-medium text-xs transition spring-tap">
                        <i class="fa-solid fa-qrcode text-sm w-5 text-center text-[#FFD86B]"></i>
                        <span>Pindai QR Koleksi</span>
                    </a>

                    <button type="button" @click="mobileDrawer = false; infoModal = true"
                        class="w-full flex items-center gap-3.5 px-4 py-3 rounded-xl text-white/85 hover:bg-white/10 hover:text-white font-medium text-xs transition text-left spring-tap">
                        <i class="fa-solid fa-circle-info text-sm w-5 text-center text-[#FFD86B]"></i>
                        <span>Informasi Jam & Tiket</span>
                    </button>

                    <a href="{{ route('login') }}"
                        class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-white/85 hover:bg-white/10 hover:text-white font-medium text-xs transition spring-tap">
                        <i class="fa-solid fa-user-shield text-sm w-5 text-center text-[#FFD86B]"></i>
                        <span>Login Petugas / Admin</span>
                    </a>
                </nav>
            </div>

            <!-- Drawer Bottom (Gapura & Copyright) -->
            <div class="pt-6 border-t border-white/10 text-center">
                <img src="{{ asset('src/images/gapura1.png') }}" alt="Gapura Blambangan"
                    class="w-20 mx-auto opacity-75 mb-2 filter drop-shadow-md">
                <p class="text-[11px] text-[#FFD86B] font-bold">© 2026 MUSEWANGI</p>
                <p class="text-[10px] text-gray-400">Museum Blambangan Banyuwangi</p>
            </div>
        </div>
    </div>

    <!-- TOPBAR / HEADER -->
    <header class="sticky top-0 z-30 bg-[#F8F5ED]/95 backdrop-blur-md border-b border-[#E8DCC0] shadow-xs">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full overflow-hidden border border-[#C9981C] bg-[#162544] flex-shrink-0 shadow-xs">
                    <img src="{{ asset('src/images/logo-museum.jpeg') }}" alt="Logo Musewangi" class="w-full h-full object-cover">
                </div>
                <div>
                    <h1 class="text-sm font-black tracking-wide text-[#162544] uppercase leading-tight">MUSEWANGI</h1>
                    <p class="text-[10px] text-gray-500 font-medium leading-tight">Museum Blambangan Banyuwangi</p>
                </div>
            </div>

            <!-- Header Action: Info & Drawer -->
            <div class="flex items-center gap-2">
                <button type="button" @click="infoModal = true"
                    class="w-9 h-9 rounded-xl bg-white border border-[#E8DCC0] hover:bg-[#E8DCC0]/30 text-[#C9981C] flex items-center justify-center shadow-xs transition spring-tap"
                    title="Informasi Museum">
                    <i class="fa-solid fa-circle-info text-sm"></i>
                </button>

                <button type="button" @click="mobileDrawer = true"
                    class="w-9 h-9 rounded-xl bg-white border border-[#E8DCC0] hover:bg-[#E8DCC0]/30 text-[#162544] flex items-center justify-center shadow-xs transition spring-tap"
                    aria-label="Buka Menu Navigasi">
                    <i class="fa-solid fa-bars text-sm"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- CONTENT WRAPPER -->
    <main class="max-w-5xl mx-auto w-full px-4 py-4 flex-1 space-y-5">

        <!-- 1. HERO BANNER CARD (REVEAL ITEM 1) -->
        <div class="reveal-item is-visible relative overflow-hidden rounded-3xl navy-gradient-card text-white p-6 md:p-8 shadow-xl border border-[#C9981C]/40 spring-card">
            <!-- Decorative Gapura Background (Right side) -->
            <div class="absolute right-0 bottom-0 top-0 w-44 md:w-64 pointer-events-none opacity-25 flex items-end justify-end pr-2 pb-1">
                <img src="{{ asset('src/images/gapura1.png') }}" alt="Gapura" class="w-28 md:w-44 h-auto object-contain">
            </div>

            <div class="relative z-10 space-y-2.5 max-w-lg">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase bg-[#C9981C]/25 border border-[#C9981C]/50 text-[#FFD86B]">
                    <i class="fa-solid fa-landmark text-[9px]"></i>
                    <span>Museum Blambangan Banyuwangi</span>
                </div>

                <h2 class="text-2xl md:text-3xl font-black text-[#FFD86B] tracking-wide leading-tight drop-shadow-sm">
                    MUSEWANGI
                </h2>

                <p class="text-xs md:text-sm text-gray-200 leading-relaxed">
                    Panduan interaktif & eksplorasi warisan budaya Blambangan Banyuwangi berbasis QR Code.
                </p>

                <div class="pt-2">
                    <a href="{{ route('public.scan') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl gold-gradient-bg text-[#162544] font-black text-xs md:text-sm shadow-lg shadow-[#C9981C]/30 hover:brightness-110 transition spring-tap">
                        <i class="fa-solid fa-qrcode text-sm"></i>
                        <span>Pindai QR Etalase</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- 2. SEARCH INPUT (REVEAL ITEM 2) -->
        <div class="reveal-item relative">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#B0A080] text-xs"></i>
            <input type="text" x-model="searchQuery"
                placeholder="Cari nama artefak, kategori, atau nomor registrasi..."
                class="w-full pl-10 pr-10 py-3 rounded-2xl bg-white border border-[#E8DCC0] focus:ring-2 focus:ring-[#C9981C] text-xs outline-none shadow-pro-card text-[#162544] placeholder-gray-400 transition">
            <button x-show="searchQuery" @click="searchQuery = ''"
                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-xs spring-tap">
                <i class="fa-solid fa-circle-xmark"></i>
            </button>
        </div>

        <!-- 3. DYNAMIC CATEGORY FILTER PILLS (REVEAL ITEM 3) -->
        <div class="reveal-item space-y-1.5">
            <div class="flex items-center justify-between px-1">
                <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Kategori Kuratorial</span>
                <span class="text-[10px] text-[#C9981C] font-semibold">{{ $totalCategories }} Kategori</span>
            </div>

            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar py-1 scroll-smooth">
                <button type="button" @click="selectedCategory = 'all'"
                    :class="selectedCategory === 'all' ? 'bg-[#162544] text-[#FFD86B] font-bold shadow-xs border-[#162544]' : 'bg-white text-gray-600 border-[#E8DCC0] hover:border-[#C9981C]'"
                    class="px-3.5 py-1.5 rounded-full text-xs whitespace-nowrap border transition flex items-center gap-1.5 spring-tap">
                    <span>Semua Koleksi</span>
                    <span class="px-1.5 py-0.2 rounded-full text-[9px] font-bold bg-[#C9981C]/20 text-[#C9981C]">{{ $totalCollections }}</span>
                </button>

                @if(isset($categories) && $categories->count())
                    @foreach($categories as $cat)
                        <button type="button" @click="selectedCategory = '{{ strtolower($cat->nama) }}'"
                            :class="selectedCategory === '{{ strtolower($cat->nama) }}' ? 'bg-[#162544] text-[#FFD86B] font-bold shadow-xs border-[#162544]' : 'bg-white text-gray-600 border-[#E8DCC0] hover:border-[#C9981C]'"
                            class="px-3.5 py-1.5 rounded-full text-xs whitespace-nowrap border transition flex items-center gap-1.5 spring-tap">
                            <span>{{ $cat->nama }}</span>
                            <span class="px-1.5 py-0.2 rounded-full text-[9px] font-bold bg-[#C9981C]/20 text-[#C9981C]">{{ $cat->koleksis_count ?? 0 }}</span>
                        </button>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- 4. STATS SUMMARY BADGE (REVEAL ITEM 4) -->
        <div class="reveal-item grid grid-cols-2 gap-3">
            <a href="{{ route('public.scan') }}"
                class="bg-white rounded-2xl p-3.5 border border-[#E8DCC0] shadow-pro-card hover:border-[#C9981C] transition flex items-center gap-3 group spring-card">
                <div class="w-10 h-10 rounded-xl bg-[#FFF8EA] text-[#C9981C] border border-[#C9981C]/30 flex items-center justify-center text-base group-hover:scale-110 transition flex-shrink-0">
                    <i class="fa-solid fa-camera"></i>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-[#162544]">Pindai QR</h3>
                    <p class="text-[10px] text-gray-500">Auto Scan 24 FPS</p>
                </div>
            </a>

            <div class="bg-white rounded-2xl p-3.5 border border-[#E8DCC0] shadow-pro-card flex items-center gap-3 spring-card">
                <div class="w-10 h-10 rounded-xl bg-[#EBF5FB] text-[#2980B9] border border-[#2980B9]/30 flex items-center justify-center text-base flex-shrink-0">
                    <i class="fa-solid fa-landmark"></i>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-[#162544]">{{ $totalCollections }} Artefak</h3>
                    <p class="text-[10px] text-gray-500">Terdaftar Resmi</p>
                </div>
            </div>
        </div>

        <!-- 5. DAFTAR KOLEKSI MUSEUM (REVEAL ITEM 5) -->
        <div class="reveal-item space-y-3 pt-1">
            <div class="flex items-center justify-between px-1">
                <h3 class="text-xs font-extrabold text-[#162544] uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-gem text-[#C9981C]"></i>
                    <span>Koleksi Bersejarah</span>
                </h3>
                <span class="text-[10px] text-gray-400 font-medium">Ketuk untuk detail & audio</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
                @forelse($collections as $item)
                    @php
                        $kategoriNama = $item->category ? $item->category->nama : ($item->kategori ?? 'Umum');
                        $kondisi = strtolower($item->kondisi ?? 'baik');
                        $kondisiBadge = match($kondisi) {
                            'baik' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            'rusak ringan', 'rusak_ringan' => 'bg-amber-50 text-amber-700 border-amber-200',
                            default => 'bg-red-50 text-red-700 border-red-200'
                        };
                    @endphp
                    <a href="{{ route('public.koleksi.show', $item->kode_unik) }}"
                        x-show="filterItem('{{ addslashes($item->nama_koleksi) }}', '{{ addslashes($kategoriNama) }}', '{{ addslashes($item->no_registrasi) }}')"
                        class="bg-white rounded-2xl p-3.5 border border-[#E8DCC0] shadow-pro-card hover:border-[#C9981C] transition flex items-center gap-3.5 group spring-card">
                        <!-- Foto Artefak -->
                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-[#E9DEC7] flex-shrink-0 border border-[#E8DCC0] relative shadow-xs">
                            @if($item->fotoUrl())
                                <img src="{{ $item->fotoUrl() }}" alt="{{ $item->nama_koleksi }}" class="w-full h-full object-cover group-hover:scale-108 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-[#C9981C]/70">
                                    <i class="fa-solid fa-landmark text-lg"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Info Artefak -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-1.5 mb-1">
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-[#FFF8EA] text-[#7B5200] border border-[#EDD9A3]">
                                    {{ $kategoriNama }}
                                </span>
                                <span class="text-[9px] font-mono text-gray-400 truncate">
                                    {{ $item->no_registrasi }}
                                </span>
                            </div>

                            <h4 class="text-xs font-bold text-[#162544] truncate group-hover:text-[#C9981C] transition">
                                {{ $item->nama_koleksi }}
                            </h4>

                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[9px] px-2 py-0.2 rounded-full font-semibold border {{ $kondisiBadge }}">
                                    {{ $item->kondisiLabel() }}
                                </span>
                                <span class="text-[10px] text-amber-500 font-bold flex items-center gap-0.5">
                                    <i class="fa-solid fa-star text-[9px]"></i>
                                    <span>5.0</span>
                                </span>
                            </div>
                        </div>

                        <!-- Action Button Arrow -->
                        <div class="w-8 h-8 rounded-full bg-[#F8F5ED] text-gray-400 group-hover:bg-[#C9981C] group-hover:text-white flex items-center justify-center transition flex-shrink-0 shadow-xs border border-[#E8DCC0] spring-tap">
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full bg-white rounded-2xl p-8 text-center border border-[#E8DCC0] text-gray-400 space-y-2 shadow-xs">
                        <i class="fa-solid fa-box-open text-3xl text-[#C9981C]/50 block"></i>
                        <p class="text-xs font-medium">Belum ada data koleksi museum yang terdaftar.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 6. PANDUAN PENGUNJUNG CARD (REVEAL ITEM 6) -->
        <div class="reveal-item bg-white rounded-3xl p-5 border border-[#EDD9A3] shadow-pro-card space-y-3 spring-card">
            <h4 class="text-xs font-extrabold uppercase tracking-wider text-[#C9981C] flex items-center gap-2">
                <i class="fa-solid fa-compass"></i>
                <span>Cara Menggunakan Panduan Digital</span>
            </h4>

            <div class="grid grid-cols-3 gap-2.5 text-center pt-1">
                <div class="p-2.5 rounded-2xl bg-[#F8F5ED] border border-[#E8DCC0] space-y-1">
                    <span class="w-6 h-6 rounded-full bg-[#162544] text-[#FFD86B] font-bold text-[10px] inline-flex items-center justify-center">1</span>
                    <p class="text-[10px] font-bold text-[#162544]">Buka Kamera</p>
                    <p class="text-[9px] text-gray-500 leading-tight">Tekan tombol Scan QR</p>
                </div>

                <div class="p-2.5 rounded-2xl bg-[#F8F5ED] border border-[#E8DCC0] space-y-1">
                    <span class="w-6 h-6 rounded-full bg-[#162544] text-[#FFD86B] font-bold text-[10px] inline-flex items-center justify-center">2</span>
                    <p class="text-[10px] font-bold text-[#162544]">Arahkan QR</p>
                    <p class="text-[9px] text-gray-500 leading-tight">Pindai label etalase</p>
                </div>

                <div class="p-2.5 rounded-2xl bg-[#F8F5ED] border border-[#E8DCC0] space-y-1">
                    <span class="w-6 h-6 rounded-full bg-[#162544] text-[#FFD86B] font-bold text-[10px] inline-flex items-center justify-center">3</span>
                    <p class="text-[10px] font-bold text-[#162544]">Audio Guide</p>
                    <p class="text-[9px] text-gray-500 leading-tight">Dengar narasi artefak</p>
                </div>
            </div>
        </div>

    </main>

    <!-- FLOATING SCROLL TO TOP BUTTON -->
    <button type="button" @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        x-show="showScrollTop" x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-3 scale-90"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-3 scale-90"
        class="fixed right-4 bottom-24 z-30 w-10 h-10 rounded-full bg-[#162544] text-[#FFD86B] shadow-lg border border-[#C9981C]/40 flex items-center justify-center text-sm spring-tap active:scale-90"
        title="Kembali ke Atas">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    <!-- FLOATING APP BOTTOM NAVIGATION BAR -->
    <nav class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-[#E8DCC0] shadow-xl md:bottom-5 md:max-w-md md:mx-auto md:rounded-3xl md:border md:border-[#EDD9A3]/80 md:shadow-2xl">
        <div class="max-w-md mx-auto px-4 py-2 flex items-center justify-between">
            <!-- 1. Home -->
            <a href="{{ route('home') }}"
                class="flex-1 flex flex-col items-center justify-center gap-1 text-[#C9981C] font-bold text-[10px] md:text-[11px] transition spring-tap py-1">
                <i class="fa-solid fa-house text-base md:text-lg"></i>
                <span class="leading-none">Beranda</span>
            </a>

            <!-- 2. Scan Button (Floating Center Highlight) -->
            <div class="flex-1 flex justify-center -mt-6">
                <a href="{{ route('public.scan') }}"
                    class="flex flex-col items-center group spring-tap focus:outline-none"
                    aria-label="Scan QR Code">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-tr from-[#B78921] via-[#D4AF37] to-[#F3D376] text-[#162544] flex items-center justify-center text-xl shadow-xl shadow-[#C9981C]/40 border-4 border-[#F8F5ED] md:border-white group-hover:scale-105 group-active:scale-95 transition-all duration-200">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <span class="text-[10px] font-black text-[#162544] mt-1 tracking-tight leading-none">Scan QR</span>
                </a>
            </div>

            <!-- 3. Info Museum -->
            <button type="button" @click="infoModal = true"
                class="flex-1 flex flex-col items-center justify-center gap-1 text-gray-400 hover:text-[#162544] font-medium text-[10px] md:text-[11px] transition spring-tap py-1">
                <i class="fa-solid fa-circle-info text-base md:text-lg"></i>
                <span class="leading-none">Info Museum</span>
            </button>

            <!-- 4. Admin Login -->
            <a href="{{ route('login') }}"
                class="flex-1 flex flex-col items-center justify-center gap-1 text-gray-400 hover:text-[#162544] font-medium text-[10px] md:text-[11px] transition spring-tap py-1">
                <i class="fa-solid fa-user-shield text-base md:text-lg"></i>
                <span class="leading-none">Petugas</span>
            </a>
        </div>
    </nav>

    <!-- MODAL INFORMASI MUSEUM -->
    <div x-show="infoModal" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div @click.outside="infoModal = false"
            class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-[#EDD9A3] relative space-y-4">

            <!-- Close Button -->
            <button type="button" @click="infoModal = false"
                class="absolute top-4 right-4 w-8 h-8 rounded-full bg-gray-100 text-gray-400 hover:text-gray-700 flex items-center justify-center transition spring-tap">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>

            <!-- Header -->
            <div class="text-center space-y-1">
                <div class="w-12 h-12 rounded-full bg-[#FFF3D1] border border-[#EDD9A3] flex items-center justify-center text-[#B78921] text-xl mx-auto mb-2">
                    <i class="fa-solid fa-landmark"></i>
                </div>
                <h3 class="text-base font-bold text-[#162544]">Museum Blambangan</h3>
                <p class="text-xs text-gray-500">Dinas Kebudayaan dan Pariwisata Kab. Banyuwangi</p>
            </div>

            <!-- Detail Info -->
            <div class="space-y-3 text-xs max-h-[65vh] overflow-y-auto pr-1">
                <!-- Jam / Sesi Operasional -->
                <div class="p-3.5 rounded-2xl bg-[#F8F5ED] border border-[#E8DCC0] space-y-1.5">
                    <div class="font-bold text-[#162544] flex items-center gap-2">
                        <i class="fa-regular fa-clock text-[#C9981C]"></i>
                        <span>Sesi Jam Kunjungan:</span>
                    </div>
                    <div class="space-y-1 text-gray-700 pl-5 font-medium text-[11px]">
                        <div class="flex items-center justify-between">
                            <span>Sesi I</span>
                            <span class="font-bold text-[#162544]">08:00 WIB – 10:00 WIB</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Sesi II</span>
                            <span class="font-bold text-[#162544]">10:00 WIB – 12:00 WIB</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span>Sesi III</span>
                            <span class="font-bold text-[#162544]">13:00 WIB – 15:00 WIB</span>
                        </div>
                    </div>
                </div>

                <!-- Retribusi Tiket Masuk -->
                <div class="p-3.5 rounded-2xl bg-[#F8F5ED] border border-[#E8DCC0] space-y-1.5">
                    <div class="font-bold text-[#162544] flex items-center gap-2">
                        <i class="fa-solid fa-ticket text-[#C9981C]"></i>
                        <span>Retribusi Tiket Masuk:</span>
                    </div>
                    <div class="space-y-1.5 text-gray-700 pl-5 text-[11px]">
                        <div class="flex justify-between items-center">
                            <span>Pelajar / Mahasiswa</span>
                            <span class="font-bold text-[#162544]">Rp. 5.000</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Umum</span>
                            <span class="font-bold text-[#162544]">Rp. 7.500</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Mancanegara</span>
                            <span class="font-bold text-[#162544]">Rp. 20.000</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Pelajar Rombongan</span>
                            <span class="font-bold text-[#162544]">Rp. 5.000</span>
                        </div>
                    </div>
                </div>

                <!-- Alamat Lengkap -->
                <div class="p-3.5 rounded-2xl bg-[#F8F5ED] border border-[#E8DCC0] space-y-1.5">
                    <div class="font-bold text-[#162544] flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-[#C9981C]"></i>
                        <span>Alamat Lengkap:</span>
                    </div>
                    <p class="text-gray-700 pl-5 leading-relaxed text-[11px]">
                        Jl. Jenderal Ahmad Yani No.78, Taman Baru, Kec. Banyuwangi, Kabupaten Banyuwangi, Jawa Timur 68416
                    </p>
                </div>
            </div>

            <button type="button" @click="infoModal = false"
                class="w-full py-3 rounded-xl gold-gradient-bg text-[#162544] font-black text-xs shadow-md transition spring-tap">
                Tutup & Lanjutkan
            </button>
        </div>
    </div>

    <!-- JAVASCRIPT STATE -->
    <script>
        function homeApp() {
            return {
                mobileDrawer: false,
                infoModal: false,
                searchQuery: '',
                selectedCategory: 'all',
                showScrollTop: false,

                init() {
                    // Scroll Reveal Observer
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('is-visible');
                            }
                        });
                    }, { threshold: 0.1 });

                    document.querySelectorAll('.reveal-item').forEach(el => {
                        observer.observe(el);
                    });

                    // Scroll Top Listener
                    window.addEventListener('scroll', () => {
                        this.showScrollTop = window.scrollY > 200;
                    }, { passive: true });
                },

                filterItem(nama, kategori, noReg) {
                    const q = this.searchQuery.toLowerCase().trim();
                    const matchQuery = !q ||
                        nama.toLowerCase().includes(q) ||
                        kategori.toLowerCase().includes(q) ||
                        noReg.toLowerCase().includes(q);

                    const matchCategory = (this.selectedCategory === 'all') ||
                        kategori.toLowerCase().includes(this.selectedCategory);

                    return matchQuery && matchCategory;
                }
            };
        }
    </script>
</body>

</html>
