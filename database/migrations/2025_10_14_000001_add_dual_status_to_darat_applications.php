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
        Schema::table('darat_applications', function (Blueprint $table) {
            // Add dual status tracking fields
            $table->string('status_pemohon')->nullable()->after('application_status_id')->comment('Status displayed to applicants');
            $table->string('status_pegawai')->nullable()->after('status_pemohon')->comment('Status displayed to officers');
            $table->string('current_officer_level')->nullable()->after('status_pegawai')->comment('Current processing level: PPL, KCL, PK');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('darat_applications', function (Blueprint $table) {
            $table->dropColumn(['status_pemohon', 'status_pegawai', 'current_officer_level']);
        });
    }
};

