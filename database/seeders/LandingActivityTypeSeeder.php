<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingDeclaration\LandingActivityType;

class LandingActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// race
        LandingActivityType::seed('MEMANCING', true, 1);
        LandingActivityType::seed('MEMASANG PUKAT', false, 2);
        LandingActivityType::seed('MENGANGKAT PUKAT', true, 3);
    }
}