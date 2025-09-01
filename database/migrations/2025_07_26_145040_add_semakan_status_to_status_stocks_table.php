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
            $table->string('semakan_status')->nullable()->after('pengesahan_status');
            $table->timestamp('submitted_at')->nullable()->after('semakan_status');
            $table->string('submitted_by')->nullable()->after('submitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_stocks', function (Blueprint $table) {
            $table->dropColumn(['semakan_status', 'submitted_at', 'submitted_by']);
        });
    }
};
