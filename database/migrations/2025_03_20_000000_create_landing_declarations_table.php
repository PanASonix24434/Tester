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
        Schema::create('landing_declarations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            //address

            $table->unsignedInteger('year')->nullable();
            $table->unsignedTinyInteger('month')->nullable();
            $table->unsignedTinyInteger('week')->nullable();
            $table->unsignedTinyInteger('startDay')->nullable();
            $table->unsignedTinyInteger('endDay')->nullable();

            $table->boolean('is_verified')->nullable();
            $table->uuid('decision_by')->nullable();
            $table->foreign('decision_by')->references('id')->on('users');
            $table->datetime('decision_at')->nullable();
            
			$table->uuid('landing_status_id')->nullable();
			$table->foreign('landing_status_id')->references('id')->on('code_masters');
            
            $table->datetime('submitted_at')->nullable(); // date applicant send the application
            $table->uuid('entity_id')->nullable();
            $table->foreign('entity_id')->references('id')->on('entities');

            $table->boolean('used_in_monthly')->nullable();

            //audit
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
        Schema::dropIfExists('landing_declarations');
    }
};
