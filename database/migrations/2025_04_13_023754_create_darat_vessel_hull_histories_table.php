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
        Schema::create('darat_vessel_hull_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('vessel_hull_id')->nullable();

            $table->string('hull_type')->nullable();
            $table->boolean('drilled')->nullable();
            $table->boolean('brightly_painted')->nullable();
            $table->text('vessel_registration_remarks')->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('depth', 8, 2)->nullable();
            $table->string('overall_image_path')->nullable();
            $table->string('right_side_image_path')->nullable();

            $table->boolean('is_active')->default(true)->nullable();
            $table->boolean('is_approved')->default(false)->nullable();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('vessel_hull_id')->references('id')->on('darat_vessel_hulls')->onDelete('cascade');
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
        Schema::dropIfExists('darat_vessel_hull_histories');
    }
};
