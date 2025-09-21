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
        Schema::table('permit_reminders', function (Blueprint $table) {
            $table->string('reminder_type')->default('extension_reminder')->after('user_id');
            $table->date('reminder_date')->after('reminder_type');
            $table->date('sent_date')->nullable()->after('reminder_date');
            $table->boolean('is_sent')->default(false)->after('sent_date');
            $table->text('email_content')->nullable()->after('is_sent');
            $table->string('email_status')->nullable()->after('email_content');
            $table->text('email_error')->nullable()->after('email_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permit_reminders', function (Blueprint $table) {
            $table->dropColumn([
                'reminder_type',
                'reminder_date', 
                'sent_date',
                'is_sent',
                'email_content',
                'email_status',
                'email_error'
            ]);
        });
    }
};
