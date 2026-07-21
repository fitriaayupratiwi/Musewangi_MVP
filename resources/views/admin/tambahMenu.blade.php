<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin DineQR | Tambah Menu</title>
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
            <span class="inline-flex items-center text-sm font-medium text-body-subtle">Tambah Menu</span>
        </div>
        </li>
    </ol>
    </nav>

    <form id="myForm" action="{{ route('admin.store.menu') }}" method="POST" enctype="multipart/form-data"
        class="max-w-md mx-auto mt-8 p-6 bg-white dark:bg-gray-800 rounded-md shadow-md">
        @csrf
        <h2 class="text-2xl font-bold text-center dark:text-white mb-6">Tambah Menu</h2>

        <div class="mb-4">
            <label for="nama_menu" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Nama Menu</label>
            <input type="text" id="nama_menu" name="nama_menu"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline"
                required>
        </div>

        <div class="mb-6">
            <label for="image" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Gambar</label>
            <input type="file" id="image" name="image" accept="image/*"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
            <img id="showImage"
                src="{{ !empty($profileData->gambar)
                    ? url('upload/menu/1.jpg' . $profileData->gambar)
                    : url(
                        'upload/menu/1.jpg                                                                                                                                                                                               .jpg',
                    ) }}"
                alt="" class="mt-2 max-w-xs rounded">
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>

        <div class="mb-4">
            <label for="kategori" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Kategori</label>
            <select id="kategori" name="kategori"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- <div class="mb-4">
            <label for="stok" class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
            <select id="stok" name="stok" min="0"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">-- Pilih Stok --</option>
                <option value="habis">Habis</option>
                <option value="tersedia">Tersedia</option>
            </select>
        </div> --}}

        <div class="mb-4">
            <label for="harga" class="block text-gray-700 dark:text-white text-sm font-bold mb-2">Harga</label>
            <input type="number" id="harga" name="harga"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-white dark:bg-gray-700 dark:border-gray-600 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="flex justify-between pt-4">
            <button type="reset"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Hapus
            </button>
            <button type="submit"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
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
                    nama_menu: {
                        required: true,
                    },
                    image: {
                        required: true,
                    },

                },
                messages: {
                    nama_menu: {
                        required: 'Please Menu Name',
                    },
                    image: {
                        required: 'Please Select Image',
                    },


                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.parent().append(error);
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