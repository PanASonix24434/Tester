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
        Schema::create('applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('application_type_id');
            $table->foreign('application_type_id')->references('id')->on('code_masters');
            $table->string('full_name');
            $table->string('ic_no');
            $table->date('date_of_birth');
            $table->uuid('type_of_gender_id')->nullable();
            $table->foreign('type_of_gender_id')->references('id')->on('code_masters');
            $table->uuid('bumiputera_status')->nullable();
            $table->foreign('bumiputera_status')->references('id')->on('code_masters');
            $table->string('age');
            $table->uuid('type_of_race_id')->nullable();
            $table->foreign('type_of_race_id')->references('id')->on('code_masters');
            $table->uuid('marital_status_id')->nullable();
            $table->foreign('marital_status_id')->references('id')->on('code_masters');
            $table->string('no_of_children')->nullable();
            $table->string('mail_address1')->nullable();
            $table->string('mail_address2')->nullable();
            $table->string('mail_address3')->nullable();
            $table->string('mail_postcode',6)->nullable();
            $table->string('mail_city')->nullable();
            $table->uuid('mail_state_id')->nullable();
            $table->foreign('mail_state_id')->references('id')->on('code_masters');
            $table->string('home_address1')->nullable();
            $table->string('home_address2')->nullable();
            $table->string('home_address3')->nullable();
            $table->string('home_postcode',6)->nullable();
            $table->string('home_city')->nullable();
            $table->uuid('home_state_id')->nullable();
            $table->foreign('home_state_id')->references('id')->on('code_masters');
            $table->string('phone_no')->nullable();
            $table->string('mobile_phone_no')->nullable();
            $table->string('email')->nullable();
            $table->uuid('type_of_residence_id')->nullable();
            $table->foreign('type_of_residence_id')->references('id')->on('code_masters');
            $table->uuid('dun_id')->nullable();
            $table->foreign('dun_id')->references('id')->on('code_masters');
            $table->uuid('parlimen_id')->nullable();
            $table->foreign('parlimen_id')->references('id')->on('code_masters');
            $table->decimal('application_amount',8,2)->nullable();
            $table->string('application_loan_period')->nullable();
            $table->uuid('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('code_masters');
            $table->string('bank_account_no')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
