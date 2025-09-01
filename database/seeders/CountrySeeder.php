<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CodeMaster as Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// country
		Country::seed('country', 'MY', 'Malaysia', 'Malaysia', null);
		Country::seed('country', 'SG', 'Singapore', 'Singapore', null);
		Country::seed('country', 'ID', 'Indonesia', 'Indonesia', null);
		Country::seed('country', 'PH', 'Philippines', 'Philippines', null);
		Country::seed('country', 'BN', 'Brunei Darussalam', 'Brunei Darussalam', null);
		Country::seed('country', 'TH', 'Thailand', 'Thailand', null);
		Country::seed('country', 'CN', 'China', 'China', null);
		Country::seed('country', 'JP', 'Japan', 'Japan', null);
		Country::seed('country', 'MD', 'Madagascar', 'Madagascar', null);
		Country::seed('country', 'US', 'USA', 'USA', null);
    }
}