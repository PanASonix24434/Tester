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
        Schema::create('landing_declaration_monthlies', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Foreign key relationships
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            // Year and month columns
            $table->unsignedInteger('year')->nullable();
            $table->unsignedTinyInteger('month')->nullable();

            // Week reference columns (relating to the 'landing_declarations' table)
            $table->uuid('week1_id')->nullable();
            $table->foreign('week1_id')->references('id')->on('landing_declarations');
            $table->uuid('week2_id')->nullable();
            $table->foreign('week2_id')->references('id')->on('landing_declarations');
            $table->uuid('week3_id')->nullable();
            $table->foreign('week3_id')->references('id')->on('landing_declarations');
            $table->uuid('week4_id')->nullable();
            $table->foreign('week4_id')->references('id')->on('landing_declarations');
            $table->uuid('week5_id')->nullable();
            $table->foreign('week5_id')->references('id')->on('landing_declarations');

            // Verification and decision columns
            $table->boolean('is_verified')->nullable();
            $table->uuid('decision_by')->nullable();
            $table->foreign('decision_by')->references('id')->on('users');
            $table->datetime('decision_at')->nullable();

            // Status and entity-related columns
            $table->uuid('landing_status_id')->nullable();
            $table->foreign('landing_status_id')->references('id')->on('code_masters');
            $table->uuid('entity_id')->nullable();
            $table->foreign('entity_id')->references('id')->on('entities');
            $table->datetime('submitted_at')->nullable(); // Submission date for the application

            // Payment and approval status
            $table->boolean('used_in_payment')->default(false);
            $table->boolean('has_payed')->default(false);

            // Audit fields
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->uuid('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->uuid('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');

            // Timestamps and soft deletes
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_declaration_monthlies');
    }
};
