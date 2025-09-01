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
        Schema::table('kru_application_foreigns', function (Blueprint $table) {
            $table->dropForeign(['immigration_gate_id']);
            $table->dropColumn('immigration_gate_id');
        });

        Schema::table('kru_application_foreigns', function (Blueprint $table) {
			$table->uuid('immigration_gate_id')->nullable();
			$table->foreign('immigration_gate_id')->references('id')->on('immigration_gates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kru_application_foreigns', function (Blueprint $table) {
            $table->dropForeign(['immigration_gate_id']);
            $table->dropColumn('immigration_gate_id');
        });
    }
};
