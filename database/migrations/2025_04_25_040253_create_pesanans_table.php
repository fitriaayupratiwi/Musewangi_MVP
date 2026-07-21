<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesanansTable extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel pesanans.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_meja')->nullable();
            $table->enum('status', ['belum dibayar', 'dibayar', 'keranjang'])->default('belum dibayar');
            $table->decimal('total_harga', 10, 2);
            $table->string('metode_pembayaran')->nullable();
            $table->timestamps();
        });
    }



    /**
     * Pembatalan migrasi.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pesanans', function (Blueprint $table) {
            $table->dropColumn(['status', 'metode_pembayaran', 'total']);
        });
    }
}
