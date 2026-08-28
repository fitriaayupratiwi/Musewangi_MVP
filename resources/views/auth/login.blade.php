<x-guest-layout>
    <div class="flex flex-col lg:flex-row w-full min-h-screen bg-[#F8F5ED]">

        <!-- ================= LEFT COLUMN: LOGIN FORM ================= -->
        <div class="flex flex-col justify-center items-center w-full lg:w-1/2 p-6 sm:p-10 lg:p-16">
            <div class="w-full max-w-md space-y-6">

                <!-- LOGO & BRANDING -->
                <div class="flex flex-col items-center text-center space-y-3">
                    <div class="w-20 h-20 rounded-2xl bg-[#162544] p-1.5 shadow-lg border-2 border-[#C9981C] flex items-center justify-center transform hover:scale-105 transition">
                        <img src="{{ asset('favicon.png') }}" alt="Logo Museum Blambangan" class="w-full h-full object-contain rounded-xl">
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#162544] tracking-tight">
                            MUSEWANGI
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-500 font-medium mt-1">
                            Panel Masuk Petugas & Kurator Museum
                        </p>
                    </div>
                </div>

                <!-- SESSION ALERT -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- FORM CARD -->
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-[#E8DCC0] shadow-sm space-y-5">
                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <!-- USERNAME / EMAIL -->
                        <div class="space-y-1.5">
                            <label for="username" class="block text-xs font-bold text-[#162544] uppercase tracking-wider">
                                Username atau Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-user text-xs"></i>
                                </div>
                                <input id="username" type="text" name="username"
                                    value="{{ old('username', 'admin') }}"
                                    placeholder="Ketik username atau email..."
                                    required autofocus autocomplete="username"
                                    class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-[#E8DCC0] bg-[#FAF8F3] text-[#162544] font-medium placeholder-gray-400 focus:bg-white focus:border-[#C9981C] focus:ring-2 focus:ring-[#C9981C]/20 outline-none transition">
                            </div>
                            <x-input-error :messages="$errors->get('username')" class="mt-1 text-xs" />
                        </div>

                        <!-- PASSWORD -->
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-xs font-bold text-[#162544] uppercase tracking-wider">
                                    Kata Sandi
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-[11px] font-bold text-[#C9981C] hover:underline">
                                        Lupa sandi?
                                    </a>
                                @endif
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <i class="fa-solid fa-lock text-xs"></i>
                                </div>
                                <input id="password" type="password" name="password"
                                    placeholder="••••••••"
                                    required autocomplete="current-password"
                                    class="w-full pl-10 pr-11 py-2.5 text-sm rounded-xl border border-[#E8DCC0] bg-[#FAF8F3] text-[#162544] font-medium placeholder-gray-400 focus:bg-white focus:border-[#C9981C] focus:ring-2 focus:ring-[#C9981C]/20 outline-none transition">
                                <button type="button" onclick="togglePasswordVisibility()"
                                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-[#C9981C] transition"
                                    aria-label="Tampilkan kata sandi">
                                    <i id="eyeIcon" class="fa-solid fa-eye text-xs"></i>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
                        </div>

                        <!-- REMEMBER ME -->
                        <div class="flex items-center pt-1">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                                <input id="remember_me" type="checkbox" name="remember" checked
                                    class="w-4 h-4 rounded-md border-gray-300 text-[#C9981C] focus:ring-[#C9981C]">
                                <span class="ms-2 text-xs font-medium text-gray-600">Ingat sesi saya di perangkat ini</span>
                            </label>
                        </div>

                        <!-- SUBMIT BUTTON -->
                        <button type="submit"
                            class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-[#C9981C] to-[#E5B238] hover:from-[#B78921] hover:to-[#D4A028] text-white font-extrabold text-sm shadow-md shadow-[#C9981C]/30 hover:shadow-lg transition transform active:scale-98 flex items-center justify-center gap-2">
                            <span>Masuk ke Panel</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </form>
                </div>

                <!-- BACK TO PUBLIC PAGE -->
                <div class="text-center pt-2">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 text-xs font-bold text-gray-500 hover:text-[#162544] transition">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Kembali ke Halaman Pengunjung / Scan QR</span>
                    </a>
                </div>

            </div>
        </div>

        <!-- ================= RIGHT COLUMN: HERO BANNER (DESKTOP) ================= -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-gradient-to-br from-[#0F1F3A] via-[#162544] to-[#0A162B] p-12 overflow-hidden flex-col justify-between text-white">

            <!-- Background Decorative Ornaments -->
            <div class="absolute -right-24 -top-24 w-96 h-96 rounded-full bg-[#C9981C]/10 blur-3xl pointer-events-none"></div>
            <div class="absolute -left-24 -bottom-24 w-96 h-96 rounded-full bg-[#C9981C]/10 blur-3xl pointer-events-none"></div>

            <!-- Top Header in Banner -->
            <div class="relative z-10 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#C9981C]/20 border border-[#C9981C]/40 flex items-center justify-center text-[#FFD86B]">
                        <i class="fa-solid fa-landmark text-base"></i>
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-[#FFD86B]">Museum Blambangan</div>
                        <div class="text-[11px] text-gray-400">Kabupaten Banyuwangi</div>
                    </div>
                </div>

                <span class="px-3 py-1 rounded-full text-[11px] font-bold bg-white/10 border border-white/20 text-[#FFD86B]">
                    v1.0 MVP
                </span>
            </div>

            <!-- Center Artwork & Quote -->
            <div class="relative z-10 flex flex-col items-center text-center max-w-lg mx-auto my-auto space-y-6">
                <!-- Center Gapura / Emblem Artwork -->
                <div class="w-48 h-48 rounded-full bg-[#162544]/60 border-2 border-[#C9981C]/40 flex items-center justify-center p-4 shadow-2xl backdrop-blur-xs transform hover:scale-105 transition duration-500">
                    <img src="{{ asset('favicon.png') }}" alt="Candi Blambangan" class="w-full h-full object-contain">
                </div>

                <div class="space-y-2">
                    <h2 class="text-2xl font-black text-white tracking-tight">
                        Preservasi & Digitalisasi Budaya
                    </h2>
                    <p class="text-xs sm:text-sm text-[#D8CBA8] leading-relaxed max-w-md">
                        "Melestarikan warisan luhur peradaban Blambangan melalui inventarisasi cerdas dan pemandu digital interaktif."
                    </p>
                </div>
            </div>

            <!-- Footer in Banner -->
            <div class="relative z-10 flex items-center justify-between text-[11px] text-gray-400 border-t border-white/10 pt-4">
                <span>Dinas Kebudayaan & Pariwisata</span>
                <span>© {{ date('Y') }} MUSEWANGI</span>
            </div>

        </div>

    </div>

    <!-- SCRIPT TOGGLE PASSWORD -->
    <script>
        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                pwdInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</x-guest-layout>
