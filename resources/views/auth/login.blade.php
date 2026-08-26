<x-guest-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <div class="flex flex-col flex-1 w-full lg:w-2/5">
        <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto">
            <div class="mb-5 sm:mb-8">
                <h1 class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md">
                    Log in
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Masukkan username dan kata sandi Anda untuk masuk!
                </p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />




            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username -->
                <div>
                    <x-input-label for="username" :value="__('Username')" />
                    <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                        :value="old('username')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <div class="relative mt-1">
                        <x-text-input id="password" class="block w-full pr-10" type="password" name="password" required
                            autocomplete="current-password" />

                        <button type="button" onclick="togglePassword('password', 'eyeIconLogin')"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-blue-600">
                            <i id="eyeIconLogin" class="fas fa-eye"></i>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Ingatkan saya') }}</span>
                    </label>



                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('password.request') }}">
                            {{ __('Lupa kata sandi Anda?') }}
                        </a>
                    @endif

                </div>

                <x-primary-button class="mt-4 w-full">
                    {{ __('Masuk') }}
                </x-primary-button>

            </form>
        </div>

    </div>


    <div class="relative hidden lg:flex lg:w-1/2 bg-[#0F1F3A] overflow-hidden">

<!-- Tulisan -->
<div class="absolute top-16 left-1/2 -translate-x-1/2 text-center w-full px-8 z-10">
    <h1 class="text-3xl font-bold text-[#F8F5ED]">
        Selamat Datang di MUSEWANGI
    </h1>

    <p class="mt-3 text-[#D8CBA8] text-sm">
        Masuk untuk mulai mengelola inventaris museum.
    </p>
</div>

<!-- Gapura -->
<img src="{{ asset('src/images/gapura1.png') }}" alt="Gapura"
    class="absolute bottom-0 left-1/2 -translate-x-1/2 w-2/3 max-w-sm object-contain">

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>

</x-guest-layout>
