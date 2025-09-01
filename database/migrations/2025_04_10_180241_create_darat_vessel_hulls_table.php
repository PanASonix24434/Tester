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
        // Check if the table exists before creating it
        if (!Schema::hasTable('darat_vessel_hulls')) {
            Schema::create('darat_vessel_hulls', function (Blueprint $table) {
                $table->uuid('id')->primary();  // UUID as the primary key
                $table->uuid('vessel_id');  // Ensure this is a UUID that matches 'id' in 'darat_vessels'

                // Hull specifications
                $table->string('hull_type')->nullable();
                $table->boolean('drilled')->default(false);
                $table->boolean('brightly_painted')->default(false);
                $table->text('vessel_registration_remarks')->nullable();

                // Dimensions
                $table->decimal('length', 6, 2)->nullable();
                $table->decimal('width', 6, 2)->nullable();
                $table->decimal('depth', 6, 2)->nullable();

                // Image paths
                $table->string('overall_image_path')->nullable();
                $table->string('right_side_image_path')->nullable();

                // Status fields
                $table->boolean('is_active')->default(true);
                $table->boolean('is_approved')->default(false);

                // Audit fields
                $table->uuid('created_by')->nullable();
                $table->uuid('updated_by')->nullable();
                $table->uuid('deleted_by')->nullable();

                // Timestamps and soft deletes
                $table->timestamps();
                $table->softDeletes();

                // Foreign key constraints
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
        Schema::dropIfExists('darat_vessel_hulls');
    }
};
