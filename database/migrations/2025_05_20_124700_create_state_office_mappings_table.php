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
         Schema::create('state_office_mappings', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Nullable foreign keys
            $table->uuid('parent_id')->nullable();
            $table->uuid('state_id')->nullable();
            $table->uuid('district_id')->nullable();
            $table->uuid('office_id')->nullable();

            // Nullable audit fields
            $table->boolean('is_active')->nullable()->default(true);
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            // Timestamps & soft delete
            $table->timestamps();
            $table->softDeletes();

            // Optional foreign key constraints
            $table->foreign('state_id')->references('id')->on('code_masters')->onDelete('restrict');
            $table->foreign('district_id')->references('id')->on('code_masters')->onDelete('restrict');
            $table->foreign('parent_id')->references('id')->on('entities')->onDelete('restrict');
            $table->foreign('office_id')->references('id')->on('entities')->onDelete('restrict');
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
        Schema::dropIfExists('state_office_mappings');
    }
};
