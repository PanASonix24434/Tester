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
        Schema::create('foreign_crews', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->string('passport_number')->unique();
			$table->date('passport_end_date')->nullable();
            $table->string('plks_number')->nullable();
			$table->date('plks_end_date')->nullable();
            $table->string('name');
            
            $table->uuid('vessel_id')->nullable();
			$table->foreign('vessel_id')->references('id')->on('vessels');

			$table->date('birth_date');
            $table->uuid('gender_id');
            $table->foreign('gender_id')->references('id')->on('code_masters');
            // $table->string('nationality');
            $table->uuid('source_country_id')->nullable();
            $table->foreign('source_country_id')->references('id')->on('code_masters');
            $table->uuid('foreign_kru_position_id')->nullable();
			$table->foreign('foreign_kru_position_id')->references('id')->on('code_masters');
			$table->string('crew_whereabout')->nullable();
            
            $table->uuid('kru_application_foreign_kru_id')->nullable();
            $table->foreign('kru_application_foreign_kru_id')->references('id')->on('kru_application_foreign_krus');

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
        Schema::dropIfExists('foreign_crews');
    }
};
