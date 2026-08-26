@php
    $koleksis = $koleksis ?? collect();
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        rel="stylesheet" />

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Admin MUSEWANGI | Riwayat</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <style>

        body{
            font-family:'Plus Jakarta Sans',sans-serif;
            background:#F8F5ED;
        }

        table{
            border-collapse:collapse;
            width:100%;
        }

        thead{
            background:#E9DEC7;
        }

        thead th{
            color:#162544;
            font-weight:700;
            font-size:14px;
            padding:18px 22px;
            text-align:left;
        }

        tbody td{
            padding:20px 22px;
            border-bottom:1px solid #F2E9D6;
            font-size:14px;
        }

        tbody tr{
            transition:.25s;
        }

        tbody tr:hover{
            background:#faf7ef;
        }

        .status{
            padding:6px 14px;
            border-radius:999px;
            font-size:12px;
            font-weight:600;
            display:inline-flex;
            align-items:center;
        }

        .baik{
            background:#DCFCE7;
            color:#166534;
        }

        .ringan{
            background:#FEF3C7;
            color:#92400E;
        }

        .berat{
            background:#FEE2E2;
            color:#B91C1C;
        }

        .foto{
            width:60px;
            height:60px;
            border-radius:14px;
            object-fit:cover;
            border:1px solid #E5E5E5;
        }

        .aksi-btn{
            width:36px;
            height:36px;
            border-radius:10px;
            display:flex;
            align-items:center;
            justify-content:center;
            background:#F4F4F4;
            transition:.25s;
        }

        .aksi-btn:hover{
            background:#E7D9B7;
        }

    </style>

</head>

<body
x-data="qrPage()"
x-init="init()"
:class="{'dark bg-gray-900':darkMode}">

@include('admin.body.sidebar')

<div
x-show="sidebarToggle"
@click="sidebarToggle=false"
class="fixed inset-0 bg-black/50 z-40 lg:hidden">
</div>

@include('admin.body.header')

<main class="pt-24 lg:ml-64 p-5">

<div class="max-w-7xl mx-auto">

<div class="mb-8">

<div class="flex items-start justify-between gap-6 mb-8">

    {{-- JUDUL --}}
    <div>
        <h1 class="text-3xl font-bold text-[#162544]">
            Riwayat Aktivitas
        </h1>

        <p class="text-gray-500 mt-1">
            Lihat seluruh aktivitas yang terjadi di dalam sistem.
        </p>
    </div>

    {{-- SEARCH + HAPUS --}}
    <div class="flex items-center gap-3 ml-auto">

        {{-- Search --}}
