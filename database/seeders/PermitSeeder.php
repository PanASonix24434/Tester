<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permit;

class PermitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permits = [
            [
                'permit_number' => 'C2-001',
                'permit_type' => 'C2',
                'zone' => 'C2',
                'status' => 'active',
                'issue_date' => now()->subMonths(6),
                'expiry_date' => now()->addMonths(6),
                'has_progress' => false,
                'application_count' => 0,
            ],
            [
                'permit_number' => 'C3-001',
                'permit_type' => 'C3/Angkut',
                'zone' => 'C3',
                'status' => 'active',
                'issue_date' => now()->subMonths(8),
                'expiry_date' => now()->addMonths(4),
                'has_progress' => true,
                'application_count' => 1,
            ],
            [
                'permit_number' => 'MPPI-001',
                'permit_type' => 'MPPI',
                'zone' => 'MPPI',
                'status' => 'active',
                'issue_date' => now()->subMonths(10),
                'expiry_date' => now()->addMonths(2),
                'has_progress' => false,
                'application_count' => 2,
            ],
            [
                'permit_number' => 'SKL-001',
                'permit_type' => 'SKL',
                'zone' => 'SKL',
                'status' => 'active',
                'issue_date' => now()->subMonths(12),
                'expiry_date' => now(),
                'has_progress' => false,
                'application_count' => 3,
            ],
        ];

        foreach ($permits as $permit) {
            Permit::create($permit);
        }

        $this->command->info('Sample permit data created successfully!');
    }
}
