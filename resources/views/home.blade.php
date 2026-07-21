<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DineQR | Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
    </style>
</head>

<body class="bg-blue-100 dark:bg-gray-900">

    <!-- Tab Kategori -->

        <nav class="border-blue-200 bg-white dark:bg-gray-800 dark:border-blue-700 shadow-md rounded-b-lg">
    <div class="max-w-screen-xl mx-auto p-4 flex justify-center items-center">

        <!-- Form Pencarian -->
        <div class="relative w-full max-w-md">
            <form method="GET" action="{{ url('/menu') }}" class="relative">
                <input id="searchInput" type="text" name="search" placeholder="Cari Menu ..."
                    class="w-full pl-4 pr-12 py-2 text-left border rounded-full
                           focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit"
                    class="absolute right-2 top-1/2 -translate-y-1/2
                           bg-blue-500 text-white rounded-full
                           w-8 h-8 flex items-center justify-center
                           transition duration-200 hover:bg-white hover:text-blue-500">
                    <i class="fas fa-arrow-right text-sm"></i>
                </button>
            </form>
        </div>

    </div>
</nav>


        @if ($nomorMeja)
            <div class="bg-orange-100 p-3 rounded text-center mx-4 mt-4 shadow">
                <span class="font-semibold text-black">Nomor Meja:</span>
                <span class="font-semibold text-black">{{ $nomorMeja }}</span>
            </div>
        @endif

        <div class="w-full overflow-x-auto scrollbar-hide scroll-smooth">
            <ul class="flex flex-nowrap md:flex-wrap text-sm font-medium text-center text-gray-500 mt-4 mb-6 px-4 md:px-6 gap-3 md:gap-4">

                {{-- Tab Semua --}}
                <li class="flex-shrink-0">
                    <a href="javascript:void(0)" onclick="showCategory('semua')"
                        class="kategori-tab block px-6 py-3 rounded-xl shadow-md border border-gray-200
                            bg-white text-gray-600 font-medium transform transition-all duration-300
                            hover:scale-105 hover:shadow-lg hover:bg-blue-50 active"
                        id="tab-semua">
                        Semua
                    </a>
                </li>

                {{-- Tab Kategori Dinamis --}}

                @foreach ($kategoris as $index => $kategori)
                    @php $kategoriId = Str::slug($kategori->nama); @endphp
                    <li class="flex-shrink-0">
                        <a href="javascript:void(0)" onclick="showCategory('{{ $kategoriId }}')"
                            class="kategori-tab block px-6 py-3 rounded-xl shadow-md border border-gray-200 
                                bg-white text-gray-600 font-medium transform transition-all duration-300
                                hover:scale-105 hover:shadow-lg hover:bg-blue-50 {{ $index == 0 ? 'text-blue-600 bg-gray-100 active' : '' }}"
                            id="tab-{{ $kategoriId }}">
                            {{ $kategori->nama }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        

        <!-- Konten Semua -->
        <div class="kategori-content" id="kategori-semua">
    <h2 class="text-2xl font-bold text-gray-900 mt-8 ml-4">Semua Menu</h2>
    <div class="px-4 py-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @php
            $allMenus = $kategoris->flatMap->menus;

            // Urutkan agar stok "tersedia" di atas, dan "habis" di bawah
            $sortedMenus = $allMenus->sortBy(function ($menu) {
                return strtolower($menu->stok) === 'tersedia' ? 0 : 1;
            });
        @endphp
        
        @foreach ($sortedMenus as $menu)
            <div data-nama="{{ strtolower($menu->nama) }}"  
                class="cursor-pointer menu-item w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transform transition duration-300 hover:scale-105 hover:-translate-y-1">

                {{-- 🟡 Icon Best Seller --}}
                @if (isset($bestSellers) && in_array($menu->id, $bestSellers))
                    <div class="absolute top-3 left-3 bg-yellow-400 text-white text-sm font-semibold px-2 py-1 rounded-full flex items-center gap-1 shadow">
                         <i class="fas fa-star"></i> Best Seller
                    </div>
                @endif

                {{-- 🧑‍🍳 Icon Rekomendasi Chef --}}
                @if (isset($recommendedMenus) && in_array($menu->id, $recommendedMenus))
                    <div class="absolute top-3 right-3 bg-orange-500 text-white text-sm font-semibold px-2 py-1 rounded-full flex items-center gap-1 shadow">
                        <i class="fas fa-user-tie"></i> Recomended
                    </div>
                @endif

                <a href="{{ route('menu.show', $menu->id) }}" class="cursor-pointer">
                    <img class="p-4 rounded-3xl w-full h-90 aspect-square object-cover"
                        src="{{ asset($menu->gambar) }}" alt="{{ $menu->nama }}" />
                </a>

                <div class="px-5 pb-5">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-5">
                        <a href="{{ route('menu.show', $menu->id) }}" class="cursor-pointer">
                            <h5 class="text-xl font-semibold tracking-tight text-gray-900">{{ $menu->nama }}</h5>
                        </a>
                        <span class="text-3xl font-bold text-blue-700">
                            Rp. @php echo number_format($menu->harga, 0, ',', '.'); @endphp
                        </span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-4">
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden w-fit">
                            <form action="{{ route('customer.keranjang.add', $menu->id) }}" method="POST">
                                @csrf
                                <button type="button" onclick="decrementQty(this)" 
                                    class="px-3 py-2 text-lg font-bold text-gray-600 hover:bg-gray-200 transition">-</button>
                                <input  type="number" name="quantity" value="1" min="1"
                                    class="qty-input w-12 text-center border-0 focus:ring-0 focus:outline-none text-gray-900">
                                <button type="button" onclick="incrementQty(this)" 
                                    class="px-3 py-2 text-lg font-bold text-gray-600 hover:bg-gray-200 transition">+</button>
                        </div>

                        @if(strtolower($menu->stok) === 'tersedia')
                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                            <button type="submit"
                                class="text-white bg-blue-400 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                Tambah
                            </button>
                            </form>
                        @else
                            <button
                                class="text-white bg-gray-400 cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                disabled>
                                Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($allMenus->isEmpty())
        <div class="flex flex-col w-full items-center justify-center py-10">
            <h1 class="text-gray-600 text-xl font-semibold">
                Tidak ada menu yang tersedia
            </h1>
            <img src="{{ asset('src/images/empty-menu.png') }}" 
                alt="Tidak ada menu" 
                class="w-48 h-48 object-contain mb-4 opacity-80">
        </div>
    @endif
</div>


        <!-- Konten per Kategori -->
        @foreach ($kategoris as $index => $kategori)
            @php $kategoriId = Str::slug($kategori->nama); @endphp
            <div class="kategori-content {{ $index == 0 ? '' : 'hidden' }}" id="kategori-{{ $kategoriId }}">
                <h2 class="text-2xl font-bold text-gray-900 mt-8 ml-4">{{ $kategori->nama }}</h2>
                <div class="px-4 py-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($kategori->menus as $menu)
                        <div data-nama="{{ strtolower($menu->nama) }} " 
                            class="menu-item w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transform transition duration-300 hover:scale-105 hover:-translate-y-1">

                            {{-- 🟡 Icon Best Seller --}}
                            @if (isset($bestSellers) && in_array($menu->id, $bestSellers))
                                <div class="absolute top-3 left-3 bg-yellow-400 text-white text-sm font-semibold px-2 py-1 rounded-full flex items-center gap-1 shadow">
                                     <i class="fas fa-star"></i> Best Seller
                                </div>
                            @endif

                            {{-- 🧑‍🍳 Icon Rekomendasi Chef --}}
                            @if (isset($recommendedMenus) && in_array($menu->id, $recommendedMenus))
                                <div class="absolute top-3 right-3 bg-orange-500 text-white text-sm font-semibold px-2 py-1 rounded-full flex items-center gap-1 shadow">
                                    <i class="fas fa-user-tie"></i> Recomended
                                </div>
                            @endif

                            <a href="{{ route('menu.show', $menu->id) }}" class="cursor-pointer">
                                <img class="p-4 rounded-3xl w-full h-90 aspect-square object-cover"
                                    src="{{ asset($menu->gambar) }}" alt="{{ $menu->nama }}" />
                            </a>
                            <div class="px-5 pb-5">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-5">
                                    <a href="{{ route('menu.show', $menu->id) }}" class="cursor-pointer">
                                        <h5 class="text-xl font-semibold tracking-tight text-gray-900">{{ $menu->nama }}</h5>
                                    </a>
                                    <span class="text-3xl font-bold text-blue-700">
                                       Rp. @php echo number_format($menu->harga, 0, ',', '.'); @endphp
                                    </span>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-4">
                                        <!-- Tombol QTY -->
                                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden w-fit">
                                            <form action="{{ route('customer.keranjang.add', $menu->id) }}" method="POST">
                                            @csrf
                                            <button type="button" onclick="decrementQty(this)" 
                                                class="px-3 py-2 text-lg font-bold text-gray-600 hover:bg-gray-200 transition">-</button>
                                            
                                            <input  type="number" name="quantity" value="1" min="1"
                                                class="qty-input w-12 text-center border-0 focus:ring-0 focus:outline-none text-gray-900">
                                            
                                            <button type="button" onclick="incrementQty(this)" 
                                                class="px-3 py-2 text-lg font-bold text-gray-600 hover:bg-gray-200 transition">+</button>
                                        </div>
                                    @if(strtolower($menu->stok) === 'tersedia')
                                    
                                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                        <button type="submit"
                                            class="text-white bg-blue-400 hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                            Tambah
                                        </button>
                                    </form>
                                    @else
                                        <button
                                            class="text-white bg-gray-400 cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                            disabled>
                                            Habis
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($kategori->menus->isEmpty())
                    <div class="flex flex-col w-full items-center justify-center py-10">
                        <h1 class="text-gray-600 text-xl font-semibold">
                            Tidak ada menu yang tersedia
                        </h1>
                        <img src="{{ asset('src/images/empty-menu.png') }}" 
                            alt="Tidak ada menu" 
                            class="w-48 h-48 object-contain mb-4 opacity-80">
                    </div>
                @endif
            </div>
        @endforeach

        <!-- Toast Container -->
    <div id="toast-container" class="fixed top-5 right-5 space-y-2 z-50"></div>

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

        <!-- Script: Pencarian -->
        <script>
            const searchInput = document.getElementById('searchInput');
            searchInput.addEventListener('input', function() {
                const searchValue = this.value.toLowerCase();
                const menuItems = document.querySelectorAll('.menu-item');
                menuItems.forEach(item => {
                    const namaMenu = item.getAttribute('data-nama');
                    item.style.display = namaMenu.includes(searchValue) ? 'block' : 'none';
                });
            });
        </script>

        <!-- Script: Navigasi Tab -->
        {{-- <script>
            function showCategory(category) {
                document.querySelectorAll('.kategori-content').forEach(el => el.classList.add('hidden'));
                const kategoriEl = document.getElementById('kategori-' + category);
                if (kategoriEl) kategoriEl.classList.remove('hidden');

                document.querySelectorAll('.kategori-tab').forEach(el =>
                    el.classList.remove('text-blue-600', 'bg-gray-100', 'active')
                );
                const tabEl = document.getElementById('tab-' + category);
                if (tabEl) tabEl.classList.add('text-blue-600', 'bg-gray-100', 'active');
            }
        </script> --}}

        <script>
    function showCategory(category) {
        // Sembunyikan semua konten kategori
        document.querySelectorAll('.kategori-content').forEach(el => el.classList.add('hidden'));
        const kategoriEl = document.getElementById('kategori-' + category);
        if (kategoriEl) kategoriEl.classList.remove('hidden');

        // Reset semua tab ke default (putih abu-abu)
        document.querySelectorAll('.kategori-tab').forEach(el => {
            el.classList.remove('bg-blue-400', 'text-white', 'active');
            el.classList.add('bg-white', 'text-gray-600');
        });

        // Aktifkan tab yang dipilih (biru penuh)
        const tabEl = document.getElementById('tab-' + category);
        if (tabEl) {
            tabEl.classList.remove('bg-white', 'text-gray-600');
            tabEl.classList.add('bg-blue-400', 'text-white', 'active');
        }
    }

    // Set tab pertama aktif otomatis saat load
    document.addEventListener('DOMContentLoaded', () => {
        const firstTab = document.querySelector('.kategori-tab');
        if (firstTab) firstTab.click();
    });
</script>

    <!-- Script: Tombol QTY -->
<script>
function incrementQty(btn) {
    let wrapper = btn.parentElement; 
    let qty = wrapper.querySelector(".qty-input");

    qty.value = parseInt(qty.value) + 1;
}

function decrementQty(btn) {
    let wrapper = btn.parentElement;
    let qty = wrapper.querySelector(".qty-input");

    if (parseInt(qty.value) > 1) {
        qty.value = parseInt(qty.value) - 1;
    }
}
</script>

{{-- @php
    $cart = session('cart', []);
    $cartCount = is_array($cart) ? count($cart) : 0;
@endphp

{{ $cartCount }} --}}


<a href="{{ route('customer.keranjang.view') }}"
   class="fixed bottom-6 right-6 z-50
          flex items-center justify-center
          w-20 h-20
          bg-blue-600 hover:bg-blue-700
          text-white
          rounded-full
          shadow-2xl
          transition-transform duration-300
          hover:scale-110">

    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
        <path fill-rule="evenodd"
            d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z"
            clip-rule="evenodd" />
    </svg>

    
</a>




</body>

</html>
