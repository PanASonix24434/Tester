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
        // Check if the table already exists to avoid duplication error
        if (!Schema::hasTable('darat_vessel_histories')) {
            Schema::create('darat_vessel_histories', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('vessel_id');  // Ensure both vessel_id columns are UUIDs
                
                $table->string('vessel_condition')->nullable();
                $table->string('vessel_registration_number')->nullable();
                $table->string('transportation')->nullable();
                $table->boolean('is_approved')->default(false)->nullable();
                $table->boolean('is_active')->default(true)->nullable();
            
                $table->boolean('safety_jacket_status')->nullable();
                $table->integer('safety_jacket_quantity')->nullable();
                $table->string('safety_jacket_condition')->nullable();
                $table->string('safety_jacket_image_path')->nullable();
            
                $table->uuid('created_by')->nullable();
                $table->uuid('updated_by')->nullable();
                $table->uuid('deleted_by')->nullable();
            
                $table->softDeletes();
                $table->timestamps();
            
                // Ensure foreign key references are consistent with UUID
                $table->foreign('vessel_id')->references('id')->on('darat_vessels')->onDelete('cascade');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the table if it exists
        Schema::dropIfExists('darat_vessel_histories');
    }
};
