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
        Schema::dropIfExists('permit_reminders');
        
        Schema::create('permit_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permit_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('reminder_type')->default('extension_reminder');
            $table->date('reminder_date');
            $table->date('sent_date')->nullable();
            $table->boolean('is_sent')->default(false);
            $table->text('email_content')->nullable();
            $table->string('email_status')->nullable();
            $table->text('email_error')->nullable();
            $table->timestamps();
            
            $table->index(['reminder_date', 'is_sent']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permit_reminders');
    }
};
