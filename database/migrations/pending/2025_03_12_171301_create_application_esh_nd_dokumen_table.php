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
        Schema::create('application_esh_nd_dokumen', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('application_esh_nd_id')->constrained('application_esh_nd')->onDelete('cascade');

            $table->enum('file_type', ['bank', 'kwsp', 'aadk', 'support']);
            $table->string('file_desc')->nullable();
            $table->string('file_name');
            $table->string('file_path');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_esh_nd_dokumen');
    }
};
