<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin MUSEWANGI | Koleksi</title>


<link rel="stylesheet" 
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


@vite(['resources/css/app.css','resources/js/app.js'])


</head>

<body 
x-data="{sidebarToggle:false,darkMode:false}"
class="bg-[#F8F5ED]">


{{-- SIDEBAR --}}
@include('admin.body.sidebar')

{{-- OVERLAY MOBILE --}}

<div 
x-show="sidebarToggle"
@click="sidebarToggle=false"
class="fixed inset-0 bg-black/50 z-40 lg:hidden">
</div>

{{-- HEADER --}}

@include('admin.body.header')

{{-- CONTENT --}}

<main class="pt-20 lg:ml-64 p-8">

<div class="max-w-7xl mx-auto">

{{-- TITLE SECTION --}}
<div class="flex justify-between items-center mb-8">
<div>

<h1 
class="
text-3xl
font-bold
text-[#162544]
">
Koleksi

</h1>
<p class="text-gray-500 mt-2">
    Kelola semua data koleksi museum, tambah, ubah, lihat detail, atau hapus koleksi.
</p>


</div>
<a href="{{route('admin.koleksi.create')}}"

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
">

<i class="fa fa-plus"></i>
Tambah Koleksi
</a>

</div>

{{-- TABLE CARD --}}

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

<thead

class="
bg-[#E9DEC7]
text-[#162544]
"

>

<tr>

<th class="px-6 py-4 text-left">
    Foto
</th>


<th class="px-6 py-4 text-left">
    No. Registrasi
</th>


<th class="px-6 py-4 text-left">
    Nama Koleksi
</th>


<th class="px-6 py-4 text-left">
    Kategori
</th>


<th class="px-6 py-4 text-left">
    Asal
</th>


<th class="px-6 py-4 text-left">
    Kondisi
</th>


<th class="px-6 py-4 text-center">
    Aksi
</th>
</tr>
</thead>

<tbody>
@forelse($collections as $collection)

<tr

class="
border-b
hover:bg-[#faf7ef]
transition
"

>

{{-- FOTO --}}
<td class="px-6 py-4">
@if($collection->foto)
<img

src="{{asset('storage/'.$collection->foto)}}"

class="
w-14
h-14
rounded-lg
object-cover
bg-[#E8DCC0]
"


>


@else


<div

class="
w-14
h-14
rounded-lg
bg-[#E8DCC0]
flex
items-center
justify-center
text-gray-400
"

>


<i class="fa fa-image"></i>


</div>


@endif

</td>

{{-- NOMOR REGISTRASI --}}
<td class="px-6 py-4 text-gray-600">
{{$collection->no_registrasi}}
</td>


{{-- NAMA --}}
<td

class="
px-6
py-4
font-semibold
text-[#162544]
"


>

{{$collection->nama_koleksi}}


</td>


{{-- KATEGORI --}}
<td class="px-6 py-4 text-gray-600">
{{ $collection->kategori ?? 'Senjata' }}
</td>

{{-- ASAL --}}
<td class="px-6 py-4 text-gray-600">
{{$collection->asal}}
</td>

{{-- KONDISI --}}
<td class="px-6 py-4">
@if($collection->kondisi == 'Baik')

<span

class="
bg-green-100
text-green-700
px-3
py-1
rounded-full
text-xs
"

>

Baik

</span>
@elseif($collection->kondisi == 'Rusak Ringan')



<span

class="
bg-yellow-100
text-yellow-700
px-3
py-1
rounded-full
text-xs
"

>

Rusak Ringan

</span>





@else



<span

class="
bg-red-100
text-red-600
px-3
py-1
rounded-full
text-xs
"

>

Rusak Berat

</span>




@endif



</td>

{{-- AKSI --}}
<td class="px-6 py-4">
<div class="flex justify-center gap-2">


{{-- DETAIL --}}
<a href="#"

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

<i class="fa fa-eye text-xs"></i>


</a>


{{-- EDIT --}}
<a 
href="{{route('admin.koleksi.edit',$collection->id)}}"
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


{{-- DELETE --}}
<form

action="{{route('admin.koleksi.delete',$collection->id)}}"

method="POST"

>


@csrf

@method('DELETE')



<button

onclick="return confirm('Hapus koleksi ini?')"

class="
w-8
h-8
rounded
bg-gray-100
hover:bg-red-100
flex
items-center
justify-center
"

>


<i class="fa fa-trash text-red-500 text-xs"></i>


</button>



</form>

</div>

</td>

</tr>

@empty



<tr>


<td

colspan="7"

class="
text-center
py-10
text-gray-500
"

>


Belum ada data koleksi


</td>


</tr>




@endforelse






</tbody>



</table>



</div>



</div>






</div>



</main>



</body>


</html>