<form
    method="GET"
    action="{{ route('admin.riwayat') }}"
    class="relative"
    id="searchForm">

    <input
        type="text"
        name="search"
        id="searchInput"
        value="{{ request('search') }}"
        placeholder="Cari aktivitas..."
        autocomplete="off"
        class="w-72 rounded-xl border border-[#E8DCC0]
               bg-white py-3 pl-11 pr-12
               focus:outline-none
               focus:ring-2 focus:ring-[#C9981C]">

    <i
        class="fa-solid fa-magnifying-glass
               absolute left-4 top-1/2
               -translate-y-1/2 text-gray-400">
    </i>

    {{-- Tombol hapus pencarian --}}
        <button
            type="button"
            id="clearSearch"
            class="hidden absolute right-2 top-1/2
                -translate-y-1/2
                w-9 h-9 rounded-lg
                text-gray-400
                hover:text-red-500
                hover:bg-gray-100
                transition">

            <i class="fa-solid fa-xmark"></i>

        </button>

    </form>

        {{-- Hapus Terpilih --}}
        <form
            action="{{ route('admin.riwayat.bulkDelete') }}"
            method="POST"
            id="bulkDeleteForm">

            @csrf
            @method('DELETE')

            <input
                type="hidden"
                name="ids"
                id="selectedIds">

            <button
                type="button"
                onclick="hapusTerpilih()"
                class="bg-red-600 hover:bg-red-700
                       text-white px-5 py-3
                       rounded-xl transition
                       whitespace-nowrap">

                <i class="fa-solid fa-trash mr-2"></i>
                Hapus Terpilih

            </button>

        </form>

    </div>

</div>

</div>

</div>

<div
class="bg-white rounded-2xl shadow-lg border border-[#E8DCC0] overflow-hidden">

<div class="overflow-x-auto">

<table>
<thead>
<tr>

    <th>Tanggal</th>

    <th>Aktivitas</th>

    <th>Objek</th>

    <th>Keterangan</th>

    <th class="text-center w-24">

        <div class="flex items-center justify-center gap-2">

            <span>Aksi</span>

            <input
                type="checkbox"
                id="checkAll"
                class="w-4 h-4 cursor-pointer">

        </div>

    </th>

</tr>
</thead>

<tbody>

@forelse($aktivitas as $item)

<tr>

    {{-- Tanggal --}}
    <td>
        {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}
    </td>


    {{-- Aktivitas --}}
    <td>

        @php

            $badgeClass = 'baik';
            $icon = 'fa-plus';

            if(str_contains(strtolower($item->aktivitas), 'hapus')){
                $badgeClass = 'berat';
                $icon = 'fa-trash';
            }

            elseif(str_contains(strtolower($item->aktivitas), 'edit')){
                $badgeClass = 'ringan';
                $icon = 'fa-pen';
            }

        @endphp

        <span class="status {{ $badgeClass }}">

            <i class="fa-solid {{ $icon }} mr-2"></i>

            {{ $item->aktivitas }}

        </span>

    </td>


    {{-- Objek --}}
    <td>
        {{ $item->objek }}
    </td>


    {{-- Keterangan --}}
    <td>
        {{ $item->keterangan }}
    </td>


    {{-- Aksi --}}
    <td class="text-center">

        <input
            type="checkbox"
            name="aktivitas[]"
            value="{{ $item->id }}"
            class="activity-checkbox w-4 h-4 cursor-pointer accent-[#C9981C]">

    </td>

</tr>

@empty

<tr>
    <td colspan="4" class="text-center py-8 text-gray-400">
        Belum ada aktivitas
    </td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

<div class="mt-6">
    
{{ $aktivitas->links() }}

</div>

</div>

</main>
{{-- MODAL QR --}}
<div
    x-cloak
    x-show="qrOpen"
    x-transition.opacity
    class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">

    <div
        @click.away="qrOpen=false"
        class="relative w-full max-w-md rounded-2xl border border-[#E8DCC0] bg-[#F8F5ED] p-8 shadow-2xl">

        <button
            type="button"
            @click="qrOpen=false"
            class="absolute right-5 top-4 text-gray-600 hover:text-red-500">

            <i class="fa-solid fa-xmark text-lg"></i>

        </button>

        <h2
            class="text-xl font-bold text-[#162544] text-center">

            <span x-text="qrName"></span>

        </h2>

        <p
            class="text-center text-sm text-gray-500 mt-1"
            x-text="qrReg">
        </p>

        <div class="flex justify-center mt-6">

            <div
                class="rounded-2xl bg-white border border-[#E8DCC0] p-5 shadow">

                <img
                    :src="qrText"
                    class="w-52 h-52 object-contain">

            </div>

        </div>

        <div class="flex justify-center gap-3 mt-8">

            <button
                @click="printQr()"
                class="bg-[#C9981C] hover:bg-[#AE8518] text-white px-5 py-2 rounded-lg transition">

                <i class="fa fa-print mr-2"></i>

                Cetak

            </button>

            <a
                :href="qrDownload"
                download
                class="bg-[#162544] hover:bg-[#0F1930] text-white px-5 py-2 rounded-lg transition">

                <i class="fa fa-download mr-2"></i>

                Download

            </a>

        </div>

    </div>

</div>

<script>

function qrPage(){

return{

darkMode:false,

sidebarToggle:false,

qrOpen:false,

qrName:'',

qrReg:'',

qrText:'',

qrDownload:'',

init(){

const stored=localStorage.getItem("darkMode");

this.darkMode=stored?JSON.parse(stored):false;

this.$watch("darkMode",value=>{

localStorage.setItem("darkMode",JSON.stringify(value));

});

},

openQrModal(payload){

if(!payload.text)return;

this.qrName=payload.name;

this.qrReg=payload.reg;

this.qrText=payload.text;

this.qrDownload=payload.download;

this.qrOpen=true;

},

printQr(){

if(!this.qrText)return;

let w=window.open('','','width=450,height=550');

w.document.write(`

<html>

<head>

<title>QR Code</title>

<style>

body{

font-family:Arial;

text-align:center;

padding:30px;

}

img{

width:220px;

height:220px;

}

h2{

margin-top:20px;

color:#162544;

}

p{

color:#666;

}

</style>

</head>

<body>

<img src="${this.qrText}">

<h2>${this.qrName}</h2>

<p>${this.qrReg}</p>

<script>

window.onload=function(){

window.print();

}

<\/script>

</script>


{{-- SCRIPT CHECKBOX & HAPUS TERPILIH --}}
<script>

    // CHECKBOX PILIH SEMUA
    document.getElementById('checkAll')?.addEventListener('change', function () {

        const checkboxes = document.querySelectorAll('.activity-checkbox');

        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });

    });


    // HAPUS AKTIVITAS TERPILIH
    function hapusTerpilih() {

        const selected = document.querySelectorAll(
            '.activity-checkbox:checked'
        );

        if (selected.length === 0) {

            Swal.fire({
                icon: 'warning',
                title: 'Belum Ada Pilihan',
                text: 'Silakan pilih aktivitas yang ingin dihapus.',
                confirmButtonColor: '#C9981C'
            });

            return;
        }


        const ids = Array.from(selected).map(
            checkbox => checkbox.value
        );


        Swal.fire({
            title: 'Hapus aktivitas terpilih?',
            text: `Sebanyak ${ids.length} aktivitas akan dihapus.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {

                document.getElementById('selectedIds').value =
                    ids.join(',');

                document.getElementById('bulkDeleteForm').submit();

            }

        });

    }

</script>

{{-- SCRIPT TOASTR --}}
<script>

    @if(Session::has('message'))

        toastr.options.closeButton=true;
        toastr.options.progressBar=true;
        toastr.options.positionClass="toast-top-right";

        var type="{{Session::get('alert-type','info')}}";

        switch(type){

            case'info':
                toastr.info("{{Session::get('message')}}");
                break;

            case'success':
                toastr.success("{{Session::get('message')}}");
                break;

            case'warning':
                toastr.warning("{{Session::get('message')}}");
                break;

            case'error':
                toastr.error("{{Session::get('message')}}");
                break;

        }

    @endif

</script>

{{-- SCRIPT HAPUS TERPILIH --}}
<script>
    function hapusTerpilih() {

        const selected = document.querySelectorAll(
            '.activity-checkbox:checked'
        );

        // Kalau belum memilih data
        if (selected.length === 0) {

            Swal.fire({
                icon: 'warning',
                title: 'Belum Ada Pilihan',
                text: 'Silakan pilih aktivitas yang ingin dihapus.',
                confirmButtonColor: '#C9981C'
            });

            return;
        }

        // Ambil semua ID yang dicentang
        const ids = Array.from(selected).map(
            checkbox => checkbox.value
        );

        // Popup konfirmasi
        Swal.fire({
            title: 'Hapus aktivitas terpilih?',
            text: `Sebanyak ${ids.length} aktivitas akan dihapus.`,
            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#6B7280',

            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'

        }).then((result) => {

            if (result.isConfirmed) {

                document.getElementById('selectedIds').value =
                    ids.join(',');

                document.getElementById('bulkDeleteForm').submit();

            }

        });
    }
</script>

<script>

    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    const clearSearch = document.getElementById('clearSearch');

    let searchTimer;


    // LIVE SEARCH
    searchInput.addEventListener('input', function () {

        clearTimeout(searchTimer);

        const keyword = this.value.trim();


        // Tampilkan tombol X kalau ada tulisan
        if (keyword.length > 0) {

            clearSearch.classList.remove('hidden');

        } else {

            clearSearch.classList.add('hidden');

        }


        // Tunggu sebentar supaya tidak request setiap huruf
        searchTimer = setTimeout(() => {

            searchForm.submit();

        }, 400);

    });


    // HAPUS PENCARIAN
    clearSearch.addEventListener('click', function () {

        searchInput.value = '';

        clearSearch.classList.add('hidden');

        searchForm.submit();

    });


    // Kalau halaman dibuka dengan search yang sudah ada
    if (searchInput.value.trim() !== '') {

        clearSearch.classList.remove('hidden');

    }

</script>

{{-- SCRIPT HAPUS TERPILIH --}}
<script>
    function hapusTerpilih() {

        const selected = document.querySelectorAll(
            '.activity-checkbox:checked'
        );

        if (selected.length === 0) {

            Swal.fire({
                icon: 'warning',
                title: 'Belum Ada Pilihan',
                text: 'Silakan pilih aktivitas yang ingin dihapus.',
                confirmButtonColor: '#C9981C'
            });

            return;
        }

        const ids = Array.from(selected).map(
            checkbox => checkbox.value
        );

        Swal.fire({
            title: 'Hapus aktivitas terpilih?',
            text: `Sebanyak ${ids.length} aktivitas akan dihapus.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DC2626',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'

        }).then((result) => {

            if (result.isConfirmed) {

                document.getElementById('selectedIds').value =
                    ids.join(',');

                document.getElementById('bulkDeleteForm').submit();

            }

        });

    }
</script>


{{-- SCRIPT CHECK ALL --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const checkAll = document.getElementById('checkAll');

        const checkboxes = document.querySelectorAll(
            '.activity-checkbox'
        );


        // CHECKBOX "AKSI" / CHECK ALL
        checkAll.addEventListener('change', function () {

            checkboxes.forEach(function (checkbox) {

                checkbox.checked = checkAll.checked;

            });

        });


        // CHECKBOX INDIVIDUAL
        checkboxes.forEach(function (checkbox) {

            checkbox.addEventListener('change', function () {

                const total = checkboxes.length;

                const checked = document.querySelectorAll(
                    '.activity-checkbox:checked'
                ).length;


                // Semua dicentang
                if (checked === total && total > 0) {

                    checkAll.checked = true;

                } else {

                    checkAll.checked = false;

                }

            });

        });

    });
</script>

</body>

</html>

`);

w.document.close();

}

}

}

</script>

</body>

</html>