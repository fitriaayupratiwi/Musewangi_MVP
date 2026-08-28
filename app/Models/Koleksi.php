<?php

namespace App\Models;

/**
 * Koleksi alias / compatibility model for Collection.
 * Both point to the same 'collections' table.
 */
class Koleksi extends Collection
{
    protected $table = 'collections';
}