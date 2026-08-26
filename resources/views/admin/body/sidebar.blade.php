<aside id="default-sidebar"
    class="sidebar fixed inset-y-0 top-0 left-0 z-50 w-64 max-w-[256px] h-screen overflow-hidden border-r border-gray-200 bg-[#162544] transform transition-transform duration-300 ease-in-out lg:translate-x-0 dark:border-gray-700 dark:bg-gray-800"
    :class="{
        '-translate-x-full': !sidebarToggle,
        'translate-x-0': sidebarToggle,
        'lg:translate-x-0': true
    }"
    aria-label="Sidebar">

{{-- HEADER --}}
<div class="relative px-3 pt-5 pb-2">
    <button
        @click="sidebarToggle = false"
        class="absolute top-2 right-2 lg:hidden flex h-8 w-8 items-center justify-center rounded-full text-white hover:text-[#FFD86B] transition duration-200"
        aria-label="Close sidebar">

        <svg xmlns="http://www.w3.org/2000/svg"
            width="20"
            height="20"
            viewBox="0 0 24 24"
            fill="currentColor">

            <path d="M6.225 6.225a.75.75 0 011.06 0L12 10.94l4.715-4.715a.75.75 0 111.06 1.06L13.06 12l4.715 4.715a.75.75 0 01-1.06 1.06L12 13.06l-4.715 4.715a.75.75 0 01-1.06-1.06L10.94 12 6.225 7.285a.75.75 0 010-1.06Z" />

        </svg>

    </button>

    <div class="flex items-center gap-3 px-1 py-2">

        {{-- Logo --}}
        <div class="w-[66px] h-[66px] rounded-full overflow-hidden border-2 border-[#C9981C] flex-shrink-0">

            <img
                src="{{ asset('src/images/logo-museum.jpeg') }}"
                alt="Logo MUSEWANGI"
                class="w-full h-full object-cover">

        </div>


        {{-- Tulisan --}}
        <div class="min-w-0">

            <h1 class="text-[17px] font-bold text-[#C9981C] leading-tight whitespace-nowrap">
                MUSEWANGI
            </h1>

            <p class="text-[9px] leading-[12px] text-[#FFD86B] mt-1">
                Museum Blambangan<br>
                Banyuwangi
            </p>

        </div>

    </div>


    {{-- Garis --}}
    <div class="mx-1 mt-2 border-b border-[#C9981C]/70"></div>
