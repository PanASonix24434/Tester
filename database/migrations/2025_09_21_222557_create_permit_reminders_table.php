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
        Schema::create('permit_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permit_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('reminder_type')->default('extension_reminder'); // extension_reminder, expiry_warning
            $table->date('reminder_date'); // Tarikh reminder perlu dihantar
            $table->date('sent_date')->nullable(); // Tarikh reminder dihantar
            $table->boolean('is_sent')->default(false);
            $table->text('email_content')->nullable();
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
