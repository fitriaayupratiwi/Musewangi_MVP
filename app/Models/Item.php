<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['pesanan_id', 'menu_id', 'jumlah', 'harga'];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}