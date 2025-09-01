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
        Schema::table('profile_users', function (Blueprint $table) {
            // Add type_id column only if it does not exist
            if (!Schema::hasColumn('profile_users', 'type_id')) {
                $table->foreignUuid('type_id')->nullable()->constrained('code_masters');
            }

            // Add other columns only if they do not exist
            if (!Schema::hasColumn('profile_users', 'ref')) {
                $table->string('ref')->nullable();
            }

            if (!Schema::hasColumn('profile_users', 'phone_code')) {
                $table->string('phone_code')->nullable();
            }

            if (!Schema::hasColumn('profile_users', 'phone')) {
                $table->string('phone')->nullable();
            }

            if (!Schema::hasColumn('profile_users', 'phone_office_code')) {
                $table->string('phone_office_code')->nullable();
            }

            if (!Schema::hasColumn('profile_users', 'phone_office')) {
                $table->string('phone_office')->nullable();
            }

            if (!Schema::hasColumn('profile_users', 'gender_id')) {
                $table->foreignUuid('gender_id')->nullable()->constrained('code_masters');
            }

            if (!Schema::hasColumn('profile_users', 'religion_id')) {
                $table->foreignUuid('religion_id')->nullable()->constrained('code_masters');
            }

            if (!Schema::hasColumn('profile_users', 'race_id')) {
                $table->foreignUuid('race_id')->nullable()->constrained('code_masters');
            }

            if (!Schema::hasColumn('profile_users', 'marital_status_id')) {
                $table->foreignUuid('marital_status_id')->nullable()->constrained('code_masters');
            }

            if (!Schema::hasColumn('profile_users', 'status')) {
                $table->string('status')->nullable();
            }

            if (!Schema::hasColumn('profile_users', 'is_bumiputera')) {
                $table->boolean('is_bumiputera')->nullable();
            }

            if (!Schema::hasColumn('profile_users', 'is_active_ajim')) {
                $table->boolean('is_active_ajim')->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_users', function (Blueprint $table) {
            // Optionally, drop the columns in the down() method if needed
        });
    }
};
