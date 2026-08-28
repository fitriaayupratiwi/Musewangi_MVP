```blade
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Favicon HD Multi-Resolution -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=5">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=5">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=5">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=5">

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin MUSEWANGI | Tambah Admin</title>


    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    {{-- Icon --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    >


    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body
    x-data="{ sidebarToggle:false }"
    class="bg-[#F8F5ED]"
>


    {{-- SIDEBAR --}}
    @include('admin.body.sidebar')


    {{-- OVERLAY MOBILE --}}
    <div
        x-show="sidebarToggle"
        @click="sidebarToggle=false"
        class="fixed inset-0 bg-black/50 z-40 lg:hidden"
    ></div>


    {{-- HEADER --}}
    @include('admin.body.header')


    {{-- CONTENT --}}
    <main class="pt-24 lg:ml-64 p-5">

        <div class="max-w-7xl mx-auto">


            {{-- ========================================= --}}
            {{-- TITLE --}}
            {{-- ========================================= --}}

            <div class="mb-8">

                <h1 class="text-3xl font-bold text-[#162544]">
                    Tambah Admin
                </h1>


                <div class="text-sm text-gray-500 mt-2 flex items-center gap-2">

                    <a
                        href="{{ route('admin.kelolaadmin') }}"
                        class="hover:text-[#C9981C] transition"
                    >
                        Kelola Admin
                    </a>


                    <span>></span>


                    <span class="text-[#C9981C] font-medium">
                        Tambah
                    </span>

                </div>

            </div>



            {{-- ========================================= --}}
            {{-- FORM --}}
            {{-- ========================================= --}}

            <form
                action="{{ route('admin.kelolaadmin.tambah') }}"
                method="POST"
                class="
                    bg-white
                    rounded-2xl
                    shadow-lg
                    border
                    border-[#E8DCC0]
                    p-8
                "
            >

                @csrf



                {{-- ========================================= --}}
                {{-- ADMIN HEADER --}}
                {{-- ========================================= --}}

                <div
                    class="
                        flex
                        items-center
                        gap-3
                        pb-5
                        mb-6
                        border-b
                        border-[#E8DCC0]
                    "
                >


                    {{-- AVATAR --}}
                    <div
                        class="
                            w-12
                            h-12
                            rounded-xl
                            bg-[#E8DCC0]
                            text-[#162544]
                            flex
                            items-center
                            justify-center
                            text-base
                            font-bold
                            flex-shrink-0
                        "
                    >

                        <i class="fa-solid fa-user-plus"></i>

                    </div>



                    {{-- ADMIN NAME --}}
                    <div>

                        <h2 class="text-base font-bold text-[#162544]">
                            Admin Baru
                        </h2>

                        <p class="text-xs text-gray-500 mt-0.5">
                            Administrator MUSEWANGI
                        </p>

                    </div>

                </div>



                {{-- ========================================= --}}
                {{-- FORM GRID --}}
                {{-- ========================================= --}}

                <div class="grid grid-cols-2 gap-10">


                    {{-- ========================================= --}}
                    {{-- LEFT COLUMN --}}
                    {{-- ========================================= --}}

                    <div>


                        {{-- NAMA LENGKAP --}}
                        <div class="mb-5">

                            <label
                                for="name"
                                class="
                                    font-semibold
                                    text-[#162544]
                                    text-sm
                                "
                            >
                                Nama Lengkap
                            </label>


                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Masukkan nama lengkap"
                                class="
                                    w-full
                                    mt-2
                                    border
                                    border-[#C9981C]
                                    rounded-lg
                                    p-3
                                    text-sm
                                    outline-none
                                    focus:border-[#C9981C]
                                    focus:ring-2
                                    focus:ring-[#C9981C]/20
                                "
                                required
                            >


                            @error('name')

                                <p class="text-xs text-red-500 mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>



                        {{-- USERNAME --}}
                        <div class="mb-5">

                            <label
                                for="username"
                                class="
                                    font-semibold
                                    text-[#162544]
                                    text-sm
                                "
                            >
                                Username
                            </label>


                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                placeholder="Masukkan username"
                                class="
                                    w-full
                                    mt-2
                                    border
                                    border-[#C9981C]
                                    rounded-lg
                                    p-3
                                    text-sm
                                    outline-none
                                    focus:border-[#C9981C]
                                    focus:ring-2
                                    focus:ring-[#C9981C]/20
                                "
                                required
                            >


                            @error('username')

                                <p class="text-xs text-red-500 mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>



                        {{-- EMAIL --}}
                        <div class="mb-5">

                            <label
                                for="email"
                                class="
                                    font-semibold
                                    text-[#162544]
                                    text-sm
                                "
                            >
                                Email
                            </label>


                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="admin@gmail.com"
                                class="
                                    w-full
                                    mt-2
                                    border
                                    border-[#C9981C]
                                    rounded-lg
                                    p-3
                                    text-sm
                                    outline-none
                                    focus:border-[#C9981C]
                                    focus:ring-2
                                    focus:ring-[#C9981C]/20
                                "
                                required
                            >


                            @error('email')

                                <p class="text-xs text-red-500 mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>



                        {{-- ROLE --}}
                        <div>

                            <label
                                for="role"
                                class="
                                    font-semibold
                                    text-[#162544]
                                    text-sm
                                "
                            >
                                Role
                            </label>


                            <select
                                id="role"
                                name="role"
                                class="
                                    w-full
                                    mt-2
                                    border
                                    border-[#C9981C]
                                    rounded-lg
                                    p-3
                                    text-sm
                                    bg-white
                                    text-[#162544]
                                    outline-none
                                    focus:border-[#C9981C]
                                    focus:ring-2
                                    focus:ring-[#C9981C]/20
                                "
                                required
                            >

                                <option value="admin" selected>
                                    Admin
                                </option>

                            </select>


                            <p class="text-xs text-gray-400 mt-1.5">
                                Role administrator digunakan untuk mengelola sistem MUSEWANGI.
                            </p>


                            @error('role')

                                <p class="text-xs text-red-500 mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>

                    </div>



                    {{-- ========================================= --}}
                    {{-- RIGHT COLUMN --}}
                    {{-- ========================================= --}}

                    <div>


                        {{-- PASSWORD --}}
                        <div>

                            <h3
                                class="
                                    font-semibold
                                    text-[#162544]
                                    text-sm
                                "
                            >
                                Password
                            </h3>


                            <p class="text-xs text-gray-500 mt-1 mb-5">
                                Buat password untuk akun administrator baru.
                            </p>



                            {{-- PASSWORD --}}
                            <div class="mb-5">

                                <label
                                    for="password"
                                    class="
                                        font-semibold
                                        text-[#162544]
                                        text-sm
                                    "
                                >
                                    Password
                                </label>


                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Masukkan password"
                                    class="
                                        w-full
                                        mt-2
                                        border
                                        border-[#C9981C]
                                        rounded-lg
                                        p-3
                                        text-sm
                                        outline-none
                                        focus:border-[#C9981C]
                                        focus:ring-2
                                        focus:ring-[#C9981C]/20
                                    "
                                    required
                                >


                                @error('password')

                                    <p class="text-xs text-red-500 mt-1">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>



                            {{-- KONFIRMASI PASSWORD --}}
                            <div>

                                <label
                                    for="password_confirmation"
                                    class="
                                        font-semibold
                                        text-[#162544]
                                        text-sm
                                    "
                                >
                                    Konfirmasi Password
                                </label>


                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Ulangi password"
                                    class="
                                        w-full
                                        mt-2
                                        border
                                        border-[#C9981C]
                                        rounded-lg
                                        p-3
                                        text-sm
                                        outline-none
                                        focus:border-[#C9981C]
                                        focus:ring-2
                                        focus:ring-[#C9981C]/20
                                    "
                                    required
                                >

                            </div>

                        </div>



                        {{-- ========================================= --}}
                        {{-- INFO --}}
                        {{-- ========================================= --}}

                        <div
                            class="
                                mt-6
                                bg-[#FAF8F2]
                                border
                                border-[#E8DCC0]
                                rounded-lg
                                p-4
                            "
                        >

                            <div class="flex items-start gap-3">

                                <i
                                    class="
                                        fa-solid
                                        fa-circle-info
                                        text-[#C9981C]
                                        mt-0.5
                                    "
                                ></i>


                                <div>

                                    <p
                                        class="
                                            text-xs
                                            font-semibold
                                            text-[#162544]
                                        "
                                    >
                                        Informasi
                                    </p>


                                    <p
                                        class="
                                            text-xs
                                            text-gray-500
                                            mt-1
                                            leading-relaxed
                                        "
                                    >
                                        Pastikan data admin yang dimasukkan
                                        sudah benar. Password akan digunakan
                                        untuk masuk ke halaman administrator
                                        MUSEWANGI.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- ========================================= --}}
                {{-- BUTTON --}}
                {{-- ========================================= --}}

                <div
                    class="
                        mt-8
                        pt-5
                        border-t
                        border-[#E8DCC0]
                        flex
                        justify-end
                        gap-3
                    "
                >


                    {{-- BATAL --}}
                    <a
                        href="{{ route('admin.kelolaadmin') }}"
                        class="
                            border
                            border-gray-300
                            hover:bg-gray-100
                            px-5
                            py-3
                            rounded-lg
                            shadow-sm
                            text-sm
                            transition
                        "
                    >
                        Batal
                    </a>



                    {{-- SIMPAN --}}
                    <button
                        type="submit"
                        class="
                            bg-[#162544]
                            hover:bg-[#0F1930]
                            text-white
                            px-5
                            py-3
                            rounded-lg
                            shadow
                            flex
                            items-center
                            gap-2
                            text-sm
                            transition
                        "
                    >

                        <i class="fa fa-save"></i>

                        Simpan Admin

                    </button>

                </div>


            </form>

        </div>

    </main>


</body>

</html>
```
