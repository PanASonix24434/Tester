<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pendaftaran_antarabangsa', function (Blueprint $table) {
            $table->id();
            $table->uuid('vessel_id'); // Tukar ke UUID
            $table->string('no_pendaftaran_vesel')->unique();
            $table->string('no_ircs')->nullable();
            $table->string('no_rfmo')->nullable();
            $table->string('no_imo')->nullable();
            $table->string('kawasan_penangkapan');
            $table->string('spesis_sasaran');
            $table->timestamps();

            // Hubungkan dengan am_vessel yang menggunakan UUID
            $table->foreign('vessel_id')->references('id')->on('vessels')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftaran_antarabangsa');
    }
};
