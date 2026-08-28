# 🏛️ MUSEWANGI (Museum Blambangan Banyuwangi)
> **Sistem Informasi Inventarisasi, Katalog Kuratorial, & Pemandu Wisata Digital Berbasis QR Code**  
> *Dinas Kebudayaan dan Pariwisata Kabupaten Banyuwangi*

---

## 📑 Daftar Isi
1. [Tentang Sistem](#-tentang-sistem)
2. [Akses Website Online (Production)](#-akses-website-online-production)
3. [Kredensial Akun Pengguna](#-kredensial-akun-pengguna)
4. [Panduan Lengkap Pengujian Sistem (Testing Guide)](#-panduan-lengkap-pengujian-sistem-testing-guide)
   - [Uji 1: Eksplorasi Katalog & Informasi Museum](#skenario-1-eksplorasi-katalog--informasi-museum-pengunjung)
   - [Uji 2: Detail Artefak & Audio Guide Narasi](#skenario-2-detail-artefak--audio-guide-narasi)
   - [Uji 3: Scanner QR Code Kamera HP](#skenario-3-scanner-qr-code-kamera-smartphone)
   - [Uji 4: Autentikasi Login & Role-Based Access](#skenario-4-autentikasi-login--hak-akses)
   - [Uji 5: Manajemen Koleksi & Cetak Plakat QR PDF](#skenario-5-manajemen-koleksi-crud--cetak-plakat-qr-pdf)
   - [Uji 6: Manajemen Kategori Kuratorial](#skenario-6-manajemen-kategori-kuratorial)
5. [Panduan Instalasi di Komputer Lokal (Localhost)](#-panduan-instalasi-di-komputer-lokal-localhost)
6. [Pengujian Kamera HP di Jaringan Wi-Fi Lokal](#-pengujian-kamera-hp-di-jaringan-wi-fi-lokal)
7. [Struktur Teknologi & Arsitektur](#-struktur-teknologi--arsitektur)
8. [Informasi Jam Operasional & Tiket Museum](#-informasi-jam-operasional--tiket-museum)

---

## 📖 Tentang Sistem

**MUSEWANGI** adalah aplikasi web modern (*Progressive Web Experience*) yang dirancang khusus untuk memodernisasi layanan Museum Blambangan Banyuwangi. Sistem ini mengintegrasikan dua pilar utama:

1. **Pemandu Wisata Interaktif Pengunjung:** Memungkinkan wisatawan mengakses informasi artefak secara mandiri langsung melalui pemindaian QR Code di etalase museum, mendengarkan narasi audio multi-bahasa (*Audio Guide*), melihat foto multi-sudut 3D, serta memberikan ulasan pengalaman kunjungan.
2. **Sistem Inventarisasi & Kuratorial Admin:** Memfasilitasi kurator dan pengelola museum dalam mencatat inventaris resmi, mengelompokkan koleksi sesuai 8 kategori kuratorial, menghasilkan kode QR beresolusi tinggi, dan mencetak plakat etalase standar museum dalam format PDF.

---

## 🌐 Akses Website Online (Production)

Aplikasi telah terpasang dan dapat diakses secara publik melalui jaringan internet:

- 📱 **Halaman Pengunjung & Pemandu Digital:**  
  👉 **[https://musewangimvp-production.up.railway.app](https://musewangimvp-production.up.railway.app)**
- 📷 **Scanner QR Code Kamera:**  
  👉 **[https://musewangimvp-production.up.railway.app/scan](https://musewangimvp-production.up.railway.app/scan)**
- 🔐 **Panel Masuk Petugas & Admin:**  
  👉 **[https://musewangimvp-production.up.railway.app/login](https://musewangimvp-production.up.railway.app/login)**

---

## 🔑 Kredensial Akun Pengguna

Sistem dilengkapi dengan akun bawaan (*pre-seeded*) dengan pembagian hak akses (*Role-Based Access Control*):

| Role / Peran | Username | Email Alternatif | Kata Sandi (Password) | Hak Akses Utama |
| :--- | :--- | :--- | :--- | :--- |
| 🛡️ **Super Admin** | **`admin`** | `admin@gmail.com` | **`admin123`** | Akses penuh dashboard statistik, kelola koleksi, kelola kategori, cetak plakat QR, moderasi ulasan, dan manajemen pengguna. |
| 🎟️ **Petugas / Loket** | **`petugas`** | `kasir@gmail.com` | **`petugas123`** | Akses panel data inventaris, verifikasi status artefak, dan scanner kuratorial. |

---

## 🧪 Panduan Lengkap Pengujian Sistem (Testing Guide)

Berikut adalah panduan langkah demi langkah untuk menguji seluruh fungsionalitas sistem secara komprehensif:

### Skenario 1: Eksplorasi Katalog & Informasi Museum (Pengunjung)
1. Buka browser dan akses **`https://musewangimvp-production.up.railway.app`**.
2. **Uji Filter Kategori:**
   - Klik salah satu pill kategori kuratorial (*misal: Etnografi, Arkeologi, Filologi*).
   - Pastikan daftar koleksi otomatis tersaring secara instan tanpa reload halaman.
   - Klik kembali **"Semua Koleksi"** untuk menampilkan seluruh data.
3. **Uji Pencarian Cepat:**
   - Ketikkan kata kunci pada kolom pencarian (*misal: "Keris", "Batik", atau "MB-ARK"*).
   - Pastikan kartu artefak yang sesuai langsung muncul.
4. **Uji Modal Informasi Museum:**
   - Klik ikon **`Info Museum`** pada navigasi bawah atau header.
   - Pastikan muncul jendela pop-up yang memuat:
     - **Sesi Jam Kunjungan:** Sesi I (08:00–10:00), Sesi II (10:00–12:00), Sesi III (**13:00–16:00 WIB**).
     - **Tarif Retribusi Tiket:** Pelajar Rp 5.000, Umum Rp 7.500, Mancanegara Rp 20.000.
     - **Alamat Lengkap & Peta GPS** Museum Blambangan.

---

### Skenario 2: Detail Artefak & Audio Guide Narasi
1. Pada katalog beranda, klik salah satu kartu artefak (*misal: Keris Luk 13 Dhapur Sengkelat*).
2. **Uji Galeri Multi-Sudut:**
   - Klik tab sudut foto **"Tampak Depan"**, **"Samping"**, atau **"Belakang"**.
   - Klik foto utama untuk membuka mode pembesar (*Lightbox Zoom*).
3. **Uji Audio Guide Narasi:**
   - Tekan tombol **Play (▶)** pada pemutar audio guide.
   - Pastikan animasi gelombang suara (*audio visualizer*) bergerak dan durasi waktu berjalan.
4. **Uji Golden Reading Progress Bar:**
   - Gulir layar ke bawah membaca deskripsi sejarah artefak.
   - Perhatikan garis emas tipis di bagian atas layar bergerak sesuai persentase scroll pembaca.
5. **Uji Formulir Ulasan Pengunjung:**
   - Gulir ke bagian bawah pada seksi **"Ulasan Pengunjung"**.
   - Pilih bintang rating (1 sampai 5), ketikkan nama dan komentar ulasan, lalu klik **"Kirim Ulasan"**.

---

### Skenario 3: Scanner QR Code Kamera Smartphone
1. Pada menu navigasi bawah, ketuk tombol emas bundar **"Scan QR"** (atau buka URL `/scan`).
2. **Jika membuka dari Smartphone via HTTPS:**
   - Browser akan meminta izin kamera (*"Allow Camera Access"*).
   - Berikan izin (*Allow*). Kamera belakang smartphone akan aktif dalam mode *Full Viewport 24 FPS*.
   - Arahkan kamera ke QR Code artefak (atau QR code uji coba).
3. **Uji Pemindaian & Redirect Otomatis:**
   - Saat QR Code terdeteksi, layar akan menampilkan animasi konfirmasi centang hijau dan otomatis mengarahkan ke halaman detail artefak yang bersangkutan.
4. **Uji Simulasi Langsung (Tanpa Kamera Fisik):**
   - Anda juga dapat langsung menguji alur verifikasi dengan membuka URL contoh:  
     `https://musewangimvp-production.up.railway.app/koleksi/keris-luk-13-sengkelat`  
     `https://musewangimvp-production.up.railway.app/koleksi/arca-mahadewa-abad-14`

---

### Skenario 4: Autentikasi Login & Hak Akses
1. Buka halaman login di **`https://musewangimvp-production.up.railway.app/login`**.
2. **Uji Login Valid:**
   - Masukkan Username: `admin` dan Password: `admin123`.
   - Klik **"Masuk ke Panel"**.
   - Sistem akan mengarahkan Anda ke **Dashboard Admin** (`/admin/dashboard`).
3. **Uji Login Gagal (Validasi Keamanan):**
   - Coba masukkan password yang salah.
   - Pastikan muncul notifikasi peringatan merah: *"Username/Email atau Password yang Anda masukkan tidak sesuai."*
4. **Uji Logout:**
   - Klik menu profil di pojok kanan atas, lalu pilih **"Keluar / Logout"**.
   - Pastikan sesi berakhir dan dialihkan kembali ke halaman utama.

---

### Skenario 5: Manajemen Koleksi (CRUD) & Cetak Plakat QR PDF
1. Login sebagai **Super Admin**.
2. Masuk ke menu **"Koleksi"** di bilah navigasi samping (*sidebar*).
3. **Uji Tambah Koleksi Baru:**
   - Klik tombol **"+ Tambah Koleksi"**.
   - Isi form: Nomor Registrasi, Nama Koleksi, Kategori Kuratorial, Asal-Usul, Kondisi (*Baik / Rusak Ringan / Rusak Berat*), dan Deskripsi.
   - Unggah foto artefak dan rekaman suara (*voice over*).
   - Klik **"Simpan Koleksi"**.
4. **Uji Cetak Plakat Etalase PDF:**
   - Pada baris data koleksi yang baru dibuat, klik tombol **"Cetak Plakat QR"**.
   - Sistem akan mengunduh dokumen PDF plakat resmi yang berisi kop Museum Blambangan, nama artefak, nomor registrasi, dan QR Code siap cetak/tempel pada etalase kaca museum.
5. **Uji Edit & Hapus Koleksi:**
   - Klik tombol edit (ikon pensil emas) untuk mengubah data koleksi.
   - Klik tombol hapus (ikon tempat sampah merah) untuk menghapus koleksi (didukung konfirmasi *SweetAlert2*).

---

### Skenario 6: Manajemen Kategori Kuratorial
1. Pada sidebar Admin, klik menu **"Kategori"**.
2. **Uji Tambah Kategori:**
   - Klik **"+ Tambah Kategori"**.
   - Masukkan nama kategori baru (*contoh: "Koleksi Khusus Geopark"*).
   - Klik **Simpan**.
3. **Verifikasi Sinkronisasi Real-Time:**
   - Buka tab baru di browser dan akses halaman beranda pengunjung (`/`).
   - Kategori baru tersebut akan **langsung muncul di bilah filter kategori pengunjung** secara otomatis.

---

## 💻 Panduan Instalasi di Komputer Lokal (Localhost)

### 📋 Prasyarat Perangkat Lunak:
- **PHP** >= 8.2 (dengan ekstensi `pdo_sqlite`, `pdo_mysql`, `gd`, `fileinfo`, `mbstring`, `openssl`, `curl`)
- **Composer** >= 2.x
- **Node.js** >= 18.x & **NPM**
- **Git**

---

### 🚀 Langkah Instalasi:

1. **Clone Repositori dari GitHub:**
   ```bash
   git clone https://github.com/fitriaayupratiwi/Musewangi_MVP.git
   cd Musewangi_MVP
   ```

2. **Pasang Dependensi PHP (Composer):**
   ```bash
   composer install
   ```

3. **Pasang Dependensi Frontend (NPM):**
   ```bash
   npm install
   ```

4. **Konfigurasi File Environment (`.env`):**
   Salin file template konfigurasi:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Catatan: Pastikan di dalam file `.env` terkonfigurasi `DB_CONNECTION=sqlite`.*

5. **Jalankan Migrasi Database & Data Awal:**
   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```

6. **Kompilasi Aset Frontend (Tailwind + Vite):**
   ```bash
   npm run build
   ```

7. **Jalankan Web Server Lokal:**
   ```bash
   php artisan serve
   ```
   Buka browser Anda di: **`http://127.0.0.1:8000`**

---

## 📱 Pengujian Kamera HP di Jaringan Wi-Fi Lokal

Standar keamanan browser modern mewajibkan protokol **HTTPS** agar fitur kamera (*WebRTC / MediaDevices*) dapat diakses. Untuk menguji kamera smartphone pada laptop lokal melalui jaringan Wi-Fi:

1. **Jalankan Artisan Serve dengan Host Publik:**
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```
2. **Cari Tahu Alamat IP Laptop Anda:**
   - Buka Command Prompt / PowerShell, ketik: `ipconfig`
   - Catat alamat **IPv4 Address** (contoh: `192.168.1.25`).
3. **Buka Alamat di Smartphone:**
   - Sambungkan HP ke jaringan Wi-Fi yang sama dengan laptop.
   - Buka browser Chrome di HP: `http://192.168.1.25:8000`.
4. **Aktifkan Izin Kamera di Chrome HP (Bypass HTTP Insecure):**
   - Buka tab baru di Chrome HP, ketik di address bar: `chrome://flags`
   - Cari pengaturan: **`Insecure origins treated as secure`**
   - Masukkan alamat IP laptop Anda: `http://192.168.1.25:8000`
   - Ubah status dari *Disabled* menjadi **Enabled**.
   - Ketuk tombol **Relaunch** di kanan bawah browser.
5. **Kamera Scanner QR HP kini aktif 100% pada lingkungan localhost!** 📷✨

---

## 🏗️ Struktur Teknologi & Arsitektur

| Komponen | Teknologi yang Digunakan | Penjelasan Fungsi |
| :--- | :--- | :--- |
| **Backend Framework** | Laravel 12.x (PHP 8.2) | Logika bisnis, autentikasi, ORM Eloquent, dan REST routing |
| **Database Engine** | SQLite (Production Standalone) & MySQL Compatible | Penyimpanan data relasional koleksi, kategori, user, dan review |
| **Frontend Styling** | Tailwind CSS v3 + Plus Jakarta Sans | Tata letak responsif bertema museum emas & *navy blue* |
| **Reaktivitas UI** | Alpine.js 3.x | Filter kategori real-time, modal interaktif, dan pencarian cepat |
| **QR Code Engine** | SimpleSoftwareIO / Endroid QrCode + `html5-qrcode` | Generator QR SVG beresolusi tinggi & scanner kamera 24 FPS |
| **Media & Audio** | HTML5 Audio Web API | Narasi pemandu digital dengan kontrol visualizer |
| **Cetak Dokumen** | Barryvdh / DomPDF | Generator plakat etalase PDF siap cetak |
| **Kontainerisasi** | Docker + PHP 8.2 Alpine + Nginx | Image produksi multi-stage dengan Nginx port-forwarding |

---

## 🏛️ Informasi Jam Operasional & Tiket Museum

- **Nama Tempat:** Museum Blambangan Banyuwangi
- **Instansi Pembina:** Dinas Kebudayaan dan Pariwisata Kabupaten Banyuwangi
- **Alamat:** Jl. Jenderal Ahmad Yani No.78, Taman Baru, Kec. Banyuwangi, Kabupaten Banyuwangi, Jawa Timur 68416
- **Jadwal Sesi Kunjungan:**
  - 🌅 **Sesi I:** 08:00 WIB – 10:00 WIB
  - ☀️ **Sesi II:** 10:00 WIB – 12:00 WIB
  - 🌇 **Sesi III:** 13:00 WIB – 16:00 WIB
- **Tarif Retribusi Resmi:**
  - Pelajar / Mahasiswa: **Rp 5.000**
  - Pengunjung Umum: **Rp 7.500**
  - Wisatawan Mancanegara: **Rp 20.000**

---

*Dikembangkan dengan penuh dedikasi sebagai platform pelestarian dan edukasi warisan budaya Blambangan Banyuwangi.*
