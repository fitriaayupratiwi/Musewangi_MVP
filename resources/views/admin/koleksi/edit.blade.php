<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin MUSEWANGI | Edit Koleksi</title>

<!-- Favicon HD Multi-Resolution -->
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=5">
<link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}?v=5">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=5">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=5">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=5">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=5">
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
<main class="pt-24 lg:ml-64 p-5">

<div class="max-w-7xl mx-auto">

{{-- TITLE --}}
<h1 class="text-3xl font-bold text-[#162544]">
Edit Koleksi
</h1>

<div class="text-sm text-gray-500 mb-3 flex items-center gap-2">
    <a
        href="{{ route('admin.koleksi.index') }}"
        class="hover:text-[#C9981C] transition"
    >
        Daftar Koleksi
    </a>

    <span class="text-gray-400">></span>

    <span class="text-[#C9981C] font-medium">
        Edit Koleksi
    </span>

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

<select
    name="kategori"
    class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm"
>
    @foreach($categories as $category)

        <option
            value="{{ $category->nama }}"
            {{ $collection->kategori == $category->nama ? 'selected' : '' }}
        >
            {{ $category->nama }}
        </option>

    @endforeach
</select>

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


<div class="mt-3 mb-2">
<p class="text-xs text-gray-500 mb-3">
    Unggah foto dari 3 sudut pandang berbeda untuk galeri interaktif pengunjung.
</p>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- 1. TAMPAK DEPAN (UTAMA) -->
    <div class="border-2 border-dashed border-[#C9981C]/60 rounded-xl bg-gray-50/70 p-4 flex flex-col items-center text-center">
        <span class="text-xs font-bold text-[#162544] mb-1">1. Tampak Depan (Utama)</span>
        <span class="text-[10px] text-gray-400 mb-2">Foto utama koleksi</span>

        <img id="previewFotoDepan"
            src="{{ $collection->fotoDepanUrl() ?: asset('src/images/gapura1.png') }}"
            class="w-28 h-28 rounded-lg object-cover border border-[#E8DCC0] mb-2 shadow-xs {{ $collection->fotoDepanUrl() ? '' : 'opacity-40' }}">

        <div class="flex gap-2 mt-auto">
            <label class="bg-[#162544] hover:bg-[#0F1930] text-white px-3 py-1.5 rounded-lg shadow flex items-center gap-1.5 cursor-pointer text-[11px] transition">
                <i class="fa fa-camera"></i>
                <span>Kamera</span>
                <input type="file" id="kameraFotoDepan" accept="image/*" capture="environment" class="hidden"
                    onchange="ubahPreviewFotoAngle(event, 'depan')">
            </label>
            <label class="bg-[#C9981C] hover:bg-[#A77C14] text-white px-3 py-1.5 rounded-lg shadow flex items-center gap-1.5 cursor-pointer text-[11px] transition">
                <i class="fa fa-folder"></i>
                <span>Ubah</span>
                <input type="file" id="fotoFileDepan" name="foto" accept="image/*" class="hidden"
                    onchange="ubahPreviewFotoAngle(event, 'depan')">
            </label>
        </div>

        <button type="button" onclick="kembalikanFotoAngle('depan')"
            class="mt-2 text-xs text-gray-500 hover:text-red-500 underline">
            Batal Ubah
        </button>
    </div>

    <!-- 2. TAMPAK SAMPING -->
    <div class="border-2 border-dashed border-gray-300 rounded-xl bg-gray-50/70 p-4 flex flex-col items-center text-center">
        <span class="text-xs font-bold text-[#162544] mb-1">2. Tampak Samping</span>
        <span class="text-[10px] text-gray-400 mb-2">Foto sudut sisi artefak</span>

        <img id="previewFotoSamping"
            src="{{ $collection->fotoSampingUrl() ?: asset('src/images/gapura1.png') }}"
            class="w-28 h-28 rounded-lg object-cover border border-[#E8DCC0] mb-2 shadow-xs {{ $collection->fotoSampingUrl() ? '' : 'opacity-40' }}">

        <div class="flex gap-2 mt-auto">
            <label class="bg-[#162544] hover:bg-[#0F1930] text-white px-3 py-1.5 rounded-lg shadow flex items-center gap-1.5 cursor-pointer text-[11px] transition">
                <i class="fa fa-camera"></i>
                <span>Kamera</span>
                <input type="file" id="kameraFotoSamping" accept="image/*" capture="environment" class="hidden"
                    onchange="ubahPreviewFotoAngle(event, 'samping')">
            </label>
            <label class="bg-[#C9981C] hover:bg-[#A77C14] text-white px-3 py-1.5 rounded-lg shadow flex items-center gap-1.5 cursor-pointer text-[11px] transition">
                <i class="fa fa-folder"></i>
                <span>{{ $collection->foto_samping ? 'Ubah' : 'Pilih' }}</span>
                <input type="file" id="fotoFileSamping" name="foto_samping" accept="image/*" class="hidden"
                    onchange="ubahPreviewFotoAngle(event, 'samping')">
            </label>
        </div>

        <button type="button" onclick="kembalikanFotoAngle('samping')"
            class="mt-2 text-xs text-gray-500 hover:text-red-500 underline">
            Batal Ubah
        </button>
    </div>

    <!-- 3. TAMPAK BELAKANG -->
    <div class="border-2 border-dashed border-gray-300 rounded-xl bg-gray-50/70 p-4 flex flex-col items-center text-center">
        <span class="text-xs font-bold text-[#162544] mb-1">3. Tampak Belakang</span>
        <span class="text-[10px] text-gray-400 mb-2">Foto sudut belakang artefak</span>

        <img id="previewFotoBelakang"
            src="{{ $collection->fotoBelakangUrl() ?: asset('src/images/gapura1.png') }}"
            class="w-28 h-28 rounded-lg object-cover border border-[#E8DCC0] mb-2 shadow-xs {{ $collection->fotoBelakangUrl() ? '' : 'opacity-40' }}">

        <div class="flex gap-2 mt-auto">
            <label class="bg-[#162544] hover:bg-[#0F1930] text-white px-3 py-1.5 rounded-lg shadow flex items-center gap-1.5 cursor-pointer text-[11px] transition">
                <i class="fa fa-camera"></i>
                <span>Kamera</span>
                <input type="file" id="kameraFotoBelakang" accept="image/*" capture="environment" class="hidden"
                    onchange="ubahPreviewFotoAngle(event, 'belakang')">
            </label>
            <label class="bg-[#C9981C] hover:bg-[#A77C14] text-white px-3 py-1.5 rounded-lg shadow flex items-center gap-1.5 cursor-pointer text-[11px] transition">
                <i class="fa fa-folder"></i>
                <span>{{ $collection->foto_belakang ? 'Ubah' : 'Pilih' }}</span>
                <input type="file" id="fotoFileBelakang" name="foto_belakang" accept="image/*" class="hidden"
                    onchange="ubahPreviewFotoAngle(event, 'belakang')">
            </label>
        </div>

        <button type="button" onclick="kembalikanFotoAngle('belakang')"
            class="mt-2 text-xs text-gray-500 hover:text-red-500 underline">
            Batal Ubah
        </button>
    </div>
