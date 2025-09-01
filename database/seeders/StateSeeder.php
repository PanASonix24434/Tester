<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CodeMaster as State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$my = json_encode(['type' => 'country', 'name' => 'Malaysia']);
		
		// state
		State::seed('state', '01', 'Johor', 'Johor', null, $my);
		State::seed('state', '02', 'Kedah', 'Kedah', null, $my);
		State::seed('state', '03', 'Kelantan', 'Kelantan', null, $my);
		State::seed('state', '04', 'Melaka', 'Melaka', null, $my);
		State::seed('state', '05', 'Negeri Sembilan', 'Negeri Sembilan', null, $my);
		State::seed('state', '06', 'Pahang', 'Pahang', null, $my);
		State::seed('state', '07', 'Pulau Pinang', 'Pulau Pinang', null, $my);
		State::seed('state', '08', 'Perak', 'Perak', null, $my);
		State::seed('state', '09', 'Perlis', 'Perlis', null, $my);
		State::seed('state', '10', 'Selangor', 'Selangor', null, $my);
		State::seed('state', '11', 'Terengganu', 'Terengganu', null, $my);
		State::seed('state', '12', 'Sabah', 'Sabah', null, $my);
		State::seed('state', '13', 'Sarawak', 'Sarawak', null, $my);
		State::seed('state', '14', 'WP Kuala Lumpur', 'WP Kuala Lumpur', null, $my);
		State::seed('state', '15', 'WP Labuan', 'WP Labuan', null, $my);
		State::seed('state', '16', 'WP Putrajaya', 'WP Putrajaya', null, $my);
    }
}