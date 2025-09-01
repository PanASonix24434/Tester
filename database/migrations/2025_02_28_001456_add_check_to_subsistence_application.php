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
        Schema::table('subsistence_application', function (Blueprint $table) {
            $table->string('status_checked')->nullable()->after('sub_application_status'); // [Permohonan Disemak (LENGKAP), Permohonan Disemak (TIDAK LENGKAP)]
            $table->uuid('checked_by')->nullable()->after('status_checked'); // User ID
            $table->foreign('checked_by')->references('id')->on('users')->nullable();
            $table->string('checked_remarks')->nullable()->after('checked_by');

            $table->string('status_supported')->nullable()->after('checked_remarks'); // [Permohonan Disokong KDP, Permohonan Tidak Disokong KDP, Permohonan Disemak KDP (TIDAK LENGKAP)]
            $table->uuid('supported_by')->nullable()->after('status_supported'); // User ID
            $table->foreign('supported_by')->references('id')->on('users')->nullable();
            $table->string('supported_remarks')->nullable()->after('supported_by');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subsistence_application', function (Blueprint $table) {
            //
        });
    }
};
