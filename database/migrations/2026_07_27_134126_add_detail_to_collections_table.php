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
        Schema::table('collections', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('collections', function (Blueprint $table) {

        $table->dropColumn('no_registrasi_lama');
        $table->dropColumn('kategori');
        $table->string('jenis_benda')->nullable();
        $table->string('tahun_pembuatan')->nullable();
        $table->string('voice_over')->nullable();

    });
}
};
