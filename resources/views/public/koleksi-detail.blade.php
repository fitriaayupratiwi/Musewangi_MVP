<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $collection->nama_koleksi }} — MUSEWANGI</title>
    <meta name="description" content="{{ Str::limit($collection->deskripsi, 140) }}">

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

        .shadow-museum {
            box-shadow: 0 10px 30px -5px rgba(22, 37, 68, 0.08), 0 4px 10px -2px rgba(201, 152, 28, 0.05);
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

        /* Soundwave animation */
        @keyframes soundWave {
            0%, 100% { height: 4px; }
            50% { height: 18px; }
        }

        .wave-bar {
            width: 3px;
            background-color: #C9981C;
            border-radius: 9999px;
            display: inline-block;
            animation: soundWave 1.2s infinite ease-in-out;
        }

        .wave-bar:nth-child(2) { animation-delay: 0.2s; }
        .wave-bar:nth-child(3) { animation-delay: 0.4s; }
        .wave-bar:nth-child(4) { animation-delay: 0.6s; }
        .wave-bar:nth-child(5) { animation-delay: 0.3s; }

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

<body x-data="detailKoleksiApp()" x-init="init()" class="min-h-screen flex flex-col justify-between relative bg-[#F8F5ED]">

    <!-- TOPBAR APLIKASI DENGAN READING PROGRESS BAR -->
    <header class="sticky top-0 z-30 bg-[#162544]/95 backdrop-blur-md text-white shadow-md border-b border-[#C9981C]/30">
        <!-- Golden Scroll Progress Indicator -->
        <div class="w-full h-1 bg-[#162544] relative overflow-hidden">
            <div class="h-full bg-gradient-to-r from-[#D4AF37] via-[#FFD86B] to-[#C9981C] transition-all duration-100 ease-out"
                :style="'width: ' + scrollProgress + '%'"></div>
        </div>

        <div class="max-w-xl mx-auto px-4 py-2.5 flex items-center justify-between gap-2">
            <!-- Back Button -->
            <a href="{{ route('home') }}"
                class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition spring-tap flex-shrink-0"
                aria-label="Kembali ke Beranda">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>

            <!-- Title -->
            <div class="flex-1 min-w-0 text-center px-2">
                <h1 class="text-[10px] font-bold text-gray-300 uppercase tracking-widest leading-none">Artefak Museum</h1>
                <p class="text-xs font-black text-[#FFD86B] truncate leading-tight mt-0.5">{{ $collection->nama_koleksi }}</p>
            </div>

            <!-- Action Buttons: Share & Language Toggle -->
            <div class="flex items-center gap-1.5 flex-shrink-0">
                <button type="button" @click="shareCollection()"
                    class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-xs transition spring-tap"
                    title="Bagikan Artefak">
                    <i class="fa-solid fa-share-nodes"></i>
                </button>

                <button type="button" @click="toggleLang()"
                    class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-full text-[11px] font-black bg-[#C9981C] text-[#162544] hover:bg-[#FFD86B] shadow-xs transition spring-tap"
                    title="Ganti Bahasa (Translate)">
                    <i class="fa-solid fa-language text-xs"></i>
                    <span x-text="lang === 'id' ? 'EN' : 'ID'"></span>
                </button>
            </div>
        </div>
    </header>

    <!-- CONTENT WRAPPER -->
    <main class="max-w-xl mx-auto w-full px-4 py-4 flex-1 space-y-4">

        <!-- NOTIFIKASI SUKSES ULASAN -->
        @if(session('success'))
            <div class="p-3.5 bg-emerald-50 border border-emerald-300 text-emerald-800 rounded-2xl text-xs flex items-center gap-2.5 shadow-sm reveal-item is-visible">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base flex-shrink-0"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- 1. CARD FOTO UTAMA & ANGLE THUMBNAILS (REVEAL ITEM 1) -->
        <div class="reveal-item is-visible bg-white rounded-3xl p-3.5 border border-[#E8DCC0] shadow-museum space-y-3 spring-card">
            <!-- Main Photo Display -->
            <div @click="lightbox = true"
                class="relative aspect-square w-full bg-[#E9DEC7] rounded-2xl overflow-hidden flex items-center justify-center border border-[#E8DCC0] cursor-zoom-in group shadow-inner">
                @if($collection->fotoUrl())
                    <img :src="currentPhoto" alt="{{ $collection->nama_koleksi }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                @else
                    <div class="flex flex-col items-center justify-center text-gray-400 p-6 text-center">
                        <i class="fa-solid fa-landmark text-5xl mb-2 text-[#C9981C]/60"></i>
                        <span class="text-xs text-gray-500 font-medium" x-text="lang === 'id' ? 'Foto artefak belum tersedia' : 'Artifact photo not available'"></span>
                    </div>
                @endif

                <!-- Kondisi Badge Overlay -->
                @php
                    $kondisi = strtolower($collection->kondisi ?? 'baik');
                    $badgeClass = match($kondisi) {
                        'baik' => 'bg-emerald-600/95 text-white shadow-emerald-700/20',
                        'rusak ringan', 'rusak_ringan', 'perlu perawatan' => 'bg-amber-600/95 text-white shadow-amber-700/20',
                        default => 'bg-red-600/95 text-white shadow-red-700/20'
                    };
                @endphp
                <div class="absolute top-3 right-3 px-3 py-1 rounded-full text-[11px] font-bold shadow-md {{ $badgeClass }}">
                    <span>{{ $collection->kondisiLabel() }}</span>
                </div>

                <!-- Zoom Hint Pill -->
                <div class="absolute bottom-3 left-3 px-2.5 py-1 rounded-full bg-black/60 backdrop-blur-xs text-white text-[10px] font-medium flex items-center gap-1.5 opacity-85 group-hover:opacity-100 transition spring-tap">
                    <i class="fa-solid fa-magnifying-glass-plus"></i>
                    <span x-text="lang === 'id' ? 'Ketuk untuk zoom' : 'Tap to zoom'"></span>
                </div>
            </div>

            <!-- Galeri Sudut Pandang (Thumbnails: Tampak Depan, Samping, Belakang) -->
            <div class="grid grid-cols-3 gap-2 pt-1">
                <!-- Tampak Depan -->
                <button type="button" @click="activeAngle = 'depan'"
                    :class="activeAngle === 'depan' ? 'border-[#C9981C] ring-2 ring-[#C9981C]/30 bg-[#FFF8EA]' : 'border-[#E8DCC0] bg-[#F8F5ED]'"
                    class="p-2 rounded-2xl border text-center transition spring-tap">
                    <div class="h-12 w-full rounded-xl overflow-hidden bg-[#E9DEC7] flex items-center justify-center mb-1.5">
                        @if($collection->fotoDepanUrl())
                            <img src="{{ $collection->fotoDepanUrl() }}" alt="Tampak Depan" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-camera text-gray-400 text-sm"></i>
                        @endif
                    </div>
                    <span class="text-[10px] font-extrabold text-[#162544]" x-text="lang === 'id' ? 'Tampak Depan' : 'Front View'"></span>
                </button>

                <!-- Tampak Samping -->
                <button type="button" @click="activeAngle = 'samping'"
                    :class="activeAngle === 'samping' ? 'border-[#C9981C] ring-2 ring-[#C9981C]/30 bg-[#FFF8EA]' : 'border-[#E8DCC0] bg-[#F8F5ED]'"
                    class="p-2 rounded-2xl border text-center transition spring-tap">
                    <div class="h-12 w-full rounded-xl overflow-hidden bg-[#E9DEC7] flex items-center justify-center mb-1.5">
                        @if($collection->fotoSampingUrl())
                            <img src="{{ $collection->fotoSampingUrl() }}" alt="Tampak Samping" class="w-full h-full object-cover">
                        @elseif($collection->fotoUrl())
                            <img src="{{ $collection->fotoUrl() }}" alt="Tampak Samping" class="w-full h-full object-cover opacity-80">
                        @else
                            <i class="fa-solid fa-camera text-gray-400 text-sm"></i>
                        @endif
                    </div>
                    <span class="text-[10px] font-extrabold text-[#162544]" x-text="lang === 'id' ? 'Tampak Samping' : 'Side View'"></span>
                </button>

                <!-- Tampak Belakang -->
                <button type="button" @click="activeAngle = 'belakang'"
                    :class="activeAngle === 'belakang' ? 'border-[#C9981C] ring-2 ring-[#C9981C]/30 bg-[#FFF8EA]' : 'border-[#E8DCC0] bg-[#F8F5ED]'"
                    class="p-2 rounded-2xl border text-center transition spring-tap">
                    <div class="h-12 w-full rounded-xl overflow-hidden bg-[#E9DEC7] flex items-center justify-center mb-1.5">
                        @if($collection->fotoBelakangUrl())
                            <img src="{{ $collection->fotoBelakangUrl() }}" alt="Tampak Belakang" class="w-full h-full object-cover">
                        @elseif($collection->fotoUrl())
                            <img src="{{ $collection->fotoUrl() }}" alt="Tampak Belakang" class="w-full h-full object-cover opacity-70">
                        @else
                            <i class="fa-solid fa-camera text-gray-400 text-sm"></i>
                        @endif
                    </div>
                    <span class="text-[10px] font-extrabold text-[#162544]" x-text="lang === 'id' ? 'Tampak Belakang' : 'Rear View'"></span>
                </button>
            </div>
        </div>

        <!-- 2. CARD SPESIFIKASI & IDENTITAS ARTEFAK (REVEAL ITEM 2) -->
        <div class="reveal-item bg-white rounded-3xl p-5 border border-[#E8DCC0] shadow-museum space-y-4 spring-card">
            <div class="flex items-start justify-between gap-3 border-b border-[#E8DCC0]/60 pb-3.5">
                <div>
                    <h2 class="text-xl font-black text-[#162544] tracking-tight">
                        {{ $collection->nama_koleksi }}
                    </h2>
                    <p class="text-xs text-[#C9981C] font-bold mt-0.5" x-text="lang === 'id' ? 'Koleksi Asli Museum Blambangan' : 'Authentic Collection of Blambangan Museum'"></p>
                </div>

                @php
                    $kategoriNama = $collection->category ? $collection->category->nama : ($collection->kategori ?? 'Umum');
                @endphp
                <div class="px-3 py-1.5 rounded-xl bg-[#FFF8EA] border border-[#EDD9A3] text-right flex-shrink-0">
                    <span class="text-[9px] uppercase tracking-wider text-gray-400 font-extrabold block" x-text="lang === 'id' ? 'Kategori' : 'Category'"></span>
                    <span class="text-xs font-black text-[#162544]">{{ $kategoriNama }}</span>
                </div>
            </div>

            <!-- Tabel Spesifikasi 2-Kolom Rapi -->
            <div class="space-y-2 text-xs divide-y divide-gray-100">
                <div class="flex justify-between py-1.5">
                    <span class="text-gray-500 font-medium" x-text="lang === 'id' ? 'Kategori Koleksi' : 'Collection Category'"></span>
                    <span class="font-bold text-[#162544]">{{ $kategoriNama }}</span>
                </div>

                <div class="flex justify-between py-1.5">
                    <span class="text-gray-500 font-medium" x-text="lang === 'id' ? 'Jenis Benda' : 'Object Type'"></span>
                    <span class="font-bold text-[#162544]">{{ $collection->jenis_benda ?? 'Artefak Bersejarah' }}</span>
                </div>

                <div class="flex justify-between py-1.5">
                    <span class="text-gray-500 font-medium" x-text="lang === 'id' ? 'Asal Temuan / Daerah' : 'Origin / Discovery'"></span>
                    <span class="font-bold text-[#162544]">{{ $collection->asal ?? 'Banyuwangi' }}</span>
                </div>

                <div class="flex justify-between py-1.5">
                    <span class="text-gray-500 font-medium" x-text="lang === 'id' ? 'Periode Pembuatan' : 'Period / Year'"></span>
                    <span class="font-bold text-[#162544]">{{ $collection->tahun_pembuatan ?? '-' }}</span>
                </div>

                <div class="flex justify-between py-1.5">
                    <span class="text-gray-500 font-medium" x-text="lang === 'id' ? 'No. Registrasi Baru' : 'New Registration No.'"></span>
                    <span class="font-mono font-bold text-[#162544]">{{ $collection->no_registrasi }}</span>
                </div>

                <div class="flex justify-between py-1.5">
                    <span class="text-gray-500 font-medium" x-text="lang === 'id' ? 'No. Registrasi Lama' : 'Old Registration No.'"></span>
                    <span class="font-mono text-gray-500">{{ $collection->no_registrasi_lama ?? '-' }}</span>
                </div>

                <div class="flex justify-between py-1.5">
                    <span class="text-gray-500 font-medium" x-text="lang === 'id' ? 'Kondisi Fisik' : 'Physical Condition'"></span>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $badgeClass }}">
                        {{ $collection->kondisiLabel() }}
                    </span>
                </div>
            </div>
        </div>

        <!-- 3. CARD PUTAR SUARA / AUDIO GUIDE (REVEAL ITEM 3) -->
        <div class="reveal-item bg-white rounded-3xl p-5 border border-[#E8DCC0] shadow-museum space-y-3 spring-card">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-black uppercase tracking-wider text-[#C9981C] flex items-center gap-2">
                    <i class="fa-solid fa-headphones"></i>
                    <span x-text="lang === 'id' ? 'Pemandu Suara (Audio Guide)' : 'Listen to Audio Guide'"></span>
                </h3>

                <!-- Wave Bars Visualizer -->
                <div x-show="isPlaying" class="flex items-center gap-1 h-5">
                    <span class="wave-bar"></span>
                    <span class="wave-bar"></span>
                    <span class="wave-bar"></span>
                    <span class="wave-bar"></span>
                    <span class="wave-bar"></span>
                </div>
            </div>

            <!-- Audio Controller Box -->
            <div class="p-4 rounded-2xl bg-[#F8F5ED] border border-[#E8DCC0] flex items-center gap-3.5">
                <!-- Play/Pause Button -->
                <button type="button" @click="toggleAudio()"
                    class="w-12 h-12 rounded-full gold-gradient-bg hover:brightness-110 text-[#162544] flex items-center justify-center shadow-md transition spring-tap flex-shrink-0">
                    <i :class="isPlaying ? 'fa-solid fa-pause text-base' : 'fa-solid fa-play text-base ml-1'"></i>
                </button>

                <!-- Audio Track & Progress -->
                <div class="flex-1 min-w-0 space-y-1.5">
                    <div class="flex items-center justify-between text-[11px] font-bold text-[#162544]">
                        <span x-text="lang === 'id' ? 'Narator Pemandu Museum' : 'Museum Audio Guide (English)'"></span>
                        <span class="font-mono text-[10px] text-gray-500" x-text="audioTime"></span>
                    </div>

                    <!-- Progress Bar -->
                    <div @click="seekAudio($event)"
                        class="w-full h-2.5 bg-white rounded-full overflow-hidden border border-[#E8DCC0] cursor-pointer relative">
                        <div class="h-full bg-[#C9981C] rounded-full transition-all duration-150" :style="'width: ' + audioProgress + '%'"></div>
                    </div>
                </div>

                <!-- Speaker Icon -->
                <div class="text-[#C9981C] text-lg px-1">
                    <i :class="isPlaying ? 'fa-solid fa-volume-high animate-pulse' : 'fa-solid fa-volume-low'"></i>
                </div>
            </div>

            <!-- Hidden Audio Element -->
            <audio id="audio-player" src="{{ $collection->audioUrl() }}" preload="metadata"></audio>
        </div>

        <!-- 4. CARD DESKRIPSI NARASI (REVEAL ITEM 4) -->
        <div class="reveal-item bg-white rounded-3xl p-5 border border-[#E8DCC0] shadow-museum space-y-3 spring-card">
            <h3 class="text-xs font-black uppercase tracking-wider text-[#C9981C] flex items-center gap-2">
                <i class="fa-solid fa-feather-pointed"></i>
                <span x-text="lang === 'id' ? 'Deskripsi & Sejarah Artefak' : 'Historical Narrative & Context'"></span>
            </h3>

            <!-- Teks Bahasa Indonesia -->
            <div x-show="lang === 'id'" class="text-xs text-gray-700 leading-relaxed space-y-2 font-normal">
                <p>{{ $collection->deskripsi ?? 'Informasi narasi sejarah untuk koleksi ini sedang dalam proses penyusunan oleh tim kurator Museum Blambangan.' }}</p>
            </div>

            <!-- Teks Terjemahan Bahasa Inggris -->
            <div x-show="lang === 'en'" x-cloak class="text-xs text-gray-700 leading-relaxed space-y-2 font-normal">
                <p>{{ $collection->deskripsiEn() }}</p>
            </div>
        </div>

        <!-- 5. CARD RATING & ULASAN PENGUNJUNG (REVEAL ITEM 5) -->
        <div class="reveal-item bg-white rounded-3xl p-5 border border-[#E8DCC0] shadow-museum space-y-4 spring-card">
            <!-- Header Rating Summary -->
            <div class="flex items-center justify-between border-b border-[#E8DCC0]/60 pb-3.5">
                <div class="flex items-center gap-3">
                    <span class="text-3xl font-black text-[#162544]">
                        {{ $collection->averageRating() }}
                    </span>

                    <div>
                        <div class="text-amber-500 text-xs flex gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        <span class="text-[10px] text-gray-400 font-bold block mt-0.5">
                            {{ $collection->reviewsCount() }} <span x-text="lang === 'id' ? 'Ulasan Pengunjung' : 'Visitor Reviews'"></span>
                        </span>
                    </div>
                </div>

                <button type="button" @click="reviewModal = true"
                    class="px-3.5 py-2 rounded-xl bg-[#FFF8EA] border border-[#EDD9A3] text-xs font-bold text-[#7B5200] hover:bg-[#C9981C] hover:text-white transition flex items-center gap-1.5 spring-tap">
                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                    <span x-text="lang === 'id' ? 'Tulis Ulasan' : 'Rate It'"></span>
                </button>
            </div>

            <!-- List Ulasan Pengunjung yang Disetujui -->
            <div class="space-y-3 pt-1">
                @forelse($collection->approvedReviews as $review)
                    <div class="p-3.5 rounded-2xl bg-[#F8F5ED] border border-[#E8DCC0]/60 space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-[#162544] text-[#FFD86B] font-extrabold text-xs flex items-center justify-center uppercase shadow-xs">
                                    {{ substr($review->nama_pengunjung, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-[#162544] leading-tight">
                                        {{ $review->nama_pengunjung }}
                                    </h4>
                                    <span class="text-[10px] text-gray-400 font-medium">
                                        {{ $review->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>

                            <!-- Stars -->
                            <div class="text-amber-500 text-[10px] flex gap-0.5">
                                @for($s = 1; $s <= 5; $s++)
                                    <i class="fa-{{ $s <= $review->rating ? 'solid' : 'regular' }} fa-star"></i>
                                @endfor
                            </div>
                        </div>

                        <p class="text-xs text-gray-700 leading-relaxed pl-10.5">
                            "{{ $review->komentar }}"
                        </p>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-400 text-xs space-y-1">
                        <i class="fa-regular fa-comment-dots text-3xl mb-1 text-[#C9981C]/50 block"></i>
                        <span x-text="lang === 'id' ? 'Belum ada ulasan untuk koleksi ini. Jadilah pengunjung pertama yang memberikan ulasan!' : 'No reviews yet for this collection. Be the first visitor to write a review!'"></span>
                    </div>
                @endforelse
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

    <!-- FLOATING ACTION BAR BAWAH -->
    <div class="fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-[#E8DCC0] p-3 shadow-lg">
        <div class="max-w-xl mx-auto flex items-center gap-3">
            <button type="button" @click="toggleAudio()"
                class="flex-1 py-3 px-4 rounded-xl gold-gradient-bg text-[#162544] font-black text-xs shadow-md flex items-center justify-center gap-2 transition spring-tap">
                <i :class="isPlaying ? 'fa-solid fa-pause' : 'fa-solid fa-volume-high'"></i>
                <span x-text="isPlaying ? (lang === 'id' ? 'Jeda Audio' : 'Pause Audio') : (lang === 'id' ? 'Dengar Audio Guide' : 'Play Audio Guide')"></span>
            </button>

            <a href="{{ route('public.scan') }}"
                class="py-3 px-4 rounded-xl bg-[#162544] text-[#FFD86B] font-bold text-xs shadow-md flex items-center justify-center gap-2 transition spring-tap">
                <i class="fa-solid fa-qrcode"></i>
                <span x-text="lang === 'id' ? 'Scan Koleksi Lain' : 'Scan Next'"></span>
            </a>
        </div>
    </div>

    <!-- FULLSCREEN LIGHTBOX PHOTO MODAL -->
    <div x-show="lightbox" x-cloak @click="lightbox = false"
        class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4 backdrop-blur-md cursor-zoom-out"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90">

        <button type="button" @click="lightbox = false"
            class="absolute top-5 right-5 w-10 h-10 rounded-full bg-white/20 text-white flex items-center justify-center text-lg hover:bg-white/30 transition spring-tap">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <img :src="currentPhoto" alt="{{ $collection->nama_koleksi }}"
            class="max-w-full max-h-[85vh] object-contain rounded-xl shadow-2xl">
    </div>

    <!-- MODAL TULIS ULASAN POP-UP -->
    <div x-show="reviewModal" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div @click.outside="reviewModal = false"
            class="bg-white rounded-3xl max-w-sm w-full p-6 shadow-2xl border border-[#E8DCC0] relative space-y-4"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95">

            <!-- Close Button -->
            <button type="button" @click="reviewModal = false"
                class="absolute top-4 right-4 w-8 h-8 rounded-full bg-gray-100 text-gray-400 hover:text-gray-700 flex items-center justify-center transition spring-tap">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>

            <!-- Modal Header -->
            <div class="text-center space-y-1">
                <h3 class="text-base font-black text-[#162544]" x-text="lang === 'id' ? 'Beri Ulasan Koleksi' : 'Review this Artifact'"></h3>
                <p class="text-xs text-gray-500 font-medium">{{ $collection->nama_koleksi }}</p>
            </div>

            <!-- Form -->
            <form action="{{ route('public.koleksi.review', $collection->kode_unik) }}" method="POST" class="space-y-3.5">
                @csrf

                <!-- Star Rating Picker -->
                <div class="text-center space-y-1.5">
                    <label class="text-[11px] font-bold text-gray-600 block" x-text="lang === 'id' ? 'Bintang Penilaian' : 'Star Rating'"></label>
                    <div class="flex justify-center gap-2 text-2xl text-amber-500 cursor-pointer">
                        <template x-for="star in [1, 2, 3, 4, 5]" :key="star">
                            <i @click="userRating = star"
                                :class="star <= userRating ? 'fa-solid fa-star' : 'fa-regular fa-star'"
                                class="hover:scale-125 transition duration-150 spring-tap"></i>
                        </template>
                    </div>
                    <input type="hidden" name="rating" :value="userRating">
                </div>

                <!-- Nama Pengunjung -->
                <div class="space-y-1 text-left">
                    <label class="text-[11px] font-bold text-gray-600 block" x-text="lang === 'id' ? 'Nama Anda (Opsional)' : 'Your Name (Optional)'"></label>
                    <input type="text" name="nama_pengunjung" placeholder="Contoh: Siti Rahma"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-[#E8DCC0] focus:ring-2 focus:ring-[#C9981C] text-xs outline-none bg-[#F8F5ED]">
                </div>

                <!-- Komentar Ulasan -->
                <div class="space-y-1 text-left">
                    <label class="text-[11px] font-bold text-gray-600 block" x-text="lang === 'id' ? 'Komentar Pengalaman' : 'Your Feedback / Comment'"></label>
                    <textarea name="komentar" rows="3" required
                        placeholder="Tuliskan pengalaman atau kesan Anda melihat koleksi ini..."
                        class="w-full px-3.5 py-2.5 rounded-xl border border-[#E8DCC0] focus:ring-2 focus:ring-[#C9981C] text-xs outline-none bg-[#F8F5ED]"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full py-3 rounded-xl gold-gradient-bg hover:brightness-110 text-[#162544] font-black text-xs shadow-md transition spring-tap">
                    <span x-text="lang === 'id' ? 'Kirim Ulasan' : 'Submit Review'"></span>
                </button>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT APP STATE -->
    <script>
        function detailKoleksiApp() {
            return {
                lang: 'id',
                activeAngle: 'depan',
                lightbox: false,
                reviewModal: false,
                userRating: 5,
                isPlaying: false,
                audioTime: '0:00 / 1:24',
                audioProgress: 0,
                scrollProgress: 0,
                showScrollTop: false,
                defaultPhoto: "{{ $collection->fotoUrl() }}",
                fotoDepan: "{{ $collection->fotoDepanUrl() }}",
                fotoSamping: "{{ $collection->fotoSampingUrl() ?: $collection->fotoUrl() }}",
                fotoBelakang: "{{ $collection->fotoBelakangUrl() ?: $collection->fotoUrl() }}",

                init() {
                    // Scroll Reveal Observer
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                entry.target.classList.add('is-visible');
                            }
                        });
                    }, { threshold: 0.1 });

                    document.querySelectorAll('.reveal-item').forEach(el => observer.observe(el));

                    // Scroll Progress & Top Button
                    window.addEventListener('scroll', () => {
                        const totalHeight = document.documentElement.scrollHeight - window.innerHeight;
                        this.scrollProgress = totalHeight > 0 ? (window.scrollY / totalHeight) * 100 : 0;
                        this.showScrollTop = window.scrollY > 280;
                    });

                    // Pre-load natural speech voices
                    if ('speechSynthesis' in window) {
                        window.speechSynthesis.getVoices();
                        if (window.speechSynthesis.onvoiceschanged !== undefined) {
                            window.speechSynthesis.onvoiceschanged = () => window.speechSynthesis.getVoices();
                        }
                    }

                    // Audio element events
                    const audio = document.getElementById('audio-player');
                    if (audio) {
                        audio.addEventListener('timeupdate', () => {
                            if (audio.duration && !isNaN(audio.duration)) {
                                this.audioProgress = (audio.currentTime / audio.duration) * 100;
                                this.audioTime = this.formatTime(audio.currentTime) + ' / ' + this.formatTime(audio.duration);
                            }
                        });
                        audio.addEventListener('play', () => { this.isPlaying = true; });
                        audio.addEventListener('pause', () => { this.isPlaying = false; });
                        audio.addEventListener('ended', () => {
                            this.isPlaying = false;
                            this.audioProgress = 0;
                            this.audioTime = '0:00 / ' + this.formatTime(audio.duration || 84);
                        });
                    }
                },

                setLang(newLang) {
                    if (this.lang !== newLang) {
                        this.stopAudio();
                        this.lang = newLang;
                    }
                },

                toggleLang() {
                    this.setLang(this.lang === 'id' ? 'en' : 'id');
                },

                get currentPhoto() {
                    if (this.activeAngle === 'depan' && this.fotoDepan) return this.fotoDepan;
                    if (this.activeAngle === 'samping' && this.fotoSamping) return this.fotoSamping;
                    if (this.activeAngle === 'belakang' && this.fotoBelakang) return this.fotoBelakang;
                    return this.defaultPhoto;
                },

                shareCollection() {
                    if (navigator.share) {
                        navigator.share({
                            title: "{{ $collection->nama_koleksi }} — MUSEWANGI",
                            text: "Lihat artefak bersejarah {{ $collection->nama_koleksi }} di Museum Blambangan Banyuwangi!",
                            url: window.location.href
                        }).catch(() => {});
                    } else {
                        navigator.clipboard.writeText(window.location.href);
                        alert("Tautan koleksi berhasil disalin ke papan klip!");
                    }
                },

                formatTime(sec) {
                    const m = Math.floor(sec / 60);
                    const s = Math.floor(sec % 60);
                    return m + ':' + (s < 10 ? '0' : '') + s;
                },

                toggleAudio() {
                    const audio = document.getElementById('audio-player');
                    const hasRealAudio = audio && audio.src && !audio.src.endsWith('/') && !audio.src.includes('undefined') && !audio.src.includes('null');

                    if (hasRealAudio) {
                        if (audio.paused) {
                            audio.play().then(() => {
                                this.isPlaying = true;
                            }).catch(() => {
                                this.toggleSpeech();
                            });
                        } else {
                            audio.pause();
                            this.isPlaying = false;
                        }
                    } else {
                        this.toggleSpeech();
                    }
                },

                toggleSpeech() {
                    if (!('speechSynthesis' in window)) {
                        alert('Browser Anda tidak mendukung pemutar suara otomatis.');
                        return;
                    }

                    // 1. If currently speaking and active -> Pause
                    if (window.speechSynthesis.speaking && !window.speechSynthesis.paused && this.isPlaying) {
                        window.speechSynthesis.pause();
                        this.isPlaying = false;
                        return;
                    }

                    // 2. If currently paused -> Resume
                    if (window.speechSynthesis.paused) {
                        window.speechSynthesis.resume();
                        this.isPlaying = true;
                        return;
                    }

                    // 3. Otherwise start new speech playback
                    window.speechSynthesis.cancel();

                    const namaKoleksi = "{{ addslashes($collection->nama_koleksi) }}";
                    const deskripsiId = "{{ addslashes(str_replace(["\r", "\n"], ' ', $collection->deskripsi ?? '')) }}";
                    const deskripsiEn = "{{ addslashes(str_replace(["\r", "\n"], ' ', $collection->deskripsiEn())) }}";

                    const textToRead = this.lang === 'id'
                        ? (namaKoleksi + '. ' + deskripsiId)
                        : (namaKoleksi + '. ' + deskripsiEn);

                    const utterance = new SpeechSynthesisUtterance(textToRead);
                    utterance.lang = this.lang === 'id' ? 'id-ID' : 'en-US';
                    utterance.rate = 0.88; // Natural, clear pacing for museum docent
                    utterance.pitch = 1.0; // Warm, realistic natural pitch

                    // Select highest quality human-like Natural HD voice
                    const voices = window.speechSynthesis.getVoices();
                    const targetLangPrefix = this.lang === 'id' ? 'id' : 'en';

                    const naturalVoice = voices.find(v =>
                        v.lang.toLowerCase().startsWith(targetLangPrefix) &&
                        (v.name.includes('Natural') || v.name.includes('Google') || v.name.includes('Online') || v.name.includes('Neural') || v.name.includes('Enhanced') || v.name.includes('Premium'))
                    ) || voices.find(v => v.lang.toLowerCase().startsWith(targetLangPrefix));

                    if (naturalVoice) {
                        utterance.voice = naturalVoice;
                    }

                    const totalLength = textToRead.length;
                    const estimatedSeconds = Math.max(15, Math.round(totalLength / 13));
                    let elapsed = 0;

                    utterance.onstart = () => {
                        this.isPlaying = true;
                        this.audioTime = '0:00 / ' + this.formatTime(estimatedSeconds);
                    };

                    utterance.onboundary = (event) => {
                        if (event.charIndex) {
                            const pct = Math.min(100, Math.round((event.charIndex / totalLength) * 100));
                            this.audioProgress = pct;
                            elapsed = Math.round((event.charIndex / totalLength) * estimatedSeconds);
                            this.audioTime = this.formatTime(elapsed) + ' / ' + this.formatTime(estimatedSeconds);
                        }
                    };

                    utterance.onend = () => {
                        this.isPlaying = false;
                        this.audioProgress = 100;
                        this.audioTime = this.formatTime(estimatedSeconds) + ' / ' + this.formatTime(estimatedSeconds);
                        setTimeout(() => {
                            this.audioProgress = 0;
                            this.audioTime = '0:00 / ' + this.formatTime(estimatedSeconds);
                        }, 1200);
                    };

                    utterance.onerror = () => {
                        this.isPlaying = false;
                    };

                    window.speechSynthesis.speak(utterance);
                },

                stopAudio() {
                    const audio = document.getElementById('audio-player');
                    if (audio) {
                        audio.pause();
                        audio.currentTime = 0;
                    }
                    if ('speechSynthesis' in window) {
                        window.speechSynthesis.cancel();
                    }
                    this.isPlaying = false;
                    this.audioProgress = 0;
                },

                seekAudio(event) {
                    const rect = event.currentTarget.getBoundingClientRect();
                    const clickX = event.clientX - rect.left;
                    const width = rect.width;
                    const pct = Math.max(0, Math.min(100, (clickX / width) * 100));
                    this.audioProgress = pct;

                    const audio = document.getElementById('audio-player');
                    if (audio && audio.duration) {
                        audio.currentTime = (pct / 100) * audio.duration;
                    }
                }
            };
        }
    </script>
</body>

</html>
