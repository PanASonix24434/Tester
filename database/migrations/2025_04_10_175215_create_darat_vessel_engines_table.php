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
        if (!Schema::hasTable('darat_vessel_engines')) {
            Schema::create('darat_vessel_engines', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('vessel_id'); // Make sure 'darat_vessels.id' is also UUID

                // Engine specifications
                $table->string('model')->nullable();
                $table->string('brand')->nullable();
                $table->integer('horsepower')->nullable();
                $table->string('engine_number')->nullable();
                $table->string('engine_image_path')->nullable();
                $table->string('engine_number_image_path')->nullable();

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
                $table->foreign('vessel_id')
                    ->references('id')->on('darat_vessels')
                    ->onDelete('cascade');

                $table->foreign('created_by')
                    ->references('id')->on('users')
                    ->onDelete('set null');

                $table->foreign('updated_by')
                    ->references('id')->on('users')
                    ->onDelete('set null');

                $table->foreign('deleted_by')
                    ->references('id')->on('users')
                    ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('darat_vessel_engines');
    }
};
