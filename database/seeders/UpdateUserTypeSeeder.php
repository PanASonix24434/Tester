<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateUserTypeSeeder extends Seeder
{
    public function run()
    {
       DB::table('code_masters')
    	->where('code', 4)
    	->where('type', 'user_type')
    	->update([
           'name' => 'PENTADBIR HARTA',
       	   'name_ms' => 'PENTADBIR HARTA',
           'updated_at' => now(),
           'is_active' => 1, 
        ]);  
    }
}
