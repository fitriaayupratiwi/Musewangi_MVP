<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <title>Admin DineQR | Menu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('backend/js/code.js') }}"></script>
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

    <main class="pt-16 transition-all duration-300
    dark:bg-gray-900
    lg:ml-64 p-4 z-10">
        <div class="py-2 overflow-x-auto shadow-md sm:rounded-lg">
            <h2 class="text-center mb-5 font-bold dark:text-white">Daftar Menu </h2>
            <a href="{{ route('admin.tambah.menu') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-1 rounded mb-5 ml-4"> <i
                    class="fas fa-plus px-1"></i>Tambah
                Menu</a>

            <table class="w-full text-sm mt-5 text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nama Menu
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Deskripsi
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Harga
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kategori
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Stok
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Rekomendasi
                        </th>
                        <th scope="col" class="px-4 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $menu->nama }}
                            </th>
                            <td class="px-4 py-3">
                                <div
                                    class="
                                    max-w-[50px]
                                    sm:max-w-[80px]
                                    md:max-w-[100px]
                                    lg:max-w-[200px]
                                    truncate
                                    "
                                    title="{{ $menu->deskripsi }}"
                                >
                                    {{ $menu->deskripsi }}
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                {{ $menu->harga }}
                            </td>
                            <td class="px-4 py-3">
                                {{ $menu->kategori->nama }}
                            </td>
                            <td class="px-4 py-3">
                                <form action="{{ route('admin.update.stok', $menu->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="stok_baru"
                                        value="{{ $menu->stok === 'habis' ? 'tersedia' : 'habis' }}">

                                    <button type="submit"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full
                                        {{ $menu->stok === 'habis' ? 'bg-red-500' : 'bg-green-500' }} btn-stok">
                                        <span
                                            class="inline-block h-4 w-4 transform rounded-full bg-white transition
                                            {{ $menu->stok === 'habis' ? 'translate-x-1' : 'translate-x-6' }}">
                                        </span>
                                    </button>

                                    <span class="ml-2 text-sm font-semibold">
                                        {{ ucfirst($menu->stok) }}
                                    </span>
                                </form>
                            </td>


                            <td class="px-4 py-3">
                                <form action="{{ route('admin.update.rekomendasi', $menu->id) }}"
                                    method="POST"
                                    >
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" name="is_recommended_baru"
                                        value="{{ $menu->is_recommended ? 0 : 1 }}">

                                    <button type="submit"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full
                                        {{ $menu->is_recommended ? 'bg-orange-500' : 'bg-gray-400' }} btn-rekomendasi">
                                        <span
                                            class="inline-block h-4 w-4 transform rounded-full bg-white transition
                                            {{ $menu->is_recommended ? 'translate-x-6' : 'translate-x-1' }}">
                                        </span>
                                    </button>

                                    <span class="ml-2 text-sm font-semibold">
                                        {{ $menu->is_recommended ? 'Ya' : 'Tidak' }}
                                    </span>
                                </form>
                            </td>



                            <td class="px-4 py-3">

                                <a href="{{ route('admin.edit.menu', $menu->id) }}"
                                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-1 rounded">
                                    Edit </a>
                                <a href="{{ route('admin.delete.menu', $menu->id) }}"
                                    class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-1 rounded"
                                    id="delete">
                                    Hapus </a>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>

    </main>

    {{-- <script>
function confirmAction(form, title, text, confirmText = 'Ya, Lanjutkan') {
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#2563eb', // blue
        cancelButtonColor: '#6b7280', // gray
        confirmButtonText: confirmText,
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}
</script> --}}



    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>






</body>

</html>