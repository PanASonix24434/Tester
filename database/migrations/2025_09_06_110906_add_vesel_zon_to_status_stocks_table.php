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
        Schema::table('status_stocks', function (Blueprint $table) {
            $table->string('vesel_type', 50)->nullable()->after('fma');
            $table->string('zon_type', 10)->nullable()->after('vesel_type');
            $table->enum('selection_type', ['vesel', 'zon'])->nullable()->after('zon_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_stocks', function (Blueprint $table) {
            $table->dropColumn(['vesel_type', 'zon_type', 'selection_type']);
        });
    }
};
