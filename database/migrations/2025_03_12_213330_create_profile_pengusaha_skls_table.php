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
        Schema::create('profile_pengusaha_skls', function (Blueprint $table) {
            $table->uuid('id');
             $table->primary('id');
 
             $table->uuid('profile_id'); // Foreign key linking to profile_users table
             $table->foreign('profile_id')->references('id')->on('profile_users')->onDelete('cascade');
             $table->string('no_lesen_skl')->nullable(); 
             $table->string('jenis_sistem_kultur_laut')->nullable();
             $table->string('jenis_ternakan')->nullable();
             $table->date('tarikh_tamat_lesen')->nullable();
             $table->decimal('keluasan', 10, 2)->nullable();
             $table->string('salinan_lesen_skl')->nullable();
 
             
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
        Schema::dropIfExists('profile_pengusaha_skls');
    }
};
