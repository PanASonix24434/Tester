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
        Schema::create('darat_user_equipment_histories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('equipment_id');
            $table->uuid('equipment_set_id')->nullable();

            $table->string('name')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('type')->nullable();

            $table->boolean('is_active')->default(true)->nullable();

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('equipment_id')->references('id')->on('darat_user_equipments')->onDelete('cascade');
            $table->foreign('equipment_set_id')->references('id')->on('darat_equipment_sets')->onDelete('set null');
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
        Schema::dropIfExists('darat_user_equipment_histories');
    }
};