</div>

    {{-- MENU --}}
    <div class="h-[calc(100vh-105px)] px-3 py-3 overflow-y-auto scrollbar-hide">

        <ul class="flex flex-col gap-1 font-medium">


            {{-- DASHBOARD --}}
            <li>

                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center p-2 rounded-lg group transition duration-200
                    {{ request()->routeIs('admin.dashboard')
                        ? 'bg-[#C9981C] text-white'
                        : 'text-white hover:bg-[#21365E]' }}">

                    <svg
                        class="shrink-0 w-[18px] h-[18px] transition duration-200
                        {{ request()->routeIs('admin.dashboard')
                            ? 'text-white'
                            : 'text-white group-hover:text-[#FFD86B]' }}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor">

                        <path d="M12 3.2 3.5 10v10.5c0 .8.7 1.5 1.5 1.5h5v-6h4v6h5c.8 0 1.5-.7 1.5-1.5V10L12 3.2Z" />

                    </svg>

                    <span class="ms-3 text-[11px] whitespace-nowrap">
                        Dashboard
                    </span>

                </a>

            </li>


            {{-- KOLEKSI --}}
            <li>

                <a href="{{ route('admin.index') }}"
                    class="flex items-center p-2 rounded-lg group transition duration-200
                    {{ request()->routeIs('admin.koleksi.index')
                        ? 'bg-[#C9981C] text-white'
                        : 'text-white hover:bg-[#21365E]' }}">

                    <svg
                        class="shrink-0 w-[18px] h-[18px] transition duration-200
                        {{ request()->routeIs('admin.koleksi.index')
                            ? 'text-white'
                            : 'text-white group-hover:text-[#FFD86B]' }}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 7h16v13H4V7Z" />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 7l2-3h14l2 3" />

                        <path
                            stroke-linecap="round"
                            d="M8 11h8" />

                    </svg>

                    <span class="ms-3 text-[11px] whitespace-nowrap">
                        Koleksi
                    </span>

                </a>

            </li>


            {{-- KATEGORI --}}
            <li>

                <a href="{{ route('admin.tambah.kategori') }}"
                    class="flex items-center p-2 rounded-lg group transition duration-200
                    {{ request()->routeIs('admin.tambah.kategori')
                        ? 'bg-[#C9981C] text-white'
                        : 'text-white hover:bg-[#21365E]' }}">

                    <svg
                        class="shrink-0 w-[18px] h-[18px] transition duration-200
                        {{ request()->routeIs('admin.tambah.kategori')
                            ? 'text-white'
                            : 'text-white group-hover:text-[#FFD86B]' }}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor">

                        <rect x="4" y="4" width="6" height="6" rx="1" />
                        <rect x="14" y="4" width="6" height="6" rx="1" />
                        <rect x="4" y="14" width="6" height="6" rx="1" />
                        <rect x="14" y="14" width="6" height="6" rx="1" />

                    </svg>

                    <span class="ms-3 text-[11px] whitespace-nowrap">
                        Kategori
                    </span>

                </a>

            </li>


            {{-- QR CODE --}}
            <li>

                <a href="{{ route('admin.qrcode.index') }}"
                    class="flex items-center p-2 rounded-lg group transition duration-200
                    {{ request()->routeIs('admin.qrcode.index')
                        ? 'bg-[#C9981C] text-white'
                        : 'text-white hover:bg-[#21365E]' }}">

                    <svg
                        class="shrink-0 w-[18px] h-[18px] transition duration-200
                        {{ request()->routeIs('admin.qrcode.index')
                            ? 'text-white'
                            : 'text-white group-hover:text-[#FFD86B]' }}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor">

                        <path d="M4 4h6v6H4V4Zm2 2v2h2V6H6Zm8-2h6v6h-6V4Zm2 2v2h2V6h-2ZM4 14h6v6H4v-6Zm2 2v2h2v-2H6Zm8-2h2v2h-2v-2Zm4 0h2v2h-2v-2Zm-4 4h2v2h-2v-2Zm4 0h2v-2h-2v2Zm-4-8h2v2h-2v-2Zm4 0h2v2h-2v-2Z" />

                    </svg>

                    <span class="ms-3 text-[11px] whitespace-nowrap">
                        QR Code
                    </span>

                </a>

            </li>


            {{-- RIWAYAT --}}
            <li>

                <a href="{{ route('admin.riwayat') }}"
                    class="flex items-center p-2 rounded-lg group transition duration-200
                    {{ request()->routeIs('admin.riwayat')
                        ? 'bg-[#C9981C] text-white'
                        : 'text-white hover:bg-[#21365E]' }}">

                    <svg
                        class="shrink-0 w-[18px] h-[18px] transition duration-200
                        {{ request()->routeIs('admin.riwayat')
                            ? 'text-white'
                            : 'text-white group-hover:text-[#FFD86B]' }}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 12a9 9 0 1 0 3-7" />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 4v5h5" />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 7v5l3 2" />

                    </svg>

                    <span class="ms-3 text-[11px] whitespace-nowrap">
                        Riwayat
                    </span>

                </a>

            </li>


            {{-- AKUN ADMIN --}}
            <li>

                <a href="{{ route('admin.kelolaadmin') }}"
                    class="flex items-center p-2 rounded-lg group transition duration-200
                    {{ request()->routeIs('admin.kelolaadmin')
                        ? 'bg-[#C9981C] text-white'
                        : 'text-white hover:bg-[#21365E]' }}">

                    <svg
                        class="shrink-0 w-[18px] h-[18px] transition duration-200
                        {{ request()->routeIs('admin.kelolaadmin')
                            ? 'text-white'
                            : 'text-white group-hover:text-[#FFD86B]' }}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">

                        <circle cx="9" cy="8" r="3" />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 20a6 6 0 0 1 12 0" />

                        <circle cx="17" cy="16" r="3" />

                        <path
                            stroke-linecap="round"
                            d="M17 14v4M15 16h4" />

                    </svg>

                    <span class="ms-3 text-[11px] whitespace-nowrap">
                        Pengguna
                    </span>

                </a>

            </li>

        </ul>

    </div>


    {{-- GAPURA --}}
    <div class="absolute left-0 bottom-[62px] w-full pointer-events-none z-10">

        <img
            src="{{ asset('src/images/gapura1.png') }}"
            alt="Ilustrasi Gapura Banyuwangi"
            class="block w-full h-auto object-contain object-bottom">

    </div>


    {{-- FOOTER --}}
    <div
        class="absolute bottom-0 left-0 w-full h-[62px] z-20
        bg-[#162544]
        border-t border-[#C9981C]/50
        flex flex-col items-center justify-center">

        <p class="text-[10px] font-semibold text-white leading-tight">
            © 2026 MUSEWANGI
        </p>

        <p class="text-[7px] text-white/80 mt-1 leading-tight">
            Sistem Informasi Museum Banyuwangi
        </p>

    </div>

</aside>