<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DineQR | Detail Menu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body class="bg-blue-100" x-data="{ toast: '', showToast: false }">

     @include('customer.body.nav')

    <div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-lg mt-10 pb-32">

    {{-- Gambar --}}
    <img src="{{ asset($menu->gambar) }}"
         alt="{{ $menu->nama }}"
         class="w-full h-80 object-contain rounded-lg mb-6 bg-gray-100">

    {{-- Nama Menu --}}
    <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $menu->nama }}</h1>

    {{-- Harga --}}
    <p class="text-2xl font-semibold text-blue-700 mb-4">
        Rp {{ number_format($menu->harga, 0, ',', '.') }}
    </p>

    {{-- Deskripsi --}}
    <p class="text-gray-700 leading-relaxed mb-6">
        {{ $menu->deskripsi ?? 'Belum ada deskripsi untuk menu ini.' }}
    </p>
    <form action="{{ route('customer.keranjang.add', $menu->id) }}" method="POST">
        @csrf

    {{-- Catatan (Opsional) --}}
    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">
            Catatan <span class="text-gray-500 text-sm">(Opsional)</span>
        </h2>

        <textarea name="catatan"  rows="3" placeholder="{{ $placeholder }}"
            class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 placeholder-gray-400 focus:ring-blue-400 resize-none"></textarea>
    </div>

    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg p-4 footer-anim">
            <div class="max-w-4xl mx-auto flex items-center justify-between">
                
                {{-- Form Tambah ke Keranjang --}}
    
        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
            <button type="button" onclick="decrementQty()"
                class="px-3 py-2 text-lg font-bold text-gray-600 hover:bg-gray-200 transition">-</button>
            <input id="quantity" type="number" name="quantity" value="1" min="1"
                class="w-12 text-center border-0 focus:ring-0 focus:outline-none text-gray-900">
            <button type="button" onclick="incrementQty()"
                class="px-3 py-2 text-lg font-bold text-gray-600 hover:bg-gray-200 transition">+</button>
        </div>

        @if(strtolower($menu->stok) === 'tersedia')
        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                        
            <button type="submit"
                class="text-white bg-blue-500 hover:bg-blue-700 px-6 py-2 rounded-lg shadow transition">
                Tambah ke Keranjang
            </button>
        @else
            <button type="button" disabled
                class="text-white bg-gray-400 cursor-not-allowed px-6 py-2 rounded-lg">
                Habis
            </button>
        @endif
    </form>

                

                    
                
            </div>
        </div>

    
</div>

{{-- Script QTY --}}
<script>
    function incrementQty() {
        let qty = document.getElementById('quantity');
        qty.value = parseInt(qty.value) + 1;
    }

    function decrementQty() {
        let qty = document.getElementById('quantity');
        if (parseInt(qty.value) > 1) qty.value = parseInt(qty.value) - 1;
    }
</script>

</body>

</html>
