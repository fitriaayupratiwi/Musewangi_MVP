<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Tidak Ditemukan — MUSEWANGI</title>

    <!-- Favicon HD Multi-Resolution -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=5">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=5">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=5">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=5">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Vite Compiled Assets (Tailwind & Alpine) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8F5ED;
            color: #162544;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col justify-between">

    <header class="bg-[#162544] text-white shadow-md border-b border-[#C9981C]/30 py-3 px-4">
        <div class="max-w-md mx-auto flex items-center justify-center gap-2">
            <div class="w-8 h-8 rounded-full overflow-hidden border border-[#C9981C]">
                <img src="{{ asset('src/images/logo-museum.jpeg') }}" alt="Logo" class="w-full h-full object-cover">
            </div>
            <span class="font-bold text-sm text-[#FFD86B] tracking-wider uppercase">MUSEWANGI</span>
        </div>
    </header>

    <main class="max-w-md mx-auto px-6 py-12 text-center flex-1 flex flex-col justify-center items-center">
        <div class="w-20 h-20 rounded-full bg-[#C9981C]/15 border-2 border-[#C9981C] flex items-center justify-center mb-6 text-[#C9981C]">
            <i class="fa-solid fa-qrcode text-3xl"></i>
        </div>

        <h1 class="text-2xl font-bold text-[#162544] mb-2">Koleksi Tidak Ditemukan</h1>
        <p class="text-xs text-gray-500 max-w-xs leading-relaxed mb-6">
            QR Code yang Anda pindai mungkin sudah tidak aktif, telah dihapus, atau kode tidak valid.
        </p>

        <div class="p-4 rounded-xl bg-white border border-[#E8DCC0] w-full text-left text-xs mb-6 space-y-1">
            <span class="text-gray-400 font-semibold block uppercase tracking-wider text-[10px]">Kode Pindai:</span>
            <span class="font-mono text-gray-700 break-all">{{ $kode ?? '-' }}</span>
        </div>

        <p class="text-xs text-gray-400">
            Silakan hubungi petugas museum untuk informasi lebih lanjut mengenai artefak ini.
        </p>
    </main>

    <footer class="bg-[#162544] text-white/75 text-center text-xs py-4 px-4 border-t border-[#C9981C]/30">
        <p class="text-[10px] text-gray-400">&copy; {{ date('Y') }} Museum Blambangan Banyuwangi</p>
    </footer>

</body>

</html>
