<?php

namespace Database\Seeders;

use App\Models\LandingDeclaration\LandingWaterType;
use Illuminate\Database\Seeder;

class LandingWaterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// race
        LandingWaterType::seed('SUNGAI', 1);
        LandingWaterType::seed('TASIK', 2);
        LandingWaterType::seed('LOMBONG', 3);
    }
}