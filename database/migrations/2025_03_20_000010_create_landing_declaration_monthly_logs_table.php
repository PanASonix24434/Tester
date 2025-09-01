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
        Schema::create('landing_declare_monthly_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('landing_declare_monthly_id');
			$table->foreign('landing_declare_monthly_id')->references('id')->on('landing_declaration_monthlies');
            $table->uuid('landing_status_id')->nullable();
			$table->foreign('landing_status_id')->references('id')->on('code_masters');
            $table->boolean('completed')->nullable();
            $table->boolean('supported')->nullable();
            $table->boolean('approved')->nullable();
            $table->boolean('is_editing')->default(false);
            $table->text('remark')->nullable();
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->uuid('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->uuid('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_declare_monthly_logs');
    }
};
