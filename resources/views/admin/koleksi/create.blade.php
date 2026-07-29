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
    <title>Admin Musewangi | Tambah Koleksi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .page-bg { background: linear-gradient(135deg, #F5EFE3 0%, #EDE3CF 40%, #F0E8D5 100%); min-height: 100vh; }

        .form-input {
            width: 100%;
            border-radius: 12px;
            border: 1.5px solid #DDD0A8;
            background: #FFFBF0;
            padding: 10px 14px;
            font-size: 14px;
            color: #202020;
            outline: none;
            transition: all 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .form-input:focus {
            border-color: #B78921;
            box-shadow: 0 0 0 3px rgba(183,137,33,0.15);
        }
        .form-input::placeholder { color: #B0A080; }
        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #1D2745;
            margin-bottom: 6px;
        }
        .form-section {
            background: white;
            border-radius: 18px;
            border: 1.5px solid #EDD9A3;
            padding: 24px;
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #1D2745;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1.5px solid #F0E4C2;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-icon {
            width: 28px; height: 28px;
            border-radius: 8px;
            background: linear-gradient(135deg, #FFF3D1, #FFE5A0);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        /* Upload area */
        .upload-zone {
            border: 2px dashed #DDD0A8;
            border-radius: 14px;
            background: #FFFBF2;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        .upload-zone:hover {
            border-color: #B78921;
            background: #FFF8E8;
        }
        .upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
        }

        /* Radio kondisi */
        .kondisi-radio { display: none; }
        .kondisi-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 10px;
            border: 1.5px solid #DDD0A8;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
            background: white;
        }
        .kondisi-radio:checked + .kondisi-label {
            border-color: #B78921;
            background: linear-gradient(135deg, #FFF3D1, #FFE5A0);
            color: #7B5200;
        }
        .kondisi-radio[value="baik"]:checked + .kondisi-label { border-color: #10B981; background: #ECFDF5; color: #065F46; }
        .kondisi-radio[value="rusak_ringan"]:checked + .kondisi-label { border-color: #F59E0B; background: #FFFBEB; color: #92400E; }
        .kondisi-radio[value="rusak_berat"]:checked + .kondisi-label { border-color: #EF4444; background: #FEF2F2; color: #991B1B; }

        /* Error alert */
        .error-box {
            background: #FEF2F2;
            border: 1.5px solid #FECACA;
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 20px;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, #B78921, #D4A82A);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 11px 28px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s;
            box-shadow: 0 4px 14px rgba(183,137,33,0.35);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #9A7219, #B78921);
            box-shadow: 0 6px 20px rgba(183,137,33,0.45);
            transform: translateY(-1px);
        }
        .btn-secondary {
            background: white;
            color: #555;
            border: 1.5px solid #DDD0A8;
            border-radius: 12px;
            padding: 11px 24px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-secondary:hover {
            border-color: #B78921;
            color: #1D2745;
            background: #FFF8E8;
        }
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
                <span class="text-[#1D2745] font-semibold">Tambah</span>
            </nav>

            {{-- Page Title --}}
            <div class="flex items-center gap-3 mb-6">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-[#B78921] to-[#E8B84B] flex items-center justify-center shadow-lg shadow-yellow-400/30">
                    <i class="fa-solid fa-plus text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-[#1D2745]">Tambah Koleksi</h1>
                    <p class="text-sm text-[#7A6F5C]">Daftarkan koleksi baru ke database museum</p>
                </div>
            </div>

            {{-- Error Box --}}
            @if ($errors->any())
                <div class="error-box mb-5">
                    <p class="font-semibold text-red-700 text-sm mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i> Terdapat kesalahan pada formulir:
                    </p>
                    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.koleksi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- SECTION: Informasi Dasar --}}
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-icon">
                            <i class="fa-solid fa-circle-info text-[#B78921] text-xs"></i>
                        </div>
                        Informasi Dasar
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Nama Koleksi <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                placeholder="Masukkan nama koleksi"
                                class="form-input @error('nama') border-red-400 @enderror">
                            @error('nama') <p class="text-xs text-red-500 mt-1.5"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Kategori <span class="text-red-500">*</span></label>
                            <select name="kategori_id" class="form-input @error('kategori_id') border-red-400 @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('kategori_id') == $category->id)>{{ $category->nama }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-[#9A8F7A] mt-1.5">
                                <a href="{{ route('admin.kategori.menu') }}" class="text-[#B78921] hover:underline">Tambah kategori baru</a>
                            </p>
                            @error('kategori_id') <p class="text-xs text-red-500 mt-1"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">No. Registrasi Baru <span class="text-red-500">*</span></label>
                            <input type="text" name="no_registrasi_baru" value="{{ old('no_registrasi_baru') }}"
                                placeholder="Nomor registrasi baru"
                                class="form-input font-mono @error('no_registrasi_baru') border-red-400 @enderror">
                            @error('no_registrasi_baru') <p class="text-xs text-red-500 mt-1.5"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">No. Registrasi Lama</label>
                            <input type="text" name="no_registrasi_lama" value="{{ old('no_registrasi_lama') }}"
                                placeholder="Nomor registrasi lama (opsional)"
                                class="form-input font-mono">
                        </div>
                        <div>
                            <label class="form-label">Jenis Benda <span class="text-red-500">*</span></label>
                            <input type="text" name="jenis_benda" value="{{ old('jenis_benda') }}"
                                placeholder="Contoh: Keris, Guci, Naskah"
                                class="form-input @error('jenis_benda') border-red-400 @enderror">
                            @error('jenis_benda') <p class="text-xs text-red-500 mt-1.5"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="form-label">Asal / Daerah</label>
                            <input type="text" name="asal" value="{{ old('asal') }}"
                                placeholder="Contoh: Banyuwangi, Jawa Timur"
                                class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Tahun Pembuatan</label>
                            <input type="text" name="tahun_pembuatan" value="{{ old('tahun_pembuatan') }}"
                                placeholder="Contoh: 1850 / Abad ke-19"
                                class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Kondisi <span class="text-red-500">*</span></label>
                            <div class="flex flex-wrap gap-3 mt-1">
                                @foreach(['baik' => ['Baik', 'fa-circle-check'], 'rusak_ringan' => ['Rusak Ringan', 'fa-circle-exclamation'], 'rusak_berat' => ['Rusak Berat', 'fa-circle-xmark']] as $val => $data)
                                    <div>
                                        <input type="radio" id="kondisi_{{ $val }}" name="kondisi" value="{{ $val }}"
                                            class="kondisi-radio"
                                            {{ old('kondisi', 'baik') == $val ? 'checked' : '' }}>
                                        <label for="kondisi_{{ $val }}" class="kondisi-label">
                                            <i class="fa-solid {{ $data[1] }} text-xs"></i> {{ $data[0] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('kondisi') <p class="text-xs text-red-500 mt-1.5"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- SECTION: Deskripsi --}}
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-icon">
                            <i class="fa-solid fa-align-left text-[#B78921] text-xs"></i>
                        </div>
                        Deskripsi Koleksi
                    </div>
                    <textarea name="deskripsi" rows="5"
                        placeholder="Tuliskan deskripsi lengkap koleksi, termasuk sejarah, fungsi, dan makna budayanya..."
                        class="form-input" style="resize: vertical;">{{ old('deskripsi') }}</textarea>
                </div>

                {{-- SECTION: Media --}}
                <div class="form-section">
                    <div class="section-title">
                        <div class="section-icon">
                            <i class="fa-solid fa-photo-film text-[#B78921] text-xs"></i>
                        </div>
                        Media Koleksi
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Foto Upload --}}
                        <div>
                            <label class="form-label mb-3">Foto Koleksi</label>
                            <div class="upload-zone" id="fotoZone">
                                <input type="file" id="foto" name="foto" accept="image/*" onchange="previewFoto(this)">
                                <div id="fotoPlaceholder">
                                    <div class="w-14 h-14 rounded-2xl bg-[#FFF3D1] flex items-center justify-center mx-auto mb-3">
                                        <i class="fa-solid fa-image text-[#B78921] text-xl"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-[#1D2745]">Klik atau seret foto ke sini</p>
                                    <p class="text-xs text-[#9A8F7A] mt-1">JPEG, PNG, GIF, SVG · Maks 2MB</p>
                                </div>
                                <img id="showFoto" class="hidden max-h-44 mx-auto rounded-xl object-contain mt-2">
                            </div>
                            @error('foto') <p class="text-xs text-red-500 mt-1.5"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p> @enderror
                        </div>

                        {{-- Audio Upload --}}
                        <div>
                            <label class="form-label mb-3">Audio Narasi</label>
                            <div class="upload-zone" id="audioZone">
                                <input type="file" name="audio" accept="audio/*" onchange="previewAudio(this)">
                                <div id="audioPlaceholder">
                                    <div class="w-14 h-14 rounded-2xl bg-[#EEF2FF] flex items-center justify-center mx-auto mb-3">
                                        <i class="fa-solid fa-microphone text-[#3B5BDB] text-xl"></i>
                                    </div>
                                    <p class="text-sm font-semibold text-[#1D2745]">Klik atau seret audio ke sini</p>
                                    <p class="text-xs text-[#9A8F7A] mt-1">MP3, WAV, OGG · Maks 10MB · Opsional</p>
                                </div>
                                <audio id="audioPreview" controls class="hidden w-full mt-2 rounded-lg"></audio>
                            </div>
                            @error('audio') <p class="text-xs text-red-500 mt-1.5"><i class="fa-solid fa-circle-exclamation mr-1"></i>{{ $message }}</p> @enderror
                        </div>

                    </div>

                    <div class="mt-4 flex items-start gap-2 bg-[#F0F9FF] border border-[#BAE6FD] rounded-xl p-3">
                        <i class="fa-solid fa-qrcode text-[#0284C7] mt-0.5 text-sm flex-shrink-0"></i>
                        <p class="text-xs text-[#0369A1]">
                            <strong>QR Code</strong> akan dibuat secara otomatis setelah koleksi berhasil disimpan dan dapat digunakan pengunjung untuk mengakses detail koleksi.
                        </p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-between gap-3">
                    <a href="{{ route('admin.koleksi.index') }}" class="btn-secondary">
                        <i class="fa-solid fa-arrow-left text-xs"></i> Batal
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fa-regular fa-floppy-disk"></i> Simpan Koleksi
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
                    const placeholder = document.getElementById('fotoPlaceholder');
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewAudio(input) {
            if (input.files && input.files[0]) {
                const audio = document.getElementById('audioPreview');
                const placeholder = document.getElementById('audioPlaceholder');
                audio.src = URL.createObjectURL(input.files[0]);
                audio.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
        }
    </script>
</body>

</html>
