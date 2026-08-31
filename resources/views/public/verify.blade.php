<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Memverifikasi QR Code — MUSEWANGI</title>

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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Vite Compiled Assets (Tailwind & Alpine) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #162544;
            color: #ffffff;
            -webkit-font-smoothing: antialiased;
        }

        /* Checkmark Scale Animation */
        @keyframes popCheckmark {
            0% { transform: scale(0.4); opacity: 0; }
            70% { transform: scale(1.15); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }

        .check-pop {
            animation: popCheckmark 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        /* Progress Fill Animation */
        @keyframes fillProgress {
            0% { width: 0%; }
            100% { width: 100%; }
        }

        .progress-bar-fill {
            animation: fillProgress 1.3s ease-out forwards;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col justify-between items-center p-6 text-center bg-[#162544] select-none">

    <!-- TOP BRANDING -->
    <div class="pt-6 opacity-60">
        <span class="text-xs font-bold tracking-widest text-[#FFD86B] uppercase">MUSEWANGI</span>
    </div>

    <!-- MAIN VERIFICATION STATUS (Screen 4 Figma) -->
    <div class="w-full max-w-xs space-y-6 flex flex-col items-center">

        <!-- Animated Green Checkmark Badge -->
        <div class="check-pop w-24 h-24 rounded-full bg-emerald-500 flex items-center justify-center shadow-2xl shadow-emerald-500/40 border-4 border-emerald-300/40">
            <i class="fa-solid fa-check text-4xl text-white"></i>
        </div>

        <!-- Verification Title -->
        <div class="space-y-2">
            <h1 class="text-xl font-extrabold text-white tracking-wide">
                QR Code Berhasil di Pindai
            </h1>
            <p class="text-xs text-gray-300">
                Artefak: <span class="font-bold text-[#FFD86B]">{{ $collection->nama_koleksi }}</span>
            </p>
        </div>

        <!-- Animated Progress Bar -->
        <div class="w-48 pt-4 space-y-2">
            <div class="w-full h-1.5 bg-white/10 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-[#C9981C] to-[#FFD86B] rounded-full progress-bar-fill"></div>
            </div>
            <p class="text-[11px] text-gray-400 font-medium tracking-wide">
                Memuat informasi koleksi...
            </p>
        </div>

    </div>

    <!-- FOOTER / IMMEDIATE LINK -->
    <div class="pb-6">
        <a
            href="{{ route('public.koleksi.show', $collection->kode_unik) }}"
            class="text-[11px] text-gray-400 hover:text-white underline transition">
            Klik jika tidak berpindah otomatis
        </a>
    </div>

    <!-- AUTO REDIRECT SCRIPT -->
    <script>
        setTimeout(function () {
            window.location.href = "{{ route('public.koleksi.show', $collection->kode_unik) }}";
        }, 1300);
    </script>

</body>

</html>
