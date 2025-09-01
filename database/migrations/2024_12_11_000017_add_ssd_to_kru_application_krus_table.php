<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kru_application_krus', function (Blueprint $table) {
            $table->string('ssd_number',10)->unique()->nullable();//ssd current application
            $table->string('previous_ssd_number',10)->nullable();//ssd previous application
            $table->boolean('has_sucessfully_printed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kru_application_krus', function (Blueprint $table) {
            $table->dropColumn('ssd_number');
            $table->dropColumn('previous_ssd_number');
            $table->dropColumn('has_sucessfully_printed');
        });
    }
};
