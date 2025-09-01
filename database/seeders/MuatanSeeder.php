<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MuatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch a valid kulit_id from the 'kulit' table
        $kulit = DB::table('kulit')->first();

        if (!$kulit) {
            // If there's no 'kulit' entry, create one (to avoid foreign key constraint failure)
            $kulit_id = (string) Str::uuid();
            DB::table('kulit')->insert([
                'id' => $kulit_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $kulit_id = $kulit->id;
        }

        // Insert seed data into 'muatan' table
        DB::table('muatan')->insert([
            [
                'kulit_id' => $kulit_id,
                'gt_1' => 'GT Example 1',
                'gt_2' => 'GT Example 2',
                'grt_1' => 'GRT Example 1',
                'grt_2' => 'GRT Example 2',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kulit_id' => $kulit_id,
                'gt_1' => 'GT Sample 3',
                'gt_2' => 'GT Sample 4',
                'grt_1' => 'GRT Sample 3',
                'grt_2' => 'GRT Sample 4',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
