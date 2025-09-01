<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if the 'profile_pentadbir_hartas' table already exists
        if (!Schema::hasTable('profile_pentadbir_hartas')) {
            Schema::create('profile_pentadbir_hartas', function (Blueprint $table) {
                // Primary key as UUID
                $table->uuid('id')->primary();

                // Foreign key linking to the 'profile_users' table (Ensure user_id is a UUID)
                $table->uuid('user_id');
                $table->foreign('user_id')->references('id')->on('profile_users')->onDelete('cascade');

                // Additional fields
                $table->string('pemilik_vesel')->nullable(); // Linking with vessel table
                $table->string('status_pengguna')->nullable();
                $table->string('hubungan')->nullable();
                $table->string('no_vesel')->nullable(); // Linking with vessel table
                $table->string('surat_pelantikan_pentadbir')->nullable();
                $table->string('dokumen_sokongan_1')->nullable();
                $table->string('dokumen_sokongan_2')->nullable();

                // User-related columns for auditing purposes
                $table->uuid('created_by')->nullable();
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');

                $table->uuid('updated_by')->nullable();
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

                $table->uuid('deleted_by')->nullable();
                $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');

                // Timestamps and soft deletes
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        // Drop the 'profile_pentadbir_hartas' table if rolling back
        Schema::dropIfExists('profile_pentadbir_hartas');
    }
};
