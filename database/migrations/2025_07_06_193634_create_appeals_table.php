<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appeals', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID
            $table->uuid('applicant_id')->nullable(); // ✅ REQUIRED COLUMN
            $table->string('nama_permohonan')->nullable();
            $table->string('no_perolehan')->nullable();
            $table->string('zon')->nullable();
            $table->date('tarikh_mula_kelulusan')->nullable();
            $table->date('tarikh_tamat_kelulusan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appeals');
    }
};
