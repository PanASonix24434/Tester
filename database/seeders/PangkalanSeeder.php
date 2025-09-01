<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PangkalanSeeder extends Seeder
{
    public function run()
    {
        DB::table('am_pangkalan')->insert([
            [
                'no_rujukan_permohonan' => 'PDT9202-22SR',
                'nama_pangkalan' => 'BAGAN SUNGAI BURONG',
                'jenis_pangkalan' => 'UTAMA',
                'daerah' => 'HILIR PERAK',
                'negeri' => 'PERAK',
                'tarikh_mula_beroperasi' => '2020-05-15',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_rujukan_permohonan' => 'REQ-002SS4',
                'nama_pangkalan' => 'PASIR GUDANG',
                'jenis_pangkalan' => 'TAMBAHAN',
                'daerah' => 'Johor Bahru',
                'negeri' => 'Johor',
                'tarikh_mula_beroperasi' => '2022-07-10',
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
