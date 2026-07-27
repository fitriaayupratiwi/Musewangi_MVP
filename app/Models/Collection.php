<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'foto',
        'no_registrasi',
        'nama_koleksi',
        'asal',
        'kondisi',
        'deskripsi',
    ];
}