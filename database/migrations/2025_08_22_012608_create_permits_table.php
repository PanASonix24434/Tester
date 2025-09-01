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
        Schema::create('permits', function (Blueprint $table) {
            $table->id();
            $table->string('permit_number')->unique();
            $table->string('permit_type'); // C2, C3, MPPI, SKL, etc.
            $table->string('zone'); // C3, other zones
            $table->string('status')->default('active'); // active, expired, cancelled
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->boolean('has_progress')->default(false);
            $table->integer('application_count')->default(0); // Count of KPV-08 applications
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permits');
    }
};
