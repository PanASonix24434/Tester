<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->uuid('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('modules');
            $table->string('name');
            $table->string('name_eng')->nullable();
            $table->string('slug');
            $table->string('url')->nullable();
            $table->string('icon', 50)->nullable();
            $table->integer('order');
            $table->boolean('is_active');
            $table->boolean('is_menu');
            $table->boolean('is_parent_menu');
            $table->uuid('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}