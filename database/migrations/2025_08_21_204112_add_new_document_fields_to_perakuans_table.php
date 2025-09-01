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
            // New document field for equipment change
            $table->string('dokumen_sokongan_tukar_peralatan_path')->nullable();
            
            // New document fields for company name change
            $table->string('borang_e_kaedah_13_path')->nullable();
            $table->string('profil_perniagaan_enterprise_path')->nullable();
            $table->string('form_9_path')->nullable();
            $table->string('form_24_path')->nullable();
            $table->string('form_44_path')->nullable();
            $table->string('form_49_path')->nullable();
            $table->string('pendaftaran_persatuan_path')->nullable();
            $table->string('profil_persatuan_path')->nullable();
            $table->string('pendaftaran_koperasi_path')->nullable();
            $table->string('profil_koperasi_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perakuans', function (Blueprint $table) {
            // Remove new document fields
            $table->dropColumn([
                'dokumen_sokongan_tukar_peralatan_path',
                'borang_e_kaedah_13_path',
                'profil_perniagaan_enterprise_path',
                'form_9_path',
                'form_24_path',
                'form_44_path',
                'form_49_path',
                'pendaftaran_persatuan_path',
                'profil_persatuan_path',
                'pendaftaran_koperasi_path',
                'profil_koperasi_path'
            ]);
        });
    }
};
