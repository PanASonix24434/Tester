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
            $table->unsignedBigInteger('kelulusan_perolehan_id')->nullable()->after('jenis_pindaan_syarat');
            $table->json('selected_permits')->nullable()->after('kelulusan_perolehan_id');
            
            $table->foreign('kelulusan_perolehan_id')->references('id')->on('kelulusan_perolehan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perakuans', function (Blueprint $table) {
            $table->dropForeign(['kelulusan_perolehan_id']);
            $table->dropColumn(['kelulusan_perolehan_id', 'selected_permits']);
        });
    }
};
