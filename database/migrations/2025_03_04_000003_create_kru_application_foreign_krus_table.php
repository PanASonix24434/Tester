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
        //for kru02 & kru03 sebab boleh pilih banyak kru dalam satu permohonan
        Schema::create('kru_application_foreign_krus', function (Blueprint $table) {
            
			$table->uuid('id')->primary();
            //reference main
			$table->uuid('kru_application_id');
			$table->foreign('kru_application_id')->references('id')->on('kru_applications');

            //maklumat permohonan
            $table->string('name');

            $table->string('passport_number');
			$table->date('passport_end_date')->nullable();
			$table->date('birth_date')->nullable();
            $table->uuid('gender_id')->nullable();
            $table->foreign('gender_id')->references('id')->on('code_masters');
            $table->uuid('source_country_id')->nullable();
            $table->foreign('source_country_id')->references('id')->on('code_masters');
            $table->uuid('foreign_kru_position_id')->nullable();
			$table->foreign('foreign_kru_position_id')->references('id')->on('code_masters');
			$table->string('crew_whereabout')->nullable();
            //kru06
			$table->boolean('has_plks')->nullable();//pas lawatan kerja sementara
            $table->string('plks_number')->nullable();
			$table->date('plks_end_date')->nullable();
			$table->boolean('selected_for_approval')->nullable(); // untuk kegunaan ketika keputusan

            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->uuid('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->uuid('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kru_application_foreign_krus');
    }
};
