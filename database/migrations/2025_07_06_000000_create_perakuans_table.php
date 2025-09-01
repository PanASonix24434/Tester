<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('perakuans', function (Blueprint $table) {
            $table->id();

            $table->uuid('user_id');
            $table->uuid('appeal_id')->nullable(); // ✅ add this line

            $table->boolean('perakuan')->default(0);
            $table->string('jenis_pindaan_syarat')->nullable();
            $table->string('jenis_bahan_binaan_vesel')->nullable();
            $table->string('nyatakan')->nullable();
            $table->string('jenis_perolehan')->nullable();
            $table->string('negeri_limbungan_baru')->nullable();
            $table->string('nama_limbungan_baru')->nullable();
            $table->string('daerah_baru')->nullable();
            $table->string('alamat_baru')->nullable();
            $table->string('poskod_baru')->nullable();
            $table->string('pernah_berdaftar')->nullable();
            $table->string('no_pendaftaran_vesel')->nullable();
            $table->string('negeri_asal_vesel')->nullable();
            $table->string('pelabuhan_pangkalan')->nullable();
            $table->string('pangkalan_asal')->nullable();
            $table->string('pangkalan_baru')->nullable();
            $table->string('justifikasi_pindaan')->nullable();
            $table->string('status')->default('draft');

            $table->string('surat_jual_beli_terpakai_path')->nullable();
            $table->string('lesen_skl_terpakai_path')->nullable();
            $table->string('dokumen_sokongan_terpakai_path')->nullable();
            $table->string('akuan_sumpah_bina_baru_path')->nullable();
            $table->string('lesen_skl_bina_baru_path')->nullable();
            $table->string('dokumen_sokongan_bina_baru_path')->nullable();
            $table->string('dokumen_sokongan_pangkalan_path')->nullable();
            $table->string('dokumen_sokongan_bahan_binaan_path')->nullable();
            $table->string('dokumen_sokongan_path')->nullable();
            
            $table->timestamps();

            $table->foreign('appeal_id')->references('id')->on('appeals')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('perakuans');
    }
};
