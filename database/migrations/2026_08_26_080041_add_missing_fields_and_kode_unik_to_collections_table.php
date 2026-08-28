<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            if (!Schema::hasColumn('collections', 'kode_unik')) {
                $table->string('kode_unik', 36)->unique()->nullable()->after('id');
            }
            if (!Schema::hasColumn('collections', 'no_registrasi_lama')) {
                $table->string('no_registrasi_lama')->nullable()->after('no_registrasi');
            }
            if (!Schema::hasColumn('collections', 'kategori')) {
                $table->string('kategori')->nullable()->after('nama_koleksi');
            }
            if (!Schema::hasColumn('collections', 'jenis_benda')) {
                $table->string('jenis_benda')->nullable()->after('kategori');
            }
            if (!Schema::hasColumn('collections', 'tahun_pembuatan')) {
                $table->string('tahun_pembuatan')->nullable()->after('jenis_benda');
            }
            if (!Schema::hasColumn('collections', 'voice_over')) {
                $table->string('voice_over')->nullable()->after('foto');
            }
        });

        // Backfill kode_unik
        $collections = DB::table('collections')->whereNull('kode_unik')->get();
        foreach ($collections as $c) {
            DB::table('collections')->where('id', $c->id)->update([
                'kode_unik' => Str::uuid()->toString()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $columnsToDrop = [];
            foreach (['kode_unik', 'no_registrasi_lama', 'kategori', 'jenis_benda', 'tahun_pembuatan', 'voice_over'] as $col) {
                if (Schema::hasColumn('collections', $col)) {
                    $columnsToDrop[] = $col;
                }
            }
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
