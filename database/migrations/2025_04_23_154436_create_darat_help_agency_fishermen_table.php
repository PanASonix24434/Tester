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
        Schema::create('darat_help_agency_fishermans', function (Blueprint $table) {
            $table->char('id', 36)->primary();

            $table->char('fisherman_info_id', 36)->nullable();
            $table->string('agency_name')->nullable();

            $table->char('created_by', 36)->nullable();
            $table->char('updated_by', 36)->nullable();
            $table->char('deleted_by', 36)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('fisherman_info_id')
                  ->references('id')->on('darat_user_fisherman_infos')
                  ->onDelete('set null');

            $table->foreign('created_by')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            $table->foreign('updated_by')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            $table->foreign('deleted_by')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('darat_help_agency_fishermans');
    }
};
