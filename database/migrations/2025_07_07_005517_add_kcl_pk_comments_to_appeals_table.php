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
        Schema::table('appeals', function (Blueprint $table) {
            $table->text('kcl_comments')->nullable();
            $table->text('pk_comments')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('appeals', function (Blueprint $table) {
            $table->dropColumn('kcl_comments');
            $table->dropColumn('pk_comments');
        });
    }
};
