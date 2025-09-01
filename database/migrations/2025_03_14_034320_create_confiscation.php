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
        Schema::create('confiscation', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('subsistence_id')->references('id')->on('subsistence_application');
            $table->string('fullname')->nullable();
            $table->string('icno')->nullable();
            $table->string('lucut_hak')->nullable(); //FAD
            $table->uuid('confiscation_reason_id')->nullable();
			$table->foreign('confiscation_reason_id')->references('id')->on('code_masters');
            $table->string('remark_lucut')->nullable();
            $table->uuid('update_by')->nullable(); 
            $table->foreign('update_by')->references('id')->on('users'); 

            $table->string('support_lucut')->nullable(); //KDP
            $table->string('remark_support')->nullable();
            $table->uuid('support_by')->nullable(); 
            $table->foreign('support_by')->references('id')->on('users'); 

            $table->string('approve_lucut')->nullable(); //FAN
            $table->string('remark_approve')->nullable();
            $table->uuid('approve_by')->nullable(); 
            $table->foreign('approve_by')->references('id')->on('users'); 
            
            $table->string('status')->nullable();

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
        Schema::dropIfExists('confiscation');
    }
};
