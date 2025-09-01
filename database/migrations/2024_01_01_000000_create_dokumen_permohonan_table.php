<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if the table already exists
        if (!Schema::hasTable('dokumen_permohonan')) {
            Schema::create('dokumen_permohonan', function (Blueprint $table) {
                $table->id(); // Auto-incrementing primary key
                $table->uuid('user_id'); // Foreign key to the users table
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

                $table->string('file_path');
                $table->string('type');
                $table->timestamps(); // Created and updated timestamps
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_permohonan');
    }
};
