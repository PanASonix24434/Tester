<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Permit;
use App\Models\PermitReminder;
use App\Models\User;
use App\Notifications\PermitExtensionReminder;
use Carbon\Carbon;

class CheckPermitReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permits:check-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and send permit extension reminders after 3 months';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Checking permit extension reminders...');
        
        // Get permits that were extended 3 months ago
        $threeMonthsAgo = Carbon::now()->subMonths(3);
        
        $permits = Permit::where('last_extension_date', '<=', $threeMonthsAgo)
            ->where('is_active', true)
            ->get();
        
        $reminderCount = 0;
        
        foreach ($permits as $permit) {
            // Check if reminder already sent
            $existingReminder = PermitReminder::where('permit_id', $permit->id)
                ->where('reminder_type', 'extension_reminder')
                ->where('is_sent', true)
                ->first();
            
            if ($existingReminder) {
                continue; // Skip if already sent
            }
            
            // Get user from company profile (simplified for testing)
            $user = User::first(); // Use first available user for testing
            
            if (!$user) {
                $this->warn("No user found for permit {$permit->no_permit}");
                continue;
            }
            
            // Create reminder record
            $reminder = PermitReminder::create([
                'permit_id' => $permit->id,
                'user_id' => $user->id,
                'reminder_type' => 'extension_reminder',
                'reminder_date' => now(),
                'is_sent' => false,
            ]);
            
            // Send email notification
            try {
                $user->notify(new PermitExtensionReminder($permit, $reminder));
                $reminder->markAsSent('sent');
                $reminderCount++;
                
                $this->info("✅ Reminder sent for permit {$permit->no_permit} to {$user->email}");
            } catch (\Exception $e) {
                $reminder->markAsFailed($e->getMessage());
                $this->error("❌ Failed to send reminder for permit {$permit->no_permit}: " . $e->getMessage());
            }
        }
        
        $this->info("Sent {$reminderCount} reminders successfully.");
    }
}
