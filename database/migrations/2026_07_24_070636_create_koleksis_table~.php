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
        Schema::create('koleksis', function (Blueprint $table) {
            $table->id();
            $table->string('no_registrasi_baru')->unique();
            $table->string('no_registrasi_lama')->nullable();
            $table->string('nama');
            $table->foreignId('kategori_id')->constrained('categories')->onDelete('cascade');
            $table->string('jenis_benda');
            $table->string('tahun_pembuatan')->nullable();
            $table->string('asal')->nullable();
            $table->enum('kondisi', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();
            $table->string('audio')->nullable();
            $table->string('qr_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koleksis');
    }
};
