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
        Schema::create('kvp08_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('appeal_id')->constrained('appeals')->onDelete('cascade');
            $table->foreignId('permit_id')->constrained('permits')->onDelete('cascade');
            $table->text('justifikasi');
            $table->string('extension_period'); // 6 months or 12 months
            $table->date('new_expiry_date');
            $table->string('status')->default('submitted'); // submitted, ppl_review, kcl_review, pk_review, approved, rejected
            $table->text('pk_remarks')->nullable();
            $table->boolean('is_approved_by_pk')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kvp08_applications');
    }
};
