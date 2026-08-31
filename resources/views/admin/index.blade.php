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
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Admin MUSEWANGI | Kelola Pengguna</title>

    <!-- Vite Compiled Assets (Tailwind & Alpine) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F8F5ED;
        }

        .page-bg {
            background: #F8F5ED;
            min-height: 100vh;
        }

        /* ── Stat cards (Identik dengan Kategori) ── */
        .stat-card {
            background: linear-gradient(135deg, #1D2745 0%, #253256 100%);
            border-radius: 20px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 120px; height: 120px;
            border-radius: 50%;
            background: rgba(199,152,28,0.15);
        }
        .stat-card::after {
            content: '';
            position: absolute;
            bottom: -30px; left: -30px;
            width: 90px; height: 90px;
            border-radius: 50%;
            background: rgba(199,152,28,0.08);
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(29,39,69,0.25);
        }

        /* ── Search bar ── */
        .search-wrapper {
            position: relative;
        }
        .search-wrapper input:focus {
            box-shadow: 0 0 0 3px rgba(183,137,33,0.2);
        }

        /* ── Section header strip ── */
        .section-header {
            background: white;
            border-radius: 18px;
            border: 1.5px solid #EDD9A3;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 20px;
        }

        #searchInput {
            background: white;
            border: 1.5px solid #DDD0A8;
            border-radius: 12px;
            padding: 10px 14px 10px 42px;
            font-size: 14px;
            color: #333;
            width: 100%;
            transition: all 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        #searchInput:focus {
            outline: none;
            border-color: #B78921;
            box-shadow: 0 0 0 3px rgba(183,137,33,0.15);
        }

        /* ── Action buttons (Identik dengan Kategori) ── */
        .btn-edit {
            width: 34px; height: 34px;
            border-radius: 10px;
            background: #F0F4FF;
            color: #3B5BDB;
            border: 1.5px solid #C5D0F7;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
            cursor: pointer;
        }
        .btn-edit:hover {
            background: #3B5BDB; color: white;
            border-color: #3B5BDB;
            transform: scale(1.1);
        }
        .btn-delete {
            width: 34px; height: 34px;
            border-radius: 10px;
            background: #FFF0F0;
            color: #E03131;
            border: 1.5px solid #FFCACA;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
            cursor: pointer;
        }
        .btn-delete:hover {
            background: #E03131; color: white;
            border-color: #E03131;
            transform: scale(1.1);
        }

        /* ── Add button ── */
        .btn-add {
            background: linear-gradient(135deg, #B78921, #D4A82A);
            color: white;
            border-radius: 12px;
            padding: 10px 22px;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.3px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s;
            box-shadow: 0 4px 14px rgba(183,137,33,0.4);
        }
        .btn-add:hover {
            background: linear-gradient(135deg, #9A7219, #B78921);
            box-shadow: 0 6px 20px rgba(183,137,33,0.5);
            transform: translateY(-1px);
        }

        /* ── Modal (Identik dengan Kategori) ── */
        .modal-overlay {
            backdrop-filter: blur(4px);
        }
        .modal-card {
            background: linear-gradient(160deg, #FFFDF7 0%, #FFF8E8 100%);
            border-radius: 24px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.2);
            border: 1px solid rgba(199,152,28,0.2);
        }
        .modal-input {
            width: 100%;
            border-radius: 12px;
            border: 1.5px solid #DDD0A8;
            background: #FFFBF0;
            padding: 10px 14px;
            font-size: 13px;
            color: #202020;
            outline: none;
            transition: all 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .modal-input:focus {
            border-color: #B78921;
            box-shadow: 0 0 0 3px rgba(183,137,33,0.15);
            background: #FFFFFF;
        }
        .modal-input::placeholder { color: #B0A080; }

        .btn-modal-save {
            background: linear-gradient(135deg, #1D2745, #253256);
            color: white;
            border: none;
            border-radius: 11px;
            padding: 10px 24px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-modal-save:hover {
            background: linear-gradient(135deg, #141D35, #1D2745);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(29,39,69,0.35);
        }
        .btn-modal-cancel {
            background: white;
            color: #444;
            border: 1.5px solid #D4C9A8;
            border-radius: 11px;
            padding: 10px 24px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-modal-cancel:hover {
            background: #F5EFE3;
            border-color: #B78921;
            color: #1D2745;
        }
    </style>
</head>

<body x-data="userPage()" x-init="init()" class="relative min-w-screen page-bg">

    @include('admin.body.sidebar')

    <div x-show="sidebarToggle" @click="sidebarToggle = false"
        class="fixed inset-0 z-40 bg-black/50 lg:hidden" x-cloak></div>

    @include('admin.body.header')

    <main class="pt-24 lg:ml-64 p-5">
        <div class="mx-auto max-w-6xl">

            {{-- 1. TITLE SECTION --}}
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-[#162544]">
                        Daftar Pengguna Sistem
                    </h1>
                    <p class="text-gray-500 mt-2">
                        Kelola semua akun administrator & petugas museum, tambah, ubah, atau hapus akses pengguna.
                    </p>
                </div>

                <button type="button" @click="openAddModal()" class="btn-add">
                    <i class="fa fa-plus"></i>
                    <span>Tambah Pengguna</span>
                </button>
            </div>

            {{-- 2. STATS ROW (3 KARTU RECTANGLE IDENTIK KATEGORI) --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <!-- Card 1: Total Pengguna (Navy) -->
                <div class="stat-card">
                    <p class="text-xs text-yellow-300 font-semibold uppercase tracking-widest mb-2">Total Pengguna</p>
                    <p class="text-4xl font-bold text-white">{{ $users->count() }}</p>
                    <p class="text-xs text-blue-200 mt-1">Akun terdaftar di sistem</p>
                    <div class="absolute right-5 top-5 opacity-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-yellow-300" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                    </div>
                </div>

                <!-- Card 2: Administrator Aktif (Gold/Brown) -->
                <div class="stat-card" style="background: linear-gradient(135deg, #7B5200 0%, #9A6800 100%);">
                    <p class="text-xs text-yellow-300 font-semibold uppercase tracking-widest mb-2">Administrator</p>
                    <p class="text-4xl font-bold text-white">{{ $users->where('role', 'admin')->count() }}</p>
                    <p class="text-xs text-yellow-100 mt-1">Akses kelola inventaris</p>
                    <div class="absolute right-5 top-5 opacity-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-yellow-200" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>

                <!-- Card 3: Keamanan & Status Sistem (Green) -->
                <div class="stat-card" style="background: linear-gradient(135deg, #1A5C3A 0%, #1F7045 100%);">
                    <p class="text-xs text-green-200 font-semibold uppercase tracking-widest mb-2">Status Sistem</p>
                    <p class="text-4xl font-bold text-white">Aktif</p>
                    <p class="text-xs text-green-100 mt-1">MUSEWANGI v1.0 MVP</p>
                    <div class="absolute right-5 top-5 opacity-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-green-200" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- 3. SECTION WITH SEARCH --}}
            <div class="section-header">
                <div class="flex items-center gap-3">
                    <h2 class="text-base font-bold text-[#1D2745]">Daftar Akun Pengguna</h2>
                    <span class="bg-[#F0E4C2] text-[#7B5200] text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $users->count() }} pengguna
                    </span>
                </div>
                <div class="search-wrapper relative w-full sm:w-64">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[#B0A080] pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <input id="searchInput" type="text" placeholder="Cari nama atau email..." oninput="filterUsers(this.value)">
                </div>
            </div>

            {{-- 4. TABLE CONTAINER (RECTANGLE BORDER & COLORS IDENTIK KATEGORI) --}}
            <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-[#EDD9A3]">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-[#E9DEC7] text-[#162544]">
                            <tr>
                                <th class="px-6 py-4 text-left font-bold text-xs uppercase">No</th>
                                <th class="px-6 py-4 text-left font-bold text-xs uppercase">Pengguna</th>
                                <th class="px-6 py-4 text-left font-bold text-xs uppercase">Username</th>
                                <th class="px-6 py-4 text-left font-bold text-xs uppercase">Email</th>
                                <th class="px-6 py-4 text-left font-bold text-xs uppercase">Role</th>
                                <th class="px-6 py-4 text-center font-bold text-xs uppercase">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#F0E4C2]">
                            @forelse($users as $user)
                                <tr class="user-row hover:bg-[#faf7ef] transition"
                                    data-name="{{ strtolower($user->name . ' ' . $user->username . ' ' . $user->email) }}">
                                    <!-- NO -->
                                    <td class="px-6 py-4 text-gray-500 font-semibold text-xs">
                                        {{ $loop->iteration }}
                                    </td>

                                    <!-- NAMA & AVATAR BOX -->
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-[#FFF3D1] to-[#FFE5A0] text-[#B78921] font-extrabold border border-[#EDD9A3] flex items-center justify-center text-sm shadow-xs shrink-0">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-[#162544] text-sm">
                                                    {{ $user->name }}
                                                </div>
                                                <div class="text-[11px] text-gray-400">
                                                    ID: #{{ $user->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- USERNAME -->
                                    <td class="px-6 py-4 text-gray-600 font-mono text-xs font-semibold">
                                        {{ $user->username }}
                                    </td>

                                    <!-- EMAIL -->
                                    <td class="px-6 py-4 text-gray-600 text-xs">
                                        {{ $user->email }}
                                    </td>

                                    <!-- ROLE BADGE -->
                                    <td class="px-6 py-4">
                                        @if(strtolower($user->role ?? '') === 'super admin')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-100 text-red-700 border border-red-200 text-xs font-semibold">
                                                <i class="fa-solid fa-crown text-[10px]"></i>
                                                Super Admin
                                            </span>
                                        @elseif(strtolower($user->role ?? '') === 'admin')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#FFF3D1] text-[#7B5200] border border-[#EDD9A3] text-xs font-semibold">
                                                <i class="fa-solid fa-shield-halved text-[10px]"></i>
                                                Administrator
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-200 text-xs font-semibold">
                                                <i class="fa-solid fa-user text-[10px]"></i>
                                                {{ ucfirst($user->role ?? 'Petugas') }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- AKSI (EDIT & DELETE IDENTIK KATEGORI) -->
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center items-center gap-2">
                                            <!-- EDIT -->
                                            <a href="{{ route('admin.edit.admin', $user->id) }}"
                                                class="btn-edit"
                                                title="Edit Pengguna">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="m13.58 3.58 2.84 2.84a1 1 0 0 1 0 1.42l-9 9a1 1 0 0 1-.44.26l-4 1a1 1 0 0 1-1.22-1.22l1-4a1 1 0 0 1 .26-.44l9-9a1 1 0 0 1 1.42 0l1.14 1.14Z" />
                                                </svg>
                                            </a>

                                            <!-- DELETE (Hanya jika bukan akun ID 1) -->
                                            @if($user->id !== 1)
                                                <button type="button" class="btn-delete"
                                                    title="Hapus Pengguna"
                                                    onclick="confirmDeleteUser('{{ route('admin.delete.admin', $user->id) }}', @js($user->name))">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M6 7h8l-.6 8.2A2 2 0 0 1 11.41 17H8.59a2 2 0 0 1-1.99-1.8L6 7Zm3-4h2a1 1 0 0 1 1 1v1h4v2H4V5h4V4a1 1 0 0 1 1-1Z" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-16 text-center text-gray-500">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-16 h-16 rounded-full bg-[#FFF3D1] border border-[#EDD9A3] flex items-center justify-center text-[#B78921] text-2xl">
                                                <i class="fa-solid fa-users"></i>
                                            </div>
                                            <p class="font-medium text-sm">Belum ada data administrator</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                            <tr id="noResultRow" class="hidden">
                                <td colspan="6" class="py-12 text-center text-gray-400">
                                    <i class="fa-solid fa-magnifying-glass text-2xl text-[#C9981C] mb-2"></i>
                                    <p class="text-sm font-semibold text-[#1D2745]">Pengguna tidak ditemukan</p>
                                    <p class="text-xs text-gray-400">Coba kata kunci pencarian yang lain</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- FOOTER INFO --}}
            <div class="mt-5 flex flex-col md:flex-row md:justify-between md:items-center gap-3">
                <div class="text-xs text-gray-500">
                    Total Administrator:
                    <span class="font-bold text-[#162544]">{{ $users->count() }}</span>
                </div>
                <div class="text-xs text-gray-400">
                    Sistem Informasi Koleksi Museum Banyuwangi (MUSEWANGI)
                </div>
            </div>

        </div>
    </main>

    {{-- ══════════════ MODAL TAMBAH PENGGUNA (IDENTIK KATEGORI) ══════════════ --}}
    <div x-cloak x-show="addOpen"
        class="fixed inset-0 z-[60] flex items-center justify-center p-4 modal-overlay"
        style="background: rgba(10,14,30,0.55);"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div class="modal-card w-full max-w-lg p-6 sm:p-8 space-y-5"
            @click.outside="addOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95">

            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-[#EDD9A3] pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#FFF3D1] to-[#FFE5A0] border border-[#EDD9A3] flex items-center justify-center text-[#B78921]">
                        <i class="fa-solid fa-user-plus text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#1D2745]">Tambah Pengguna Baru</h3>
                        <p class="text-xs text-[#8A7D6A]">Daftarkan administrator baru untuk MUSEWANGI</p>
                    </div>
                </div>
                <button type="button" @click="addOpen = false" class="text-gray-400 hover:text-gray-600 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.kelolaadmin.tambah') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xs font-bold text-[#1D2745] mb-1">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" required placeholder="Contoh: Budi Santoso"
                        class="modal-input">
                </div>

                <!-- Grid Username & Email -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-[#1D2745] mb-1">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" required placeholder="budi_admin"
                            class="modal-input">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1D2745] mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" required placeholder="budi@gmail.com"
                            class="modal-input">
                    </div>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-xs font-bold text-[#1D2745] mb-1">
                        Hak Akses / Role <span class="text-red-500">*</span>
                    </label>
                    <select name="role" required class="modal-input bg-[#FFFBF0]">
                        <option value="admin">Administrator (Akses Inventaris Penuh)</option>
                    </select>
                </div>

                <!-- Grid Password & Konfirmasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-[#1D2745] mb-1">
                            Kata Sandi <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password" required minlength="8" placeholder="Minimal 8 karakter"
                            class="modal-input">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#1D2745] mb-1">
                            Konfirmasi Sandi <span class="text-red-500">*</span>
                        </label>
                        <input type="password" name="password_confirmation" required minlength="8" placeholder="Ulangi sandi"
                            class="modal-input">
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="flex items-center justify-end gap-3 pt-3 border-t border-[#EDD9A3]">
                    <button type="button" @click="addOpen = false" class="btn-modal-cancel">
                        Batal
                    </button>
                    <button type="submit" class="btn-modal-save">
                        <i class="fa-solid fa-check mr-1.5"></i> Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Form Delete Tersembunyi untuk SweetAlert --}}
    <form id="deleteUserForm" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function userPage() {
            return {
                sidebarToggle: false,
                darkMode: false,
                addOpen: false,
                init() {
                    this.darkMode = JSON.parse(localStorage.getItem('darkMode') || 'false');
                },
                openAddModal() {
                    this.addOpen = true;
                }
            }
        }

        // Live Search Filter (Identik Kategori)
        function filterUsers(query) {
            const rows = document.querySelectorAll('.user-row');
            const noResult = document.getElementById('noResultRow');
            const q = query.toLowerCase().trim();
            let visible = 0;

            rows.forEach(row => {
                const name = row.dataset.name || '';
                if (!q || name.includes(q)) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (noResult) {
                noResult.classList.toggle('hidden', visible > 0 || q === '');
            }
        }

        // SweetAlert2 Konfirmasi Hapus (Identik Kategori)
        function confirmDeleteUser(actionUrl, nama) {
            Swal.fire({
                title: 'Hapus Pengguna?',
                html: `Akun administrator "<strong>${nama}</strong>" akan dihapus secara permanen dari sistem.`,
                icon: 'warning',
                iconColor: '#DC2626',
                showCancelButton: true,
                confirmButtonText: '<i class="fa-solid fa-trash mr-1"></i> Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#6B7280',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-lg font-semibold',
                    cancelButton: 'rounded-lg font-semibold',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteUserForm');
                    form.action = actionUrl;
                    form.submit();
                }
            });
        }
    </script>

    <script>
        @if (Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
        @if (Session::has('error'))
            toastr.error("{{ Session::get('error') }}");
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $err)
                toastr.error("{{ $err }}");
            @endforeach
        @endif
    </script>
</body>

</html>