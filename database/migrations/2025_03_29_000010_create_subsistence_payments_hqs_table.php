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
        Schema::create('subsistence_payment_hqs', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->date('generated_date');
            $table->enum('status', ['Dijana', 'Dicetak', 'Dihantar'])->default('Dijana');

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subsistence_payment_hqs');
    }
};
