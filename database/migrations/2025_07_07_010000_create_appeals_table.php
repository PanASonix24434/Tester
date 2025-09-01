<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appeals', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('applicant_id', 36);
            $table->string('status');
            $table->text('ppl_comments')->nullable();
            $table->text('kcl_comments')->nullable();
            $table->text('pk_comments')->nullable();
            $table->string('kpp_decision')->nullable();
            $table->text('kpp_comments')->nullable();
            $table->string('kpp_ref_no')->nullable();
            $table->string('decision_letter_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appeals');
    }
}; 