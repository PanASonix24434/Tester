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
        Schema::table('subsistence_doc', function (Blueprint $table) {
            $table->string('status')->nullable()->after('file_detail'); // 'verified' or 'rejected'
            $table->uuid('verified_by')->nullable()->after('status'); // User ID
            $table->timestamp('verified_at')->nullable()->after('verified_by'); // Timestamp
            
           
            $table->foreign('verified_by')->references('id')->on('users')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subsistence_doc', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['status', 'verified_by', 'verified_at']);
        });
    }
};
