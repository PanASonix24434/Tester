<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fish_type_id')->constrained('fish_types');
            $table->string('fma');
            $table->integer('bilangan_stok');
            $table->string('dokumen_senarai_stok')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_stocks');
    }
}; 