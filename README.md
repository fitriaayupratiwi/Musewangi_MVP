# 🏛️ MUSEWANGI: Sistem Informasi Koleksi Museum Blambangan Banyuwangi Berbasis QR Code

merupakan aplikasi berbasis web yang dikembangkan untuk membantu digitalisasi pengelolaan koleksi museum serta memberikan akses informasi koleksi secara interaktif kepada pengunjung melalui pemindaian QR Code.

# 🎯 Visi & Tujuan Proyek

MUSEWANGI (Museum Banyuwangi Information System) merupakan aplikasi berbasis web yang dikembangkan untuk mendukung digitalisasi pengelolaan koleksi Museum Blambangan Banyuwangi di bawah Dinas Kebudayaan dan Pariwisata Kabupaten Banyuwangi. Sistem ini bertujuan mempermudah pengelolaan informasi koleksi museum serta memberikan akses informasi yang interaktif kepada pengunjung melalui teknologi QR Code.

Melalui pemindaian QR Code pada setiap koleksi, pengunjung dapat memperoleh informasi lengkap mengenai koleksi museum secara digital, sedangkan admin dapat mengelola seluruh data koleksi secara terpusat, sehingga proses dokumentasi, pengelolaan, dan penyebaran informasi menjadi lebih efektif, efisien, dan terdigitalisasi.

# Fitur Utama (Core Features)

## Interactive QR Code Collection

Setiap koleksi museum memiliki QR Code unik yang dapat dipindai oleh pengunjung untuk menampilkan informasi koleksi secara digital, meliputi:

📸 Foto koleksi
📝 Deskripsi koleksi
🎙️ Voice Narration (Audio)
⭐ Ulasan pengunjung

## Digital Collection Management

Admin museum dapat mengelola seluruh informasi koleksi melalui fitur Create, Read, Update, Delete (CRUD). Data yang dikelola meliputi:

📸 Foto koleksi
🆔 Nomor registrasi
🏛️ Nama koleksi
🏷️ Kategori koleksi
🏺 Jenis benda
📍 Asal koleksi
📅 Tahun pembuatan
✅ Kondisi koleksi
🎙️ File audio (voice narration)
🔳 QR Code koleksi

Fitur ini membantu proses pengelolaan data koleksi menjadi lebih terstruktur, terdokumentasi, dan mudah diperbarui.

## Collection Category Management

Sistem menyediakan fitur pengelolaan kategori untuk mengelompokkan koleksi berdasarkan jenis atau karakteristiknya, seperti:

🏺 Arkeologi
👘 Etnografi
🪙 Numismatik
🏺 Keramik
📜 Sejarah
🎨 Seni Rupa
📚 Kategori lainnya

Pengelompokan kategori memudahkan proses pencarian, pengelolaan, serta penyajian informasi koleksi kepada pengunjung.

## Visitor Review

Pengunjung dapat memberikan ulasan terhadap koleksi museum setelah mengakses informasi melalui QR Code. Fitur ini memungkinkan museum memperoleh masukan mengenai kualitas informasi dan pengalaman pengunjung, sehingga dapat menjadi bahan evaluasi untuk meningkatkan layanan museum.

# 🚀 Quick Start (Panduan Instalasi & Penggunaan)

1️⃣ Clone Repository
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

## Ubah konfigurasi berikut sesuai database yang dimiliki.

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

# Tech Stack

| Category          | Technology                      |
| ----------------- | ------------------------------- |
| Backend           | Laravel 12, PHP 8.2             |
| Frontend          | Blade, Tailwind CSS, JavaScript |
| Database          | MySQL                           |
| Build Tool        | Vite, NPM                       |
| Authentication    | Laravel Breeze                  |
| QR Code           | Simple QrCode                   |
| Audio             | HTML5 Audio Player              |
| Version Control   | Git, GitHub                     |
| Development Tools | Composer, VS Code, XAMPP        |
| UI Library        | Font Awesome                    |
