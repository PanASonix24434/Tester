<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PermitReminder;

class CheckEmailStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:check-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check email reminder status and statistics';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('📧 Email Reminder Status Report');
        $this->info('================================');
        
        // Get statistics
        $totalReminders = PermitReminder::count();
        $sentReminders = PermitReminder::where('is_sent', true)->count();
        $failedReminders = PermitReminder::where('email_status', 'failed')->count();
        $pendingReminders = PermitReminder::where('is_sent', false)->count();
        
        $this->info("Total Reminders: {$totalReminders}");
        $this->info("✅ Sent Successfully: {$sentReminders}");
        $this->info("❌ Failed: {$failedReminders}");
        $this->info("⏳ Pending: {$pendingReminders}");
        $this->info("");
        
        // Show recent reminders
        $this->info('📋 Recent Reminders (Last 10):');
        $this->info('===============================');
        
        $recentReminders = PermitReminder::with(['permit', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        if ($recentReminders->isEmpty()) {
            $this->warn('No reminders found.');
            return;
        }
        
        $headers = ['ID', 'Permit', 'User Email', 'Status', 'Sent Date', 'Error'];
        $rows = [];
        
        foreach ($recentReminders as $reminder) {
            $status = $reminder->is_sent ? '✅ Sent' : '⏳ Pending';
            if ($reminder->email_status === 'failed') {
                $status = '❌ Failed';
            }
            
            $rows[] = [
                $reminder->id,
                $reminder->permit->no_permit ?? 'N/A',
                $reminder->user->email ?? 'N/A',
                $status,
                $reminder->sent_date ? $reminder->sent_date->format('d/m/Y H:i') : 'N/A',
                $reminder->email_error ?? 'N/A',
            ];
        }
        
        $this->table($headers, $rows);
        
        // Show failed reminders details
        if ($failedReminders > 0) {
            $this->info('');
            $this->error('❌ Failed Reminders Details:');
            $this->error('============================');
            
            $failedReminders = PermitReminder::where('email_status', 'failed')
                ->with(['permit', 'user'])
                ->get();
            
            foreach ($failedReminders as $reminder) {
                $this->error("ID: {$reminder->id} | Permit: {$reminder->permit->no_permit} | Email: {$reminder->user->email}");
                $this->error("Error: {$reminder->email_error}");
                $this->error("---");
            }
        }
    }
}
