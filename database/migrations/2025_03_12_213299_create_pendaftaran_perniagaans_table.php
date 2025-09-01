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
        Schema::create('pendaftaran_perniagaans', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');


            $table->uuid('company_id');
            $table->foreign('company_id')->references('id')->on('maklumat_syarikats')->onDelete('cascade');
            $table->string('company_reg_no')->nullable();
            $table->date('company_reg_date')->nullable();
            $table->date('company_exp_date')->nullable();
            $table->boolean('business_status');

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
        Schema::dropIfExists('pendaftaran_perniagaans');
    }
};
