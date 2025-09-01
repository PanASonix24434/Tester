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
        Schema::create('confiscation_docs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('confiscation_id')->nullable();
			$table->foreign('confiscation_id')->references('id')->on('confiscation');

            $table->string('title');
			$table->string('file_path');
            $table->string('file_detail');
			$table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->uuid('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confiscation_docs');
    }
};
