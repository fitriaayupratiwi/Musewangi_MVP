<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <title>Admin MUSEWANGI | Koleksi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ 'darkMode': false, 'sidebarToggle': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }" class=" relative min-w-screen">

    @include('admin.body.sidebar')
    <div x-show="sidebarToggle" @click="sidebarToggle = false" class="fixed inset-0 z-40 bg-black/50 lg:hidden"
        x-transition.opacity></div>
    @include('admin.body.header')

    <main class="pt-16 transition-all duration-300 dark:bg-gray-900 lg:ml-64 p-4 z-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-5 gap-3">
            <div>
                <h2 class="font-bold text-xl dark:text-white">Koleksi</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kelola semua data koleksi museum. Tambah, ubah,
                    lihat detail, atau hapus koleksi.</p>
            </div>
            <a href="{{ route('admin.koleksi.create') }}"
                class="inline-flex items-center justify-center gap-1 bg-[#C9981C] hover:bg-[#b3860f] text-white font-semibold py-2 px-4 rounded whitespace-nowrap">
                <i class="fas fa-plus"></i> Tambah Koleksi
            </a>
        </div>

        <form method="GET" action="{{ route('admin.koleksi.index') }}" class="mb-4 max-w-sm">
            <div class="relative">
                <input type="text" name="cari" value="{{ request('cari') }}"
                    placeholder="Cari koleksi, no. registrasi..."
                    class="w-full rounded-lg border border-gray-300 py-2 pl-9 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#C9981C] dark:bg-gray-700 dark:text-white dark:border-gray-600">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
        </form>

        <div class="py-2 overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Foto</th>
                        <th scope="col" class="px-4 py-3">No. Registrasi</th>
                        <th scope="col" class="px-4 py-3">Nama Koleksi</th>
                        <th scope="col" class="px-4 py-3">Kategori</th>
                        <th scope="col" class="px-4 py-3">Jenis Benda</th>
                        <th scope="col" class="px-4 py-3">Asal</th>
                        <th scope="col" class="px-4 py-3">Kondisi</th>
                        <th scope="col" class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($koleksis as $koleksi)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <td class="px-4 py-3">
                                <div class="w-14 h-14 rounded overflow-hidden bg-gray-100 flex items-center justify-center">
                                    @if ($koleksi->foto)
                                        <img src="{{ asset($koleksi->foto) }}" class="w-full h-full object-cover" alt="{{ $koleksi->nama }}">
                                    @else
                                        <i class="fas fa-image text-gray-300"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $koleksi->no_registrasi_baru }}</td>
                            <td class="px-4 py-3">{{ $koleksi->nama }}</td>
                            <td class="px-4 py-3">{{ $koleksi->kategori->nama ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $koleksi->jenis_benda }}</td>
                            <td class="px-4 py-3">{{ $koleksi->asal ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $badge = match ($koleksi->kondisi) {
                                        'baik' => 'bg-green-100 text-green-700',
                                        'rusak_ringan' => 'bg-yellow-100 text-yellow-700',
                                        'rusak_berat' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                    {{ $koleksi->kondisiLabel() }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.koleksi.show', $koleksi->id) }}"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded bg-gray-500 hover:bg-gray-600 text-white"
                                        title="Lihat"><i class="fas fa-eye text-xs"></i></a>
                                    <a href="{{ route('admin.koleksi.edit', $koleksi->id) }}"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded bg-blue-500 hover:bg-blue-600 text-white"
                                        title="Edit"><i class="fas fa-pen text-xs"></i></a>
                                    <button type="button"
                                        onclick="hapusKoleksi('{{ route('admin.koleksi.destroy', $koleksi->id) }}', '{{ addslashes($koleksi->nama) }}')"
                                        class="inline-flex items-center justify-center w-7 h-7 rounded bg-red-500 hover:bg-red-600 text-white"
                                        title="Hapus"><i class="fas fa-trash text-xs"></i></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-gray-400">Belum ada data koleksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $koleksis->links() }}
        </div>
    </main>

    <form id="deleteForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function hapusKoleksi(url, nama) {
            Swal.fire({
                title: 'Hapus Koleksi?',
                text: `Yakin ingin menghapus koleksi "${nama}"? Data yang dihapus tidak dapat dikembalikan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = url;
                    form.submit();
                }
            });
        }

        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch (type) {
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
                default:
                    toastr.info("{{ Session::get('message') }}");
            }
        @endif
    </script>
</body>

</html>
