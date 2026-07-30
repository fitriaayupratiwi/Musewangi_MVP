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
x-data="
{
sidebarToggle:false,
darkMode:false,
deleteModal:false,
deleteId:null,
deleteName:'',
deleteUrl:''
}
"
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
">


<div class="overflow-x-auto">


<table class="w-full text-sm">


{{-- TABLE HEADER --}}
<thead

class="
bg-[#E9DEC7]
text-[#162544]
">

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


{{-- TABLE BODY --}}
<tbody>


@forelse($collections as $collection)


<tr

class="
border-b
hover:bg-[#faf7ef]
transition
">


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
">

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
">

<i class="fa fa-image"></i>

</div>


@endif

</td>


{{-- NOMOR REGISTRASI --}}
<td class="px-6 py-4 text-gray-600">

{{$collection->no_registrasi}}

</td>


{{-- NAMA KOLEKSI --}}
<td

class="
px-6
py-4
font-semibold
text-[#162544]
">

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
">

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
">

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
">

Rusak Berat

</span>


@endif


</td>


{{-- AKSI --}}
<td class="px-6 py-4">


<div class="flex justify-center gap-2">


{{-- DETAIL --}}
<a 

href="{{route('admin.koleksi.detail',$collection->id)}}"

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
<button

@click="
deleteModal=true;
deleteId={{$collection->id}};
deleteName='{{$collection->nama_koleksi}}';
deleteUrl='{{route('admin.koleksi.delete',$collection->id)}}'
"

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


{{-- MODAL HAPUS KOLEKSI --}}

<div

x-show="deleteModal"

x-transition

class="
fixed
inset-0
z-50
flex
items-center
justify-center
bg-black/50
"


>


{{-- CARD MODAL --}}

<div

@click.away="deleteModal=false"

class="
bg-[#F8F5ED]
w-[420px]
rounded-2xl
shadow-2xl
p-8
relative
text-center
border
border-[#E8DCC0]
"

>


{{-- CLOSE BUTTON --}}

<button

@click="deleteModal=false"

class="
absolute
right-5
top-3
text-3xl
text-gray-700
"

>

×

</button>


{{-- ICON WARNING --}}

<div class="flex justify-center mb-5">


<div

class="
w-16
h-16
rounded-full
bg-red-100
flex
items-center
justify-center
"

>


<i

class="
fa-solid
fa-triangle-exclamation
text-red-600
text-3xl
"

></i>


</div>


</div>


{{-- TITLE --}}

<h2

class="
text-xl
font-bold
text-[#162544]
mb-4
"

>

Hapus Koleksi

</h2>


{{-- DESCRIPTION --}}

<p

class="
text-sm
text-gray-700
leading-relaxed
mb-6
"

>

Anda yakin menghapus koleksi

<br>

<b

class="text-[#162544]"

x-text="'&quot;'+deleteName+'&quot;'"

>

</b>

<br>

Data yang dihapus tidak dapat dikembalikan.

</p>
{{-- BUTTON MODAL --}}

<div class="flex justify-center gap-4">


{{-- BATAL --}}

<button

@click="deleteModal=false"

class="
px-6
py-2
rounded-lg
border
border-red-500
text-red-600
hover:bg-red-50
"

>

Batal

</button>



{{-- HAPUS --}}

<form

:action="deleteUrl"

method="POST"

>

@csrf

@method('DELETE')


<button

class="
px-6
py-2
rounded-lg
bg-red-600
hover:bg-red-700
text-white
"

>

<i class="fa fa-trash"></i>

Hapus

</button>


</form>


</div>


</div>


</div>


</body>


</html>