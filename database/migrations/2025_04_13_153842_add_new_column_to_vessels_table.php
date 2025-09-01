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
        Schema::table('vessels', function (Blueprint $table) {
            // $table->string('vessel_no'); // Commented out to avoid duplicate column error
            // $table->string('zone')->nullable(); // Commented out to avoid duplicate column error
            // $table->dateTime('start_date')->nullable(); // Commented out to avoid duplicate column error
            // $table->dateTime('end_date')->nullable(); // Commented out to avoid duplicate column error
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vessels', function (Blueprint $table) {
            //
        });
    }
};
