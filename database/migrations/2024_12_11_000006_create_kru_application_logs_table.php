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
        Schema::create('kru_application_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kru_application_id');
			$table->foreign('kru_application_id')->references('id')->on('kru_applications');
            $table->uuid('kru_application_status_id')->nullable();
			$table->foreign('kru_application_status_id')->references('id')->on('code_masters');
            $table->boolean('completed')->nullable();
            $table->boolean('checked')->nullable();
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
        Schema::dropIfExists('kru_application_logs');
    }
};
