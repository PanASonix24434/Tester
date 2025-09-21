<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Permit;
use App\Models\User;
use App\Models\PermitReminder;
use App\Notifications\PermitExtensionReminder;
use Carbon\Carbon;

class SendTestReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:send-reminder-email {email=fadzly0222@gmail.com}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send test reminder email to specified email address';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = $this->argument('email');
        
        $this->info("🧪 Creating test reminder email for: {$email}");
        
        // Get or create test permit
        $permit = Permit::first();
        if (!$permit) {
            $this->error('No permit found. Please create a permit first.');
            return;
        }
        
        // Update permit with test data
        $permit->update([
            'last_extension_date' => Carbon::now()->subMonths(3),
            'application_count' => 1,
            'expiry_date' => Carbon::now()->addMonths(3),
            'no_permit' => 'TEST-PERMIT-001',
            'jenis_peralatan' => 'Pukat Tunda',
        ]);
        
        // Get or create test user
        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => $email,
                'password' => bcrypt('password'),
                'company_profile_id' => 1, // Assuming company profile exists
            ]);
            $this->info("✅ Created test user: {$email}");
        }
        
        // Create test reminder
        $reminder = PermitReminder::create([
            'permit_id' => $permit->id,
            'user_id' => $user->id,
            'reminder_type' => 'extension_reminder',
            'reminder_date' => Carbon::now()->subDays(1),
            'is_sent' => false,
        ]);
        
        $this->info("✅ Created test reminder ID: {$reminder->id}");
        
        // Send email notification
        try {
            $user->notify(new PermitExtensionReminder($permit, $reminder));
            $reminder->markAsSent('sent');
            
            $this->info("✅ Test reminder email sent successfully to: {$email}");
            $this->info("📧 Check your email inbox for the reminder!");
            
        } catch (\Exception $e) {
            $reminder->markAsFailed($e->getMessage());
            $this->error("❌ Failed to send test email: " . $e->getMessage());
            $this->error("💡 Make sure email configuration is correct in .env file");
        }
        
        $this->info("");
        $this->info("📊 Test Summary:");
        $this->info("- Permit: {$permit->no_permit}");
        $this->info("- User: {$user->email}");
        $this->info("- Reminder ID: {$reminder->id}");
        $this->info("- Status: " . ($reminder->is_sent ? '✅ Sent' : '❌ Failed'));
    }
}
