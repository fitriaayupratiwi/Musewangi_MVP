# 🏛️ MUSEWANGI (Museum Blambangan Banyuwangi)
### Sistem Informasi Inventaris & Pemandu Digital Koleksi Berbasis QR Code

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Vite](https://img.shields.io/badge/Vite-6.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)

**MUSEWANGI** adalah platform web terpadu yang dikembangkan untuk digitalisasi kuratorial dan pengalaman pengunjung di **Museum Blambangan Banyuwangi** (di bawah naungan Dinas Kebudayaan dan Pariwisata Kabupaten Banyuwangi).

Sistem ini memadukan **Pemandu Digital Pengunjung (*Mobile-First Visitor Guide*)** dengan **Pemindai Kamera Layar Penuh (ala QRIS DANA)**, **Audio Guide Bilingual (Indonesia & English)**, **Label Etalase A5 Berornamen Batik Gajah Oling**, serta **Panel Pengelolaan Kuratorial Lengkap**.

---

## 📑 Daftar Isi
1. [Prasyarat Sistem (*Requirements*)](#-prasyarat-sistem-requirements)
2. [Panduan Menjalankan Proyek (*Quick Start*)](#-panduan-menjalankan-proyek-quick-start)
3. [Akun Login Petugas / Admin](#-akun-login-petugas--admin)
4. [Daftar Rute & URL Utama](#-daftar-rute--url-utama)
5. [Cara Mencoba di HP / Smartphone via Wi-Fi](#-cara-mencoba-di-hp--smartphone-via-wi-fi)
6. [Panduan Mengaktifkan Kamera HP (*Troubleshooting Kamera*)](#-panduan-mengaktifkan-kamera-hp-troubleshooting-kamera)
7. [Fitur-Fitur Utama Sistem](#-fitur-fitur-utama-sistem)
8. [Perintah Perawatan (*Troubleshooting & Cache Clear*)](#-perintah-perawatan-troubleshooting--cache-clear)

---

## ⚙️ Prasyarat Sistem (*Requirements*)

Pastikan komputer/laptop Anda telah terpasang:
- **PHP 8.2 atau lebih baru** (Direkomendasikan PHP 8.2 / 8.3 / 8.4)
- **Composer 2.x**
- **Node.js 18+ & NPM**
- **MySQL / MariaDB** (via XAMPP, Laragon, atau MySQL Standalone)
- **Ekstensi PHP wajib aktif di `php.ini`**:
  ```ini
  extension=gd
  extension=fileinfo
  extension=pdo_mysql
  extension=curl
  extension=mbstring
  ```

---

## 🚀 Panduan Menjalankan Proyek (*Quick Start*)

Ikuti langkah-langkah berikut secara berurutan untuk menjalankan proyek dari awal:

### 1. Masuk ke Direktori Proyek
Buka terminal (Git Bash / PowerShell / Command Prompt):
```bash
cd Musewangi_MVP
```

### 2. Pasang Dependency Backend (PHP)
```bash
composer install
```

### 3. Pasang Dependency Frontend (Node.js)
```bash
npm install
```

### 4. Konfigurasi Berkas Lingkungan (`.env`)
Salin file template `.env.example` menjadi `.env`:
- **Windows (PowerShell / CMD):**
  ```powershell
  copy .env.example .env
  ```
- **Git Bash / Linux / macOS:**
  ```bash
  cp .env.example .env
  ```

Buka file `.env` dan pastikan konfigurasi database sudah sesuai:
```env
APP_NAME=MUSEWANGI
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventaris
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Buat Application Key
```bash
php artisan key:generate
```

### 6. Buat Database MySQL
Buka **phpMyAdmin** (`http://localhost/phpmyadmin`) atau jalankan query MySQL:
```sql
CREATE DATABASE inventaris;
```

### 7. Jalankan Migrasi & Database Seeder
Lakukan migrasi tabel sekaligus mengisi data awal (*admin, koleksi artefak, kategori, dan ulasan*):
```bash
php artisan migrate --seed
```

### 8. Buat Symlink Storage (Wajib untuk Foto & Audio)
Perintah ini menghubungkan folder upload foto/audio koleksi agar dapat diakses di browser:
```bash
php artisan storage:link
```

### 9. Kompilasi Aset Frontend (CSS & JavaScript)
Ada 2 pilihan untuk menjalankan frontend:
- **Pilihan A (Rekomendasi - Mode Produksi Cepat):**
  ```bash
  npm run build
  ```
  *(Cukup dijalankan sekali, aset langsung siap pakai tanpa perlu membuka terminal terpisah)*.

- **Pilihan B (Mode Development Hot-Reload):**
  ```bash
  npm run dev
  ```

### 10. Jalankan Server Lokal Laravel
Jalankan server agar dapat diakses dari laptop dan HP di jaringan Wi-Fi yang sama:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Buka peramban (browser) di laptop Anda:
👉 **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🔐 Akun Login Petugas / Admin

Untuk masuk ke Panel Admin Inventaris & Kurator Museum, gunakan kredensial berikut:

| Keterangan | Kredensial |
| :--- | :--- |
| **URL Login** | `http://127.0.0.1:8000/login` |
| **Username** | `admin` |
| **Email Alternatif** | `admin@gmail.com` |
| **Password** | `admin123` |
| **Hak Akses (*Role*)** | Super Administrator (Akses Penuh) |

> **Catatan Keamanan:** Form login mendukung login simultan menggunakan **Username** maupun **Email**.

---

## 🗺️ Daftar Rute & URL Utama

| Modul Halaman | URL Path | Keterangan |
| :--- | :--- | :--- |
| **Beranda Pengunjung** | `/` | Dashboard mobile-first pengunjung, katalog artefak, dan info museum |
| **Pemindai Kamera QR** | `/scan` | Pemindai kamera layar penuh 24 FPS ala DANA QRIS |
| **Detail Koleksi** | `/koleksi/{kode_unik}` | Detail artefak, galeri foto, audio guide bilingual, dan ulasan |
| **Login Admin** | `/login` | Masuk ke sistem kuratorial museum |
| **Dashboard Admin** | `/admin/dashboard` | Statistik live koleksi, kategori, ulasan, dan aktivitas |
| **Kelola Koleksi** | `/admin/koleksi` | CRUD artefak museum, upload multi-angle foto, dan voice narration |
| **Kelola Kategori** | `/admin/kategori` | CRUD kategori kuratorial & proporsi koleksi |
| **Moderasi Ulasan** | `/admin/ulasan` | Verifikasi, setujui, tolak, atau hapus ulasan pengunjung |
| **Kelola Pengguna** | `/admin/kelolaadmin` | Manajemen akun administrator & kurator sistem |
| **Cetak Label A5** | `/admin/qrcode/cetak-label/{id}` | Cetak label etalase pameran A5 motif Batik Gajah Oling |
| **Riwayat Aktivitas** | `/admin/riwayat` | Log audit trail aktivitas kurator |

---

## 📱 Cara Mencoba di HP / Smartphone via Wi-Fi

Aplikasi MUSEWANGI didesain dengan pendekatan **Mobile-First**, sehingga sangat optimal dibuka melalui smartphone.

### Langkah-langkah:
1. Pastikan **Laptop/Komputer** dan **HP Anda** terhubung ke **jaringan Wi-Fi yang sama** (atau HP melakukan Hotspot ke Laptop).
2. Cari tahu **Alamat IP Lokal (IPv4)** laptop Anda:
   - Buka PowerShell / CMD di laptop, ketik:
     ```powershell
     ipconfig
     ```
   - Lihat pada baris `IPv4 Address`, contohnya: `192.168.1.15` (atau `192.168.221.191`).
3. Jalankan Laravel dengan binding ke seluruh host:
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```
4. Buka browser di HP Anda (Chrome / Safari / Samsung Internet) dan ketik alamat:
   ```text
   http://[ALAMAT_IP_LAPTOP]:8000
   Contoh: http://192.168.1.15:8000
   ```

---

## 📷 Panduan Mengaktifkan Kamera HP (*Troubleshooting Kamera*)

Browser modern (Google Chrome, Brave, Edge) secara default memblokir izin akses kamera pada alamat IP lokal (`http://`) karena dianggap bukan HTTPS.

Agar kamera pemindai QR dapat aktif di browser HP Android via Wi-Fi:

1. Buka browser **Google Chrome** di HP Anda.
2. Di bilah URL, ketik alamat:
   ```text
   chrome://flags
   ```
3. Di kolom pencarian flags di bagian atas, cari kata kunci:
   ```text
   unsafely-treat-insecure-origin-as-secure
   ```
4. Ubah status flag tersebut dari **Disabled** menjadi **Enabled**.
5. Di kolom teks di bawahnya, masukkan alamat IP laptop Anda beserta port 8000:
   ```text
   http://192.168.x.x:8000
   Contoh: http://192.168.1.15:8000
   ```
6. Tekan tombol **Relaunch** di pojok kanan bawah untuk me-restart browser Chrome HP.
7. Buka kembali halaman pemindai: `http://192.168.x.x:8000/scan`.
8. Saat muncul dialog izin pop-up, pilih **Izinkan Akses Kamera (*Allow*)**. Kamera akan langsung aktif dan mendeteksi QR Code otomatis!

> **Tips Alternatif:** Anda juga dapat menggunakan tombol **"Unggah dari Galeri"** di pojok kanan atas pemindai untuk membaca QR code dari foto tanpa memerlukan akses kamera langsung.

---

## ⭐ Fitur-Fitur Utama Sistem

### 1. Pengalaman Pengunjung (*Visitor Experience*)
- **Pemindai Kamera Layar Penuh (Full-screen DANA Style)**: Deteksi otomatis berkecepatan 24 FPS, getaran haptik (*vibration*), bunyi beep sintetis, senter/flashlight, dan pemilihan galeri.
- **Audio Guide Bilingual (ID & EN)**: Pemandu suara narasi otomatis yang sinkron antara Bahasa Indonesia dan terjemahan Bahasa Inggris kuratorial resmi.
- **Galeri Multi-Sudut & Lightbox HD**: Tampilan foto artefak dari tampak depan, samping, dan belakang serta zoom layar penuh.
- **Ulasan Pengunjung & Star Rating**: Pengunjung dapat memberikan bintang 1–5 serta komentar pengalaman.
- **Efek Interaksi & Scroll Modern**: Bilah progres membaca emas (*golden reading progress*), animasi kemunculan bertahap (*scroll-reveal*), tombol melayang kembali ke atas (*back-to-top*), dan sentuhan pegas taktil.

### 2. Pengelolaan Kurator (*Admin & Curator Panel*)
- **Dashboard Metrik Real-Time**: 4 kartu statistik dinamis (Total Koleksi, Kategori, Ulasan dengan lencana pending, Skor Bintang Museum) dan tabel ringkasan aktivitas terbaru.
- **Moderasi Ulasan Terpadu**: Kurator dapat memverifikasi ulasan sebelum tampil di halaman publik pengunjung.
- **Cetak Label Etalase A5 (Replika Pameran Canva)**: Format siap cetak landscape standar pameran museum dengan ornamen resmi **Batik Gajah Oling Banyuwangi**, dua tabel spesifikasi emas oker, dan kartu QR Code beremblem resmi.

---

## 🛠️ Perintah Perawatan (*Troubleshooting & Cache Clear*)

Jika terjadi perubahan data atau tampilan yang belum diperbarui di browser:

```bash
# 1. Bersihkan seluruh cache Laravel
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 2. Kompilasi ulang aset produksi frontend
npm run build

# 3. Jalankan server kembali
php artisan serve --host=0.0.0.0 --port=8000
```

---

## 👥 Kontributor & Lisensi
- **Pengembang**: Fitria Ayu Pratiwi & Tim Pengembang MUSEWANGI
- **Instansi**: Dinas Kebudayaan dan Pariwisata Kabupaten Banyuwangi / Museum Blambangan
- **Lisensi**: Open-source untuk kebutuhan pelestarian budaya dan edukasi publik.
