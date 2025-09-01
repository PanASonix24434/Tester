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
        Schema::create('darat_vessel_engine_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('vessel_engine_id');

            $table->string('engine_model')->nullable();
            $table->string('engine_brand')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('engine_image_path')->nullable();
            $table->string('engine_number_image_path')->nullable();
            $table->integer('horsepower')->nullable();

            $table->boolean('is_active')->nullable()->default(true);
            $table->boolean('is_approved')->nullable()->default(false);

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('vessel_engine_id')->references('id')->on('darat_vessel_engines')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('darat_vessel_engine_histories');
    }
};
