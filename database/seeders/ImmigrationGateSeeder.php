<?php

namespace Database\Seeders;

use App\Models\Kru\ImmigrationGate;
use Illuminate\Database\Seeder;

class ImmigrationGateSeeder extends Seeder
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

        ImmigrationGate::seed('PADANG BESAR (STESEN KERETAPI)','DARAT',$prls);
        ImmigrationGate::seed('PADANG BESAR (LANDASAN KERETAPI)','DARAT',$prls);
        ImmigrationGate::seed('PADANG BESAR (KOMPLEKS IMIGRESEN ICQ)','DARAT',$prls);
        ImmigrationGate::seed('WANG KELIAN','DARAT',$prls);
        
        ImmigrationGate::seed('KOMPLEKS ICQS BUKIT KAYU HITAM','DARAT',$kdh);
        ImmigrationGate::seed('DURIAN BURUNG, KOTA PUTRA (DAERAH PADANG TERAP)','DARAT',$kdh);
        ImmigrationGate::seed('JETI KUAH LANGKAWI','LAUT',$kdh);
        ImmigrationGate::seed('TELUK EWA LANGKAWI','LAUT',$kdh);
        ImmigrationGate::seed('TANJUNG LEMBUNG, LANGKAWI','LAUT',$kdh);
        ImmigrationGate::seed('KUALA KEDAH','LAUT',$kdh);
        ImmigrationGate::seed('JETI STAR CRUISE TANJUNG MALAI, LANGKAWI','LAUT',$kdh);
        ImmigrationGate::seed('TELAGA HARBOUR PARK, PANTAI KOK, LANGKAWI','LAUT',$kdh);
        
        ImmigrationGate::seed('LAPANGAN TERBANG ANTARABANGSA BAYAN LEPAS','UDARA',$png);
        ImmigrationGate::seed('PELABUHAN PULAU PINANG (NORTH BUTTERWORTH)','LAUT',$png);
        ImmigrationGate::seed('DERMAGA BUTTERWORTH','LAUT',$png);
        
        ImmigrationGate::seed('BUKIT BERAPIT, PENGKALAN HULU','DARAT',$prk);
        ImmigrationGate::seed('PELABUHAN LUMUT','LAUT',$prk);
        ImmigrationGate::seed('JETI GHADAF MARBLE S/B, HUTAN MELINTANG','LAUT',$prk);
        
        ImmigrationGate::seed('KLIA 1','UDARA',$slngr);
        ImmigrationGate::seed('KLIA 2','UDARA',$slngr);
        ImmigrationGate::seed('PELABUHAN KLANG (NORTH PORT, WEST PORT, NORTH PORT)','LAUT',$slngr);
        
        ImmigrationGate::seed('JETI KOPERASI SERBAGUNA BAHAGIAN PORT DICKSON','LAUT',$ngr9);
        ImmigrationGate::seed('PELABUHAN PORT DICKSON','LAUT',$ngr9);
        ImmigrationGate::seed('KUALA LUKUT','LAUT',$ngr9);
        
        ImmigrationGate::seed('PELABUHAN MELAKA','LAUT',$mlc);
        ImmigrationGate::seed('DERMAGA TANJUNG BRUAS','LAUT',$mlc);
        ImmigrationGate::seed('PELABUHAN SUNGAI UDANG','LAUT',$mlc);
        ImmigrationGate::seed('PELABUHAN KUALA LINGGI','LAUT',$mlc);
        ImmigrationGate::seed('PELABUHAN SUNGAI RAMBAI','LAUT',$mlc);
        
        ImmigrationGate::seed('KOMPLEKS CIQ BANGUNAN SULTAN ISKANDAR','DARAT',$jhr);
        ImmigrationGate::seed('KOMPLEKS CIQ SULTAN ABU BAKAR','DARAT',$jhr);
        ImmigrationGate::seed('STESEN KERETAPI JOHOR BAHRU','DARAT',$jhr);
        ImmigrationGate::seed('PELABUHAN JOHOR (PASIR GUDANG)','LAUT',$jhr);
        ImmigrationGate::seed('PELABUHAN TANJUNG PELEPAS','LAUT',$jhr);
        ImmigrationGate::seed('TANJUNG PUTERI','LAUT',$jhr);
        ImmigrationGate::seed('JETI STULANG LAUT','LAUT',$jhr);
        ImmigrationGate::seed('SUNGAI SEGGET','LAUT',$jhr);
        ImmigrationGate::seed('BATU PAHAT','LAUT',$jhr);
        ImmigrationGate::seed('TANJUNG BELUNGKOR','LAUT',$jhr);
        ImmigrationGate::seed('TANJUNG PENGELIH','LAUT',$jhr);
        ImmigrationGate::seed('MERSING','LAUT',$jhr);
        ImmigrationGate::seed('KUKUP','LAUT',$jhr);
        ImmigrationGate::seed('SEBANA COVE MARINA, KOTA TINGGI','LAUT',$jhr);
        
        ImmigrationGate::seed('PELABUHAN KUANTAN','LAUT',$phg);
        ImmigrationGate::seed('PULAU TIOMAN','LAUT',$phg);
        
        ImmigrationGate::seed('PELABUHAN KEMAMAN','LAUT',$trggn);
        ImmigrationGate::seed('KUALA TERENGGANU','LAUT',$trggn);
        ImmigrationGate::seed('KUALA DUNGUN','LAUT',$trggn);
        ImmigrationGate::seed('PELABUHAN KERTEH','LAUT',$trggn);
        
        ImmigrationGate::seed('KOMPLEKS ICQS RANTAU PANJANG','DARAT',$kltn);
        ImmigrationGate::seed('KOMPLEKS IMIGRESEN PENGKALAN KUBOR','DARAT',$kltn);
        ImmigrationGate::seed('KOMPLEKS IMIGRESEN BUKIT BUNGA','DARAT',$kltn);
        ImmigrationGate::seed('JETI PENDARATAN IKAN TOK BALI','LAUT',$kltn);
        
        ImmigrationGate::seed('BIAWAK','DARAT',$srwk);
        ImmigrationGate::seed('SERIKIN','DARAT',$srwk);
        ImmigrationGate::seed('PADAWAN','DARAT',$srwk);
        ImmigrationGate::seed('TEBEDU','DARAT',$srwk);
        ImmigrationGate::seed('BUNAN GEGA','DARAT',$srwk);
        ImmigrationGate::seed('BATU LINTANG','DARAT',$srwk);
        ImmigrationGate::seed('LUBOK ANTU','DARAT',$srwk);
        ImmigrationGate::seed('SUNGAI TUJOH','DARAT',$srwk);
        ImmigrationGate::seed('BARIO','DARAT',$srwk);
        ImmigrationGate::seed('MERAPOK','DARAT',$srwk);
        ImmigrationGate::seed('TEDUNGAN','DARAT',$srwk);
        ImmigrationGate::seed('BAKELALAN','DARAT',$srwk);
        ImmigrationGate::seed('MENGKALAP','DARAT',$srwk);
        ImmigrationGate::seed('LONG LAMA','DARAT',$srwk);
        ImmigrationGate::seed('LAPANGAN TERBANG ANTARBANGSA KUCHING','UDARA',$srwk);
        ImmigrationGate::seed('LAPANGAN TERBANG SIBU','UDARA',$srwk);
        ImmigrationGate::seed('BAHAGIAN PERTAMA DERMAGA BAN HOCK, KUCHING','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA SUNGAI BIAWAK','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA PENDING','LAUT',$srwk);
        ImmigrationGate::seed('POS KAWALAN IMIGRESEN SANTUBONG','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA LEMBAGA PELABUHAN KUCHING','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA DATUK SIM KHENG HONG','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA BAUXITE, SEMANTAN','LAUT',$srwk);
        ImmigrationGate::seed('PANTAI BERSEMPADAN DENGAN SEMANTAN BAZZAR','LAUT',$srwk);
        ImmigrationGate::seed('BAHAGIAN KETIGA DERMAGA LEMBAGA PELABUHAN RAJANG, SIBU','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA SUNGAI MERAH, SIBU','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA KASTAM MIRI','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA KASTAM MARUDI','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA KASTAM BINTULU','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA KASTAM TANJUNG KIDURONG, BINTULU','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA KASTAM LIMBANG','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA KASTAM LAWAS','LAUT',$srwk);
        ImmigrationGate::seed('POS IMIGRESEN KUALA LAWAS - LIMBANG','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA KASTAM SUNDAR','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA KASTAM PUNANG','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA PELABUHAN RAJANG, SARIKEI','LAUT',$srwk);
        ImmigrationGate::seed('DERMAGA KASTAM BINATANG','LAUT',$srwk);
        ImmigrationGate::seed('TEMPAT PEMERIKSAAN KASTAM TANJUNG MANIS','LAUT',$srwk);
        
        ImmigrationGate::seed('SINDUMIN','DARAT',$sbh);
        ImmigrationGate::seed('LONG PASA','DARAT',$sbh);
        ImmigrationGate::seed('PEGALONGAN','DARAT',$sbh);
        ImmigrationGate::seed('LAPANGAN TERBANG ANTARABANGSA KOTA KINABALU','UDARA',$sbh);
        ImmigrationGate::seed('LAPANGAN TERBANG SANDAKAN','UDARA',$sbh);
        ImmigrationGate::seed('LAPANGAN TERBANG TAWAU','UDARA',$sbh);
        ImmigrationGate::seed('DERMAGA TAWAU','LAUT',$sbh);
        ImmigrationGate::seed('DERMAGA SEMPORNA','LAUT',$sbh);
        ImmigrationGate::seed('DERMAGA LAHAD DATU','LAUT',$sbh);
        ImmigrationGate::seed('DERMAGA SANDAKAN','LAUT',$sbh);
        ImmigrationGate::seed('DERMAGA KUDAT','LAUT',$sbh);
        ImmigrationGate::seed('DERMAGA KOTA KINABALU','LAUT',$sbh);
        ImmigrationGate::seed('DERMAGA KUALA SIPITANG','LAUT',$sbh);
        ImmigrationGate::seed('DERMAGA KOTA KINABALU','LAUT',$sbh);
        ImmigrationGate::seed('DERMAGA MENUMBOK','LAUT',$sbh);
        ImmigrationGate::seed('KARAKIT, PULAU BANGGI','LAUT',$sbh);
        
        ImmigrationGate::seed('DERMAGA LABUAN','LAUT',$lbn);
    }
}