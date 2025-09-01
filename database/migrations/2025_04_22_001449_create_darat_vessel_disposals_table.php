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
        Schema::create('darat_vessel_disposals', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('application_id')->nullable()->index();
            $table->uuid('user_id')->nullable()->index();

            $table->string('jenis_jualan')->nullable();

            $table->string('owner_name')->nullable();
            $table->string('owner_phone')->nullable();
            $table->text('owner_address')->nullable();
            $table->string('owner_ic')->nullable();

            $table->string('resit_file_path')->nullable();
            $table->string('document_description')->nullable();

            $table->date('disposal_time')->nullable();
            $table->string('disposal_location')->nullable();
            $table->string('disposal_method')->nullable();
            $table->string('before_disposal_image')->nullable();
            $table->string('after_disposal_image')->nullable();
            $table->string('attendance_form_image')->nullable();

            $table->boolean('is_approved')->nullable()->default(false);
            $table->boolean('is_active')->nullable()->default(true);

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('application_id')->references('id')->on('darat_applications')->nullOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('darat_vessel_disposals');
    }
};
