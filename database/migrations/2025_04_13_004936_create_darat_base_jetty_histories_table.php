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
        Schema::create('darat_base_jetty_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('jetty_id');

            $table->string('jetty_name')->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('river')->nullable();

            $table->boolean('is_active')->default(true)->nullable();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('jetty_id')->references('id')->on('darat_base_jetties')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('darat_base_jetty_histories');
    }
};
