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
        Schema::create('ssds', function (Blueprint $table) {
			$table->uuid('id')->primary();
            $table->string('ssd_number',10)->unique();
            
            $table->string('application_table_name')->nullable();//ie: kru_applications
            $table->string('application_id')->nullable();//ie: id for the application in the table
            $table->boolean('has_used')->default(false);
            $table->boolean('is_faulty')->default(false);
            
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
        Schema::dropIfExists('ssds');
    }
};
