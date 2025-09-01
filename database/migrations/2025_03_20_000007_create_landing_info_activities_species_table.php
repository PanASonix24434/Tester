<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('landing_activity_species', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('landing_info_activity_id');
            $table->foreign('landing_info_activity_id')->references('id')->on('landing_info_activities')->onDelete('cascade'); // Ensuring deletion cascades

            $table->string('species_id');
            $table->foreign('species_id')->references('id')->on('species')->onDelete('cascade'); // Ensure deletion cascades
            $table->float('weight');
            $table->float('price_per_weight');

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key constraint first
        DB::statement('ALTER TABLE landing_activity_species DROP FOREIGN KEY landing_activity_species_landing_info_activity_id_foreign');
        DB::statement('ALTER TABLE landing_activity_species DROP FOREIGN KEY landing_activity_species_species_id_foreign');
        
        // Then drop the dependent table
        Schema::dropIfExists('landing_activity_species');
        
        // Finally, drop the parent table
        Schema::dropIfExists('landing_info_activities');
    }
};
