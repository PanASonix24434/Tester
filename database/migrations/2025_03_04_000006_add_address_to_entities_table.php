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
        Schema::table('entities', function (Blueprint $table) {
			$table->string('address1')->nullable();
			$table->string('address2')->nullable();
			$table->string('address3')->nullable();
			$table->string('postcode', 5)->nullable();
			$table->string('city')->nullable();
			$table->uuid('district_id')->nullable();
            $table->foreign('district_id')->references('id')->on('code_masters');
			$table->uuid('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('code_masters');

            
			$table->string('fax_no')->nullable();
			$table->string('entity_phone_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->dropColumn('address1');
            $table->dropColumn('address2');
            $table->dropColumn('address3');
            $table->dropColumn('postcode');
            $table->dropColumn('city');
            $table->dropColumn('district_id');
            $table->dropColumn('state_id');
            
            $table->dropColumn('fax_no');
            $table->dropColumn('entity_phone_no');
        });
    }
};
