<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(UserSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(CodeMasterSeeder::class);
		$this->call(CountrySeeder::class);       
        $this->call(StateSeeder::class);
        $this->call(DistrictSeeder::class);  
        $this->call(ParliamentSeeder::class);
        $this->call(ParliamentSeatSeeder::class);
        $this->call(EntitySeeder::class);
        $this->call(LandingWaterTypeSeeder::class);
        $this->call(LandingActivityTypeSeeder::class);
        $this->call(SpeciesSeeder::class);

    }
}
