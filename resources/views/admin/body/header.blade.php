<header
    class="fixed
           top-0
           right-0
           z-30
           w-full
           border-b
           border-[#E8DCC0]
           bg-[#F8F5ED]"
>
    <div
        class="flex
               h-20
               items-center
               justify-between
               px-5
               lg:ml-64
               lg:px-8"
    >
        <!-- ================= LEFT HEADER ================= -->
        <div class="flex items-center gap-3">
            <!-- BURGER BUTTON (MOBILE & TABLET) -->
            <button
                @click="sidebarToggle = !sidebarToggle"
                class="lg:hidden
                       flex
                       h-10
                       w-10
                       items-center
                       justify-center
                       rounded-lg
                       text-[#162544]
                       hover:bg-[#E9DEC7]
                       hover:text-[#C9981C]
                       transition"
                aria-label="Toggle Sidebar"
            >
                <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>
            </button>

            <!-- BREADCRUMB / PAGE TITLE INDICATOR -->
            <div class="hidden sm:flex items-center gap-2 text-xs text-gray-500 font-medium">
                <span class="text-[#162544] font-bold">Admin Panel</span>
                <span class="text-gray-300">/</span>
                <span class="text-[#C9981C] font-semibold">
                    @if(request()->routeIs('admin.dashboard'))
                        Dashboard
                    @elseif(request()->routeIs('admin.koleksi.*') || request()->routeIs('admin.index'))
                        Kelola Koleksi
                    @elseif(request()->routeIs('admin.kategori.*') || request()->routeIs('admin.tambah.kategori'))
                        Kategori Koleksi
                    @elseif(request()->routeIs('admin.qrcode.*'))
                        QR Code Koleksi
                    @elseif(request()->routeIs('admin.riwayat*'))
                        Riwayat Aktivitas
                    @elseif(request()->routeIs('admin.kelolaadmin*'))
                        Kelola Pengguna
                    @elseif(request()->routeIs('admin.ulasan.*'))
                        Moderasi Ulasan
                    @else
                        Musewangi
                    @endif
                </span>
            </div>
        </div>

        <!-- ================= RIGHT HEADER ================= -->
        <div class="flex items-center gap-4">

            <!-- USER MENU -->
            <div
                class="relative"
                x-data="{ dropdownOpen: false }"
                @click.outside="dropdownOpen = false"
            >
                <button
                    type="button"
                    class="flex items-center gap-3 rounded-full focus:outline-none"
                    @click.prevent="dropdownOpen = !dropdownOpen"
                >
                    <!-- AVATAR -->
                    <span class="h-11 w-11 overflow-hidden rounded-full border-2 border-[#C9981C] flex-shrink-0 shadow-sm">
                        <img
                            src="{{ asset('src/avatar/avatar.jpg') }}"
                            alt="User Avatar"
                            class="h-full w-full object-cover"
                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=162544&color=FFD86B'"
                        >
                    </span>

                    <!-- USER TEXT -->
                    <span class="hidden md:flex flex-col text-left leading-tight">
                        <span class="text-sm font-bold text-[#162544]">
                            {{ Auth::user()->name ?? 'Administrator' }}
                        </span>
                        <span class="text-[11px] font-medium text-[#C9981C]">
                            Admin Musewangi
                        </span>
                    </span>

                    <!-- ARROW -->
                    <svg
                        :class="dropdownOpen && 'rotate-180'"
                        class="h-4 w-4 text-[#162544] transition-transform flex-shrink-0"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6" />
                    </svg>
                </button>

                <!-- DROPDOWN -->
                <div
                    x-show="dropdownOpen"
                    x-transition
                    class="absolute right-0 z-50 mt-3 w-64 rounded-2xl border border-[#E8DCC0] bg-white p-3 shadow-xl"
                >
                    <div class="px-3 py-2 border-b border-gray-100">
                        <p class="text-sm font-bold text-[#162544]">
                            {{ Auth::user()->name ?? 'Admin' }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">
                            {{ Auth::user()->email ?? 'admin@musewangi.banyuwangi.go.id' }}
                        </p>
                    </div>

                    <!-- KELOLA AKUN -->
                    <a
                        href="{{ route('admin.kelolaadmin') }}"
                        class="mt-2 flex w-full items-center gap-3 rounded-xl px-3 py-2 text-xs font-semibold text-[#162544] hover:bg-[#F8F5ED] hover:text-[#C9981C] transition"
                    >
                        <i class="fa-solid fa-user-gear text-sm text-[#C9981C]"></i>
                        Kelola Pengguna
                    </a>

                    <!-- SIGN OUT -->
                    <button
                        id="signoutBtn"
                        type="button"
                        class="mt-1 flex w-full items-center gap-3 rounded-xl px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 transition"
                    >
                        <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                        Sign Out
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- LOGOUT FORM -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <script>
        document.getElementById("signoutBtn")?.addEventListener("click", function () {
            Swal.fire({
                title: "Yakin ingin keluar?",
                text: "Sesi login Anda akan berakhir.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#C9981C",
                cancelButtonColor: "#6B7280",
                confirmButtonText: "Ya, Keluar",
                cancelButtonText: "Batal",
                reverseButtons: true,
                customClass: {
                    popup: "rounded-2xl shadow-xl border border-[#E8DCC0]"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        });
    </script>
</header>