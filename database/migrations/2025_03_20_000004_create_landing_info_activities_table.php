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
        Schema::create('landing_info_activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('landing_info_id');
            $table->foreign('landing_info_id')->references('id')->on('landing_infos');
            
            $table->uuid('landing_activity_type_id');
            $table->foreign('landing_activity_type_id')->references('id')->on('landing_activity_types');
            $table->string('equipment')->nullable();
            $table->time('time')->nullable();

            $table->uuid('state_id')->nullable();
			$table->foreign('state_id')->references('id')->on('code_masters');
            $table->uuid('district_id')->nullable();
			$table->foreign('district_id')->references('id')->on('code_masters');
            $table->string('location_name')->nullable();

            $table->uuid('landing_water_type_id')->nullable();
			$table->foreign('landing_water_type_id')->references('id')->on('landing_water_types');

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_info_activities');
    }
};
