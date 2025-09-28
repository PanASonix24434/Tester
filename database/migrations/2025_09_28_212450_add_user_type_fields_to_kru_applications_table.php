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
        Schema::table('kru_applications', function (Blueprint $table) {
            $table->string('applicant_type')->default('regular_user')->after('user_id');
            $table->uuid('profile_user_id')->nullable()->after('applicant_type');
            $table->foreign('profile_user_id')->references('id')->on('profile_users')->onDelete('set null');
            $table->uuid('vessel_id')->nullable()->after('profile_user_id');
            $table->foreign('vessel_id')->references('id')->on('vessels')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kru_applications', function (Blueprint $table) {
            $table->dropForeign(['profile_user_id']);
            $table->dropForeign(['vessel_id']);
            $table->dropColumn(['applicant_type', 'profile_user_id', 'vessel_id']);
        });
    }
};
