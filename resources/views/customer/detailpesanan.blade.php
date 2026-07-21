<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DineQR | List Pesanan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
        /* Toast Animation */
        .toast {
            animation: slideIn 0.5s, fadeOut 0.5s 3s forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }
    </style>
</head>

<body class="bg-blue-100">

    @include('customer.body.nav')

    <div class="container mx-auto mt-6 p-4 bg-white rounded-lg shadow-md">
        <!-- Judul di tengah -->
        <h1 class="text-xl font-bold mb-4 text-center">
            Detail Pesanan Nomor Meja {{ $pesanan->nomor_meja }}
        </h1>

        <!-- List item -->
        <h2 class="text-lg font-semibold mt-4 mb-2">Item yang dipesan:</h2>
        <ul class="list-disc pl-6">
            @foreach (json_decode($pesanan->details, true) as $item)
                <li>
                    {{ $item['nama'] }} ({{ $item['jumlah'] }} x Rp {{ number_format($item['harga'], 0, ',', '.') }})
                    = Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                </li>
            @endforeach
        </ul>

        <!-- Total bayar rata kiri -->
        <p class="mt-4"><strong>Total Bayar:</strong> Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</p>

        <!-- Tombol Riwayat & Pesan Lagi -->
        <div class="mt-6 flex justify-between">
            <a href="{{ route('customer.riwayat', ['nomor_meja' => $pesanan->nomor_meja]) }}"
                class="px-4 py-2 border-2 border-blue-600 text-black rounded-lg hover:bg-blue-50 transition">List Pesanan</a>

            <a href="{{ route('customer.menu') }}" id="pesanLagiBtn"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Pesan Lagi</a>
        </div>
    </div>
    <!-- Toast Notification -->
    <div id="toast-container" class="fixed top-5 right-5 space-y-2 z-50"></div>

    <script>
        // SweetAlert Toast Notifikasi dari session
        @if (session('message'))
            const type = "{{ session('alert-type') }}";
            const message = "{{ session('message') }}";

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: type,
                title: message
            });
        @endif

        // Konfirmasi Pesan Lagi
        $(document).on("click", "#pesanLagiBtn", function(e) {
            e.preventDefault();
            const url = $(this).attr("href");

            Swal.fire({
                text: "Kamu yakin ingin memulai pesanan baru?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Pesanan Baru",
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    </script>

    @if(session('success'))
<div id="successModal"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">

    <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full text-center">
        <h3 class="text-lg font-semibold text-green-600 mb-2">
            ✅ Pesanan Berhasil
        </h3>

        <p class="text-gray-700 mb-4">
            {{ session('success') }}
        </p>

        <button onclick="closeModal()"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            OK
        </button>
    </div>
</div>

<script>
function closeModal() {
    document.getElementById('successModal')?.remove();
}
</script>
@endif




</body>

</html>