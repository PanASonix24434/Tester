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
            if (Schema::hasColumn('status_stocks', 'submitted_at')) {
                $table->dropColumn('submitted_at');
            }
            if (Schema::hasColumn('status_stocks', 'submitted_by')) {
                $table->dropColumn('submitted_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_stocks', function (Blueprint $table) {
            $table->timestamp('submitted_at')->nullable()->after('final_decision_at');
            $table->char('submitted_by', 36)->nullable()->after('submitted_at');
        });
    }
}; 