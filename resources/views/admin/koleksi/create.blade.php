<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Admin MUSEWANGI | Tambah Koleksi</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body x-data="{sidebarToggle:false}" class="bg-[#F8F5ED]">

@include('admin.body.sidebar')

<div x-show="sidebarToggle" @click="sidebarToggle=false" class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

@include('admin.body.header')

<main class="pt-16 lg:ml-64 p-5">
<div class="max-w-6xl mx-auto">

<h1 class="text-2xl font-bold text-[#162544] mb-5">
Tambah Koleksi
</h1>

<div class="text-xs text-gray-500 mb-3">
Dashboard > Koleksi > Tambah
</div>

<form action="{{route('admin.koleksi.store')}}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow p-6">
@csrf

<div class="grid grid-cols-2 gap-5">

<div>

<label class="text-sm font-semibold">
Nama Koleksi
</label>

<input type="text" name="nama_koleksi" placeholder="Masukkan nama koleksi" class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm">

<label class="text-sm font-semibold block mt-3">
No. Registrasi Baru
</label>

<input type="text" name="no_registrasi" placeholder="Masukkan nomor registrasi baru" class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm">

<label class="text-sm font-semibold block mt-3">
No. Registrasi Lama
</label>

<input type="text" name="no_registrasi_lama" placeholder="Masukkan nomor registrasi lama" class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm">

<label class="text-sm font-semibold block mt-3">
Tahun Pembuatan
</label>

<input type="text" name="tahun_pembuatan" placeholder="Masukkan tahun pembuatan" class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm">

</div>

<div>

<label class="text-sm font-semibold">
Kategori
</label>

<select name="kategori" class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm">
<option value="Senjata">Senjata</option>
<option value="Keramik">Keramik</option>
<option value="Pakaian">Pakaian</option>
</select>

<label class="text-sm font-semibold block mt-3">
Jenis Benda
</label>

<input type="text" name="jenis_benda" placeholder="Masukkan jenis benda" class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm">

<label class="text-sm font-semibold block mt-3">
Asal
</label>

<input type="text" name="asal" placeholder="Masukkan asal koleksi" class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm">

<label class="text-sm font-semibold block mt-3">
Kondisi
</label>

<div class="mt-2 text-sm space-y-1">

<label class="block">
<input type="radio" name="kondisi" value="Baik" checked>
Baik
</label>

<label class="block">
<input type="radio" name="kondisi" value="Rusak Ringan">
Perlu Perawatan
</label>

<label class="block">
<input type="radio" name="kondisi" value="Rusak Berat">
Rusak
</label>

</div>

</div>

</div>

<label class="text-sm font-semibold block mt-4">
Deskripsi
</label>

<textarea name="deskripsi" rows="3" placeholder="Masukkan deskripsi koleksi" class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm"></textarea>

<label class="text-sm font-semibold block mt-4">
Foto Koleksi
</label>

<div class="mt-2 w-72 border border-[#C9981C] rounded-lg bg-gray-50 p-4 flex flex-col items-center">

<i class="fa-solid fa-cloud-arrow-up text-3xl text-[#162544]"></i>

<p class="text-xs text-gray-500 mt-2">
Pilih foto koleksi
</p>


<div class="flex gap-3 mt-3">


<label class="bg-[#162544] hover:bg-[#0F1930] text-white px-4 py-2 rounded-lg shadow flex items-center gap-2 cursor-pointer text-xs transition">

<i class="fa fa-camera"></i>

Kamera

<input 
type="file"
id="kameraFoto"
accept="image/*"
capture="environment"
class="hidden"
onchange="ambilFoto(event)">

</label>



<label class="bg-[#C9981C] hover:bg-[#A77C14] text-white px-4 py-2 rounded-lg shadow flex items-center gap-2 cursor-pointer text-xs transition">

<i class="fa fa-folder"></i>

Pilih Foto

<input 
type="file"
id="fotoFile"
name="foto"
accept="image/*"
class="hidden"
onchange="pilihFoto(event)">

</label>


</div>



<img 
id="previewFoto" 
src="" 
style="display:none"
class="mt-3 w-40 h-40 rounded-lg object-cover border">



<button 
type="button" 
id="btnBatalFoto"
onclick="batalFoto()" 
style="display:none"
class="mt-3 border border-gray-300 hover:bg-gray-100 px-5 py-2 rounded-lg shadow-sm text-sm transition">

<i class="fa fa-times"></i>

Batal Foto

</button>


</div>

<!-- REKAM SUARA DESKRIPSI -->

<label class="text-sm font-semibold block mt-4">
Rekam Suara Deskripsi
</label>

<div class="mt-2 w-72 border border-[#C9981C] rounded-lg bg-gray-50 p-4 flex flex-col items-center">

<div class="flex justify-center gap-3">

<button type="button" onclick="startRecording()" class="bg-[#162544] hover:bg-[#0F1930] text-white px-4 py-2 rounded-lg shadow flex items-center gap-2 text-xs transition">

<i class="fa fa-microphone"></i>
Rekam

