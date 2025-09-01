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
        Schema::create('dokumen_sokongan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('appeals_id');
            $table->string('ref_number');
            $table->uuid('user_id');
            $table->string('file_path', 500);
            $table->string('file_name');
            $table->enum('file_type', [
                'bina_baru', 
                'bina_baru_luar_negara', 
                'terpakai', 
                'pangkalan', 
                'bahan_binaan', 
                'tukar_peralatan'
            ]);
            $table->bigInteger('file_size')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->timestamp('upload_date')->useCurrent();
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('appeals_id')->references('id')->on('appeals')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Indexes for better performance
            $table->index('appeals_id');
            $table->index('file_type');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_sokongan');
    }
};
