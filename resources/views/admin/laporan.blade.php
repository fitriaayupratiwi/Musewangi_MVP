<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin DineQR | Laporan Transaksi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ 'darkMode': false, 'sidebarToggle': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }" class=" relative min-w-screen">

    @include('admin.body.sidebar')
    <!-- OVERLAY (klik → tutup sidebar) -->
  <div
    x-show="sidebarToggle"
    @click="sidebarToggle = false"
    class="fixed inset-0 z-40 bg-black/50 lg:hidden"
    x-transition.opacity
  ></div>
    @include('admin.body.header')

    <main class="pt-16 transition-all duration-300 p-6
    dark:bg-gray-900
    lg:ml-64 z-10">
        <h1 class="text-center mb-4 font-bold dark:text-white">Laporan Transaksi</h1>
        <h3 class="mb-5 dark:text-white">Gunakan filter untuk melihat laporan transaksi berdasarkan rentang tanggal</h3>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="col-lg-12">

                            <form id="myForm" action="{{ route('admin.search.bydate') }}" method="post"
                                enctype="multipart/form-data" class="flex items-center gap-4">
                                @csrf

                                <!-- Tanggal Mulai -->
                                <div>
                                    <label for="tanggal_mulai" class="block mb-1 font-medium dark:text-white">Tanggal Mulai</label>
                                    <input class="form-control" type="date" name="tanggal_awal"
                                        id="example-text-input">
                                </div>

                                <!-- Tanggal Akhir -->
                                <div>
                                    <label for="tanggal_akhir" class="block mb-1 font-medium dark:text-white">Tanggal Akhir</label>
                                    <input class="form-control" type="date" name="tanggal_akhir"
                                        id="example-text-input">
                                </div>

                                <!-- Tombol Filter -->
                                <div class="pt-6">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                                        <i class="fa-solid fa-filter"></i>
                                        <span class="ml-2">Filter</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
</body>

</html>