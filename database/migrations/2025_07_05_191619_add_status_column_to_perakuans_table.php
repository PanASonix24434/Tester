<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusColumnToPerakuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perakuans', function (Blueprint $table) {
            // Add the 'status' column to the 'perakuans' table
            if (!Schema::hasColumn('perakuans', 'status')) {
                $table->string('status')->nullable(); // Or set a default value if needed
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('perakuans', function (Blueprint $table) {
            // Drop the 'status' column if rolling back the migration
            if (Schema::hasColumn('perakuans', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
}
