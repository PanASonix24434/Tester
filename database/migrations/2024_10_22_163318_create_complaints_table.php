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
        Schema::create('complaints', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->integer('complaint_no');
            $table->string('name');
            $table->string('email');
            $table->string('phone_no');
            $table->string('title');
            $table->string('description');
            $table->string('file_title')->nullable();
			$table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->uuid('assign_to')->nullable();
            $table->string('complaint_type');
            $table->integer('complaint_status');

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
