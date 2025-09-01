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
        Schema::table('perakuans', function (Blueprint $table) {
            $table->date('tarikh_mula_kelulusan')->nullable()->after('justifikasi_lanjutan_tempoh');
            $table->date('tarikh_tamat_kelulusan')->nullable()->after('tarikh_mula_kelulusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perakuans', function (Blueprint $table) {
            $table->dropColumn(['tarikh_mula_kelulusan', 'tarikh_tamat_kelulusan']);
        });
    }
};
