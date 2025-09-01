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
        Schema::create('subsistence_application', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            
            $table->string('registration_no')->nullable();
            $table->string('type_registration')->default('Baru') ;// Baru Or  Rayuan 
			$table->uuid('user_id');// applicant
			$table->foreign('user_id')->references('id')->on('users');
            $table->string('fullname');
            $table->string('icno');

            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('address3')->nullable();
			$table->string('postcode', 5)->nullable();
			$table->string('city')->nullable();
			$table->uuid('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('code_masters');//update
			$table->uuid('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('code_masters');//update
            
            $table->string('contact_number')->nullable();

            $table->uuid('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('code_masters');
            $table->uuid('state_bank_id')->nullable();
            $table->foreign('state_bank_id')->references('id')->on('code_masters');
            $table->string('no_account');

            $table->uuid('fisherman_type_id')->nullable();
            $table->foreign('fisherman_type_id')->references('id')->on('code_masters');
            $table->integer('year_become_fisherman')->nullable();
            $table->integer('becoming_fisherman_duration')->nullable();
            $table->unsignedTinyInteger('working_days_fishing_per_month')->nullable();
            $table->float('tot_incomefish', 8, 2)->nullable();
            $table->float('tot_incomeother', 8, 2)->nullable();
            $table->float('tot_allincome', 8, 2)->nullable();

            $table->integer('tot_child')->nullable();
            $table->integer('tot_otherchild')->nullable();
            $table->integer('tot_allchild')->nullable();

            $table->boolean('is_primary')->nullable();
            $table->boolean('is_secondary')->nullable();
            $table->boolean('is_uni')->nullable();
            $table->boolean('is_notschool')->nullable();

            $table->integer('declaration')->nullable();
            $table->string('sub_application_status')->default('Permohonan Disimpan');
            $table->uuid('batch_id')->nullable(); // id from table subsistence_list_quota
            $table->enum('status_quota', ['menunggu', 'senarai_menunggu', 'layak diluluskan', 'layak tidak diluluskan', 'ditolak'])->default('menunggu'); // - layak tidak diluluskan (kerana quota tidak ckup)
            $table->enum('status_hq', ['belum disemak', 'diluluskan', 'layak tidak diluluskan' ,'ditolak'])->default('Belum disemak');
            $table->uuid('entity_id')->nullable();
            $table->foreign('entity_id')->references('id')->on('entities');
            $table->datetime('submitted_at')->nullable(); // date applicant send the application
            
            $table->boolean('is_approved_jkk')->nullable();

            $table->datetime('application_approved_date')->nullable();
            $table->datetime('application_expired_date')->nullable();

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
        Schema::dropIfExists('subsistence_application');
    }
};
