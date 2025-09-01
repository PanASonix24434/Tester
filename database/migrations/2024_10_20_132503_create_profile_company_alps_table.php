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
        Schema::create('profile_company_alps', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->uuid('company_profile_id');
            $table->string('alp_name');
            $table->string('alp_icno');
            $table->string('alp_email')->nullable();
            $table->string('alp_phone_no');
            $table->string('alp_position');
            $table->integer('alp_citizenship');
            $table->integer('alp_status');

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
        Schema::dropIfExists('profile_company_alps');
    }
};
