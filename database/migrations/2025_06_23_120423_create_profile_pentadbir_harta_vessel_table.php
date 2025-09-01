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
       Schema::create('profile_pentadbir_harta_vessel', function (Blueprint $table) {
    $table->uuid('profile_pentadbir_harta_id');
    $table->uuid('vessel_id');

    // Rename the constraints to shorter names
    $table->foreign('profile_pentadbir_harta_id', 'fk_pph_vessel_profile')
        ->references('id')->on('profile_pentadbir_hartas')
        ->onDelete('cascade');

    $table->foreign('vessel_id', 'fk_pph_vessel_vessel')
        ->references('id')->on('vessels')
        ->onDelete('cascade');

    $table->primary(['profile_pentadbir_harta_id', 'vessel_id']);
});    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_pentadbir_harta_vessel');
    }
};
