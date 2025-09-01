<?php

namespace Database\Seeders;

use App\Models\Kru\ImmigrationOffice;
use Illuminate\Database\Seeder;

class ImmigrationOfficeSeeder extends Seeder
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

        ImmigrationOffice::seed('Jabatan Imigresen Malaysia Selangor','Tingkat 2, Kompleks PKNS',null,null,'40550','Shah Alam',$slngr,'03-5650 0000','03-5650 0118');
        ImmigrationOffice::seed('Jabatan Imigresen Malaysia Negeri Johor','Tingkat 1-3 dan 8-14, Blok 1','Kompleks Kementerian Dalam Negeri','Taman Setia Tropika, Kempas','81200','Johor Bahru',$jhr,'07-2338400','07-2344292');
        ImmigrationOffice::seed('Jabatan Imigresen Malaysia Negeri Pulau Pinang','Jalan Kelasah',null,null,'13700','Bandar Seberang Jaya',$png,'04-3973011','04-3983529');
        ImmigrationOffice::seed('Jabatan Imigresen Malaysia Negeri Perak','Aras 2-4, Kompleks KDN','Persiaran Meru Utama','Bandar Meru Raya','30020','Ipoh',$prk,'05-5017100','05-5017121');
        ImmigrationOffice::seed('Jabatan Imigresen Malaysia Kedah','Tingkat 1 & 2, Bangunan Kementerian Dalam Negeri (KDN)','Pusat Pentadbiran Kerajaan Persekutuan',"Bandar Mu'adzam Shah",'06550','Alor Setar',$kdh,'04-7333302','04-7331752');
        ImmigrationOffice::seed('Jabatan Imigresen Malaysia Negeri Melaka','Aras 1-3, Blok Pentadbiran','Kompleks Kementerian Dalam Negeri','Jalan Seri Negeri, Hang Tuah Jaya','75450','Ayer Keroh',$mlc,'06-2322662','06-2322654');
        ImmigrationOffice::seed('Jabatan Imigresen Malaysia Negeri Sembilan','Tingkat 2, 4, 6 & 7, Wisma Persekutuan',"Jalan Dato' Abdul Kadir",null,'70000','Seremban',$ngr9,'06-7620000','06-7632491');
        ImmigrationOffice::seed('Jabatan Imigresen Malaysia Negeri Pahang','Kompleks KDN','Bandar Indera Mahkota',null,'25200','Kuantan',$phg,'09-5717999','09-5738342');
        ImmigrationOffice::seed('Jabatan Imigresen Malaysia Negeri Terengganu','Tingkat 1, Wisma Persekutuan','Jalan Sultan Ismail',null,'20200','Kuala Terengganu',$trggn,'09-6221424 / 09- 6225951 / 09-6221476','09-6236682');
        ImmigrationOffice::seed('Jabatan Imigresen Malaysia Negeri Kelantan','Aras 2, Wisma Persekutuan','Jalan Bayam',null,'15550','Kota Bahru',$kltn,'09-7482120 / 09- 7482644 / 09-7440503','09-7440200');
        ImmigrationOffice::seed('Jabatan Imigresen Malaysia Negeri Perlis','Aras 1-2, Kompleks KDN','Mukim Seriab, Persiaran Wawasan',null,'01000','Kangar',$prls,'04-9762636','04-9770946');
        ImmigrationOffice::seed('Jabatan Imigresen Negeri Sarawak','Tingkat 9, Bangunan Tuanku Haji Bujang','Jalan Simpang Tiga',null,'93550','Kuching',$srwk,'082-245661/230280/429437','082-240390');
        ImmigrationOffice::seed('Jabatan Imigresen Negeri Sabah','Aras 1-4, Blok B','Kompleks Pentadbiran Kerajaan Persekutuan Sabah','Jalan Sulaman','88450','Kota Kinabalu',$sbh,'088-488700','088-488800');
        ImmigrationOffice::seed('Jabatan Imigresen Wilayah Persekutuan Labuan','Unit E 002, Tingkat 1 Aras Podium','Kompleks Ujana Kewangan','Jalan Merdeka, Peti Surat 174','87008','Labuan',$lbn,'087-425 307','087-414990');
        // ImmigrationOffice::seed('Pejabat Imigresen Kulim');
        // ImmigrationOffice::seed('Jabatan Imigresen Wilayah Persekutuan Kuala Lumpur');
        // ImmigrationOffice::seed('Jabatan Imigresen Tawau');
    }
}