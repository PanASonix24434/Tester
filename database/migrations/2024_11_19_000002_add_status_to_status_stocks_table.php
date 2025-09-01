<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('status_stocks', function (Blueprint $table) {
            $table->string('status')->default('draft')->after('dokumen_senarai_stok');
        });
    }

    public function down(): void
    {
        Schema::table('status_stocks', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}; 