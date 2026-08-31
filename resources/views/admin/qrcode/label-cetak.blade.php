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

    <!-- Google Fonts: Cinzel, Playfair Display, Lora, Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,600;0,700;0,800;0,900;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Vite Compiled Assets (Tailwind & Alpine) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #EDE8DE;
            color: #1F1A14;
            -webkit-font-smoothing: antialiased;
        }

        .font-serif-title {
            font-family: 'Cinzel', 'Playfair Display', Georgia, serif;
        }

        .font-serif-subtitle {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .font-serif-body {
            font-family: 'Lora', Georgia, 'Times New Roman', serif;
        }

        /* Placard Card Dimensions (Standard Museum Placard Landscape ~ 210mm x 148mm) */
        .museum-placard {
            width: 210mm;
            min-height: 148mm;
            background: #FCFAF5;
            position: relative;
            box-sizing: border-box;
            border-radius: 8px;
            box-shadow: 0 15px 40px rgba(35, 25, 15, 0.15);
            overflow: hidden;
            border: 1px solid #E2D1B3;
        }

        /* Inner ornamental border frame */
        .placard-inner-frame {
            position: absolute;
            inset: 8px;
            border: 1.5px solid #D6B97E;
            border-radius: 6px;
            pointer-events: none;
            z-index: 1;
        }

        /* Table header bronze styling matching Canva */
        .table-bronze-header {
            background: #B07D1E;
            color: #ffffff;
            font-weight: 700;
            text-align: center;
            padding: 5px 10px;
            border-top-left-radius: 7px;
            border-top-right-radius: 7px;
            font-size: 11.5px;
            letter-spacing: 0.2px;
        }

        .table-bronze-container {
            border: 1.5px solid #C4A265;
            border-top: none;
            border-bottom-left-radius: 7px;
            border-bottom-right-radius: 7px;
            overflow: hidden;
            background: #FFFFFF;
        }

        .table-bronze-container table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5px;
        }

        .table-bronze-container td {
            padding: 4px 8px;
            border-bottom: 1px solid #C4A265;
            border-right: 1px solid #C4A265;
            color: #1E1308;
        }

        .table-bronze-container tr:last-child td {
            border-bottom: none;
        }

        .table-bronze-container td:last-child {
            border-right: none;
        }

        .table-bronze-container td.label-col {
            font-weight: 700;
            width: 46%;
            background: #FFFFFF;
        }

        .table-bronze-container td.val-col {
            text-align: center;
            background: #FFFFFF;
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
                border: 1px solid #D6B97E !important;
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
        <!-- MUSEUM SHOWCASE PLACARD (Persis Desain Canva media_1788155142055) -->
        <!-- ============================================================== -->
        <div class="museum-placard p-7 flex gap-5 relative">

            <!-- Inner Golden Frame -->
            <div class="placard-inner-frame"></div>

            <!-- ── LEFT FLANK ORNAMENT: GOLDEN GAJAH OLING & SWEEPING RIBBON (CANVA STYLE) ── -->
            <div class="absolute left-0 bottom-0 top-0 w-36 pointer-events-none overflow-hidden select-none z-0">
                <svg viewBox="0 0 160 480" class="w-full h-full" fill="none">
                    <!-- Subtle damask / batik pattern background watermark on left -->
                    <g opacity="0.08" fill="#B07D1E">
                        <circle cx="25" cy="80" r="18" />
                        <circle cx="25" cy="160" r="18" />
                        <circle cx="25" cy="240" r="18" />
                        <circle cx="25" cy="320" r="18" />
                        <path d="M 10 70 Q 25 50 40 70 Q 25 90 10 70 Z" />
                        <path d="M 10 150 Q 25 130 40 150 Q 25 170 10 150 Z" />
                        <path d="M 10 230 Q 25 210 40 230 Q 25 250 10 230 Z" />
                    </g>

                    <!-- Outer sweeping golden curve line -->
                    <path d="M 38 460 C 26 350, 20 250, 48 160 C 72 85, 115 45, 145 15"
                        stroke="#B8860B" stroke-width="4.5" stroke-linecap="round" />

                    <!-- Inner parallel thin golden curve -->
                    <path d="M 22 455 C 12 355, 8 260, 32 170 C 56 98, 98 58, 128 28"
                        stroke="#D4A82A" stroke-width="1.8" stroke-linecap="round" opacity="0.8" />

                    <!-- Bottom-Left Gajah Oling & Floral Medallion -->
                    <g transform="translate(6, 335) scale(0.9)" opacity="0.95">
                        <!-- Floral Petals -->
                        <g fill="#B8860B" stroke="#8E6110" stroke-width="1">
                            <path d="M 45 50 C 25 35, 15 15, 28 5 C 42 -5, 55 15, 50 35 Z" />
                            <path d="M 50 45 C 50 20, 65 5, 80 15 C 92 25, 80 45, 60 52 Z" />
                            <path d="M 52 55 C 75 50, 95 60, 95 75 C 95 90, 75 88, 60 70 Z" />
                            <path d="M 48 60 C 58 80, 52 105, 38 108 C 22 110, 20 90, 35 70 Z" />
                            <path d="M 42 55 C 20 65, -2 60, -2 45 C -2 30, 20 32, 35 45 Z" />
                        </g>

                        <!-- Central Gajah Oling Spiral / Core -->
                        <circle cx="48" cy="54" r="16" fill="#C5962C" stroke="#7A520C" stroke-width="2" />
                        <circle cx="48" cy="54" r="11" fill="#FCFAF5" stroke="#B8860B" stroke-width="2" />
                        <path d="M 48 45 C 53 45, 56 49, 56 54 C 56 58, 51 61, 46 58 C 42 55, 43 50, 47 49"
                            fill="none" stroke="#7A520C" stroke-width="2.5" stroke-linecap="round" />

                        <!-- Flowing lower sulur leaves -->
                        <path d="M 30 75 C 10 90, 5 115, 20 130 C 35 120, 30 95, 30 75 Z" fill="#C5962C" />
                        <path d="M 42 85 C 32 105, 30 130, 48 140 C 58 128, 50 102, 42 85 Z" fill="#D4A82A" />
                        <path d="M 12 110 C -5 125, -2 145, 12 152 C 22 142, 18 125, 12 110 Z" fill="#B8860B" opacity="0.85" />
                    </g>
                </svg>
            </div>

            <!-- ── LEFT COLUMN: TITLE & BILINGUAL NARRATIVE (CANVA STYLE) ────────── -->
            <div class="flex-1 min-w-0 pl-14 z-10 flex flex-col justify-between">
                <div>
                    <!-- Subtitle / Kategori (e.g. Patung Arca) -->
                    <h3 class="font-serif-subtitle text-[#A66E1E] text-base sm:text-[17px] font-bold tracking-wide leading-tight mb-1">
                        {{ $koleksi->jenis_benda ?? ($koleksi->kategori ?? 'Patung Arca') }}
                    </h3>

                    <!-- Main Title (e.g. Arca Jaladwara / Stupika) -->
                    <h2 class="font-serif-title text-[#1E1308] text-2xl sm:text-[28px] font-black tracking-tight leading-tight mb-2">
                        {{ $koleksi->nama_koleksi }}
                    </h2>

                    <!-- Decorative Golden Filigree Divider (Canva Style) -->
                    <div class="my-2 flex items-center justify-start gap-1">
                        <svg class="h-3.5 w-32 text-[#B8860B]" viewBox="0 0 120 16" fill="currentColor">
                            <path d="M 0 8 Q 25 8 45 7 Q 52 2 60 8 Q 52 14 45 9 Q 25 8 0 8 Z" opacity="0.8" />
                            <circle cx="60" cy="8" r="3.2" />
                            <circle cx="51" cy="8" r="1.6" />
                            <circle cx="69" cy="8" r="1.6" />
                            <path d="M 120 8 Q 95 8 75 7 Q 68 2 60 8 Q 68 14 75 9 Q 95 8 120 8 Z" opacity="0.8" />
                        </svg>
                    </div>

                    <!-- Narasi Bahasa Indonesia (Justify & Serif) -->
                    <div class="font-serif-body text-[10.5px] sm:text-[11.2px] text-[#1F1A14] leading-relaxed text-justify space-y-1 font-normal">
                        <p>
                            {{ $koleksi->deskripsi ?? 'Arca Jaladwara merupakan pancuran air yang digunakan di candi-candi atau pemandian kuno untuk menyalurkan air. Arca ini digambarkan dalam posisi duduk dengan bagian kepala dan tangan kanan hilang. Arca ini menggunakan selendang yang dikenakan dari kiri melintang ke pinggang kanan (Upawita), dan tangan kanan yang menggunakan gelang bertumpu pada kaki kiri.' }}
                        </p>
                    </div>

                    <!-- Second Decorative Golden Filigree Divider (Canva Style) -->
                    <div class="my-2.5 flex items-center justify-start gap-1">
                        <svg class="h-3.5 w-32 text-[#B8860B]" viewBox="0 0 120 16" fill="currentColor">
                            <path d="M 0 8 Q 25 8 45 7 Q 52 2 60 8 Q 52 14 45 9 Q 25 8 0 8 Z" opacity="0.8" />
                            <circle cx="60" cy="8" r="3.2" />
                            <circle cx="51" cy="8" r="1.6" />
                            <circle cx="69" cy="8" r="1.6" />
                            <path d="M 120 8 Q 95 8 75 7 Q 68 2 60 8 Q 68 14 75 9 Q 95 8 120 8 Z" opacity="0.8" />
                        </svg>
                    </div>

                    <!-- Narasi Bahasa Inggris (Bilingual, Justify & Serif) -->
                    <div class="font-serif-body text-[10px] sm:text-[10.5px] text-[#1F1A14] leading-relaxed text-justify space-y-1 font-normal">
                        <p>
                            {{ $koleksi->deskripsiEn() }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- ── RIGHT COLUMN: INFO TABLES & OFFICIAL QR CODE (CANVA STYLE) ────── -->
            <div class="w-[76mm] flex-shrink-0 z-10 flex flex-col justify-between space-y-3">

                <!-- TABLE 1: INFORMASI UMUM (CANVA DESIGN) -->
                <div>
                    <div class="table-bronze-header">
                        Informasi Umum
                    </div>

                    <div class="table-bronze-container">
                        <table>
                            <tr>
                                <td class="label-col">No. Registrasi Baru</td>
                                <td class="val-col font-mono">{{ $koleksi->no_registrasi }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">No. Registrasi Lama</td>
                                <td class="val-col font-mono">{{ $koleksi->no_registrasi_lama ?? '080/ BWI/ 2024' }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">Tanggal Registrasi</td>
                                <td class="val-col">{{ $koleksi->created_at ? $koleksi->created_at->translatedFormat('d F Y') : '11 Maret 2026' }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">Jenis Benda</td>
                                <td class="val-col">{{ $koleksi->jenis_benda ?? ($koleksi->kategori ?? 'Arca') }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">Tahun Pembuatan</td>
                                <td class="val-col">{{ $koleksi->tahun_pembuatan ?? 'Abad ke-8' }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">Asal</td>
                                <td class="val-col leading-tight">{{ $koleksi->asal ?? 'Tombokrejo, Muncar, Banyuwangi' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- TABLE 2: INFORMASI UMUM / DIMENSI & BAHAN (CANVA DESIGN) -->
                <div>
                    <div class="table-bronze-header">
                        Informasi Umum
                    </div>

                    <div class="table-bronze-container">
                        <table>
                            <tr>
                                <td class="label-col">Tinggi</td>
                                <td class="val-col">{{ $koleksi->tinggi ?? ($koleksi->diameter() ?: '25,5 cm') }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">Lebar</td>
                                <td class="val-col">{{ $koleksi->lebar ?? ($koleksi->tebal() ?: '23 cm') }}</td>
                            </tr>
                            <tr>
                                <td class="label-col">Bahan</td>
                                <td class="val-col">{{ $koleksi->bahan() }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- QR CODE ETALASE CARD (CANVA DESIGN) -->
                <div class="flex justify-end pt-0.5">
                    <div class="bg-white rounded-2xl p-2.5 border-2 border-[#C4A265] shadow-xs flex items-center justify-center relative w-28 h-28">
                        <!-- Vector SVG QR Code -->
                        <img src="{{ $koleksi->qrCodeDataUri(180) }}"
                            alt="QR Code {{ $koleksi->nama_koleksi }}"
                            class="w-full h-full object-contain">

                        <!-- Museum Emblem in the center of QR (Same as Canva) -->
                        <div class="absolute inset-0 m-auto w-7 h-7 rounded-full bg-[#162544] border-2 border-[#C9981C] flex items-center justify-center shadow-xs overflow-hidden pointer-events-none">
                            <img src="{{ asset('favicon.png') }}" alt="Logo" class="w-4 h-4 object-contain">
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</body>

</html>
