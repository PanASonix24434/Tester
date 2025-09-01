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
        Schema::create('kru_application_krus', function (Blueprint $table) {
            
			$table->uuid('id')->primary();
            //reference main
			$table->uuid('kru_application_id');
			$table->foreign('kru_application_id')->references('id')->on('kru_applications');

            //maklumat permohonan
            $table->string('ic_number', 12);
            $table->string('name');
            $table->uuid('bumiputera_status_id')->nullable();
            $table->foreign('bumiputera_status_id')->references('id')->on('code_masters');
            $table->uuid('kewarganegaraan_status_id')->nullable();
            $table->foreign('kewarganegaraan_status_id')->references('id')->on('code_masters');

			$table->string('address1')->nullable();
			$table->string('address2')->nullable();
			$table->string('address3')->nullable();
			$table->string('postcode', 5)->nullable();
			$table->string('city')->nullable();
			$table->uuid('district_id')->nullable();
			$table->uuid('state_id')->nullable();
			$table->uuid('parliament_id')->nullable();
            $table->foreign('parliament_id')->references('id')->on('parliaments');//update
			$table->uuid('parliament_seat_id')->nullable();
            $table->foreign('parliament_seat_id')->references('id')->on('parliament_seats');//update

            $table->string('home_contact_number')->nullable();
			$table->string('mobile_contact_number')->nullable();
			$table->string('email')->nullable();

			$table->string('health_declaration')->nullable(); //untuk kegunaan pembaharuan (KRU02)
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
        Schema::dropIfExists('kru_application_krus');
    }
};
