<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\darat_equipment_list;

class DaratEquipmentListSeeder extends Seeder
{
    public function run()
    {
        $equipmentNames = [
            'JARING UDANG',
            'PUKAT',
            'BUBU',
            'RAWAI',
            'JALA',
            'BESEN IKAN',
            'BAKUL PLASTIK',
            'TONG SIMPANAN IKAN',
            'TANGKUK',
            'SEROK',
            'PENANGKAP KETAM',
            'PERANGKAP IKAN',
            'BOT KECIL',
            'KOTAK SIMPAN IKAN',
            'PENAPIS AIR',
            'TALI IKAN',
            'TONG AIS',
            'ALAT PENCUCUK IKAN',
            'BAIT BUATAN',
            'JARING TEGAK',
            'PEMATANG IKAN',
            'ENJIN BOT SANDAR',
        ];

        foreach ($equipmentNames as $name) {
            darat_equipment_list::create([
                'name'       => $name,
                'type'       => null,
                'is_active'  => true,
            ]);
        }
    }
}
