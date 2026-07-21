<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DineQR | Keranjang Pesanan</title>
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
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; transform: translateX(100%); }
        }

        /* Footer animation */
        .footer-anim {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-blue-100" x-data="{ toast: '', showToast: false }">

     @include('customer.body.nav')

    <div class="container mx-auto mt-6 p-4 bg-white rounded-lg shadow-md">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold mb-8">Keranjang Anda</h1>
        </div>
        <!-- Versi Tabel (desktop & tablet) -->
        <div class="hidden md:block relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-2 text-center">No</th>
                        <th scope="col" class="px-4 py-2 text-center">Nama Produk</th>
                        <th scope="col" class="px-4 py-2 text-center">Harga</th>
                        <th scope="col" class="px-4 py-2 text-center">Jumlah</th>
                        <th scope="col" class="px-4 py-2 text-center">Subtotal</th>
                        <th scope="col" class="px-4 py-2 text-center">Catatan</th>
                        <th scope="col" class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($keranjangs as $keranjang)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td scope="row" class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $keranjang->menu->nama }}
                                @if ($keranjang->ukuran)
                                    <div class="text-xs text-gray-500">(Ukuran: {{ $keranjang->ukuran }})</div>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                Rp. {{ number_format($keranjang->harga_satuan, 0, ',', '.') }}
                            </td>

                            {{-- QTY Buttons --}}
                            <td class="px-2 py-2 text-center">
                                <form action="{{ route('customer.keranjang.update', $keranjang->id) }}"
                                    method="POST" class="inline-flex items-center"
                                    x-data="{ jumlah: {{ $keranjang->jumlah }} }">
                                    @csrf
                                    @method('PUT')

                                    <!-- Tombol - -->
                                    <button type="submit" name="action" value="decrement"
                                        class="mx-1 px-3 py-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-l transition">
                                        −
                                    </button>

                                    <!-- Input jumlah (animated bounce) -->
                                    <input type="number" name="jumlah" x-model="jumlah"
                                        class="w-13 text-center border-t border-b border-gray-300 focus:outline-none text-lg font-semibold transform transition-transform duration-150"
                                        x-effect="$el.classList.add('scale-110'); setTimeout(()=> $el.classList.remove('scale-110'),150)">

                                    <!-- Tombol + -->
                                    <button type="submit" name="action" value="increment"
                                        class="mx-1 px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-r transition">
                                        +
                                    </button>
                                </form>
                            </td>

                            <td class="px-4 py-2 text-center text-blue-600 font-semibold">
                                Rp. {{ number_format($keranjang->total_harga, 0, ',', '.') }}
                            </td>
                            <!-- Kolom Catatan -->
                            <td class="px-4 py-2 text-center text-gray-700">
                                {{ $keranjang->catatan ?? '-' }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                <form action="{{ route('customer.keranjang.delete', $keranjang->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-white bg-red-600 hover:bg-red-800 rounded-lg px-2 py-1">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- 🔹 Versi Card (mobile only) -->
    <div class="md:hidden space-y-4 mt-4">
        @foreach ($keranjangs as $keranjang)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $keranjang->menu->nama }}</h3>
                        @if ($keranjang->ukuran)
                            <p class="text-xs text-gray-500 mt-0.5">Ukuran: {{ $keranjang->ukuran }}</p>
                        @endif
                    </div>
                    <p class="text-blue-600 font-semibold">
                        Rp {{ number_format($keranjang->total_harga, 0, ',', '.') }}
                    </p>
                </div>

                <div class="mt-3 text-sm text-gray-600 space-y-1">
                    <p>Harga: Rp {{ number_format($keranjang->harga_satuan, 0, ',', '.') }}</p>
                    <p>Jumlah: {{ $keranjang->jumlah }}</p>
                    <p>Catatan: {{ $keranjang->catatan ?? '-' }}</p>
                </div>

                <div class="flex items-center justify-between mt-3">
                    <!-- Form update jumlah -->
                    <form action="{{ route('customer.keranjang.update', $keranjang->id) }}"
                        method="POST" class="flex items-center gap-1"
                        x-data="{ jumlah: {{ $keranjang->jumlah }} }">
                        @csrf
                        @method('PUT')

                        <button type="submit" name="action" value="decrement"
                            class="px-3 py-1 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-l transition">
                            −
                        </button>
                        <input type="number" name="jumlah" x-model="jumlah"
                            class="w-12 text-center border-y border-gray-300 text-sm font-semibold focus:outline-none">
                        <button type="submit" name="action" value="increment"
                            class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-r transition">
                            +
                        </button>
                    </form>

                    <!-- Tombol hapus -->
                    <form action="{{ route('customer.keranjang.delete', $keranjang->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-800 text-white px-3 py-1 rounded-md text-sm transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
        

        <!-- Checkout -->
        <div class="mt-8 ">
            <form action="{{ route('customer.keranjang.checkout') }}" method="POST" id="checkoutForm">
                @csrf
                <div class="mb-5">
                    <label for="nomor_meja"
                        class="block mb-2 text-sm font-bold text-gray-900">Nomor Meja</label>
                    @if (session('nomor_meja'))
                        <input type="text" value="Meja {{ session('nomor_meja') }}"
                            class="block w-full p-3 border border-gray-300 rounded-lg bg-gray-100" disabled>
                        <input type="hidden" name="nomor_meja" value="{{ session('nomor_meja') }}">
                    @else
                        <select name="nomor_meja" id="nomor_meja" 
                            class="block w-full p-3 border border-gray-300 rounded-lg bg-gray-50">
                            <option value="">Pilih Nomor Meja</option>
                            @foreach ($nomor_mejas as $meja)
                                <option value="{{ $meja->nomor }}">Meja {{ $meja->nomor }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
        </div>

        
        {{-- @if(Auth::check())
            <div class="mb-3">
                <label for="nomor_meja_manual">Atau Masukkan Nomor Meja Manual</label>
                <input type="text" class="form-control" id="nomor_meja_manual"
                name="nomor_meja_manual" placeholder="Contoh: 15A">
            </div>
        @endif --}}
       

        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg p-4 footer-anim">
            <div class="max-w-4xl mx-auto flex items-center justify-between">
                
                <!-- Harga -->
                <span class="text-2xl md:text-3xl font-bold text-blue-600">
                    Total Rp. {{ number_format($totalBayar, 0, ',', '.') }}
                </span>
                <div class="flex space-x-3">
                    <button type="submit"
                        class="w-20 text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3">
                        Pesan
                    </button>
                </form>

                @if(session('from_kasir'))
                    {{-- Tombol untuk kasir --}}
                    <a href="{{ route('kasir.pesanan') }}"
                    class="px-4 py-2 border-2 border-gray-600 text-black rounded-lg hover:bg-gray-100 transition">
                    Kembali
                    </a>
                @else
                    {{-- Tombol untuk customer --}}
                    <a href="{{ $pesanan ? route('customer.riwayat', ['nomor_meja' => $pesanan->nomor_meja]) : '#' }}"
                    class="px-4 py-2 border-2 border-blue-600 text-black rounded-lg hover:bg-blue-50 transition">
                    List Pesanan
                    </a>
                @endif

                

                    
                </div>
            </div>
        </div>
    </div>

    

    <!-- Toast Notification -->
    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-5 right-5 space-y-2 z-50"></div>

    <script>
        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            // let manual = document.getElementById('nomor_meja_manual').value.trim();
            let manualField = document.getElementById('nomor_meja_manual');
            let manual = manualField ? manualField.value.trim() : "";
            let dropdown = document.getElementById('nomor_meja');

            // Kalau dua-duanya kosong → cegah submit
            if (!manual && !dropdown.value) {
                e.preventDefault();
                alert("Silakan pilih nomor meja atau isi manual jika kasir.");
                return;
            }

            // Kalau manual diisi,  kosongkan dropdown agar prioritas manual
            if (manual) {
                dropdown.value = "";
            }
        });
    </script>
    <script>
        // Jika session success/error, munculkan toast
        @if (session('success'))
            // fungsi toast
            function showToast(message) {
                const container = document.getElementById("toast-container");
                const toast = document.createElement("div");
                toast.className = "toast bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md";
                toast.innerText = message;
                container.appendChild(toast);

                // auto remove setelah animasi selesai
                setTimeout(() => {
                    toast.remove();
                }, 4000);
            }

            // cek apakah ada session flash dari Laravel
            @if(session('success'))
                showToast("{{ session('success') }}");
            @endif
        @endif

        @if (session('error'))
                function showToast(message) {
                const container = document.getElementById("toast-container");
                const toast = document.createElement("div");
                toast.className = "toast bg-red-600 text-white px-4 py-2 rounded-lg shadow-md";
                toast.innerText = message;
                container.appendChild(toast);

                // auto remove setelah animasi selesai
                setTimeout(() => {
                    toast.remove();
                }, 4000);
            }

            // cek apakah ada session flash dari Laravel
            @if(session('error'))
                showToast("{{ session('error') }}");
            @endif
        @endif
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
        document.getElementById('successModal').remove();
    }
</script>
@endif


</body>

</html>
