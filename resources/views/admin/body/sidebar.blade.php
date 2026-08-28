<aside id="default-sidebar"
    class="sidebar fixed inset-y-0 top-0 left-0 z-50 w-64 max-w-[256px] h-screen overflow-hidden border-r border-gray-200 bg-[#162544] transform transition-transform duration-300 ease-in-out lg:translate-x-0 dark:border-gray-700 dark:bg-gray-800"
    :class="{
        '-translate-x-full': !sidebarToggle,
        'translate-x-0': sidebarToggle,
        'lg:translate-x-0': true
    }"
    aria-label="Sidebar">

    {{-- HEADER SIDEBAR --}}
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
                <path d="M6.225 6.225a.75.75 0 011.06 0L12 10.94l4.715-4.715a.75.75 0 111.06 1.06L13.06 12l4.715 4.715a.75.75 0 11-1.06 1.06L12 13.06l-4.715 4.715a.75.75 0 11-1.06-1.06L10.94 12 6.225 7.285a.75.75 0 010-1.06Z" />
            </svg>
        </button>

        <div class="flex items-center gap-3 px-1 py-2">
            {{-- Logo Museum --}}
            <div class="w-[60px] h-[60px] rounded-full overflow-hidden border-2 border-[#C9981C] flex-shrink-0 shadow">
                <img
                    src="{{ asset('src/images/logo-museum.jpeg') }}"
                    alt="Logo MUSEWANGI"
                    class="w-full h-full object-cover">
            </div>

            {{-- Brand Title --}}
            <div class="min-w-0">
                <h1 class="text-[17px] font-extrabold text-[#C9981C] leading-tight whitespace-nowrap tracking-wide">
                    MUSEWANGI
                </h1>
                <p class="text-[10px] leading-[13px] text-[#FFD86B] mt-1 font-medium">
                    Museum Blambangan<br>
                    Banyuwangi
                </p>
            </div>
        </div>

        {{-- Divider --}}
        <div class="mx-1 mt-2 border-b border-[#C9981C]/50"></div>
    </div>

    {{-- MENU LIST --}}
    <div class="h-[calc(100vh-105px)] px-3 py-3 overflow-y-auto scrollbar-hide">
        <ul class="flex flex-col gap-1.5 font-medium">

            {{-- DASHBOARD --}}
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center p-2.5 rounded-xl group transition duration-200
                    {{ request()->routeIs('admin.dashboard')
                        ? 'bg-[#C9981C] text-white shadow-sm'
                        : 'text-white/90 hover:bg-[#21365E] hover:text-white' }}">

                    <svg
                        class="shrink-0 w-5 h-5 transition duration-200
                        {{ request()->routeIs('admin.dashboard')
                            ? 'text-white'
                            : 'text-white/80 group-hover:text-[#FFD86B]' }}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor">
                        <path d="M12 3.2 3.5 10v10.5c0 .8.7 1.5 1.5 1.5h5v-6h4v6h5c.8 0 1.5-.7 1.5-1.5V10L12 3.2Z" />
                    </svg>

                    <span class="ms-3 text-xs tracking-wide">
                        Dashboard
                    </span>
                </a>
            </li>

            {{-- KOLEKSI --}}
            <li>
                <a href="{{ route('admin.koleksi.index') }}"
                    class="flex items-center p-2.5 rounded-xl group transition duration-200
                    {{ request()->routeIs('admin.koleksi.*') || request()->routeIs('admin.index')
                        ? 'bg-[#C9981C] text-white shadow-sm'
                        : 'text-white/90 hover:bg-[#21365E] hover:text-white' }}">

                    <svg
                        class="shrink-0 w-5 h-5 transition duration-200
                        {{ request()->routeIs('admin.koleksi.*') || request()->routeIs('admin.index')
                            ? 'text-white'
                            : 'text-white/80 group-hover:text-[#FFD86B]' }}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16v13H4V7Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l2-3h14l2 3" />
                        <path stroke-linecap="round" d="M8 11h8" />
                    </svg>

                    <span class="ms-3 text-xs tracking-wide">
                        Koleksi
                    </span>
                </a>
            </li>

            {{-- KATEGORI --}}
            <li>
                <a href="{{ route('admin.kategori.index') }}"
                    class="flex items-center p-2.5 rounded-xl group transition duration-200
                    {{ request()->routeIs('admin.kategori.*') || request()->routeIs('admin.tambah.kategori') || request()->routeIs('admin.edit.kategori')
                        ? 'bg-[#C9981C] text-white shadow-sm'
                        : 'text-white/90 hover:bg-[#21365E] hover:text-white' }}">

                    <svg
                        class="shrink-0 w-5 h-5 transition duration-200
                        {{ request()->routeIs('admin.kategori.*') || request()->routeIs('admin.tambah.kategori') || request()->routeIs('admin.edit.kategori')
                            ? 'text-white'
                            : 'text-white/80 group-hover:text-[#FFD86B]' }}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor">
                        <rect x="4" y="4" width="6" height="6" rx="1" />
                        <rect x="14" y="4" width="6" height="6" rx="1" />
                        <rect x="4" y="14" width="6" height="6" rx="1" />
                        <rect x="14" y="14" width="6" height="6" rx="1" />
                    </svg>

                    <span class="ms-3 text-xs tracking-wide">
                        Kategori
                    </span>
                </a>
            </li>

            {{-- QR CODE --}}
            <li>
                <a href="{{ route('admin.qrcode.index') }}"
                    class="flex items-center p-2.5 rounded-xl group transition duration-200
                    {{ request()->routeIs('admin.qrcode.*')
                        ? 'bg-[#C9981C] text-white shadow-sm'
                        : 'text-white/90 hover:bg-[#21365E] hover:text-white' }}">

                    <svg
                        class="shrink-0 w-5 h-5 transition duration-200
                        {{ request()->routeIs('admin.qrcode.*')
                            ? 'text-white'
                            : 'text-white/80 group-hover:text-[#FFD86B]' }}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="currentColor">
                        <path d="M4 4h6v6H4V4Zm2 2v2h2V6H6Zm8-2h6v6h-6V4Zm2 2v2h2V6h-2ZM4 14h6v6H4v-6Zm2 2v2h2v-2H6Zm8-2h2v2h-2v-2Zm4 0h2v2h-2v-2Zm-4 4h2v2h-2v-2Zm4 0h2v-2h-2v2Zm-4-8h2v2h-2v-2Zm4 0h2v2h-2v-2Z" />
                    </svg>

                    <span class="ms-3 text-xs tracking-wide">
                        QR Code
                    </span>
                </a>
            </li>

            {{-- ULASAN PENGUNJUNG --}}
            @php
                $pendingReviewsCount = \App\Models\CollectionReview::where('status', 'pending')->count();
            @endphp
            <li>
                <a href="{{ route('admin.ulasan.index') }}"
                    class="flex items-center justify-between p-2.5 rounded-xl group transition duration-200
                    {{ request()->routeIs('admin.ulasan.*')
                        ? 'bg-[#C9981C] text-white shadow-sm'
                        : 'text-white/90 hover:bg-[#21365E] hover:text-white' }}">

                    <div class="flex items-center">
                        <svg
                            class="shrink-0 w-5 h-5 transition duration-200
                            {{ request()->routeIs('admin.ulasan.*')
                                ? 'text-white'
                                : 'text-white/80 group-hover:text-[#FFD86B]' }}"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor">
                            <path fill-rule="evenodd" d="M4.804 21.644A6.707 6.707 0 0 0 6 21.75a6.721 6.721 0 0 0 3.583-1.029c.774.182 1.584.279 2.417.279 5.322 0 9.75-3.97 9.75-9 0-5.03-4.428-9-9.75-9s-9.75 3.97-9.75 9c0 2.409 1.025 4.587 2.674 6.192.232.226.277.428.254.543a3.73 3.73 0 0 1-.814 1.686.75.75 0 0 0 .44 1.223ZM8.25 10.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm4.5 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Zm4.5 0a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" clip-rule="evenodd" />
                        </svg>

                        <span class="ms-3 text-xs tracking-wide">
                            Ulasan
                        </span>
                    </div>

                    @if($pendingReviewsCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-500 text-white shadow-xs animate-pulse">
                            {{ $pendingReviewsCount }}
                        </span>
                    @endif
                </a>
            </li>

            {{-- RIWAYAT --}}
            <li>
                <a href="{{ route('admin.riwayat') }}"
                    class="flex items-center p-2.5 rounded-xl group transition duration-200
                    {{ request()->routeIs('admin.riwayat*')
                        ? 'bg-[#C9981C] text-white shadow-sm'
                        : 'text-white/90 hover:bg-[#21365E] hover:text-white' }}">

                    <svg
                        class="shrink-0 w-5 h-5 transition duration-200
                        {{ request()->routeIs('admin.riwayat*')
                            ? 'text-white'
                            : 'text-white/80 group-hover:text-[#FFD86B]' }}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12a9 9 0 1 0 3-7" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4v5h5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                    </svg>

                    <span class="ms-3 text-xs tracking-wide">
                        Riwayat
                    </span>
                </a>
            </li>

            {{-- AKUN ADMIN / PENGGUNA --}}
            <li>
                <a href="{{ route('admin.kelolaadmin') }}"
                    class="flex items-center p-2.5 rounded-xl group transition duration-200
                    {{ request()->routeIs('admin.kelolaadmin*')
                        ? 'bg-[#C9981C] text-white shadow-sm'
                        : 'text-white/90 hover:bg-[#21365E] hover:text-white' }}">

                    <svg
                        class="shrink-0 w-5 h-5 transition duration-200
                        {{ request()->routeIs('admin.kelolaadmin*')
                            ? 'text-white'
                            : 'text-white/80 group-hover:text-[#FFD86B]' }}"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <circle cx="9" cy="8" r="3" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 20a6 6 0 0 1 12 0" />
                        <circle cx="17" cy="16" r="3" />
                        <path stroke-linecap="round" d="M17 14v4M15 16h4" />
                    </svg>

                    <span class="ms-3 text-xs tracking-wide">
                        Pengguna
                    </span>
                </a>
            </li>

            {{-- LOGOUT / KELUAR --}}
            <li class="pt-2 mt-2 border-t border-white/10">
                <button type="button" onclick="handleLogout()"
                    class="flex w-full items-center p-2.5 rounded-xl text-red-400 hover:bg-red-500/15 hover:text-red-300 transition duration-200 text-left">
                    <svg class="shrink-0 w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                    </svg>
                    <span class="ms-3 text-xs tracking-wide font-bold">
                        Keluar / Sign Out
                    </span>
                </button>
            </li>

        </ul>
    </div>

    {{-- ILUSTRASI GAPURA / BATIK BANYUWANGI --}}
    <div class="absolute left-0 bottom-[60px] w-full pointer-events-none z-10 opacity-70">
        <img
            src="{{ asset('src/images/gapura1.png') }}"
            alt="Ilustrasi Gapura Banyuwangi"
            class="block w-full h-auto object-contain object-bottom">
    </div>

    {{-- FOOTER SIDEBAR --}}
    <div
        class="absolute bottom-0 left-0 w-full h-[60px] z-20
        bg-[#162544]
        border-t border-[#C9981C]/40
        flex flex-col items-center justify-center">

        <p class="text-[11px] font-bold text-[#FFD86B] leading-tight">
            &copy; 2026 MUSEWANGI
        </p>
        <p class="text-[9px] text-white/70 mt-0.5 leading-tight">
            Sistem Informasi Museum Banyuwangi
        </p>
    </div>

</aside>