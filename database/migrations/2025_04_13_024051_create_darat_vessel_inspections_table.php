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
        // Check if the table already exists before creating it
        if (!Schema::hasTable('darat_vessel_inspections')) {
            Schema::create('darat_vessel_inspections', function (Blueprint $table) {
                $table->uuid('id')->primary(); // UUID as the primary key
            
                $table->uuid('vessel_id')->nullable(); // Ensure this is a UUID that matches 'id' in 'darat_vessels'
                $table->uuid('application_id')->nullable();
        
                $table->date('inspection_date')->nullable();
                $table->date('valid_date')->nullable();  
                $table->string('inspection_location')->nullable();
                $table->string('inspected_by')->nullable();
                $table->boolean('is_support')->default(false); 
                $table->text('inspection_summary')->nullable();
            
                $table->string('vessel_registration_number')->nullable();
                $table->string('vessel_condition')->nullable();
                $table->string('vessel_origin')->nullable();
        
                $table->string('hull_type')->nullable();
                $table->boolean('drilled')->nullable();
                $table->boolean('brightly_painted')->nullable();
                $table->string('vessel_registration_remarks')->nullable();
                $table->float('length', 8, 2)->nullable();
                $table->float('width', 8, 2)->nullable();
                $table->float('depth', 8, 2)->nullable();
            
                $table->string('engine_model')->nullable();
                $table->string('engine_brand')->nullable();
                $table->integer('horsepower')->nullable();
                $table->string('engine_number')->nullable();
            
                $table->boolean('safety_jacket_status')->nullable();
                $table->integer('safety_jacket_quantity')->nullable();
                $table->string('safety_jacket_condition')->nullable();
            
                $table->string('attendance_form_path')->nullable();
                $table->string('vessel_image_path')->nullable();
                $table->string('inspector_owner_image_path')->nullable();
                $table->string('overall_image_path')->nullable();
                $table->string('safety_jacket_image_path')->nullable();
                $table->string('engine_image_path')->nullable();
                $table->string('engine_number_image_path')->nullable();
        
                $table->boolean('is_approved')->default(false);
                $table->boolean('is_active')->default(true);
        
                $table->uuid('created_by')->nullable();
                $table->uuid('updated_by')->nullable();
                $table->uuid('deleted_by')->nullable();
        
                $table->softDeletes();
                $table->timestamps();
        
                // Foreign key constraints
                $table->foreign('vessel_id')->references('id')->on('darat_vessels')->onDelete('set null');
                $table->foreign('application_id')->references('id')->on('darat_applications')->onDelete('set null');
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
        Schema::dropIfExists('darat_vessel_inspections');
    }
};
