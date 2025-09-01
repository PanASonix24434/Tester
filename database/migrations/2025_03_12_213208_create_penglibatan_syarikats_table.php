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
        Schema::create('penglibatan_syarikats', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');


            $table->uuid('company_id');
            $table->foreign('company_id')->references('id')->on('maklumat_syarikats')->onDelete('cascade');
            $table->string('bil_vesel')->nullable();
            $table->string('jenis_industri')->nullable();
            $table->string('industri_lain')->nullable();
            

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
        Schema::dropIfExists('penglibatan_syarikats');
    }
};
