<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koleksi extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Label kondisi koleksi untuk ditampilkan di tampilan (badge, dsb).
     */
    public const KONDISI_LABELS = [
        'baik' => 'Baik',
        'rusak_ringan' => 'Rusak Ringan',
        'rusak_berat' => 'Rusak Berat',
    ];

    public function kategori()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function kondisiLabel(): string
    {
        return self::KONDISI_LABELS[$this->kondisi] ?? $this->kondisi;
    }
}
