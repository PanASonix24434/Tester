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
        Schema::create('subsistence_list_quota', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->date('generated_date');
            $table->integer('total_applicants');
            $table->integer('quota');
            $table->enum('status', ['Dijana', 'Dicetak', 'Dihantar', 'Selesai'])->default('Dijana');
            $table->uuid('entities_id')->nullable();
            $table->foreign('entities_id')->references('id')->on('entities')->after('status'); 

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subsistence_list_quota');
    }
};
