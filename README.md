# 🏛️ MUSEWANGI (Museum Blambangan Banyuwangi)
> **Sistem Informasi Inventaris & Pemandu Digital Koleksi Bersejarah Berbasis QR Code**  
> *Dinas Kebudayaan dan Pariwisata Kabupaten Banyuwangi*

---

## 🌐 Akses Website Online (Production Live)

- 📱 **Halaman Pengunjung & Scanner QR:**  
  👉 **[https://musewangimvp-production.up.railway.app](https://musewangimvp-production.up.railway.app)**
- 🔐 **Panel Masuk Petugas & Admin:**  
  👉 **[https://musewangimvp-production.up.railway.app/login](https://musewangimvp-production.up.railway.app/login)**

---

## 🔑 Kredensial Akun Login Default

| Role | Username / Email | Kata Sandi (Password) | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `admin` *(atau `admin@gmail.com`)* | **`admin123`** | Akses penuh dashboard, kelola artefak, kategori, cetak QR, review, & kelola user |
| **Petugas / Loket** | `petugas` *(atau `kasir@gmail.com`)* | **`petugas123`** | Akses panel inventaris koleksi & scanner kuratorial |

---

## ✨ Fitur-Fitur Unggulan

### 1. 📱 Modul Pengunjung & Wisatawan (Mobile-First & Desktop Responsive)
- **Beranda Interaktif:** Menampilkan katalog artefak bersejarah, ringkasan jumlah koleksi, kategori kuratorial, dan panduan digital.
- **Scanner QR Kamera Cepat (24 FPS):** Memindai label QR pada etalase museum secara instan langsung dari browser smartphone tanpa perlu menginstal aplikasi tambahan.
- **Detail Artefak Kaya Informasi:**
  - Foto artefak multi-sudut (*Depan, Samping, Belakang*).
  - *Golden Reading Progress Bar* saat membaca deskripsi artefak.
  - *Audio Guide Player* dengan visualizer gelombang suara untuk mendengar narasi sejarah.
  - Form ulasan & rating pengalaman pengunjung.
- **Modal Informasi Museum:** Jadwal operasional sesi kunjungan, tarif retribusi tiket masuk, dan alamat lokasi GPS Museum Blambangan.
- **Floating Bottom Navigation Bar:** Navigasi ergonomis di smartphone dan berubah menjadi *floating dock* modern di layar desktop/tablet.

### 2. 🛡️ Modul Admin & Kurator Museum
- **Dashboard Statistik:** Ringkasan total koleksi, kategori aktif, kondisi artefak (*Baik, Rusak Ringan, Rusak Berat*), dan ulasan pengunjung.
- **Manajemen Koleksi (CRUD):** Tambah, edit, dan hapus artefak lengkap dengan upload foto multi-sudut, rekaman audio narasi, nomor registrasi, dan dimensi.
- **Auto QR Code Generator:** Pembuatan QR Code SVG/PNG otomatis beresolusi tinggi untuk setiap artefak.
- **Cetak Plakat Etalase PDF:** Fitur cetak plakat fisik etalase siap tempel dengan nomor registrasi dan QR Code resmi.
- **Manajemen Kategori Kuratorial:** Klasifikasi artefak berdasarkan standar kuratorial (Arkeologi, Etnografi, Numismatika, Filologi, Keramologi, Seni Rupa, dll.).
- **Manajemen Ulasan & Pengguna:** Moderasi testimoni pengunjung dan pengaturan akun admin/petugas.

---

## 💻 Panduan Menjalankan Proyek di Komputer Lokal (Localhost)

### 📋 Prasyarat Sistem:
- **PHP** >= 8.2 (dengan ekstensi `pdo_sqlite` atau `pdo_mysql`, `gd`, `fileinfo`, `mbstring`, `zip`)
- **Composer** >= 2.x
- **Node.js** >= 18.x & **NPM**
- **XAMPP / MySQL** (Opsional jika menggunakan SQLite)

---

### 🚀 Langkah Instalasi Cepat (Quick Start):

1. **Clone Repositori:**
   ```bash
   git clone https://github.com/fitriaayupratiwi/Musewangi_MVP.git
   cd Musewangi_MVP
   ```

2. **Install Dependensi PHP & Node.js:**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment (`.env`):**
   Salin file konfigurasi contoh:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi Database & Data Awal:**
   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```

5. **Kompilasi Aset Frontend (Tailwind + Vite):**
   ```bash
   npm run build
   # atau untuk mode development:
   # npm run dev
   ```

6. **Jalankan Server Lokal:**
   ```bash
   php artisan serve
   ```
   Buka peramban Anda di: **`http://127.0.0.1:8000`**

---

## 📱 Cara Menguji Kamera HP via Jaringan Wi-Fi Lokal

Agar browser smartphone dapat mengakses kamera scanner QR pada localhost:

1. **Jalankan artisan serve dengan host `0.0.0.0`:**
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```
2. **Cari Alamat IP Laptop Anda (IPv4):**
   - Di terminal Windows: ketik `ipconfig` (misal: `192.168.1.15`).
3. **Buka di HP:** Buka `http://192.168.1.15:8000`.
4. **Aktifkan Izin Kamera di Chrome HP:**
   - Buka `chrome://flags` di Chrome HP Anda.
   - Cari: `unsafely-treat-insecure-origin-as-secure`.
   - Masukkan: `http://192.168.1.15:8000` $\rightarrow$ set ke **Enabled** $\rightarrow$ klik **Relaunch**.
   - Kamera scanner QR akan langsung aktif!

---

## ☁️ Struktur Deployment Cloud PaaS (Railway / Docker)

Aplikasi ini telah dilengkapi dengan kontainerisasi multi-stage siap pakai:
- **`Dockerfile`**: Image PHP 8.2-FPM Alpine + Nginx + Node.js 20 + SQLite & GD.
- **`docker/nginx.conf`**: Konfigurasi server Nginx multi-port (Port 80 & 8080).
- **`docker/entrypoint.sh`**: Skrip startup otomatis untuk migrasi database, storage linking, dan inisialisasi permission.

---

## 🏛️ Informasi Lokasi Museum Blambangan
- **Alamat:** Jl. Jenderal Ahmad Yani No.78, Taman Baru, Kec. Banyuwangi, Kabupaten Banyuwangi, Jawa Timur 68416
- **Jam Kunjungan:**
  - Sesi I: 08:00 – 10:00 WIB
  - Sesi II: 10:00 – 12:00 WIB
  - Sesi III: 13:00 – 15:00 WIB
- **Retribusi Tiket:** Pelajar/Mahasiswa (Rp 5.000), Umum (Rp 7.500), Mancanegara (Rp 20.000).

---
*Dikembangkan dengan penuh dedikasi untuk pelestarian warisan budaya Banyuwangi.*
