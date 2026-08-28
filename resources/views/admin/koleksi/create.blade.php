<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin MUSEWANGI | Tambah Koleksi</title>

    <!-- Favicon HD Multi-Resolution -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=5">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('favicon-48x48.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}?v=5">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}?v=5">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}?v=5">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=5">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="{ sidebarToggle: false }" class="bg-[#F8F5ED]">

    @include('admin.body.sidebar')

    <div x-show="sidebarToggle" @click="sidebarToggle=false" class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

    @include('admin.body.header')

    <main class="pt-24 lg:ml-64 p-5">
        <div class="max-w-6xl mx-auto">

            <h1 class="text-3xl font-bold text-[#162544] mb-5">
                Tambah Koleksi
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
                    Tambah Koleksi
                </span>

            </div>

            <form action="{{ route('admin.koleksi.store') }}" method="POST" enctype="multipart/form-data"
                class="bg-white rounded-xl shadow p-6">
                @csrf

                <div class="grid grid-cols-2 gap-5">

                    <div>

                        <label class="text-sm font-semibold">
                            Nama Koleksi
                        </label>

                        <input type="text" name="nama_koleksi" placeholder="Masukkan nama koleksi"
                            class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm">

                        <label class="text-sm font-semibold block mt-3">
                            No. Registrasi Baru
                        </label>

                        <input type="text" name="no_registrasi" placeholder="Masukkan nomor registrasi baru"
                            class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm">

                        <label class="text-sm font-semibold block mt-3">
                            No. Registrasi Lama
                        </label>

                        <input type="text" name="no_registrasi_lama" placeholder="Masukkan nomor registrasi lama"
                            class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm">

                        <label class="text-sm font-semibold block mt-3">
                            Tahun Pembuatan
                        </label>

                        <input type="text" name="tahun_pembuatan" placeholder="Masukkan tahun pembuatan"
                            class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm">

                    </div>

                    <div>

                        <label class="text-sm font-semibold">
                            Kategori
                        </label>

                        <select
                            name="kategori"
                            class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm"
                        >
                            <option value="">
                                Pilih Kategori
                            </option>

                            @foreach($categories as $category)
                                <option value="{{ $category->nama }}">
                                    {{ $category->nama }}
                                </option>
                            @endforeach
                        </select>

                        <label class="text-sm font-semibold block mt-3">
                            Jenis Benda
                        </label>

                        <input type="text" name="jenis_benda" placeholder="Masukkan jenis benda"
                            class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm">

                        <label class="text-sm font-semibold block mt-3">
                            Asal
                        </label>

                        <input type="text" name="asal" placeholder="Masukkan asal koleksi"
                            class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm">

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

                <textarea name="deskripsi" rows="3" placeholder="Masukkan deskripsi koleksi"
                    class="w-full mt-1 border border-[#C9981C] rounded px-3 py-2 text-sm"></textarea>

                <!-- FOTO KOLEKSI (3 SUDUT PANDANG) -->
                <div class="mt-4 mb-2">
                    <label class="text-sm font-bold text-[#162544] flex items-center gap-2">
                        <i class="fa-solid fa-camera text-[#C9981C]"></i>
                        <span>Foto Koleksi (3 Sudut Pandang)</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-0.5 mb-3">
                        Unggah foto dari 3 sudut pandang berbeda untuk galeri interaktif pengunjung.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- 1. TAMPAK DEPAN (UTAMA) -->
                        <div class="border-2 border-dashed border-[#C9981C]/60 rounded-xl bg-gray-50/70 p-4 flex flex-col items-center text-center">
                            <span class="text-xs font-bold text-[#162544] mb-1">1. Tampak Depan (Utama) *</span>
                            <span class="text-[10px] text-gray-400 mb-2">Foto utama koleksi</span>

                            <img id="previewFotoDepan" src="" style="display:none"
                                class="w-28 h-28 rounded-lg object-cover border border-[#E8DCC0] mb-2 shadow-xs">

                            <div class="flex gap-2 mt-auto">
                                <label class="bg-[#162544] hover:bg-[#0F1930] text-white px-3 py-1.5 rounded-lg shadow flex items-center gap-1.5 cursor-pointer text-[11px] transition">
                                    <i class="fa fa-camera"></i>
                                    <span>Kamera</span>
                                    <input type="file" id="kameraFotoDepan" accept="image/*" capture="environment" class="hidden"
                                        onchange="pilihFotoAngle(event, 'depan')">
                                </label>
                                <label class="bg-[#C9981C] hover:bg-[#A77C14] text-white px-3 py-1.5 rounded-lg shadow flex items-center gap-1.5 cursor-pointer text-[11px] transition">
                                    <i class="fa fa-folder"></i>
                                    <span>Pilih</span>
                                    <input type="file" id="fotoFileDepan" name="foto" accept="image/*" class="hidden"
                                        onchange="pilihFotoAngle(event, 'depan')">
                                </label>
                            </div>

                            <button type="button" id="btnBatalFotoDepan" onclick="batalFotoAngle('depan')" style="display:none"
                                class="mt-2 text-xs text-red-500 hover:text-red-700 underline">
                                Hapus Foto
                            </button>
                        </div>

                        <!-- 2. TAMPAK SAMPING -->
                        <div class="border-2 border-dashed border-gray-300 rounded-xl bg-gray-50/70 p-4 flex flex-col items-center text-center">
                            <span class="text-xs font-bold text-[#162544] mb-1">2. Tampak Samping</span>
                            <span class="text-[10px] text-gray-400 mb-2">Foto sudut sisi artefak</span>

                            <img id="previewFotoSamping" src="" style="display:none"
                                class="w-28 h-28 rounded-lg object-cover border border-[#E8DCC0] mb-2 shadow-xs">

                            <div class="flex gap-2 mt-auto">
                                <label class="bg-[#162544] hover:bg-[#0F1930] text-white px-3 py-1.5 rounded-lg shadow flex items-center gap-1.5 cursor-pointer text-[11px] transition">
                                    <i class="fa fa-camera"></i>
                                    <span>Kamera</span>
                                    <input type="file" id="kameraFotoSamping" accept="image/*" capture="environment" class="hidden"
                                        onchange="pilihFotoAngle(event, 'samping')">
                                </label>
                                <label class="bg-[#C9981C] hover:bg-[#A77C14] text-white px-3 py-1.5 rounded-lg shadow flex items-center gap-1.5 cursor-pointer text-[11px] transition">
                                    <i class="fa fa-folder"></i>
                                    <span>Pilih</span>
                                    <input type="file" id="fotoFileSamping" name="foto_samping" accept="image/*" class="hidden"
                                        onchange="pilihFotoAngle(event, 'samping')">
                                </label>
                            </div>

                            <button type="button" id="btnBatalFotoSamping" onclick="batalFotoAngle('samping')" style="display:none"
                                class="mt-2 text-xs text-red-500 hover:text-red-700 underline">
                                Hapus Foto
                            </button>
                        </div>

                        <!-- 3. TAMPAK BELAKANG -->
                        <div class="border-2 border-dashed border-gray-300 rounded-xl bg-gray-50/70 p-4 flex flex-col items-center text-center">
                            <span class="text-xs font-bold text-[#162544] mb-1">3. Tampak Belakang</span>
                            <span class="text-[10px] text-gray-400 mb-2">Foto sudut belakang artefak</span>

                            <img id="previewFotoBelakang" src="" style="display:none"
                                class="w-28 h-28 rounded-lg object-cover border border-[#E8DCC0] mb-2 shadow-xs">

                            <div class="flex gap-2 mt-auto">
                                <label class="bg-[#162544] hover:bg-[#0F1930] text-white px-3 py-1.5 rounded-lg shadow flex items-center gap-1.5 cursor-pointer text-[11px] transition">
                                    <i class="fa fa-camera"></i>
                                    <span>Kamera</span>
                                    <input type="file" id="kameraFotoBelakang" accept="image/*" capture="environment" class="hidden"
                                        onchange="pilihFotoAngle(event, 'belakang')">
                                </label>
                                <label class="bg-[#C9981C] hover:bg-[#A77C14] text-white px-3 py-1.5 rounded-lg shadow flex items-center gap-1.5 cursor-pointer text-[11px] transition">
                                    <i class="fa fa-folder"></i>
                                    <span>Pilih</span>
                                    <input type="file" id="fotoFileBelakang" name="foto_belakang" accept="image/*" class="hidden"
                                        onchange="pilihFotoAngle(event, 'belakang')">
                                </label>
                            </div>

                            <button type="button" id="btnBatalFotoBelakang" onclick="batalFotoAngle('belakang')" style="display:none"
                                class="mt-2 text-xs text-red-500 hover:text-red-700 underline">
                                Hapus Foto
                            </button>
                        </div>
                    </div>
                </div>

                <!-- REKAM SUARA DESKRIPSI -->

                <label class="text-sm font-semibold block mt-4">
                    Rekam Suara Deskripsi
                </label>

                <div class="mt-2 w-72 border border-[#C9981C] rounded-lg bg-gray-50 p-4 flex flex-col items-center">

                    <div class="flex justify-center gap-3">

                        <button type="button" onclick="startRecording()"
                            class="bg-[#162544] hover:bg-[#0F1930] text-white px-4 py-2 rounded-lg shadow flex items-center gap-2 text-xs transition">

                            <i class="fa fa-microphone"></i>
                            Rekam

                        </button>

                        <button type="button" onclick="stopRecording()"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow flex items-center gap-2 text-xs transition">

                            <i class="fa fa-stop"></i>
                            Stop

                        </button>

                        <label
                            class="bg-[#C9981C] hover:bg-[#A77C14] text-white px-4 py-2 rounded-lg shadow flex items-center gap-2 cursor-pointer text-xs transition">

                            <i class="fa fa-folder"></i>
                            Upload

                            <input type="file" id="audioFile" accept="audio/*" class="hidden"
                                onchange="previewAudio(event)">

                        </label>

                    </div>


                    <p id="recordStatus" class="text-xs text-gray-500 mt-3 text-center">
                        Belum ada rekaman
                    </p>


                    <audio id="audioPreview" controls style="display:none" class="w-full mt-3"></audio>


                    <button type="button" id="btnBatalAudio" onclick="batalAudio()" style="display:none"
                        class="mt-3 border border-gray-300 hover:bg-gray-100 px-5 py-2 rounded-lg shadow-sm text-sm transition">

                        <i class="fa fa-times"></i>
                        Batal Suara

                    </button>

                    <input type="file" id="voiceInput" name="voice_over" accept="audio/*" class="hidden">

                </div>



                <!-- BUTTON -->

                <div class="flex justify-end gap-3 mt-5">


                    <a href="{{ route('admin.koleksi.index') }}"
                        class="border border-gray-300 hover:bg-gray-100 px-5 py-3 rounded-lg shadow-sm text-sm transition">

                        Batal

                    </a>


                    <button type="submit"
                        class="bg-[#162544] hover:bg-[#0F1930] text-white px-5 py-3 rounded-lg shadow flex items-center gap-2 text-sm transition">

                        <i class="fa fa-save"></i>

                        Simpan Koleksi

                    </button>


                </div>


            </form>

        </div>

    </main>
    <script>
        function pilihFotoAngle(event, angle) {
            let file = event.target.files[0];
            if (!file) return;

            const suffix = angle === 'depan' ? 'Depan' : (angle === 'samping' ? 'Samping' : 'Belakang');
            let preview = document.getElementById('previewFoto' + suffix);
            let btnBatal = document.getElementById('btnBatalFoto' + suffix);

            if (preview) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = "block";
            }
            if (btnBatal) {
                btnBatal.style.display = "inline-block";
            }
        }

        function batalFotoAngle(angle) {
            const suffix = angle === 'depan' ? 'Depan' : (angle === 'samping' ? 'Samping' : 'Belakang');

            const fileInp = document.getElementById('fotoFile' + suffix);
            const camInp = document.getElementById('kameraFoto' + suffix);
            const preview = document.getElementById('previewFoto' + suffix);
            const btnBatal = document.getElementById('btnBatalFoto' + suffix);

            if (fileInp) fileInp.value = "";
            if (camInp) camInp.value = "";
            if (preview) {
                preview.src = "";
                preview.style.display = "none";
            }
            if (btnBatal) {
                btnBatal.style.display = "none";
            }
        }


        let recorder;

        let audioChunks = [];

        let currentStream;

        function startRecording() {

            navigator.mediaDevices.getUserMedia({
                    audio: true
                })
                .then(stream => {

                    currentStream = stream;

                    recorder = new MediaRecorder(stream);

                    audioChunks = [];

                    recorder.start();


                    document.getElementById('recordStatus').innerHTML =
                        "Sedang merekam...";


                    recorder.ondataavailable = function(e) {

                        audioChunks.push(e.data);

                    };


                    recorder.onstop = function() {

                        let blob = new Blob(audioChunks, {
                            type: "audio/webm"
                        });


                        let url = URL.createObjectURL(blob);

                        let audio = document.getElementById('audioPreview');

                        audio.src = url;
                        audio.style.display = "block";


                        let file = new File(
                            [blob],
                            "rekaman_deskripsi.webm", {
                                type: "audio/webm"
                            }
                        );


                        let dt = new DataTransfer();

                        dt.items.add(file);

                        document.getElementById('voiceInput').files =
                            dt.files;


                        document.getElementById('btnBatalAudio').style.display = "block";


                        document.getElementById('recordStatus').innerHTML =
                            "Rekaman selesai";


                        stream.getTracks().forEach(track => {
                            track.stop();
                        });

                    };


                })
                .catch(() => {

                    alert("Microphone tidak diizinkan");

                });

        }

        function stopRecording() {

            if (recorder && recorder.state === "recording") {

                recorder.stop();

            }

        }




        function previewAudio(event) {


            let file = event.target.files[0];


            if (file) {


                let audio = document.getElementById('audioPreview');


                audio.src = URL.createObjectURL(file);


                audio.style.display = "block";



                let dataTransfer = new DataTransfer();

                dataTransfer.items.add(file);



                document.getElementById('voiceInput').files =
                    dataTransfer.files;



                document.getElementById('recordStatus').innerHTML =
                    "Audio berhasil dipilih";



                document.getElementById('batalAudio').style.display =
                    "block";


            }


        }

        function batalAudio() {

            let audio = document.getElementById('audioPreview');

            audio.pause();

            audio.src = "";

            audio.style.display = "none";

            document.getElementById('audioFile').value = "";

            document.getElementById('voiceInput').value = "";

            document.getElementById('recordStatus').innerHTML =
                "Belum ada rekaman";

            document.getElementById('batalAudio').style.display =
                "none";

            audioChunks = [];


            if (recorder && recorder.state === "recording") {

                recorder.stop();

            }


            if (currentStream) {

                currentStream.getTracks().forEach(track => track.stop());

            }

        }

        console.log("Foto:", typeof batalFoto);
        console.log("Audio:", typeof batalAudio);
    </script>