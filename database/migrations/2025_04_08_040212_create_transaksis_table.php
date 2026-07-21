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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->integer('total_bayar');
            $table->integer('nomor_meja');
            $table->integer('uang_dibayarkan')->default(0);
            $table->integer('kembalian')->default(0);
            //$table->enum('kembalian',['pending','success'])->default('pending');
            $table->string('metode_pembayaran')->default('tunai');
            $table->string('status')->default('aktif');
            $table->string('status_bayar')->default('belum bayar');
            $table->json('details');
            $table->timestamp('waktu_diantar')->nullable();
            $table->timestamp('waktu_bayar')->nullable();

            // kolom baru untuk kasir
            $table->unsignedBigInteger('kasir_id')->nullable(); 
            $table->foreign('kasir_id')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
