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
            // New fields for Kertas Kerja (replacing Akuan Sumpah)
            $table->string('kertas_kerja_bina_baru_path')->nullable();
            $table->string('kertas_kerja_bina_baru_luar_negara_path')->nullable();
            
            // New fields for unlimited dokumen sokongan (arrays stored as JSON)
            $table->json('dokumen_sokongan_bina_baru_array')->nullable();
            $table->json('dokumen_sokongan_bina_baru_luar_negara_array')->nullable();
            
            // Remove old akuan sumpah field (will be dropped in down method)
            // $table->dropColumn('akuan_sumpah_bina_baru_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perakuans', function (Blueprint $table) {
            // Drop new fields
            $table->dropColumn([
                'kertas_kerja_bina_baru_path',
                'kertas_kerja_bina_baru_luar_negara_path',
                'dokumen_sokongan_bina_baru_array',
                'dokumen_sokongan_bina_baru_luar_negara_array'
            ]);
            
            // Re-add old field if needed
            // $table->string('akuan_sumpah_bina_baru_path')->nullable();
        });
    }
};
