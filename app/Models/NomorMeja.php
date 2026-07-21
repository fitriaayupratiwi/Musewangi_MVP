<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomorMeja extends Model
{
    /** @use HasFactory<\Database\Factories\NomorMejaFactory> */
    use HasFactory;
    protected $guarded = [];
    protected $table = 'nomor_mejas';
}
