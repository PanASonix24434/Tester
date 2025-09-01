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
        Schema::create('announcements', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('file_title')->nullable();
			$table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->integer('announcement_type');
            $table->integer('announcement_status');

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
        Schema::dropIfExists('announcements');
    }
};
