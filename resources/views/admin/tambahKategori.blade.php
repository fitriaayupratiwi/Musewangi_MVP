<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Favicon HD Multi-Resolution -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=5">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=5">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=5">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=5">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Admin Musewangi | Tambah Kategori</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .page-bg { background: linear-gradient(135deg, #F5EFE3 0%, #EDE3CF 40%, #F0E8D5 100%); min-height: 100vh; }
    </style>
</head>

<body x-data="{ 'darkMode': false, 'sidebarToggle': false }"
    x-init="darkMode = JSON.parse(localStorage.getItem('darkMode') || 'false');
    $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{ 'dark bg-gray-900': darkMode === true }"
    class="relative min-w-screen page-bg">

    @include('admin.body.sidebar')
    <div x-show="sidebarToggle" @click="sidebarToggle = false"
        class="fixed inset-0 z-40 bg-black/50 lg:hidden" x-transition.opacity></div>
    @include('admin.body.header')

    <main class="pt-16 transition-all duration-300 p-5 lg:ml-64 z-10">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-[#7A6F5C] mb-6">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[#B78921] transition flex items-center gap-1">
                <i class="fa-solid fa-house text-xs"></i> Dashboard
            </a>
            <i class="fa-solid fa-chevron-right text-xs text-[#B0A080]"></i>
            <a href="{{ route('admin.kategori.index') }}" class="hover:text-[#B78921] transition">Kategori</a>
            <i class="fa-solid fa-chevron-right text-xs text-[#B0A080]"></i>
            <span class="text-[#1D2745] font-semibold">Tambah</span>
        </nav>

        <div class="max-w-lg mx-auto">
            <div class="bg-white rounded-2xl border border-[#EDD9A3] shadow-[0_8px_32px_rgba(183,137,33,0.12)] overflow-hidden">

                {{-- Card Header --}}
                <div class="bg-gradient-to-r from-[#1D2745] to-[#253256] px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#B78921] to-[#E8B84B] flex items-center justify-center">
                            <i class="fa-solid fa-plus text-white text-sm"></i>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-white">Tambah Kategori</h1>
                            <p class="text-xs text-blue-200">Buat kelompok koleksi baru</p>
                        </div>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="px-8 py-7">
                    <form id="tambahForm" action="{{ route('admin.store.kategori') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="nama" class="block text-sm font-semibold text-[#1D2745] mb-2">
                                Nama Kategori <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="nama" name="nama"
                                value="{{ old('nama') }}"
                                placeholder="Contoh: Prasejarah, Senjata Tradisional..."
                                class="w-full rounded-xl border-2 border-[#DDD0A8] bg-[#FFFBF0] px-4 py-3 text-sm text-[#202020] outline-none transition focus:border-[#B78921] focus:ring-3 focus:ring-[#B78921]/15 placeholder:text-[#B0A080] font-['Plus_Jakarta_Sans']"
                                required>
                            @error('nama')
                                <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between gap-3 pt-4 border-t border-[#F0E4C2]">
                            <a href="{{ route('admin.kategori.index') }}"
                                class="flex items-center gap-2 rounded-xl border-2 border-[#DDD0A8] bg-white px-5 py-2.5 text-sm font-semibold text-[#555] hover:border-[#B78921] hover:text-[#1D2745] transition">
                                <i class="fa-solid fa-arrow-left text-xs"></i> Kembali
                            </a>
                            <button type="submit"
                                class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#B78921] to-[#D4A82A] px-6 py-2.5 text-sm font-bold text-white shadow-md shadow-yellow-400/30 hover:from-[#9A7219] hover:to-[#B78921] transition">
                                <i class="fa-regular fa-floppy-disk"></i> Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </main>
</body>

</html>