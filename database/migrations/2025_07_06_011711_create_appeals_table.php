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
        Schema::create('appeals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('applicant_id');
            $table->string('status')->default('submitted');
            $table->text('ppl_comments')->nullable();
            $table->text('kcl_comments')->nullable();
            $table->text('pk_comments')->nullable();
            $table->string('kpp_decision')->nullable();
            $table->text('kpp_comments')->nullable();
            $table->string('kpp_ref_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appeals');
    }
};
