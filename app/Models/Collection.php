<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use HasFactory;

   protected $fillable = [
    'foto',
    'voice_over',
    'no_registrasi',
    'no_registrasi_lama',
    'nama_koleksi',
    'kategori',
    'jenis_benda',
    'tahun_pembuatan',
    'asal',
    'kondisi',
    'deskripsi',
];
}