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
    <title>Admin Musewangi | Kategori</title>
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

        /* ── Stat cards ── */
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

        /* ── Category cards ── */
        .cat-card {
            background: white;
            border-radius: 18px;
            border: 1.5px solid #EDD9A3;
            transition: all 0.25s ease;
            overflow: hidden;
            position: relative;
        }
        .cat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, #B78921, #E8B84B);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }
        .cat-card:hover::before { transform: scaleX(1); }
        .cat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(183,137,33,0.15);
            border-color: #C9981C;
        }

        .cat-icon-wrap {
            width: 52px; height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, #FFF3D1, #FFE5A0);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .badge-count {
            background: linear-gradient(135deg, #1D2745, #2A3860);
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            letter-spacing: 0.5px;
        }

        /* ── Action buttons ── */
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

        /* ── Modal ── */
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
            padding: 11px 14px;
            font-size: 14px;
            color: #202020;
            outline: none;
            transition: all 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .modal-input:focus {
            border-color: #B78921;
            box-shadow: 0 0 0 3px rgba(183,137,33,0.15);
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

        /* ── Empty state ── */
        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }
        .empty-icon {
            width: 80px; height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #FFF3D1, #FFE5A0);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
        }

        /* ── Search filter ── */
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

        /* ── Animations ── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .cat-card { animation: fadeInUp 0.4s ease both; }
        .cat-card:nth-child(1) { animation-delay: 0.05s; }
        .cat-card:nth-child(2) { animation-delay: 0.10s; }
        .cat-card:nth-child(3) { animation-delay: 0.15s; }
        .cat-card:nth-child(4) { animation-delay: 0.20s; }
        .cat-card:nth-child(5) { animation-delay: 0.25s; }
        .cat-card:nth-child(6) { animation-delay: 0.30s; }

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
    </style>
</head>

<body
    x-data="categoryPage()"
    x-init="init()"
    :class="{ 'dark bg-gray-900': darkMode === true }"
    class="relative min-w-screen page-bg"
>
    @include('admin.body.sidebar')

    <div
        x-show="sidebarToggle"
        @click="sidebarToggle = false"
        class="fixed inset-0 z-40 bg-black/50 lg:hidden"
        x-transition.opacity
    ></div>

    @include('admin.body.header')

   <main class="pt-24 lg:ml-64 p-5">
        <div class="mx-auto max-w-6xl">

    {{-- TITLE SECTION --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-[#162544]">
                Daftar Kategori Koleksi
            </h1>

            <p class="text-gray-500 mt-2">
                Kelola semua kategori koleksi museum, tambah, ubah, atau hapus kategori.
            </p>
        </div>

<button
    type="button"
    @click="openAddModal()"
    class="
        bg-[#C9981C]
        hover:bg-[#A77C14]
        text-white
        px-5
        py-3
        rounded-lg
        shadow
        flex
        items-center
        gap-2
        transition
    "
>
    <i class="fa fa-plus"></i>

    Tambah Kategori
</button>
    </div>

            {{-- ── STATS ROW ── --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="stat-card">
                    <p class="text-xs text-yellow-300 font-semibold uppercase tracking-widest mb-2">Total Kategori</p>
                    <p class="text-4xl font-bold text-white">{{ $kategori->count() }}</p>
                    <p class="text-xs text-blue-200 mt-1">Kategori terdaftar</p>
                    <div class="absolute right-5 top-5 opacity-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-yellow-300" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z" />
                        </svg>
                    </div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #7B5200 0%, #9A6800 100%);">
                    <p class="text-xs text-yellow-300 font-semibold uppercase tracking-widest mb-2">Total Koleksi</p>
                    <p class="text-4xl font-bold text-white">{{ $kategori->sum('koleksis_count') }}</p>
                    <p class="text-xs text-yellow-100 mt-1">Item di semua kategori</p>
                    <div class="absolute right-5 top-5 opacity-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-yellow-200" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
                <div class="stat-card" style="background: linear-gradient(135deg, #1A5C3A 0%, #1F7045 100%);">
                    <p class="text-xs text-green-200 font-semibold uppercase tracking-widest mb-2">Rata-rata / Kategori</p>
                    <p class="text-4xl font-bold text-white">
                        {{ $kategori->count() > 0 ? round($kategori->avg('koleksis_count'), 1) : 0 }}
                    </p>
                    <p class="text-xs text-green-100 mt-1">Koleksi per kategori</p>
                    <div class="absolute right-5 top-5 opacity-20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14 text-green-200" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- ── SECTION WITH SEARCH ── --}}
            <div class="section-header">
                <div class="flex items-center gap-3">
                    <h2 class="text-base font-bold text-[#1D2745]">Daftar Kategori</h2>
                    <span class="bg-[#F0E4C2] text-[#7B5200] text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $kategori->count() }} kategori
                    </span>
                </div>
                <div class="search-wrapper relative w-full sm:w-64">
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-[#B0A080] pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <input id="searchInput" type="text" placeholder="Cari kategori..." oninput="filterCards(this.value)">
                </div>
            </div>

            {{-- ── CATEGORY CARDS GRID ── --}}
            @if ($kategori->isEmpty())
                <div class="bg-white rounded-2xl border border-[#EDD9A3] empty-state">
                    <div class="empty-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-[#B78921]" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#1D2745] mb-2">Belum Ada Kategori</h3>
                    <p class="text-sm text-[#8A7D6A] mb-6">Mulai tambahkan kategori untuk mengelompokkan koleksi museum.</p>
                    <button type="button" @click="openAddModal()" class="btn-add mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah Kategori Pertama
                    </button>
                </div>
            @else
                <div id="categoryGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($kategori as $item)
                        <div class="cat-card cat-item" data-name="{{ strtolower($item->nama) }}">
                            <div class="p-5">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="cat-icon-wrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#B78921]" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-bold text-[#1D2745] leading-tight">{{ $item->nama }}</h3>
                                            <p class="text-xs text-[#9A8F7A] mt-0.5">ID #{{ $item->id }}</p>
                                        </div>
                                    </div>
                                    <span class="badge-count">
                                        {{ $item->koleksis_count }} item
                                    </span>
                                </div>

                                {{-- Progress bar --}}
                                @php
                                    $maxCount = $kategori->max('koleksis_count');
                                    $pct = $maxCount > 0 ? round(($item->koleksis_count / $maxCount) * 100) : 0;
                                @endphp
                                <div class="mb-4">
                                    <div class="flex justify-between text-xs text-[#8A7D6A] mb-1 font-medium">
                                        <span>Proporsi Koleksi</span>
                                        <span>{{ $pct }}%</span>
                                    </div>
                                    <div class="w-full bg-[#F0E4C2] rounded-full h-2 overflow-hidden">
                                        <div
                                            class="h-2 rounded-full transition-all duration-500"
                                            style="width: {{ $pct }}%; background: linear-gradient(90deg, #B78921, #E8B84B);"
                                        ></div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-3 border-t border-[#F0E4C2]">
                                    <span class="text-xs text-[#8A7D6A]">
                                        <i class="fa-solid fa-boxes-stacked text-[#C9981C] mr-1"></i>
                                        {{ $item->koleksis_count }} Koleksi
                                    </span>
                                    <div class="flex items-center gap-2">
                                        <button
                                            type="button"
                                            class="btn-edit"
                                            title="Edit Kategori"
                                            @click="openEditModal({
                                                id: {{ $item->id }},
                                                nama: @js($item->nama),
                                                updateUrl: '{{ route('admin.update.kategori', $item->id) }}'
                                            })"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="m13.58 3.58 2.84 2.84a1 1 0 0 1 0 1.42l-9 9a1 1 0 0 1-.44.26l-4 1a1 1 0 0 1-1.22-1.22l1-4a1 1 0 0 1 .26-.44l9-9a1 1 0 0 1 1.42 0l1.14 1.14Z" />
                                            </svg>
                                        </button>
                                        <button
                                            type="button"
                                            class="btn-delete"
                                            title="Hapus Kategori"
                                            onclick="confirmDelete('{{ route('admin.delete.kategori', $item->id) }}', @js($item->nama), {{ $item->koleksis_count }})"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 7h8l-.6 8.2A2 2 0 0 1 11.41 17H8.59a2 2 0 0 1-1.99-1.8L6 7Zm3-4h2a1 1 0 0 1 1 1v1h4v2H4V5h4V4a1 1 0 0 1 1-1Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- No result state (hidden by default) --}}
                    <div id="noResult" class="col-span-full hidden">
                        <div class="bg-white rounded-2xl border border-[#EDD9A3] py-12 text-center">
                            <div class="empty-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-[#B78921]" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-[#1D2745]">Tidak ditemukan</p>
                            <p class="text-xs text-[#8A7D6A] mt-1">Coba kata kunci yang berbeda</p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </main>

    {{-- ══════════════ ADD MODAL ══════════════ --}}
    <div x-cloak x-show="addOpen"
        class="fixed inset-0 z-[60] flex items-center justify-center p-4 modal-overlay"
        style="background: rgba(10,14,30,0.55);"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="modal-card relative w-full max-w-md px-8 py-7"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        >
            {{-- Close --}}
            <button type="button" @click="addOpen = false"
                class="absolute right-5 top-5 w-8 h-8 flex items-center justify-center rounded-full bg-black/5 text-gray-500 hover:bg-black/10 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>

            {{-- Modal header --}}
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#B78921] to-[#E8B84B] flex items-center justify-center shadow-md shadow-yellow-400/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-[#17223F]">Tambah Kategori</h2>
                    <p class="text-xs text-[#8A7D6A]">Buat kelompok koleksi baru</p>
                </div>
            </div>

            <form action="{{ route('admin.store.kategori') }}" method="POST">
                @csrf
                <label for="nama_add" class="mb-2 block text-sm font-semibold text-[#1D2745]">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input
                    id="nama_add"
                    name="nama"
                    type="text"
                    value="{{ old('nama') }}"
                    placeholder="Contoh: Prasejarah, Senjata Tradisional..."
                    class="modal-input"
                    autofocus
                >

                @error('nama')
                    <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror

                <div class="mt-7 flex items-center justify-end gap-3">
                    <button type="button" @click="addOpen = false" class="btn-modal-cancel">
                        Batal
                    </button>
                    <button type="submit" class="btn-modal-save">
                        <i class="fa-regular fa-floppy-disk mr-1.5"></i> Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ══════════════ EDIT MODAL ══════════════ --}}
    <div x-cloak x-show="editOpen"
        class="fixed inset-0 z-[60] flex items-center justify-center p-4 modal-overlay"
        style="background: rgba(10,14,30,0.55);"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="modal-card relative w-full max-w-md px-8 py-7"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        >
            {{-- Close --}}
            <button type="button" @click="closeEditModal()"
                class="absolute right-5 top-5 w-8 h-8 flex items-center justify-center rounded-full bg-black/5 text-gray-500 hover:bg-black/10 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>

            {{-- Modal header --}}
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#3B5BDB] to-[#7048E8] flex items-center justify-center shadow-md shadow-blue-400/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M5 13.5V15h1.5L15.06 6.44l-1.5-1.5L5 13.5Zm10.71-8.04a1 1 0 0 0 0-1.42l-.75-.75a1 1 0 0 0-1.42 0l-.86.86 2.17 2.17.86-.86Z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-[#17223F]">Edit Kategori</h2>
                    <p class="text-xs text-[#8A7D6A]">Perbarui nama kategori</p>
                </div>
            </div>

            <form :action="editAction" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" x-model="editId">

                <label for="nama_edit" class="mb-2 block text-sm font-semibold text-[#1D2745]">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input
                    id="nama_edit"
                    name="nama"
                    type="text"
                    x-model="editNama"
                    placeholder="Masukkan nama kategori"
                    class="modal-input"
                >

                @error('nama')
                    <p class="mt-2 text-xs text-red-500 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror

                <div class="mt-7 flex items-center justify-end gap-3">
                    <button type="button" @click="closeEditModal()" class="btn-modal-cancel">
                        Batal
                    </button>
                    <button type="submit" class="btn-modal-save" style="background: linear-gradient(135deg,#3B5BDB,#7048E8);">
                        <i class="fa-regular fa-floppy-disk mr-1.5"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Hidden delete form --}}
    <form id="deleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function categoryPage() {
            return {
                darkMode: false,
                sidebarToggle: false,
                addOpen: {{ $errors->any() ? 'true' : 'false' }},
                editOpen: false,
                editId: null,
                editNama: '',
                editAction: '',
                init() {
                    this.darkMode = JSON.parse(localStorage.getItem('darkMode') || 'false');
                    this.$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)));
                },
                openAddModal() {
                    this.addOpen = true;
                    this.editOpen = false;
                },
                openEditModal(payload) {
                    this.editId = payload.id;
                    this.editNama = payload.nama;
                    this.editAction = payload.updateUrl;
                    this.editOpen = true;
                    this.addOpen = false;
                },
                closeEditModal() {
                    this.editOpen = false;
                },
            }
        }

        function filterCards(query) {
            const items = document.querySelectorAll('.cat-item');
            const noResult = document.getElementById('noResult');
            const q = query.toLowerCase().trim();
            let visible = 0;
            items.forEach(card => {
                const name = card.dataset.name || '';
                if (!q || name.includes(q)) {
                    card.style.display = '';
                    visible++;
                } else {
                    card.style.display = 'none';
                }
            });
            if (noResult) {
                noResult.style.display = (visible === 0 && q !== '') ? 'block' : 'none';
            }
        }

        function confirmDelete(actionUrl, nama, count) {
            let warningText = count > 0
                ? `Kategori "<strong>${nama}</strong>" memiliki <strong>${count} koleksi</strong>. Data koleksi mungkin terpengaruh.`
                : `Kategori "<strong>${nama}</strong>" akan dihapus secara permanen.`;

            Swal.fire({
                title: 'Hapus Kategori?',
                html: warningText,
                icon: count > 0 ? 'warning' : 'question',
                iconColor: count > 0 ? '#E8A030' : '#B78921',
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
                    const form = document.getElementById('deleteForm');
                    form.action = actionUrl;
                    form.submit();
                }
            });
        }
    </script>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':    toastr.info(" {{ Session::get('message') }} ");    break;
                case 'success': toastr.success(" {{ Session::get('message') }} "); break;
                case 'warning': toastr.warning(" {{ Session::get('message') }} "); break;
                case 'error':   toastr.error(" {{ Session::get('message') }} ");   break;
            }
        @endif
    </script>
</body>

</html>
