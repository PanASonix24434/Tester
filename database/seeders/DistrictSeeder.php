<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CodeMaster as District;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
		$jhr   = json_encode(['type' => 'state', 'name' => 'Johor']);
		$kdh   = json_encode(['type' => 'state', 'name' => 'Kedah']);
		$kltn  = json_encode(['type' => 'state', 'name' => 'Kelantan']);
		$mlc   = json_encode(['type' => 'state', 'name' => 'Melaka']);
		$ngr9  = json_encode(['type' => 'state', 'name' => 'Negeri Sembilan']);		
		$phg   = json_encode(['type' => 'state', 'name' => 'Pahang']);
		$png   = json_encode(['type' => 'state', 'name' => 'Pulau Pinang']);
		$prk   = json_encode(['type' => 'state', 'name' => 'Perak']);
		$prls  = json_encode(['type' => 'state', 'name' => 'Perlis']);
		$slngr = json_encode(['type' => 'state', 'name' => 'Selangor']);
		$trggn = json_encode(['type' => 'state', 'name' => 'Terengganu']);
		$sbh   = json_encode(['type' => 'state', 'name' => 'Sabah']);
		$srwk  = json_encode(['type' => 'state', 'name' => 'Sarawak']);
		$kl    = json_encode(['type' => 'state', 'name' => 'WP Kuala Lumpur']);
		$lbn   = json_encode(['type' => 'state', 'name' => 'WP Labuan']);
		$pj    = json_encode(['type' => 'state', 'name' => 'WP Putrajaya']);
			
		// johor
		District::seed('district', '01', 'Batu Pahat', 'Batu Pahat', null, $jhr);
		District::seed('district', '02', 'Johor Bahru', 'Johor Bahru', null, $jhr);
		District::seed('district', '03', 'Kluang', 'Kluang', null, $jhr);
		District::seed('district', '04', 'Kota Tinggi', 'Kota Tinggi', null, $jhr);
		District::seed('district', '05', 'Mersing', 'Mersing', null, $jhr);
		District::seed('district', '06', 'Muar', 'Muar', null, $jhr);
		District::seed('district', '07', 'Pontian', 'Pontian', null, $jhr);
		District::seed('district', '08', 'Segamat', 'Segamat', null, $jhr);
		District::seed('district', '21', 'Kulai', 'Kulai', null, $jhr);
		District::seed('district', '22', 'Tangkak', 'Tangkak', null, $jhr);
		
		// kedah
		District::seed('district', '01', 'Kota Setar', 'Kota Setar', null, $kdh);
		District::seed('district', '02', 'Kubang Pasu', 'Kubang Pasu', null, $kdh);
		District::seed('district', '03', 'Padang Terap', 'Padang Terap', null, $kdh);
		District::seed('district', '04', 'Langkawi', 'Langkawi', null, $kdh);
		District::seed('district', '05', 'Kuala Muda', 'Kuala Muda', null, $kdh);
		District::seed('district', '06', 'Yan', 'Yan', null, $kdh);
		District::seed('district', '07', 'Sik', 'Sik', null, $kdh);
		District::seed('district', '08', 'Baling', 'Baling', null, $kdh);
		District::seed('district', '09', 'Kulim', 'Kulim', null, $kdh);
		District::seed('district', '10', 'Bandar Baharu', 'Bandar Baharu', null, $kdh);
		District::seed('district', '11', 'Pendang', 'Pendang', null, $kdh);
		District::seed('district', '12', 'Pokok Sena', 'Pokok Sena', null, $kdh);
		
		// kelantan
		District::seed('district', '01', 'Bachok', 'Bachok', null, $kltn);
		District::seed('district', '02', 'Kota Bharu', 'Kota Bharu', null, $kltn);
		District::seed('district', '03', 'Machang', 'Machang', null, $kltn);
		District::seed('district', '04', 'Pasir Mas', 'Pasir Mas', null, $kltn);
		District::seed('district', '05', 'Pasir Puteh', 'Pasir Puteh', null, $kltn);
		District::seed('district', '06', 'Tanah Merah', 'Tanah Merah', null, $kltn);
		District::seed('district', '07', 'Tumpat', 'Tumpat', null, $kltn);
		District::seed('district', '08', 'Gua Musang', 'Gua Musang', null, $kltn);
		District::seed('district', '10', 'Kuala Krai', 'Kuala Krai', null, $kltn);
		District::seed('district', '11', 'Jeli', 'Jeli', null, $kltn);
		District::seed('district', '12', 'Lojing', 'Lojing', null, $kltn);
		
		// melacca
		District::seed('district', '01', 'Melaka Tengah', 'Melaka Tengah', null, $mlc);
		District::seed('district', '02', 'Jasin', 'Jasin', null, $mlc);
		District::seed('district', '03', 'Alor Gajah', 'Alor Gajah', null, $mlc);
		
		// negeri sembilan
		District::seed('district', '01', 'Jelebu', 'Jelebu', null, $ngr9);
		District::seed('district', '02', 'Kuala Pilah', 'Kuala Pilah', null, $ngr9);
		District::seed('district', '03', 'Port Dickson', 'Port Dickson', null, $ngr9);
		District::seed('district', '04', 'Rembau', 'Rembau', null, $ngr9);
		District::seed('district', '05', 'Seremban', 'Seremban', null, $ngr9);
		District::seed('district', '06', 'Tampin', 'Tampin', null, $ngr9);
		District::seed('district', '07', 'Jempol', 'Jempol', null, $ngr9);
		
		// pahang
		District::seed('district', '01', 'Bentong', 'Bentong', null, $phg);
		District::seed('district', '02', 'Cameron Highlands', 'Cameron Highlands', null, $phg);
		District::seed('district', '03', 'Jerantut', 'Jerantut', null, $phg);
		District::seed('district', '04', 'Kuantan', 'Kuantan', null, $phg);
		District::seed('district', '05', 'Lipis', 'Lipis', null, $phg);
		District::seed('district', '06', 'Pekan', 'Pekan', null, $phg);
		District::seed('district', '07', 'Raub', 'Raub', null, $phg);
		District::seed('district', '08', 'Temerloh', 'Temerloh', null, $phg);
		District::seed('district', '09', 'Rompin', 'Rompin', null, $phg);
		District::seed('district', '10', 'Maran', 'Maran', null, $phg);
		District::seed('district', '11', 'Bera', 'Bera', null, $phg);
		
		// penang
		District::seed('district', '01', 'Seberang Perai Tengah', 'Seberang Perai Tengah', null, $png);
		District::seed('district', '02', 'Seberang Perai Utara', 'Seberang Perai Utara', null, $png);
		District::seed('district', '03', 'Seberang Perai Selatan', 'Seberang Perai Selatan', null, $png);
		District::seed('district', '04', 'Timur Laut', 'Timur Laut', null, $png);
		District::seed('district', '05', 'Barat Daya', 'Barat Daya', null, $png);
		
		// perak
		District::seed('district', '01', 'Batang Padang', 'Batang Padang', null, $prk);
		District::seed('district', '02', 'Manjung', 'Manjung', null, $prk);
		District::seed('district', '03', 'Kinta', 'Kinta', null, $prk);
		District::seed('district', '04', 'Kerian', 'Kerian', null, $prk);
		District::seed('district', '05', 'Kuala Kangsar', 'Kuala Kangsar', null, $prk);
		District::seed('district', '06', 'Larut & Matang', 'Larut & Matang', null, $prk);
		District::seed('district', '07', 'Hilir Perak', 'Hilir Perak', null, $prk);
		District::seed('district', '08', 'Hulu Perak', 'Hulu Perak', null, $prk);
		District::seed('district', '09', 'Selama', 'Selama', null, $prk);
		District::seed('district', '10', 'Perak Tengah', 'Perak Tengah', null, $prk);
		District::seed('district', '11', 'Kampar', 'Kampar', null, $prk);
		District::seed('district', '12', 'Muaalim', 'Muaalim', null, $prk);
		District::seed('district', '13', 'Bagan Datuk', 'Bagan Datuk', null, $prk);
		
		// perlis - no district
		
		// selangor
		District::seed('district', '01', 'Klang', 'Klang', null, $slngr);
		District::seed('district', '02', 'Kuala Langat', 'Kuala Langat', null, $slngr);
		District::seed('district', '04', 'Kuala Selangor', 'Kuala Selangor', null, $slngr);
		District::seed('district', '05', 'Sabak Bernam', 'Sabak Bernam', null, $slngr);
		District::seed('district', '06', 'Hulu Langat', 'Hulu Langat', null, $slngr);
		District::seed('district', '07', 'Hulu Selangor', 'Hulu Selangor', null, $slngr);
		District::seed('district', '08', 'Petaling Jaya', 'Petaling Jaya', null, $slngr);
		District::seed('district', '09', 'Gombak', 'Gombak', null, $slngr);
		District::seed('district', '10', 'Sepang', 'Sepang', null, $slngr);
		
		// terengganu
		District::seed('district', '01', 'Besut', 'Besut', null, $trggn);
		District::seed('district', '02', 'Dungun', 'Dungun', null, $trggn);
		District::seed('district', '03', 'Kemaman', 'Kemaman', null, $trggn);
		District::seed('district', '04', 'Kuala Terengganu', 'Kuala Terengganu', null, $trggn);
		District::seed('district', '05', 'Hulu Terengganu', 'Hulu Terengganu', null, $trggn);
		District::seed('district', '06', 'Marang', 'Marang', null, $trggn);
		District::seed('district', '07', 'Setiu', 'Setiu', null, $trggn);
		District::seed('district', '08', 'Kuala Nerus', 'Kuala Nerus', null, $trggn);
		
		// sabah
		District::seed('district', '01', 'Kota Kinabalu', 'Kota Kinabalu', null, $sbh);
		District::seed('district', '02', 'Papar', 'Papar', null, $sbh);
		District::seed('district', '03', 'Kota Belud', 'Kota Belud', null, $sbh);
		District::seed('district', '04', 'Tuaran', 'Tuaran', null, $sbh);
		District::seed('district', '05', 'Kudat', 'Kudat', null, $sbh);
		District::seed('district', '06', 'Ranau', 'Ranau', null, $sbh);
		District::seed('district', '07', 'Sandakan', 'Sandakan', null, $sbh);
		District::seed('district', '08', 'Labuk Sugut', 'Labuk Sugut', null, $sbh);
		District::seed('district', '09', 'Kinabatangan', 'Kinabatangan', null, $sbh);
		District::seed('district', '10', 'Tawau', 'Tawau', null, $sbh);
		District::seed('district', '11', 'Lahat Datu', 'Lahat Datu', null, $sbh);
		District::seed('district', '12', 'Semporna', 'Semporna', null, $sbh);
		District::seed('district', '13', 'Keningau', 'Keningau', null, $sbh);
		District::seed('district', '14', 'Tambunan', 'Tambunan', null, $sbh);
		District::seed('district', '15', 'Pensiangan', 'Pensiangan', null, $sbh);
		District::seed('district', '16', 'Tenom', 'Tenom', null, $sbh);
		District::seed('district', '17', 'Beaufort', 'Beaufort', null, $sbh);
		District::seed('district', '18', 'Kuala Penyu', 'Kuala Penyu', null, $sbh);
		District::seed('district', '19', 'Sipitang', 'Sipitang', null, $sbh);
		District::seed('district', '21', 'Penampang', 'Penampang', null, $sbh);
		District::seed('district', '22', 'Kota Marudu', 'Kota Marudu', null, $sbh);
		District::seed('district', '23', 'Pitas', 'Pitas', null, $sbh);
		District::seed('district', '24', 'Kunak', 'Kunak', null, $sbh);
		District::seed('district', '25', 'Tongod', 'Tongod', null, $sbh);
		District::seed('district', '26', 'Putatan', 'Putatan', null, $sbh);

		// sarawak
		District::seed('district', '01', 'Kuching', 'Kuching', null, $srwk);
		District::seed('district', '02', 'Sri Aman', 'Sri Aman', null, $srwk);
		District::seed('district', '03', 'Sibu', 'Sibu', null, $srwk);
		District::seed('district', '04', 'Miri', 'Miri', null, $srwk);
		District::seed('district', '05', 'Limbang', 'Limbang', null, $srwk);
		District::seed('district', '06', 'Sarikei', 'Sarikei', null, $srwk);
		District::seed('district', '07', 'Kapit', 'Kapit', null, $srwk);
		District::seed('district', '08', 'Samarahan', 'Samarahan', null, $srwk);
		District::seed('district', '09', 'Bintulu', 'Bintulu', null, $srwk);
		District::seed('district', '10', 'Mukah', 'Mukah', null, $srwk);
		District::seed('district', '11', 'Betong', 'Betong', null, $srwk);
		District::seed('district', '12', 'Serian', 'Serian', null, $srwk);
				
		// WP Kuala Lumpur
		District::seed('district', '01', 'Ampang', 'Ampang', null, $kl);
		District::seed('district', '02', 'Batu', 'Batu', null, $kl);
		District::seed('district', '03', 'Cheras', 'Cheras', null, $kl);
		District::seed('district', '04', 'Ulu Kelang', 'Ulu Kelang', null, $kl);
		District::seed('district', '05', 'Kuala Lumpur', 'Kuala Lumpur', null, $kl);
		District::seed('district', '06', 'Petaling', 'Petaling', null, $kl);
		District::seed('district', '07', 'Setapak', 'Setapak', null, $kl);
		District::seed('district', '44', 'Bandar Kuala Lumpur', 'Bandar Kuala Lumpur', null, $kl);
		District::seed('district', '55', 'Bandar Petaling Jaya', 'Bandar Petaling Jaya', null, $kl);
		District::seed('district', '66', 'Bandar Baru Sungai Besi', 'Bandar Baru Sungai Besi', null, $kl);
		District::seed('district', '70', 'Batu', 'Batu', null, $kl);
		District::seed('district', '71', 'Batu Caves', 'Batu Caves', null, $kl);
		District::seed('district', '72', 'Kepong', 'Kepong', null, $kl);
		District::seed('district', '73', 'Kuala Pauh', 'Kuala Pauh', null, $kl);
		// District::seed('district', '74', 'Petaling', 'Petaling', null, $kl);
		District::seed('district', '75', 'Salak South', 'Salak South', null, $kl);
		District::seed('district', '76', 'Sungai Penchala', 'Sungai Penchala', null, $kl);
		
		// WP Labuan
		District::seed('district', '00', 'Bandar', 'Bandar', null, $lbn);
		District::seed('district', '29', 'Desa', 'Desa', null, $lbn);
				
		// WP Putrajaya
		District::seed('district', '01', 'Presint 1', 'Presint 1', null, $pj);
		District::seed('district', '02', 'Presint 2', 'Presint 2', null, $pj);
		District::seed('district', '03', 'Presint 3', 'Presint 3', null, $pj);
		District::seed('district', '04', 'Presint 4', 'Presint 4', null, $pj);
		District::seed('district', '05', 'Presint 5', 'Presint 5', null, $pj);
		District::seed('district', '06', 'Presint 6', 'Presint 6', null, $pj);
		District::seed('district', '07', 'Presint 7', 'Presint 7', null, $pj);
		District::seed('district', '08', 'Presint 8', 'Presint 8', null, $pj);
		District::seed('district', '09', 'Presint 9', 'Presint 9', null, $pj);
		District::seed('district', '10', 'Presint 10', 'Presint 10', null, $pj);
		District::seed('district', '11', 'Presint 11', 'Presint 11', null, $pj);
		District::seed('district', '12', 'Presint 12', 'Presint 12', null, $pj);
		District::seed('district', '13', 'Presint 13', 'Presint 13', null, $pj);
		District::seed('district', '14', 'Presint 14', 'Presint 14', null, $pj);
		District::seed('district', '15', 'Presint 15', 'Presint 15', null, $pj);
		District::seed('district', '16', 'Presint 16', 'Presint 16', null, $pj);
		District::seed('district', '17', 'Presint 17', 'Presint 17', null, $pj);
		District::seed('district', '18', 'Presint 18', 'Presint 18', null, $pj);
		District::seed('district', '19', 'Presint 19', 'Presint 19', null, $pj);
		District::seed('district', '20', 'Presint 20', 'Presint 20', null, $pj);		
    }
}