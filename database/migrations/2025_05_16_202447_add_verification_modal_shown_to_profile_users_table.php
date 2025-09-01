<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerificationModalShownToProfileUsersTable extends Migration
{
    public function up()
    {
        Schema::table('profile_users', function (Blueprint $table) {
            $table->boolean('verification_modal_shown')->default(false)->after('verify_status');
        });
    }

    public function down()
    {
        Schema::table('profile_users', function (Blueprint $table) {
            $table->dropColumn('verification_modal_shown');
        });
    }
}
