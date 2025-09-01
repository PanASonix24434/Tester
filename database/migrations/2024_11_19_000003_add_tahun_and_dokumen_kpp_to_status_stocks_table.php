<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('status_stocks', function (Blueprint $table) {
            $table->string('tahun')->nullable()->after('id');
            $table->string('dokumen_kelulusan_kpp')->nullable()->after('tahun');
        });
    }

    public function down(): void
    {
        Schema::table('status_stocks', function (Blueprint $table) {
            $table->dropColumn(['tahun', 'dokumen_kelulusan_kpp']);
        });
    }
}; 