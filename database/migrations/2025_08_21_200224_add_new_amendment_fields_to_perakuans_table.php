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
            // New fields for equipment change
            $table->string('no_permit_peralatan')->nullable();
            $table->string('jenis_peralatan_asal')->nullable();
            $table->string('jenis_peralatan_baru')->nullable();
            $table->text('justifikasi_tukar_peralatan')->nullable();
            
            // New fields for company name change
            $table->string('no_pendaftaran_perniagaan')->nullable();
            $table->date('tarikh_pendaftaran_syarikat')->nullable();
            $table->date('tarikh_luput_pendaftaran')->nullable();
            $table->string('status_perniagaan')->nullable();
            $table->string('nama_syarikat_baru')->nullable();
            $table->text('justifikasi_tukar_nama')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perakuans', function (Blueprint $table) {
            // Remove new fields for equipment change
            $table->dropColumn([
                'no_permit_peralatan',
                'jenis_peralatan_asal',
                'jenis_peralatan_baru',
                'justifikasi_tukar_peralatan'
            ]);
            
            // Remove new fields for company name change
            $table->dropColumn([
                'no_pendaftaran_perniagaan',
                'tarikh_pendaftaran_syarikat',
                'tarikh_luput_pendaftaran',
                'status_perniagaan',
                'nama_syarikat_baru',
                'justifikasi_tukar_nama'
            ]);
        });
    }
};