</div>
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


<a href="{{route('admin.koleksi.index')}}" 

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

// ================= FOTO 3 SUDUT PANDANG =================
let fotoLamaDepan = "{{ $collection->fotoDepanUrl() ?: asset('src/images/gapura1.png') }}";
let fotoLamaSamping = "{{ $collection->fotoSampingUrl() ?: asset('src/images/gapura1.png') }}";
let fotoLamaBelakang = "{{ $collection->fotoBelakangUrl() ?: asset('src/images/gapura1.png') }}";

function ubahPreviewFotoAngle(event, angle) {
    let file = event.target.files[0];
    if (!file) return;

    const suffix = angle === 'depan' ? 'Depan' : (angle === 'samping' ? 'Samping' : 'Belakang');
    let preview = document.getElementById('previewFoto' + suffix);
    if (preview) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('opacity-40');
    }
}

function kembalikanFotoAngle(angle) {
    const suffix = angle === 'depan' ? 'Depan' : (angle === 'samping' ? 'Samping' : 'Belakang');
    const fileInp = document.getElementById('fotoFile' + suffix);
    const camInp = document.getElementById('kameraFoto' + suffix);
    const preview = document.getElementById('previewFoto' + suffix);

    if (fileInp) fileInp.value = "";
    if (camInp) camInp.value = "";

    if (preview) {
        if (angle === 'depan') preview.src = fotoLamaDepan;
        if (angle === 'samping') preview.src = fotoLamaSamping;
        if (angle === 'belakang') preview.src = fotoLamaBelakang;
    }
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
