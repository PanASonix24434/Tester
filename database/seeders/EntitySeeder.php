<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entity as Entity;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Level 1 - HQ
        Entity::seed(null,'Jabatan Perikanan Malaysia HQ','1','16');

        $hq = json_encode(['entity_name' => 'Jabatan Perikanan Malaysia HQ']);

        //Level 2 - Negeri
        Entity::seed($hq,'Pejabat Perikanan Negeri Johor','2','01');
        Entity::seed($hq,'Pejabat Perikanan Negeri Kedah','2','02');
        Entity::seed($hq,'Pejabat Perikanan Negeri Kelantan','2','03');
        Entity::seed($hq,'Pejabat Perikanan Negeri Melaka','2','04');
        Entity::seed($hq,'Pejabat Perikanan Negeri Sembilan','2','05');
        Entity::seed($hq,'Pejabat Perikanan Negeri Pahang','2','06');
        Entity::seed($hq,'Pejabat Perikanan Negeri Pulau Pinang','2','07');
        Entity::seed($hq,'Pejabat Perikanan Negeri Perak','2','08');
        Entity::seed($hq,'Pejabat Perikanan Negeri Perlis','2','09');
        Entity::seed($hq,'Pejabat Perikanan Negeri Selangor','2','10');
        Entity::seed($hq,'Pejabat Perikanan Negeri Terengganu','2','11');
        Entity::seed($hq,'Pejabat Perikanan Negeri Sabah','2','12');
        Entity::seed($hq,'Pejabat Perikanan Negeri Sarawak','2','13');
        Entity::seed($hq,'Pejabat Perikanan Negeri Labuan','2','15');
		Entity::seed($hq,'Pejabat Perikanan WP Kuala Lumpur / Putrajaya','2','16');

        $joh = json_encode(['entity_name' => 'Pejabat Perikanan Negeri Johor']);
        $ked = json_encode(['entity_name' => 'Pejabat Perikanan Negeri Kedah']);
        $kel = json_encode(['entity_name' => 'Pejabat Perikanan Negeri Kelantan']);
        $mel = json_encode(['entity_name' => 'Pejabat Perikanan Negeri Melaka']);
        $ne9 = json_encode(['entity_name' => 'Pejabat Perikanan Negeri Sembilan']);
        $pah = json_encode(['entity_name' => 'Pejabat Perikanan Negeri Pahang']);
        $pul = json_encode(['entity_name' => 'Pejabat Perikanan Negeri Pulau Pinang']);
        $prk = json_encode(['entity_name' => 'Pejabat Perikanan Negeri Perak']);
        $prl = json_encode(['entity_name' => 'Pejabat Perikanan Negeri Perlis']);
        $sel = json_encode(['entity_name' => 'Pejabat Perikanan Negeri Selangor']);
        $ter = json_encode(['entity_name' => 'Pejabat Perikanan Negeri Terengganu']);
        $sab = json_encode(['entity_name' => 'Pejabat Perikanan Negeri Sabah']);
        $sar = json_encode(['entity_name' => 'Pejabat Perikanan Negeri Sarawak']);
        $lab = json_encode(['entity_name' => 'Pejabat Perikanan Negeri Labuan']);
		$kul = json_encode(['entity_name' => 'Pejabat Perikanan WP Kuala Lumpur / Putrajaya']);

        //Level 3 - Wilayah

        //Level 4 - Daerah

        //Johor
        Entity::seed($joh,'Pejabat Perikanan Daerah Johor Bahru','4','01');
        Entity::seed($joh,'Pejabat Perikanan Daerah Pontian','4','01');
        Entity::seed($joh,'Pejabat Perikanan Daerah Batu Pahat','4','01');
        Entity::seed($joh,'Pejabat Perikanan Daerah Muar / Tangkak','4','01');
        Entity::seed($joh,'Pejabat Perikanan Daerah Segamat','4','01');
        Entity::seed($joh,'Pejabat Perikanan Daerah Kluang','4','01');
        Entity::seed($joh,'Pejabat Perikanan Daerah Mersing','4','01');
        Entity::seed($joh,'Pejabat Perikanan Daerah Kota Tinggi Selatan (Pengerang)','4','01');
        Entity::seed($joh,'Pejabat Perikanan Daerah Tanjung Sedili','4','01');

        //Kedah
        Entity::seed($ked,'Pejabat Perikanan Kedah Utara','4','02');
        Entity::seed($ked,'Pejabat Perikanan Daerah Langkawi','4','02');
        Entity::seed($ked,'Pejabat Perikanan Daerah Kuala Muda','4','02');
        Entity::seed($ked,'Pejabat Perikanan Daerah Kulim','4','02');
        Entity::seed($ked,'Pejabat Perikanan Daerah Sik','4','02');
        Entity::seed($ked,'Pejabat Perikanan Daerah Padang Terap','4','02');
        Entity::seed($ked,'Pejabat Perikanan Daerah Pendang','4','02');
        Entity::seed($ked,'Pejabat Perikanan Daerah Kubang Pasu','4','02');
        Entity::seed($ked,'Pejabat Perikanan Daerah Bandar Baharu','4','02');
        Entity::seed($ked,'Pejabat Perikanan Daerah Baling','4','02');

        //Kelantan
        Entity::seed($kel,'Pejabat Perikanan Daerah Pasir Mas','4','03');
        Entity::seed($kel,'Pejabat Perikanan Daerah Kuala Krai','4','03');
        Entity::seed($kel,'Pejabat Perikanan Daerah Machang','4','03');
        Entity::seed($kel,'Pejabat Perikanan Daerah Jeli','4','03');
        Entity::seed($kel,'Pejabat Perikanan Daerah Gua Musang','4','03');
        Entity::seed($kel,'Pejabat Perikanan Daerah Kota Bharu','4','03');
        Entity::seed($kel,'Pejabat Perikanan Daerah Pasir Puteh','4','03');
        Entity::seed($kel,'Pejabat Perikanan Daerah Tanah Merah','4','03');
        Entity::seed($kel,'Pejabat Perikanan Daerah Tumpat','4','03');
        Entity::seed($kel,'Pejabat Perikanan Daerah Bachok','4','03');

        //Melaka
        Entity::seed($mel,'Pejabat Perikanan Daerah Melaka Tengah','4','04');
        Entity::seed($mel,'Pejabat Perikanan Daerah Alor Gajah','4','04');
        Entity::seed($mel,'Pejabat Perikanan Daerah Jasin','4','04');

        //Negeri Sembilan
        Entity::seed($ne9,'Pejabat Perikanan Daerah Seremban','4','05');
        Entity::seed($ne9,'Pejabat Perikanan Daerah Kuala Pilah','4','05');
        Entity::seed($ne9,'Pejabat Perikanan Daerah Jempol','4','05');
        Entity::seed($ne9,'Pejabat Perikanan Daerah Jelebu','4','05');
        Entity::seed($ne9,'Pejabat Perikanan Daerah Port Dickson','4','05');
        Entity::seed($ne9,'Pejabat Perikanan Daerah Rembau','4','05');
        Entity::seed($ne9,'Pejabat Perikanan Daerah Tampin','4','05');

        //Pahang
        Entity::seed($pah,'Pejabat Perikanan Daerah Kuantan','4','06');
        Entity::seed($pah,'Pejabat Perikanan Daerah Pekan','4','06');
        Entity::seed($pah,'Pejabat Perikanan Daerah Rompin','4','06');
        Entity::seed($pah,'Pejabat Perikanan Daerah Lipis','4','06');
        Entity::seed($pah,'Pejabat Perikanan Daerah Maran','4','06');
        Entity::seed($pah,'Pejabat Perikanan Daerah Temerloh','4','06');
        Entity::seed($pah,'Pejabat Perikanan Daerah Bentong','4','06');
        Entity::seed($pah,'Pejabat Perikanan Daerah Raub','4','06');
        Entity::seed($pah,'Pejabat Perikanan Daerah Jerantut','4','06');
        Entity::seed($pah,'Pejabat Perikanan Daerah Bera','4','06');

        //Pulau Pinang
        Entity::seed($pul,'Pejabat Perikanan Daerah Barat Daya / Timur Laut','4','07');
        Entity::seed($pul,'Pejabat Perikanan Daerah Seberang Perai','4','07');

        //Perak
        Entity::seed($prk,'Pejabat Perikanan Daerah Larut Matang & Selama','4','08');
        Entity::seed($prk,'Pejabat Perikanan Daerah Manjung','4','08');
        Entity::seed($prk,'Pejabat Perikanan Daerah Hilir Perak','4','08');
        Entity::seed($prk,'Pejabat Perikanan Daerah Kerian','4','08');
        Entity::seed($prk,'Pejabat Perikanan Daerah Kinta & Kampar','4','08');
        Entity::seed($prk,'Pejabat Perikanan Daerah Perak Tengah','4','08');
        Entity::seed($prk,'Pejabat Perikanan Daerah Batang Padang','4','08');
        Entity::seed($prk,'Pejabat Perikanan Daerah Hulu Perak (U)','4','08');
        Entity::seed($prk,'Pejabat Perikanan Daerah Hulu Perak (S)','4','08');
        Entity::seed($prk,'Pejabat Perikanan Daerah Kuala Kangsar','4','08');

        //Perlis - Takda Pejabat Daerah
        Entity::seed($prl,'Pejabat Perikanan Perlis','4','09');

        //Selangor
        Entity::seed($sel,'Pejabat Perikanan Daerah Klang','4','10');
        Entity::seed($sel,'Pejabat Perikanan Daerah Kuala Langat / Sepang','4','10');
        Entity::seed($sel,'Pejabat Perikanan Daerah Sabak Bernam','4','10');
        Entity::seed($sel,'Pejabat Perikanan Daerah Hulu Selangor','4','10');
        Entity::seed($sel,'Pejabat Perikanan Daerah Kuala Selangor','4','10');
        Entity::seed($sel,'Pejabat Perikanan Daerah Gombak / Petaling','4','10');
        Entity::seed($sel,'Pejabat Perikanan Daerah Hulu Langat','4','10');

        //Terengganu
        Entity::seed($ter,'Pejabat Perikanan Daerah Besut','4','11');
        Entity::seed($ter,'Pejabat Perikanan Daerah Setiu','4','11');
        Entity::seed($ter,'Pejabat Perikanan Daerah Kuala Nerus','4','11');
        Entity::seed($ter,'Pejabat Perikanan Daerah Kuala Terengganu','4','11');
        Entity::seed($ter,'Pejabat Perikanan Daerah Marang','4','11');
        Entity::seed($ter,'Pejabat Perikanan Daerah Hulu Terengganu','4','11');
        Entity::seed($ter,'Pejabat Perikanan Daerah Dungun','4','11');
        Entity::seed($ter,'Pejabat Perikanan Daerah Kemaman','4','11');

        //Sabah
        Entity::seed($sab,'Pejabat Perikanan Daerah Kudat','4','12');
        Entity::seed($sab,'Pejabat Perikanan Daerah Kunak','4','12');
        Entity::seed($sab,'Pejabat Perikanan Daerah Sandakan','4','12');
        Entity::seed($sab,'Pejabat Perikanan Daerah Semporna','4','12');
        Entity::seed($sab,'Pejabat Perikanan Daerah Kota Marudu','4','12');
        Entity::seed($sab,'Pejabat Perikanan Daerah Papar','4','12');
        //Sabah - Tambahan
        Entity::seed($sab,'Pejabat Perikanan Daerah Kota Kinabalu','4','12');
        Entity::seed($sab,'Pejabat Perikanan Daerah Likas','4','12');
        Entity::seed($sab,'Pejabat Perikanan Daerah Keningau','4','12');
        Entity::seed($sab,'Pejabat Perikanan Daerah Nabawan','4','12');
        Entity::seed($sab,'Pejabat Perikanan Daerah Telupid','4','12');
        Entity::seed($sab,'Pejabat Perikanan Daerah Tawau','4','12');
        Entity::seed($sab,'Pejabat Perikanan Daerah Pitas','4','12');
        Entity::seed($sab,'Pejabat Perikanan Daerah Tongod','4','12');
        Entity::seed($sab,'Pejabat Perikanan Daerah Kota Belud','4','12');
        Entity::seed($sab,'Pejabat Perikanan Daerah Penampang','4','12');

        //Sarawak
        Entity::seed($sar,'Pejabat Perikanan Daerah Kuching','4','13');
        Entity::seed($sar,'Pejabat Perikanan Daerah Santubong','4','13');
        Entity::seed($sar,'Pejabat Perikanan Daerah Sematan','4','13');
        Entity::seed($sar,'Pejabat Perikanan Daerah Sebuyau','4','13');
        Entity::seed($sar,'Pejabat Perikanan Daerah Kabong','4','13');
        Entity::seed($sar,'Pejabat Perikanan Daerah Sarikei','4','13');
        Entity::seed($sar,'Pejabat Perikanan Daerah Sibu','4','13');
        Entity::seed($sar,'Pejabat Perikanan Daerah Mukah','4','13');
		
		//Kuala Lumpur
		Entity::seed($kul,'Pejabat Perikanan Kuala Lumpur / Putrajaya','4','14');
    }
}