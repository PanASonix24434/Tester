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
        Schema::create('darat_user_fisherman_infos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('fisherman_type_id')->nullable();

            $table->integer('year_become_fisherman')->nullable();
            $table->integer('becoming_fisherman_duration')->nullable();
            $table->integer('working_days_fishing_per_month')->nullable();
            $table->decimal('estimated_income_yearly_fishing', 10, 2)->nullable();
            $table->decimal('estimated_income_other_job', 10, 2)->nullable();
            $table->integer('days_working_other_job_per_month')->nullable();
            $table->boolean('receive_pension')->nullable();
            $table->boolean('receive_financial_aid')->nullable();
            $table->string('financial_aid_agency')->nullable();
            $table->boolean('epf_contributor')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('fisherman_type_id')->references('id')->on('code_masters')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('darat_user_fisherman_infos');
    }
};
