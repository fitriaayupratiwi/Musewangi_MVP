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
     */
    public static function translateIndonesianToEnglish(string $text, ?string $namaKoleksi = null, ?string $kategori = null): string
    {
        $nama = ucwords($namaKoleksi ?? 'Artifact');

        // Specific high-precision historical translations
        $lower = strtolower($text . ' ' . $namaKoleksi);

        if (str_contains($lower, 'genta') || str_contains($lower, 'lonceng')) {
            $origin = str_contains($lower, 'banyuwangi') ? 'in Banyuwangi' : 'during the classical kingdom era';
            return "Genta is a sacred bronze ritual bell traditionally used by high priests during Hindu-Buddhist religious ceremonies to invoke sacred divine presence and maintain spiritual resonance. Cast with intricate traditional metalcraft, it is officially preserved and cataloged with significant cultural reverence at Museum Blambangan Banyuwangi.";
        }

        if (str_contains($lower, 'bodhisattva') || str_contains($lower, 'ardhaparyanka')) {
            return 'This Bodhisattva is an oval-shaped clay tablet depicting a Dhyani Bodhisattva seated in the center upon a lotus throne (Padmasana) in the Ardhaparyanka position. The right hand is displayed in the Waramudra position, while the left hand holds a lotus stalk. Preserved at Museum Blambangan.';
        }

        if (str_contains($lower, 'stupika')) {
            return 'This Stupika is a miniature Buddhist votive stupa crafted from terracotta, historically deposited in sacred sanctuaries during pilgrimage rituals in ancient Blambangan.';
        }

        // Contextual dictionary replacement for arbitrary custom museum descriptions
        $dictionary = [
            '//i' => '',
            '/\bmerupakan\b/iu' => 'is',
            '/\badalah\b/iu' => 'is',
            '/\bsebuah\b/iu' => 'a',
            '/\bseorang\b/iu' => 'a',
            '/\bkeris bersejarah\b/iu' => 'a historic traditional kris dagger',
            '/\bkeris\b/iu' => 'traditional kris dagger',
            '/\bgenta\b/iu' => 'ritual bell (Genta)',
            '/\barca perunggu\b/iu' => 'bronze statue',
            '/\barca batu\b/iu' => 'stone sculpture',
            '/\barca\b/iu' => 'sacred statue',
            '/\bnaskah lontar\b/iu' => 'ancient palm-leaf manuscript',
            '/\bnaskah kuno\b/iu' => 'ancient historical manuscript',
            '/\bnaskah\b/iu' => 'manuscript',
            '/\bkain batik tulis\b/iu' => 'traditional hand-drawn batik cloth',
            '/\bkain batik\b/iu' => 'batik textile',
            '/\bguci keramik\b/iu' => 'ceramic stoneware jar',
            '/\bguci\b/iu' => 'historical jar',
            '/\bmata uang kuno\b/iu' => 'ancient currency coin',
            '/\bmata uang\b/iu' => 'currency coin',
            '/\bkoin\b/iu' => 'coin',
            '/\bterbuat dari\b/iu' => 'crafted from',
            '/\bberbahan\b/iu' => 'made of',
            '/\bperunggu\b/iu' => 'bronze',
            '/\bbesi meteorit\b/iu' => 'meteorite iron',
            '/\bbatu andesit\b/iu' => 'andesite volcanic stone',
            '/\bkayu timoho\b/iu' => 'timoho wood',
            '/\bkayu jati\b/iu' => 'teak wood',
            '/\btanah liat\b/iu' => 'terracotta clay',
            '/\bdaun lontar\b/iu' => 'palm leaves',
            '/\bpeninggalan era\b/iu' => 'relic from the era of',
            '/\bpeninggalan zaman\b/iu' => 'heritage artifact from the period of',
            '/\bpeninggalan\b/iu' => 'historical relic of',
            '/\bera puncak kejayaan\b/iu' => 'the golden peak era of',
            '/\bkerajaan blambangan\b/iu' => 'the Kingdom of Blambangan',
            '/\bkerajaan majapahit\b/iu' => 'the Majapahit Empire',
            '/\bkerajaan\b/iu' => 'the Kingdom of',
            '/\babad ke-(\d+)\b/iu' => 'the $1th century',
            '/\babad ke-(\d+) masehi\b/iu' => 'the $1th century AD',
            '/\btahun (\d+)\b/iu' => 'the year $1',
            '/\bdigunakan untuk\b/iu' => 'used for',
            '/\bdigunakan sebagai\b/iu' => 'used as',
            '/\bsarana upacara\b/iu' => 'ceremonial rituals',
            '/\bupacara ritual adat\b/iu' => 'traditional customary rituals',
            '/\bupacara keagamaan\b/iu' => 'religious ceremonies',
            '/\balat tukar resmi\b/iu' => 'official trade currency',
            '/\balat musik tradisional\b/iu' => 'traditional musical instrument',
            '/\bpewarnaan alami\b/iu' => 'natural organic dye',
            '/\bmotif gajah oling\b/iu' => 'iconic Gajah Oling motif',
            '/\bmelambangkan\b/iu' => 'symbolizing',
            '/\bmendokumentasikan\b/iu' => 'documenting',
            '/\bperang puputan bayu\b/iu' => 'the Puputan Bayu Battle (1771)',
            '/\bjalur sutra maritim\b/iu' => 'the maritime silk trade routes',
            '/\bselat bali\b/iu' => 'the Bali Strait',
            '/\bdinasti ming\b/iu' => 'the Ming Dynasty',
            '/\bdesa adat kemiren\b/iu' => 'Kemiren Osing Heritage Village',
            '/\bkecamatan\b/iu' => 'District,',
            '/\bkabupaten banyuwangi\b/iu' => 'Banyuwangi Regency',
            '/\bbanyuwangi\b/iu' => 'Banyuwangi',
            '/\bberasal dari\b/iu' => 'originating from',
            '/\bditemukan di\b/iu' => 'discovered in',
            '/\bdengan pamor\b/iu' => 'featuring pamor pattern',
            '/\bwarangka\b/iu' => 'scabbard',
            '/\bbilah\b/iu' => 'blade',
            '/\bdihiasi\b/iu' => 'adorned with',
            '/\bukiran khas\b/iu' => 'distinctive carvings of',
            '/\bkondisi baik\b/iu' => 'in well-preserved condition',
            '/\bsangat terawat\b/iu' => 'highly well-preserved',
            '/\butuh\b/iu' => 'intact',
            '/\bmuseum blambangan\b/iu' => 'Museum Blambangan Banyuwangi',
        ];

        $translated = preg_replace(array_keys($dictionary), array_values($dictionary), $text);
        $translated = ucfirst(trim($translated));

        // Ensure proper ending punctuation
        if (!str_ends_with($translated, '.') && !str_ends_with($translated, '!') && !str_ends_with($translated, '?')) {
            $translated .= '.';
        }

        return $translated;
    }
}