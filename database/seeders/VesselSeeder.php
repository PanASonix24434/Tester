<?php

namespace Database\Seeders;

use App\Models\Vessel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Colors\Profile;
use App\Models\ProfileUser;
use App\Models\ProfilVessel\Pangkalan;

class VesselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vessel::factory()->count(50)->create();
        DB::table('vessels')->delete();

        $user1 = ProfileUser::where('icno', '222222222222')->first();
        $user2 = ProfileUser::where('icno', '333333333333')->first();

        // Ambil ID pangkalan secara dinamik
        $pangkalanUtama = Pangkalan::where('nama_pangkalan', 'Pelabuhan A')->first();
        $pangkalanTambahan = Pangkalan::where('nama_pangkalan', 'Pelabuhan B')->first();

        // Create vessels
        $vessel1 = Vessel::create([
            'id'                   => (string) Str::uuid(),
            'no_pendaftaran'       => 'VSL-001',
            'negeri'               => 'Selangor',
            'daerah'               => 'Petaling',
            'pangkalan'            => 'Port Klang',
            'zon'                  => 'A',
            'bil_enjin'            => 2,
            'tarikh_mula'          => Carbon::now()->subDays(30),
            'tarikh_tamat_lesen'   => Carbon::now()->addYear(),
            'status_vesel'         => 1,
            'pangkalan_utama_id' => $pangkalanUtama ? $pangkalanUtama->id : null,
            'pangkalan_tambahan_id' => $pangkalanTambahan ? $pangkalanTambahan->id : null,
        ]);

        $vessel2 = Vessel::create([
            'id'                   => (string) Str::uuid(),
            'no_pendaftaran'       => 'VSL-002',
            'negeri'               => 'Johor',
            'daerah'               => 'Johor Bahru',
            'pangkalan'            => 'Pasir Gudang',
            'zon'                  => 'B',
            'bil_enjin'            => 3,
            'tarikh_mula'          => Carbon::now()->subDays(60),
            'tarikh_tamat_lesen'   => Carbon::now()->addMonths(6),
            'status_vesel'         => 0,
            'pangkalan_utama_id' => $pangkalanUtama ? $pangkalanUtama->id : null,
            'pangkalan_tambahan_id' => null, 
        ]);

        if ($user1) {
            $vessel1->managers()->attach($user1->id, ['role' => 'manager', 'status' => 'verified']);
        }

        if ($user2) {
            $vessel2->managers()->attach($user2->id, ['role' => 'manager', 'status' => 'verified']);
        }
    }
}
