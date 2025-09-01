<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('profile_users', function (Blueprint $table) {
            $table->timestamp('verified_at')->nullable();
            $table->boolean('verify_status')->nullable();
            $table->string('ulasan')->nullable();
        });
    }

    public function down()
    {
        Schema::table('profile_users', function (Blueprint $table) {
            $table->dropColumn('verified_at');
            $table->dropColumn('verify_status');
            $table->dropColumn('ulasan');
        });
    }
};
