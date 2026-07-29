<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DineQR | Dashboard Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body x-data="{ darkMode: false, sidebarToggle: false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode')) ?? false;
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{
        'dark bg-gray-900': darkMode,
        'bg-gray-100': !darkMode
    }"
    class=" relative min-w-screen">

    @include('admin.body.sidebar')
    <!-- OVERLAY (klik → tutup sidebar) -->
    <div x-show="sidebarToggle" @click="sidebarToggle = false" class="fixed inset-0 z-40 bg-black/50 lg:hidden"
        x-transition.opacity></div>
    @include('admin.body.header')

    <main class="pt-16 min-h-screen transition-all duration-300
    dark:bg-gray-900
    lg:ml-64 z-10">

        <div class="relative overflow-hidden rounded-3xl bg-[#152544] p-8 text-white shadow-xl">
            <div class="grid md:grid-cols-2 items-center gap-6">

                <div>
                    <h1 class="text-4xl font-bold text-yellow-400">
                        MUSEWANGI
                    </h1>

                    <h3 class="mt-3 text-xl font-semibold">
                        Sistem Informasi Koleksi Museum Blambangan Banyuwangi
                        Berbasis QR Code
                    </h3>

                    <p class="mt-6 text-lg text-gray-200">
                        Kelola, lestarikan, dan sebarkan warisan budaya Banyuwangi
                        secara digital.
                    </p>
                </div>

                <div class="flex justify-end">
                    <img src="{{ asset('src/images/gapura1.png') }}" class="h-52 object-contain">
                </div>

            </div>

        </div>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">

            <!-- Total Koleksi -->
            <div class="bg-white rounded-3xl shadow-lg p-6">

                <div class="flex items-center gap-5">

                    <div class="w-20 h-20 rounded-full bg-[#152544] flex items-center justify-center">

                        {{-- <i class="fa-solid fa-box text-4xl text-white"></i> --}}
                        <i class="fa-solid fa-landmark text-4xl text-white"></i>
                        {{-- <i class="fa-solid fa-box-archive text-4xl text-white"></i> --}}

                    </div>

                    <div>



                        <p class="text-xl font-bold text-[#152544]">
                            Total Koleksi
                        </p>

                        <h2 class="text-5xl font-bold text-[#152544]">
                            {{-- {{ number_format($totalKoleksi) }} --}}
                        </h2>

                        <small class="text-black-400">
                            Semua koleksi terdaftar
                        </small>

                    </div>

                </div>

            </div>

            <!-- Total Kategori -->
            <div class="bg-white rounded-3xl shadow-lg p-6">

                <div class="flex items-center gap-5">

                    <div class="w-20 h-20 rounded-full bg-yellow-500 flex items-center justify-center">

                        {{-- <i class="fa-solid fa-layer-group text-4xl text-white"></i> --}}
                        {{-- <i class="fa-solid fa-shapes text-4xl text-white"></i> --}}
                        <i class="fa-solid fa-chart-column text-4xl text-white"></i>


                    </div>

                    <div>

                        <p class="text-xl font-bold text-[#152544]">
                            Total Kategori
                        </p>



                        <h2 class="text-5xl font-bold text-[#152544]">
                            {{-- {{ number_format($totalKategori) }} --}}
                        </h2>

                        <small class="text-black-400">
                            Kategori koleksi
                        </small>

                    </div>

                </div>

            </div>

            <!-- Total Ulasan -->
            <div class="bg-white rounded-3xl shadow-lg p-6">

                <div class="flex items-center gap-5">

                    <div class="w-20 h-20 rounded-full bg-[#152544] flex items-center justify-center">

                        {{-- <i class="fa-solid fa-comments text-4xl text-white"></i> --}}
                        {{-- <i class="fa-solid fa-download text-4xl text-white"></i> --}}
                        <i class="fa-solid fa-comments text-4xl text-white"></i>

                    </div>

                    <div>

                        <p class="text-xl font-bold text-[#152544]">
                            Total Ulasan
                        </p>

                        <h2 class="text-5xl font-bold text-[#152544]">
                            {{-- {{ number_format($totalUlasan) }} --}}
                        </h2>

                        <small class="text-black-400">
                            Catatan Ulasan Pengunjung
                        </small>

                    </div>

                </div>

            </div>

        </div>

        <div class="bg-white rounded-3xl shadow-xl mt-10">

            <div class="flex justify-between items-center p-6">

                <h2 class="text-2xl font-bold text-[#152544]">
                    Aktivitas Terakhir
                </h2>

                <a href="#" class="bg-yellow-600 hover:bg-yellow-700 text-white px-5 py-2 rounded-xl">
                    Lihat Semua Aktivitas
                </a>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full">


                    <thead class="bg-[#B07B4C] text-white">

                        <tr>

                            <th class="text-left p-4">Tanggal</th>
                            <th class="text-left p-4">Aktivitas</th>
                            <th class="text-left p-4">Keterangan</th>

                        </tr>

                    </thead>

                    <tbody>

                        {{-- @foreach ($aktivitas as $item) --}}
                        <tr class="border-b hover:bg-yellow-50 transition duration-200">


                            <td class="p-4">
                                {{-- {{ $item->created_at->format('d M Y H:i') }} --}}
                            </td>

                            <td class="p-4">
                                {{-- {{ $item->aktivitas }} --}}
                            </td>

                            <td class="p-4 text-blue-700">
                                {{-- {{ $item->keterangan }} --}}
                            </td>

                        </tr>
                        {{-- @endforeach --}}

                    </tbody>

                </table>

            </div>

        </div>
        </div>
    </main>


    <!-- end row -->
</body>

</html>
