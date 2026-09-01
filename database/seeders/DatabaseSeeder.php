<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with Museum Blambangan data.
     */
    public function run(): void
    {
        // 1. Super Admin Musewangi
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator Musewangi',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Petugas Loket & Kurator
        User::updateOrCreate(
            ['username' => 'petugas'],
            [
                'name' => 'Petugas Loket Museum',
                'email' => 'kasir@gmail.com',
                'role' => 'kasir',
                'password' => Hash::make('petugas123'),
                'email_verified_at' => now(),
            ]
        );

        // 3. Bersihkan Kategori Usang
        Category::whereIn('nama', ['Makanan', 'Minuman', 'Camilan'])->delete();

        // 4. Kategori Kuratorial Resmi Museum Blambangan
        $kategoriList = [
            'Arkeologi',
            'Etnografi',
            'Numismatika & Heraldika',
            'Filologi',
            'Keramologi',
            'Seni Rupa & Kriya',
            'Teknologi Tradisional',
            'Geologi'
        ];

        $kategoriModels = [];
        foreach ($kategoriList as $nama) {
            $kategoriModels[$nama] = Category::firstOrCreate(['nama' => $nama]);
        }

        // 5. Koleksi Artefak Bersejarah Museum Blambangan
        $allCollections = [
            [
                'nama_koleksi' => 'Stupika',
                'category_id' => $kategoriModels['Arkeologi']->id,
                'no_registrasi' => '006/ BWI/ 2026',
                'no_registrasi_lama' => 'MB-ARK-006',
                'kode_unik' => 'stupika-muncar',
                'kategori' => 'Arkeologi',
                'jenis_benda' => 'Stupa Miniatur Terakota',
                'tahun_pembuatan' => 'Abad ke-14 Masehi',
                'asal' => 'Gumuk Klinting, Muncar, Banyuwangi.',
                'kondisi' => 'Baik',
                'deskripsi' => 'Stupika tanah liat terakota peninggalan era klasik Hindu-Buddha di kawasan Muncar. Berfungsi sebagai sarana persembahyangan dan tanda ziarah suci keagamaan masa Kerajaan Blambangan.',
            ],
            [
                'nama_koleksi' => 'Bata Merah',
                'category_id' => $kategoriModels['Seni Rupa & Kriya']->id,
                'no_registrasi' => '002/ BWI/ 2026',
                'no_registrasi_lama' => 'MB-SRK-002',
                'kode_unik' => 'bata-merah-kuno-macanputih',
                'kategori' => 'Seni Rupa & Kriya',
                'jenis_benda' => 'Struktur Bangunan Kuno',
                'tahun_pembuatan' => 'Abad ke-15 Masehi',
                'asal' => 'Macanputih, Kabat, Banyuwangi.',
                'kondisi' => 'Baik',
                'deskripsi' => 'Bata merah kuno berukuran tebal dengan teknik pembakaran tradisional, peninggalan struktur benteng pertahanan dan istana Keraton Macanputih masa Prabu Tawangalun.',
            ],
            [
                'nama_koleksi' => 'Dhyani Bodhisattva',
                'category_id' => $kategoriModels['Arkeologi']->id,
                'no_registrasi' => '001/ BWI/ 2026',
                'no_registrasi_lama' => 'MB-ARK-001',
                'kode_unik' => 'dhyani-bodhisattva-muncar',
                'kategori' => 'Arkeologi',
                'jenis_benda' => 'Tablet Terakota Religius',
                'tahun_pembuatan' => 'Abad ke-14 Masehi',
                'asal' => 'Tambakrejo, Muncar, Banyuwangi.',
                'kondisi' => 'Baik',
                'deskripsi' => 'Tablet tanah liat berbentuk oval yang menggambarkan Dhyani Bodhisattva duduk di atas singgasana teratai (Padmasana) dalam posisi Ardhaparyanka dengan sikap tangan Waramudra peninggalan era Majapahit-Blambangan.',
            ],
            [
                'nama_koleksi' => 'Arca Dewa',
                'category_id' => $kategoriModels['Arkeologi']->id,
                'no_registrasi' => '86/BWI/2015',
                'no_registrasi_lama' => 'MB-ARK-086',
                'kode_unik' => 'arca-dewa-siliragung',
                'kategori' => 'Arkeologi',
                'jenis_benda' => 'Arca Batu Andesit',
                'tahun_pembuatan' => 'Abad ke-14 Masehi',
                'asal' => 'Gumuk Kancil, Siliragung, Banyuwangi.',
                'kondisi' => 'Baik',
                'deskripsi' => 'Arca Dewa berbahan batu andesit vulkanik dengan pahatan halus atribut kedewaan klasik Hindu peninggalan peradaban Blambangan selatan.',
            ],
            [
                'nama_koleksi' => 'Keris Luk 13 Dhapur Sengkelat Era Blambangan',
                'category_id' => $kategoriModels['Etnografi']->id,
                'no_registrasi' => 'MB-ETN-2024-001',
                'kode_unik' => 'keris-luk-13-sengkelat',
                'kategori' => 'Etnografi',
                'jenis_benda' => 'Senjata Tradisional',
                'tahun_pembuatan' => 'Abad ke-16',
                'asal' => 'Macanputih, Kabat, Banyuwangi (Era Prabu Tawangalun)',
                'kondisi' => 'Baik',
                'deskripsi' => 'Keris bersejarah dengan pamor Beras Wutah peninggalan era puncak kejayaan Kerajaan Blambangan abad ke-16. Bilah keris berbahan besi meteorit dengan warangka kayu timoho lamen ukiran khas pesisir timur Jawa.',
            ],
            [
                'nama_koleksi' => 'Naskah Lontar Babad Blambangan',
                'category_id' => $kategoriModels['Filologi']->id,
                'no_registrasi' => 'MB-FIL-2024-003',
                'kode_unik' => 'naskah-lontar-babad-blambangan',
                'kategori' => 'Filologi',
                'jenis_benda' => 'Manuskrip Kuno',
                'tahun_pembuatan' => 'Tahun 1772 Masehi',
                'asal' => 'Temenggungan, Banyuwangi',
                'kondisi' => 'Baik',
                'deskripsi' => 'Naskah kuno berbahan daun lontar dengan aksara Jawa Kawi yang mendokumentasikan babak perjuangan Wong Agung Wilis dan Perang Puputan Bayu tahun 1771 melawan VOC.',
            ],
            [
                'nama_koleksi' => 'Kain Batik Tulis Motif Gajah Oling Klasik',
                'category_id' => $kategoriModels['Seni Rupa & Kriya']->id,
                'no_registrasi' => 'MB-SRK-2024-004',
                'kode_unik' => 'batik-tulis-gajah-oling-klasik',
                'kategori' => 'Seni Rupa & Kriya',
                'jenis_benda' => 'Tekstil Tradisional',
                'tahun_pembuatan' => 'Tahun 1910',
                'asal' => 'Desa Adat Kemiren, Glagah, Banyuwangi',
                'kondisi' => 'Baik',
                'deskripsi' => 'Kain batik tulis tradisional tertua khas Banyuwangi dengan pewarnaan alami kulit pohon soga dan indigo. Motif Gajah Oling melambangkan kebesaran dan rasa syukur kepada Sang Maha Pencipta.',
            ],
            [
                'nama_koleksi' => 'Guci Seladon Dinasti Ming Abad ke-16',
                'category_id' => $kategoriModels['Keramologi']->id,
                'no_registrasi' => 'MB-KRM-2024-005',
                'kode_unik' => 'guci-seladon-dinasti-ming',
                'kategori' => 'Keramologi',
                'jenis_benda' => 'Keramik Kuno',
                'tahun_pembuatan' => 'Abad ke-16 Dinasti Ming',
                'asal' => 'Perairan Grajagan, Purwoharjo, Banyuwangi',
                'kondisi' => 'Baik',
                'deskripsi' => 'Guci keramik stoneware berglasir hijau seladon peninggalan jalur sutra maritim Selat Bali era Dinasti Ming, dihiasi motif ukir timbul naga dan bunga peony.',
            ],
            [
                'nama_koleksi' => 'Mata Uang Kuno Gobog Wayang Blambangan',
                'category_id' => $kategoriModels['Numismatika & Heraldika']->id,
                'no_registrasi' => 'MB-NUM-2024-006',
                'kode_unik' => 'gobog-wayang-blambangan',
                'kategori' => 'Numismatika & Heraldika',
                'jenis_benda' => 'Mata Uang Kuno',
                'tahun_pembuatan' => 'Abad ke-15 Masehi',
                'asal' => 'Situs Keraton Macanputih, Banyuwangi',
                'kondisi' => 'Baik',
                'deskripsi' => 'Mata uang perunggu tradisional bermotif relief tokoh pewayangan dan aksara sandi kerajaan, digunakan sebagai alat tukar resmi dan sarana upacara ritual adat.',
            ],
            [
                'nama_koleksi' => 'Patung Royo Blonyo',
                'category_id' => $kategoriModels['Etnografi']->id,
                'no_registrasi' => '009/ BWI/ 2026',
                'no_registrasi_lama' => 'MB-ETN-009',
                'kode_unik' => 'patung-royo-blonyo',
                'kategori' => 'Etnografi',
                'jenis_benda' => 'Patung Kayu Pengantin Tradisional',
                'tahun_pembuatan' => 'Abad ke-19',
                'asal' => 'Banyuwangi',
                'kondisi' => 'Baik',
                'deskripsi' => 'Patung Royo Blonyo ini melambangkan keharmonisan rumah tangga, kesuburan, serta kemakmuran, dan sering kali diasosiasikan sebagai wujud dari Dewa Wisnu (atau Sadana). Pada masa lalu patung ini diletakkan diruang tengah atau sentong tengah rumah tradisional Jawa sebagai lambang kesejahteraan.',
            ],
        ];

        foreach ($allCollections as $data) {
            Collection::updateOrCreate(
                ['kode_unik' => $data['kode_unik']],
                $data
            );
        }
    }
}
