<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('darat_user_details', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('user_id')->nullable();
        $table->string('name')->nullable();
        $table->string('phone_number')->nullable();
        $table->string('identity_card_number');
        $table->string('fishing_transport_type')->nullable();
        $table->string('address')->nullable();
        $table->string('postcode')->nullable();
        $table->string('district')->nullable();
        $table->string('state')->nullable();
        $table->timestamps();
        $table->uuid('created_by')->nullable();
        $table->uuid('updated_by')->nullable();
        $table->uuid('deleted_by')->nullable();
        $table->boolean('is_active')->default(true);
        $table->softDeletes();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('darat_user_details');
    }
};
