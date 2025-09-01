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
        Schema::create('darat_applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
        
            $table->uuid('user_id')->nullable();
            $table->uuid('application_type_id')->nullable();
            $table->uuid('application_status_id')->nullable();
        
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
        
            $table->date('inspection_date')->nullable();
            $table->string('no_rujukan', 20)->unique()->nullable();
        
            $table->boolean('is_appeal')->default(false);
            $table->tinyInteger('is_approved')->default(0);
            $table->tinyInteger('is_active')->default(1);
        
            $table->softDeletes();
            $table->timestamps();
        
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('application_type_id')->references('id')->on('code_masters')->onDelete('cascade');
            $table->foreign('application_status_id')->references('id')->on('code_masters')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('set null');
        });
              
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('darat_applications');
    }
};
