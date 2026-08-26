<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin MUSEWANGI | Edit Admin</title>

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
    x-data="{sidebarToggle:false}"
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


   {{-- TITLE --}}
<div class="mb-8">

    <h1 class="text-3xl font-bold text-[#162544]">
        Edit Admin
    </h1>

    <div class="text-sm text-gray-500 mt-2 flex items-center gap-2">

        <a href="{{ route('admin.kelolaadmin') }}"
            class="hover:text-[#C9981C] transition">
            Kelola Admin
        </a>

        <span>></span>

        <span class="text-[#C9981C] font-medium">
            Edit
        </span>

    </div>

</div>


        {{-- FORM --}}
        <form
            action="{{ route('admin.update.admin', $admin->id) }}"
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

            @method('PUT')



            {{-- ADMIN HEADER --}}
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

                    {{ strtoupper(substr($admin->name, 0, 1)) }}

                </div>


                {{-- ADMIN NAME --}}
                <div>

                    <h2 class="text-base font-bold text-[#162544]">

                        {{ $admin->name }}

                    </h2>

                    <p class="text-xs text-gray-500 mt-0.5">

                        Administrator MUSEWANGI

                    </p>

                </div>

            </div>



            {{-- FORM GRID --}}
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
                            value="{{ old('name', $admin->name) }}"
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
                            value="{{ old('username', $admin->username) }}"
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
                            value="{{ old('email', $admin->email) }}"
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
                            disabled
                            class="
                                w-full
                                mt-2
                                border
                                border-[#C9981C]
                                rounded-lg
                                p-3
                                text-sm
                                bg-gray-50
                                text-gray-500
                                outline-none
                            "
                        >

                            <option value="admin" selected>

                                Admin

                            </option>

                        </select>


                        <p class="text-xs text-gray-400 mt-1.5">

                            Role administrator tidak dapat diubah.

                        </p>

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

                            Ubah Password

                        </h3>


                        <p class="text-xs text-gray-500 mt-1 mb-5">

                            Kosongkan jika tidak ingin mengubah password.

                        </p>



                        {{-- PASSWORD BARU --}}
                        <div class="mb-5">

                            <label
                                for="password"
                                class="
                                    font-semibold
                                    text-[#162544]
                                    text-sm
                                "
                            >

                                Password Baru

                            </label>


                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan password baru"
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

                                Konfirmasi Password Baru

                            </label>


                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Ulangi password baru"
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
                            >

                        </div>

                    </div>



                    {{-- INFO PASSWORD --}}
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

                                    Password hanya akan diperbarui jika
                                    kolom password diisi. Jika kosong,
                                    password lama tetap digunakan.

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            {{-- BUTTON --}}
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

                    Simpan Perubahan

                </button>

            </div>


        </form>

    </div>

</main>


</body>

</html>