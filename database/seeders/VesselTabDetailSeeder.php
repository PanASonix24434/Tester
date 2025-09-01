<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VesselTabDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Seed am_vessel
        DB::table('am_vessel')->insert([
            [
                'no_pendaftaran' => 'TRF002',
                'no_tetap' => 'T123',
                'no_patil_kekal' => 'P456',
                'tarikh_daftar' => Carbon::now()->subDays(30),
                'indikator_kapal' => 'Aktif',
                'bahan_api' => 'Diesel',
                'status_usaha_kapal' => 'Beroperasi',
                'tempasal_kapal' => 'Pelabuhan A',
                'negara' => 'Malaysia',
                'kebenaran_memancing' => true,
                'pemasangan_vtu' => true,
                'kod_rfid' => 'RFID001',
                'kod_qr' => 'QR001',
                'hak_milik' => 'Persendirian',
                'status_iuu' => false,
                'pangkalan_utama' => 'Pelabuhan Utama',
                'pangkalan_tambahan' => 'Pelabuhan Sekunder',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_pendaftaran' => 'ROM0003',
                'no_tetap' => 'T789',
                'no_patil_kekal' => 'P987',
                'tarikh_daftar' => Carbon::now()->subDays(30),
                'indikator_kapal' => 'Tidak Aktif',
                'bahan_api' => 'Petrol',
                'status_usaha_kapal' => 'Dalam Penyelenggaraan',
                'tempasal_kapal' => 'Pelabuhan B',
                'negara' => 'Indonesia',
                'kebenaran_memancing' => false,
                'pemasangan_vtu' => false,
                'kod_rfid' => 'RFID002',
                'kod_qr' => 'QR002',
                'hak_milik' => 'Kerajaan',
                'status_iuu' => true,
                'pangkalan_utama' => 'Pelabuhan C',
                'pangkalan_tambahan' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed lesen
        DB::table('lesen')->insert([
            [
                'no_pendaftaran' => 'TRF002',
                'no_lesen' => 'L001',
                'tarikh_keluar' => Carbon::now()->subDays(30),
                'tarikh_tamat' =>  Carbon::now()->addYear(),
                'kod_zon' => 'A1',
                'kawasan_perairan' => 'Zon 1',
                'no_patil' => 'P123',
                'catatan' => 'Lesen Sah',
                'status_lesen' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_pendaftaran' => 'ROM0003 ',
                'no_lesen' => 'L002',
                'tarikh_keluar' =>  Carbon::now()->subDays(30),
                'tarikh_tamat' =>  Carbon::now()->addYear(),
                'kod_zon' => 'B2',
                'kawasan_perairan' => 'Zon 2',
                'no_patil' => 'P789',
                'catatan' => 'Lesen Tamat Tempoh',
                'status_lesen' => 'Tamat Tempoh',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed kulit
        DB::table('kulit')->insert([
            [
                'id' => Str::uuid(), // Generate UUID
                'no_pendaftaran' => 'TRF002',
                'panjang' => '20m',
                'lebar' => '5m',
                'dalam' => '3m',
                'jenis_kulit' => 'Kayu',
                'tarikh_kulit_dilesenkan' =>  Carbon::now()->subDays(30),
                'status_kulit' => 'Baik',
                'catatan' => 'Baru Diperiksa',
                'baru' => true,
                'asal' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(), // Generate UUID

                'no_pendaftaran' => 'ROM0003 ',
                'panjang' => '25m',
                'lebar' => '6m',
                'dalam' => '4m',
                'jenis_kulit' => 'Keluli',
                'tarikh_kulit_dilesenkan' =>  Carbon::now()->subDays(30),
                'status_kulit' => 'Perlu Dibaiki',
                'catatan' => 'Karatan Dikesan',
                'baru' => false,
                'asal' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed enjin
        DB::table('enjin')->insert([
            [
                'no_pendaftaran' => 'TRF002',
                'jenis_enjin' => 1,
                'jenama' => 'Yamaha',
                'kuasa_kuda' => 250,
                'no_enjin' => 'EJ12345',
                'model' => 'X200',
                'tarikh_enjin_dilesenkan' =>  Carbon::now()->subDays(30),
                'kategori_enjin' => 'Dalaman',
                'status_enjin' => 'Beroperasi',
                'bahan_api' => 'Diesel',
                'has_turbo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_pendaftaran' => 'ROM0003 ',
                'jenis_enjin' => 2,
                'jenama' => 'Honda',
                'kuasa_kuda' => 300,
                'no_enjin' => 'EJ67890',
                'model' => 'Z500',
                'tarikh_enjin_dilesenkan' =>  Carbon::now()->subDays(30),
                'kategori_enjin' => 'Luar',
                'bahan_api' => 'Petrol',
                'has_turbo' => false,
                'status_enjin' => 'Perlu Dibaiki',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed pemilikan
        DB::table('pemilikan')->insert([
            [
                'no_pendaftaran' => 'TRF002',
                'nama_pemilik' => 'Ahmad Maritime',
                'jenis_pemilikan' => 'Individu',
                'negeri' => 'Selangor',
                'daerah' => 'Klang',
                'tarikh_aktif_pemilikan' =>  Carbon::now()->subDays(10),
                'status_pemilikan' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_pendaftaran' => 'ROM0003 ',
                'nama_pemilik' => 'Budi Fishing Co.',
                'jenis_pemilikan' => 'Syarikat',
                'negeri' => 'Johor',
                'daerah' => 'Mersing',
                'tarikh_aktif_pemilikan' =>  Carbon::now()->subDays(30),
                'status_pemilikan' => 'Tidak Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed peralatan
        DB::table('cm_equipment')->insert([
            [
                'id' => (string) Str::uuid(),
                'vessel_id' => 'TRF002',
                'equipment_name' => 'Bubu',
                'equipment_type' => 1,
                'date_licensed' =>  Carbon::now()->subDays(30),
                'fisherman_type' => 1,
                'notes' => 'Perlu Dibaiki',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'vessel_id' => 'ROM0003 ',
                'equipment_name' => 'Jaring',
                'equipment_type' => 2,
                'date_licensed' =>  Carbon::now()->subDays(30),
                'fisherman_type' => 1,
                'notes' => 'Memerlukan Calibrasi',
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed kru
        // warganegara: 1 = kru tempatan, 2 = penduduk tetap, 3 = kru asing
        // Status Kru = 1 = Aktif, 2 = Tidak Aktif, 3 = Batal
        DB::table('kru')->insert([
            [
                'no_pendaftaran' => 'TRF002',
                'warganegara' => 2,
                'nama_kru' => 'Ali Hassan',
                'no_kp_baru' => '900101-01-1234',
                'no_kp_lama' => null,
                'no_kad' => 'KRU001',
                'jawatan' => 'Awak-awak',
                'tarikh_kemaskini_mykad' =>  Carbon::now()->subDays(30),
                'status_kru' => 1,
                'no_sijil' => 'S123456',
                'no_plks' => null,
                'tarikh_tamat_plks' => null,
                'negara' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_pendaftaran' => 'ROM0003 ',
                'warganegara' => 1,
                'nama_kru' => 'Zainal Mutalib',
                'no_kp_baru' => '850505-02-5678',
                'no_kp_lama' => 'A123456',
                'no_kad' => 'KRU002',
                'jawatan' => 'Nakhoda',
                'tarikh_kemaskini_mykad' =>  Carbon::now()->subDays(30),
                'status_kru' => 2,
                'no_sijil' => null,
                'no_plks' => null,
                'tarikh_tamat_plks' => null,
                'negara' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_pendaftaran' => 'TRF002',
                'warganegara' => 3,
                'nama_kru' => 'Boun Ondavong',
                'no_kp_baru' => null,
                'no_kp_lama' => null,
                'no_kad' => null,
                'tarikh_kemaskini_mykad' => null,
                'no_sijil' => null,
                'no_plks' => 'P2882828',
                'tarikh_tamat_plks' =>  Carbon::now()->addYear(),
                'negara' => 'Laos',
                'jawatan' => 'Awak-awak',
                'status_kru' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_pendaftaran' => 'TRF002',
                'warganegara' => 1,
                'nama_kru' => 'Ahmad Bin Ali',
                'no_kp_baru' => '900101-01-1234',
                'no_kp_lama' => null,
                'no_kad' => 'KRU003',
                'jawatan' => 'Awak-awak',
                'tarikh_kemaskini_mykad' =>  Carbon::now()->subDays(30),
                'status_kru' => 1,
                'no_sijil' => 'S123456',
                'no_plks' => null,
                'tarikh_tamat_plks' => null,
                'negara' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Seed kesalahan
        DB::table('kesalahan')->insert([
            [
                'no_pendaftaran' => 'TRF002',
                'pesalah' => 'Ali Hassan',
                'no_ic_pesalah' => '900101-01-1234',
                'akta' => 'Akta Perikanan 1985',
                'seksyen' => 'Seksyen 15',
                'kesalahan' => 'Memancing di kawasan larangan',
                'tarikh' =>  Carbon::now()->subDays(15),
                'keputusan' => 'Denda RM5000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'no_pendaftaran' => 'ROM0003 ',
                'pesalah' => 'Zainal Mutalib',
                'no_ic_pesalah' => '850505-02-5678',
                'akta' => 'Akta Perkapalan 1994',
                'seksyen' => 'Seksyen 21',
                'kesalahan' => 'Tidak mempunyai lesen sah',
                'tarikh' =>  Carbon::now()->subDays(150),
                'keputusan' => 'Tahanan kapal selama 6 bulan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
