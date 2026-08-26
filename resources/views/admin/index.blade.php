<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin MUSEWANGI | Kelola Admin</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Icon -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body
    x-data="{sidebarToggle:false}"
    class="bg-[#F8F5ED] font-['Plus_Jakarta_Sans']">

@include('admin.body.sidebar')

<div
    x-show="sidebarToggle"
    @click="sidebarToggle=false"
    class="fixed inset-0 bg-black/50 z-40 lg:hidden">
</div>

@include('admin.body.header')

<main class="pt-24 lg:ml-64 p-5">
    <div class="mx-auto max-w-6xl">

{{-- TITLE SECTION --}}
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

    <div>
        <h1 class="text-3xl font-bold text-[#162544]">
            Daftar Pengguna
        </h1>

        <p class="text-gray-500 mt-2">
            Kelola semua akun administrator sistem MUSEWANGI, tambah, ubah, atau hapus data admin.
        </p>
    </div>

<button
    type="button"
    onclick="openModal()"
    class="
        bg-[#C9981C]
        hover:bg-[#A77C14]
        text-white
        px-5
        py-3
        rounded-lg
        shadow
        flex
        items-center
        gap-2
        transition
    "
>
    <i class="fa fa-plus"></i>

    Tambah Pengguna
</button>

</div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

        <div
            class="bg-[#1D2745] rounded-2xl p-5 shadow">

            <p class="text-xs uppercase tracking-wider text-yellow-300">

                Total Admin

            </p>

            <h2 class="text-3xl font-bold text-white mt-2">

                {{ $users->count() }}

            </h2>

        </div>

        <div
            class="bg-[#8C6315] rounded-2xl p-5 shadow">

            <p class="text-xs uppercase tracking-wider text-yellow-200">

                Administrator Aktif

            </p>

            <h2 class="text-3xl font-bold text-white mt-2">

                {{ $users->count() }}

            </h2>

        </div>

        <div
            class="bg-[#25543C] rounded-2xl p-5 shadow">

            <p class="text-xs uppercase tracking-wider text-green-200">

                Sistem

            </p>

            <h2 class="text-3xl font-bold text-white mt-2">

                MUSEWANGI

            </h2>

        </div>

    </div>

{{-- CARD DAFTAR ADMIN --}}
<div
    class="
        bg-white
        rounded-2xl
        shadow-lg
        overflow-hidden
        border
        border-[#E8DCC0]
    "
>

    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            {{-- TABLE HEADER --}}
            <thead
                class="
                    bg-[#E9DEC7]
                    text-[#162544]
                "
            >
                <tr>
                    <th class="px-6 py-4 text-left">
                        No
                    </th>

                    <th class="px-6 py-4 text-left">
                        Nama
                    </th>

                    <th class="px-6 py-4 text-left">
                        Username
                    </th>

                    <th class="px-6 py-4 text-left">
                        Email
                    </th>

                    <th class="px-6 py-4 text-left">
                        Role
                    </th>

                    <th class="px-6 py-4 text-center">
                        Aksi
                    </th>
                </tr>
            </thead>

            {{-- TABLE BODY --}}
            <tbody>

                @forelse($users as $user)

                <tr
                    class="
                        border-b
                        hover:bg-[#faf7ef]
                        transition
                    "
                >
                    {{-- NO --}}
                    <td class="px-6 py-4 text-gray-600">
                        {{ $loop->iteration }}
                    </td>

                    {{-- NAMA --}}
                    <td class="px-6 py-4">

                        <div class="flex items-center gap-3">

                            <div
                                class="
                                    w-12
                                    h-12
                                    rounded-lg
                                    bg-[#E8DCC0]
                                    text-[#162544]
                                    flex
                                    items-center
                                    justify-center
                                    font-bold
                                "
                            >
                                {{ strtoupper(substr($user->name,0,1)) }}
                            </div>

                            <div>
                                <div class="font-semibold text-[#162544]">
                                    {{ $user->name }}
                                </div>

                                <div class="text-xs text-gray-500">
                                    Administrator MUSEWANGI
                                </div>
                            </div>

                        </div>

                    </td>

                    {{-- USERNAME --}}
                    <td class="px-6 py-4 text-gray-600">
                        {{ $user->username }}
                    </td>

                    {{-- EMAIL --}}
                    <td class="px-6 py-4 text-gray-600">
                        {{ $user->email }}
                    </td>

                    {{-- ROLE --}}
                    <td class="px-6 py-4">

                        @if(strtolower($user->role) == 'super admin')

                            <span
                                class="
                                    inline-flex
                                    items-center
                                    gap-1
                                    px-3
                                    py-1
                                    rounded-full
                                    bg-red-100
                                    text-red-600
                                    text-xs
                                    font-semibold
                                "
                            >
                                <i class="fa-solid fa-crown"></i>
                                Super Admin
                            </span>

                        @else

                            <span
                                class="
                                    inline-flex
                                    items-center
                                    gap-1
                                    px-3
                                    py-1
                                    rounded-full
                                    bg-[#F8E8BF]
                                    text-[#8A6510]
                                    text-xs
                                    font-semibold
                                "
                            >
                                <i class="fa-solid fa-user"></i>
                                Admin
                            </span>

                        @endif

                    </td>

                    {{-- AKSI --}}
                <td class="px-6 py-4">

                <div class="flex justify-center gap-2">

        {{-- EDIT --}}
                <a
                    href="{{ route('admin.edit.admin',$user->id) }}"
                    class="
                        w-8
                        h-8
                        rounded
                        bg-gray-100
                        hover:bg-gray-200
                        flex
                        items-center
                        justify-center
                    "
                >
                    <i class="fa fa-pen text-xs"></i>
                </a>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td
                        colspan="6"
                        class="
                            py-16
                            text-center
                            text-gray-500
                        "
                    >
                        <div class="flex flex-col items-center gap-3">

                            <div
                                class="
                                    w-16
                                    h-16
                                    rounded-full
                                    bg-[#F5F1E8]
                                    flex
                                    items-center
                                    justify-center
                                "
                            >
                                <i
                                    class="
                                        fa-solid
                                        fa-users
                                        text-2xl
                                        text-[#C9981C]
                                    "
                                ></i>
                            </div>

                            <p>
                                Belum ada data administrator
                            </p>

                        </div>
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- FOOTER INFO --}}

<div
    class="mt-5 flex flex-col md:flex-row md:justify-between md:items-center gap-3">

    <div class="text-sm text-gray-500">

        Total Administrator :

        <span class="font-semibold text-[#162544]">

            {{ $users->count() }}

        </span>

    </div>

    <div class="text-xs text-gray-400">

        Sistem Informasi Koleksi Museum Banyuwangi (MUSEWANGI)

    </div>

</div>

</div>

</main>
{{-- NOTIFIKASI --}}

@if(session('success'))

<div
    id="alertSuccess"
    class="fixed top-6 right-6 z-50 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-3">

    <i class="fa-solid fa-circle-check"></i>

    <span>

        {{ session('success') }}

    </span>

</div>

@endif


@if(session('error'))

<div
    id="alertError"
    class="fixed top-6 right-6 z-50 bg-red-600 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-3">

    <i class="fa-solid fa-circle-xmark"></i>

    <span>

        {{ session('error') }}

    </span>

</div>

@endif


<script>

setTimeout(function(){

    let success = document.getElementById("alertSuccess");

    if(success){

        success.style.opacity="0";

        success.style.transition="0.4s";

        setTimeout(()=>success.remove(),400);

    }

},3000);


setTimeout(function(){

    let error = document.getElementById("alertError");

    if(error){

        error.style.opacity="0";

        error.style.transition="0.4s";

        setTimeout(()=>error.remove(),400);

    }

},3000);



document.querySelectorAll("form").forEach(form => {

    if(form.querySelector("button")){

        form.addEventListener("submit", function(e){

            if(form.action.includes("delete")){

                if(!confirm("Yakin ingin menghapus administrator ini?")){
                    e.preventDefault();
                }

            }

        });

    }

});

</script>

</body>
</html>