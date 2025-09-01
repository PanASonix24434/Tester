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
        Schema::table('complaints', function (Blueprint $table) {
            $table->date('close_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            // Check if the foreign key exists before attempting to drop it
            $foreignKeyExists = DB::select("SELECT CONSTRAINT_NAME 
                                           FROM information_schema.KEY_COLUMN_USAGE 
                                           WHERE TABLE_NAME = 'complaints' 
                                           AND CONSTRAINT_NAME = 'complaints_close_date_foreign'");

            // Drop the foreign key constraint if it exists
            if (!empty($foreignKeyExists)) {
                $table->dropForeign(['close_date']);
            }

            // Drop the column 'close_date'
            $table->dropColumn('close_date');
        });
    }
};
