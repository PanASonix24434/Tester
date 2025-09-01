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
        Schema::table('status_stocks', function (Blueprint $table) {
            // Change the audit fields from BIGINT to CHAR(36) to support UUIDs
            $table->char('created_by', 36)->nullable()->change();
            $table->char('updated_by', 36)->nullable()->change();
            $table->char('deleted_by', 36)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_stocks', function (Blueprint $table) {
            // Revert back to BIGINT
            $table->unsignedBigInteger('created_by')->nullable()->change();
            $table->unsignedBigInteger('updated_by')->nullable()->change();
            $table->unsignedBigInteger('deleted_by')->nullable()->change();
        });
    }
}; 