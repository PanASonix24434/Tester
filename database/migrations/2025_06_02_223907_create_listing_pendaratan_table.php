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
        Schema::create('listing_pendaratan', function (Blueprint $table) {
        $table->id();
        $table->string('pelayaran_no');
        $table->uuid('vessel_id'); // Tukar ke UUID
        $table->string('bulan');
        $table->integer('jumlah_hari_di_laut');
        $table->dateTime('tarikh_masa_berlepas');
        $table->dateTime('tarikh_masa_tiba');
        $table->time('purata_masa_memukat');
        $table->string('dokumen_nama')->nullable();
        $table->string('dokumen_type')->nullable();
        $table->string('dokumen')->nullable(); 
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_pendaratan');
    }
};
