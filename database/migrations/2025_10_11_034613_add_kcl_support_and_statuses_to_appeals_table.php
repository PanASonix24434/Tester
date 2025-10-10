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
            // Add missing columns only
            if (!Schema::hasColumn('appeals', 'kcl_support')) {
                $table->string('kcl_support')->nullable()->after('kcl_status');
            }
            if (!Schema::hasColumn('appeals', 'pk_decision')) {
                $table->string('pk_decision')->nullable()->after('pk_comments');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appeals', function (Blueprint $table) {
            if (Schema::hasColumn('appeals', 'kcl_support')) {
                $table->dropColumn('kcl_support');
            }
            if (Schema::hasColumn('appeals', 'pk_decision')) {
                $table->dropColumn('pk_decision');
            }
        });
    }
};
