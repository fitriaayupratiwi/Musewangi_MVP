<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    /** @use HasFactory<\Database\Factories\MenuFactory> */
    use HasFactory;

    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
