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
        Schema::table('perakuans', function (Blueprint $table) {
            $table->string('alamat_limbungan_luar_negara')->nullable();
            $table->string('negara_limbungan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perakuans', function (Blueprint $table) {
            $table->dropColumn('alamat_limbungan_luar_negara');
            $table->dropColumn('negara_limbungan');
        });
    }
};
