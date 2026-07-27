
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Admin Musewangi | Edit Kategori</title>
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
            <a href="{{ route('admin.kategori.menu') }}" class="hover:text-[#B78921] transition">Kategori</a>
            <i class="fa-solid fa-chevron-right text-xs text-[#B0A080]"></i>
            <span class="text-[#1D2745] font-semibold">Edit</span>
        </nav>
        <div class="max-w-lg mx-auto">
            <div class="bg-white rounded-2xl border border-[#EDD9A3] shadow-[0_8px_32px_rgba(183,137,33,0.12)] overflow-hidden">
                {{-- Card Header --}}
                <div class="bg-gradient-to-r from-[#2A3066] to-[#3B5BDB] px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center border border-white/30">
                            <i class="fa-solid fa-pen text-white text-sm"></i>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-white">Edit Kategori</h1>
                            <p class="text-xs text-blue-200">Perbarui nama kategori "{{ $kategori->nama }}"</p>
                        </div>