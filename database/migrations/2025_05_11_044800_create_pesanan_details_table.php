<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id');
            $table->unsignedBigInteger('menu_id'); // Menambahkan relasi ke tabel menus
            $table->string('nama_produk'); // Ini mungkin duplikat dari nama di tabel menu, bisa dihilangkan jika yakin selalu ada menu_id
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 10, 2); // Mengganti nama kolom menjadi harga_satuan
            $table->decimal('total_harga', 10, 2); // Menambahkan kolom total_harga
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('pesanan_id')->references('id')->on('pesanans')->onDelete('cascade');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade'); // Menambahkan foreign key ke tabel menus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_details');
    }
};