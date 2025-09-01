<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appeals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('applicant_id');
            $table->string('status')->default('draft');
            $table->string('ppl_status')->nullable();
            $table->string('kcl_status')->nullable();
            $table->string('pk_status')->nullable();
            $table->text('ppl_comments')->nullable();
            $table->text('kcl_comments')->nullable();
            $table->text('pk_comments')->nullable();
            $table->string('kpp_decision')->nullable();
            $table->text('kpp_comments')->nullable();
            $table->string('kpp_ref_no')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('appeals');
    }
}; 