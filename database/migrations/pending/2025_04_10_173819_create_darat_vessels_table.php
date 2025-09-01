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
        Schema::create('darat_vessels', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->unique();

            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('vessel_condition')->nullable();
            $table->string('vessel_registration_number')->nullable();
            $table->string('transportation')->nullable();
            
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_active')->default(true);

            $table->string('safety_jacket_status')->nullable();
            $table->integer('safety_jacket_quantity')->nullable();
            $table->string('safety_jacket_condition')->nullable();
            $table->string('safety_jacket_image_path')->nullable();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('darat_vessels');
    }
};
