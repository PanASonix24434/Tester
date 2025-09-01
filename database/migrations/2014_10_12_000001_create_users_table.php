<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
			
            $table->string('name')->nullable();
            $table->string('username');
            $table->string('email');
            $table->string('peranan')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('is_active');
            $table->boolean('is_admin');
			$table->integer('user_type')->nullable();			
            $table->string('profile_picture')->nullable();
            $table->timestamp('last_online_at')->nullable();
			$table->integer('bumiputera_type')->nullable();
			$table->string('address1')->nullable();
			$table->string('address2')->nullable();
			$table->string('address3')->nullable();
			$table->string('postcode')->nullable();
			$table->string('district')->nullable();
			$table->uuid('state_id')->nullable();			
            $table->string('contact_number')->nullable();
			$table->string('mobile_contact_number')->nullable();
			
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}