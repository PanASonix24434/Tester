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
            $table->string('semakan_status')->nullable()->after('status');
            $table->text('semakan_ulasan')->nullable()->after('semakan_status');
            $table->string('sokongan_status')->nullable()->after('semakan_ulasan');
            $table->text('sokongan_ulasan')->nullable()->after('sokongan_status');
            $table->string('keputusan_status')->nullable()->after('sokongan_ulasan');
            $table->text('keputusan_ulasan')->nullable()->after('keputusan_status');
            $table->string('keputusan_rujukan')->nullable()->after('keputusan_ulasan');
            $table->string('keputusan_surat_path')->nullable()->after('keputusan_rujukan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perakuans', function (Blueprint $table) {
            $table->dropColumn([
                'semakan_status',
                'semakan_ulasan',
                'sokongan_status',
                'sokongan_ulasan',
                'keputusan_status',
                'keputusan_ulasan',
                'keputusan_rujukan',
                'keputusan_surat_path',
            ]);
        });
    }
};
