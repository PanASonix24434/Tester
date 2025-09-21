<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\PermitReminder;

class UpdateUserEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:user-email {email=fadzly0222@gmail.com}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user email and send reminder';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = $this->argument('email');
        
        $this->info("📧 Updating user email to: {$email}");
        
        // Update first user email
        $user = User::first();
        if ($user) {
            $user->update(['email' => $email]);
            $this->info("✅ Updated user email to: {$email}");
            
            // Update existing reminders to use new email
            $reminders = PermitReminder::where('user_id', $user->id)->get();
            foreach ($reminders as $reminder) {
                $reminder->update(['is_sent' => false]); // Reset to pending
            }
            
            $this->info("✅ Reset {$reminders->count()} reminders to pending status");
            $this->info("");
            $this->info("Now run: php artisan permits:check-reminders");
            
        } else {
            $this->error("No user found!");
        }
    }
}
