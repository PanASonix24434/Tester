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
        Schema::table('landing_declarations', function (Blueprint $table) {
            $table->uuid('landing_declare_monthly_id')->nullable();
			$table->foreign('landing_declare_monthly_id')->references('id')->on('landing_declaration_monthlies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_declarations', function (Blueprint $table) {
            $table->dropForeign(['landing_declare_monthly_id']);
        });
    }
};
