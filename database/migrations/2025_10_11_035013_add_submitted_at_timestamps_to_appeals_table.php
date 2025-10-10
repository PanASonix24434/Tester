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
            if (!Schema::hasColumn('appeals', 'ppl_submitted_at')) {
                $table->timestamp('ppl_submitted_at')->nullable()->after('ppl_reviewer_id');
            }
            if (!Schema::hasColumn('appeals', 'kcl_submitted_at')) {
                $table->timestamp('kcl_submitted_at')->nullable()->after('kcl_reviewer_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appeals', function (Blueprint $table) {
            if (Schema::hasColumn('appeals', 'ppl_submitted_at')) {
                $table->dropColumn('ppl_submitted_at');
            }
            if (Schema::hasColumn('appeals', 'kcl_submitted_at')) {
                $table->dropColumn('kcl_submitted_at');
            }
        });
    }
};
