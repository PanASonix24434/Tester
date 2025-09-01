<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FMADataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing FMA data
        DB::table('fma_compositions')->truncate();
        
        // Insert all 7 FMA areas
        $fmaData = [
            [
                'fma_number' => 1,
                'states' => 'Perlis, Kedah, Pulau Pinang, Perak & Selangor',
                'chairman' => 'Perak',
                'year' => 2025,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fma_number' => 2,
                'states' => 'Negeri Sembilan, Melaka & Johor Barat',
                'chairman' => 'Johor',
                'year' => 2025,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fma_number' => 3,
                'states' => 'Kelantan & Terengganu',
                'chairman' => 'Terengganu',
                'year' => 2025,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fma_number' => 4,
                'states' => 'Pahang & Johor Timur',
                'chairman' => 'Pahang',
                'year' => 2025,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fma_number' => 5,
                'states' => 'Sarawak',
                'chairman' => 'Sarawak',
                'year' => 2025,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fma_number' => 6,
                'states' => 'Limbang Lawas',
                'chairman' => 'Sarawak',
                'year' => 2025,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'fma_number' => 7,
                'states' => 'Labuan',
                'chairman' => 'Labuan',
                'year' => 2025,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        
        DB::table('fma_compositions')->insert($fmaData);
        
        $this->command->info('FMA data seeded successfully!');
        $this->command->info('Total FMA areas: ' . count($fmaData));
    }
}
