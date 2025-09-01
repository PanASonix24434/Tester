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
        Schema::table('subsistence_list_quota', function (Blueprint $table) {
            $table->integer('year')->nullable();
            $table->enum('phase', ['Separuh Pertama', 'Separuh Kedua'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subsistence_list_quota', function (Blueprint $table) {
            $table->dropColumn([
                'year',
                'phase',
            ]);
        });
    }
};
