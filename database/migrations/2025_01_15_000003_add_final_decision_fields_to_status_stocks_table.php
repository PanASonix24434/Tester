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
            if (!Schema::hasColumn('status_stocks', 'final_decision_by')) {
                $table->char('final_decision_by', 36)->nullable()->after('final_decision');
            }
            if (!Schema::hasColumn('status_stocks', 'final_decision_at')) {
                $table->timestamp('final_decision_at')->nullable()->after('final_decision_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_stocks', function (Blueprint $table) {
            $table->dropColumn(['final_decision_by', 'final_decision_at']);
        });
    }
}; 