<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin MUSEWANGI | QR Code Koleksi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ 'darkMode': false, 'sidebarToggle': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }" class=" relative min-w-screen">

    @include('admin.body.sidebar')
    <div x-show="sidebarToggle" @click="sidebarToggle = false" class="fixed inset-0 z-40 bg-black/50 lg:hidden"
        x-transition.opacity></div>
    @include('admin.body.header')

    <main class="pt-16 transition-all duration-300 dark:bg-gray-900 lg:ml-64 p-4 z-10">
        <div class="mb-5">
            <h2 class="font-bold text-xl dark:text-white">QR Code Koleksi</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Lihat atau unduh QR Code untuk setiap koleksi agar
                informasi mudah diakses pengunjung.</p>
        </div>

        <form method="GET" action="{{ route('admin.koleksi.qrcode') }}" class="mb-4 max-w-sm">
            <div class="relative">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama koleksi..."
                    class="w-full rounded-lg border border-gray-300 py-2 pl-9 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#C9981C] dark:bg-gray-700 dark:text-white dark:border-gray-600">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            </div>
        </form>

        <div class="py-2 overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Nama</th>
                        <th scope="col" class="px-4 py-3">No. Registrasi</th>
                        <th scope="col" class="px-4 py-3">QR Code</th>
                        <th scope="col" class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($koleksis as $koleksi)
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $koleksi->nama }}</td>
                            <td class="px-4 py-3">{{ $koleksi->no_registrasi_baru }}</td>
                            <td class="px-4 py-3">
                                @if ($koleksi->qr_code)
                                    <img src="{{ asset($koleksi->qr_code) }}" class="w-12 h-12">
                                @else
                                    <span class="text-xs text-gray-400">Belum tersedia</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-1">
                                    @if ($koleksi->qr_code)
                                        <button type="button"
                                            onclick="lihatQr('{{ asset($koleksi->qr_code) }}', '{{ addslashes($koleksi->nama) }}', '{{ route('admin.koleksi.qrcode.download', $koleksi->id) }}')"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded bg-gray-500 hover:bg-gray-600 text-white"
                                            title="Lihat QR"><i class="fas fa-eye text-xs"></i></button>
                                        <a href="{{ route('admin.koleksi.qrcode.download', $koleksi->id) }}"
                                            class="inline-flex items-center justify-center w-7 h-7 rounded bg-[#C9981C] hover:bg-[#b3860f] text-white"
                                            title="Unduh"><i class="fas fa-download text-xs"></i></a>
                                    @else
                                        <span class="text-xs text-gray-400">-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-gray-400">Belum ada data koleksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $koleksis->links() }}
        </div>
    </main>

    <!-- Modal Lihat QR Code -->
    <div id="qrModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="bg-[#FBF6EC] rounded-lg shadow-lg w-full max-w-xs p-6 relative text-center">
            <button onclick="tutupQr()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-800">
                <i class="fas fa-xmark"></i>
            </button>
            <h3 class="font-bold text-lg mb-4">QR Code</h3>
            <img id="qrModalImage" src="" class="w-40 h-40 mx-auto mb-4" alt="QR Code">
            <a id="qrModalDownload" href="#" class="inline-block bg-[#162544] hover:bg-[#0f1b33] text-white text-sm font-semibold py-2 px-4 rounded">
                Download
            </a>
        </div>
    </div>

    <script>
        function lihatQr(src, nama, downloadUrl) {
            document.getElementById('qrModalImage').src = src;
            document.getElementById('qrModalImage').alt = nama;
            document.getElementById('qrModalDownload').href = downloadUrl;
            document.getElementById('qrModal').classList.remove('hidden');
            document.getElementById('qrModal').classList.add('flex');
        }

        function tutupQr() {
            document.getElementById('qrModal').classList.add('hidden');
            document.getElementById('qrModal').classList.remove('flex');
        }
    </script>

</body>

</html>
