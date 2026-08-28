<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin MUSEWANGI | Koleksi</title>

    <!-- Favicon HD Multi-Resolution -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=5">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=5">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=5">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=5">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
    function koleksiApp() {
        return {
            sidebarToggle: false,
            darkMode: false
        };
    }
    </script>
</head>

<body x-data="koleksiApp()" class="bg-[#F8F5ED]">

    {{-- SIDEBAR --}}
    @include('admin.body.sidebar')

    {{-- OVERLAY MOBILE --}}
    <div
        x-show="sidebarToggle"
        @click="sidebarToggle=false"
        class="fixed inset-0 bg-black/50 z-40 lg:hidden"
        x-transition.opacity>
    </div>

    {{-- HEADER --}}
    @include('admin.body.header')

    {{-- CONTENT --}}
    <main class="pt-24 lg:ml-64 p-5">
        <div class="max-w-7xl mx-auto">

            {{-- TITLE SECTION --}}
            <div class="flex justify-between items-center mb-8 flex-wrap gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-[#162544]">
                        Daftar Koleksi
                    </h1>
                    <p class="text-gray-500 mt-1 text-sm">
                        Kelola semua data koleksi museum, tambah, ubah, lihat detail, atau cetak QR Code koleksi.
                    </p>
                </div>

                <a href="{{ route('admin.koleksi.create') }}"
                    class="bg-[#C9981C] hover:bg-[#A77C14] text-white px-5 py-2.5 rounded-xl shadow flex items-center gap-2 transition text-sm font-semibold">
                    <i class="fa fa-plus"></i> Tambah Koleksi
                </a>
            </div>

            {{-- TABLE CARD --}}
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-[#E8DCC0]">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        {{-- TABLE HEADER --}}
                        <thead class="bg-[#E9DEC7] text-[#162544]">
                            <tr>
                                <th class="px-6 py-4 text-left">Foto</th>
                                <th class="px-6 py-4 text-left">No. Registrasi</th>
                                <th class="px-6 py-4 text-left">Nama Koleksi</th>
                                <th class="px-6 py-4 text-left">Kategori</th>
                                <th class="px-6 py-4 text-left">Asal</th>
                                <th class="px-6 py-4 text-left">Kondisi</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>

                        {{-- TABLE BODY --}}
                        <tbody>
                            @forelse($collections as $collection)
                                <tr class="border-b border-gray-100 hover:bg-[#faf7ef] transition">
                                    {{-- FOTO --}}
                                    <td class="px-6 py-4">
                                        @if($collection->fotoUrl())
                                            <img
                                                src="{{ $collection->fotoUrl() }}"
                                                class="w-14 h-14 rounded-xl object-cover bg-[#E8DCC0] border border-[#E8DCC0] shadow-sm"
                                                alt="{{ $collection->nama_koleksi }}"
                                                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-14 h-14 rounded-xl bg-[#E8DCC0] flex items-center justify-center text-gray-400\'><i class=\'fa fa-image text-lg\'></i></div>';">
                                        @else
                                            <div class="w-14 h-14 rounded-xl bg-[#E8DCC0] flex items-center justify-center text-gray-400 border border-[#E8DCC0]">
                                                <i class="fa fa-image text-lg text-[#C9981C]/70"></i>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- NOMOR REGISTRASI --}}
                                    <td class="px-6 py-4 font-mono text-gray-600 text-xs">
                                        {{ $collection->no_registrasi }}
                                    </td>

                                    {{-- NAMA KOLEKSI --}}
                                    <td class="px-6 py-4 font-semibold text-[#162544]">
                                        {{ $collection->nama_koleksi }}
                                    </td>

                                    {{-- KATEGORI --}}
                                    <td class="px-6 py-4 text-gray-600">
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-[#F8F5ED] border border-[#E8DCC0] text-[#162544]">
                                            {{ $collection->kategori ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- ASAL --}}
                                    <td class="px-6 py-4 text-gray-600">
                                        {{ $collection->asal ?: '-' }}
                                    </td>

                                    {{-- KONDISI --}}
                                    <td class="px-6 py-4">
                                        @php
                                            $kondisi = strtolower($collection->kondisi ?? 'baik');
                                            $badgeClass = match($kondisi) {
                                                'baik' => 'bg-green-100 text-green-700',
                                                'rusak ringan', 'rusak_ringan', 'perlu perawatan' => 'bg-yellow-100 text-yellow-700',
                                                'rusak berat', 'rusak_berat', 'rusak' => 'bg-red-100 text-red-600',
                                                default => 'bg-gray-100 text-gray-700'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                            {{ $collection->kondisiLabel() }}
                                        </span>
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center items-center gap-1.5">
                                            {{-- PINDAH KE HALAMAN QR CODE --}}
                                            <a
                                                href="{{ route('admin.qrcode.index', ['cari' => $collection->nama_koleksi]) }}"
                                                class="w-8 h-8 rounded-lg bg-amber-50 hover:bg-[#FFF3D1] text-[#C9981C] border border-[#C9981C]/30 flex items-center justify-center transition"
                                                title="Pindah ke Halaman QR Code">
                                                <i class="fa-solid fa-qrcode text-xs"></i>
                                            </a>

                                            {{-- DETAIL --}}
                                            <a
                                                href="{{ route('admin.koleksi.detail', $collection->id) }}"
                                                class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-[#162544] flex items-center justify-center transition"
                                                title="Detail Koleksi">
                                                <i class="fa fa-eye text-xs"></i>
                                            </a>

                                            {{-- EDIT --}}
                                            <a
                                                href="{{ route('admin.koleksi.edit', $collection->id) }}"
                                                class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-[#162544] flex items-center justify-center transition"
                                                title="Ubah Koleksi">
                                                <i class="fa fa-pen text-xs"></i>
                                            </a>

                                            {{-- DELETE --}}
                                            <button
                                                type="button"
                                                onclick="konfirmasiHapus(
                                                    '{{ $collection->id }}',
                                                    '{{ addslashes($collection->nama_koleksi) }}',
                                                    '{{ route('admin.koleksi.delete', $collection->id) }}'
                                                )"
                                                class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-red-100 text-red-500 flex items-center justify-center transition"
                                                title="Hapus Koleksi">
                                                <i class="fa fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-12 text-gray-400">
                                        <i class="fa-solid fa-box-open text-4xl mb-2 text-gray-300 block"></i>
                                        Belum ada data koleksi museum.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    {{-- TOASTR SUCCESS NOTIFICATION --}}
    @if(session('message'))
        <script>
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right",
                timeOut: 3000,
                extendedTimeOut: 1000,
                showDuration: 300,
                hideDuration: 300,
                showMethod: "slideDown",
                hideMethod: "slideUp"
            };
            toastr.success("{{ session('message') }}");
        </script>
    @endif

    {{-- SWEETALERT2 KONFIRMASI HAPUS (MATCHING FIGMA) --}}
    <script>
        function konfirmasiHapus(id, nama, url) {
            Swal.fire({
                title: 'Hapus Koleksi?',
                html: `
                    <p class="text-sm text-gray-600 mb-2">
                        Apakah Anda yakin ingin menghapus data koleksi <strong>"${nama}"</strong>?
                    </p>
                    <p class="text-xs text-red-500 font-medium">
                        Tindakan ini tidak dapat dibatalkan.
                    </p>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="fa-solid fa-trash mr-1"></i> Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#DC2626',
                cancelButtonColor: '#6B7280',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl shadow-xl border border-[#E8DCC0] p-6',
                    confirmButton: 'rounded-xl px-5 py-2.5 font-bold text-xs',
                    cancelButton: 'rounded-xl px-5 py-2.5 font-bold text-xs'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.createElement('form');
                    form.action = url;
                    form.method = 'POST';
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

</body>

</html>
