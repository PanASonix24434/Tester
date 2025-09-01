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
        Schema::create('eshnd_quotas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('year')->nullable();
            $table->enum('phase', ['Separuh Pertama', 'Separuh Kedua'])->nullable();
            $table->integer('amount')->nullable();

            $table->uuid('entity_id')->nullable(); // entity with level 2 only - entity negeri
            $table->foreign('entity_id')->references('id')->on('entities'); 

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['year', 'phase', 'entity_id'], 'year_phase_entity_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eshnd_quotas');
    }
};
