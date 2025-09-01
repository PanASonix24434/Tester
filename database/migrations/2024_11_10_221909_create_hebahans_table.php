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
        Schema::create('hebahans', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->string('tajuk');
            $table->string('kandungan');
            $table->date('tarikh');
            $table->uuid('role_id')->nullable();
            $table->uuid('entity_id')->nullable();
            $table->integer('status');

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
        Schema::dropIfExists('hebahans');
    }
};
