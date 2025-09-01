<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParliamentSeat as ParliamentSeat;

class ParliamentSeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Perlis
        $padangBesar  = json_encode(['pCode' => 'P001']);
        $kangar  = json_encode(['pCode' => 'P002']);
        $arau  = json_encode(['pCode' => 'P003']);

        //Perlis - Padang Besar
		ParliamentSeat::seed('N01', 'TITI TINGGI', $padangBesar);
        ParliamentSeat::seed('N02', 'BESERI', $padangBesar);
        ParliamentSeat::seed('N03', 'CHUPING', $padangBesar);
        ParliamentSeat::seed('N04', 'MATA AYER', $padangBesar);
        ParliamentSeat::seed('N05', 'SANTAN', $padangBesar);

        //Perlis - Kangar
		ParliamentSeat::seed('N06', 'BINTONG', $kangar);
        ParliamentSeat::seed('N07', 'SENA', $kangar);
        ParliamentSeat::seed('N08', 'INDERA KAYANGAN', $kangar);
        ParliamentSeat::seed('N09', 'KUALA PERLIS', $kangar);
        ParliamentSeat::seed('N10', 'KAYANGAN', $kangar);

        //Perlis - Arau
		ParliamentSeat::seed('N11', 'PAUH', $arau);
        ParliamentSeat::seed('N12', 'TAMBUN TULANG', $arau);
        ParliamentSeat::seed('N13', 'GUAR SANJI', $arau);
        ParliamentSeat::seed('N14', 'SIMPANG EMPAT', $arau);
        ParliamentSeat::seed('N15', 'SANGLANG', $arau);

        //Kedah
        $langkawi  = json_encode(['pCode' => 'P004']);
        $jerlun  = json_encode(['pCode' => 'P005']);
        $kubangPasu  = json_encode(['pCode' => 'P006']);
        $padangTerap  = json_encode(['pCode' => 'P007']);
        $pokokSena  = json_encode(['pCode' => 'P008']);
        $alorSetar  = json_encode(['pCode' => 'P009']);
        $kualaKedah  = json_encode(['pCode' => 'P010']);
        $pendang  = json_encode(['pCode' => 'P011']);
        $jerai  = json_encode(['pCode' => 'P012']);
        $sik  = json_encode(['pCode' => 'P013']);
        $merbok  = json_encode(['pCode' => 'P014']);
        $sungaiPetani  = json_encode(['pCode' => 'P015']);
        $baling  = json_encode(['pCode' => 'P016']);
        $padangSerai  = json_encode(['pCode' => 'P017']);
        $kulimBandarBaharu  = json_encode(['pCode' => 'P018']);

        //Kedah - Langkawi
		ParliamentSeat::seed('N01', 'AYER HANGAT', $langkawi);
        ParliamentSeat::seed('N02', 'KUAH', $langkawi);

        //Kedah - Jerlun
		ParliamentSeat::seed('N03', 'KOTA SIPUTEH', $jerlun);
        ParliamentSeat::seed('N04', 'AYER HITAM', $jerlun);

        //Kedah - Kubang Pasu
		ParliamentSeat::seed('N05', 'BUKIT KAYU HITAM', $kubangPasu);
        ParliamentSeat::seed('N06', 'JITRA', $kubangPasu);

        //Kedah - Padang Terap
		ParliamentSeat::seed('N07', 'KUALA NERANG', $padangTerap);
        ParliamentSeat::seed('N08', 'PEDU', $padangTerap);

        //Kedah - Pokok Sena
		ParliamentSeat::seed('N09', 'BUKIT LADA', $pokokSena);
        ParliamentSeat::seed('N10', 'BUKIT PINANG', $pokokSena);
        ParliamentSeat::seed('N11', 'DERGA', $pokokSena);

        //Kedah - Alor Setar
		ParliamentSeat::seed('N12', 'SUKA MENANTI', $alorSetar);
        ParliamentSeat::seed('N13', 'KOTA DARUL AMAN', $alorSetar);
        ParliamentSeat::seed('N14', 'ALOR MENGKUDU', $alorSetar);

        //Kedah - Kuala Kedah
		ParliamentSeat::seed('N15', 'ANAK BUKIT', $kualaKedah);
        ParliamentSeat::seed('N16', 'KUBANG ROTAN', $kualaKedah);
        ParliamentSeat::seed('N17', 'PENGKALAN KUNDOR', $kualaKedah);

        //Kedah - Pendang
		ParliamentSeat::seed('N18', 'TOKAI', $pendang);
        ParliamentSeat::seed('N19', 'SUNGAI TIANG', $pendang);

        //Kedah - Jerai
		ParliamentSeat::seed('N20', 'SUNGAI LIMAU', $jerai);
        ParliamentSeat::seed('N21', 'GUAR CHEMPEDAK', $jerai);
        ParliamentSeat::seed('N22', 'GURUN', $jerai);

        //Kedah - Sik
		ParliamentSeat::seed('N23', 'BELANTEK', $sik);
        ParliamentSeat::seed('N24', 'JENERI', $sik);

        //Kedah - Merbok
		ParliamentSeat::seed('N25', 'BUKIT SELAMBAU', $merbok);
        ParliamentSeat::seed('N26', 'TANJONG DAWAI', $merbok);

        //Kedah - Sungai Petani
		ParliamentSeat::seed('N27', 'PANTAI MERDEKA', $sungaiPetani);
        ParliamentSeat::seed('N28', 'BAKAR ARANG', $sungaiPetani);
        ParliamentSeat::seed('N29', 'SIDAM', $sungaiPetani);

        //Kedah - Baling
		ParliamentSeat::seed('N30', 'BAYU', $baling);
        ParliamentSeat::seed('N31', 'KUPANG', $baling);
        ParliamentSeat::seed('N32', 'KUALA KETIL', $baling);

        //Kedah - Padang Serai
		ParliamentSeat::seed('N33', 'MERBAU PULAS', $padangSerai);
        ParliamentSeat::seed('N34', 'LUNAS', $padangSerai);

        //Kedah - Kulim-Bandar Baharu
		ParliamentSeat::seed('N35', 'KULIM', $kulimBandarBaharu);
        ParliamentSeat::seed('N36', 'BANDAR BAHARU', $kulimBandarBaharu);

        //Kelantan
        $tumpat  = json_encode(['pCode' => 'P019']);
        $pengkalanChepa  = json_encode(['pCode' => 'P020']);
        $kotaBharu  = json_encode(['pCode' => 'P021']);
        $pasirMas  = json_encode(['pCode' => 'P022']);
        $rantauPanjang  = json_encode(['pCode' => 'P023']);
        $kubangKerian  = json_encode(['pCode' => 'P024']);
        $bachok  = json_encode(['pCode' => 'P025']);
        $ketereh  = json_encode(['pCode' => 'P026']);
        $tanahMerah  = json_encode(['pCode' => 'P027']);
        $pasirPuteh  = json_encode(['pCode' => 'P028']);
        $machang  = json_encode(['pCode' => 'P029']);
        $jeli  = json_encode(['pCode' => 'P030']);
        $kualaKrai  = json_encode(['pCode' => 'P031']);
        $guaMusang  = json_encode(['pCode' => 'P032']);

        //Kelantan - Tumpat
		ParliamentSeat::seed('N01', 'PENGKALAN KUBOR', $tumpat);
        ParliamentSeat::seed('N02', 'KELABORAN', $tumpat);
        ParliamentSeat::seed('N03', 'PASIR PEKAN', $tumpat);
        ParliamentSeat::seed('N04', 'WAKAF BHARU', $tumpat);

        //Kelantan - Pengkalan Chepa
		ParliamentSeat::seed('N05', 'KIJANG', $pengkalanChepa);
        ParliamentSeat::seed('N06', 'CHEMPAKA', $pengkalanChepa);
        ParliamentSeat::seed('N07', 'PANCHOR', $pengkalanChepa);

        //Kelantan - Kota Bharu
		ParliamentSeat::seed('N08', 'TANJONG MAS', $kotaBharu);
        ParliamentSeat::seed('N09', 'KOTA LAMA', $kotaBharu);
        ParliamentSeat::seed('N10', 'BUNUT PAYONG', $kotaBharu);

        //Kelantan - Pasir Mas
		ParliamentSeat::seed('N11', 'TENDONG', $pasirMas);
        ParliamentSeat::seed('N12', 'PENGKALAN PASIR', $pasirMas);
        ParliamentSeat::seed('N13', 'MERANTI', $pasirMas);

        //Kelantan - Rantau Panjang
		ParliamentSeat::seed('N14', 'CHETOK', $rantauPanjang);
        ParliamentSeat::seed('N15', 'GUAL PERIOK', $rantauPanjang);
        ParliamentSeat::seed('N16', 'APAM PUTRA', $rantauPanjang);

        //Kelantan - Kubang Kerian
		ParliamentSeat::seed('N17', 'SALOR', $kubangKerian);
        ParliamentSeat::seed('N18', 'PASIR TUMBOH', $kubangKerian);
        ParliamentSeat::seed('N19', 'DEMIT', $kubangKerian);

        //Kelantan - Bachok
		ParliamentSeat::seed('N20', 'TAWANG', $bachok);
        ParliamentSeat::seed('N21', 'PANTAI IRAMA', $bachok);
        ParliamentSeat::seed('N22', 'JELAWAT', $bachok);

        //Kelantan - Ketereh
		ParliamentSeat::seed('N23', 'MELOR', $ketereh);
        ParliamentSeat::seed('N24', 'KADOK', $ketereh);
        ParliamentSeat::seed('N25', 'KOK LANAS', $ketereh);

        //Kelantan - Tanah Merah
		ParliamentSeat::seed('N26', 'BUKIT PANAU', $tanahMerah);
        ParliamentSeat::seed('N27', 'GUAL IPOH', $tanahMerah);
        ParliamentSeat::seed('N28', 'KEMAHANG', $tanahMerah);

        //Kelantan - Pasir Puteh
		ParliamentSeat::seed('N29', 'SELISING', $pasirPuteh);
        ParliamentSeat::seed('N30', 'LIMBONGAN', $pasirPuteh);
        ParliamentSeat::seed('N31', 'SEMERAK', $pasirPuteh);
        ParliamentSeat::seed('N32', 'GAAL', $pasirPuteh);

        //Kelantan - Machang
		ParliamentSeat::seed('N33', 'PULAI CHONDONG', $machang);
        ParliamentSeat::seed('N34', 'TEMANGAN', $machang);
        ParliamentSeat::seed('N35', 'KEMUNING', $machang);

        //Kelantan - Jeli
		ParliamentSeat::seed('N36', 'BUKIT BUNGA', $jeli);
        ParliamentSeat::seed('N37', 'AIR LANAS', $jeli);
        ParliamentSeat::seed('N38', 'KUALA BALAH', $jeli);

        //Kelantan - Kuala Krai
		ParliamentSeat::seed('N39', 'MENGKEBANG', $kualaKrai);
        ParliamentSeat::seed('N40', 'GUCHIL', $kualaKrai);
        ParliamentSeat::seed('N41', 'MANEK URAI', $kualaKrai);
        ParliamentSeat::seed('N42', 'DABONG', $kualaKrai);

        //Kelantan - Gua Musang
		ParliamentSeat::seed('N43', 'NENGGIRI', $guaMusang);
        ParliamentSeat::seed('N44', 'PALOH', $guaMusang);
        ParliamentSeat::seed('N45', 'GALAS', $guaMusang);

        //Terengganu
        $besut  = json_encode(['pCode' => 'P033']);
        $setiu  = json_encode(['pCode' => 'P034']);
        $kualaNerus  = json_encode(['pCode' => 'P035']);
        $kualaTerengganu  = json_encode(['pCode' => 'P036']);
        $marang  = json_encode(['pCode' => 'P037']);
        $huluTerengganu  = json_encode(['pCode' => 'P038']);
        $dungun  = json_encode(['pCode' => 'P039']);
        $kemaman  = json_encode(['pCode' => 'P040']);

        //Terengganu - Besut
		ParliamentSeat::seed('N01', 'KUALA BESUT', $besut);
        ParliamentSeat::seed('N02', 'KOTA PUTERA', $besut);
        ParliamentSeat::seed('N03', 'JERTIH', $besut);
        ParliamentSeat::seed('N04', 'HULU BESUT', $besut);

        //Terengganu - Setiu
		ParliamentSeat::seed('N05', 'JABI', $setiu);
        ParliamentSeat::seed('N06', 'PERMAISURI', $setiu);
        ParliamentSeat::seed('N07', 'LANGKAP', $setiu);
        ParliamentSeat::seed('N08', 'BATU RAKIT', $setiu);

        //Terengganu - Kuala Nerus
		ParliamentSeat::seed('N09', 'TEPUH', $kualaNerus);
        ParliamentSeat::seed('N10', 'BULUH GADING', $kualaNerus);
        ParliamentSeat::seed('N11', 'SEBERANG TAKIR', $kualaNerus);
        ParliamentSeat::seed('N12', 'BUKIT TUNGGAL', $kualaNerus);

        //Terengganu - Kuala Terengganu
		ParliamentSeat::seed('N13', 'WAKAF MEMPELAM', $kualaTerengganu);
        ParliamentSeat::seed('N14', 'BANDAR', $kualaTerengganu);
        ParliamentSeat::seed('N15', 'LADANG', $kualaTerengganu);
        ParliamentSeat::seed('N16', 'BATU BURUK', $kualaTerengganu);

        //Terengganu - Marang
		ParliamentSeat::seed('N17', 'ALUR LIMBAT', $marang);
        ParliamentSeat::seed('N18', 'BUKIT PAYUNG', $marang);
        ParliamentSeat::seed('N19', 'RU RENDANG', $marang);
        ParliamentSeat::seed('N20', 'PENGKALAN BERANGAN', $marang);

        //Terengganu - Hulu Terengganu
		ParliamentSeat::seed('N21', 'TELEMUNG', $huluTerengganu);
        ParliamentSeat::seed('N22', 'MANIR', $huluTerengganu);
        ParliamentSeat::seed('N23', 'KUALA BERANG', $huluTerengganu);
        ParliamentSeat::seed('N24', 'AJIL', $huluTerengganu);

        //Terengganu - Dungun
		ParliamentSeat::seed('N25', 'BUKIT BESI', $dungun);
        ParliamentSeat::seed('N26', 'RANTAU ABANG', $dungun);
        ParliamentSeat::seed('N27', 'SURA', $dungun);
        ParliamentSeat::seed('N28', 'PAKA', $dungun);

        //Terengganu - Kemaman
		ParliamentSeat::seed('N29', 'KEMASIK', $kemaman);
        ParliamentSeat::seed('N30', 'KIJAL', $kemaman);
        ParliamentSeat::seed('N31', 'CUKAI', $kemaman);
        ParliamentSeat::seed('N32', 'AIR PUTIH', $kemaman);

        //Pulau Pinang
        $kepalaBatas  = json_encode(['pCode' => 'P041']);
        $tasekGelugor  = json_encode(['pCode' => 'P042']);
        $bagan  = json_encode(['pCode' => 'P043']);
        $permatangPauh  = json_encode(['pCode' => 'P044']);
        $bukitMertajam  = json_encode(['pCode' => 'P045']);
        $batuKawan  = json_encode(['pCode' => 'P046']);
        $nibongTebal  = json_encode(['pCode' => 'P047']);
        $bukitBendera  = json_encode(['pCode' => 'P048']);
        $tanjong  = json_encode(['pCode' => 'P049']);
        $jelutong  = json_encode(['pCode' => 'P050']);
        $bukitGelugor  = json_encode(['pCode' => 'P051']);
        $bayanBaru  = json_encode(['pCode' => 'P052']);
        $balikPulau  = json_encode(['pCode' => 'P053']);

        //Pulau Pinang - Kepala Batas
		ParliamentSeat::seed('N01', 'PENAGA', $kepalaBatas);
        ParliamentSeat::seed('N02', 'BERTAM', $kepalaBatas);
        ParliamentSeat::seed('N03', 'PINANG TUNGGAL', $kepalaBatas);

        //Pulau Pinang - Tasek Gelugor
		ParliamentSeat::seed('N04', 'PERMATANG BERANGAN', $tasekGelugor);
        ParliamentSeat::seed('N05', 'SUNGAI DUA', $tasekGelugor);
        ParliamentSeat::seed('N06', 'TELOK AYER TAWAR', $tasekGelugor);

        //Pulau Pinang - Bagan
		ParliamentSeat::seed('N07', 'SUNGAI PUYU', $bagan);
        ParliamentSeat::seed('N08', 'BAGAN JERMAL', $bagan);
        ParliamentSeat::seed('N09', 'BAGAN DALAM', $bagan);

        //Pulau Pinang - Permatang Pauh
		ParliamentSeat::seed('N010', 'SEBERANG JAYA', $permatangPauh);
        ParliamentSeat::seed('N011', 'PERMATANG PASIR', $permatangPauh);
        ParliamentSeat::seed('N012', 'PENANTI', $permatangPauh);

        //Pulau Pinang - Bukit Mertajam
		ParliamentSeat::seed('N013', 'BERAPIT', $bukitMertajam);
        ParliamentSeat::seed('N014', 'MACHANG BUBUK', $bukitMertajam);
        ParliamentSeat::seed('N015', 'PADANG LALANG', $bukitMertajam);

        //Pulau Pinang - Batu Kawan
		ParliamentSeat::seed('N016', 'PERAI', $batuKawan);
        ParliamentSeat::seed('N017', 'BUKIT TENGAH', $batuKawan);
        ParliamentSeat::seed('N018', 'BUKIT TAMBUN', $batuKawan);

        //Pulau Pinang - Nibong Tebal
		ParliamentSeat::seed('N019', 'JAWI', $nibongTebal);
        ParliamentSeat::seed('N020', 'SUNGAI BAKAP', $nibongTebal);
        ParliamentSeat::seed('N021', 'SUNGAI ACHEH', $nibongTebal);

        //Pulau Pinang - Bukit Bendera
		ParliamentSeat::seed('N022', 'TANJONG BUNGA', $bukitBendera);
        ParliamentSeat::seed('N023', 'AIR PUTIH', $bukitBendera);
        ParliamentSeat::seed('N024', 'KEBUN BUNGA', $bukitBendera);
        ParliamentSeat::seed('N025', 'PULAU TIKUS', $bukitBendera);

        //Pulau Pinang - Tanjong
		ParliamentSeat::seed('N026', 'PADANG KOTA', $tanjong);
        ParliamentSeat::seed('N027', 'PENGKALAN KOTA', $tanjong);
        ParliamentSeat::seed('N028', 'KOMTAR', $tanjong);

        //Pulau Pinang - Jelutong
		ParliamentSeat::seed('N029', 'DATOK KERAMAT', $jelutong);
        ParliamentSeat::seed('N030', 'SUNGAI PINANG', $jelutong);
        ParliamentSeat::seed('N031', 'BATU LANCANG', $jelutong);

        //Pulau Pinang - Bukit Gelugor
		ParliamentSeat::seed('N032', 'SERI DELIMA', $bukitGelugor);
        ParliamentSeat::seed('N033', 'AIR HITAM', $bukitGelugor);
        ParliamentSeat::seed('N034', 'PAYA TERUBONG', $bukitGelugor);

        //Pulau Pinang - Bayan Baru
		ParliamentSeat::seed('N035', 'BATU UBAN', $bayanBaru);
        ParliamentSeat::seed('N036', 'PANTAI JEREJAK', $bayanBaru);
        ParliamentSeat::seed('N037', 'BATU MAUNG', $bayanBaru);

        //Pulau Pinang - Balik Pulau
		ParliamentSeat::seed('N038', 'BAYAN LEPAS', $balikPulau);
        ParliamentSeat::seed('N039', 'PULAU BETONG', $balikPulau);
        ParliamentSeat::seed('N040', 'TELOK BAHANG', $balikPulau);

        //Perak
        $gerik  = json_encode(['pCode' => 'P054']);
        $lenggong  = json_encode(['pCode' => 'P055']);
        $larut  = json_encode(['pCode' => 'P056']);
        $paritBuntar  = json_encode(['pCode' => 'P057']);
        $baganSerai  = json_encode(['pCode' => 'P058']);
        $bukitGantang  = json_encode(['pCode' => 'P059']);
        $taiping  = json_encode(['pCode' => 'P060']);
        $padangRengas  = json_encode(['pCode' => 'P061']);
        $sungaiSiput  = json_encode(['pCode' => 'P062']);
        $tambun  = json_encode(['pCode' => 'P063']);
        $ipohTimor  = json_encode(['pCode' => 'P064']);
        $ipohBarat  = json_encode(['pCode' => 'P065']);
        $batuGajah  = json_encode(['pCode' => 'P066']);
        $kualaKangsar  = json_encode(['pCode' => 'P067']);
        $beruas  = json_encode(['pCode' => 'P068']);
        $parit  = json_encode(['pCode' => 'P069']);
        $kampar  = json_encode(['pCode' => 'P070']);
        $gopeng  = json_encode(['pCode' => 'P071']);
        $tapah  = json_encode(['pCode' => 'P072']);
        $pasirSalak  = json_encode(['pCode' => 'P073']);
        $lumut  = json_encode(['pCode' => 'P074']);
        $baganDatuk  = json_encode(['pCode' => 'P075']);
        $telukIntan  = json_encode(['pCode' => 'P076']);
        $tanjongMalim  = json_encode(['pCode' => 'P077']);

        //Perak - Gerik
		ParliamentSeat::seed('N01', 'PENGAKALAN HULU', $gerik);
        ParliamentSeat::seed('N02', 'TEMENGOR', $gerik);

        //Perak - Lenggong
		ParliamentSeat::seed('N03', 'KENERING', $lenggong);
        ParliamentSeat::seed('N04', 'KOTA TAMPAN', $lenggong);

        //Perak - Larut
		ParliamentSeat::seed('N05', 'SELAMA', $larut);
        ParliamentSeat::seed('N06', 'KUBU GAJAH', $larut);
        ParliamentSeat::seed('N07', 'BATU KURAU', $larut);

        //Perak - Parit Buntar
		ParliamentSeat::seed('N08', 'TITI SERONG', $paritBuntar);
        ParliamentSeat::seed('N09', 'KUALA KURAU', $paritBuntar);

        //Perak - Bagan Serai
		ParliamentSeat::seed('N10', 'ALOR PONGSU', $baganSerai);
        ParliamentSeat::seed('N11', 'GUNONG SEMANGGOL', $baganSerai);
        ParliamentSeat::seed('N12', 'SELINSING', $baganSerai);

        //Perak - Bukit Gantang
		ParliamentSeat::seed('N13', 'KUALA SEPETANG', $bukitGantang);
        ParliamentSeat::seed('N14', 'CHANGKAT JERING', $bukitGantang);
        ParliamentSeat::seed('N15', 'TRONG', $bukitGantang);

        //Perak - Taiping
		ParliamentSeat::seed('N16', 'KAMUNTING', $taiping);
        ParliamentSeat::seed('N17', 'POKOK ASSAM', $taiping);
        ParliamentSeat::seed('N18', 'AULONG', $taiping);

        //Perak - Padang Rengas
		ParliamentSeat::seed('N19', 'CHENDEROH', $padangRengas);
        ParliamentSeat::seed('N20', 'LUBOK MERBAU', $padangRengas);

        //Perak - Sungai Siput
		ParliamentSeat::seed('N21', 'LINTANG', $sungaiSiput);
        ParliamentSeat::seed('N22', 'JALONG', $sungaiSiput);

        //Perak - Tambun
		ParliamentSeat::seed('N23', 'MANJOI', $tambun);
        ParliamentSeat::seed('N24', 'HULU KINTA', $tambun);

        //Perak - Ipoh Timor
		ParliamentSeat::seed('N25', 'CANNING', $ipohTimor);
        ParliamentSeat::seed('N26', 'TEBING TINGGI', $ipohTimor);
        ParliamentSeat::seed('N27', 'PASIR PINJI', $ipohTimor);

        //Perak - Ipoh Barat
		ParliamentSeat::seed('N28', 'BERCHAM', $ipohBarat);
        ParliamentSeat::seed('N29', 'KEPAYANG', $ipohBarat);
        ParliamentSeat::seed('N30', 'BUNTONG', $ipohBarat);

        //Perak - Batu Gajah
		ParliamentSeat::seed('N31', 'JELAPANG', $batuGajah);
        ParliamentSeat::seed('N32', 'MENGLEMBU', $batuGajah);
        ParliamentSeat::seed('N33', 'TRONOH', $batuGajah);

        //Perak - Kuala Kangsar
		ParliamentSeat::seed('N34', 'BUKIT CHANDAN', $kualaKangsar);
        ParliamentSeat::seed('N35', 'MANONG', $kualaKangsar);

        //Perak - Beruas
		ParliamentSeat::seed('N36', 'PENGKALAN BAHARU', $beruas);
        ParliamentSeat::seed('N37', 'PANTAI REMIS', $beruas);
        ParliamentSeat::seed('N38', 'ASTAKA', $beruas);

        //Perak - Parit
		ParliamentSeat::seed('N39', 'BELANJA', $parit);
        ParliamentSeat::seed('N40', 'BOTA', $parit);

        //Perak - Kampar
		ParliamentSeat::seed('N41', 'MALIM NAWAR', $kampar);
        ParliamentSeat::seed('N42', 'KERANJI', $kampar);
        ParliamentSeat::seed('N43', 'TUALANG SEKAH', $kampar);

        //Perak - Gopeng
		ParliamentSeat::seed('N44', 'SUNGAI RAPAT', $gopeng);
        ParliamentSeat::seed('N45', 'SIMPANG PULAI', $gopeng);
        ParliamentSeat::seed('N46', 'TEJA', $gopeng);

        //Perak - Tapah
		ParliamentSeat::seed('N47', 'CHENDERIANG', $tapah);
        ParliamentSeat::seed('N48', 'AYER KUNING', $tapah);

        //Perak - Pasir Salak
		ParliamentSeat::seed('N49', 'SUNGAI MANIK', $pasirSalak);
        ParliamentSeat::seed('N50', 'KAMPONG GAJAH', $pasirSalak);

        //Perak - Lumut
		ParliamentSeat::seed('N51', 'PASIR PANJANG', $lumut);
        ParliamentSeat::seed('N52', 'PANGKOR', $lumut);

        //Perak - Bagan Datuk
		ParliamentSeat::seed('N53', 'RUNGKUP', $baganDatuk);
        ParliamentSeat::seed('N54', 'HUTAN MELINTANG', $baganDatuk);

        //Perak - Teluk Intan
		ParliamentSeat::seed('N55', 'PASIR BEDAMAR', $telukIntan);
        ParliamentSeat::seed('N56', 'CHANGKAT JONG', $telukIntan);

        //Perak - Tanjong Malim
		ParliamentSeat::seed('N57', 'SUNGKAI', $tanjongMalim);
        ParliamentSeat::seed('N58', 'SLIM', $tanjongMalim);
        ParliamentSeat::seed('N59', 'BEHRANG', $tanjongMalim);

        //Pahang
        $cameronHighlands  = json_encode(['pCode' => 'P078']);
        $lipis  = json_encode(['pCode' => 'P079']);
        $raub  = json_encode(['pCode' => 'P080']);
        $jerantut  = json_encode(['pCode' => 'P081']);
        $inderaMahkota  = json_encode(['pCode' => 'P082']);
        $kuantan  = json_encode(['pCode' => 'P083']);
        $payaBesar  = json_encode(['pCode' => 'P084']);
        $pekan  = json_encode(['pCode' => 'P085']);
        $maran  = json_encode(['pCode' => 'P086']);
        $kualaKrau  = json_encode(['pCode' => 'P087']);
        $temerloh  = json_encode(['pCode' => 'P088']);
        $bentong  = json_encode(['pCode' => 'P089']);
        $bera  = json_encode(['pCode' => 'P090']);
        $rompin  = json_encode(['pCode' => 'P091']);

        //Pahang - Cameron Highlands
		ParliamentSeat::seed('N01', 'TANAH RATA', $cameronHighlands);
        ParliamentSeat::seed('N02', 'JELAI', $cameronHighlands);

        //Pahang - Lipis
		ParliamentSeat::seed('N03', 'PADANG TENGKU', $lipis);
        ParliamentSeat::seed('N04', 'CHEKA', $lipis);
        ParliamentSeat::seed('N05', 'BENTA', $lipis);

        //Pahang - Raub
		ParliamentSeat::seed('N06', 'BATU TALAM', $raub);
        ParliamentSeat::seed('N07', 'TRAS', $raub);
        ParliamentSeat::seed('N08', 'DONG', $raub);

        //Pahang - Jerantut
		ParliamentSeat::seed('N09', 'TAHAN', $jerantut);
        ParliamentSeat::seed('N10', 'DAMAK', $jerantut);
        ParliamentSeat::seed('N11', 'PULAU TAWAR', $jerantut);

        //Pahang - Indera Mahkota
		ParliamentSeat::seed('N12', 'BESERAH', $inderaMahkota);
        ParliamentSeat::seed('N13', 'SEMAMBU', $inderaMahkota);

        //Pahang - Kuantan
		ParliamentSeat::seed('N14', 'TERUNTUM', $kuantan);
        ParliamentSeat::seed('N15', 'TANJUNG LUMPUR', $kuantan);
        ParliamentSeat::seed('N16', 'INDERAPURA', $kuantan);

        //Pahang - Paya Besar
		ParliamentSeat::seed('N17', 'SUNGAI LEMBING', $payaBesar);
        ParliamentSeat::seed('N18', 'LEPAR', $payaBesar);
        ParliamentSeat::seed('N19', 'PANCHING', $payaBesar);

        //Pahang - Pekan
		ParliamentSeat::seed('N20', 'PULAU MANIS', $pekan);
        ParliamentSeat::seed('N21', 'PERAMU JAYA', $pekan);
        ParliamentSeat::seed('N22', 'BEBAR', $pekan);
        ParliamentSeat::seed('N23', 'CHINI', $pekan);

        //Pahang - Maran
		ParliamentSeat::seed('N24', 'LUIT', $maran);
        ParliamentSeat::seed('N25', 'KUALA SENTUL', $maran);
        ParliamentSeat::seed('N26', 'CHENOR', $maran);

        //Pahang - Kuala Krau
		ParliamentSeat::seed('N27', 'JENDERAK', $kualaKrau);
        ParliamentSeat::seed('N28', 'KERDAU', $kualaKrau);
        ParliamentSeat::seed('N29', 'JENGKA', $kualaKrau);

        //Pahang - Temerloh
		ParliamentSeat::seed('N30', 'MENTAKAB', $temerloh);
        ParliamentSeat::seed('N31', 'LANCHANG', $temerloh);
        ParliamentSeat::seed('N32', 'KUALA SEMANTAN', $temerloh);

        //Pahang - Bentong
		ParliamentSeat::seed('N33', 'BILUT', $bentong);
		ParliamentSeat::seed('N34', 'KETARI', $bentong);
        ParliamentSeat::seed('N35', 'SABAI', $bentong);
        ParliamentSeat::seed('N36', 'PELANGAI', $bentong);

        //Pahang - Bera
		ParliamentSeat::seed('N37', 'GUAI', $bera);
        ParliamentSeat::seed('N38', 'TRIANG', $bera);
        ParliamentSeat::seed('N39', 'KEMAYAN', $bera);

        //Pahang - Rompin
		ParliamentSeat::seed('N40', 'BUKIT IBAM', $rompin);
        ParliamentSeat::seed('N41', 'MUADZAM SHAH', $rompin);
        ParliamentSeat::seed('N42', 'TIOMAN', $rompin);

        //Selangor
        $sabakBernam = json_encode(['pCode' => 'P092']);
        $sungaiBesar = json_encode(['pCode' => 'P093']);
        $huluSelangor  = json_encode(['pCode' => 'P094']);
        $tanjongKarang  = json_encode(['pCode' => 'P095']);
        $kualaSelangor  = json_encode(['pCode' => 'P096']);
        $selayang  = json_encode(['pCode' => 'P097']);
        $gombak  = json_encode(['pCode' => 'P098']);
        $ampang  = json_encode(['pCode' => 'P099']);
        $pandan  = json_encode(['pCode' => 'P100']);
        $huluLangat  = json_encode(['pCode' => 'P101']);
        $bangi  = json_encode(['pCode' => 'P102']);
        $puchong  = json_encode(['pCode' => 'P103']);
        $subang  = json_encode(['pCode' => 'P104']);
        $petalingJaya  = json_encode(['pCode' => 'P105']);
        $damansara  = json_encode(['pCode' => 'P106']);
        $sungaiBuloh  = json_encode(['pCode' => 'P107']);
        $shahAlam  = json_encode(['pCode' => 'P108']);
        $kapar  = json_encode(['pCode' => 'P109']);
        $klang  = json_encode(['pCode' => 'P110']);
        $kotaRaja  = json_encode(['pCode' => 'P111']);
        $kualaLangat  = json_encode(['pCode' => 'P112']);
        $sepang  = json_encode(['pCode' => 'P113']);

        //Selangor - Sabak Bernam
		ParliamentSeat::seed('N01', 'SUNGAI AIR TAWAR', $sabakBernam);
        ParliamentSeat::seed('N02', 'SABAK', $sabakBernam);

        //Selangor - Sungai Besar
		ParliamentSeat::seed('N03', 'SUNGAI PANJANG', $sungaiBesar);
        ParliamentSeat::seed('N04', 'SEKINCHAN', $sungaiBesar);

        //Selangor - Hulu Selangor
		ParliamentSeat::seed('N05', 'HULU BERNAM', $huluSelangor);
        ParliamentSeat::seed('N06', 'KUALA KUBU BAHARU', $huluSelangor);
        ParliamentSeat::seed('N07', 'BATANG KALI', $huluSelangor);

        //Selangor - Tanjong Karang
		ParliamentSeat::seed('N08', 'SUNGAI BURONG', $tanjongKarang);
        ParliamentSeat::seed('N09', 'PERMATANG', $tanjongKarang);

        //Selangor - Kuala Selangor
		ParliamentSeat::seed('N10', 'BUKIT MELAWATI', $kualaSelangor);
        ParliamentSeat::seed('N11', 'IJOK', $kualaSelangor);
        ParliamentSeat::seed('N12', 'JERAM', $kualaSelangor);

        //Selangor - Selayang
		ParliamentSeat::seed('N13', 'KUANG', $selayang);
        ParliamentSeat::seed('N14', 'RAWANG', $selayang);
        ParliamentSeat::seed('N15', 'TAMAN TEMPLER', $selayang);

        //Selangor - Gombak
		ParliamentSeat::seed('N16', 'SUNGAI TUA', $gombak);
        ParliamentSeat::seed('N17', 'GOMBAK SETIA', $gombak);
        ParliamentSeat::seed('N18', 'HULU KELANG', $gombak);

        //Selangor - Ampang
		ParliamentSeat::seed('N19', 'BUKIT ANTARABANGSA', $ampang);
        ParliamentSeat::seed('N20', 'LEMBAH JAYA', $ampang);

        //Selangor - Pandan
		ParliamentSeat::seed('N21', 'PANDAN INDAH', $pandan);
        ParliamentSeat::seed('N22', 'TERATAI', $pandan);

        //Selangor - Hulu Langat
		ParliamentSeat::seed('N23', 'DUSUN TUA', $huluLangat);
        ParliamentSeat::seed('N24', 'SEMENYIH', $huluLangat);

        //Selangor - Bangi
		ParliamentSeat::seed('N25', 'KAJANG', $bangi);
        ParliamentSeat::seed('N26', 'SUNGAI RAMAL', $bangi);
        ParliamentSeat::seed('N27', 'BALAKONG', $bangi);

        //Selangor - Puchong
		ParliamentSeat::seed('N28', 'SERI KEMBANGAN', $puchong);
        ParliamentSeat::seed('N29', 'SERI SERDANG', $puchong);

        //Selangor - Subang
		ParliamentSeat::seed('N30', 'KINRARA', $subang);
        ParliamentSeat::seed('N31', 'SUBANG JAYA', $subang);

        //Selangor - Petaling Jaya
		ParliamentSeat::seed('N32', 'SERI SETIA', $petalingJaya);
        ParliamentSeat::seed('N33', 'TAMAN MEDAN', $petalingJaya);
        ParliamentSeat::seed('N34', 'BUKIT GASING', $petalingJaya);

        //Selangor - Damansara
		ParliamentSeat::seed('N35', 'KAMPUNG TUNKU', $damansara);
        ParliamentSeat::seed('N36', 'BANDAR UTAMA', $damansara);
        ParliamentSeat::seed('N37', 'BUKIT LANJAN', $damansara);

        //Selangor - Sungai Buloh
		ParliamentSeat::seed('N38', 'PAYA JARAS', $sungaiBuloh);
        ParliamentSeat::seed('N39', 'KOTA DAMANSARA', $sungaiBuloh);

        //Selangor - Shah Alam
		ParliamentSeat::seed('N40', 'KOTA ANGGERIK', $shahAlam);
        ParliamentSeat::seed('N41', 'BATU TIGA', $shahAlam);

        //Selangor - Kapar
		ParliamentSeat::seed('N42', 'MERU', $kapar);
		ParliamentSeat::seed('N43', 'SEMENTA', $kapar);
        ParliamentSeat::seed('N44', 'SELAT KLANG', $kapar);

        //Selangor - Klang
		ParliamentSeat::seed('N45', 'BANDAR BARU KLANG', $klang);
        ParliamentSeat::seed('N46', 'PELABUHAN KLANG', $klang);
        ParliamentSeat::seed('N47', 'PANDAMARAN', $klang);

        //Selangor - Kota Raja
		ParliamentSeat::seed('N48', 'SENTOSA', $kotaRaja);
        ParliamentSeat::seed('N49', 'SUNGAI KANDIS', $kotaRaja);
        ParliamentSeat::seed('N50', 'KOTA KEMUNING', $kotaRaja);

        //Selangor - Kuala Langat
		ParliamentSeat::seed('N51', 'SIJANGKANG', $kualaLangat);
        ParliamentSeat::seed('N52', 'BANTING', $kualaLangat);
        ParliamentSeat::seed('N53', 'MORIB', $kualaLangat);

        //Selangor - Sepang
		ParliamentSeat::seed('N54', 'TANJONG SEPAT', $sepang);
        ParliamentSeat::seed('N55', 'DENGKIL', $sepang);
        ParliamentSeat::seed('N56', 'SUNGAI PELEK', $sepang);

        //Negeri Sembilan
        $jelebu = json_encode(['pCode' => 'P126']);
        $jempol = json_encode(['pCode' => 'P127']);
        $seremban = json_encode(['pCode' => 'P128']);
        $kualaPilah = json_encode(['pCode' => 'P129']);
        $rasah = json_encode(['pCode' => 'P130']);
        $rembau = json_encode(['pCode' => 'P131']);
        $portDickson = json_encode(['pCode' => 'P132']);
        $tampin = json_encode(['pCode' => 'P133']);

        //Negeri Sembilan - Jelebu
		ParliamentSeat::seed('N01', 'CHENNAH', $jelebu);
        ParliamentSeat::seed('N02', 'PERTANG', $jelebu);
        ParliamentSeat::seed('N03', 'SUNGAI LUI', $jelebu);
        ParliamentSeat::seed('N04', 'KLAWANG', $jelebu);

        //Negeri Sembilan - Jempol
		ParliamentSeat::seed('N05', 'SERTING', $jempol);
        ParliamentSeat::seed('N06', 'PALONG', $jempol);
        ParliamentSeat::seed('N07', 'JERAM PADANG', $jempol);
        ParliamentSeat::seed('N08', 'BAHAU', $jempol);

        //Negeri Sembilan - Seremban
		ParliamentSeat::seed('N09', 'LENGGENG', $seremban);
        ParliamentSeat::seed('N10', 'NILAI', $seremban);
        ParliamentSeat::seed('N11', 'LOBAK', $seremban);
        ParliamentSeat::seed('N12', 'TEMIANG', $seremban);
        ParliamentSeat::seed('N13', 'SIKAMAT', $seremban);
        ParliamentSeat::seed('N14', 'AMPANGAN', $seremban);

        //Negeri Sembilan - Kuala Pilah
		ParliamentSeat::seed('N15', 'JUASSEH', $kualaPilah);
        ParliamentSeat::seed('N16', 'SERI MENANTI', $kualaPilah);
        ParliamentSeat::seed('N17', 'SENALING', $kualaPilah);
        ParliamentSeat::seed('N18', 'PILAH', $kualaPilah);
        ParliamentSeat::seed('N19', 'JOHOL', $kualaPilah);

        //Negeri Sembilan - Rasah
		ParliamentSeat::seed('N20', 'LABU', $rasah);
        ParliamentSeat::seed('N21', 'BUKIT KEPAYANG', $rasah);
        ParliamentSeat::seed('N22', 'RAHANG', $rasah);
        ParliamentSeat::seed('N23', 'MAMBAU', $rasah);
        ParliamentSeat::seed('N24', 'SEREMBAN JAYA', $rasah);

        //Negeri Sembilan - Rembau
		ParliamentSeat::seed('N25', 'PAROI', $rembau);
        ParliamentSeat::seed('N26', 'CHEMBONG', $rembau);
        ParliamentSeat::seed('N27', 'RANTAU', $rembau);
        ParliamentSeat::seed('N28', 'KOTA', $rembau);

        //Negeri Sembilan - Port Dickson
		ParliamentSeat::seed('N29', 'CHUAH', $portDickson);
        ParliamentSeat::seed('N30', 'LUKUT', $portDickson);
        ParliamentSeat::seed('N31', 'BAGAN PINANG', $portDickson);
        ParliamentSeat::seed('N32', 'LINGGI', $portDickson);
        ParliamentSeat::seed('N33', 'SRI TANJUNG', $portDickson);

        //Negeri Sembilan - Tampin
		ParliamentSeat::seed('N34', 'GEMAS', $tampin);
        ParliamentSeat::seed('N35', 'GEMENCHEH', $tampin);
        ParliamentSeat::seed('N36', 'REPAH', $tampin);

        //Melaka
        $masjidTanah = json_encode(['pCode' => 'P134']);
        $alorGajah = json_encode(['pCode' => 'P135']);
        $tanggaBatu = json_encode(['pCode' => 'P136']);
        $hangTuahJaya = json_encode(['pCode' => 'P137']);
        $kotaMelaka = json_encode(['pCode' => 'P138']);
        $jasin = json_encode(['pCode' => 'P139']);

        //Melaka - Masjid Tanah
		ParliamentSeat::seed('N01', 'KUALA LINGGI', $masjidTanah);
        ParliamentSeat::seed('N02', 'TANJUNG BIDARA', $masjidTanah);
        ParliamentSeat::seed('N03', 'AYER LIMAU', $masjidTanah);
        ParliamentSeat::seed('N04', 'LENDU', $masjidTanah);
        ParliamentSeat::seed('N05', 'TABIH NANING', $masjidTanah);

        //Melaka - Alor Gajah
		ParliamentSeat::seed('N06', 'REMBIA', $alorGajah);
        ParliamentSeat::seed('N07', 'GADEK', $alorGajah);
        ParliamentSeat::seed('N08', 'MACHAP JAYA', $alorGajah);
        ParliamentSeat::seed('N09', 'DURIAN TUNGGAL', $alorGajah);
        ParliamentSeat::seed('N10', 'ASAHAN', $alorGajah);

        //Melaka - Tangga Batu
		ParliamentSeat::seed('N11', 'SUNGAI UDANG', $tanggaBatu);
        ParliamentSeat::seed('N12', 'PANTAI KUNDOR', $tanggaBatu);
        ParliamentSeat::seed('N13', 'PAYA RUMPUT', $tanggaBatu);
        ParliamentSeat::seed('N14', 'KELEBANG', $tanggaBatu);

        //Melaka - Hang Tuah Jaya
		ParliamentSeat::seed('N15', 'PENGKALAN BATU', $hangTuahJaya);
        ParliamentSeat::seed('N16', 'AYER KEROH', $hangTuahJaya);
        ParliamentSeat::seed('N17', 'BUKIT KATIL', $hangTuahJaya);
        ParliamentSeat::seed('N18', 'AYER MOLEK', $hangTuahJaya);

        //Melaka - Kota Melaka
		ParliamentSeat::seed('N19', 'KESIDANG', $kotaMelaka);
        ParliamentSeat::seed('N20', 'KOTA LAKSAMANA', $kotaMelaka);
        ParliamentSeat::seed('N21', 'DUYONG', $kotaMelaka);
        ParliamentSeat::seed('N22', 'BANDAR HILIR', $kotaMelaka);
        ParliamentSeat::seed('N23', 'TELOK MAS', $kotaMelaka);

        //Melaka - Jasin
		ParliamentSeat::seed('N24', 'BEMBAN', $jasin);
        ParliamentSeat::seed('N25', 'RIM', $jasin);
        ParliamentSeat::seed('N26', 'SERKAM', $jasin);
        ParliamentSeat::seed('N27', 'MERLIMAU', $jasin);
        ParliamentSeat::seed('N28', 'SUNGAI RAMBAI', $jasin);

        //Johor
        $segamat = json_encode(['pCode' => 'P140']);
        $sekijang = json_encode(['pCode' => 'P141']);
        $labis = json_encode(['pCode' => 'P142']);
        $pagoh = json_encode(['pCode' => 'P143']);
        $ledang = json_encode(['pCode' => 'P144']);
        $bakri = json_encode(['pCode' => 'P145']);
        $muar = json_encode(['pCode' => 'P146']);
        $paritSulong = json_encode(['pCode' => 'P147']);
        $ayerHitam = json_encode(['pCode' => 'P148']);
        $sriGading = json_encode(['pCode' => 'P149']);
        $batuPahat = json_encode(['pCode' => 'P150']);
        $simpangRenggam = json_encode(['pCode' => 'P151']);
        $kluang = json_encode(['pCode' => 'P152']);
        $sembrong = json_encode(['pCode' => 'P153']);
        $mersing = json_encode(['pCode' => 'P154']);
        $tenggara = json_encode(['pCode' => 'P155']);
        $kotaTinggi = json_encode(['pCode' => 'P156']);
        $pengerang = json_encode(['pCode' => 'P157']);
        $tebrau = json_encode(['pCode' => 'P158']);
        $pasirGudang = json_encode(['pCode' => 'P159']);
        $johorBahru = json_encode(['pCode' => 'P160']);
        $pulai = json_encode(['pCode' => 'P161']);
        $iskandarPuteri = json_encode(['pCode' => 'P162']);
        $kulai = json_encode(['pCode' => 'P163']);
        $pontian = json_encode(['pCode' => 'P164']);
        $tanjungPiai = json_encode(['pCode' => 'P165']);

        //Johor - Segamat
		ParliamentSeat::seed('N01', 'BULOH KASAP', $segamat);
        ParliamentSeat::seed('N02', 'JEMENTAH', $segamat);

        //Johor - Sekijang
		ParliamentSeat::seed('N03', 'PEMANIS', $sekijang);
        ParliamentSeat::seed('N04', 'KEMELAH', $sekijang);

        //Johor - Labis
		ParliamentSeat::seed('N05', 'TENANG', $labis);
        ParliamentSeat::seed('N06', 'BEKOK', $labis);

        //Johor - Pagoh
		ParliamentSeat::seed('N07', 'BUKIT KEPONG', $pagoh);
        ParliamentSeat::seed('N08', 'BUKIT PASIR', $pagoh);

        //Johor - Ledang
		ParliamentSeat::seed('N09', 'GAMBIR', $ledang);
        ParliamentSeat::seed('N10', 'TANGKAK', $ledang);
        ParliamentSeat::seed('N11', 'SEROM', $ledang);

        //Johor - Bakri
		ParliamentSeat::seed('N12', 'BENTAYAN', $bakri);
        ParliamentSeat::seed('N13', 'SIMPANG JERAM', $bakri);
        ParliamentSeat::seed('N14', 'BUKIT NANING', $bakri);

        //Johor - Muar
		ParliamentSeat::seed('N15', 'MAHARANI', $muar);
        ParliamentSeat::seed('N16', 'SUNGAI BALANG', $muar);

        //Johor - Parit Sulong
		ParliamentSeat::seed('N17', 'SEMERAH', $paritSulong);
        ParliamentSeat::seed('N18', 'SRI MEDAN', $paritSulong);

        //Johor - Ayer Hitam
		ParliamentSeat::seed('N19', 'YONG PENG', $ayerHitam);
        ParliamentSeat::seed('N20', 'SEMARANG', $ayerHitam);

        //Johor - Sri Gading
		ParliamentSeat::seed('N21', 'PARIT YAANI', $sriGading);
        ParliamentSeat::seed('N22', 'PARIT RAJA', $sriGading);

        //Johor - Batu Pahat
		ParliamentSeat::seed('N23', 'PENGGARAM', $batuPahat);
        ParliamentSeat::seed('N24', 'SENGGARANG', $batuPahat);
        ParliamentSeat::seed('N25', 'RENGIT', $batuPahat);

        //Johor - Simpang Renggam
		ParliamentSeat::seed('N26', 'MACHAP', $simpangRenggam);
        ParliamentSeat::seed('N27', 'LAYANG-LAYANG', $simpangRenggam);

        //Johor - Kluang
		ParliamentSeat::seed('N28', 'MENGKIBOL', $kluang);
        ParliamentSeat::seed('N29', 'MAHKOTA', $kluang);

        //Johor - Sembrong
		ParliamentSeat::seed('N30', 'PALOH', $sembrong);
        ParliamentSeat::seed('N31', 'KAHANG', $sembrong);

        //Johor - Mersing
		ParliamentSeat::seed('N32', 'ENDAU', $mersing);
        ParliamentSeat::seed('N33', 'TENGGAROH', $mersing);

        //Johor - Tenggara
		ParliamentSeat::seed('N34', 'PANTI', $tenggara);
        ParliamentSeat::seed('N35', 'PASIR RAJA', $tenggara);

        //Johor - Kota Tinggi
		ParliamentSeat::seed('N36', 'SEDILI', $kotaTinggi);
        ParliamentSeat::seed('N37', 'JOHOR LAMA', $kotaTinggi);

        //Johor - Pengerang
		ParliamentSeat::seed('N38', 'PENAWAR', $pengerang);
        ParliamentSeat::seed('N39', 'TANJUNG SURAT', $pengerang);

        //Johor - Tebrau
		ParliamentSeat::seed('N40', 'TIRAM', $tebrau);
        ParliamentSeat::seed('N41', 'PUTERI WANGSA', $tebrau);

        //Johor - Pasir Gudang
		ParliamentSeat::seed('N42', 'JOHOR JAYA', $pasirGudang);
        ParliamentSeat::seed('N43', 'PERMAS', $pasirGudang);

        //Johor - Johor Bahru
		ParliamentSeat::seed('N44', 'LARKIN', $johorBahru);
        ParliamentSeat::seed('N45', 'STULANG', $johorBahru);

        //Johor - Pulai
		ParliamentSeat::seed('N46', 'PERLING', $pulai);
        ParliamentSeat::seed('N47', 'KEMPAS', $pulai);

        //Johor - Iskandar Puteri
		ParliamentSeat::seed('N48', 'SKUDAI', $iskandarPuteri);
        ParliamentSeat::seed('N49', 'KOTA ISKANDAR', $iskandarPuteri);

        //Johor - Kulai
		ParliamentSeat::seed('N50', 'BUKIT PERMAI', $kulai);
        ParliamentSeat::seed('N51', 'BUKIT BATU', $kulai);
        ParliamentSeat::seed('N52', 'SENAI', $kulai);

        //Johor - Pontian
		ParliamentSeat::seed('N53', 'BENUT', $pontian);
        ParliamentSeat::seed('N54', 'PULAI SEBATANG', $pontian);

        //Johor - Tanjung Piai
		ParliamentSeat::seed('N55', 'PEKAN NANAS', $tanjungPiai);
        ParliamentSeat::seed('N56', 'KUKUP', $tanjungPiai);

        //Sabah
        $kudat = json_encode(['pCode' => 'P167']);
        $kotaMarudu = json_encode(['pCode' => 'P168']);
        $kotaBelud = json_encode(['pCode' => 'P169']);
        $tuaran = json_encode(['pCode' => 'P170']);
        $sepanggar = json_encode(['pCode' => 'P171']);
        $kotaKinabalu = json_encode(['pCode' => 'P172']);
        $putatan = json_encode(['pCode' => 'P173']);
        $penampang = json_encode(['pCode' => 'P174']);
        $papar = json_encode(['pCode' => 'P175']);
        $kimanis = json_encode(['pCode' => 'P176']);
        $beaufort = json_encode(['pCode' => 'P177']);
        $sipitang = json_encode(['pCode' => 'P178']);
        $ranau = json_encode(['pCode' => 'P179']);
        $keningau = json_encode(['pCode' => 'P180']);
        $tenom = json_encode(['pCode' => 'P181']);
        $pensiangan = json_encode(['pCode' => 'P182']);
        $beluran = json_encode(['pCode' => 'P183']);
        $libaran = json_encode(['pCode' => 'P184']);
        $batuSapi = json_encode(['pCode' => 'P185']);
        $sandakan = json_encode(['pCode' => 'P186']);
        $kinabatangan = json_encode(['pCode' => 'P187']);
        $lahadDatu = json_encode(['pCode' => 'P188']);
        $semporna = json_encode(['pCode' => 'P189']);
        $tawau = json_encode(['pCode' => 'P190']);
        $kalabakan = json_encode(['pCode' => 'P191']);

        //Sabah - Kudat
		ParliamentSeat::seed('N01', 'BANGGI', $kudat);
        ParliamentSeat::seed('N02', 'BENGKOKA', $kudat);
        ParliamentSeat::seed('N03', 'PITAS', $kudat);
        ParliamentSeat::seed('N04', 'TANJONG KAPOR', $kudat);

        //Sabah - Kota Marudu
		ParliamentSeat::seed('N05', 'MATUNGGONG', $kotaMarudu);
        ParliamentSeat::seed('N06', 'BANDAU', $kotaMarudu);
        ParliamentSeat::seed('N07', 'TANDEK', $kotaMarudu);

        //Sabah - Kota Belud
		ParliamentSeat::seed('N08', 'PINTASAN', $kotaBelud);
        ParliamentSeat::seed('N09', 'TEMPASUK', $kotaBelud);
        ParliamentSeat::seed('N10', 'USUKAN', $kotaBelud);
        ParliamentSeat::seed('N11', 'KADAMAIAN', $kotaBelud);

        //Sabah - Tuaran
		ParliamentSeat::seed('N12', 'SULAMAN', $tuaran);
        ParliamentSeat::seed('N13', 'PANTAI DALIT', $tuaran);
        ParliamentSeat::seed('N14', 'TAMPARULI', $tuaran);
        ParliamentSeat::seed('N15', 'KIULU', $tuaran);

        //Sabah - Sepanggar
		ParliamentSeat::seed('N16', 'KARAMBUNAI', $sepanggar);
        ParliamentSeat::seed('N17', 'DARAU', $sepanggar);
        ParliamentSeat::seed('N18', 'INANAM', $sepanggar);

        //Sabah - Kota Kinabalu
		ParliamentSeat::seed('N19', 'LIKAS', $kotaKinabalu);
        ParliamentSeat::seed('N20', 'API-API', $kotaKinabalu);
        ParliamentSeat::seed('N21', 'LUYANG', $kotaKinabalu);

        //Sabah - Putatan
		ParliamentSeat::seed('N22', 'TANJUNG ARU', $putatan);
        ParliamentSeat::seed('N23', 'PETAGAS', $putatan);
        ParliamentSeat::seed('N24', 'TANJUNG KERAMAT', $putatan);

        //Sabah - Penampang
		ParliamentSeat::seed('N25', 'KAPAYAN', $penampang);
        ParliamentSeat::seed('N26', 'MOYOG', $penampang);

        //Sabah - Papar
		ParliamentSeat::seed('N27', 'LIMBAHAU', $papar);
        ParliamentSeat::seed('N28', 'KAWANG', $papar);
        ParliamentSeat::seed('N29', 'PANTAI MANIS', $papar);

        //Sabah - Kimanis
		ParliamentSeat::seed('N30', 'BONGAWAN', $kimanis);
        ParliamentSeat::seed('N31', 'MEMBAKUT', $kimanis);

        //Sabah - Beaufort
		ParliamentSeat::seed('N32', 'KLIAS', $beaufort);
        ParliamentSeat::seed('N33', 'KUALA PENYU', $beaufort);

        //Sabah - Sipitang
		ParliamentSeat::seed('N34', 'LUMADAN', $sipitang);
        ParliamentSeat::seed('N35', 'SINDUMIN', $sipitang);

        //Sabah - Ranau
		ParliamentSeat::seed('N36', 'KUNDASANG', $ranau);
        ParliamentSeat::seed('N37', 'KARANAAN', $ranau);
        ParliamentSeat::seed('N38', 'PAGINATAN', $ranau);

        //Sabah - Keningau
		ParliamentSeat::seed('N39', 'TAMBUNAN', $keningau);
        ParliamentSeat::seed('N40', 'BINGKOR', $keningau);
        ParliamentSeat::seed('N41', 'LIAWAN', $keningau);

        //Sabah - Tenom
		ParliamentSeat::seed('N42', 'MELALAP', $tenom);
        ParliamentSeat::seed('N43', 'KEMABONG', $tenom);

        //Sabah - Pensiangan
		ParliamentSeat::seed('N44', 'TULID', $pensiangan);
        ParliamentSeat::seed('N45', 'SOOK', $pensiangan);
        ParliamentSeat::seed('N46', 'NABAWAN', $pensiangan);

        //Sabah - Beluran
		ParliamentSeat::seed('N47', 'TELUPID', $beluran);
        ParliamentSeat::seed('N48', 'SUGUT', $beluran);
        ParliamentSeat::seed('N49', 'LABUK', $beluran);

        //Sabah - Libaran
		ParliamentSeat::seed('N50', 'GUM-GUM', $libaran);
        ParliamentSeat::seed('N51', 'SUNGAI MANILA', $libaran);
        ParliamentSeat::seed('N52', 'SUNGAI SIBUGA', $libaran);

        //Sabah - Batu Sapi
		ParliamentSeat::seed('N53', 'SEKONG', $batuSapi);
        ParliamentSeat::seed('N54', 'KARAMUNTING', $batuSapi);

        //Sabah - Sandakan
		ParliamentSeat::seed('N55', 'ELOPURA', $sandakan);
        ParliamentSeat::seed('N56', 'TANJONG PAPAT', $sandakan);

        //Sabah - Kinabatangan
		ParliamentSeat::seed('N57', 'KUAMUT', $kinabatangan);
        ParliamentSeat::seed('N58', 'LAMAG', $kinabatangan);
        ParliamentSeat::seed('N59', 'SUKAU', $kinabatangan);

        //Sabah - Lahad Datu
		ParliamentSeat::seed('N60', 'TUNGKU', $lahadDatu);
        ParliamentSeat::seed('N61', 'SEGAMA', $lahadDatu);
        ParliamentSeat::seed('N62', 'SILAM', $lahadDatu);
        ParliamentSeat::seed('N63', 'KUNAK', $lahadDatu);

        //Sabah - Semporna
		ParliamentSeat::seed('N64', 'SULABAYAN', $semporna);
        ParliamentSeat::seed('N65', 'SENALLANG', $semporna);
        ParliamentSeat::seed('N66', 'BUGAYA', $semporna);

        //Sabah - Tawau
		ParliamentSeat::seed('N67', 'BALUNG', $tawau);
        ParliamentSeat::seed('N68', 'APAS', $tawau);
        ParliamentSeat::seed('N69', 'SRI TANJONG', $tawau);

        //Sabah - Kalabakan
		ParliamentSeat::seed('N70', 'KUKUSAN', $kalabakan);
        ParliamentSeat::seed('N71', 'TANJUNG BATU', $kalabakan);
        ParliamentSeat::seed('N72', 'MEROTAI', $kalabakan);
        ParliamentSeat::seed('N73', 'SEBATIK', $kalabakan);

        //Sarawak
        $masGading = json_encode(['pCode' => 'P192']);
        $santubong = json_encode(['pCode' => 'P193']);
        $petraJaya = json_encode(['pCode' => 'P194']);
        $bandarKuching = json_encode(['pCode' => 'P195']);
        $stampin = json_encode(['pCode' => 'P196']);
        $kotaSamarahan = json_encode(['pCode' => 'P197']);
        $puncakBorneo = json_encode(['pCode' => 'P198']);
        $serian = json_encode(['pCode' => 'P199']);
        $batangSadong = json_encode(['pCode' => 'P200']);
        $batangLupar = json_encode(['pCode' => 'P201']);
        $sriAman = json_encode(['pCode' => 'P202']);
        $lubokAntu = json_encode(['pCode' => 'P203']);
        $betong = json_encode(['pCode' => 'P204']);
        $saratok = json_encode(['pCode' => 'P205']);
        $tanjongManis = json_encode(['pCode' => 'P206']);
        $igan = json_encode(['pCode' => 'P207']);
        $sarikei = json_encode(['pCode' => 'P208']);
        $julau = json_encode(['pCode' => 'P209']);
        $kanowit = json_encode(['pCode' => 'P210']);
        $lanang = json_encode(['pCode' => 'P211']);
        $sibu = json_encode(['pCode' => 'P212']);
        $mukah = json_encode(['pCode' => 'P213']);
        $selangau = json_encode(['pCode' => 'P214']);
        $kapit = json_encode(['pCode' => 'P215']);
        $huluRajang = json_encode(['pCode' => 'P216']);
        $bintulu = json_encode(['pCode' => 'P217']);
        $sibuti = json_encode(['pCode' => 'P218']);
        $miri = json_encode(['pCode' => 'P219']);
        $baram = json_encode(['pCode' => 'P220']);
        $limbang = json_encode(['pCode' => 'P221']);
        $lawas = json_encode(['pCode' => 'P222']);

        //Sarawak - Mas Gading
		ParliamentSeat::seed('N01', 'OPAR', $masGading);
        ParliamentSeat::seed('N02', 'TASIK BIRU', $masGading);

        //Sarawak - Santubong
		ParliamentSeat::seed('N03', 'TANJUNG DATU', $santubong);
        ParliamentSeat::seed('N04', 'PANTAI DAMAI', $santubong);
        ParliamentSeat::seed('N05', 'DEMAK LAUT', $santubong);

        //Sarawak - Petra Jaya
		ParliamentSeat::seed('N06', 'TUPONG', $petraJaya);
        ParliamentSeat::seed('N07', 'SAMARIANG', $petraJaya);
        ParliamentSeat::seed('N08', 'SATOK', $petraJaya);

        //Sarawak - Bandar Kuching
		ParliamentSeat::seed('N09', 'PADUNGAN', $bandarKuching);
        ParliamentSeat::seed('N10', 'PENDING', $bandarKuching);
        ParliamentSeat::seed('N11', 'BATU LINTANG', $bandarKuching);

        //Sarawak - Stampin
		ParliamentSeat::seed('N12', 'KOTA SENTOSA', $stampin);
        ParliamentSeat::seed('N13', 'BATU KITANG', $stampin);
        ParliamentSeat::seed('N14', 'BATU KAWAH', $stampin);

        //Sarawak - Kota Samarahan
		ParliamentSeat::seed('N15', 'ASAJAYA', $kotaSamarahan);
        ParliamentSeat::seed('N16', 'MUARA TUANG', $kotaSamarahan);
        ParliamentSeat::seed('N17', 'STAKAN', $kotaSamarahan);

        //Sarawak - Puncak Borneo
		ParliamentSeat::seed('N18', 'SEREMBU', $puncakBorneo);
        ParliamentSeat::seed('N19', 'MAMBONG', $puncakBorneo);
        ParliamentSeat::seed('N20', 'TARAT', $puncakBorneo);

        //Sarawak - Serian
		ParliamentSeat::seed('N21', 'TEBEDU', $serian);
        ParliamentSeat::seed('N22', 'KEDUP', $serian);
        ParliamentSeat::seed('N23', 'BUKIT SEMUJA', $serian);

        //Sarawak - Batang Sadong
		ParliamentSeat::seed('N24', 'SADONG JAYA', $batangSadong);
        ParliamentSeat::seed('N25', 'SIMUNJAN', $batangSadong);
        ParliamentSeat::seed('N26', 'GEDONG', $batangSadong);

        //Sarawak - Batang Lupar
		ParliamentSeat::seed('N27', 'SEBUYAU', $batangLupar);
        ParliamentSeat::seed('N28', 'LINGGA', $batangLupar);
        ParliamentSeat::seed('N29', 'BETING MARO', $batangLupar);

        //Sarawak - Sri Aman
		ParliamentSeat::seed('N30', 'BALAI RINGIN', $sriAman);
        ParliamentSeat::seed('N31', 'BUKIT BEGUNAN', $sriAman);
        ParliamentSeat::seed('N32', 'SIMANGGANG', $sriAman);

        //Sarawak - Lubok Antu
		ParliamentSeat::seed('N33', 'ENGKILILI', $lubokAntu);
        ParliamentSeat::seed('N34', 'BATANG AI', $lubokAntu);

        //Sarawak - Betong
		ParliamentSeat::seed('N35', 'SARIBAS', $betong);
        ParliamentSeat::seed('N36', 'LAYAR', $betong);
        ParliamentSeat::seed('N37', 'BUKIT SABAN', $betong);

        //Sarawak - Saratok
		ParliamentSeat::seed('N38', 'KALAKA', $saratok);
        ParliamentSeat::seed('N39', 'KRIAN', $saratok);
        ParliamentSeat::seed('N40', 'KABONG', $saratok);

        //Sarawak - Tanjong Manis
		ParliamentSeat::seed('N41', 'KUALA RAJANG', $tanjongManis);
        ParliamentSeat::seed('N42', 'SEMOP', $tanjongManis);

        //Sarawak - Igan
		ParliamentSeat::seed('N43', 'DARO', $igan);
        ParliamentSeat::seed('N44', 'JEMORENG', $igan);

        //Sarawak - Sarikei
		ParliamentSeat::seed('N45', 'REPOK', $sarikei);
        ParliamentSeat::seed('N46', 'MERADONG', $sarikei);

        //Sarawak - Julau
		ParliamentSeat::seed('N47', 'PAKAN', $julau);
        ParliamentSeat::seed('N48', 'MELUAN', $julau);

        //Sarawak - Kanowit
		ParliamentSeat::seed('N49', 'NGEMAH', $kanowit);
        ParliamentSeat::seed('N50', 'MACHAN', $kanowit);

        //Sarawak - Lanang
		ParliamentSeat::seed('N51', 'BUKIT ASSEK', $lanang);
        ParliamentSeat::seed('N52', 'DUDONG', $lanang);

        //Sarawak - Sibu
		ParliamentSeat::seed('N53', 'BAWANG ASSAN', $sibu);
        ParliamentSeat::seed('N54', 'PELAWAN', $sibu);
        ParliamentSeat::seed('N55', 'NANGKA', $sibu);

        //Sarawak - Mukah
		ParliamentSeat::seed('N56', 'DALAT', $mukah);
        ParliamentSeat::seed('N57', 'TELLIAN', $mukah);
        ParliamentSeat::seed('N58', 'BALINGIAN', $mukah);

        //Sarawak - Selangau
		ParliamentSeat::seed('N59', 'TAMIN', $selangau);
        ParliamentSeat::seed('N60', 'KAKUS', $selangau);

        //Sarawak - Kapit
		ParliamentSeat::seed('N61', 'PELAGUS', $kapit);
        ParliamentSeat::seed('N62', 'KATIBAS', $kapit);
        ParliamentSeat::seed('N63', 'BUKIT GORAM', $kapit);

        //Sarawak - Hulu Rajang
		ParliamentSeat::seed('N64', 'BELEH', $huluRajang);
        ParliamentSeat::seed('N65', 'BELAGA', $huluRajang);
        ParliamentSeat::seed('N66', 'MURUM', $huluRajang);

        //Sarawak - Bintulu
		ParliamentSeat::seed('N67', 'JEPAK', $bintulu);
        ParliamentSeat::seed('N68', 'TANJONG BATU', $bintulu);
        ParliamentSeat::seed('N69', 'KEMENA', $bintulu);
        ParliamentSeat::seed('N70', 'SAMALAJU', $bintulu);

        //Sarawak - Sibuti
		ParliamentSeat::seed('N71', 'BEKENU', $sibuti);
        ParliamentSeat::seed('N72', 'LAMBIR', $sibuti);

        //Sarawak - Miri
		ParliamentSeat::seed('N73', 'PIASAU', $miri);
        ParliamentSeat::seed('N74', 'PUJUT', $miri);
        ParliamentSeat::seed('N75', 'SENADIN', $miri);

        //Sarawak - Baram
		ParliamentSeat::seed('N76', 'MARUDI', $baram);
        ParliamentSeat::seed('N77', 'TELANG USAN', $baram);
        ParliamentSeat::seed('N78', 'MULU', $baram);

        //Sarawak - Limbang
		ParliamentSeat::seed('N79', 'BUKIT KOTA', $limbang);
        ParliamentSeat::seed('N80', 'BATU DANAU', $limbang);

        //Sarawak - Lawas
		ParliamentSeat::seed('N81', "BA'KELALAN", $lawas);
        ParliamentSeat::seed('N82', 'BUKIT SARI', $lawas);
    }
}
