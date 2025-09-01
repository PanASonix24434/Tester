<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('status_stocks', function (Blueprint $table) {
            if (!Schema::hasColumn('status_stocks', 'tahun')) {
                $table->string('tahun')->nullable()->after('id');
            }
            if (!Schema::hasColumn('status_stocks', 'dokumen_kelulusan_kpp')) {
                $table->string('dokumen_kelulusan_kpp')->nullable()->after('tahun');
            }
        });
    }

    public function down(): void
    {
        Schema::table('status_stocks', function (Blueprint $table) {
            if (Schema::hasColumn('status_stocks', 'tahun')) {
                $table->dropColumn('tahun');
            }
            if (Schema::hasColumn('status_stocks', 'dokumen_kelulusan_kpp')) {
                $table->dropColumn('dokumen_kelulusan_kpp');
            }
        });
    }
}; 