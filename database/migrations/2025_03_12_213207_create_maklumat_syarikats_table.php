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
        Schema::create('maklumat_syarikats', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');


            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('company_name');
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->text('address3')->nullable();
            $table->integer('poskod')->nullable();
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            $table->string('ownership')->nullable();
            $table->integer('bumiputera_status')->nullable();
            $table->string('no_phone')->nullable();
            $table->string('no_phone_office')->nullable();
            $table->string('no_fax')->nullable();
            $table->string('email')->nullable();
            $table->uuid('company_status')->nullable();

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
        Schema::dropIfExists('maklumat_syarikats');
    }
};
