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
        Schema::create('nelayan_marins', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->string('ic_number', 12)->unique();
            $table->string('name');
            $table->uuid('vessel_id')->nullable();
			$table->foreign('vessel_id')->references('id')->on('vessels');

			$table->string('address1')->nullable();
			$table->string('address2')->nullable();
			$table->string('address3')->nullable();
			$table->string('postcode', 5)->nullable();
			$table->string('city')->nullable();
			$table->uuid('district_id')->nullable();
			$table->uuid('state_id')->nullable();
			$table->uuid('parliament_id')->nullable();
            $table->foreign('parliament_id')->references('id')->on('parliaments');//update
			$table->uuid('parliament_seat_id')->nullable();
            $table->foreign('parliament_seat_id')->references('id')->on('parliament_seats');//update

            $table->string('home_contact_number')->nullable();
			$table->string('mobile_contact_number')->nullable();
			$table->string('email')->nullable();
            
			$table->string('registration_number')->unique()->nullable();
			$table->date('registration_start')->nullable();
			$table->date('registration_end')->nullable();

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
        Schema::dropIfExists('nelayan_marins');
    }
};
