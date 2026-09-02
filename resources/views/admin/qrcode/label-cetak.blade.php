<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Label Etalase Museum — {{ $koleksi->nama_koleksi }}</title>

    <!-- =========================================================
         FAVICON
    ========================================================== -->

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=5">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=5">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=5">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=5">


    <!-- =========================================================
         GOOGLE FONTS
    ========================================================== -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,600;0,700;0,800;0,900;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">


    <!-- =========================================================
         FONT AWESOME
    ========================================================== -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <!-- =========================================================
         VITE
    ========================================================== -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>
        /* =========================================================
           BODY
        ========================================================== */

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #EDE8DE;
            color: #1F1A14;
            -webkit-font-smoothing: antialiased;
        }


        /* =========================================================
           FONT
        ========================================================== */

        .font-serif-title {
            font-family: 'Cinzel', 'Playfair Display', Georgia, serif;
        }

        .font-serif-subtitle {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .font-serif-body {
            font-family: 'Lora', Georgia, 'Times New Roman', serif;
        }


        /* =========================================================
           MUSEUM PLACARD
           A5 LANDSCAPE
           210mm × 148mm
        ========================================================== */

        .museum-placard {

            width: 210mm;
            min-height: 148mm;

            background: #FCFAF5;

            position: relative;

            box-sizing: border-box;

            border-radius: 8px;

            box-shadow:
                0 15px 40px rgba(35, 25, 15, 0.15);

            overflow: hidden;

            border: 1px solid #E2D1B3;
        }


        /* =========================================================
           INNER GOLDEN FRAME
        ========================================================== */

        .placard-inner-frame {

            position: absolute;

            inset: 8px;

            border: 1.5px solid #D6B97E;

            border-radius: 6px;

            pointer-events: none;

            z-index: 1;
        }


        /* =========================================================
           GOLDEN CURVE DECORATION

           MENGGUNAKAN GAMBAR 1

           Bentuk:

           - satu garis emas
           - mulai dari bawah kiri
           - naik mengikuti sisi kiri
           - melengkung ke atas
           - memanjang ke kanan
           - tanpa garis pendamping
           - tanpa aksen tambahan
        ========================================================== */

        .gajah-oling-frame {

            position: absolute;

            left: 0;
            top: 0;

            width: 100%;
            height: 100%;

            pointer-events: none;

            z-index: 2;

            overflow: hidden;
        }


        .gajah-oling-frame img {

            position: absolute;

            left: 0;
            top: 0;

            height: 100%;

            width: auto;

            max-width: none;

            display: block;

            object-fit: contain;
        }


        /* =========================================================
           TABLE HEADER
        ========================================================== */

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


        /* =========================================================
           TABLE CONTAINER
        ========================================================== */

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


        /* =========================================================
           TABLE CELL
        ========================================================== */

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


        /* =========================================================
           TABLE LABEL
        ========================================================== */

        .table-bronze-container td.label-col {

            font-weight: 700;

            width: 46%;

            background: #FFFFFF;
        }


        /* =========================================================
           TABLE VALUE
        ========================================================== */

        .table-bronze-container td.val-col {

            text-align: center;

            background: #FFFFFF;
        }


        /* =========================================================
           PRINT
        ========================================================== */

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


            .gajah-oling-frame {

                display: block !important;
            }


            @page {

                size: A5 landscape;

                margin: 0;
            }
        }
    </style>

</head>


