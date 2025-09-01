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
        Schema::create('subsistence_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('subsistence_payment_states_id')->nullable();
            $table->foreign('subsistence_payment_states_id')->references('id')->on('subsistence_payment_states');

            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->date('generated_date');
            $table->enum('status', ['Dijana', 'Dicetak', 'Dihantar','Disokong Daerah'])->default('Dijana');
            $table->uuid('entity_id')->nullable();
            $table->foreign('entity_id')->references('id')->on('entities'); 

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
        Schema::dropIfExists('subsistence_payments');
    }
};
