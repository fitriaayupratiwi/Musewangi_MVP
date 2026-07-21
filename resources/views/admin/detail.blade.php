<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran</title>
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

    <main class="pt-16 transition-all duration-300 p-4
    dark:bg-gray-900
    lg:ml-64 z-10">
        <h1 class="text-2xl font-bold mb-6">Detail Pesanan</h1>

        <div class="mb-4">
            <p><strong>Tanggal:</strong> {{ $pesanan->created_at->format('d M Y H:i') }}</p>
            <p><strong>Nomor Meja:</strong> {{ $pesanan->nomor_meja }}</p>
        </div>

        <table class="table-auto w-full border-collapse border border-gray-300 mb-6">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">#</th>
                    <th class="border px-4 py-2">Nama Produk</th>
                    <th class="border px-4 py-2">Harga</th>
                    <th class="border px-4 py-2">Jumlah</th>
                    <th class="border px-4 py-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanan->details as $detail)
                    <tr>
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $detail['nama'] }}</td>

                        <td class="border px-4 py-2">
                            {{ number_format($detail['harga'], 0, ',', '.') }}
                        </td>
                        <td class="border px-4 py-2">{{ $detail['jumlah'] }}</td>
                        <td class="border px-4 py-2">
                            {{ number_format($detail['subtotal'], 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <div class="text-right text-xl font-bold">
            Total Bayar: @php echo number_format($pesanan->total_bayar, 0, ',', '.'); @endphp
        </div>



        <div class="mt-6">
            {{-- <form action="{{ route('admin.pesanan.bayar', $pesanan->id) }}" method="POST">
                @csrf
                <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Bayar Sekarang
                </button>
            </form> --}}
        </div>
    </main>
</body>

</html>