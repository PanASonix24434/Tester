<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parliament as Parliament;

class ParliamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $prls  = json_encode(['type' => 'state', 'name' => 'Perlis']);
        $kdh   = json_encode(['type' => 'state', 'name' => 'Kedah']);
        $kltn  = json_encode(['type' => 'state', 'name' => 'Kelantan']);
        $trggn = json_encode(['type' => 'state', 'name' => 'Terengganu']);
        $png   = json_encode(['type' => 'state', 'name' => 'Pulau Pinang']);
        $prk   = json_encode(['type' => 'state', 'name' => 'Perak']);
        $phg   = json_encode(['type' => 'state', 'name' => 'Pahang']);
        $slngr = json_encode(['type' => 'state', 'name' => 'Selangor']);
        $kl    = json_encode(['type' => 'state', 'name' => 'WP Kuala Lumpur']);
        $pj    = json_encode(['type' => 'state', 'name' => 'WP Putrajaya']);
        $ngr9  = json_encode(['type' => 'state', 'name' => 'Negeri Sembilan']);
        $mlc   = json_encode(['type' => 'state', 'name' => 'Melaka']);
        $jhr   = json_encode(['type' => 'state', 'name' => 'Johor']);
        $lbn   = json_encode(['type' => 'state', 'name' => 'WP Labuan']);								
		$sbh   = json_encode(['type' => 'state', 'name' => 'Sabah']);
		$srwk  = json_encode(['type' => 'state', 'name' => 'Sarawak']);	
		
        //Perlis
		Parliament::seed('P001', 'PADANG BESAR', $prls);
        Parliament::seed('P002', 'KANGAR', $prls);
        Parliament::seed('P003', 'ARAU', $prls);

        //Kedah
		Parliament::seed('P004', 'LANGKAWI', $kdh);
        Parliament::seed('P005', 'JERLUN', $kdh);
        Parliament::seed('P006', 'KUBANG PASU', $kdh);
        Parliament::seed('P007', 'PADANG TERAP', $kdh);
        Parliament::seed('P008', 'POKOK SENA', $kdh);
        Parliament::seed('P009', 'ALOR SETAR', $kdh);
        Parliament::seed('P010', 'KUALA KEDAH', $kdh);
        Parliament::seed('P011', 'PENDANG', $kdh);
        Parliament::seed('P012', 'JERAI', $kdh);
        Parliament::seed('P013', 'SIK', $kdh);
        Parliament::seed('P014', 'MERBOK', $kdh);
        Parliament::seed('P015', 'SUNGAI PETANI', $kdh);
        Parliament::seed('P016', 'BALING', $kdh);
        Parliament::seed('P017', 'PADANG SERAI', $kdh);
        Parliament::seed('P018', 'KULIM-BANDAR BAHARU', $kdh);

        //Kelantan
		Parliament::seed('P019', 'TUMPAT', $kltn);
        Parliament::seed('P020', 'PENGKALAN CHEPA', $kltn);
        Parliament::seed('P021', 'KOTA BHARU', $kltn);
        Parliament::seed('P022', 'PASIR MAS', $kltn);
        Parliament::seed('P023', 'RANTAU PANJANG', $kltn);
        Parliament::seed('P024', 'KUBANG KERIAN', $kltn);
        Parliament::seed('P025', 'BACHOK', $kltn);
        Parliament::seed('P026', 'KETEREH', $kltn);
        Parliament::seed('P027', 'TANAH MERAH', $kltn);
        Parliament::seed('P028', 'PASIR PUTEH', $kltn);
        Parliament::seed('P029', 'MACHANG', $kltn);
        Parliament::seed('P030', 'JELI', $kltn);
        Parliament::seed('P031', 'KUALA KRAI', $kltn);
        Parliament::seed('P032', 'GUA MUSANG', $kltn);

        //Terengganu
		Parliament::seed('P033', 'BESUT', $trggn);
        Parliament::seed('P034', 'SETIU', $trggn);
        Parliament::seed('P035', 'KUALA NERUS', $trggn);
        Parliament::seed('P036', 'KUALA TERENGGANU', $trggn);
        Parliament::seed('P037', 'MARANG', $trggn);
        Parliament::seed('P038', 'HULU TERENGGANU', $trggn);
        Parliament::seed('P039', 'DUNGUN', $trggn);
        Parliament::seed('P040', 'KEMAMAN', $trggn);

        //Pulau Pinang
		Parliament::seed('P041', 'KEPALA BATAS', $png);
        Parliament::seed('P042', 'TASEK GELUGOR', $png);
        Parliament::seed('P043', 'BAGAN', $png);
        Parliament::seed('P044', 'PERMATANG PAUH', $png);
        Parliament::seed('P045', 'BUKIT MERTAJAM', $png);
        Parliament::seed('P046', 'BATU KAWAN', $png);
        Parliament::seed('P047', 'NIBONG TEBAL', $png);
        Parliament::seed('P048', 'BUKIT BENDERA', $png);
        Parliament::seed('P049', 'TANJONG', $png);
        Parliament::seed('P050', 'JELUTONG', $png);
        Parliament::seed('P051', 'BUKIT GELUGOR', $png);
        Parliament::seed('P052', 'BAYAN BARU', $png);
        Parliament::seed('P053', 'BALIK PULAU', $png);

        //Perak
		Parliament::seed('P054', 'GERIK', $prk);
        Parliament::seed('P055', 'LENGGONG', $prk);
        Parliament::seed('P056', 'LARUT', $prk);
        Parliament::seed('P057', 'PARIT BUNTAR', $prk);
        Parliament::seed('P058', 'BAGAN SERAI', $prk);
        Parliament::seed('P059', 'BUKIT GANTANG', $prk);
        Parliament::seed('P060', 'TAIPING', $prk);
        Parliament::seed('P061', 'PADANG RENGAS', $prk);
        Parliament::seed('P062', 'SUNGAI SIPUT', $prk);
        Parliament::seed('P063', 'TAMBUN', $prk);
        Parliament::seed('P064', 'IPOH TIMOR', $prk);
        Parliament::seed('P065', 'IPOH BARAT', $prk);
        Parliament::seed('P066', 'BATU GAJAH', $prk);
        Parliament::seed('P067', 'KUALA KANGSAR', $prk);
        Parliament::seed('P068', 'BERUAS', $prk);
        Parliament::seed('P069', 'PARIT', $prk);
        Parliament::seed('P070', 'KAMPAR', $prk);
        Parliament::seed('P071', 'GOPENG', $prk);
        Parliament::seed('P072', 'TAPAH', $prk);
        Parliament::seed('P073', 'PASIR SALAK', $prk);
        Parliament::seed('P074', 'LUMUT', $prk);
        Parliament::seed('P075', 'BAGAN DATUK', $prk);
        Parliament::seed('P076', 'TELUK INTAN', $prk);
        Parliament::seed('P077', 'TANJONG MALIM', $prk);

        //Pahang
		Parliament::seed('P078', 'CAMERON HIGHLANDS', $phg);
        Parliament::seed('P079', 'LIPIS', $phg);
        Parliament::seed('P080', 'RAUB', $phg);
        Parliament::seed('P081', 'JERANTUT', $phg);
        Parliament::seed('P082', 'INDERA MAHKOTA', $phg);
        Parliament::seed('P083', 'KUANTAN', $phg);
        Parliament::seed('P084', 'PAYA BESAR', $phg);
        Parliament::seed('P085', 'PEKAN', $phg);
        Parliament::seed('P086', 'MARAN', $phg);
        Parliament::seed('P087', 'KUALA KRAU', $phg);
        Parliament::seed('P088', 'TEMERLOH', $phg);
        Parliament::seed('P089', 'BENTONG', $phg);
        Parliament::seed('P090', 'BERA', $phg);
        Parliament::seed('P091', 'ROMPIN', $phg);

        //Selangor
		Parliament::seed('P092', 'SABAK BERNAM', $slngr);
        Parliament::seed('P093', 'SUNGAI BESAR', $slngr);
        Parliament::seed('P094', 'HULU SELANGOR', $slngr);
        Parliament::seed('P095', 'TANJONG KARANG', $slngr);
        Parliament::seed('P096', 'KUALA SELANGOR', $slngr);
        Parliament::seed('P097', 'SELAYANG', $slngr);
        Parliament::seed('P098', 'GOMBAK', $slngr);
        Parliament::seed('P099', 'AMPANG', $slngr);
        Parliament::seed('P100', 'PANDAN', $slngr);
        Parliament::seed('P101', 'HULU LANGAT', $slngr);
        Parliament::seed('P102', 'BANGI', $slngr);
        Parliament::seed('P103', 'PUCHONG', $slngr);
        Parliament::seed('P104', 'SUBANG', $slngr);
        Parliament::seed('P105', 'PETALING JAYA', $slngr);
        Parliament::seed('P106', 'DAMANSARA', $slngr);
        Parliament::seed('P107', 'SUNGAI BULOH', $slngr);
        Parliament::seed('P108', 'SHAH ALAM', $slngr);
        Parliament::seed('P109', 'KAPAR', $slngr);
        Parliament::seed('P110', 'KLANG', $slngr);
        Parliament::seed('P111', 'KOTA RAJA', $slngr);
        Parliament::seed('P112', 'KUALA LANGAT', $slngr);
        Parliament::seed('P113', 'SEPANG', $slngr);

        //Kuala Selangor
		Parliament::seed('P114', 'KEPONG', $kl);
        Parliament::seed('P115', 'BATU', $kl);
        Parliament::seed('P116', 'WANGSA MAJU', $kl);
        Parliament::seed('P117', 'SEGAMBUT', $kl);
        Parliament::seed('P118', 'SETIAWANGSA', $kl);
        Parliament::seed('P119', 'TITIWANGSA', $kl);
        Parliament::seed('P120', 'BUKIT BINTANG', $kl);
        Parliament::seed('P121', 'LEMBAH PANTAI', $kl);
        Parliament::seed('P122', 'SEPUTEH', $kl);
        Parliament::seed('P123', 'CHERAS', $kl);
        Parliament::seed('P124', 'BANDAR TUN RAZAK', $kl);

        //Putrajaya
		Parliament::seed('P125', 'PUTRAJAYA', $pj);

        //Negeri Sembilan
		Parliament::seed('P126', 'JELEBU', $ngr9);
        Parliament::seed('P127', 'JEMPOL', $ngr9);
        Parliament::seed('P128', 'SEREMBAN', $ngr9);
        Parliament::seed('P129', 'KUALA PILAH', $ngr9);
        Parliament::seed('P130', 'RASAH', $ngr9);
        Parliament::seed('P131', 'REMBAU', $ngr9);
        Parliament::seed('P132', 'PORT DICKSON', $ngr9);
        Parliament::seed('P133', 'TAMPIN', $ngr9);

        //Melaka
		Parliament::seed('P134', 'MASJID TANAH', $mlc);
        Parliament::seed('P135', 'ALOR GAJAH', $mlc);
        Parliament::seed('P136', 'TANGGA BATU', $mlc);
        Parliament::seed('P137', 'HANG TUAH JAYA', $mlc);
        Parliament::seed('P138', 'KOTA MELAKA', $mlc);
        Parliament::seed('P139', 'JASIN', $mlc);

        //Johor
		Parliament::seed('P140', 'SEGAMAT', $jhr);
        Parliament::seed('P141', 'SEKIJANG', $jhr);
        Parliament::seed('P142', 'LABIS', $jhr);
        Parliament::seed('P143', 'PAGOH', $jhr);
        Parliament::seed('P144', 'LEDANG', $jhr);
        Parliament::seed('P145', 'BAKRI', $jhr);
        Parliament::seed('P146', 'MUAR', $jhr);
        Parliament::seed('P147', 'PARIT SULONG', $jhr);
        Parliament::seed('P148', 'AYER HITAM', $jhr);
        Parliament::seed('P149', 'SRI GADING', $jhr);
        Parliament::seed('P150', 'BATU PAHAT', $jhr);
        Parliament::seed('P151', 'SIMPANG RENGGAM', $jhr);
        Parliament::seed('P152', 'KLUANG', $jhr);
        Parliament::seed('P153', 'SEMBRONG', $jhr);
        Parliament::seed('P154', 'MERSING', $jhr);
        Parliament::seed('P155', 'TENGGARA', $jhr);
        Parliament::seed('P156', 'KOTA TINGGI', $jhr);
        Parliament::seed('P157', 'PENGERANG', $jhr);
        Parliament::seed('P158', 'TEBRAU', $jhr);
        Parliament::seed('P159', 'PASIR GUDANG', $jhr);
        Parliament::seed('P160', 'JOHOR BAHRU', $jhr);
        Parliament::seed('P161', 'PULAI', $jhr);
        Parliament::seed('P162', 'ISKANDAR PUTERI', $jhr);
        Parliament::seed('P163', 'KULAI', $jhr);
        Parliament::seed('P164', 'PONTIAN', $jhr);
        Parliament::seed('P165', 'TANJUNG PIAI', $jhr);

        //Labuan
		Parliament::seed('P166', 'LABUAN', $lbn);

        //Sabah
		Parliament::seed('P167', 'KUDAT', $sbh);
        Parliament::seed('P168', 'KOTA MARUDU', $sbh);
        Parliament::seed('P169', 'KOTA BELUD', $sbh);
        Parliament::seed('P170', 'TUARAN', $sbh);
        Parliament::seed('P171', 'SEPANGGAR', $sbh);
        Parliament::seed('P172', 'KOTA KINABALU', $sbh);
        Parliament::seed('P173', 'PUTATAN', $sbh);
        Parliament::seed('P174', 'PENAMPANG', $sbh);
        Parliament::seed('P175', 'PAPAR', $sbh);
        Parliament::seed('P176', 'KIMANIS', $sbh);
        Parliament::seed('P177', 'BEAUFORT', $sbh);
        Parliament::seed('P178', 'SIPITANG', $sbh);
        Parliament::seed('P179', 'RANAU', $sbh);
        Parliament::seed('P180', 'KENINGAU', $sbh);
        Parliament::seed('P181', 'TENOM', $sbh);
        Parliament::seed('P182', 'PENSIANGAN', $sbh);
        Parliament::seed('P183', 'BELURAN', $sbh);
        Parliament::seed('P184', 'LIBARAN', $sbh);
        Parliament::seed('P185', 'BATU SAPI', $sbh);
        Parliament::seed('P186', 'SANDAKAN', $sbh);
        Parliament::seed('P187', 'KINABATANGAN', $sbh);
        Parliament::seed('P188', 'LAHAD DATU', $sbh);
        Parliament::seed('P189', 'SEMPORNA', $sbh);
        Parliament::seed('P190', 'TAWAU', $sbh);
        Parliament::seed('P191', 'KALABAKAN', $sbh);

        //Sarawak
		Parliament::seed('P192', 'MAS GADING', $srwk);
        Parliament::seed('P193', 'SANTUBONG', $srwk);
        Parliament::seed('P194', 'PETRA JAYA', $srwk);
        Parliament::seed('P195', 'BANDAR KUCHING', $srwk);
        Parliament::seed('P196', 'STAMPIN', $srwk);
        Parliament::seed('P197', 'KOTA SAMARAHAN', $srwk);
        Parliament::seed('P198', 'PUNCAK BORNEO', $srwk);
        Parliament::seed('P199', 'SERIAN', $srwk);
        Parliament::seed('P200', 'BATANG SADONG', $srwk);
        Parliament::seed('P201', 'BATANG LUPAR', $srwk);
        Parliament::seed('P202', 'SRI AMAN', $srwk);
        Parliament::seed('P203', 'LUBOK ANTU', $srwk);
        Parliament::seed('P204', 'BETONG', $srwk);
        Parliament::seed('P205', 'SARATOK', $srwk);
        Parliament::seed('P206', 'TANJONG MANIS', $srwk);
        Parliament::seed('P207', 'IGAN', $srwk);
        Parliament::seed('P208', 'SARIKEI', $srwk);
        Parliament::seed('P209', 'JULAU', $srwk);
        Parliament::seed('P210', 'KANOWIT', $srwk);
        Parliament::seed('P211', 'LANANG', $srwk);
        Parliament::seed('P212', 'SIBU', $srwk);
        Parliament::seed('P213', 'MUKAH', $srwk);
        Parliament::seed('P214', 'SELANGAU', $srwk);
        Parliament::seed('P215', 'KAPIT', $srwk);
        Parliament::seed('P216', 'HULU RAJANG', $srwk);
        Parliament::seed('P217', 'BINTULU', $srwk);
        Parliament::seed('P218', 'SIBUTI', $srwk);
        Parliament::seed('P219', 'MIRI', $srwk);
        Parliament::seed('P220', 'BARAM', $srwk);
        Parliament::seed('P221', 'LIMBANG', $srwk);
        Parliament::seed('P222', 'LAWAS', $srwk);

    }
}