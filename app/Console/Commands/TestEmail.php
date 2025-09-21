<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Permit;
use App\Models\PermitReminder;
use App\Notifications\PermitExtensionReminder;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {email=fadzly0222@gmail.com}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send test reminder email';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = $this->argument('email');
        
        $this->info("🧪 Sending test email to: {$email}");
        
        // Get or create user
        $user = User::where('email', $email)->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => $email,
                'username' => 'testuser',
                'password' => bcrypt('password'),
                'is_active' => 1,
                'is_admin' => 0,
            ]);
            $this->info("✅ Created test user: {$email}");
        }
        
        // Get or create permit
        $permit = Permit::first();
        if (!$permit) {
            $permit = Permit::create([
                'no_permit' => 'TEST-PERMIT-001',
                'kelulusan_perolehan_id' => 1,
                'jenis_peralatan' => 'Pukat Tunda',
                'status' => 'ada_kemajuan',
                'is_active' => 1,
                'application_count' => 1,
                'last_extension_date' => now()->subMonths(3),
                'expiry_date' => now()->addMonths(3),
            ]);
            $this->info("✅ Created test permit: TEST-PERMIT-001");
        } else {
            $permit->update([
                'no_permit' => 'TEST-PERMIT-001',
                'jenis_peralatan' => 'Pukat Tunda',
                'application_count' => 1,
                'last_extension_date' => now()->subMonths(3),
                'expiry_date' => now()->addMonths(3),
            ]);
        }
        
        // Create reminder
        $reminder = PermitReminder::create([
            'permit_id' => $permit->id,
            'user_id' => $user->id,
            'reminder_type' => 'extension_reminder',
            'reminder_date' => now()->subDays(1),
            'is_sent' => false,
        ]);
        
        // Send email
        try {
            $user->notify(new PermitExtensionReminder($permit, $reminder));
            $reminder->markAsSent('sent');
            
            $this->info("✅ Test email sent successfully to: {$email}");
            $this->info("📧 Check your email inbox!");
            
        } catch (\Exception $e) {
            $reminder->markAsFailed($e->getMessage());
            $this->error("❌ Failed to send email: " . $e->getMessage());
        }
    }
}
