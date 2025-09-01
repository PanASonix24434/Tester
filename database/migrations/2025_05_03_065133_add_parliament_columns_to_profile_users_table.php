<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('profile_users', function (Blueprint $table) {
            // Guna 'after' hanya jika kolum 'state' memang wujud
            $table->uuid('parliament')->nullable()->after('state');
            $table->uuid('parliament_seat')->nullable()->after('parliament');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('profile_users', function (Blueprint $table) {
            $table->dropColumn(['parliament', 'parliament_seat']);
        });
    }
};
