<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LicensingQuotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing licensing quota data
        DB::table('licensing_quotas')->truncate();
        
        // Insert sample licensing quota data for year 2025
        $quotaData = [
            // Sampan
            [
                'category' => 'Sampan',
                'sub_category' => null,
                'year' => 2025,
                'fma_01' => 100,
                'fma_02' => 80,
                'fma_03' => 60,
                'fma_04' => 70,
                'fma_05' => 50,
                'fma_06' => 30,
                'fma_07' => 20,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // A
            [
                'category' => 'A',
                'sub_category' => null,
                'year' => 2025,
                'fma_01' => 200,
                'fma_02' => 150,
                'fma_03' => 120,
                'fma_04' => 100,
                'fma_05' => 80,
                'fma_06' => 40,
                'fma_07' => 30,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // B Pelagik
            [
                'category' => 'B',
                'sub_category' => 'Pelagik',
                'year' => 2025,
                'fma_01' => 150,
                'fma_02' => 120,
                'fma_03' => 90,
                'fma_04' => 80,
                'fma_05' => 60,
                'fma_06' => 30,
                'fma_07' => 25,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // B Demersal
            [
                'category' => 'B',
                'sub_category' => 'Demersal',
                'year' => 2025,
                'fma_01' => 120,
                'fma_02' => 100,
                'fma_03' => 80,
                'fma_04' => 70,
                'fma_05' => 50,
                'fma_06' => 25,
                'fma_07' => 20,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // C Pelagik
            [
                'category' => 'C',
                'sub_category' => 'Pelagik',
                'year' => 2025,
                'fma_01' => 80,
                'fma_02' => 70,
                'fma_03' => 60,
                'fma_04' => 50,
                'fma_05' => 40,
                'fma_06' => 20,
                'fma_07' => 15,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // C Demersal
            [
                'category' => 'C',
                'sub_category' => 'Demersal',
                'year' => 2025,
                'fma_01' => 70,
                'fma_02' => 60,
                'fma_03' => 50,
                'fma_04' => 40,
                'fma_05' => 30,
                'fma_06' => 15,
                'fma_07' => 10,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // C2 Pelagik
            [
                'category' => 'C2',
                'sub_category' => 'Pelagik',
                'year' => 2025,
                'fma_01' => 60,
                'fma_02' => 50,
                'fma_03' => 40,
                'fma_04' => 35,
                'fma_05' => 25,
                'fma_06' => 12,
                'fma_07' => 8,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // C2 Demersal
            [
                'category' => 'C2',
                'sub_category' => 'Demersal',
                'year' => 2025,
                'fma_01' => 50,
                'fma_02' => 40,
                'fma_03' => 35,
                'fma_04' => 30,
                'fma_05' => 20,
                'fma_06' => 10,
                'fma_07' => 6,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Jerut Bilis
            [
                'category' => 'Jerut Bilis',
                'sub_category' => null,
                'year' => 2025,
                'fma_01' => 40,
                'fma_02' => 35,
                'fma_03' => 30,
                'fma_04' => 0,
                'fma_05' => 0,
                'fma_06' => 0,
                'fma_07' => 25,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // PTMT
            [
                'category' => 'PTMT',
                'sub_category' => null,
                'year' => 2025,
                'fma_01' => 35,
                'fma_02' => 30,
                'fma_03' => 25,
                'fma_04' => 20,
                'fma_05' => 0,
                'fma_06' => 0,
                'fma_07' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Kenka 2 Bot
            [
                'category' => 'Kenka 2 Bot',
                'sub_category' => null,
                'year' => 2025,
                'fma_01' => 30,
                'fma_02' => 25,
                'fma_03' => 20,
                'fma_04' => 15,
                'fma_05' => 10,
                'fma_06' => 0,
                'fma_07' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Siput Retak Seribu
            [
                'category' => 'Siput Retak Seribu',
                'sub_category' => null,
                'year' => 2025,
                'fma_01' => 25,
                'fma_02' => 20,
                'fma_03' => 0,
                'fma_04' => 0,
                'fma_05' => 0,
                'fma_06' => 0,
                'fma_07' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        
        DB::table('licensing_quotas')->insert($quotaData);
        
        $this->command->info('Licensing Quota data seeded successfully!');
        $this->command->info('Total quota records: ' . count($quotaData));
    }
}
