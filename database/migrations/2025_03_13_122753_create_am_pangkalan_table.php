<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('am_pangkalan', function (Blueprint $table) {
            $table->id();
            $table->string('no_rujukan_permohonan')->nullable(); // Rujukan permohonan
            $table->string('nama_pangkalan');
            $table->enum('jenis_pangkalan', ['Utama', 'Tambahan']);
            $table->string('daerah');
            $table->string('negeri');
            $table->date('tarikh_mula_beroperasi')->nullable();
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('am_pangkalan');
    }
};
