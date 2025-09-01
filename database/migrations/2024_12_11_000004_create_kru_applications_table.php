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
        Schema::create('kru_applications', function (Blueprint $table) {

			$table->uuid('id')->primary();
			$table->uuid('kru_application_type_id');
			$table->foreign('kru_application_type_id')->references('id')->on('kru_application_types');
			$table->uuid('user_id');
			$table->foreign('user_id')->references('id')->on('users');
            $table->string('reference_number')->unique()->nullable();

			$table->uuid('kru_application_status_id')->nullable();
			$table->foreign('kru_application_status_id')->references('id')->on('code_masters');
            $table->uuid('entity_id')->nullable();
            $table->foreign('entity_id')->references('id')->on('entities');
            $table->datetime('submitted_at')->nullable(); // date applicant send the application
            $table->datetime('start_counting_at')->nullable(); // date fa(D) forward the application
            
			$table->string('registration_number')->nullable();
			$table->date('registration_start')->nullable();
			$table->date('registration_end')->nullable();
            $table->string('pin_number')->nullable();
            $table->string('ssd_number')->unique()->nullable();
            
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->uuid('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->uuid('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kru_applications');
    }
};
