<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVesselProfileTabs extends Migration
{
    public function up()
    {
        // Jadual Kapal
        Schema::create('am_vessel', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran_kapal');
            $table->string('no_tetap')->nullable();
            $table->string('no_patil_kekal')->nullable();
            $table->date('tarikh_daftar');
            $table->string('indikator_kapal');
            $table->string('bahan_api');
            $table->string('status_usaha_kapal')->nullable();
            $table->string('tempasal_kapal');
            $table->string('negara')->nullable();
            $table->boolean('kebenaran_memancing');
            $table->boolean('pemasangan_vtu');
            $table->string('kod_rfid')->nullable();
            $table->string('kod_qr')->nullable();
            $table->string('hak_milik');
            $table->boolean('status_iuu');
            $table->string('pangkalan_utama');
            $table->string('pangkalan_tambahan')->nullable();
            $table->foreign('no_pendaftaran_kapal')->references('vessel_no')->on('vessels')->onDelete('cascade');
            $table->timestamps();
        });

        // Jadual Lesen
        Schema::create('lesen', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran_kapal');
            $table->string('no_lesen');
            $table->date('tarikh_keluar');
            $table->date('tarikh_tamat');
            $table->string('kod_zon');
            $table->string('kawasan_perairan');
            $table->string('no_patil');
            $table->string('catatan')->nullable();
            $table->string('status_lesen');
            $table->foreign('no_pendaftaran_kapal')->references('vessel_no')->on('vessels')->onDelete('cascade');
            $table->timestamps();
        });

        // Jadual Kulit
        Schema::create('kulit', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_pendaftaran_kapal');
            $table->string('panjang');
            $table->string('lebar');
            $table->string('dalam');
            $table->string('jenis_kulit');
            $table->string('tarikh_kulit_dilesenkan');
            $table->string('status_kulit');
            $table->string('catatan')->nullable();
            $table->boolean('baru');
            $table->boolean('asal');
            $table->foreign('no_pendaftaran_kapal')->references('no_pendaftaran')->on('vessels')->onDelete('cascade');
            $table->timestamps();
        });

        // Jadual Enjin
        Schema::create('enjin', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran_kapal');
            $table->integer('jenis_enjin');
            $table->string('jenama');
            $table->integer('kuasa_kuda');
            $table->string('no_enjin');
            $table->string('model');
            $table->date('tarikh_enjin_dilesenkan');
            $table->string('kategori_enjin');
            $table->string('status_enjin');
            $table->boolean('has_turbo');
            $table->string('bahan_api');
            $table->string('gambar_enjin')->nullable();
            $table->string('gambar_no_enjin')->nullable();
            $table->string('gambar_pev')->nullable();
            $table->string('gambar_turbo')->nullable();
            $table->string('gambar_generator')->nullable();
            $table->foreign('no_pendaftaran_kapal')->references('no_pendaftaran')->on('vessels')->onDelete('cascade');
            $table->timestamps();
        });

        // Jadual Pemilikan
        Schema::create('pemilikan', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran_kapal');
            $table->string('nama_pemilik');
            $table->string('jenis_pemilikan');
            $table->string('negeri');
            $table->string('daerah');
            $table->date('tarikh_aktif_pemilikan');
            $table->string('status_pemilikan');
            $table->foreign('no_pendaftaran_kapal')->references('no_pendaftaran')->on('vessels')->onDelete('cascade');
            $table->timestamps();
        });

        // Jadual Kru 
        Schema::create('kru', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran_kapal');
            $table->string('nama_kru');
            $table->string('no_kp_baru')->nullable();
            $table->string('no_kp_lama')->nullable();
            $table->string('no_kad')->nullable();
            $table->string('jawatan');
            $table->date('tarikh_kemaskini_mykad')->nullable();
            $table->integer('status_kru');
            $table->string('no_sijil')->nullable();
            $table->string('no_plks')->nullable();
            $table->date('tarikh_tamat_plks')->nullable();
            $table->string('negara')->nullable();
            $table->integer('warganegara');
            $table->foreign('no_pendaftaran_kapal')->references('no_pendaftaran')->on('vessels')->onDelete('cascade');
            $table->timestamps();
        });

        // Jadual Kesalahan
        Schema::create('kesalahan', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran_kapal');
            $table->string('pesalah');
            $table->string('no_ic_pesalah');
            $table->string('akta');
            $table->string('seksyen');
            $table->string('kesalahan');
            $table->date('tarikh');
            $table->string('keputusan');
            $table->foreign('no_pendaftaran_kapal')->references('no_pendaftaran')->on('vessels')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kesalahan');
        Schema::dropIfExists('kru');
        Schema::dropIfExists('peralatan');
        Schema::dropIfExists('pemilikan');
        Schema::dropIfExists('enjin');
        Schema::dropIfExists('kulit');
        Schema::dropIfExists('lesen');
        Schema::dropIfExists('am_vessel');
    }
}
