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
        Schema::table('perakuans', function (Blueprint $table) {
            $table->string('dokumen_sokongan_path')->nullable()->after('dokumen_sokongan_bahan_binaan_path');
        });
    }
    
    public function down()
    {
        Schema::table('perakuans', function (Blueprint $table) {
            $table->dropColumn('dokumen_sokongan_path');
        });
    }
    
};
