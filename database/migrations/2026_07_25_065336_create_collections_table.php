<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collections', function (Blueprint $table) {

            $table->id();

            $table->string('no_registrasi');

            $table->string('no_registrasi_lama')
                ->nullable();

            $table->string('nama_koleksi');

            $table->string('kategori')
                ->nullable();

            $table->string('jenis_benda')
                ->nullable();

            $table->string('tahun_pembuatan')
                ->nullable();

            $table->string('asal');

            $table->enum('kondisi',[
                'Baik',
                'Rusak Ringan',
                'Rusak Berat'
            ]);

            $table->text('deskripsi')
                ->nullable();

            $table->string('foto')->nullable();

            $table->string('voice_over')->nullable();
            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};