</button>

<button type="button" onclick="stopRecording()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow flex items-center gap-2 text-xs transition">

<i class="fa fa-stop"></i>
Stop

</button>

<label class="bg-[#C9981C] hover:bg-[#A77C14] text-white px-4 py-2 rounded-lg shadow flex items-center gap-2 cursor-pointer text-xs transition">

<i class="fa fa-folder"></i>
Upload

<input type="file" id="audioFile" accept="audio/*" class="hidden" onchange="previewAudio(event)">

</label>

</div>


<p id="recordStatus" class="text-xs text-gray-500 mt-3 text-center">
Belum ada rekaman
</p>


<audio id="audioPreview" controls style="display:none" class="w-full mt-3"></audio>


<button type="button" id="btnBatalAudio" onclick="batalAudio()" style="display:none" class="mt-3 border border-gray-300 hover:bg-gray-100 px-5 py-2 rounded-lg shadow-sm text-sm transition">

<i class="fa fa-times"></i>
Batal Suara

</button>

<input 
type="file"
id="voiceInput"
name="voice_over"
accept="audio/*"
class="hidden">

</div>



<!-- BUTTON -->

<div class="flex justify-end gap-3 mt-5">


<a href="{{route('admin.koleksi')}}" class="border border-gray-300 hover:bg-gray-100 px-5 py-3 rounded-lg shadow-sm text-sm transition">

Batal

</a>


<button type="submit" class="bg-[#162544] hover:bg-[#0F1930] text-white px-5 py-3 rounded-lg shadow flex items-center gap-2 text-sm transition">

<i class="fa fa-save"></i>

Simpan Koleksi

</button>


</div>


</form>

</div>

</main>
<script>
function pilihFoto(event){

    let file = event.target.files[0];

    if(file){

        let preview = document.getElementById('previewFoto');

        preview.src = URL.createObjectURL(file);

        preview.style.display = "block";

        document.getElementById('btnBatalFoto').style.display="block";

    }

}



function ambilFoto(event){

    let file = event.target.files[0];

    if(file){

        let preview = document.getElementById('previewFoto');

        preview.src = URL.createObjectURL(file);

        preview.style.display = "block";

        document.getElementById('batalFoto').style.display="block";

    }

}

function batalFoto(){

    document.getElementById('kameraFoto').value="";
    document.getElementById('fotoFile').value="";


    let preview=document.getElementById('previewFoto');


    preview.src="";
    preview.style.display="none";


    document.getElementById('batalFoto').style.display="none";

}


let recorder;

let audioChunks=[];

let currentStream;

function startRecording(){

    navigator.mediaDevices.getUserMedia({
        audio:true
    })
    .then(stream=>{

        currentStream = stream;

        recorder = new MediaRecorder(stream);

        audioChunks=[];

        recorder.start();


        document.getElementById('recordStatus').innerHTML =
        "Sedang merekam...";


        recorder.ondataavailable=function(e){

            audioChunks.push(e.data);

        };


        recorder.onstop=function(){

            let blob = new Blob(audioChunks,{
                type:"audio/webm"
            });


            let url = URL.createObjectURL(blob);

            let audio=document.getElementById('audioPreview');

            audio.src=url;
            audio.style.display="block";


            let file=new File(
                [blob],
                "rekaman_deskripsi.webm",
                {
                    type:"audio/webm"
                }
            );


            let dt=new DataTransfer();

            dt.items.add(file);

            document.getElementById('voiceInput').files =
            dt.files;


            document.getElementById('btnBatalAudio').style.display="block";


            document.getElementById('recordStatus').innerHTML =
            "Rekaman selesai";


            stream.getTracks().forEach(track=>{
                track.stop();
            });

        };


    })
    .catch(()=>{

        alert("Microphone tidak diizinkan");

    });

}

function stopRecording(){

if(recorder && recorder.state==="recording"){

recorder.stop();

}

}




function previewAudio(event){


let file=event.target.files[0];


if(file){


let audio=document.getElementById('audioPreview');


audio.src=URL.createObjectURL(file);


audio.style.display="block";



let dataTransfer=new DataTransfer();

dataTransfer.items.add(file);



document.getElementById('voiceInput').files=
dataTransfer.files;



document.getElementById('recordStatus').innerHTML=
"Audio berhasil dipilih";



document.getElementById('batalAudio').style.display=
"block";


}


}
function batalAudio(){

    let audio=document.getElementById('audioPreview');

    audio.pause();

    audio.src="";

    audio.style.display="none";

    document.getElementById('audioFile').value="";

    document.getElementById('voiceInput').value="";

    document.getElementById('recordStatus').innerHTML =
    "Belum ada rekaman";

    document.getElementById('batalAudio').style.display=
    "none";

    audioChunks=[];


    if(recorder && recorder.state==="recording"){

        recorder.stop();

    }


    if(currentStream){

        currentStream.getTracks().forEach(track=>track.stop());

    }

}

console.log("Foto:", typeof batalFoto);
console.log("Audio:", typeof batalAudio);

</script>
