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
        // Check if the table exists before creating it
        if (!Schema::hasTable('profile_user_vessel')) {
            Schema::create('profile_user_vessel', function (Blueprint $table) {
                $table->uuid('profile_user_id');
                $table->uuid('vessel_id');
                $table->string('role')->default('manager');
                $table->string('status')->default('pending');
                $table->timestamps();

                $table->primary(['profile_user_id', 'vessel_id']);
                $table->foreign('profile_user_id')->references('id')->on('profile_users')->onDelete('cascade');
                $table->foreign('vessel_id')->references('id')->on('vessels')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_user_vessel');
    }
};
