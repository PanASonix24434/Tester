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
        Schema::create('appointments', function (Blueprint $table) {
            //$table->id();
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->string('username')->references('username')->on('users');
            $table->string('name');
            $table->string('icno');
            $table->string('level');
            $table->string('role');
            $table->string('office_duty');
            $table->string('email');
            $table->string('department')->nullable();
            $table->date('report_date');
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('ic_file_path');
            $table->string('ic_file_name');
            $table->string('letter_file_path');
            $table->string('letter_file_name');
            $table->date('inactive_date');
            $table->string('inactive_note')->nullable();
            $table->string('inactive_file_path')->nullable();
            $table->string('inactive_file_name')->nullable();
            $table->integer('status_id');
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
        Schema::dropIfExists('appointments');
    }
};
