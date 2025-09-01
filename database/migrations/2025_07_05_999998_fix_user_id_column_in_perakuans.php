<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Drop the user_id column completely
        Schema::table('perakuans', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        
        // Add it back as uuid
        Schema::table('perakuans', function (Blueprint $table) {
            $table->uuid('user_id')->after('id');
        });
    }

    public function down()
    {
        Schema::table('perakuans', function (Blueprint $table) {
            $table->dropColumn('user_id');
            $table->unsignedBigInteger('user_id')->after('id');
        });
    }
}; 