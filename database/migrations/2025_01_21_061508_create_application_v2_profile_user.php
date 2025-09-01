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
        if (!Schema::hasTable('application_v2_profile_user')) {
            Schema::create('application_v2_profile_user', function (Blueprint $table) {
                // Foreign key for application_id referencing 'applications_v2' table
                $table->foreignUuid('application_id') // Ensure matching data types (UUID)
                    ->constrained('applications_v2') // Points to 'id' in 'applications_v2'
                    ->onDelete('cascade');

                // Foreign key for profile_user_id referencing 'profile_users' table
                $table->foreignUuid('profile_user_id') // Ensure matching data types (UUID)
                    ->constrained('profile_users') // Points to 'id' in 'profile_users'
                    ->onDelete('cascade');

                // Composite primary key on application_id and profile_user_id
                $table->primary(['application_id', 'profile_user_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'application_v2_profile_user' table if rolling back
        Schema::dropIfExists('application_v2_profile_user');
    }
};
