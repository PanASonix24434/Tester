<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAppealIdToPerakuansTable extends Migration
{
    public function up()
    {
        Schema::table('perakuans', function (Blueprint $table) {
            $table->uuid('appeal_id')->nullable()->after('user_id');
            $table->foreign('appeal_id')->references('id')->on('appeals')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('perakuans', function (Blueprint $table) {
            $table->dropForeign(['appeal_id']);
            $table->dropColumn('appeal_id');
        });
    }
}
