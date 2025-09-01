<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\CodeMaster as CodeMaster;

class CodeMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
			// race
        CodeMaster::seed('race', 1, 'MELAYU', 'MELAYU', 1);
        CodeMaster::seed('race', 2, 'CINA', 'CINA', 2);
        CodeMaster::seed('race', 3, 'INDIA', 'INDIA', 3);
        CodeMaster::seed('race', 4, 'LAIN-LAIN', 'LAIN-LAIN', 4);

        // citizen
        CodeMaster::seed('citizenship', null, 'WARGANEGARA', 'WARGANEGARA', 1);
        CodeMaster::seed('citizenship', null, 'BUKAN WARGANEGARA', 'BUKAN WARGANEGARA', 2);

        // gender
        CodeMaster::seed('gender', 1, 'LELAKI', 'LELAKI', 1);
        CodeMaster::seed('gender', 2, 'PEREMPUAN', 'PEREMPUAN', 2);

        // month
        CodeMaster::seed('month','Jan', 'JANUARI', 'JANUARI', 1);
        CodeMaster::seed('month','Feb', 'FEBRUARI', 'FEBRUARI', 2);
        CodeMaster::seed('month','Mac', 'MAC', 'MAC', 3);
        CodeMaster::seed('month','Apr', 'APRIL', 'APRIL', 4);
        CodeMaster::seed('month','Mei', 'MEI', 'MEI', 5);
        CodeMaster::seed('month','Jun', 'JUN', 'JUN', 6);
        CodeMaster::seed('month','Jul', 'JULAI', 'JULAI', 7);
        CodeMaster::seed('month','Ogs', 'OGOS', 'OGOS', 8);
        CodeMaster::seed('month','Sep', 'SEPTEMBER', 'SEPTEMBER', 9);
        CodeMaster::seed('month','Okt', 'OKTOBER', 'OKTOBER', 10);
        CodeMaster::seed('month','Nov', 'NOVEMBER', 'NOVEMBER', 11);
        CodeMaster::seed('month','Dis', 'DISEMBER', 'DISEMBER', 12);

        // Jenis Daftar Pengguna
        CodeMaster::seed('user_type', 1, 'PEMOHON LESEN VESEL (NELAYAN LAUT)', 'PEMOHON LESEN VESEL (NELAYAN LAUT)', 1);
        CodeMaster::seed('user_type', 2, 'PEMOHON LESEN VESEL (NELAYAN DARAT)', 'PEMOHON LESEN VESEL (NELAYAN DARAT)', 2);
        CodeMaster::seed('user_type', 3, 'PENGUSAHA SKL', 'PENGUSAHA SKL', 3);
        CodeMaster::seed('user_type', 4, 'PENTADBIR HARTA', 'PENTADBIR HARTA', 4);
        CodeMaster::seed('user_type', 5, 'PENGURUS VESEL', 'PENGURUS VESEL', 5);
        CodeMaster::seed('user_type', 6, 'PEWARIS', 'PEWARIS', 6);

        // Status Pelantikan Watikah
        CodeMaster::seed('watikah_status', 1, 'DIHANTAR', 'DIHANTAR', 1);
        CodeMaster::seed('watikah_status', 2, 'DITOLAK', 'DITOLAK', 2);
        CodeMaster::seed('watikah_status', 3, 'DILULUS', 'DILULUS', 3);

        // Status perkahwinan
        CodeMaster::seed('marital_status', 1, 'BUJANG', 'BUJANG', 1);
        CodeMaster::seed('marital_status', 2, 'BERKAHWIN', 'BERKAHWIN', 2);
        CodeMaster::seed('marital_status', 3, 'CERAI', 'CERAI', 3);
        CodeMaster::seed('marital_status', 4, 'KEMATIAN PASANGAN', 'KEMATIAN PASANGAN', 4);
        
        //Agama
        CodeMaster::seed('religion', 1, 'ISLAM', 'ISLAM', 1);
        CodeMaster::seed('religion', 2, 'KRISTIAN', 'KRISTIAN', 2);
        CodeMaster::seed('religion', 3, 'HINDU', 'HINDU', 3);
        CodeMaster::seed('religion', 4, 'BUDHHA', 'BUDHHA', 4);
        CodeMaster::seed('religion', 5, 'LAIN-LAIN', 'LAIN-LAIN', 5);

        // Jenis Industri
        CodeMaster::seed('jenis_industri', 1, 'PEMPROSESAN', 'PEMPROSESAN', 1);
        CodeMaster::seed('jenis_industri', 2, 'LIMBUNGAN', 'LIMBUNGAN', 2);
        CodeMaster::seed('jenis_industri', 3, 'KILANG AIS', 'KILANG AIS', 3);
        CodeMaster::seed('jenis_industri', 4, 'BILIK SEJUK', 'BILIK SEJUK', 4);
        CodeMaster::seed('jenis_industri', 5, 'PEMBORONG PERIKANAN', 'PEMBORONG PERIKANAN', 5);
        CodeMaster::seed('jenis_industri', 6, 'PERUNCITAN PERIKANAN', 'PERUNCITAN PERIKANAN', 6);
        CodeMaster::seed('jenis_industri', 7, 'LAIN-LAIN', 'LAIN-LAIN', 7);

        // Jenis Pemilikan
        CodeMaster::seed('pemilikan_syarikat', 1, 'MILIKAN TUNGGAL', 'MILIKAN TUNGGAL', 1);
        CodeMaster::seed('pemilikan_syarikat', 2, 'PERKONGSIAN', 'PERKONGSIAN', 2);
        CodeMaster::seed('pemilikan_syarikat', 3, 'KOPERASI', 'KOPERASI', 3);
        CodeMaster::seed('pemilikan_syarikat', 4, 'SENDIRIAN BERHAD', 'SENDIRIAN BERHAD', 4);
        
        //---------------------------Irfan - Start---------------------------
        // Jawatan - permohonan kad pendaftaran nelayan
        CodeMaster::seed('kru_position', 1, 'PEMILIK VESEL', 'PEMILIK VESEL', 1);
        CodeMaster::seed('kru_position', 2, 'KRU', 'KRU', 2);
        CodeMaster::seed('kru_position', 3, 'TAIKONG', 'TAIKONG', 3);
        
        // Jawatan - permohonan kru bukan warganegara
        CodeMaster::seed('foreign_kru_position', 1, 'NAHKODA / TAIKONG', 'NAHKODA / TAIKONG', 1);
        CodeMaster::seed('foreign_kru_position', 2, 'KRU', 'KRU', 2);
        
        // Bumiputera - permohonan kad pendaftaran nelayan
        CodeMaster::seed('bumiputera_status', 1, 'BUMIPUTERA', 'BUMIPUTERA', 1);
        CodeMaster::seed('bumiputera_status', 2, 'BUKAN BUMIPUTERA', 'BUKAN BUMIPUTERA', 2);
        CodeMaster::seed('bumiputera_status', 3, 'TIADA', 'TIADA', 3);
        
        // Kewarganegaraan - permohonan kad pendaftaran nelayan
        CodeMaster::seed('kewarganegaraan_status', 1, 'WARGANEGARA', 'WARGANEGARA', 1);
        CodeMaster::seed('kewarganegaraan_status', 2, 'PEMASTAUTIN TETAP', 'PEMASTAUTIN TETAP', 2);

        // peralatan
        CodeMaster::seed('peralatan', null, 'PUKAT TUNDA', 'PUKAT TUNDA', 1);
        CodeMaster::seed('peralatan', null, 'PUKAT JERUT', 'PUKAT JERUT', 2);
        CodeMaster::seed('peralatan', null, 'PUKAT HANYUT', 'PUKAT HANYUT', 3);
        CodeMaster::seed('peralatan', null, 'RAWAI', 'RAWAI', 4);
        CodeMaster::seed('peralatan', null, 'BUBU', 'BUBU', 5);
        
        //status permohonan kru
        CodeMaster::seed('kru_application_status', 1, 'DISIMPAN', 'DISIMPAN', 1);
        CodeMaster::seed('kru_application_status', 2, 'DIHANTAR', 'DIHANTAR', 2);
        CodeMaster::seed('kru_application_status', 3, 'DISEMAK DAERAH', 'DISEMAK DAERAH', 3);
        CodeMaster::seed('kru_application_status', 4, 'DISOKONG DAERAH', 'DISOKONG DAERAH', 4);
        CodeMaster::seed('kru_application_status', 5, 'DISOKONG WILAYAH', 'DISOKONG WILAYAH', 5);
        CodeMaster::seed('kru_application_status', 6, 'DISEMAK NEGERI', 'DISEMAK NEGERI', 6);
        CodeMaster::seed('kru_application_status', 7, 'DISOKONG NEGERI', 'DISOKONG NEGERI', 7);
        CodeMaster::seed('kru_application_status', 8, 'DITOLAK', 'DITOLAK', 8);
        CodeMaster::seed('kru_application_status', 9, 'DILULUS', 'DILULUS', 9);
        CodeMaster::seed('kru_application_status', 10, 'TIDAK LENGKAP', 'TIDAK LENGKAP', 10);
        CodeMaster::seed('kru_application_status', 11, 'TIDAK DISOKONG DAERAH', 'TIDAK DISOKONG DAERAH', 11);
        CodeMaster::seed('kru_application_status', 12, 'TIDAK DISOKONG WILAYAH', 'TIDAK DISOKONG WILAYAH', 12);
        CodeMaster::seed('kru_application_status', 13, 'TIDAK DISOKONG NEGERI', 'TIDAK DISOKONG NEGERI', 13);
        CodeMaster::seed('kru_application_status', 14, 'BAYARAN DITERIMA', 'BAYARAN DITERIMA', 14);
        CodeMaster::seed('kru_application_status', 15, 'BAYARAN DISAHKAN', 'BAYARAN DISAHKAN', 15);
        CodeMaster::seed('kru_application_status', 16, 'BAYARAN TIDAK DISAHKAN', 'BAYARAN TIDAK DISAHKAN', 16);

        // kesihatan kru
        CodeMaster::seed('kru_health', null, 'SIHAT', 'SIHAT', 1);
        CodeMaster::seed('kru_health', null, 'TIDAK SIHAT SEMENTARA', 'TIDAK SIHAT SEMENTARA', 2);
        CodeMaster::seed('kru_health', null, 'TIDAK SIHAT KEKAL', 'TIDAK SIHAT KEKAL', 3);
        
        // item bayaran
        CodeMaster::seed('payment_item', null, 'GERAN', 'GERAN', 1);
        CodeMaster::seed('payment_item', null, 'LESEN', 'LESEN', 2);
        CodeMaster::seed('payment_item', null, 'TINPLATE', 'TINPLATE', 3);
        CodeMaster::seed('payment_item', null, 'FI PERALATAN', 'FI PERALATAN', 4);
        CodeMaster::seed('payment_item', null, 'FI VESEL', 'FI VESEL', 5);
        CodeMaster::seed('payment_item', null, 'PATIL', 'PATIL', 6);
        CodeMaster::seed('payment_item', null, 'ATF', 'ATF', 7);
        CodeMaster::seed('payment_item', null, 'DENDA - GERAN', 'DENDA - GERAN', 8);
        CodeMaster::seed('payment_item', null, 'DENDA - LESEN', 'DENDA - LESEN', 9);
        CodeMaster::seed('payment_item', null, 'DENDA - KAD NELAYAN', 'DENDA - KAD NELAYAN', 10);
        CodeMaster::seed('payment_item', null, 'DENDA - TINPLATE', 'DENDA - TINPLATE', 11);
        
        //---------------------------Irfan - End---------------------

        // ===================  ELAUN SARA DIRI - ARIFAH  =================
        CodeMaster::seed('bank', '01', 'BANK ISLAM MALAYSIA BERHAD', 'BANK ISLAM MALAYSIA BERHAD', 1);
        CodeMaster::seed('bank', '02', 'BANK RAKYAT', 'BANK RAKYAT', 1);
        CodeMaster::seed('bank', '03', 'CIMB BANK', 'CIMB BANK', 2);
        CodeMaster::seed('bank', '04', 'MAYBANK', 'MAYBANK', 3);
        // =================  ELAUN SARA DIRI - ARIFAH  ===============
        
        // ===================  ND-PPD-01 LANDING - IRFAN  =================
        CodeMaster::seed('landing_status', null, 'DISIMPAN', 'DISIMPAN', 1);
        CodeMaster::seed('landing_status', null, 'DIHANTAR', 'DIHANTAR', 2);
        CodeMaster::seed('landing_status', null, 'TIDAK LENGKAP', 'TIDAK LENGKAP', 3);
        CodeMaster::seed('landing_status', null, 'DISOKONG DAERAH', 'DISOKONG DAERAH', 4);
        CodeMaster::seed('landing_status', null, 'TIDAK DISOKONG DAERAH', 'TIDAK DISOKONG DAERAH', 5);
        CodeMaster::seed('landing_status', null, 'DISAHKAN DAERAH', 'DISAHKAN DAERAH', 6);
        CodeMaster::seed('landing_status', null, 'TIDAK DISAHKAN DAERAH', 'TIDAK DISAHKAN DAERAH', 7);
        // ===================  ND-PPD-01 LANDING - IRFAN  ===============

      //    Faris   ===============================================================
      
           // // Jenis Fisherman
        // CodeMaster::seed('fisherman_type', 1, 'TULEN (Berlesen)', 'PURE (Licensed)', 1);
        // CodeMaster::seed('fisherman_type', 2, 'TULEN (Tidak Berlesen)', 'PURE (Un-Licensed)', 1);
        // CodeMaster::seed('fisherman_type', 3, 'SAMBILAN (Berlesen)', 'PART-TIME (Licensed)', 2);
        // CodeMaster::seed('fisherman_type', 4, 'SAMBILAN (Tidak Berlesen)', 'PART-TIME (Un-Licensed)', 2);

        // JENAMA ENJIN VESEL
        // CodeMaster::seed('engine_brand', null, 'CUMMINS', 'CUMMINS', 1);
        // CodeMaster::seed('engine_brand', null, 'NISSAN', 'NISSAN', 2);
        // CodeMaster::seed('engine_brand', null, 'HINO', 'HINO', 3);
        // CodeMaster::seed('engine_brand', null, 'MITSUBISHI', 'MITSUBISHI', 4);
        // CodeMaster::seed('engine_brand', null, 'WEICHAI', 'WEICHAI', 5);
        // CodeMaster::seed('engine_brand', null, 'YANMAR', 'YANMAR', 6);


        

      //    Faris   ===============================================================
    }
}