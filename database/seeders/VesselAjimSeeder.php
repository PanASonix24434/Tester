<?php

namespace Database\Seeders;

use App\Models\Vessel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VesselAjimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vessel::factory()->count(50)->create();

        $vessels = [
            'A' => [
                'PKS3675', 'TFA2033', 'PKFA9581', 'PKFB970', 'TFA2388', 'KHS6520', 'SLS6357', 'PHS3742', 'KHS3110', 'PKFA8181',
            ],
            'B' => [
                'PKFB767', 'JHFA89B', 'JHF1077B', 'PKFA8677', 'PKFA9714', 'PKFB1273', 'PKFB767', 'JHFA89B', 'JHF1077B', 'PKFA8677',
            ],
            'C' => [
                'SF2-155', 'PKFB1459', 'JHF5252T', 'KHF2193', 'SF1-89', 'PSF2397', 'PKFA9574', 'PSF2039', 'SF1-5216', 'JHF5138T',
            ],
        ];

        foreach ($vessels as $zone => $vessel_numbers) {
            foreach ($vessel_numbers as $vessel_no) {
                if (!Vessel::where('vessel_no', $vessel_no)->exists()) {
                    $vessel = new Vessel;
                    $vessel->vessel_no = $vessel_no;
                    $vessel->zone = $zone;
                    $vessel->save();
                }
            }
        }
    }
}
