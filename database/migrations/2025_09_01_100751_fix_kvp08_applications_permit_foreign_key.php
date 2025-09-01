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
        Schema::table('kvp08_applications', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['permit_id']);
            
            // Add the correct foreign key constraint to permits_new table
            $table->foreign('permit_id')->references('id')->on('permits_new')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kvp08_applications', function (Blueprint $table) {
            // Drop the permits_new foreign key constraint
            $table->dropForeign(['permit_id']);
            
            // Restore the original foreign key constraint to permits table
            $table->foreign('permit_id')->references('id')->on('permits')->onDelete('cascade');
        });
    }
};
