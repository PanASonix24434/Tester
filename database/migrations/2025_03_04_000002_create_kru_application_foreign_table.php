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
        Schema::create('kru_application_foreigns', function (Blueprint $table) {
			$table->uuid('id')->primary();
            //reference main
			$table->uuid('kru_application_id');
			$table->foreign('kru_application_id')->references('id')->on('kru_applications');

            //kru06
			$table->string('approval_type')->nullable();
			$table->date('plks_end_date')->nullable();
			$table->uuid('permission_application_id')->nullable();
			$table->foreign('permission_application_id')->references('id')->on('kru_applications');
			$table->string('supervised')->nullable();
			$table->string('crew_placement')->nullable();
            
            //maklumat permohonan
			$table->uuid('immigration_office_id')->nullable();
			$table->foreign('immigration_office_id')->references('id')->on('immigration_offices');
			$table->uuid('immigration_gate_id')->nullable();
			$table->foreign('immigration_gate_id')->references('id')->on('code_masters');
			$table->date('immigration_date')->nullable();
            
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
        Schema::dropIfExists('kru_application_foreigns');
    }
};
