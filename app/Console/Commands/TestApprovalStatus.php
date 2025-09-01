<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StatusStock;

class TestApprovalStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:approval-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the approval status functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing approval status functionality...');

        try {
            // Test 1: Basic record update
            $this->info('Test 1: Basic record update');
            $existingRecord = StatusStock::where('fish_type_id', 1)
                ->where('tahun', 2025)
                ->first();
            
            if ($existingRecord) {
                $this->info('Found existing record with ID: ' . $existingRecord->id);
                $this->info('Current pengesahan_status: ' . ($existingRecord->pengesahan_status ?? 'NULL'));
                
                // Update the record
                $existingRecord->update(['pengesahan_status' => 'approved']);
                
                // Refresh the model
                $existingRecord->refresh();
                
                $this->info('Updated pengesahan_status to: ' . ($existingRecord->pengesahan_status ?? 'NULL'));
            } else {
                $this->info('No existing record found. Creating new record...');
                
                // Create new record
                $newRecord = StatusStock::create([
                    'tahun' => 2025,
                    'fish_type_id' => 1,
                    'fma' => 'Test FMA',
                    'bilangan_stok' => 100,
                    'status' => 'draft',
                    'pengesahan_status' => 'approved'
                ]);
                
                $this->info('Created new record with ID: ' . $newRecord->id);
                $this->info('Pengesahan status: ' . ($newRecord->pengesahan_status ?? 'NULL'));
            }
            
            // Test 2: Update all records for year
            $this->info('Test 2: Update all records for year');
            $updatedCount = StatusStock::where('tahun', 2025)
                ->update(['pengesahan_status' => 'rejected']);
            
            $this->info("Updated {$updatedCount} records for year 2025 to 'rejected'");
            
            // Verify the updates
            $verifyRecords = StatusStock::where('tahun', 2025)->get();
            $this->info('Verification - Records for year 2025:');
            foreach ($verifyRecords as $record) {
                $this->info("Record ID: {$record->id}, Status: " . ($record->pengesahan_status ?? 'NULL'));
            }
            
            $this->info('All tests completed successfully!');
            
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
