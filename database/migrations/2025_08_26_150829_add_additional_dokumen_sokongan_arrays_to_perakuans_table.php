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
            // Additional dokumen sokongan array fields for unlimited document uploads
            $table->json('dokumen_sokongan_terpakai_array')->nullable();
            $table->json('dokumen_sokongan_pangkalan_array')->nullable();
            $table->json('dokumen_sokongan_bahan_binaan_array')->nullable();
            $table->json('dokumen_sokongan_tukar_peralatan_array')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perakuans', function (Blueprint $table) {
            $table->dropColumn([
                'dokumen_sokongan_terpakai_array',
                'dokumen_sokongan_pangkalan_array',
                'dokumen_sokongan_bahan_binaan_array',
                'dokumen_sokongan_tukar_peralatan_array'
            ]);
        });
    }
};
