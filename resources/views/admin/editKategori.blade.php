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
    <title>Admin MUSEWANGI | Edit Kategori</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .page-bg { background: #F8F5ED; min-height: 100vh; }
    </style>
</head>

<body x-data="{ sidebarToggle: false, darkMode: false }" class="relative min-w-screen page-bg">
    @include('admin.body.sidebar')

    <div x-show="sidebarToggle" @click="sidebarToggle = false"
        class="fixed inset-0 z-40 bg-black/50 lg:hidden" x-cloak></div>

    @include('admin.body.header')

    <main class="pt-24 lg:ml-64 p-5">
        <div class="max-w-xl mx-auto">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-xs text-gray-500 mb-6">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#C9981C] transition flex items-center gap-1">
                    <i class="fa-solid fa-house text-[10px]"></i> Dashboard
                </a>
                <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
                <a href="{{ route('admin.kategori.index') }}" class="hover:text-[#C9981C] transition">Kategori</a>
                <i class="fa-solid fa-chevron-right text-[9px] text-gray-400"></i>
                <span class="text-[#162544] font-bold">Edit</span>
            </nav>

            <div class="bg-white rounded-2xl border border-[#EDD9A3] shadow-md overflow-hidden">
                {{-- Card Header --}}
                <div class="bg-gradient-to-r from-[#162544] to-[#253256] px-6 py-5 text-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center border border-white/20 text-[#FFD86B]">
                            <i class="fa-solid fa-pen text-sm"></i>
                        </div>
                        <div>
                            <h1 class="text-base font-bold text-white">Edit Kategori Koleksi</h1>
                            <p class="text-xs text-blue-200">Perbarui nama kategori "{{ $kategori->nama }}"</p>
                        </div>
                    </div>
                </div>

                {{-- Form --}}
                <form action="{{ route('admin.update.kategori', $kategori->id) }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nama" class="block text-xs font-bold text-[#162544] mb-1.5">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama" name="nama"
                            value="{{ old('nama', $kategori->nama) }}"
                            required
                            placeholder="Contoh: Arkeologi, Etnografi, Keramik"
                            class="w-full rounded-xl border border-[#DDD0A8] bg-[#FFFBF0] px-4 py-2.5 text-sm text-[#162544] outline-none focus:border-[#C9981C] focus:bg-white focus:ring-2 focus:ring-[#C9981C]/20 transition font-medium">

                        @error('nama')
                            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#EDD9A3]">
                        <a href="{{ route('admin.kategori.index') }}"
                            class="px-5 py-2.5 rounded-xl border border-[#D4C9A8] text-xs font-bold text-gray-600 hover:bg-[#F8F5ED] transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-xl bg-[#162544] text-white hover:bg-[#0F1A30] text-xs font-bold shadow-md transition flex items-center gap-2">
                            <i class="fa-solid fa-check text-xs"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>