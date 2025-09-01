<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CodeMaster as CodeMaster;
use App\Models\Entity;
use App\Models\Systems\Module;
use App\Models\Kru\KruApplicationType;
use App\Models\User;
use Carbon\Carbon;
use App\Models\CodeMaster as District;

class AOneTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //---------------------------Irfan - Start---------------------------
        // // Jawatan - permohonan kad pendaftaran nelayan
        // CodeMaster::seed('kru_position', 1, 'PEMILIK VESEL', 'PEMILIK VESEL', 1);
        // CodeMaster::seed('kru_position', 2, 'KRU', 'KRU', 2);

        // //peralatan
        // CodeMaster::seed('peralatan', null, 'PUKAT TUNDA', 'PUKAT TUNDA', 1);
        // CodeMaster::seed('peralatan', null, 'PUKAT JERUT', 'PUKAT JERUT', 2);
        // CodeMaster::seed('peralatan', null, 'PUKAT HANYUT', 'PUKAT HANYUT', 3);
        // CodeMaster::seed('peralatan', null, 'RAWAI', 'RAWAI', 4);
        // CodeMaster::seed('peralatan', null, 'BUBU', 'BUBU', 5);
        
        // //status permohonan kru
        // CodeMaster::seed('kru_application_status', 1, 'DISIMPAN', 'DISIMPAN', 1);
        // CodeMaster::seed('kru_application_status', 2, 'DIHANTAR', 'DIHANTAR', 2);
        // CodeMaster::seed('kru_application_status', 3, 'DISEMAK DAERAH', 'DISEMAK DAERAH', 3);
        // CodeMaster::seed('kru_application_status', 4, 'DISOKONG DAERAH', 'DISOKONG DAERAH', 4);
        // CodeMaster::seed('kru_application_status', 5, 'DISOKONG WILAYAH', 'DISOKONG WILAYAH', 5);
        // CodeMaster::seed('kru_application_status', 6, 'DISEMAK NEGERI', 'DISEMAK NEGERI', 6);
        // CodeMaster::seed('kru_application_status', 7, 'DISOKONG NEGERI', 'DISOKONG NEGERI', 7);
        // CodeMaster::seed('kru_application_status', 8, 'DITOLAK', 'DITOLAK', 8);
        // CodeMaster::seed('kru_application_status', 9, 'DILULUS', 'DILULUS', 9);
        // CodeMaster::seed('kru_application_status', 10, 'TIDAK LENGKAP', 'TIDAK LENGKAP', 10);
        // CodeMaster::seed('kru_application_status', 11, 'TIDAK DISOKONG DAERAH', 'TIDAK DISOKONG DAERAH', 11);
        // CodeMaster::seed('kru_application_status', 12, 'TIDAK DISOKONG WILAYAH', 'TIDAK DISOKONG WILAYAH', 12);
        // CodeMaster::seed('kru_application_status', 13, 'TIDAK DISOKONG NEGERI', 'TIDAK DISOKONG NEGERI', 13);
        // CodeMaster::seed('kru_application_status', 14, 'BAYARAN DITERIMA', 'BAYARAN DITERIMA', 14);
        // CodeMaster::seed('kru_application_status', 15, 'BAYARAN DISAHKAN', 'BAYARAN DISAHKAN', 15);
        // CodeMaster::seed('kru_application_status', 16, 'BAYARAN TIDAK DISAHKAN', 'BAYARAN TIDAK DISAHKAN', 16);
        // CodeMaster::seed('kru_application_status', 17, 'SSD LAMA DITERIMA', 'SSD LAMA DITERIMA', 17);
        // CodeMaster::seed('kru_application_status', 18, 'PERMOHONAN SELESAI', 'PERMOHONAN SELESAI', 18);

        // //kesihatan kru
        // CodeMaster::seed('kru_health', null, 'SIHAT', 'SIHAT', 1);
        // CodeMaster::seed('kru_health', null, 'TIDAK SIHAT SEMENTARA', 'TIDAK SIHAT SEMENTARA', 2);
        // CodeMaster::seed('kru_health', null, 'TIDAK SIHAT KEKAL', 'TIDAK SIHAT KEKAL', 3);
        
        // //item bayaran
        // CodeMaster::seed('payment_item', null, 'GERAN', 'GERAN', 1);
        // CodeMaster::seed('payment_item', null, 'LESEN', 'LESEN', 2);
        // CodeMaster::seed('payment_item', null, 'TINPLATE', 'TINPLATE', 3);
        // CodeMaster::seed('payment_item', null, 'FI PERALATAN', 'FI PERALATAN', 4);
        // CodeMaster::seed('payment_item', null, 'FI VESEL', 'FI VESEL', 5);
        // CodeMaster::seed('payment_item', null, 'PATIL', 'PATIL', 6);
        // CodeMaster::seed('payment_item', null, 'ATF', 'ATF', 7);
        // CodeMaster::seed('payment_item', null, 'DENDA - GERAN', 'DENDA - GERAN', 8);
        // CodeMaster::seed('payment_item', null, 'DENDA - LESEN', 'DENDA - LESEN', 9);
        // CodeMaster::seed('payment_item', null, 'DENDA - KAD NELAYAN', 'DENDA - KAD NELAYAN', 10);
        // CodeMaster::seed('payment_item', null, 'DENDA - TINPLATE', 'DENDA - TINPLATE', 11);
        // //---------------------------Irfan - End---------------------
        

        // 5 - Modul KRU
        // Module::seed('Keseluruhan Permohonan Kru', 'Keseluruhan Permohonan Kru', 'keseluruhanpermohonankru', '/keseluruhanpermohonankru', 'fas fa-edit', 5, true);

        // Module::seed('Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)', 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)', 'kadpendaftarannelayan', '/kadpendaftarannelayan', 'fas fa-edit', 5, true);
        //     Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/kadpendaftarannelayan/permohonan', 0, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
        //     Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/kadpendaftarannelayan/semakandaerah', 1, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
        //     Module::seedChild('Sokongan Daerah', 'Sokongan Daerah', 'sokongandaerah', '/kadpendaftarannelayan/sokongandaerah', 2, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
        //     Module::seedChild('Keputusan Daerah', 'Keputusan Daerah', 'keputusandaerah', '/kadpendaftarannelayan/keputusandaerah', 3, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
        //     Module::seedChild('Sokongan Wilayah', 'Sokongan Wilayah', 'sokonganwilayah', '/kadpendaftarannelayan/sokonganwilayah', 4, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
        //     Module::seedChild('Keputusan Wilayah', 'Keputusan Wilayah', 'keputusanwilayah', '/kadpendaftarannelayan/keputusanwilayah', 5, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
        //     Module::seedChild('Semakan Negeri', 'Semakan Negeri', 'semakannegeri', '/kadpendaftarannelayan/semakannegeri', 6, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
        //     Module::seedChild('Sokongan Negeri', 'Sokongan Negeri', 'sokongannegeri', '/kadpendaftarannelayan/sokongannegeri', 7, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
        //     Module::seedChild('Keputusan Negeri', 'Keputusan Negeri', 'keputusannegeri', '/kadpendaftarannelayan/keputusannegeri', 8, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
        //     Module::seedChild('Terimaan Bayaran', 'Terimaan Bayaran', 'terimaanbayaran', '/kadpendaftarannelayan/terimaanbayaran', 9, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
        //     Module::seedChild('Pengesahan Bayaran', 'Pengesahan Bayaran', 'pengesahanbayaran', '/kadpendaftarannelayan/pengesahanbayaran', 10, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
        //     Module::seedChild('Cetakan Kad', 'Cetakan Kad', 'cetakankad', '/kadpendaftarannelayan/cetakankad', 11, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');

        // Module::seed('Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)', 'Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)', 'pembaharuankadpendaftarannelayan', '/pembaharuankadpendaftarannelayan', 'fas fa-edit', 7, true);
        //     Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/pembaharuankadpendaftarannelayan/permohonan', 0, 'Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/pembaharuankadpendaftarannelayan/semakandaerah', 1, 'Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Keputusan Daerah', 'Keputusan Daerah', 'keputusandaerah', '/pembaharuankadpendaftarannelayan/keputusandaerah', 2, 'Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Terimaan Bayaran', 'Terimaan Bayaran', 'terimaanbayaran', '/pembaharuankadpendaftarannelayan/terimaanbayaran', 4, 'Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Pengesahan Bayaran', 'Pengesahan Bayaran', 'pengesahanbayaran', '/pembaharuankadpendaftarannelayan/pengesahanbayaran', 5, 'Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Cetakan Kad', 'Cetakan Kad', 'cetakankad', '/pembaharuankadpendaftarannelayan/cetakankad', 6, 'Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');

        // Module::seed('Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)', 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)', 'gantiankadpendaftarannelayan', '/gantiankadpendaftarannelayan', 'fas fa-edit', 8, true);
        //     Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/gantiankadpendaftarannelayan/permohonan', 0, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/gantiankadpendaftarannelayan/semakandaerah', 1, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Sokongan Daerah', 'Sokongan Daerah', 'sokongandaerah', '/gantiankadpendaftarannelayan/sokongandaerah', 2, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Sokongan Wilayah', 'Sokongan Wilayah', 'sokonganwilayah', '/gantiankadpendaftarannelayan/sokonganwilayah', 4, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Semakan Negeri', 'Semakan Negeri', 'semakannegeri', '/gantiankadpendaftarannelayan/semakannegeri', 6, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Sokongan Negeri', 'Sokongan Negeri', 'sokongannegeri', '/gantiankadpendaftarannelayan/sokongannegeri', 7, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Keputusan Negeri', 'Keputusan Negeri', 'keputusannegeri', '/gantiankadpendaftarannelayan/keputusannegeri', 8, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Terimaan Bayaran', 'Terimaan Bayaran', 'terimaanbayaran', '/gantiankadpendaftarannelayan/terimaanbayaran', 10, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Pengesahan Bayaran', 'Pengesahan Bayaran', 'pengesahanbayaran', '/gantiankadpendaftarannelayan/pengesahanbayaran', 11, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Cetakan Kad', 'Cetakan Kad', 'cetakankad', '/gantiankadpendaftarannelayan/cetakankad', 12, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');

        // Module::seed('Pembatalan Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)', 'Pembatalan Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)', 'pembatalankadpendaftarannelayan', '/pembatalankadpendaftarannelayan', 'fas fa-edit', 8, true);
        //     Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/pembatalankadpendaftarannelayan/permohonan', 0, 'Pembatalan Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/pembatalankadpendaftarannelayan/semakandaerah', 1, 'Pembatalan Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
        //     Module::seedChild('Keputusan Daerah', 'Keputusan Daerah', 'keputusandaerah', '/pembatalankadpendaftarannelayan/keputusandaerah', 2, 'Pembatalan Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');

        // Module::seed('Kebenaran Penggunaan Kru Asing', 'Kebenaran Penggunaan Kru Asing', 'kebenaranpenggunaankrubukanwarganegara', '/kebenaranpenggunaankrubukanwarganegara', 'fas fa-edit', 11, true);
        //     Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/kebenaranpenggunaankrubukanwarganegara/permohonan', 1, 'Kebenaran Penggunaan Kru Asing');
        //     Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/kebenaranpenggunaankrubukanwarganegara/semakandaerah', 2, 'Kebenaran Penggunaan Kru Asing');
        //     Module::seedChild('Keputusan Daerah', 'Keputusan Daerah', 'keputusandaerah', '/kebenaranpenggunaankrubukanwarganegara/keputusandaerah', 3, 'Kebenaran Penggunaan Kru Asing');

        // Module::seed('Kelulusan Penggunaan Kru Asing', 'Kelulusan Penggunaan Kru Asing', 'kelulusanpenggunaankrubukanwarganegara', '/kelulusanpenggunaankrubukanwarganegara', 'fas fa-edit', 12, true);
        //     Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/kelulusanpenggunaankrubukanwarganegara/permohonan', 1, 'Kelulusan Penggunaan Kru Asing');
        //     Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/kelulusanpenggunaankrubukanwarganegara/semakandaerah', 2, 'Kelulusan Penggunaan Kru Asing');
        //     Module::seedChild('Keputusan Daerah', 'Keputusan Daerah', 'keputusandaerah', '/kelulusanpenggunaankrubukanwarganegara/keputusandaerah', 3, 'Kelulusan Penggunaan Kru Asing');

        // Module::seed('Pembaharuan Kebenaran Penggunaan Kru Asing', 'Pembaharuan Kebenaran Penggunaan Kru Asing', 'pembaharuanpenggunaankrubukanwarganegara', '/pembaharuanpenggunaankrubukanwarganegara', 'fas fa-edit', 13, true);
        //     Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/pembaharuanpenggunaankrubukanwarganegara/permohonan', 1, 'Pembaharuan Kebenaran Penggunaan Kru Asing');
        //     Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/pembaharuanpenggunaankrubukanwarganegara/semakandaerah', 2, 'Pembaharuan Kebenaran Penggunaan Kru Asing');
        //     Module::seedChild('Keputusan Daerah', 'Keputusan Daerah', 'keputusandaerah', '/pembaharuanpenggunaankrubukanwarganegara/keputusandaerah', 3, 'Pembaharuan Kebenaran Penggunaan Kru Asing');

        // Module::seed('Pembatalan Kelulusan Kru Asing', 'Pembatalan Kelulusan Kru Asing', 'pembatalanpenggunaankrubukanwarganegara', '/pembatalanpenggunaankrubukanwarganegara', 'fas fa-edit', 14, true);
        //     Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/pembatalanpenggunaankrubukanwarganegara/permohonan', 1, 'Pembatalan Kelulusan Kru Asing');
        //     Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/pembatalanpenggunaankrubukanwarganegara/semakandaerah', 2, 'Pembatalan Kelulusan Kru Asing');
        //     Module::seedChild('Keputusan Daerah', 'Keputusan Daerah', 'keputusandaerah', '/pembatalanpenggunaankrubukanwarganegara/keputusandaerah', 3, 'Pembatalan Kelulusan Kru Asing');

            
        // $sar = json_encode(['entity_name' => 'Pejabat Perikanan Negeri Sarawak']);
        // //Level 3 - Wilayah
        // Entity::seed($sar,'Wilayah 1','3','01');
        // Entity::seed($sar,'Wilayah 2','3','02');
        // Entity::seed($sar,'Wilayah 3','3','03');
        
        // CodeMaster::seed('kru_application_status', 18, 'PERMOHONAN SELESAI', 'PERMOHONAN SELESAI', 18);
        // Module::seed('Kru', 'Crew', 'crewvessel', '/crewvessel', 'fas fa-id-badge', 5, true);
        
        //kru asing
        // KruApplicationType::seed('KRU05', 'PERMOHONAN KEBENARAN PENGGUNAAN KRU BUKAN WARGANEGARA UNTUK BEKERJA DI ATAS VESEL PENANGKAPAN IKAN TEMPATAN', 5);
        // KruApplicationType::seed('KRU06', 'PERMOHONAN KELULUSAN PENGGUNAAN KRU BUKAN WARGANEGARA UNTUK BEKERJA DI ATAS VESEL PENANGKAPAN IKAN TEMPATAN', 6);
        // KruApplicationType::seed('KRU07', 'PERMOHONAN PEMBAHARUAN PENGGUNAAN KRU BUKAN WARGANEGARA UNTUK BEKERJA DI ATAS VESEL PENANGKAPAN IKAN TEMPATAN', 7);
        // KruApplicationType::seed('KRU08', 'PERMOHONAN PEMBATALAN PENGGUNAAN KRU BUKAN WARGANEGARA UNTUK BEKERJA DI ATAS VESEL PENANGKAPAN IKAN TEMPATAN', 8);
        
        // CodeMaster::seed('immigration_gate', null, 'KLIA', 'KLIA', 1);
        
        // Jawatan - permohonan kru bukan warganegara
        // CodeMaster::seed('foreign_kru_position', 1, 'KAPTEN / TAIKONG', 'KAPTEN / TAIKONG', 1);
        // CodeMaster::seed('foreign_kru_position', 2, 'KRU', 'KRU', 2);
        
        // CodeMaster::seed('source_country', null, 'INDONESIA', 'INDONESIA', 1);
        // CodeMaster::seed('source_country', null, 'BANGLADESH', 'BANGLADESH', 2);
        // CodeMaster::seed('source_country', null, 'THAILAND', 'THAILAND', 3);
        // CodeMaster::seed('source_country', null, 'MYANMAR', 'MYANMAR', 4);
        // CodeMaster::seed('source_country', null, 'KEMBOJA', 'KEMBOJA', 5);
        // CodeMaster::seed('source_country', null, 'LAOS', 'LAOS', 6);
        // CodeMaster::seed('source_country', null, 'VIETNAM', 'VIETNAM', 7);
        // CodeMaster::seed('source_country', null, 'PAKISTAN', 'PAKISTAN', 8);
        // CodeMaster::seed('source_country', null, 'SRI LANKA', 'SRI LANKA', 9);
        // CodeMaster::seed('source_country', null, 'TURKMENISTAN', 'TURKMENISTAN', 10);
        // CodeMaster::seed('source_country', null, 'KAZAKHSTAN', 'KAZAKHSTAN', 11);
        // CodeMaster::seed('source_country', null, 'UZBEKISTAN', 'UZBEKISTAN', 12);
        // CodeMaster::seed('source_country', null, 'INDIA', 'INDIA', 13);
        // CodeMaster::seed('source_country', null, 'NEPAL', 'NEPAL', 14);
        // CodeMaster::seed('source_country', null, 'FILIPINA', 'FILIPINA', 15);

        // // Irfan - Modul Pengisytiharan Pendaratan
        // Module::seed('Pengisytiharan Pendaratan', 'Pengisytiharan Pendaratan', 'landingdeclaration', '/landingdeclaration', 'fas fa-edit', 51, true);
        //     Module::seedChild('Permohonan', 'Application', 'landingdeclarationapplication', '/landingdeclaration/application', 1, 'Pengisytiharan Pendaratan');  
        //     Module::seedChild('Semakan Pendaratan', 'Landing Check', 'landingdeclarationcheck', '/landingdeclaration/check', 2, 'Pengisytiharan Pendaratan');  
        //     Module::seedChild('Pengesahan Pendaratan', 'Landing Confirmation', 'landingdeclarationconfirmation', '/landingdeclaration/confirmation', 3, 'Pengisytiharan Pendaratan'); 
        
        // // 5/2 Arifah 51 - Modul ESH
        // Module::seed('Permohonan ESHND', 'Subsistence Allowance', 'subsistence-allowance', '/subsistence-allowance', 'fas fa-ship', 52, true);
        //     Module::seedChild('Permohonan', 'Application', 'application', '/subsistence-allowance/application', 1, 'Permohonan ESHND');
        //     Module::seedChild('Senarai Permohonan', 'List Application', 'list-application', '/subsistence-allowance/list-application', 2, 'Permohonan ESHND');
        //     Module::seedChild('Semakan KDP', 'KDP Review', 'kdp-review', '/subsistence-allowance/kdp-review', 3, 'Permohonan ESHND');
        //     Module::seedChild('Jana Nama Negeri', 'Genarate Name State', 'generate-name-state', '/subsistence-allowance/generate-name-state', 4, 'Permohonan ESHND'); 
        //     Module::seedChild('Jana Nama HQ', 'Generate Name HQ', 'generate-name-hq', '/subsistence-allowance/generate-name-hq', 5, 'Permohonan ESHND');

        // // 12/3 Arifah 52 - Modul Pembaharuan ESH
        // Module::seed('Pembaharuan ESHND', 'Subsistence Allowance Renewal', 'subsistence-allowance-renewal', '/subsistence-allowance-renewal', 'fas fa-ship', 53, true);
        //     Module::seedChild('Permohonan Pembaharuan', 'Application Renewal', 'application-renewal', '/subsistence-allowance-renewal/application-renewal', 1, 'Pembaharuan ESHND');
        //     Module::seedChild('Senarai Pembaharuan', 'List Renewal', 'list-renewal', '/subsistence-allowance-renewal/list-renewal', 2, 'Pembaharuan ESHND');
        //     Module::seedChild('Sokongan Pembaharuan', 'Supported Renewal', 'supported_renewal', '/subsistence-allowance-renewal/supported-renewal', 3, 'Pembaharuan ESHND');
        //     Module::seedChild('Jana Nama Negeri', 'Genarate Name State', 'generate-name-state', '/subsistence-allowance-renewal/generate-name-state', 4, 'Pembaharuan ESHND'); 
        //     Module::seedChild('Jana Nama HQ', 'Generate Name HQ', 'generate-name-hq', '/subsistence-allowance-renewal/generate-name-hq', 5, 'Pembaharuan ESHND');

        // ===================  ELAUN SARA DIRI - ARIFAH  =================
        // CodeMaster::seed('bank', '01', 'BANK ISLAM MALAYSIA BERHAD', 'BANK ISLAM MALAYSIA BERHAD', 1);
        // CodeMaster::seed('bank', '02', 'BANK RAKYAT', 'BANK RAKYAT', 1);
        // CodeMaster::seed('bank', '03', 'CIMB BANK', 'CIMB BANK', 2);
        // CodeMaster::seed('bank', '04', 'MAYBANK', 'MAYBANK', 3);
        // =================  ELAUN SARA DIRI - ARIFAH  ===============
        
        // ===================  ND-PPD-01 LANDING - IRFAN  =================
        // CodeMaster::seed('landing_status', null, 'DISIMPAN', 'DISIMPAN', 1);
        // CodeMaster::seed('landing_status', null, 'DIHANTAR', 'DIHANTAR', 2);
        // CodeMaster::seed('landing_status', null, 'TIDAK LENGKAP', 'TIDAK LENGKAP', 3);
        // CodeMaster::seed('landing_status', null, 'DISOKONG DAERAH', 'DISOKONG DAERAH', 4);
        // CodeMaster::seed('landing_status', null, 'TIDAK DISOKONG DAERAH', 'TIDAK DISOKONG DAERAH', 5);
        // CodeMaster::seed('landing_status', null, 'DISAHKAN DAERAH', 'DISAHKAN DAERAH', 6);
        // CodeMaster::seed('landing_status', null, 'TIDAK DISAHKAN DAERAH', 'TIDAK DISAHKAN DAERAH', 7);
        // ===================  ND-PPD-01 LANDING - IRFAN  ===============

        
    //    CodeMaster::seed('application_status', 801, 'SEMAKAN DOKUMEN', 'DIHANTAR', 801);
    //    CodeMaster::seed('application_status', 802, 'TIDAK LENGKAP', 'SEMAKAN DOKUMEN', 802);
    //    CodeMaster::seed('application_status', 803, 'PINDA/SAH TARIKH PEMERIKSAAN', 'SEMAKAN DOKUMEN', 803);
    //    CodeMaster::seed('application_status', 804, 'PEMERIKSAAN LPI', 'PINDAH/SAHKAN PEMERIKSAAN VESEL', 804);
    //    CodeMaster::seed('application_status', 805, 'LAPORAN LPI', 'PINDA LPI', 805);
    //    CodeMaster::seed('application_status', 806, 'SOKONGAN ULASAN', 'LAPORAN LPI', 806);
    //    CodeMaster::seed('application_status', 807, 'TIDAK LENGKAP', 'SOKONGAN ULASAN', 807);
    //    CodeMaster::seed('application_status', 808, 'SEMAKAN ULASAN', 'SOKONGAN ULASAN', 808);
    //    CodeMaster::seed('application_status', 809, 'TIDAK LENGKAP', 'SEMAKAN ULASAN', 809);
    //    CodeMaster::seed('application_status', 810, 'SOKONGAN ULASAN', 'SEMAKAN ULASAN', 810);
    //    CodeMaster::seed('application_status', 811, 'TIDAK LENGKAP', 'SOKONGAN ULASAN', 811);
    //    CodeMaster::seed('application_status', 812, 'KEPUTUSAN', 'SOKONGAN ULASAN', 812);
    //    CodeMaster::seed('application_status', 813, 'TIDAK LENGKAP', 'KEPUTUSAN', 813);

    //    CodeMaster::seed('application_status', 815, 'TIDAK LULUS', 'KEPUTUSAN', 815);
    //    CodeMaster::seed('application_status', 816, 'RESIT BAYARAN', 'KEPUTUSAN', 816);
    //    CodeMaster::seed('application_status', 817, 'SEMAKAN BAYARAN', 'RESIT BAYARAN', 817);
    //    CodeMaster::seed('application_status', 818, 'TIDAK LENGKAP', 'SEMAKAN BAYARAN', 818);
    //    CodeMaster::seed('application_status', 819, 'CETAK LESEN', 'SEMAKAN BAYARAN', 819);
    //    CodeMaster::seed('application_status', 820, 'DILULUSKAN', 'DILULUSKAN', 820);
       
    //     CodeMaster::seed('application_status', 901, 'SEMAKAN DOKUMEN', 'DIHANTAR', 901);
    //     CodeMaster::seed('application_status', 902, 'TIDAK LENGKAP', 'SEMAKAN DOKUMEN', 902);
    //     CodeMaster::seed('application_status', 903, 'SAH/PINDA TARIKH LPI', 'SEMAKAN DOKUMEN', 903);
    //     CodeMaster::seed('application_status', 904, 'LAPORAN LPI', 'SAH/PINDA TARIKH LPI', 904);
    //     CodeMaster::seed('application_status', 905, 'KEPUTUSAN', 'LAPORAN LPI', 905);
    //     CodeMaster::seed('application_status', 906, 'TIDAK LENGKAP', 'KEPUTUSAN', 906);
    //     CodeMaster::seed('application_status', 907, 'TIDAK LULUS', 'KEPUTUSAN', 907);
    //     CodeMaster::seed('application_status', 908, 'RESIT PEMBAYARAN', 'KEPUTUSAN', 908);
    //     CodeMaster::seed('application_status', 909, 'SEMAKAN PEMBAYARAN', 'RESIT PEMBAYARAN', 909);
    //     CodeMaster::seed('application_status', 910, 'SEMAKAN PEMBAYARAN', 'RESIT PEMBAYARAN', 910);
    //     CodeMaster::seed('application_status', 911, 'TIDAK LENGKAP', 'SEMAKAN PEMBAYARAN', 911);
    //     CodeMaster::seed('application_status', 912, 'CETAK LESEN', 'SEMAKAN PEMBAYARAN', 912);
    //     CodeMaster::seed('application_status', 913, 'DILULUSKAN', 'DILULUSKAN', 913);

    //     CodeMaster::seed('application_status', 915, 'SOKONGAN ULASAN RAYUAN', 'SEMAKAN DOKUMEN', 915);
    //     CodeMaster::seed('application_status', 916, 'SEMAKAN ULASAN RAYUAN', 'SOKONGAN ULASAN RAYUAN', 916);
    //     CodeMaster::seed('application_status', 917, 'KEPUTUSAN RAYUAN', 'SEMAKAN ULASAN RAYUAN', 917);
    //     CodeMaster::seed('application_status', 918, 'TIDAK LENGKAP', 'KEPUTUSAN RAYUAN', 918);
    //     CodeMaster::seed('application_status', 919, 'TIDAK LULUS', 'KEPUTUSAN RAYUAN', 919);
    //     CodeMaster::seed('application_status', 920, 'RESIT PEMBAYARAN', 'KEPUTUSAN RAYUAN', 920);
    //     CodeMaster::seed('application_status', 921, 'KEPUTUSAN', 'SEMAKAN DOKUMEN', 921);

        // $this->seedUser('800000000001','FA HQ');
        // $this->seedUser('800100000001','FAD HQ');
        // $this->seedUser('800000000002','PBKP');

        // $this->seedUser('901100000001','PEMOHON DARAT BATU PAHAT');
        // $this->seedUser('901100000002','FAD BATU PAHAT');
        // $this->seedUser('901000000003','KDP BATU PAHAT');
        // $this->seedUser('901100000005','FAD JOHOR');
        // $this->seedUser('901000000006','KCSPT JOHOR');
        // $this->seedUser('901000000007','PPN JOHOR');
        
        // $this->seedUser('902100000001','PEMOHON DARAT BALING');
        // $this->seedUser('902100000002','FAD BALING');
        // $this->seedUser('902000000003','KDP BALING');
        // $this->seedUser('902100000005','FAD KEDAH');
        // $this->seedUser('902000000006','KCSPT KEDAH');
        // $this->seedUser('902000000007','PPN KEDAH');
        
        // $this->seedUser('903100000001','PEMOHON DARAT BACHOK');
        // $this->seedUser('903100000002','FAD BACHOK');
        // $this->seedUser('903000000003','KDP BACHOK');
        // $this->seedUser('903100000005','FAD KELANTAN');
        // $this->seedUser('903000000006','KCSPT KELANTAN');
        // $this->seedUser('903000000007','PPN KELANTAN');
        
        // $this->seedUser('904100000001','PEMOHON DARAT ALOR GAJAH');
        // $this->seedUser('904100000002','FAD ALOR GAJAH');
        // $this->seedUser('904000000003','KDP ALOR GAJAH');
        // $this->seedUser('904100000005','FAD MELAKA');
        // $this->seedUser('904000000006','KCSPT MELAKA');
        // $this->seedUser('904000000007','PPN MELAKA');
        
        // $this->seedUser('905100000001','PEMOHON DARAT JELEBU');
        // $this->seedUser('905100000002','FAD JELEBU');
        // $this->seedUser('905000000003','KDP JELEBU');
        // $this->seedUser('905100000005','FAD NEGERI SEMBILAN');
        // $this->seedUser('905000000006','KCSPT NEGERI SEMBILAN');
        // $this->seedUser('905000000007','PPN NEGERI SEMBILAN');
        
        // $this->seedUser('906100000001','PEMOHON DARAT BENTONG');
        // $this->seedUser('906100000002','FAD BENTONG');
        // $this->seedUser('906000000003','KDP BENTONG');
        // $this->seedUser('906100000005','FAD PAHANG');
        // $this->seedUser('906000000006','KCSPT PAHANG');
        // $this->seedUser('906000000007','PPN PAHANG');
        
        // $this->seedUser('907100000001','PEMOHON DARAT BARAT DAYA/TIMUR LAUT');
        // $this->seedUser('907100000002','FAD BARAT DAYA/TIMUR LAUT');
        // $this->seedUser('907000000003','KDP BARAT DAYA/TIMUR LAUT');
        // $this->seedUser('907100000005','FAD PULAU PINANG');
        // $this->seedUser('907000000006','KCSPT PULAU PINANG');
        // $this->seedUser('907000000007','PPN PULAU PINANG');
        
        // $this->seedUser('908100000001','PEMOHON DARAT BAGAN DATUK');
        // $this->seedUser('908100000002','FAD BAGAN DATUK');
        // $this->seedUser('908000000003','KDP BAGAN DATUK');
        // $this->seedUser('908100000005','FAD PERAK');
        // $this->seedUser('908000000006','KCSPT PERAK');
        // $this->seedUser('908000000007','PPN PERAK');
        
        // $this->seedUser('910100000001','PEMOHON DARAT GOMBAK');
        // $this->seedUser('910100000002','FAD GOMBAK');
        // $this->seedUser('910000000003','KDP GOMBAK');
        // $this->seedUser('910100000005','FAD SELANGOR');
        // $this->seedUser('910000000006','KCSPT SELANGOR');
        // $this->seedUser('910000000007','PPN SELANGOR');
        
        // $this->seedUser('911100000001','PEMOHON DARAT BESUT');
        // $this->seedUser('911100000002','FAD BESUT');
        // $this->seedUser('911000000003','KDP BESUT');
        // $this->seedUser('911100000005','FAD TERENGGANU');
        // $this->seedUser('911000000006','KCSPT TERENGGANU');
        // $this->seedUser('911000000007','PPN TERENGGANU');

        // $this->seedUser('909100000001','PEMOHON DARAT PERLIS');
        // $this->seedUser('909100000002','FAD PERLIS');
        // $this->seedUser('909000000003','KDP PERLIS');
        // $this->seedUser('909100000005','FAD PERLIS');
        // $this->seedUser('909000000006','KCSPT PERLIS');
        // $this->seedUser('909000000007','PPN PERLIS');

        // // Irfan - Modul Pembayaran ESH
        // Module::seed('Pembayaran ESHND', 'Subsistence Allowance Payment', 'subsistenceallowancepayment', '/subsistenceallowancepayment', 'fas fa-edit', 54, true);
        //     Module::seedChild('Jana Nama Daerah', 'Generate Name District', 'generatenamedistrict', '/subsistenceallowancepayment/generatenamedistrict', 1, 'Pembayaran ESHND');  
        //     Module::seedChild('Sokongan Daerah', 'Support District', 'supportdistrict', '/subsistenceallowancepayment/supportdistrict', 2, 'Pembayaran ESHND');  
        //     Module::seedChild('Jana Nama Negeri', 'Generate Name State', 'generatenamenstate', '/subsistenceallowancepayment/generatenamestate', 3, 'Pembayaran ESHND');  
        //     Module::seedChild('Kelulusan Negeri', 'Approval State', 'approvalstate', '/subsistenceallowancepayment/approvalstate', 4, 'Pembayaran ESHND');  
        //     Module::seedChild('Jana Nama Hq', 'Generate Name Hq', 'generatenamehq', '/subsistenceallowancepayment/generatenamehq', 5, 'Pembayaran ESHND');  
        //     Module::seedChild('Jana Peruntukan', 'Generate Allocation', 'generateallocation', '/subsistenceallowancepayment/generateallocation', 6, 'Pembayaran ESHND'); 
        //     Module::seedChild('Keputusan Bayaran', 'Payment Outcome', 'paymentoutcome', '/subsistenceallowancepayment/paymentoutcome', 7, 'Pembayaran ESHND');  
        
        // // 13/3 Qistina 52 - Modul Permohonan Lucut Hak
        // Module::seed('Permohonan Lucut Hak ESHND', 'Confiscation Application', 'confiscation', '/confiscation', 'fas fa-edit', 55, true);
        //     Module::seedChild('Permohonan', 'Application', 'update-application', '/confiscation/update-application', 1, 'Permohonan Lucut Hak ESHND');  
        //     Module::seedChild('Senarai Permohonan', 'Application List', 'support-application', '/confiscation/support-application', 2, 'Permohonan Lucut Hak ESHND');  
        //     Module::seedChild('Senarai Nama', 'Name List', 'name-list', '/confiscation/name-list', 3, 'Permohonan Lucut Hak ESHND');

        
		// $prls  = json_encode(['type' => 'state', 'name' => 'Perlis']);
		// District::seed('district', '01', 'Perlis', 'Perlis', null, $prls);
        // ===================  ESH-04 LUCUT HAK - IRFAN  =================
        // CodeMaster::seed('confiscation_reason', null, 'SIJIL KEMATIAN', 'SIJIL KEMATIAN', 1);
        // CodeMaster::seed('confiscation_reason', null, 'SURAT KELUAR INDUSTRI', 'SURAT KELUAR INDUSTRI', 2);
        // CodeMaster::seed('confiscation_reason', null, 'SURAT PERINTAH MAHKAMAH', 'SURAT PERINTAH MAHKAMAH', 3);
        // CodeMaster::seed('confiscation_reason', null, 'SURAT TARIK DIRI', 'SURAT TARIK DIRI', 4);
        // CodeMaster::seed('confiscation_reason', null, 'SURAT HOSPITAL', 'SURAT HOSPITAL', 5);
        // ===================  ESH-04 LUCUT HAK - IRFAN  ===============
        
        // Module::seedChild('Cetakan Surat', 'Cetakan Surat', 'cetakansurat', '/kebenaranpenggunaankrubukanwarganegara/cetakansurat', 4, 'Kebenaran Penggunaan Kru Asing');
        // Module::seedChild('Cetakan Surat', 'Cetakan Surat', 'cetakansurat', '/pembaharuanpenggunaankrubukanwarganegara/cetakansurat', 4, 'Pembaharuan Kebenaran Penggunaan Kru Asing');
        
        // Bumiputera - permohonan kad pendaftaran nelayan
        // CodeMaster::seed('bumiputera_status', 1, 'BUMIPUTERA', 'BUMIPUTERA', 1);
        // CodeMaster::seed('bumiputera_status', 2, 'BUKAN BUMIPUTERA', 'BUKAN BUMIPUTERA', 2);
        
        // // Kewarganegaraan - permohonan kad pendaftaran nelayan
        // CodeMaster::seed('kewarganegaraan_status', 1, 'WARGANEGARA', 'WARGANEGARA', 1);
        // CodeMaster::seed('kewarganegaraan_status', 2, 'PEMASTAUTIN TETAP', 'PEMASTAUTIN TETAP', 2);
        
        // CodeMaster::seed('payment_item', null, 'KAD NELAYAN', 'KAD NELAYAN', 1);
        // CodeMaster::seed('payment_item', null, 'FI PATIL', 'FI PATIL', 5);
        // CodeMaster::seed('payment_item', null, 'PATIL KEKAL', 'PATIL KEKAL', 6);
        // CodeMaster::seed('payment_item', null, 'SISTEM KULTUR LAUT', 'SISTEM KULTUR LAUT', 7);
        // CodeMaster::seed('payment_item', null, 'DENDA - LESEN', 'DENDA - PATIL KEKAL', 12);
        
        // CodeMaster::seed('kru_position', 3, 'TAIKONG', 'TAIKONG', 3);
        CodeMaster::seed('bumiputera_status', 3, 'TIADA', 'TIADA', 3);
    }

    // public function seedUser($username,$name){
    //     $user = new User();
    //     $user->name = $name;
    //     $user->username = $username;
    //     $user->email = 'email@email.com';
    //     $user->email_verified_at = Carbon::now();
    //     $user->password = '$2y$10$lt9/qQhSziALZaQxUdZMDubZxkT1m6vH7OtsENR1OWNjRjGduaax.';//Pass@1234567
    //     $user->is_active = true;
    //     $user->is_admin = false;
    //     $user->save();
    // }
}