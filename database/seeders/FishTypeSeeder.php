<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FishType;

class FishTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fishTypes = [
            ['name' => 'Ikan Kembung'],
            ['name' => 'Ikan Selar'],
            ['name' => 'Ikan Tenggiri'],
            ['name' => 'Ikan Bawal'],
            ['name' => 'Ikan Kerapu'],
            ['name' => 'Ikan Siakap'],
            ['name' => 'Ikan Gelama'],
            ['name' => 'Ikan Pari'],
            ['name' => 'Ikan Yu'],
            ['name' => 'Udang'],
            ['name' => 'Ketam'],
            ['name' => 'Sotong'],
        ];

        foreach ($fishTypes as $fishType) {
            FishType::firstOrCreate(['name' => $fishType['name']]);
        }
    }
} 