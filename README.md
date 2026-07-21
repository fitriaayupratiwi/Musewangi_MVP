🏛️ MUSEWANGI: Smart Museum Inventory Management System
Project Based Learning (PBL) Semester 7
Sistem Inventaris Digital Museum Blambangan Banyuwangi untuk membantu Dinas Kebudayaan dan Pariwisata Kabupaten Banyuwangi dalam mengelola data koleksi museum secara terstruktur, aman, dan terdigitalisasi.

# 🎯 Visi & Tujuan Proyek

### Smart QR-Based Restaurant Ordering System

MUSEWANGI (Museum Inventory System Banyuwangi) merupakan purwarupa sistem inventaris digital berbasis web yang dirancang untuk membantu Dinas Kebudayaan dan Pariwisata Kabupaten Banyuwangi dalam mengelola koleksi Museum Blambangan secara terstruktur, terdigitalisasi, dan mudah diakses. Sistem ini mengintegrasikan manajemen inventaris dengan teknologi QR Code sehingga informasi koleksi dapat disajikan secara interaktif kepada pengunjung tanpa mengungkap data inventaris internal yang bersifat rahasia.

🌟 Fitur Utama (Core Features)

🏷️ Interactive QR Code Collection

Setiap koleksi museum memiliki QR Code unik yang dapat dipindai oleh pengunjung untuk menampilkan informasi digital secara langsung, meliputi:

📸 Foto koleksi berkualitas tinggi
🎙️ Voice Narration (Audio/VN) sebagai panduan
📝 Deskripsi sejarah, asal-usul, fungsi, serta informasi budaya koleksi
🏺 Digital Collection Management

Admin museum dapat mengelola seluruh data koleksi secara digital melalui fitur Create, Read, Update, Delete (CRUD). Data yang dikelola meliputi nomor registrasi, nama koleksi, kategori, kondisi, lokasi penyimpanan, foto, serta informasi inventaris lainnya sehingga proses administrasi menjadi lebih efisien dan terdokumentasi.

📂 Collection Category Management

Sistem menyediakan pengelolaan kategori koleksi untuk mengelompokkan benda berdasarkan jenisnya, seperti:

Arkeologi
Etnografi
Numismatik
Keramik
Sejarah
Seni Rupa
dan kategori lainnya.

Pengelompokan ini memudahkan proses pencarian serta penyajian informasi koleksi.

📜 Inventory History & Activity Tracking

Seluruh aktivitas pengelolaan inventaris dicatat dalam sistem sehingga admin dapat melihat riwayat perubahan data koleksi, mulai dari penambahan, pembaruan, hingga perubahan kondisi koleksi. Fitur ini membantu menjaga akurasi data serta mendukung proses dokumentasi inventaris museum secara berkelanjutan.

---

🚀 Quick Start (Panduan Instalasi & Penggunaan)

1️⃣ Clone Repository
Pastikan Python 3.11 dan Git sudah terinstal di komputermu, lalu jalankan perintah berikut di terminal:

git clone https://github.com/fitriaayupratiwi/Musewangi_MVP.git
cd Musewangi_MVP

2️⃣ Install Dependency PHP

Install seluruh package Laravel menggunakan Composer dengan perintah:
composer install

3️⃣ Install Dependency JavaScript

Install seluruh package frontend dengan perintah:
npm install

4️⃣ Buat File Environment

Salin file .env.example menjadi .env dengan perintah:
copy .env.example .env

5️⃣ Generate Application Key

php artisan key:generate

6️⃣ Konfigurasi Database

Buka file .env

Ubah konfigurasi berikut sesuai database yang dimiliki.

APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventaris
DB_USERNAME=root
DB_PASSWORD=

7️⃣ Buat Database

Masuk ke http://localhost/phpmyadmin lalu buat database.

CREATE DATABASE inventaris;

8️⃣ Jalankan Migration

Membuat seluruh tabel database dengan perintah:
php artisan migrate

dan seeder dengan perintah:
php artisan migrate --seed

🔟 Compile Asset Frontend

Mode Development dengan perintah:
npm run dev

1️⃣1️⃣ Jalankan Laravel
php artisan serve

---

# Tech Stack

- Laravel
- Tailwind CSS
