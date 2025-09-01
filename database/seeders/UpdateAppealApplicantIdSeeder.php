<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appeal;

class UpdateAppealApplicantIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appeal = Appeal::find(1);
        
        if ($appeal) {
            $appeal->applicant_id = '682a6721-ec3d-42af-a747-c884e79bf19f';
            $appeal->save();
            
            $this->command->info('Successfully updated Appeal ID 1 applicant_id to: 682a6721-ec3d-42af-a747-c884e79bf19f');
        } else {
            $this->command->error('Appeal with ID 1 not found!');
        }
    }
}
