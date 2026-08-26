<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koleksi extends Model
{
    use HasFactory;

    protected $table = 'collections';

    protected $guarded = [];

    /**
     * Label kondisi koleksi
     */
    public const KONDISI_LABELS = [
        'baik' => 'Baik',
        'rusak_ringan' => 'Rusak Ringan',
        'rusak_berat' => 'Rusak Berat',
    ];

    /**
     * Relasi kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Menampilkan label kondisi
     */
    public function kondisiLabel(): string
    {
        return self::KONDISI_LABELS[$this->kondisi] ?? $this->kondisi;
    }
}