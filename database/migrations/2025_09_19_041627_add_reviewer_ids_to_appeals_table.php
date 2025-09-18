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
            $table->unsignedBigInteger('ppl_reviewer_id')->nullable()->after('ppl_comments');
            $table->unsignedBigInteger('kcl_reviewer_id')->nullable()->after('kcl_comments');
            $table->unsignedBigInteger('pk_reviewer_id')->nullable()->after('pk_comments');
            $table->unsignedBigInteger('kpp_reviewer_id')->nullable()->after('kpp_comments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appeals', function (Blueprint $table) {
            $table->dropColumn([
                'ppl_reviewer_id',
                'kcl_reviewer_id', 
                'pk_reviewer_id',
                'kpp_reviewer_id'
            ]);
        });
    }
};