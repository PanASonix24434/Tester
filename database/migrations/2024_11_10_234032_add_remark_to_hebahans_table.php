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
        Schema::table('hebahans', function (Blueprint $table) {
            // Add new columns
            $table->string('remark_reject')->nullable();
            $table->string('remark_approve')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hebahans', function (Blueprint $table) {
            // Check if the foreign key exists before dropping
            $foreignKeyExists = DB::select("SELECT CONSTRAINT_NAME 
                                           FROM information_schema.KEY_COLUMN_USAGE 
                                           WHERE TABLE_NAME = 'hebahans' 
                                           AND CONSTRAINT_NAME = 'hebahans_remark_reject_foreign'");

            // Drop foreign key if it exists
            if (!empty($foreignKeyExists)) {
                $table->dropForeign(['remark_reject']);
            }

            // Drop the columns
            $table->dropColumn('remark_reject');
            $table->dropColumn('remark_approve');
        });
    }
};
