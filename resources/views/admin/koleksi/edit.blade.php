<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Admin Musewangi | Edit Koleksi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .page-bg { background: linear-gradient(135deg, #F5EFE3 0%, #EDE3CF 40%, #F0E8D5 100%); min-height: 100vh; }
        .form-input {
            width: 100%; border-radius: 12px; border: 1.5px solid #DDD0A8;
            background: #FFFBF0; padding: 10px 14px; font-size: 14px;
            color: #202020; outline: none; transition: all 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .form-input:focus { border-color: #B78921; box-shadow: 0 0 0 3px rgba(183,137,33,0.15); }
        .form-input::placeholder { color: #B0A080; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #1D2745; margin-bottom: 6px; }
        .form-section { background: white; border-radius: 18px; border: 1.5px solid #EDD9A3; padding: 24px; margin-bottom: 20px; }
        .section-title { font-size: 14px; font-weight: 700; color: #1D2745; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1.5px solid #F0E4C2; display: flex; align-items: center; gap: 8px; }
        .section-icon { width: 28px; height: 28px; border-radius: 8px; background: linear-gradient(135deg, #EEF2FF, #C5D0F7); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .upload-zone { border: 2px dashed #DDD0A8; border-radius: 14px; background: #FFFBF2; padding: 24px; text-align: center; cursor: pointer; transition: all 0.2s; position: relative; }
        .upload-zone:hover { border-color: #B78921; background: #FFF8E8; }
        .upload-zone input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; }
        .kondisi-radio { display: none; }
        .kondisi-label { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 10px; border: 1.5px solid #DDD0A8; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s; background: white; }
        .kondisi-radio:checked + .kondisi-label { border-color: #B78921; background: linear-gradient(135deg, #FFF3D1, #FFE5A0); color: #7B5200; }
        .kondisi-radio[value="baik"]:checked + .kondisi-label { border-color: #10B981; background: #ECFDF5; color: #065F46; }
        .kondisi-radio[value="rusak_ringan"]:checked + .kondisi-label { border-color: #F59E0B; background: #FFFBEB; color: #92400E; }
        .kondisi-radio[value="rusak_berat"]:checked + .kondisi-label { border-color: #EF4444; background: #FEF2F2; color: #991B1B; }
        .btn-primary { background: linear-gradient(135deg, #3B5BDB, #7048E8); color: white; border: none; border-radius: 12px; padding: 11px 28px; font-size: 14px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.25s; box-shadow: 0 4px 14px rgba(59,91,219,0.3); }
        .btn-primary:hover { background: linear-gradient(135deg, #2A47C6, #5E35CC); box-shadow: 0 6px 20px rgba(59,91,219,0.4); transform: translateY(-1px); }
        .btn-secondary { background: white; color: #555; border: 1.5px solid #DDD0A8; border-radius: 12px; padding: 11px 24px; font-size: 14px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; text-decoration: none; }
        .btn-secondary:hover { border-color: #3B5BDB; color: #3B5BDB; background: #EEF2FF; }
    </style>
</head>

<body x-data="{ 'darkMode': false, 'sidebarToggle': false }"
    x-init="darkMode = JSON.parse(localStorage.getItem('darkMode') || 'false');
    $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{ 'dark bg-gray-900': darkMode === true }"
    class="relative min-w-screen page-bg">

    @include('admin.body.sidebar')
    <div x-show="sidebarToggle" @click="sidebarToggle = false"
        class="fixed inset-0 z-40 bg-black/50 lg:hidden" x-transition.opacity></div>
    @include('admin.body.header')

    <main class="pt-16 transition-all duration-300 p-5 lg:ml-64 z-10">
        <div class="mx-auto max-w-4xl">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-[#7A6F5C] mb-5">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#B78921] transition flex items-center gap-1">
                    <i class="fa-solid fa-house text-xs"></i> Dashboard
                </a>
                <i class="fa-solid fa-chevron-right text-xs text-[#B0A080]"></i>
                <a href="{{ route('admin.koleksi.index') }}" class="hover:text-[#B78921] transition">Koleksi</a>
                <i class="fa-solid fa-chevron-right text-xs text-[#B0A080]"></i>
                <span class="text-[#1D2745] font-semibold">Edit</span>
            </nav>

            {{-- Page Title --}}
            <div class="flex items-center gap-3 mb-6">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-[#3B5BDB] to-[#7048E8] flex items-center justify-center shadow-lg shadow-blue-400/30">
                    <i class="fa-solid fa-pen text-white text-sm"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-[#1D2745]">Edit Koleksi</h1>
                    <p class="text-sm text-[#7A6F5C]">Memperbarui data: <strong>{{ $koleksi->nama }}</strong></p>
                </div>
            </div>

            {{-- Error Box --}}
            @if ($errors->any())
                <div class="bg-red-50 border-2 border-red-200 rounded-2xl p-4 mb-5">
                    <p class="font-semibold text-red-700 text-sm mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i> Terdapat kesalahan:
                    </p>
                    <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.koleksi.update', $koleksi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- SECTION: Informasi Dasar --}}
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-icon">
                            <i class="fa-solid fa-circle-info text-[#3B5BDB] text-xs"></i>
                        </div>
                        Informasi Dasar
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Nama Koleksi <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama', $koleksi->nama) }}"
                                class="form-input @error('nama') border-red-400 @enderror">
                            @error('nama') <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Kategori <span class="text-red-500">*</span></label>
                            <select name="kategori_id" class="form-input @error('kategori_id') border-red-400 @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('kategori_id', $koleksi->kategori_id) == $category->id)>{{ $category->nama }}</option>
                                @endforeach
                            </select>
                            @error('kategori_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">No. Registrasi Baru <span class="text-red-500">*</span></label>
                            <input type="text" name="no_registrasi_baru" value="{{ old('no_registrasi_baru', $koleksi->no_registrasi_baru) }}"
                                class="form-input font-mono @error('no_registrasi_baru') border-red-400 @enderror">
                            @error('no_registrasi_baru') <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">No. Registrasi Lama</label>
                            <input type="text" name="no_registrasi_lama" value="{{ old('no_registrasi_lama', $koleksi->no_registrasi_lama) }}"
                                class="form-input font-mono">
                        </div>
                        <div>
                            <label class="form-label">Jenis Benda <span class="text-red-500">*</span></label>
                            <input type="text" name="jenis_benda" value="{{ old('jenis_benda', $koleksi->jenis_benda) }}"
                                class="form-input @error('jenis_benda') border-red-400 @enderror">
                            @error('jenis_benda') <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Asal / Daerah</label>
                            <input type="text" name="asal" value="{{ old('asal', $koleksi->asal) }}" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Tahun Pembuatan</label>
                            <input type="text" name="tahun_pembuatan" value="{{ old('tahun_pembuatan', $koleksi->tahun_pembuatan) }}" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Kondisi <span class="text-red-500">*</span></label>
                            <div class="flex flex-wrap gap-3 mt-1">
                                @foreach(['baik' => ['Baik', 'fa-circle-check'], 'rusak_ringan' => ['Rusak Ringan', 'fa-circle-exclamation'], 'rusak_berat' => ['Rusak Berat', 'fa-circle-xmark']] as $val => $data)
                                    <div>
                                        <input type="radio" id="kondisi_{{ $val }}" name="kondisi" value="{{ $val }}"
                                            class="kondisi-radio"
                                            {{ old('kondisi', $koleksi->kondisi) == $val ? 'checked' : '' }}>
                                        <label for="kondisi_{{ $val }}" class="kondisi-label">
                                            <i class="fa-solid {{ $data[1] }} text-xs"></i> {{ $data[0] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECTION: Deskripsi --}}
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-icon">
                            <i class="fa-solid fa-align-left text-[#3B5BDB] text-xs"></i>
                        </div>
                        Deskripsi Koleksi
                    </div>
                    <textarea name="deskripsi" rows="5"
                        placeholder="Tuliskan deskripsi lengkap koleksi..."
                        class="form-input" style="resize: vertical;">{{ old('deskripsi', $koleksi->deskripsi) }}</textarea>
                </div>

                {{-- SECTION: Media --}}
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-icon">
                            <i class="fa-solid fa-photo-film text-[#3B5BDB] text-xs"></i>
                        </div>
                        Media Koleksi
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Foto --}}
                        <div>
                            <label class="form-label mb-3">Foto Koleksi</label>
                            @if ($koleksi->foto)
                                <div class="mb-3 flex items-center gap-3 bg-[#F5EFE3] rounded-xl p-3">
                                    <img src="{{ asset($koleksi->foto) }}" class="w-16 h-16 rounded-xl object-cover" id="showFoto">
                                    <div>
                                        <p class="text-xs font-semibold text-[#1D2745]">Foto saat ini</p>
                                        <p class="text-xs text-[#9A8F7A]">Unggah baru untuk mengganti</p>
                                    </div>
                                </div>
                            @else
                                <img id="showFoto" class="hidden max-h-44 mx-auto rounded-xl object-contain mb-3">
                            @endif
                            <div class="upload-zone">
                                <input type="file" id="foto" name="foto" accept="image/*" onchange="previewFoto(this)">
                                <div class="pointer-events-none">
                                    <i class="fa-solid fa-cloud-arrow-up text-[#B78921] text-2xl mb-2"></i>
                                    <p class="text-sm font-semibold text-[#1D2745]">Unggah foto baru</p>
                                    <p class="text-xs text-[#9A8F7A] mt-1">JPEG, PNG · Maks 2MB · Opsional</p>
                                </div>
                            </div>
                            @error('foto') <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p> @enderror
                        </div>

                        {{-- Audio --}}
                        <div>
                            <label class="form-label mb-3">Audio Narasi</label>
                            @if ($koleksi->audio)
                                <div class="mb-3 bg-[#EEF2FF] rounded-xl p-3">
                                    <p class="text-xs font-semibold text-[#3B5BDB] mb-2"><i class="fa-solid fa-music mr-1"></i>Audio saat ini</p>
                                    <audio controls class="w-full rounded-lg">
                                        <source src="{{ asset($koleksi->audio) }}">
                                    </audio>
                                </div>
                            @endif
                            <audio id="audioPreview" controls class="hidden w-full rounded-xl mb-3"></audio>
                            <div class="upload-zone">
                                <input type="file" name="audio" accept="audio/*" onchange="previewAudio(this)">
                                <div class="pointer-events-none">
                                    <i class="fa-solid fa-cloud-arrow-up text-[#3B5BDB] text-2xl mb-2"></i>
                                    <p class="text-sm font-semibold text-[#1D2745]">Unggah audio baru</p>
                                    <p class="text-xs text-[#9A8F7A] mt-1">MP3, WAV, OGG · Maks 10MB · Opsional</p>
                                </div>
                            </div>
                            @error('audio') <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-between gap-3">
                    <a href="{{ route('admin.koleksi.index') }}" class="btn-secondary">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Batal
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fa-regular fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </main>

    <script>
        function previewFoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('showFoto');
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        function previewAudio(input) {
            if (input.files && input.files[0]) {
                const audio = document.getElementById('audioPreview');
                audio.src = URL.createObjectURL(input.files[0]);
                audio.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>
