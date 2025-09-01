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
        Schema::create('application_v2_vessel', function (Blueprint $table) {
            $table->foreignUuid('application_id')->constrained('applications_v2')->onDelete('cascade');
            $table->foreignUuid('vessel_id')->constrained()->onDelete('cascade');

            $table->primary(['application_id', 'vessel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_v2_vessel');
    }
};
