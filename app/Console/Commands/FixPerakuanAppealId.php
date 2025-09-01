<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixPerakuanAppealId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-perakuan-appeal-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for orphaned perakuans (not linked to a valid appeal)...');
        $orphans = \App\Models\Perakuan::whereNull('appeal_id')
            ->orWhereDoesntHave('appeal')
            ->get();
        if ($orphans->isEmpty()) {
            $this->info('No orphaned perakuans found.');
        } else {
            foreach ($orphans as $perakuan) {
                $this->warn("Orphaned Perakuan ID: {$perakuan->id} | appeal_id: {$perakuan->appeal_id}");
            }
            // Uncomment the next lines to delete orphans automatically:
            // $orphans->each->delete();
            // $this->info('Deleted all orphaned perakuans.');
        }
        $this->info('Done checking for orphans.');

        \App\Models\Perakuan::chunk(100, function ($perakuans) {
            foreach ($perakuans as $perakuan) {
                $appeal = \App\Models\Appeal::where('applicant_id', $perakuan->user_id)->latest()->first();
                if ($appeal) {
                    $perakuan->appeal_id = $appeal->id;
                    $perakuan->save();
                    $this->info("Updated perakuan {$perakuan->id} with appeal_id {$appeal->id}");
                }
            }
        });
        $this->info('Done updating perakuan appeal_id.');
    }
}
