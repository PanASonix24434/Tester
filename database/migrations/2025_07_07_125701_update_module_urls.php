<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the main Permohonan module URL
        DB::table('modules')
            ->where('name', 'Permohonan')
            ->update(['url' => '/application']);

        // Update the Borang Permohonan child module URL
        DB::table('modules')
            ->where('name', 'Borang Permohonan')
            ->update(['url' => 'application/borang-permohonan']);

        // Update the Senarai Permohonan child module URL
        DB::table('modules')
            ->where('name', 'Senarai Permohonan')
            ->update(['url' => '/appeals/amendment']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the main Permohonan module URL
        DB::table('modules')
            ->where('name', 'Permohonan')
            ->update(['url' => '/application']);

        // Revert the Borang Permohonan child module URL
        DB::table('modules')
            ->where('name', 'Borang Permohonan')
            ->update(['url' => '/application/form']);

        // Revert the Senarai Permohonan child module URL
        DB::table('modules')
            ->where('name', 'Senarai Permohonan')
            ->update(['url' => '/application/formlist']);
    }
};
