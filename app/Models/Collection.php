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
     * Narasi Bahasa Inggris untuk Placard & Audio Guide Voice
     */
    public function deskripsiEn(): string
    {
        if (!empty($this->attributes['deskripsi_en'] ?? null)) {
            return $this->attributes['deskripsi_en'];
        }

        $desc = $this->deskripsi ?? '';
        $descLower = strtolower($desc . ' ' . $this->nama_koleksi . ' ' . $this->jenis_benda);

        // If the description is already in English
        if (str_starts_with(trim($desc), 'This ') || str_starts_with(trim($desc), 'The ') || str_starts_with(trim($desc), 'An ')) {
            return $desc;
        }

        // Specific high-precision matches based on artifact description contents
        if (str_contains($descLower, 'bodhisattva') || str_contains($descLower, 'padmasana') || str_contains($descLower, 'ardhaparyanka')) {
            return 'This Bodhisattva is an oval-shaped clay tablet depicting a Dhyani Bodhisattva seated in the center upon a lotus throne (Padmasana) in the Ardhaparyanka position (with the right leg dangling downward and the left leg crossed on the seat). The right hand is displayed in the Waramudra position (slightly open), while the left hand holds a lotus stalk (Utpala). The Bodhisattva figure wears a crown and a necklace as additional adornments. Furthermore, there are five lines of inscription written in Old Javanese script.';
        }

        if (str_contains($descLower, 'stupika') || (str_contains($descLower, 'stupa') && str_contains($descLower, 'tanah liat'))) {
            return 'This Stupika is a miniature Buddhist votive stupa crafted from terracotta, historically deposited in sacred temples or sanctuaries during religious pilgrimage rituals in ancient Blambangan. Preserved and cataloged with high cultural significance at Museum Blambangan.';
        }

        if (str_contains($descLower, 'wadah air') || (str_contains($descLower, 'wadah') && str_contains($descLower, 'bibir terbuka'))) {
            return 'This ancient terracotta water vessel features an open rim with slight historic patina. Handcrafted with traditional pottery techniques, it was used for household water storage and ceremonial purposes in early Blambangan settlements.';
        }

        if (str_contains($descLower, 'keris') || str_contains($descLower, 'pamor') || str_contains($descLower, 'luk') || str_contains($descLower, 'senjata')) {
            return 'A sacred traditional kris dagger from the Blambangan kingdom era, forged with layered steel metallurgy displaying spiritual pamor patterns. It represents an esteemed cultural symbol of bravery, heritage protection, and Javanese royal identity.';
        }

        if (str_contains($descLower, 'arca') || str_contains($descLower, 'patung') || str_contains($descLower, 'statue')) {
            return 'This historical stone statue is carved from volcanic andesite stone, representing sacred deity figures and artistic sculpture traditions of the Hindu-Buddhist classical era in East Java and Blambangan.';
        }

        if (str_contains($descLower, 'koin') || str_contains($descLower, 'kepeng') || str_contains($descLower, 'uang')) {
            return 'An authentic numismatic coin collection representing ancient trade currency and maritime commerce in the coastal kingdom of Blambangan and the Majapahit empire.';
        }

        if (str_contains($descLower, 'batik') || str_contains($descLower, 'gajah oling') || str_contains($descLower, 'kain')) {
            return 'A traditional Banyuwangi hand-drawn textile featuring the iconic Gajah Oling motif, symbolizing wisdom, continuous life, and ancestral reverence in Osing cultural traditions.';
        }

        if (!empty($desc)) {
            $nama = ucwords($this->nama_koleksi);
            $kat = $this->kategori ?? 'Historical Artifact';
            return "{$nama} is an authentic {$kat} artifact officially preserved and cataloged at Museum Blambangan Banyuwangi, showcasing the significant cultural heritage and historical craftsmanship of the Blambangan civilization.";
        }

        return 'This historical artifact represents the rich cultural heritage and Blambangan civilization of Banyuwangi. Preserved and cataloged with high historical value for educational and cultural heritage purposes at the Blambangan Museum.';
    }
}