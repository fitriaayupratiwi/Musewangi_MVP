<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin MUSEWANGI | Riwayat Aktivitas</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon HD Multi-Resolution -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=5">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=5">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=5">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=5">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Toastr & SweetAlert -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F8F5ED;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body x-data="{ sidebarToggle: false, darkMode: false, selectedIds: [] }" class="relative min-h-screen bg-[#F8F5ED]">

    {{-- SIDEBAR --}}
    @include('admin.body.sidebar')

    {{-- OVERLAY MOBILE --}}
    <div x-show="sidebarToggle" @click="sidebarToggle = false" x-cloak
        class="fixed inset-0 z-40 bg-black/50 backdrop-blur-xs lg:hidden"></div>

    {{-- HEADER --}}
    @include('admin.body.header')

    {{-- MAIN CONTENT --}}
    <main class="pt-28 pb-16 px-4 sm:px-6 lg:px-8 lg:ml-64 z-10 min-h-screen transition-all duration-300">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- PAGE TITLE BAR -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-[#E8DCC0] shadow-xs">
                <div>
                    <div class="flex items-center gap-2.5">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#162544] to-[#21365E] text-[#FFD86B] flex items-center justify-center shadow-xs">
                            <i class="fa-solid fa-clock-rotate-left text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-[#162544]">Riwayat Aktivitas</h1>
                            <p class="text-xs text-gray-500">Log catatan seluruh aktivitas dan perubahan di sistem MUSEWANGI.</p>
                        </div>
                    </div>
                </div>

                <!-- SEARCH & BULK ACTIONS -->
                <div class="flex flex-wrap items-center gap-3">
                    {{-- Search Form --}}
                    <form method="GET" action="{{ route('admin.riwayat') }}" class="relative flex-1 sm:w-72">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari aktivitas, objek..."
                            class="w-full pl-9 pr-8 py-2 text-xs rounded-xl border border-[#E8DCC0] bg-[#FAF8F3] text-[#162544] focus:bg-white focus:border-[#C9981C] focus:ring-2 focus:ring-[#C9981C]/20 outline-none transition">
                        @if(request('search'))
                            <a href="{{ route('admin.riwayat') }}"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 text-xs">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </a>
                        @endif
                    </form>

                    {{-- Bulk Delete Button --}}
                    <form action="{{ route('admin.riwayat.bulkDelete') }}" method="POST" id="bulkDeleteForm">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="ids" id="selectedIdsInput">
                        <button type="button" onclick="hapusTerpilih()"
                            class="px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-xs transition flex items-center gap-2">
                            <i class="fa-solid fa-trash text-xs"></i>
                            <span>Hapus Terpilih</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- TABLE CARD -->
            <div class="bg-white rounded-2xl border border-[#E8DCC0] shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-[#F8F5ED] text-[#162544] font-bold border-b border-[#E8DCC0]">
                                <th class="py-3.5 px-4 w-12 text-center">
                                    <input type="checkbox" id="checkAll" class="rounded border-gray-300 text-[#C9981C] focus:ring-[#C9981C] cursor-pointer">
                                </th>
                                <th class="py-3.5 px-4">Waktu</th>
                                <th class="py-3.5 px-4">Aktivitas</th>
                                <th class="py-3.5 px-4">Objek / Target</th>
                                <th class="py-3.5 px-4">Keterangan</th>
                                <th class="py-3.5 px-4 text-center w-20">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F2E9D6] text-gray-700">
                            @forelse($aktivitas as $item)
                                @php
                                    $akt = strtolower($item->aktivitas ?? '');
                                    $badge = match(true) {
                                        str_contains($akt, 'hapus') || str_contains($akt, 'delete') => ['bg-red-50 text-red-700 border-red-200', 'fa-trash'],
                                        str_contains($akt, 'edit') || str_contains($akt, 'ubah') || str_contains($akt, 'update') => ['bg-amber-50 text-amber-700 border-amber-200', 'fa-pen'],
                                        str_contains($akt, 'tambah') || str_contains($akt, 'create') => ['bg-emerald-50 text-emerald-700 border-emerald-200', 'fa-plus'],
                                        default => ['bg-blue-50 text-blue-700 border-blue-200', 'fa-circle-info']
                                    };
                                @endphp
                                <tr class="hover:bg-[#FAF8F3] transition">
                                    <td class="py-3 px-4 text-center">
                                        <input type="checkbox" name="aktivitas[]" value="{{ $item->id }}"
                                            class="activity-checkbox rounded border-gray-300 text-[#C9981C] focus:ring-[#C9981C] cursor-pointer">
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap text-gray-500 font-mono text-[11px]">
                                        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $badge[0] }}">
                                            <i class="fa-solid {{ $badge[1] }} text-[10px]"></i>
                                            <span>{{ $item->aktivitas }}</span>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 font-semibold text-[#162544] max-w-xs truncate">
                                        {{ $item->objek ?: '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-600">
                                        {{ $item->keterangan ?: '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <button type="button" onclick="hapusRiwayat('{{ route('admin.riwayat.hapus', $item->id) }}')"
                                            class="w-7 h-7 rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white border border-red-200 transition inline-flex items-center justify-center"
                                            title="Hapus Catatan Ini">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-gray-400">
                                        <i class="fa-solid fa-clock-rotate-left text-3xl text-gray-300 mb-2 block"></i>
                                        <p class="text-xs font-medium">Belum ada catatan riwayat aktivitas di sistem.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- PAGINATION -->
                @if($aktivitas->hasPages())
                    <div class="p-4 border-t border-[#E8DCC0] bg-[#FAF8F3]">
                        {{ $aktivitas->links() }}
                    </div>
                @endif
            </div>

        </div>
    </main>

    <!-- SWEETALERT & SCRIPTS -->
    <script>
        // Check All Functionality
        document.addEventListener('DOMContentLoaded', function () {
            const checkAll = document.getElementById('checkAll');
            const checkboxes = document.querySelectorAll('.activity-checkbox');

            if (checkAll) {
                checkAll.addEventListener('change', function () {
                    checkboxes.forEach(cb => cb.checked = checkAll.checked);
                });
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', function () {
                    const allChecked = Array.from(checkboxes).every(c => c.checked);
                    if (checkAll) checkAll.checked = allChecked;
                });
            });
        });

        // Single Delete
        function hapusRiwayat(url) {
            Swal.fire({
                title: 'Hapus Catatan Riwayat?',
                text: 'Catatan aktivitas ini akan dihapus permanen dari sistem.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }

        // Bulk Delete
        function hapusTerpilih() {
            const checked = document.querySelectorAll('.activity-checkbox:checked');
            if (checked.length === 0) {
                Swal.fire({
                    title: 'Pilih Catatan',
                    text: 'Silakan centang minimal satu catatan riwayat yang ingin dihapus.',
                    icon: 'info',
                    confirmButtonColor: '#C9981C'
                });
                return;
            }

            const ids = Array.from(checked).map(c => c.value);

            Swal.fire({
                title: `Hapus ${ids.length} Catatan?`,
                text: 'Semua catatan aktivitas terpilih akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#6B7280',
                confirmButtonText: 'Ya, Hapus Semua',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('selectedIdsInput').value = ids.join(',');
                    document.getElementById('bulkDeleteForm').submit();
                }
            });
        }

        // Toastr Flash Messages
        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
                case 'info': toastr.info("{{ Session::get('message') }}"); break;
                case 'success': toastr.success("{{ Session::get('message') }}"); break;
                case 'warning': toastr.warning("{{ Session::get('message') }}"); break;
                case 'error': toastr.error("{{ Session::get('message') }}"); break;
            }
        @endif
        @if(Session::has('success'))
            toastr.success("{{ Session::get('success') }}");
        @endif
    </script>

</body>

</html>