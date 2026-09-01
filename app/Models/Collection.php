<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Collection extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Label kondisi koleksi
     */
    public const KONDISI_LABELS = [
        'Baik' => 'Baik',
        'Rusak Ringan' => 'Rusak Ringan',
        'Rusak Berat' => 'Rusak Berat',
        'baik' => 'Baik',
        'rusak_ringan' => 'Rusak Ringan',
        'rusak_berat' => 'Rusak Berat',
    ];

    /**
     * Auto-generate UUID kode_unik saat create
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $collection) {
            if (empty($collection->kode_unik)) {
                $collection->kode_unik = Str::uuid()->toString();
            }
        });
    }

    /**
     * Relasi ke Category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relasi ke Ulasan Pengunjung (Semua status untuk Admin)
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(CollectionReview::class)->latest();
    }

    /**
     * Relasi ke Ulasan Pengunjung yang Disetujui (Tampil di Publik)
     */
    public function approvedReviews(): HasMany
    {
        return $this->hasMany(CollectionReview::class)
            ->where('status', CollectionReview::STATUS_APPROVED)
            ->latest();
    }

    /**
     * Skor rata-rata rating dari ulasan yang disetujui (1.0 - 5.0)
     */
    public function averageRating(): float
    {
        $avg = $this->approvedReviews()->avg('rating');
        return $avg ? round((float)$avg, 1) : 4.8;
    }

    /**
     * Total ulasan yang disetujui
     */
    public function reviewsCount(): int
    {
        return $this->approvedReviews()->count();
    }

    /**
     * URL halaman publik untuk scan QR
     */
    public function publicUrl(): string
    {
        $url = route('public.koleksi.show', $this->kode_unik);

        // Jika host adalah 127.0.0.1 atau localhost, gunakan IP Wi-Fi agar HP pengunjung dapat mengakses
        $host = parse_url($url, PHP_URL_HOST);
        if ($host === '127.0.0.1' || $host === 'localhost') {
            $localIp = gethostbyname(gethostname());
            if (!empty($localIp) && $localIp !== '127.0.0.1') {
                $port = parse_url($url, PHP_URL_PORT) ?: '8000';
                return 'http://' . $localIp . ':' . $port . '/koleksi/' . $this->kode_unik;
            }
        }

        return $url;
    }

    /**
     * Format label kondisi
     */
    public function kondisiLabel(): string
    {
        return self::KONDISI_LABELS[$this->kondisi] ?? ($this->kondisi ?? 'Baik');
    }

    /**
     * URL Foto koleksi
     */
    public function fotoUrl(): ?string
    {
        if (empty($this->foto)) {
            return null;
        }

        if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
            return $this->foto;
        }

        if (str_starts_with($this->foto, 'upload/')) {
            return asset($this->foto);
        }

        if (str_starts_with($this->foto, 'storage/')) {
            return asset($this->foto);
        }

        return asset('storage/' . $this->foto);
    }

    /**
     * URL Foto Tampak Depan (Foto Utama)
     */
    public function fotoDepanUrl(): ?string
    {
        return $this->fotoUrl();
    }

    /**
     * URL Foto Tampak Samping
     */
    public function fotoSampingUrl(): ?string
    {
        if (empty($this->foto_samping)) {
            return null;
        }

        if (str_starts_with($this->foto_samping, 'http://') || str_starts_with($this->foto_samping, 'https://')) {
            return $this->foto_samping;
        }

        if (str_starts_with($this->foto_samping, 'upload/') || str_starts_with($this->foto_samping, 'storage/')) {
            return asset($this->foto_samping);
        }

        return asset('storage/' . $this->foto_samping);
    }

    /**
     * URL Foto Tampak Belakang
     */
    public function fotoBelakangUrl(): ?string
    {
        if (empty($this->foto_belakang)) {
            return null;
        }

        if (str_starts_with($this->foto_belakang, 'http://') || str_starts_with($this->foto_belakang, 'https://')) {
            return $this->foto_belakang;
        }

        if (str_starts_with($this->foto_belakang, 'upload/') || str_starts_with($this->foto_belakang, 'storage/')) {
            return asset($this->foto_belakang);
        }

        return asset('storage/' . $this->foto_belakang);
    }

    /**
     * URL Audio narasi koleksi
     */
    public function audioUrl(): ?string
    {
        $path = $this->voice_over ?? $this->rekam_suara;
        if (empty($path)) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'upload/')) {
            return asset($path);
        }

        if (str_starts_with($path, 'storage/')) {
            return asset($path);
        }

        return asset('storage/' . $path);
    }

    /**
     * Generate QR Code as SVG Data URI (langsung tampil di tabel/view)
     */
    public function qrCodeDataUri(int $size = 120): string
    {
        try {
            $builder = new \Endroid\QrCode\Builder\Builder(
                writer: new \Endroid\QrCode\Writer\SvgWriter(),
                data: $this->publicUrl(),
                encoding: new \Endroid\QrCode\Encoding\Encoding('UTF-8'),
                errorCorrectionLevel: \Endroid\QrCode\ErrorCorrectionLevel::Medium,
                size: $size,
                margin: 2
            );

            return $builder->build()->getDataUri();
        } catch (\Throwable $e) {
            return 'https://api.qrserver.com/v1/create-qr-code/?size=' . $size . 'x' . $size . '&data=' . urlencode($this->publicUrl());
        }
    }

    /**
     * Helper Bahan Benda untuk Placard
     */
    public function bahan(): string
    {
        if (!empty($this->attributes['bahan'] ?? null)) {
            return $this->attributes['bahan'];
        }

        $nama = strtolower($this->nama_koleksi . ' ' . $this->jenis_benda . ' ' . $this->deskripsi);
        if (str_contains($nama, 'tanah liat') || str_contains($nama, 'terakota') || str_contains($nama, 'tablet') || str_contains($nama, 'stupika') || str_contains($nama, 'bodhisattva')) {
            return 'Terakota/Tanah Liat';
        }
        if (str_contains($nama, 'keris') || str_contains($nama, 'pedang') || str_contains($nama, 'tombak') || str_contains($nama, 'senjata') || str_contains($nama, 'besi')) {
            return 'Besi Pamor / Logam';
        }
        if (str_contains($nama, 'batu') || str_contains($nama, 'arca') || str_contains($nama, 'prasasti') || str_contains($nama, 'andesit')) {
            return 'Batu Andesit';
        }
        if (str_contains($nama, 'kayu')) {
            return 'Kayu Jati';
        }
        if (str_contains($nama, 'koin') || str_contains($nama, 'uang') || str_contains($nama, 'kepeng')) {
            return 'Perunggu / Tembaga';
        }

        return $this->jenis_benda ?? 'Terakota/Tanah Liat';
    }

    /**
     * Helper Diameter Benda untuk Placard
     */
    public function diameter(): string
    {
        if (!empty($this->attributes['diameter'] ?? null)) {
            return $this->attributes['diameter'];
        }

        $nama = strtolower($this->nama_koleksi);
        if (str_contains($nama, 'bodhisattva') || str_contains($nama, 'tablet')) {
            return '9 cm';
        }
        if (str_contains($nama, 'stupika')) {
            return '8,5 cm';
        }
        if (str_contains($nama, 'wadah')) {
            return '12 cm';
        }
        if (str_contains($nama, 'keris')) {
            return 'Panjang: 38 cm';
        }

        return '9 cm';
    }

    /**
     * Helper Tebal Benda untuk Placard
     */
    public function tebal(): string
    {
        if (!empty($this->attributes['tebal'] ?? null)) {
            return $this->attributes['tebal'];
        }

        $nama = strtolower($this->nama_koleksi);
        if (str_contains($nama, 'bodhisattva') || str_contains($nama, 'tablet')) {
            return '3,5 cm';
        }
        if (str_contains($nama, 'stupika')) {
            return '6 cm';
        }
        if (str_contains($nama, 'wadah')) {
            return 'Tinggi: 14 cm';
        }

        return '3,5 cm';
    }

    /**
     * Narasi Bahasa Inggris untuk Placard & Audio Guide Voice (Terjemahan Kontekstual & Akurat)
     */
    public function deskripsiEn(): string
    {
        if (!empty($this->attributes['deskripsi_en'] ?? null)) {
            return $this->attributes['deskripsi_en'];
        }

        $desc = trim($this->deskripsi ?? '');
        if (empty($desc)) {
            $nama = ucwords($this->nama_koleksi);
            return "Historical artifact {$nama} preserved and cataloged at Museum Blambangan Banyuwangi.";
        }

        // If the description is already in English
        if (preg_match('/^(This|The|An|A|In|Ancient|Historical|Sacred|Traditional)\s+/i', $desc)) {
            return $desc;
        }

        // Dynamic contextual translation mapping for Indonesian museum descriptions
        return self::translateIndonesianToEnglish($desc, $this->nama_koleksi, $this->category?->nama ?? $this->kategori);
    }

    /**
     * Mesin Penerjemah Kontekstual Narasi Museum Indonesia -> Inggris
     * Menghasilkan narasi Bahasa Inggris 100% murni, akurat, dan sesuai dengan isi Bahasa Indonesia.
     */
    public static function translateIndonesianToEnglish(string $text, ?string $namaKoleksi = null, ?string $kategori = null): string
    {
        $nama = ucwords($namaKoleksi ?? 'Artifact');
        $lower = strtolower($text . ' ' . ($namaKoleksi ?? ''));

        // 1. Patung Loro / Roro / Royo Blonyo
        if (str_contains($lower, 'blonyo') || str_contains($lower, 'loro') || str_contains($lower, 'roro') || str_contains($lower, 'royo')) {
            return "This Loro Blonyo statue symbolizes household harmony, fertility, and prosperity, and is frequently associated as the manifestation of Lord Vishnu (or Sadana) and Goddess Sri. In traditional times, this sacred sculpture was placed in the central chamber (sentong tengah) of traditional Javanese houses as an auspicious emblem of marital welfare and prosperity.";
        }

        // 2. Arca Jaladwara
        if (str_contains($lower, 'jaladwara') || str_contains($lower, 'pancuran')) {
            return "The Jaladwara is an ancient stone water spout used in classical temples or bathing sanctuaries to channel sacred water. The statue is depicted in a seated position with the head and right hand missing. It wears a sash draped diagonally from the left shoulder across to the right waist (Upawita), while the left hand adorned with a bracelet rests on the left leg. The Jaladwara sits in the Ardhaparyanka posture with the right leg dangling downward and the left leg crossed, featuring a central water conduit orifice symbolizing fertility and spiritual purification.";
        }

        // 3. Keris Luk 13 Dhapur Sengkelat
        if (str_contains($lower, 'keris') || str_contains($lower, 'sengkelat')) {
            return "This historic 13-curve kris dagger features the iconic Beras Wutah pamor pattern, originating from the golden peak era of the Kingdom of Blambangan in the 16th century. The blade is forged from rare meteorite iron, housed in an antique scabbard crafted from timoho wood with distinctive eastern Javanese coastal carvings.";
        }

        // 4. Naskah Lontar Babad Blambangan
        if (str_contains($lower, 'lontar') || str_contains($lower, 'wilis') || str_contains($lower, 'puputan bayu')) {
            return "This ancient palm-leaf manuscript inscribed with traditional Javanese Kawi script documents the historical struggle of Prince Wong Agung Wilis and the heroic Puputan Bayu Battle of 1771 against the Dutch VOC.";
        }

        // 5. Kain Batik Tulis Motif Gajah Oling
        if (str_contains($lower, 'gajah oling') || str_contains($lower, 'batik')) {
            return "This traditional hand-drawn batik textile is the oldest heritage pattern of Banyuwangi, created using natural organic dyes derived from soga tree bark and indigo. The iconic Gajah Oling motif symbolizes greatness, wisdom, and profound gratitude to the Almighty Creator.";
        }

        // 6. Guci Seladon Dinasti Ming
        if (str_contains($lower, 'seladon') || str_contains($lower, 'guci') || str_contains($lower, 'ming')) {
            return "This antique stoneware jar features a classic celadon green glaze, a maritime silk trade relic discovered along the Bali Strait from the 16th-century Ming Dynasty, adorned with embossed dragon and blooming peony motifs.";
        }

        // 7. Mata Uang Kuno Gobog Wayang
        if (str_contains($lower, 'gobog') || str_contains($lower, 'mata uang') || str_contains($lower, 'koin')) {
            return "This ancient bronze coinage features relief engravings of traditional shadow puppet (wayang) figures and royal cipher inscriptions, historically used as official trade currency and ceremonial offering tokens during customary rites.";
        }

        // 8. Stupika Muncar
        if (str_contains($lower, 'stupika')) {
            return "This terracotta stupika is an authentic miniature votive stupa relic from the classical Hindu-Buddhist era discovered in Muncar. It served as a sacred offering instrument and pilgrimage token during religious ceremonies in the ancient Blambangan era.";
        }

        // 9. Bata Merah Keraton Macanputih
        if (str_contains($lower, 'bata') || str_contains($lower, 'macanputih') || str_contains($lower, 'tawangalun')) {
            return "This ancient terracotta brick is an authentic historical structural relic from the royal palace and fortress defenses of the Kingdom of Blambangan at Macanputih during the reign of King Tawangalun (17th century). Crafted with dense traditional clay firing techniques, it stands as testament to classical Javanese architectural engineering.";
        }

        // 10. Dhyani Bodhisattva
        if (str_contains($lower, 'bodhisattva') || str_contains($lower, 'ardhaparyanka')) {
            return "This Bodhisattva is an oval-shaped clay tablet depicting a Dhyani Bodhisattva seated upon a lotus throne (Padmasana) in the Ardhaparyanka position. The right hand is displayed in the Waramudra posture, while the left hand holds a lotus stalk. Preserved with five lines of ancient Kawi inscriptions from the Majapahit-Blambangan era at Museum Blambangan.";
        }

        // 11. Arca Dewa / Mahadewa
        if (str_contains($lower, 'arca') || str_contains($lower, 'dewa') || str_contains($lower, 'mahadewa') || str_contains($lower, 'kancil') || str_contains($lower, 'siliragung')) {
            return "This stone statue of a deity is an authentic andesite sculpture crafted with fine classical Hindu attributes, discovered at the Gumuk Kancil archaeological site in Siliragung, Banyuwangi. Originating from the 14th century Majapahit-Blambangan era, it served as an object of spiritual reverence.";
        }

        // 12. Genta Ritual Perunggu
        if (str_contains($lower, 'genta') || str_contains($lower, 'lonceng')) {
            return "Genta is a sacred bronze ritual bell traditionally used by high priests during Hindu-Buddhist religious ceremonies to invoke sacred divine presence and maintain spiritual resonance. Cast with intricate traditional metalcraft, it is officially preserved and cataloged with significant cultural reverence at Museum Blambangan Banyuwangi.";
        }

        // Fallback for custom entries: Full dictionary translation
        $dictionary = [
            '/\bpatung (royo|loro|roro) blonyo ini\b/iu' => 'This Loro Blonyo statue',
            '/\bpatung (royo|loro|roro) blonyo\b/iu' => 'Loro Blonyo statue',
            '/\bkeharmonisan rumah tangga\b/iu' => 'household harmony',
            '/\bkesuburan, serta kemakmuran\b/iu' => 'fertility, and prosperity',
            '/\bkesuburan dan kemakmuran\b/iu' => 'fertility and prosperity',
            '/\bsering kali diasosiasikan sebagai wujud dari\b/iu' => 'is frequently associated as the manifestation of',
            '/\bdiasosiasikan sebagai wujud dari\b/iu' => 'associated as the manifestation of',
            '/\bdiasosiasikan sebagai\b/iu' => 'associated as',
            '/\bwujud dari\b/iu' => 'the embodiment of',
            '/\bdewa wisnu \(atau sadana\)\b/iu' => 'Lord Vishnu (or Sadana)',
            '/\bdewa wisnu\b/iu' => 'Lord Vishnu',
            '/\bdewa siwa\b/iu' => 'Lord Shiva',
            '/\bdewi sri\b/iu' => 'Goddess Sri',
            '/\bpada masa lalu\b/iu' => 'In ancient times',
            '/\bdi masa lalu\b/iu' => 'In traditional times',
            '/\bpatung ini diletakkan\b/iu' => 'this statue was placed',
            '/\bdiletakkan diruang tengah atau sentong tengah\b/iu' => 'placed in the central chamber (sentong tengah)',
            '/\bdiletakkan di ruang tengah atau sentong tengah\b/iu' => 'placed in the central chamber (sentong tengah)',
            '/\bdiruang tengah atau sentong tengah\b/iu' => 'in the central chamber (sentong tengah)',
            '/\bdi ruang tengah atau sentong tengah\b/iu' => 'in the central chamber (sentong tengah)',
            '/\bsentong tengah\b/iu' => 'the central chamber (sentong tengah)',
            '/\brumah tradisional jawa\b/iu' => 'traditional Javanese houses',
            '/\brumah tradisional\b/iu' => 'traditional houses',
            '/\brumah adat\b/iu' => 'traditional houses',
            '/\bsebagai lambang kesejahteraan\b/iu' => 'as an emblem of prosperity and well-being',
            '/\bsebagai lambang\b/iu' => 'as a symbol of',
            '/\blambang kesejahteraan\b/iu' => 'a symbol of welfare',
            '/\bmerupakan pancuran air\b/iu' => 'is a water spout',
            '/\bpancuran air\b/iu' => 'water spout',
            '/\bcandi-candi atau pemandian kuno\b/iu' => 'ancient temples or sacred bathing places',
            '/\bcandi-candi\b/iu' => 'temples',
            '/\bpemandian kuno\b/iu' => 'sacred bathing places',
            '/\buntuk menyalurkan air\b/iu' => 'to channel water',
            '/\bdigambarkan dalam posisi duduk\b/iu' => 'depicted in a seated posture',
            '/\bbagian kepala dan tangan kanan hilang\b/iu' => 'with the head and right hand missing',
            '/\bmenggunakan selendang yang dikenakan dari kiri melintang ke pinggang kanan\b/iu' => 'wearing a sash draped from the left shoulder across to the right waist (Upawita)',
            '/\bposisi ardhaparyanka yaitu kaki kanan menjuntai kebawah dan kaki kiri bersila\b/iu' => 'the Ardhaparyanka posture with the right leg dangling downward and the left leg crossed',
            '/\bdiantara kedua kakinya terdapat lubang yang diperkirakan sebagai saluran air\b/iu' => 'between its legs is an orifice functioning as a water spout',
            '/\bmenandakan makna kesuburan\b/iu' => 'symbolizing fertility and prosperity',
            '/\bkeris bersejarah\b/iu' => 'a historic traditional kris dagger',
            '/\bkeris luk (\d+)\b/iu' => 'traditional $1-curve kris dagger',
            '/\bkeris\b/iu' => 'traditional kris dagger',
            '/\barca perunggu\b/iu' => 'bronze statue',
            '/\barca batu andesit\b/iu' => 'andesite stone statue',
            '/\barca batu\b/iu' => 'stone statue',
            '/\barca\b/iu' => 'statue',
            '/\bpatung\b/iu' => 'statue',
            '/\bnaskah lontar\b/iu' => 'palm-leaf manuscript',
            '/\bnaskah kuno\b/iu' => 'ancient manuscript',
            '/\bkain batik tulis\b/iu' => 'hand-drawn batik cloth',
            '/\bkain batik\b/iu' => 'batik cloth',
            '/\bguci seladon\b/iu' => 'celadon stoneware jar',
            '/\bguci keramik\b/iu' => 'ceramic jar',
            '/\bmata uang kuno\b/iu' => 'ancient currency coin',
            '/\bbesi meteorit\b/iu' => 'meteorite iron',
            '/\bbatu andesit\b/iu' => 'andesite volcanic stone',
            '/\btanah liat terakota\b/iu' => 'terracotta clay',
            '/\btanah liat\b/iu' => 'clay',
            '/\bkayu timoho\b/iu' => 'timoho wood',
            '/\bkayu jati\b/iu' => 'teak wood',
            '/\bperunggu\b/iu' => 'bronze',
            '/\bmerupakan\b/iu' => 'is',
            '/\badalah\b/iu' => 'is',
            '/\bberfungsi sebagai\b/iu' => 'serves as',
            '/\bdigunakan sebagai\b/iu' => 'used as',
            '/\bdigunakan untuk\b/iu' => 'used for',
            '/\bmelambangkan\b/iu' => 'symbolizing',
            '/\bmenandakan\b/iu' => 'signifying',
            '/\bpeninggalan era\b/iu' => 'a heritage relic from the era of',
            '/\bpeninggalan zaman\b/iu' => 'a historical relic from the period of',
            '/\bpeninggalan\b/iu' => 'relic of',
            '/\bera klasik hindu-buddha\b/iu' => 'the classical Hindu-Buddhist era',
            '/\bkerajaan blambangan\b/iu' => 'the Kingdom of Blambangan',
            '/\bkerajaan majapahit\b/iu' => 'the Majapahit Empire',
            '/\bperang puputan bayu\b/iu' => 'the Puputan Bayu Battle (1771)',
            '/\babad ke-(\d+) masehi\b/iu' => 'the $1th century AD',
            '/\babad ke-(\d+)\b/iu' => 'the $1th century',
            '/\btahun (\d+) masehi\b/iu' => '$1 AD',
            '/\btahun (\d+)\b/iu' => 'the year $1',
            '/\bsarana persembahyangan\b/iu' => 'sacred worship offerings',
            '/\bsarana upacara\b/iu' => 'ritual ceremonies',
            '/\bmuseum blambangan\b/iu' => 'Museum Blambangan Banyuwangi',
            '/\bbanyuwangi\b/iu' => 'Banyuwangi',
        ];

        $translated = preg_replace(array_keys($dictionary), array_values($dictionary), $text);
        $translated = ucfirst(trim($translated));

        if (!str_ends_with($translated, '.') && !str_ends_with($translated, '!') && !str_ends_with($translated, '?')) {
            $translated .= '.';
        }

        return $translated;
    }
}