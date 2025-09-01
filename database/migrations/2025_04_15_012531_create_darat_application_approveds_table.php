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
        Schema::create('darat_application_approveds', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Foreign key to the original application
            $table->uuid('application_id');
            $table->string('certificate_number')->unique();

            // Approval metadata
            $table->uuid('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            // Validity
            $table->integer('valid_duration_months')->default(12);
            $table->timestamp('expired_at')->nullable();
            $table->boolean('is_active')->default(true);

            // Audit fields
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('application_id')->references('id')->on('darat_applications')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('darat_application_approveds');
    }
};
