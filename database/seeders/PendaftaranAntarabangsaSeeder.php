<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Vessel;

class PendaftaranAntarabangsaSeeder extends Seeder
{
    public function run()
    {
        $vessel1 = Vessel::inRandomOrder()->first();
        $vessel2 = Vessel::inRandomOrder()->first();

        DB::table('pendaftaran_antarabangsa')->insert([
            [
                'vessel_id' => $vessel1->id ?? null,
                'no_pendaftaran' => 'TRF002',
                'no_ircs' => 'IRCS-001',
                'no_rfmo' => 'RFMO-XYZ',
                'no_imo' => 'IMO-98765',
                'kawasan_penangkapan' => 'Lautan Pasifik',
                'spesis_sasaran' => 'Tuna',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'vessel_id' => $vessel2->id ?? null,
                'no_pendaftaran' => 'ROM0003',
                'no_ircs' => 'IRCS-002',
                'no_rfmo' => 'RFMO-ABC',
                'no_imo' => 'IMO-12345',
                'kawasan_penangkapan' => 'Lautan Pasifik',
                'spesis_sasaran' => 'Tuna',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
