<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DineQR | Riwayat Pesanan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-blue-100">

    @include('customer.body.nav')

    <div class="container mx-auto mt-6 p-4 bg-white rounded-lg shadow-md">
        <!-- Judul -->
        <h1 class="text-xl font-bold mb-4 text-center">
            Riwayat Pesanan Nomor Meja {{ $nomor_meja }}
        </h1>

        @if ($riwayat->isEmpty())
            <p class="text-center text-gray-600">Belum ada riwayat pesanan untuk meja ini.</p>
        @else
            @foreach ($riwayat as $pesanan)
                <div class="border-b border-gray-300 pb-4 mb-4">
                    <h2 class="text-lg font-semibold">
                        Pesanan pada {{ $pesanan->created_at->format('d M Y, H:i') }}
                    </h2>
                    <ul class="list-disc pl-6 mt-2">
                        @foreach (json_decode($pesanan->details, true) as $item)
                            <li>
                                {{ $item['nama'] }} ({{ $item['jumlah'] }} x Rp
                                {{ number_format($item['harga'], 0, ',', '.') }})
                                = Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            <!-- Total akhir -->
            <p class="mt-4 text-lg font-bold text-blue-600">
                Total Bayar: Rp {{ number_format($grandTotal, 0, ',', '.') }}
            </p>
        @endif
    </div>

</body>

</html>