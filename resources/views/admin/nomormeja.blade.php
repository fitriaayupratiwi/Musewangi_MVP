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

    <title>Admin DineQR | Nomor Meja</title>
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

    <main class="pt-16 transition-all duration-300 p-4
    dark:bg-gray-900
    lg:ml-64 z-10">
        <div class=" overflow-x-auto shadow-md sm:rounded-lg">
            <h2 class="text-center mb-5 font-bold dark:text-white">Daftar Nomor Meja </h2>
            <a href="{{ route('admin.tambah.nomormeja') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-1 rounded mb-3"> <i
                    class="fas fa-plus px-1"></i>Tambah
                Nomor Meja</a>

            <table class="w-full text-sm text-left mt-5 rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nomor Meja
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-4 py-3">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nomor_mejas as $nomor_meja)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $nomor_meja->nomor }}
                            </th>
                            <td class="px-6 py-4">
                               @if ($nomor_meja->status == 'tersedia')
                                    <button type="button" disabled class="px-3 py-1 text-green-700 bg-green-100 font-semibold text-sm rounded-full cursor-default">
                                        Tersedia
                                    </button>
                                @elseif ($nomor_meja->status == 'terisi')
                                    <button type="button" disabled class="px-3 py-1 text-yellow-700 bg-yellow-100 font-semibold text-sm rounded-full cursor-default">
                                        Terisi
                                    </button>
                                @elseif ($nomor_meja->status == 'reservasi')
                                    <button type="button" disabled class="px-3 py-1 text-blue-700 bg-blue-100 font-semibold text-sm rounded-full cursor-default">
                                        Reservasi
                                    </button>
                                @elseif ($nomor_meja->status == 'rusak')
                                    <button type="button" disabled class="px-3 py-1 text-red-700 bg-red-100 font-semibold text-sm rounded-full cursor-default">
                                        Rusak
                                    </button>
                                @endif
                            </td>
                            <td class="px-6 py-4">

                                <a href="{{ route('admin.edit.nomormeja', $nomor_meja->id) }}"
                                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-1 rounded">
                                    Edit </a>
                                <a href="{{ route('admin.delete.nomormeja', $nomor_meja->id) }}"
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




</body>

</html>