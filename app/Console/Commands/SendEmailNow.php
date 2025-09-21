<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Permit;
use App\Models\PermitReminder;
use App\Notifications\PermitExtensionReminder;

class SendEmailNow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email-now';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder email immediately';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info("📧 Sending reminder email...");
        
        $user = User::first();
        $permit = Permit::first();
        $reminder = PermitReminder::where('is_sent', false)->first();
        
        if (!$user || !$permit || !$reminder) {
            $this->error("Missing data: User, Permit, or Reminder not found");
            return;
        }
        
        try {
            $user->notify(new PermitExtensionReminder($permit, $reminder));
            $reminder->markAsSent('sent');
            
            $this->info("✅ Email sent successfully to: {$user->email}");
            $this->info("📧 Check your inbox at fadzly0222@gmail.com!");
            
        } catch (\Exception $e) {
            $reminder->markAsFailed($e->getMessage());
            $this->error("❌ Failed to send email: " . $e->getMessage());
        }
    }
}
