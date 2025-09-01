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
        // Update the Senarai Permohonan module URL to point to the new landing page
        DB::table('modules')
            ->where('name', 'Senarai Permohonan')
            ->where('parent_id', function($query) {
                $query->select('id')
                      ->from('modules')
                      ->where('name', 'Permohonan');
            })
            ->update(['url' => '/appeals/senarai-permohonan']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the Senarai Permohonan module URL back to the old amendment page
        DB::table('modules')
            ->where('name', 'Senarai Permohonan')
            ->where('parent_id', function($query) {
                $query->select('id')
                      ->from('modules')
                      ->where('name', 'Permohonan');
            })
            ->update(['url' => '/appeal/amendment']);
    }
};
