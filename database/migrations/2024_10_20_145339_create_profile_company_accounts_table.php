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
        Schema::create('profile_company_accounts', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->uuid('company_profile_id');
            $table->string('account_year');
            $table->string('title')->nullable();
			$table->string('file_path')->nullable();
            $table->string('filename')->nullable();
			$table->boolean('is_deleted');

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
        Schema::dropIfExists('profile_company_accounts');
    }
};
