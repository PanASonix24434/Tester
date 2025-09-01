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
        Schema::create('profile_companies', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->string('company_name');
            $table->string('company_reg_no')->nullable();
            $table->date('company_reg_date')->nullable();
            $table->string('lhdn_account_no')->nullable();
            $table->string('current_address1');
			$table->string('current_address2')->nullable();
			$table->string('current_address3')->nullable();
			$table->string('current_postcode');
			$table->string('current_district');
			$table->uuid('current_state_id');
            $table->string('letter_address1');
			$table->string('letter_address2')->nullable();
			$table->string('letter_address3')->nullable();
			$table->string('letter_postcode');
			$table->string('letter_district');
			$table->uuid('letter_state_id');
            $table->string('phone_no');
            $table->string('fax_no')->nullable();
            $table->string('email')->nullable();
            $table->string('comp_sec')->nullable();
            $table->string('ownership')->nullable();
            $table->integer('bumiputera_status')->nullable();
            $table->uuid('company_status')->nullable();
            $table->double('modal_allow')->nullable();
            $table->double('modal_paid')->nullable();
            $table->string('company_business');
            $table->string('company_exp_fish')->nullable();
            $table->string('company_exp_other')->nullable();
            $table->uuid('user_id');

            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_companies');
    }
};
