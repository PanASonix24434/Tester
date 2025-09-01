<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('perakuans', function (Blueprint $table) {
            if (!Schema::hasColumn('perakuans', 'appeal_id')) {
                $table->uuid('appeal_id')->nullable()->after('user_id');

                // Tambah foreign key constraint
                $table->foreign('appeal_id', 'perakuans_appeal_id_foreign')
                    ->references('id')
                    ->on('appeals')
                    ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perakuans', function (Blueprint $table) {
            // Check foreign key constraint exists before dropping
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = 'perakuans' 
                AND COLUMN_NAME = 'appeal_id' 
                AND CONSTRAINT_SCHEMA = DATABASE()
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ");

            foreach ($foreignKeys as $fk) {
                $table->dropForeign($fk->CONSTRAINT_NAME);
            }

            if (Schema::hasColumn('perakuans', 'appeal_id')) {
                $table->dropColumn('appeal_id');
            }
        });
    }
};
