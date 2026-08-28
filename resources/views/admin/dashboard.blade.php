<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin MUSEWANGI | Dashboard</title>

    <!-- Favicon HD Multi-Resolution -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=5">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=5">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=5">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=5">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Tailwind CSS & Vite -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body x-data="{ sidebarToggle: false, darkMode: false }" class="bg-[#F8F5ED]">

    @include('admin.body.sidebar')

    {{-- OVERLAY --}}
    <div x-show="sidebarToggle" @click="sidebarToggle = false"
        class="fixed inset-0 bg-black/50 z-40 lg:hidden" x-cloak></div>

    @include('admin.body.header')

    <main class="pt-24 lg:ml-64 p-5">
        <div class="max-w-7xl mx-auto">

            {{-- TITLE --}}
            <div class="mb-5">
                <h1 class="text-3xl font-bold text-[#162544]">
                    Dashboard
                </h1>
                <p class="text-gray-500 mt-2">
                    Selamat datang di Inventaris Museum Blambangan Banyuwangi
                </p>
            </div>

            {{-- HERO CARD --}}
            <div class="relative overflow-hidden rounded-2xl bg-[#162544] h-[150px] shadow-lg px-6 py-5">
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-[#C9981C]">
                        MUSEWANGI
                    </h2>
                    <h3 class="text-sm font-semibold text-white mt-2">
                        Sistem Informasi Koleksi Museum Blambangan Banyuwangi
                        <br>
                        Berbasis QR Code
                    </h3>
                    <p class="text-xs text-gray-300 mt-4 max-w-md">
                        Kelola, lestarikan, dan sebarkan warisan budaya Banyuwangi secara digital.
                    </p>
                </div>

                <img src="{{ asset('src/images/gapura1.png') }}" alt="Gapura"
                    class="absolute right-5 bottom-0 h-40 object-contain">
            </div>

            {{-- STATISTIK (3 KARTU ASLI) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

                {{-- KOLEKSI --}}
                <div class="bg-white rounded-2xl shadow-md px-5 py-4 border border-[#E8DCC0]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#162544] flex items-center justify-center">
                            <i class="fa-solid fa-landmark text-xl text-white"></i>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-500">
                                Total Koleksi
                            </p>
                            <h2 class="text-3xl font-bold text-[#162544]">
                                {{ number_format($totalKoleksi ?? 0) }}
                            </h2>
                            <p class="text-[10px] text-gray-400">
                                Semua koleksi terdaftar
                            </p>
                        </div>
                    </div>
                </div>

                {{-- KATEGORI --}}
                <div class="bg-white rounded-2xl shadow-md px-5 py-4 border border-[#E8DCC0]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#C9981C] flex items-center justify-center">
                            <i class="fa-solid fa-chart-column text-xl text-white"></i>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-500">
                                Total Kategori
                            </p>
                            <h2 class="text-3xl font-bold text-[#162544]">
                                {{ number_format($totalKategori ?? 0) }}
                            </h2>
                            <p class="text-[10px] text-gray-400">
                                Kategori koleksi
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ULASAN --}}
                <div class="bg-white rounded-2xl shadow-md px-5 py-4 border border-[#E8DCC0]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#162544] flex items-center justify-center">
                            <i class="fa-solid fa-comments text-xl text-white"></i>
                        </div>
                        <div>
                            <p class="text-[11px] text-gray-500">
                                Total Ulasan
                            </p>
                            <h2 class="text-3xl font-bold text-[#162544]">
                                {{ number_format($totalUlasan ?? 0) }}
                            </h2>
                            <p class="text-[10px] text-gray-400">
                                Catatan Ulasan Pengunjung
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- AKTIVITAS --}}
            <div class="bg-white rounded-2xl shadow-md border border-[#E8DCC0] mt-6 overflow-hidden">
                <div class="flex justify-between items-center px-5 py-4">
                    <h2 class="text-sm font-bold text-[#162544]">
                        Aktivitas Terakhir
                    </h2>
                    <a href="{{ route('admin.riwayat') }}"
                        class="bg-[#C9981C] text-white text-[11px] px-4 py-2 rounded-lg hover:bg-[#A77C14] transition">
                        Lihat Semua Aktivitas
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead class="bg-[#E9DEC7] text-[#162544]">
                            <tr>
                                <th class="px-4 py-3 text-left">Tanggal</th>
                                <th class="px-4 py-3 text-left">Aktivitas</th>
                                <th class="px-4 py-3 text-left">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($aktivitas) && $aktivitas->count())
                                @foreach($aktivitas as $item)
                                    <tr class="border-b hover:bg-[#faf7ef]">
                                        <td class="px-4 py-3">
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3 font-medium text-[#162544]">
                                            {{ $item->aktivitas }}
                                        </td>
                                        <td class="px-4 py-3 text-blue-700">
                                            {{ $item->objek }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center py-8 text-gray-400">
                                        Belum ada aktivitas
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>

</body>

</html>