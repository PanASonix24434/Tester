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
            // Only add deleted_at column if it doesn't exist
            if (!Schema::hasColumn('status_stocks', 'deleted_at')) {
                $table->softDeletes()->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_stocks', function (Blueprint $table) {
            if (Schema::hasColumn('status_stocks', 'deleted_at')) {
                $table->dropColumn('deleted_at');
            }
        });
    }
}; 