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
        Schema::table('appeals', function (Blueprint $table) {
            // Change reviewer ID columns from unsignedBigInteger to uuid
            $table->uuid('ppl_reviewer_id')->nullable()->change();
            $table->uuid('kcl_reviewer_id')->nullable()->change();
            $table->uuid('pk_reviewer_id')->nullable()->change();
            $table->uuid('kpp_reviewer_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appeals', function (Blueprint $table) {
            // Revert back to unsignedBigInteger
            $table->unsignedBigInteger('ppl_reviewer_id')->nullable()->change();
            $table->unsignedBigInteger('kcl_reviewer_id')->nullable()->change();
            $table->unsignedBigInteger('pk_reviewer_id')->nullable()->change();
            $table->unsignedBigInteger('kpp_reviewer_id')->nullable()->change();
        });
    }
};