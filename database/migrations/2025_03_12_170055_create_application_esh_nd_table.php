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
        Schema::create('application_esh_nd', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');

            // Bank Details
            $table->string('bank_name')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('bank_branch')->nullable();

            // Monthly Income
            $table->decimal('income_fishing', 10, 2)->default(0);
            $table->decimal('income_other', 10, 2)->default(0);

            // Dependent Details
            $table->integer('children_count')->default(0);
            $table->integer('other_dependents')->default(0);

            // Education Level
            $table->enum('education_level', ['none', 'primary', 'secondary', 'tertiary'])->default('none');

            // Agreement
            $table->boolean('agreement')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_esh_nd');
    }
};