<body class="min-h-screen p-4 sm:p-8 flex flex-col items-center justify-start">


    <!-- =========================================================
         ACTION CONTROLS
    ========================================================== -->

    <div
        class="no-print w-full max-w-4xl mb-6 bg-white rounded-2xl p-4 shadow-sm border border-[#E8DCC0] flex flex-wrap items-center justify-between gap-4">


        <!-- LEFT -->

        <div class="flex items-center gap-3">

            <a href="{{ route('admin.qrcode.index') }}"
                class="w-10 h-10 rounded-xl bg-[#F8F5ED] hover:bg-[#E8DCC0] text-[#162544] flex items-center justify-center transition"
                title="Kembali ke Daftar QR Code">

                <i class="fa-solid fa-arrow-left text-sm"></i>

            </a>


            <div>

                <h1 class="text-sm font-extrabold text-[#162544]">
                    Label Etalase Pameran Museum
                </h1>

                <p class="text-xs text-gray-500">
                    Standar resmi etalase Museum Blambangan Banyuwangi
                    (Format A5 Landscape)
                </p>

            </div>

        </div>


        <!-- RIGHT BUTTONS -->

        <div class="flex items-center gap-2.5">


            <!-- CETAK -->

            <button type="button" onclick="window.print()"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#C9981C] hover:bg-[#B78921] text-white font-extrabold text-xs shadow-md transition transform active:scale-95">

                <i class="fa-solid fa-print text-sm"></i>

                <span>
                    Cetak Label (Print)
                </span>

            </button>


            <!-- PDF -->

            <button type="button" onclick="window.print()"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-[#162544] hover:bg-[#0E1830] text-white font-bold text-xs shadow transition">

                <i class="fa-solid fa-file-pdf text-sm text-[#FFD86B]"></i>

                <span>
                    Simpan PDF
                </span>

            </button>

        </div>

    </div>



    <!-- =========================================================
         PLACARD WRAPPER
    ========================================================== -->

    <div class="print-wrapper flex justify-center w-full">


        <!-- =====================================================
             MUSEUM PLACARD
        ====================================================== -->

        <div class="museum-placard p-7 flex gap-5 relative">


            <!-- =================================================
                 INNER FRAME
            ================================================== -->

            <div class="placard-inner-frame"></div>

            <div class="gajah-oling-frame">

                <img src="{{ asset('src/images/garis lengkung.jpeg') }}" alt="" aria-hidden="true">

            </div>



            <!-- =================================================
                 ORNAMEN BATIK GAJAH OLING
            ================================================== -->

            <div class="absolute left-3 bottom-2 w-32 h-48 pointer-events-none z-10">

                <img src="{{ asset('src/images/Batik Barcode.png') }}" alt="Motif Batik Gajah Oling"
                    class="w-full h-full object-contain">

            </div>



            <!-- =================================================
                 LEFT COLUMN
            ================================================== -->

            <div class="flex-1 min-w-0 pl-14 pt-10 z-10 flex flex-col justify-between">


                <div>


                    <!-- SUBTITLE -->

                    <h3
                        class="font-serif-subtitle text-[#A66E1E] text-base sm:text-[17px] font-bold tracking-wide leading-tight mb-1">

                        {{ $koleksi->jenis_benda ?? ($koleksi->kategori ?? 'Patung Arca') }}

                    </h3>



                    <!-- TITLE -->

                    <h2
                        class="font-serif-title text-[#1E1308] text-2xl sm:text-[28px] font-black tracking-tight leading-tight mb-2">

                        {{ $koleksi->nama_koleksi }}

                    </h2>



                    <!-- DIVIDER 1 -->

                    <div class="my-2 flex items-center justify-start gap-1">

                        <svg class="h-3.5 w-32 text-[#B8860B]" viewBox="0 0 120 16" fill="currentColor">

                            <path d="M 0 8 Q 25 8 45 7 Q 52 2 60 8 Q 52 14 45 9 Q 25 8 0 8 Z" opacity="0.8" />

                            <circle cx="60" cy="8" r="3.2" />

                            <circle cx="51" cy="8" r="1.6" />

                            <circle cx="69" cy="8" r="1.6" />

                            <path d="M 120 8 Q 95 8 75 7 Q 68 2 60 8 Q 68 14 75 9 Q 95 8 120 8 Z" opacity="0.8" />

                        </svg>

                    </div>



                    <!-- NARASI INDONESIA -->

                    <div
                        class="font-serif-body text-[10.5px] sm:text-[11.2px] text-[#1F1A14] leading-relaxed text-justify space-y-1 font-normal">

                        <p>

                            {{ $koleksi->deskripsi ?? 'Arca Jaladwara merupakan pancuran air yang digunakan di candi-candi atau pemandian kuno untuk menyalurkan air. Arca ini digambarkan dalam posisi duduk dengan bagian kepala dan tangan kanan hilang. Arca ini menggunakan selendang yang dikenakan dari kiri melintang ke pinggang kanan (Upawita), dan tangan kanan yang menggunakan gelang bertumpu pada kaki kiri.' }}

                        </p>

                    </div>



                    <!-- DIVIDER 2 -->

                    <div class="my-2.5 flex items-center justify-start gap-1">

                        <svg class="h-3.5 w-32 text-[#B8860B]" viewBox="0 0 120 16" fill="currentColor">

                            <path d="M 0 8 Q 25 8 45 7 Q 52 2 60 8 Q 52 14 45 9 Q 25 8 0 8 Z" opacity="0.8" />

                            <circle cx="60" cy="8" r="3.2" />

                            <circle cx="51" cy="8" r="1.6" />

                            <circle cx="69" cy="8" r="1.6" />

                            <path d="M 120 8 Q 95 8 75 7 Q 68 2 60 8 Q 68 14 75 9 Q 95 8 120 8 Z" opacity="0.8" />

                        </svg>

                    </div>



                    <!-- NARASI INGGRIS -->

                    <div
                        class="font-serif-body text-[10px] sm:text-[10.5px] text-[#1F1A14] leading-relaxed text-justify space-y-1 font-normal">

                        <p>

                            {{ $koleksi->deskripsiEn() }}

                        </p>

                    </div>

                </div>

            </div>



            <!-- =================================================
                 RIGHT COLUMN
            ================================================== -->

            <div class="w-[76mm] flex-shrink-0 z-10 flex flex-col justify-between space-y-3">


                <!-- =================================================
                     TABLE 1
                ================================================== -->

                <div>

                    <div class="table-bronze-header">

                        Informasi Umum

                    </div>


                    <div class="table-bronze-container">

                        <table>

                            <tr>

                                <td class="label-col">
                                    No. Registrasi Baru
                                </td>

                                <td class="val-col font-mono">
                                    {{ $koleksi->no_registrasi }}
                                </td>

                            </tr>


                            <tr>

                                <td class="label-col">
                                    No. Registrasi Lama
                                </td>

                                <td class="val-col font-mono">
                                    {{ $koleksi->no_registrasi_lama ?? '080/ BWI/ 2024' }}
                                </td>

                            </tr>


                            <tr>

                                <td class="label-col">
                                    Tanggal Registrasi
                                </td>

                                <td class="val-col">

                                    {{ $koleksi->created_at ? $koleksi->created_at->translatedFormat('d F Y') : '11 Maret 2026' }}

                                </td>

                            </tr>


                            <tr>

                                <td class="label-col">
                                    Jenis Benda
                                </td>

                                <td class="val-col">

                                    {{ $koleksi->jenis_benda ?? ($koleksi->kategori ?? 'Arca') }}

                                </td>

                            </tr>


                            <tr>

                                <td class="label-col">
                                    Tahun Pembuatan
                                </td>

                                <td class="val-col">

                                    {{ $koleksi->tahun_pembuatan ?? 'Abad ke-8' }}

                                </td>

                            </tr>


                            <tr>

                                <td class="label-col">
                                    Asal
                                </td>

                                <td class="val-col leading-tight">

                                    {{ $koleksi->asal ?? 'Tombokrejo, Muncar, Banyuwangi' }}

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>



                <!-- =================================================
                     TABLE 2
                ================================================== -->

                <div>

                    <div class="table-bronze-header">

                        Informasi Umum

                    </div>


                    <div class="table-bronze-container">

                        <table>

                            <tr>

                                <td class="label-col">
                                    Tinggi
                                </td>

                                <td class="val-col">

                                    {{ $koleksi->tinggi ?? ($koleksi->diameter() ?: '25,5 cm') }}

                                </td>

                            </tr>


                            <tr>

                                <td class="label-col">
                                    Lebar
                                </td>

                                <td class="val-col">

                                    {{ $koleksi->lebar ?? ($koleksi->tebal() ?: '23 cm') }}

                                </td>

                            </tr>


                            <tr>

                                <td class="label-col">
                                    Bahan
                                </td>

                                <td class="val-col">

                                    {{ $koleksi->bahan() }}

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>



                <!-- =================================================
                     QR CODE
                ================================================== -->

                <div class="flex justify-end pt-0.5">

                    <div
                        class="bg-white rounded-2xl p-2.5 border-2 border-[#C4A265] shadow-xs flex items-center justify-center relative w-28 h-28">


                        <!-- QR -->

                        <img src="{{ $koleksi->qrCodeDataUri(180) }}" alt="QR Code {{ $koleksi->nama_koleksi }}"
                            class="w-full h-full object-contain">


                        <!-- LOGO MUSEUM -->

                        <div
                            class="absolute inset-0 m-auto w-7 h-7 rounded-full bg-[#162544] border-2 border-[#C9981C] flex items-center justify-center shadow-xs overflow-hidden pointer-events-none">

                            <img src="{{ asset('favicon.png') }}" alt="Logo" class="w-4 h-4 object-contain">

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
