<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEntityToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if column 'entity_id' doesn't exist before adding it
            if (!Schema::hasColumn('users', 'entity_id')) {
                $table->uuid('entity_id')->nullable();
                $table->foreign('entity_id')->references('id')->on('entities');
            }

            // Check if column 'position_id' doesn't exist before adding it
            if (!Schema::hasColumn('users', 'position_id')) {
                $table->uuid('position_id')->nullable();
                $table->foreign('position_id')->references('id')->on('code_masters');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['entity_id']);
            $table->dropColumn('entity_id');
            $table->dropForeign(['position_id']);
            $table->dropColumn('position_id');
        });
    }
}
