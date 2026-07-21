<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <title>Admin DineQR | Edit Menu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ 'darkMode': false, 'sidebarToggle': false }" x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
$watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" :class="{ 'dark bg-gray-900': darkMode === true }" class=" relative min-w-screen">

    @include('admin.body.sidebar')
    <!-- OVERLAY (klik → tutup sidebar) -->
  <div
    x-show="sidebarToggle"
    @click="sidebarToggle = false"
    class="fixed inset-0 z-40 bg-black/50 lg:hidden"
    x-transition.opacity
  ></div>
    @include('admin.body.header')

<main class="pt-16 transition-all duration-300 p-4
    dark:bg-gray-900
    lg:ml-64 z-10">

    <nav class="flex text-gray-500 mb-5 mt-5 ml-5" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
        <li class="inline-flex items-center">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-body hover:text-fg-brand">
            <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/></svg>
            Dashboard
        </a>
        </li>
        <li>
        <div class="flex items-center space-x-1.5">
            <svg class="w-3.5 h-3.5 rtl:rotate-180 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
            <a href="{{ route('admin.menu') }}" class="inline-flex items-center text-sm font-medium text-body hover:text-fg-brand">Daftar Menu</a>
        </div>
        </li>
        <li aria-current="page">
        <div class="flex items-center space-x-1.5">
            <svg class="w-3.5 h-3.5 rtl:rotate-180 text-body" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/></svg>
            <span class="inline-flex items-center text-sm font-medium text-body-subtle">Edit Menu</span>
        </div>
        </li>
    </ol>
    </nav>

    <form id="myForm" action="{{ route('admin.update.menu') }}" method="POST" enctype="multipart/form-data"
        class="max-w-xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow space-y-4">
        @csrf
        <input type="hidden" name="id" value="{{ $menu->id }}">

        <h3 class="text-2xl font-bold text-center dark:text-white mb-4">Edit Menu</h3>

        <!-- Nama Menu -->
        <div>
            <label for="nama_menu" class="block text-sm font-medium text-gray-700 dark:text-white">Nama Menu</label>
            <input type="text" id="nama_menu" name="nama_menu" value="{{ $menu->nama }}"
                class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md p-2 focus:outline-none focus:ring focus:border-blue-500"
                required>
        </div>

        <!-- Gambar -->
        <div class="mb-3">
            <label for="example-text-input" class="form-label dark:text-white">Gambar</label>
            <input class="form-control dark:bg-gray-700 dark:text-white" name="image" type="file" id="image" accept="image/*">
        </div>
        <div class="mb-3">

            <img id="showImage" src="{{ asset($menu->gambar) }}" alt=""
                class="rounded-circle p-1 bg-primary" width="110">
        </div>



        <!-- Deskripsi -->
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-white">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"
                class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md p-2 focus:outline-none focus:ring focus:border-blue-500">{{ $menu->deskripsi }}</textarea>
        </div>

        <!-- Kategori -->
        <select id="kategori" name="kategori"
            class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring focus:border-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
            <option value="">-- Pilih Kategori --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $menu->kategori_id == $category->id ? 'selected' : '' }}>
                    {{ $category->nama }}
                </option>
            @endforeach
        </select>


        <!-- Stok -->
        {{-- <div>
            <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
            <select id="stok" name="stok" min="0"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">-- Pilih Stok --</option>
                <option value="habis" {{ $menu->stok == 'habis' ? 'selected' : '' }}>Habis</option>
                <option value="tersedia" {{ $menu->stok == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
            </select>
        </div> --}}

        <!-- Harga -->
        <div>
            <label for="harga" class="block text-sm font-medium text-gray-700 dark:text-white">Harga </label>
            <input type="number" id="harga" name="harga" value="{{ $menu->harga }}"
                class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md p-2 focus:outline-none focus:ring focus:border-blue-500">
        </div>

        <!-- Tombol -->
        <div class="flex justify-between pt-4">

            <a href="{{ route('admin.menu') }}"
                class="bg-white text-black font-bold px-6 py-2 rounded border border-gray-300 hover:bg-gray-200 dark:bg-gray-700 dark:text-white transition flex items-center gap-2">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>

            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                Simpan
            </button>
        </div>

    </form>

</main>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            })
        })
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#myForm').validate({
                rules: {
                    category_name: {
                        required: true,
                    },


                },
                messages: {
                    category_name: {
                        required: 'Please Enter Category Name',
                    },



                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
            });
        });
    </script>

</body>

</html>