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
        Schema::table('appeals', function (Blueprint $table) {
            // Add pemohon_status (status shown to applicant)
            $table->string('pemohon_status')->nullable()->after('status');
            
            // Add pegawai_status (status shown to officer)
            $table->string('pegawai_status')->nullable()->after('pemohon_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appeals', function (Blueprint $table) {
            $table->dropColumn(['pemohon_status', 'pegawai_status']);
        });
    }
};
