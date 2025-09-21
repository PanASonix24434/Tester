<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Permit;
use App\Models\User;
use App\Models\PermitReminder;
use Carbon\Carbon;

class CreateTestReminderData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:create-reminder-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test data for email reminder testing';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Creating test reminder data...');
        
        // Get first permit and user for testing
        $permit = Permit::first();
        $user = User::first();
        
        if (!$permit || !$user) {
            $this->error('No permit or user found. Please create some test data first.');
            return;
        }
        
        // Update permit to have extension date 3 months ago
        $permit->update([
            'last_extension_date' => Carbon::now()->subMonths(3),
            'application_count' => 1,
            'expiry_date' => Carbon::now()->addMonths(3),
        ]);
        
        // Create test reminder
        $reminder = PermitReminder::create([
            'permit_id' => $permit->id,
            'user_id' => $user->id,
            'reminder_type' => 'extension_reminder',
            'reminder_date' => Carbon::now()->subDays(1), // Yesterday
            'is_sent' => false,
        ]);
        
        $this->info("Test data created:");
        $this->info("- Permit ID: {$permit->id}");
        $this->info("- User ID: {$user->id} ({$user->email})");
        $this->info("- Reminder ID: {$reminder->id}");
        $this->info("- Last Extension Date: {$permit->last_extension_date}");
        $this->info("");
        $this->info("Now run: php artisan permits:check-reminders");
    }
}
