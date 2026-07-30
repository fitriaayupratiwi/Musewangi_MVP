<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin MUSEWANGI | Edit Koleksi</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body
x-data="{sidebarToggle:false}"
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

{{-- TITLE --}}
<h1 class="text-3xl font-bold text-[#162544]">
Edit Koleksi
</h1>

<div class="text-sm text-gray-500 mt-2 mb-8">
Dashboard
>
Detail
>
Edit
</div>

{{-- FORM --}}
<form
action="{{route('admin.koleksi.update',['id'=>$collection->id])}}"
method="POST"
enctype="multipart/form-data"
class="
bg-white
rounded-2xl
shadow-lg
border
border-[#E8DCC0]
p-8
">

@csrf
@method('PUT')

<div class="grid grid-cols-2 gap-10">

{{-- LEFT COLUMN --}}
<div>

{{-- NAMA KOLEKSI --}}
<label class="font-semibold text-[#162544]">
Nama Koleksi
</label>

<input
type="text"
name="nama_koleksi"
value="{{$collection->nama_koleksi}}"
class="
w-full
mt-2
mb-4
border
border-[#C9981C]
rounded-lg
p-3
text-sm
">

{{-- REGISTRASI BARU --}}
<label class="font-semibold text-[#162544]">
No. Registrasi Baru
</label>

<input
type="text"
name="no_registrasi"
value="{{$collection->no_registrasi}}"
class="
w-full
mt-2
mb-4
border
border-[#C9981C]
rounded-lg
p-3
text-sm
">

{{-- REGISTRASI LAMA --}}
<label class="font-semibold text-[#162544]">
No. Registrasi Lama
</label>

<input
type="text"
name="no_registrasi_lama"
value="{{$collection->no_registrasi_lama}}"
class="
w-full
mt-2
mb-4
border
border-[#C9981C]
rounded-lg
p-3
text-sm
">

{{-- TAHUN PEMBUATAN --}}
<label class="font-semibold text-[#162544]">
Tahun Pembuatan
</label>

<input
type="text"
name="tahun_pembuatan"
value="{{$collection->tahun_pembuatan}}"
class="
w-full
mt-2
mb-4
border
border-[#C9981C]
rounded-lg
p-3
text-sm
">

{{-- ASAL --}}
<label class="font-semibold text-[#162544]">
Asal
</label>

<input
type="text"
name="asal"
value="{{$collection->asal}}"
class="
w-full
mt-2
mb-4
border
border-[#C9981C]
rounded-lg
p-3
text-sm
">

{{-- DESKRIPSI --}}
<label class="font-semibold text-[#162544]">
Deskripsi
</label>

<textarea
name="deskripsi"
rows="6"
class="
w-full
mt-2
border
border-[#C9981C]
rounded-lg
p-3
text-sm
">{{$collection->deskripsi}}</textarea>

</div>
{{-- RIGHT COLUMN --}}
<div>

{{-- KATEGORI --}}
<label class="font-semibold text-[#162544]">
Kategori
</label>

<input
type="text"
name="kategori"
value="{{$collection->kategori}}"
class="
w-full
mt-2
mb-4
border
border-[#C9981C]
rounded-lg
p-3
text-sm
">


{{-- JENIS BENDA --}}
<label class="font-semibold text-[#162544]">
Jenis Benda
</label>

<input
type="text"
name="jenis_benda"
value="{{$collection->jenis_benda}}"
class="
w-full
mt-2
mb-4
border
border-[#C9981C]
rounded-lg
p-3
text-sm
">


{{-- KONDISI --}}
<label class="font-semibold text-[#162544]">
Kondisi
</label>

<div class="mt-3 space-y-3 mb-6">


<label class="flex items-center gap-3">

<input
type="radio"
name="kondisi"
value="Baik"
{{$collection->kondisi == 'Baik' ? 'checked' : ''}}
>

Baik

</label>


<label class="flex items-center gap-3">

<input
type="radio"
name="kondisi"
value="Rusak Ringan"
{{$collection->kondisi == 'Rusak Ringan' ? 'checked' : ''}}
>

Rusak Ringan

</label>


<label class="flex items-center gap-3">

<input
type="radio"
name="kondisi"
value="Rusak Berat"
{{$collection->kondisi == 'Rusak Berat' ? 'checked' : ''}}
>

Rusak Berat

</label>


</div>

{{-- FOTO KOLEKSI --}}
<label class="font-semibold text-[#162544]">
Foto Koleksi
</label>


<div class="
mt-3
w-72
border
border-[#C9981C]
rounded-lg
bg-gray-50
p-4
flex
flex-col
items-center
">


<i class="fa-solid fa-cloud-arrow-up text-3xl text-[#162544]"></i>


<p class="text-xs text-gray-500 mt-2">
Pilih foto koleksi
</p>

<div class="flex gap-3 mt-3">


<label
for="kameraFoto"
class="
bg-[#162544]
text-white
px-4
py-2
rounded-lg
cursor-pointer
text-xs
flex
items-center
gap-2
">

<i class="fa fa-camera"></i>
Kamera

</label>


<input
type="file"
id="kameraFoto"
accept="image/*"
capture="environment"
class="hidden"
onchange="ubahPreviewFoto(event)">





<label
for="fotoFile"
class="
bg-[#C9981C]
text-white
px-4
py-2
rounded-lg
cursor-pointer
text-xs
flex
items-center
gap-2
">

<i class="fa fa-folder"></i>
Pilih Foto

</label>


<input
type="file"
id="fotoFile"
name="foto"
accept="image/*"
class="hidden"
onchange="ubahPreviewFoto(event)">



</div>



<img
id="previewFoto"

src="{{asset('storage/'.$collection->foto)}}"

class="
mt-3
w-40
h-40
rounded-lg
object-cover
border
">



<p class="text-xs text-gray-500 mt-2 text-center">

Pilih foto baru jika ingin mengganti foto lama

</p>



<button
type="button"
onclick="hapusFoto()"
class="
mt-3
border
px-5
py-2
rounded-lg
text-sm">


<i class="fa fa-times"></i>

Batal Foto

</button>

</div>

{{-- REKAMAN SUARA DESKRIPSI --}}

<label class="font-semibold text-[#162544]">
Rekaman Suara Deskripsi
</label>


<div class="
mt-3
w-72
border
border-[#C9981C]
rounded-lg
bg-gray-50
p-4
">


<div class="flex gap-2">


<button
type="button"
onclick="startRecording()"
class="
bg-[#162544]
text-white
px-3
py-2
rounded-lg
text-xs">

<i class="fa fa-microphone"></i>
Rekam

</button>



<button
type="button"
onclick="stopRecording()"
class="
bg-red-600
text-white
px-3
py-2
rounded-lg
text-xs">

<i class="fa fa-stop"></i>
Stop

</button>



<label
class="
bg-[#C9981C]
text-white
px-3
py-2
rounded-lg
text-xs
cursor-pointer">

<i class="fa fa-folder"></i>
Upload


<input
type="file"
id="audioUpload"
accept="audio/*"
hidden
onchange="uploadAudio(event)">


</label>


</div>



@if($collection->voice_over)

<p class="text-xs text-gray-500 mt-4">
Audio saat ini
</p>


<audio
id="audioPreview"
controls
class="w-full mt-2">


<source
src="{{asset('storage/'.$collection->voice_over)}}">

</audio>


@else

<audio
id="audioPreview"
controls
style="display:none"
class="w-full mt-3">
</audio>


@endif




<p id="audioStatus"
class="text-xs text-gray-500 mt-3">

Upload audio baru jika ingin mengganti suara deskripsi.

</p>



<button
type="button"
onclick="hapusAudio()"
class="
mt-3
border
px-5
py-2
rounded-lg
text-sm">


<i class="fa fa-trash"></i>

Hapus Suara


</button>



<input
type="file"
id="voiceInput"
name="voice_over"
hidden>


</div>

{{-- BUTTON --}}

<div class="mt-8 flex justify-end gap-3">


<a href="{{route('admin.koleksi')}}" 

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
">

Batal

</a>


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
">

<i class="fa fa-save"></i>

Simpan Perubahan

</button>


</div>


</form>


</div>


</main>

{{-- SCRIPT EDIT KOLEKSI --}}

<script>

// ================= FOTO =================
let fotoLama = "{{asset('storage/'.$collection->foto)}}";


function ubahPreviewFoto(event){

    let file = event.target.files[0];


    if(file){

        let preview = document.getElementById('previewFoto');


        preview.src = URL.createObjectURL(file);


        console.log("Foto baru dipilih:", file.name);

    }

}



function hapusFoto(){

    document.getElementById('fotoFile').value="";
    document.getElementById('kameraFoto').value="";


    let preview=document.getElementById('previewFoto');


    preview.src=fotoLama;


    console.log("Foto dikembalikan");

}

// ================= AUDIO =================
let recorder;
let audioChunks=[];
let stream;



function startRecording(){


navigator.mediaDevices.getUserMedia({
    audio:true
})
.then(s=>{


    stream=s;


    recorder=new MediaRecorder(stream);


    audioChunks=[];


    recorder.start();


    document.getElementById('audioStatus').innerHTML =
    "Sedang merekam...";



    recorder.ondataavailable=function(e){

        audioChunks.push(e.data);

    };



    recorder.onstop=function(){


        let blob=new Blob(audioChunks,{
            type:"audio/webm"
        });



        let audio=document.getElementById('audioPreview');


        audio.src =
        URL.createObjectURL(blob);


        audio.style.display="block";



        let file=new File(
            [blob],
            "rekaman_baru.webm",
            {
                type:"audio/webm"
            }
        );



        let dt=new DataTransfer();


        dt.items.add(file);



        document.getElementById('voiceInput').files =
        dt.files;



        document.getElementById('audioStatus').innerHTML =
        "Rekaman baru siap disimpan";



        stream.getTracks().forEach(track=>{
            track.stop();
        });


    };


});


}




function stopRecording(){


    if(recorder &&
       recorder.state==="recording"){

        recorder.stop();

    }

}




function uploadAudio(event){


    let file = event.target.files[0];


    if(file){


        let audio=document.getElementById('audioPreview');


        audio.src =
        URL.createObjectURL(file);


        audio.style.display="block";



        let dt=new DataTransfer();


        dt.items.add(file);



        document.getElementById('voiceInput').files =
        dt.files;



        document.getElementById('audioStatus').innerHTML =
        "Audio baru dipilih";


    }


}




function hapusAudio(){


    document.getElementById('voiceInput').value="";


    document.getElementById('audioUpload').value="";


    let audio=document.getElementById('audioPreview');


    audio.src="";

    audio.style.display="none";



    document.getElementById('audioStatus').innerHTML =
    "Suara dihapus, upload atau rekam ulang";


}


console.log("script edit koleksi aktif");
</script>
</body>
</html>