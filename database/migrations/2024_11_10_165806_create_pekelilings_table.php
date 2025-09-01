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
        Schema::create('pekelilings', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->string('nama');
            $table->string('tajuk');
            $table->date('tarikh');
            $table->string('no_rujukan');
            $table->string('kandungan');
            $table->string('bil')->nullable();
            $table->string('file_title')->nullable();
			$table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->boolean('is_active');

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
        Schema::dropIfExists('pekelilings');
    }
};
