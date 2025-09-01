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
        Schema::create('licensing_quotas', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('sub_category')->nullable();
            $table->integer('year');
            $table->integer('fma_01')->nullable();
            $table->integer('fma_02')->nullable();
            $table->integer('fma_03')->nullable();
            $table->integer('fma_04')->nullable();
            $table->integer('fma_05')->nullable();
            $table->integer('fma_06')->nullable();
            $table->integer('fma_07')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
            
            $table->unique(['category', 'sub_category', 'year']);
            $table->index(['year', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licensing_quotas');
    }
};
