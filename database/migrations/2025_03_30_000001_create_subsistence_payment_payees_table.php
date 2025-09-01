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
        Schema::create('subsistence_payment_payees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('subsistence_payment_id')->nullable();
            $table->foreign('subsistence_payment_id')->references('id')->on('subsistence_payments');
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->enum('decision_district', ['Sokong', 'Tidak Sokong'])->nullable();

            //status for monthly landing
            $table->boolean('has_landing')->default(false); // does the user have landing for the month
            $table->uuid('landing_monthly_id')->nullable(); //which landing it is referenced if any
            $table->foreign('landing_monthly_id')->references('id')->on('landing_declaration_monthlies');
            $table->boolean('in_process')->default(false); // does the landing in in used for other payment application?
            $table->boolean('have_paid')->default(false); // does the landing have been payed?

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
        Schema::dropIfExists('subsistence_payment_payees');
    }
};
