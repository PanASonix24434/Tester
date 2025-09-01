<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\nd_Lpi_Report;

class NdLpiReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        nd_Lpi_Report::create([
            'id' => Str::uuid(),
            'application_id' => Str::uuid(),
            'brand' => 'Yamaha',
            'model' => 'X200',
            'turbo' => true,
            'paku_penanda_lebar' => true,
            'correctly_painted' => false,
            'brightly_painted' => true,
            'zone_code' => 'A1',
            'di_atas_bumbung' => false,
            'drilled' => false,
            'no_reg_brigthly_painted' => true,
            'tanda_di_bahagian_laluan' => true,
            'huruf_kod_tanda' => 'B1',
            'qr_code_image_path' => 'images/qrcodes/sample.png',
            'length' => 25.5,
            'width' => 5.2,
            'depth' => 3.1,
            'capacity' => 120.0,
            'navigation_light_status' => true,
            'navigation_light_quantity' => 2,
            'navigation_light_condition' => 'Good',
            'safety_jacket_status' => true,
            'safety_jacket_quantity' => 5,
            'safety_jacket_condition' => 'Excellent',
            'life_buoy_status' => true,
            'life_buoy_quantity' => 3,
            'fire_extinguisher_status' => true,
            'fire_extinguisher_quantity' => 2,
            'life_raft_status' => false,
            'life_raft_quantity' => 0,
            'radio_status' => true,
            'radio_quantity' => 1,
            'horsepower' => 150,
            'engine_number' => 'ENG123456',
            'vessel_engine_indicator' => true,
            'engine_image_path' => 'images/engines/engine1.png',
            'turbo_image_path' => 'images/engines/turbo1.png',
            'generator_image_path' => 'images/generators/gen1.png',
            'vessel_condition' => 'New',
            'hull_type' => 'Fiberglass',
            'vessel_registration_remarks' => 'Registered under Class A',
            'inspection_date' => '2024-01-10',
            'inspection_location' => 'Kuala Lumpur',
            // Ukuran Geometri Vesel (UGV)
            'size' => 'Medium',
            'size_A' => '15m',
            'size_B' => '4m',
            'size_C' => '3m',
            'size_D' => '2.5m',
            'size_E' => '1.5m',
            'size_F' => '1m',

            // Gambar Vesel
            'overall_image_path' => 'images/vessel/overall.png',
            'left_side_image_path' => 'images/vessel/left.png',
            'right_side_image_path' => 'images/vessel/right.png',
            'front_image_path' => 'images/vessel/front.png',
            'back_image_path' => 'images/vessel/back.png',

            // Gambar MTU/AIS
            'mtu_image_path' => 'images/mtu/mtu1.png',
            'ais_image_path' => 'images/ais/ais1.png',

            // Gambar Lampu Pelayaran
            'navigation_light_image_path' => 'images/lights/navigation_light.png',

            // Gambar QR Code
            'peralatan_pelayaran_qr_code_image_path' => 'images/qrcodes/equipment.png',

            // 4. Kelengkapan Menangkap Ikan
            'has_echo_sounder' => true,
            'has_sonar' => false,
            'has_hauler' => true,
            'has_power_block' => false,
            'has_fish_hold' => true,
            'has_rsw' => false,

            // 5. Dokumen
            'general_arrangement_path' => 'documents/arrangement.pdf',
            'vessel_certificate_path' => 'documents/vessel_cert.pdf',
            'engineering_inspection_path' => 'documents/engineering_inspection.pdf',
            'sureveyor_inspections_path' => 'documents/surveyor_inspection.pdf',
            'cert_of_reg_path' => 'documents/cert_of_reg.pdf',
            'gear_making_path' => 'documents/gear_making.pdf',
            'hygiene_path' => 'documents/hygiene.pdf',
            'international_oil_pollution_path' => 'documents/oil_pollution.pdf',
            'international_tonnage_certificate_path' => 'documents/tonnage_certificate.pdf',
            'staff_competency_cert_path' => 'documents/staff_competency.pdf',
            'safety_equipment_cert_path' => 'documents/safety_equipment.pdf',

            'created_by' => Str::uuid(),
            'updated_by' => Str::uuid(),
            'is_active' => true,
        ]);
    }
}
