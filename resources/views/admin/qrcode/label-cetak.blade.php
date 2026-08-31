<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label Etalase Museum — {{ $koleksi->nama_koleksi }}</title>

    <!-- Favicon HD Multi-Resolution -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=5">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=5">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=5">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=5">

    <!-- Google Fonts: Playfair Display / Cinzel & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;0,900;1,400&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Vite Compiled Assets (Tailwind & Alpine) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #EDE8DE;
            color: #2D251D;
            -webkit-font-smoothing: antialiased;
        }

        .font-serif-title {
            font-family: 'Playfair Display', Georgia, serif;
        }

        /* Placard Card Dimensions (Standard Museum Placard Landscape ~ 210mm x 148mm) */
        .museum-placard {
            width: 210mm;
            min-height: 148mm;
            background: #FAF6ED;
            position: relative;
            box-sizing: border-box;
            border-radius: 4px;
            box-shadow: 0 12px 35px rgba(35, 25, 15, 0.12);
            overflow: hidden;
        }

        /* Print Media Settings */
        @media print {
            body {
                background: transparent !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .no-print {
                display: none !important;
            }

            .print-wrapper {
                padding: 0 !important;
                margin: 0 !important;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .museum-placard {
                box-shadow: none !important;
                border-radius: 0 !important;
                page-break-inside: avoid;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            @page {
                size: A5 landscape;
                margin: 0;
            }
        }
    </style>
</head>

<body class="min-h-screen p-4 sm:p-8 flex flex-col items-center justify-start">

    <!-- ACTION CONTROLS (Screen only, hidden on print) -->
    <div class="no-print w-full max-w-4xl mb-6 bg-white rounded-2xl p-4 shadow-sm border border-[#E8DCC0] flex flex-wrap items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.qrcode.index') }}"
                class="w-10 h-10 rounded-xl bg-[#F8F5ED] hover:bg-[#E8DCC0] text-[#162544] flex items-center justify-center transition"
                title="Kembali ke Daftar QR Code">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-sm font-extrabold text-[#162544]">Label Etalase Pameran Museum</h1>
                <p class="text-xs text-gray-500">Standar resmi etalase Museum Blambangan Banyuwangi (Format A5 Landscape)</p>
            </div>
        </div>

        <div class="flex items-center gap-2.5">
            <button type="button" onclick="window.print()"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#C9981C] hover:bg-[#B78921] text-white font-extrabold text-xs shadow-md transition transform active:scale-95">
                <i class="fa-solid fa-print text-sm"></i>
                <span>Cetak Label (Print)</span>
            </button>

            <button type="button" onclick="window.print()"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#162544] hover:bg-[#0E1830] text-white font-bold text-xs shadow transition">
                <i class="fa-solid fa-file-pdf text-sm text-[#FFD86B]"></i>
                <span>Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- PLACARD WRAPPER -->
    <div class="print-wrapper flex justify-center w-full">

        <!-- ============================================================== -->
        <!-- MUSEUM SHOWCASE PLACARD (Persis Desain Contoh media_1787747280787) -->
        <!-- ============================================================== -->
        <div class="museum-placard p-8 flex gap-6 relative">

            <!-- ── LEFT FLANK ORNAMENT: GOLDEN GAJAH OLING & SWEEPING RIBBON ── -->
            <div class="absolute left-0 bottom-0 top-0 w-36 pointer-events-none overflow-hidden select-none z-0">
                <svg viewBox="0 0 160 460" class="w-full h-full" fill="none">
                    <!-- Outer sweeping golden curve -->
                    <path d="M 45 450 C 35 340, 28 240, 58 160 C 85 85, 125 45, 155 12"
                        stroke="#C4942A" stroke-width="4.5" stroke-linecap="round" />

                    <!-- Inner parallel thin golden curve -->
                    <path d="M 28 445 C 20 345, 15 250, 42 170 C 68 98, 108 58, 138 25"
                        stroke="#D5A942" stroke-width="1.8" stroke-linecap="round" opacity="0.85" />

                    <!-- Bottom-Left Gajah Oling & Floral Medallion -->
                    <g transform="translate(8, 315) scale(0.85)" opacity="0.95">
                        <!-- Floral Petals -->
                        <g fill="#B88424" stroke="#8E6110" stroke-width="1">
                            <path d="M 45 50 C 25 35, 15 15, 28 5 C 42 -5, 55 15, 50 35 Z" />
                            <path d="M 50 45 C 50 20, 65 5, 80 15 C 92 25, 80 45, 60 52 Z" />
                            <path d="M 52 55 C 75 50, 95 60, 95 75 C 95 90, 75 88, 60 70 Z" />
                            <path d="M 48 60 C 58 80, 52 105, 38 108 C 22 110, 20 90, 35 70 Z" />
                            <path d="M 42 55 C 20 65, -2 60, -2 45 C -2 30, 20 32, 35 45 Z" />
                        </g>

                        <!-- Central Gajah Oling Spiral / Core -->
                        <circle cx="48" cy="54" r="16" fill="#C5962C" stroke="#7A520C" stroke-width="2" />
                        <circle cx="48" cy="54" r="11" fill="#FAF6ED" stroke="#B88424" stroke-width="2" />
                        <path d="M 48 45 C 53 45, 56 49, 56 54 C 56 58, 51 61, 46 58 C 42 55, 43 50, 47 49"
                            fill="none" stroke="#7A520C" stroke-width="2.5" stroke-linecap="round" />

                        <!-- Flowing lower sulur leaves -->
                        <path d="M 30 75 C 10 90, 5 115, 20 130 C 35 120, 30 95, 30 75 Z" fill="#C5962C" />
                        <path d="M 42 85 C 32 105, 30 130, 48 140 C 58 128, 50 102, 42 85 Z" fill="#D5A942" />
                        <path d="M 12 110 C -5 125, -2 145, 12 152 C 22 142, 18 125, 12 110 Z" fill="#B88424" opacity="0.8" />
                    </g>
                </svg>
            </div>

            <!-- ── LEFT COLUMN: TITLE & BILINGUAL NARRATIVE ────────── -->
            <div class="flex-1 min-w-0 pl-16 z-10 flex flex-col justify-between">
                <div>
                    <!-- Subtitle / Kategori -->
                    <h3 class="font-serif-title text-[#A77218] text-xs sm:text-[13px] font-bold tracking-wide leading-tight mb-1">
                        {{ $koleksi->jenis_benda ?? ($koleksi->kategori ?? 'Tablet Tanah Liat') }}
                    </h3>

                    <!-- Main Title (Nama Koleksi) -->
                    <h2 class="font-serif-title text-[#1D140C] text-2xl sm:text-[27px] font-black tracking-tight leading-tight mb-2">
                        {{ $koleksi->nama_koleksi }}
                    </h2>

                    <!-- Decorative Gold Divider (Emblem / Floral Wings) -->
                    <div class="my-2 flex items-center gap-1.5 text-[#C4942A]">
                        <svg class="h-3.5 w-24 text-[#C4942A]" viewBox="0 0 100 16" fill="currentColor">
                            <path d="M 0 8 Q 20 8 35 7 Q 42 3 48 8 Q 42 13 35 9 Q 20 8 0 8 Z" opacity="0.75" />
                            <circle cx="50" cy="8" r="2.8" />
                            <circle cx="42" cy="8" r="1.5" />
                            <circle cx="58" cy="8" r="1.5" />
                            <path d="M 100 8 Q 80 8 65 7 Q 58 3 52 8 Q 58 13 65 9 Q 80 8 100 8 Z" opacity="0.75" />
                        </svg>
                    </div>

                    <!-- Narasi Bahasa Indonesia -->
                    <div class="text-[10px] sm:text-[10.5px] text-[#2D251D] leading-relaxed text-justify space-y-1 font-normal">
                        <p>
                            {{ $koleksi->deskripsi ?? 'Bodhisattva merupakan tablet tanah liat yang berbentuk oval dengan penggambaran Dhyani Bodhisattva berada di tengah dengan penggambaran Bodhisattva tersebut sedang duduk di atas tempat duduk (Padmasana) dalam posisi Ardhaparyanka (kaki kanan menjuntai ke bawah dan kaki kiri bersila di atas tempat duduk). Tangan kanannya ditampilkan dalam posisi Waramudra (agak terbuka), sementara tangan kirinya menggenggam tangkai bunga teratai (Utpala). Figur Bodhisattva ini mengenakan mahkota serta kalung sebagai atribut tambahan. Selain itu, terdapat lima baris inskripsi beraksara Jawa Kuno.' }}
                        </p>
                    </div>

                    <!-- Thin Horizontal Divider -->
                    <div class="my-2.5 flex items-center justify-center gap-2">
                        <span class="h-[1px] w-full bg-[#D8BE8E]"></span>
                        <i class="fa-solid fa-diamond text-[#B78526] text-[7px]"></i>
                        <span class="h-[1px] w-full bg-[#D8BE8E]"></span>
                    </div>

                    <!-- Narasi Bahasa Inggris (Bilingual) -->
                    <div class="text-[9.5px] sm:text-[10px] text-[#2D251D] leading-relaxed text-justify space-y-1 font-normal">
                        <p>
                            {{ $koleksi->deskripsiEn() }}
                        </p>
                    </div>
                </div>

                <!-- Footer halus (jika ada sisa ruang) -->
                <div class="pt-2 flex items-center justify-between text-[8px] text-gray-400 font-semibold tracking-wider uppercase border-t border-[#D8BE8E]/40">
                    <span>Museum Blambangan</span>
                    <span>Banyuwangi</span>
                </div>
            </div>

            <!-- ── RIGHT COLUMN: INFO TABLES & OFFICIAL QR CODE ────── -->
            <div class="w-[74mm] flex-shrink-0 z-10 flex flex-col justify-between space-y-3">

                <!-- TABLE 1: INFORMASI UMUM -->
                <div class="space-y-1">
                    <!-- Brown Ochre Header Bar -->
                    <div class="bg-[#A97824] text-white text-center py-1 px-3 rounded-md shadow-2xs">
                        <h4 class="text-[11px] font-extrabold uppercase tracking-wide">
                            Informasi Umum
                        </h4>
                    </div>

                    <!-- Table Rows -->
                    <div class="rounded-md overflow-hidden border border-[#D4B886] bg-white">
                        <table class="w-full text-[9px] leading-tight divide-y divide-[#D4B886]">
                            <tr class="divide-x divide-[#D4B886]">
                                <td class="px-2 py-1 font-bold text-[#1D140C] w-[46%] bg-white">No. Registrasi Baru</td>
                                <td class="px-2 py-1 text-center font-mono text-[#1D140C] bg-white">{{ $koleksi->no_registrasi }}</td>
                            </tr>
                            <tr class="divide-x divide-[#D4B886]">
                                <td class="px-2 py-1 font-bold text-[#1D140C] bg-white">No. Registrasi Lama</td>
                                <td class="px-2 py-1 text-center font-mono text-[#1D140C] bg-white">{{ $koleksi->no_registrasi_lama ?? '002/ BWI/ 2024' }}</td>
                            </tr>
                            <tr class="divide-x divide-[#D4B886]">
                                <td class="px-2 py-1 font-bold text-[#1D140C] bg-white">Tanggal Registrasi</td>
                                <td class="px-2 py-1 text-center text-[#1D140C] bg-white">{{ $koleksi->created_at ? $koleksi->created_at->translatedFormat('d F Y') : '04 Maret 2026' }}</td>
                            </tr>
                            <tr class="divide-x divide-[#D4B886]">
                                <td class="px-2 py-1 font-bold text-[#1D140C] bg-white">Jenis Benda</td>
                                <td class="px-2 py-1 text-center text-[#1D140C] bg-white">{{ $koleksi->jenis_benda ?? ($koleksi->kategori ?? 'Tablet Tanah Liat') }}</td>
                            </tr>
                            <tr class="divide-x divide-[#D4B886]">
                                <td class="px-2 py-1 font-bold text-[#1D140C] bg-white">Tahun Pembuatan</td>
                                <td class="px-2 py-1 text-center text-[#1D140C] bg-white">{{ $koleksi->tahun_pembuatan ?? '1972' }}</td>
                            </tr>
                            <tr class="divide-x divide-[#D4B886]">
                                <td class="px-2 py-1 font-bold text-[#1D140C] bg-white">Asal</td>
                                <td class="px-2 py-1 text-center text-[#1D140C] bg-white leading-tight">{{ $koleksi->asal ?? 'Tambakrejo, Muncar, Banyuwangi' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- TABLE 2: INFORMASI UMUM (SPESIFIKASI FISIK) -->
                <div class="space-y-1">
                    <!-- Brown Ochre Header Bar -->
                    <div class="bg-[#A97824] text-white text-center py-1 px-3 rounded-md shadow-2xs">
                        <h4 class="text-[11px] font-extrabold uppercase tracking-wide">
                            Informasi Umum
                        </h4>
                    </div>

                    <!-- Table Rows -->
                    <div class="rounded-md overflow-hidden border border-[#D4B886] bg-white">
                        <table class="w-full text-[9px] leading-tight divide-y divide-[#D4B886]">
                            <tr class="divide-x divide-[#D4B886]">
                                <td class="px-2 py-1 font-bold text-[#1D140C] w-[46%] bg-white">Diameter</td>
                                <td class="px-2 py-1 text-center text-[#1D140C] bg-white">{{ $koleksi->diameter() }}</td>
                            </tr>
                            <tr class="divide-x divide-[#D4B886]">
                                <td class="px-2 py-1 font-bold text-[#1D140C] bg-white">Tebal</td>
                                <td class="px-2 py-1 text-center text-[#1D140C] bg-white">{{ $koleksi->tebal() }}</td>
                            </tr>
                            <tr class="divide-x divide-[#D4B886]">
                                <td class="px-2 py-1 font-bold text-[#1D140C] bg-white">Bahan</td>
                                <td class="px-2 py-1 text-center text-[#1D140C] bg-white">{{ $koleksi->bahan() }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- QR CODE ETALASE CARD (Persis Contoh Tanpa Teks Tambahan) -->
                <div class="flex justify-end pt-1">
                    <div class="bg-white rounded-xl p-2 border border-[#D4B886] shadow-xs flex items-center justify-center relative w-28 h-28">
                        <!-- Vector SVG QR Code -->
                        <img src="{{ $koleksi->qrCodeDataUri(160) }}"
                            alt="QR Code {{ $koleksi->nama_koleksi }}"
                            class="w-full h-full object-contain">

                        <!-- Museum Emblem in the center of QR -->
                        <div class="absolute inset-0 m-auto w-6 h-6 rounded-full bg-[#162544] border border-[#C9981C] flex items-center justify-center shadow-xs overflow-hidden pointer-events-none">
                            <img src="{{ asset('favicon.png') }}" alt="Logo" class="w-4 h-4 object-contain">
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</body>

</html>
