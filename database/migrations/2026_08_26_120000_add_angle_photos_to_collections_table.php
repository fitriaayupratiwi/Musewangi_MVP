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
            if (!Schema::hasColumn('collections', 'foto_samping')) {
                $table->string('foto_samping')->nullable()->after('foto');
            }
            if (!Schema::hasColumn('collections', 'foto_belakang')) {
                $table->string('foto_belakang')->nullable()->after('foto_samping');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropColumn(['foto_samping', 'foto_belakang']);
        });
    }
};
