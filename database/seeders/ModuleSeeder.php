<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Systems\Module as Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Bahasa Melayu & English
        // 1 - Modul Dashboard
        Module::seed('Dashboard', 'Dashboard', 'dashboard', '/dashboard', 'fas fa-tachometer-alt', 1);

        // 2 - Modul Profil
        Module::seed('Profil', 'Profile', 'profile', '/profile', 'fas fa-user', 2, true);
			Module::seedChild('Pengguna', 'User', 'user', '/profile/handleProfile', 1, 'Profil'); 

            // ------------ Start (Syasya) -----------------------------
            Module::seedChild('Syarikat', 'Company', 'syarikat', '/profile/indexSyarikat', 2, 'Profil'); 
            Module::seedChild('Vesel', 'Vessel', 'vesel', '/profile/vesel', 3, 'Profil');
            // ------------ End (Syasya) -------------------------------

            Module::seedChild('Kakitangan', 'Staff', 'staff', '/profile/staff', 4, 'Profil');
            Module::seedChild('Senarai Kakitangan', 'Staff List', 'stafflist', '/profile/stafflist', 5, 'Profil');

            // ------------ Start (Ajim) -------------------------------
            Module::seedChild('Pengurus Vesel', 'Vessel Manager', 'vesselmanager', '/profile/vesselmanager', 6, 'Profil');
            Module::seedChild('Pentadbir Harta', 'Inheritance Administrator', 'inheritance-administrator', '/profile/inheritance-administrator', 7, 'Profil');
            Module::seedChild('Pewaris', 'Heir', 'inheritance-administrator', '/profile/inheritance-administrator', 8, 'Profil');
            
        // 3 - Pengesahan Profil - Ajim & Syasya
        Module::seed('Pengesahan Profil', 'Profile Verification', 'profile-verification', '/profile-verification', 'fas fa-user-check', 3, true);
            Module::seedChild('Pemohon Lesen', 'License Applicant', 'license-applicant', '/profile/verifyProfiles', 1, 'Pengesahan Profil');
            Module::seedChild('Pengurus Vesel', 'Vessel Manager', 'verification-vesselmanager', '/profile-verification/vesselmanager', 2, 'Pengesahan Profil');
            Module::seedChild('Pentadbir Harta / Pewaris', 'Inheritance Administrator / Heir', 'verification-inheritance-administrator', '/profile-verification/inheritance-administrator', 3, 'Pengesahan Profil'); 
            // ------------ End (Ajim) -------------------------------

        // 4 - Modul Watikah Pelantikan
        Module::seed('Watikah Pelantikan', 'User Appointment', 'appointment', '/appointment', 'fas fa-edit', 4, true);
	     Module::seedChild('Kelulusan Watikah', 'Appointment Approval', 'approval', '/appointment/approval', 1, 'Watikah Pelantikan');
             Module::seedChild('Carian Watikah', 'Appointment List', 'search', '/appointment/search', 2, 'Watikah Pelantikan');
	     Module::seedChild('Muatturun Watikah', 'Appointment Download', 'download', '/appointment/download', 3, 'Watikah Pelantikan');

        // 5 - Modul Permohonan
        Module::seed('Permohonan', 'Application', 'application', '/application', 'fas fa-edit', 5, true);
	    Module::seedChild('Borang Permohonan', 'Application Form', 'form', '/application/form', 1, 'Permohonan');
        Module::seedChild('Senarai Permohonan', 'Application List', 'formlist', '/appeals/senarai-permohonan', 2, 'Permohonan');

        // 6 - Modul KRU
        Module::seed('Keseluruhan Permohonan Kru', 'Keseluruhan Permohonan Kru', 'keseluruhanpermohonankru', '/keseluruhanpermohonankru', 'fas fa-edit', 6, true);

        // 7 - Modul KRU
        Module::seed('Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)', 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)', 'kadpendaftarannelayan', '/kadpendaftarannelayan', 'fas fa-edit', 7, true);
            Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/kadpendaftarannelayan/permohonan', 0, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
            Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/kadpendaftarannelayan/semakandaerah', 1, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
            Module::seedChild('Sokongan Daerah', 'Sokongan Daerah', 'sokongandaerah', '/kadpendaftarannelayan/sokongandaerah', 2, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
            Module::seedChild('Keputusan Daerah', 'Keputusan Daerah', 'keputusandaerah', '/kadpendaftarannelayan/keputusandaerah', 3, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
            Module::seedChild('Sokongan Wilayah', 'Sokongan Wilayah', 'sokonganwilayah', '/kadpendaftarannelayan/sokonganwilayah', 4, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
            Module::seedChild('Keputusan Wilayah', 'Keputusan Wilayah', 'keputusanwilayah', '/kadpendaftarannelayan/keputusanwilayah', 5, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
            Module::seedChild('Semakan Negeri', 'Semakan Negeri', 'semakannegeri', '/kadpendaftarannelayan/semakannegeri', 6, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
            Module::seedChild('Sokongan Negeri', 'Sokongan Negeri', 'sokongannegeri', '/kadpendaftarannelayan/sokongannegeri', 7, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
            Module::seedChild('Keputusan Negeri', 'Keputusan Negeri', 'keputusannegeri', '/kadpendaftarannelayan/keputusannegeri', 8, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
            Module::seedChild('Terimaan KPN Lama', 'Terimaan KPN Lama', 'terimaankpnlama', '/kadpendaftarannelayan/terimaankpnlama', 9, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
            Module::seedChild('Terimaan Bayaran', 'Terimaan Bayaran', 'terimaanbayaran', '/kadpendaftarannelayan/terimaanbayaran', 10, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
            Module::seedChild('Pengesahan Bayaran', 'Pengesahan Bayaran', 'pengesahanbayaran', '/kadpendaftarannelayan/pengesahanbayaran', 11, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
            Module::seedChild('Cetakan Kad', 'Cetakan Kad', 'cetakankad', '/kadpendaftarannelayan/cetakankad', 12, 'Kad Pendaftaran Nelayan (Tempatan/ Pemastautin Tetap)');
        
        Module::seed('Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)', 'Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)', 'pembaharuankadpendaftarannelayan', '/pembaharuankadpendaftarannelayan', 'fas fa-edit', 8, true);
            Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/pembaharuankadpendaftarannelayan/permohonan', 0, 'Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/pembaharuankadpendaftarannelayan/semakandaerah', 1, 'Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Keputusan Daerah', 'Keputusan Daerah', 'keputusandaerah', '/pembaharuankadpendaftarannelayan/keputusandaerah', 2, 'Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Terimaan Bayaran', 'Terimaan Bayaran', 'terimaanbayaran', '/pembaharuankadpendaftarannelayan/terimaanbayaran', 4, 'Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Pengesahan Bayaran', 'Pengesahan Bayaran', 'pengesahanbayaran', '/pembaharuankadpendaftarannelayan/pengesahanbayaran', 5, 'Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Cetakan Kad', 'Cetakan Kad', 'cetakankad', '/pembaharuankadpendaftarannelayan/cetakankad', 6, 'Pembaharuan Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');

        Module::seed('Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)', 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)', 'gantiankadpendaftarannelayan', '/gantiankadpendaftarannelayan', 'fas fa-edit', 9, true);
            Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/gantiankadpendaftarannelayan/permohonan', 0, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/gantiankadpendaftarannelayan/semakandaerah', 1, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Sokongan Daerah', 'Sokongan Daerah', 'sokongandaerah', '/gantiankadpendaftarannelayan/sokongandaerah', 2, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Sokongan Wilayah', 'Sokongan Wilayah', 'sokonganwilayah', '/gantiankadpendaftarannelayan/sokonganwilayah', 4, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Semakan Negeri', 'Semakan Negeri', 'semakannegeri', '/gantiankadpendaftarannelayan/semakannegeri', 6, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Sokongan Negeri', 'Sokongan Negeri', 'sokongannegeri', '/gantiankadpendaftarannelayan/sokongannegeri', 7, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Keputusan Negeri', 'Keputusan Negeri', 'keputusannegeri', '/gantiankadpendaftarannelayan/keputusannegeri', 8, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Terimaan Bayaran', 'Terimaan Bayaran', 'terimaanbayaran', '/gantiankadpendaftarannelayan/terimaanbayaran', 10, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Pengesahan Bayaran', 'Pengesahan Bayaran', 'pengesahanbayaran', '/gantiankadpendaftarannelayan/pengesahanbayaran', 11, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Cetakan Kad', 'Cetakan Kad', 'cetakankad', '/gantiankadpendaftarannelayan/cetakankad', 12, 'Gantian Kad Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');

        Module::seed('Pembatalan Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)', 'Pembatalan Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)', 'pembatalankadpendaftarannelayan', '/pembatalankadpendaftarannelayan', 'fas fa-edit', 10, true);
            Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/pembatalankadpendaftarannelayan/permohonan', 0, 'Pembatalan Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/pembatalankadpendaftarannelayan/semakandaerah', 1, 'Pembatalan Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');
            Module::seedChild('Keputusan Daerah', 'Keputusan Daerah', 'keputusandaerah', '/pembatalankadpendaftarannelayan/keputusandaerah', 2, 'Pembatalan Pendaftaran Nelayan (Tempatan / Pemastautin Tetap)');

        Module::seed('Kebenaran Penggunaan Kru Asing', 'Kebenaran Penggunaan Kru Asing', 'kebenaranpenggunaankrubukanwarganegara', '/kebenaranpenggunaankrubukanwarganegara', 'fas fa-edit', 11, true);
            Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/kebenaranpenggunaankrubukanwarganegara/permohonan', 1, 'Kebenaran Penggunaan Kru Asing');
            Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/kebenaranpenggunaankrubukanwarganegara/semakandaerah', 2, 'Kebenaran Penggunaan Kru Asing');
            Module::seedChild('Keputusan Daerah', 'Keputusan Daerah', 'keputusandaerah', '/kebenaranpenggunaankrubukanwarganegara/keputusandaerah', 3, 'Kebenaran Penggunaan Kru Asing');

        Module::seed('Kelulusan Penggunaan Kru Asing', 'Kelulusan Penggunaan Kru Asing', 'kelulusanpenggunaankrubukanwarganegara', '/kelulusanpenggunaankrubukanwarganegara', 'fas fa-edit', 12, true);
            Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/kelulusanpenggunaankrubukanwarganegara/permohonan', 1, 'Kelulusan Penggunaan Kru Asing');
            Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/kelulusanpenggunaankrubukanwarganegara/semakandaerah', 2, 'Kelulusan Penggunaan Kru Asing');
            Module::seedChild('Keputusan Daerah', 'Keputusan Daerah', 'keputusandaerah', '/kelulusanpenggunaankrubukanwarganegara/keputusandaerah', 3, 'Kelulusan Penggunaan Kru Asing');

        Module::seed('Pembaharuan Kebenaran Penggunaan Kru Asing', 'Pembaharuan Kebenaran Penggunaan Kru Asing', 'pembaharuanpenggunaankrubukanwarganegara', '/pembaharuanpenggunaankrubukanwarganegara', 'fas fa-edit', 13, true);
            Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/pembaharuanpenggunaankrubukanwarganegara/permohonan', 1, 'Pembaharuan Kebenaran Penggunaan Kru Asing');
            Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/pembaharuanpenggunaankrubukanwarganegara/semakandaerah', 2, 'Pembaharuan Kebenaran Penggunaan Kru Asing');
            Module::seedChild('Keputusan Daerah', 'Keputusan Daerah', 'keputusandaerah', '/pembaharuanpenggunaankrubukanwarganegara/keputusandaerah', 3, 'Pembaharuan Kebenaran Penggunaan Kru Asing');

        Module::seed('Pembatalan Kelulusan Kru Asing', 'Pembatalan Kelulusan Kru Asing', 'pembatalanpenggunaankrubukanwarganegara', '/pembatalanpenggunaankrubukanwarganegara', 'fas fa-edit', 14, true);
            Module::seedChild('Permohonan', 'Permohonan', 'permohonan', '/pembatalanpenggunaankrubukanwarganegara/permohonan', 1, 'Pembatalan Kelulusan Kru Asing');
            Module::seedChild('Semakan Daerah', 'Semakan Daerah', 'semakandaerah', '/pembatalanpenggunaankrubukanwarganegara/semakandaerah', 2, 'Pembatalan Kelulusan Kru Asing');
            Module::seedChild('Keputusan Daerah', 'Keputusan Daerah', 'keputusandaerah', '/pembatalanpenggunaankrubukanwarganegara/keputusandaerah', 3, 'Pembatalan Kelulusan Kru Asing');

        // 46 - Modul Hebahan
        Module::seed('Hebahan', 'Hebahan', 'hebahan', '/hebahan', 'fas fa-paper-plane', 46, true);
            Module::seedChild('Kemasukan Hebahan', 'Kemasukan Hebahan', 'hebahanlist', '/hebahan/hebahanlist', 1, 'Hebahan');
            Module::seedChild('Kelulusan Hebahan', 'Kelulusan Hebahan', 'hebahanapprovelist', '/hebahan/hebahanapprovelist', 2, 'Hebahan');

        // 47 - Modul Aduan
        Module::seed('Aduan', 'Complaint', 'complaint2', '/complaint2', 'fas fa-exclamation-triangle', 47, true);
            Module::seedChild('Senarai Aduan', 'Complaint List', 'complaintlist', '/complaint2/complaintlist', 1, 'Aduan');

        // 48 - Modul Pelaporan
        Module::seed('Pelaporan', 'Report', 'report', '/report', 'fas fa-database', 48, true);	
            Module::seedChild('Senarai Laporan', 'Report List', 'report-list', '/report/report-list', 1, 'Pelaporan');

        // 49 - Modul Data Utama
        Module::seed('Data Utama', 'Master Data', 'master-data', '/master-data', 'fas fa-database', 49, true);

            Module::seedChild('Bangsa', 'Race', 'races', '/master-data/races', 1, 'Data Utama');
                Module::seedChild('Tambah Bangsa', 'Add Race', 'add-race', '/master-data/races/add', 1, 'Bangsa', false);
                Module::seedChild('Ubahsuai Bangsa', 'Edit Race', 'edit-race', '/master-data/races/{id}/edit', 2, 'Bangsa', false);
                Module::seedChild('Padam Bangsa', 'Delete Race', 'delete-race', null, 3, 'Bangsa', false);

            Module::seedChild('Warganegara', 'Citizenship', 'citizenships', '/master-data/citizenships', 2, 'Data Utama');
                Module::seedChild('Tambah Warganegara', 'Add Citizenship', 'add-citizenship', '/master-data/citizenships/add', 1, 'Warganegara', false);
                Module::seedChild('Ubahsuai Warganegara', 'Edit Citizenship', 'edit-citizenship', '/master-data/citizenships/{id}/edit', 2, 'Warganegara', false);
                Module::seedChild('Padam Warganegara', 'Delete Citizenship', 'delete-citizenship', null, 3, 'Warganegara', false);

            Module::seedChild('Jantina', 'Gender', 'genders', '/master-data/genders', 3, 'Data Utama');
                Module::seedChild('Tambah Jantina', 'Add Gender','add-gender', '/master-data/genders/add', 1, 'Jantina', false);
                Module::seedChild('Ubahsuai Jantina', 'Edit Gender','edit-gender', '/master-data/genders/{id}/edit', 2, 'Jantina', false);
                Module::seedChild('Padam Jantina', 'Delete Gender','delete-gender', null, 3, 'Jantina', false);

            Module::seedChild('Daerah', 'District','districts', '/master-data/districts', 4, 'Data Utama');
                Module::seedChild('Tambah Daerah', 'Add District','add-district', '/master-data/districts/add', 1, 'Daerah', false);
                Module::seedChild('Ubahsuai Daerah', 'Edit District','edit-district', '/master-data/districts/{id}/edit', 2, 'Daerah', false);
                Module::seedChild('Padam Daerah', 'Delete District','delete-district', null, 3, 'Daerah', false);

            Module::seedChild('DUN', 'DUN', 'aduns', '/master-data/aduns', 5, 'Data Utama');
                Module::seedChild('Tambah DUN', 'Add DUN', 'add-adun', '/master-data/aduns/add', 1, 'DUN', false);
                Module::seedChild('Ubahsuai DUN', 'Edit DUN','edit-adun', '/master-data/aduns/{id}/edit', 2, 'DUN', false);
                Module::seedChild('Padam DUN', 'Delete DUN','delete-adun', null, 3, 'DUN', false);

            Module::seedChild('Parlimen', 'Parliament','parliaments', '/master-data/parliaments', 6, 'Data Utama');
                Module::seedChild('Tambah Parlimen', 'Add Parliament','add-parliament', '/master-data/parliaments/add', 1, 'Parlimen', false);
                Module::seedChild('Ubahsuai Parlimen', 'Edit Parliament','edit-parliament', '/master-data/parliaments/{id}/edit', 2, 'Parlimen', false);
                Module::seedChild('Padam Parlimen', 'Delete Parliament','delete-parliament', null, 3, 'Parlimen', false);

            Module::seedChild('Negeri', 'State','states', '/master-data/states', 7, 'Data Utama');
                Module::seedChild('Tambah Negeri', 'Add State','add-state', '/master-data/states/add', 1, 'Negeri', false);
                Module::seedChild('Ubahsuai Negeri', 'Edit State','edit-state', '/master-data/states/{id}/edit', 2, 'Negeri', false);
                Module::seedChild('Padam Negeri', 'Delete State','delete-state', null, 3, 'Negeri', false); 
            
            Module::seedChild('Konfigurasi Lesen', 'License Configuration','licenses', '/master-data/licenses', 7, 'Data Utama');

        // 50 - Modul Pentadbiran
        Module::seed('Pentadbiran', 'Administration', 'administration', '/administration', 'fas fa-cogs', 50, true);
            
            Module::seedChild('Pengumuman', 'Announcement', 'announcement', '/administration/announcement', 1, 'Pentadbiran');
            Module::seedChild('Pekeliling', 'Pekeliling', 'pekeliling', '/administration/pekeliling', 2, 'Pentadbiran');
            Module::seedChild('Peranan', 'Role', 'roles', '/administration/roles', 3, 'Pentadbiran');
                Module::seedChild('Tambah Peranan', 'Add role', 'create-role', '/administration/roles/create', 1, 'Peranan', false);
                Module::seedChild('Ubahsuai Peranan', 'Edit Role', 'edit-role', '/administration/roles/{id}/edit', 2, 'Peranan', false);
                Module::seedChild('Padam Peranan', 'Delete Role', 'delete-role', null, 3, 'Peranan', false);
                
            Module::seedChild('Pengguna', 'User', 'users', '/administration/users', 4, 'Pentadbiran');
                Module::seedChild('Tambah Pengguna', 'Add User', 'create-user', '/administration/users/create', 1, 'Pengguna', false);
                Module::seedChild('Ubahsuai Pengguna', 'Edit User', 'edit-user', '/administration/users/{id}/edit', 2, 'Pengguna', false);
                Module::seedChild('Padam Pengguna', 'Delete User', 'delete-user', null, 3, 'Pengguna', false);
                Module::seedChild('Eksport Pengguna', 'Export User', 'export-user', null, 4, 'Pengguna', false);
                
            Module::seedChild('Log Audit', 'Audit Logs', 'audit-logs', '/administration/audit-logs', 5, 'Pentadbiran');
                
            Module::seedChild('Caches', 'Caches', 'caches', '/administration/caches', 6, 'Pentadbiran');

        // Irfan - Modul Pengisytiharan Pendaratan
        Module::seed('Pengisytiharan Pendaratan', 'Pengisytiharan Pendaratan', 'landingdeclaration', '/landingdeclaration', 'fas fa-edit', 51, true);
            Module::seedChild('Permohonan', 'Application', 'landingdeclarationapplication', '/landingdeclaration/application', 1, 'Pengisytiharan Pendaratan');  
            Module::seedChild('Semakan Pendaratan', 'Landing Check', 'landingdeclarationcheck', '/landingdeclaration/check', 2, 'Pengisytiharan Pendaratan');  
            Module::seedChild('Pengesahan Pendaratan', 'Landing Confirmation', 'landingdeclarationconfirmation', '/landingdeclaration/confirmation', 3, 'Pengisytiharan Pendaratan'); 
        
        // 5/2 Arifah 51 - Modul ESH
        Module::seed('Permohonan ESHND', 'Subsistence Allowance', 'subsistence-allowance', '/subsistence-allowance', 'fas fa-ship', 52, true);
            Module::seedChild('Permohonan', 'Application', 'application', '/subsistence-allowance/application', 1, 'Permohonan ESHND');
            Module::seedChild('Senarai Permohonan', 'List Application', 'list-application', '/subsistence-allowance/list-application', 2, 'Permohonan ESHND');
            Module::seedChild('Semakan KDP', 'KDP Review', 'kdp-review', '/subsistence-allowance/kdp-review', 3, 'Permohonan ESHND');
            Module::seedChild('Jana Nama Negeri', 'Genarate Name State', 'generate-name-state', '/subsistence-allowance/generate-name-state', 4, 'Permohonan ESHND'); 
            Module::seedChild('Jana Nama HQ', 'Generate Name HQ', 'generate-name-hq', '/subsistence-allowance/generate-name-hq', 5, 'Permohonan ESHND');

        // 12/3 Arifah 52 - Modul Pembaharuan ESH
        Module::seed('Pembaharuan ESHND', 'Subsistence Allowance Renewal', 'subsistence-allowance-renewal', '/subsistence-allowance-renewal', 'fas fa-ship', 53, true);
            Module::seedChild('Permohonan Pembaharuan', 'Application Renewal', 'application-renewal', '/subsistence-allowance-renewal/application-renewal', 1, 'Pembaharuan ESHND');
            Module::seedChild('Senarai Pembaharuan', 'List Renewal', 'list-renewal', '/subsistence-allowance-renewal/list-renewal', 2, 'Pembaharuan ESHND');
            Module::seedChild('Sokongan Pembaharuan', 'Supported Renewal', 'supported_renewal', '/subsistence-allowance-renewal/supported-renewal', 3, 'Pembaharuan ESHND');
            Module::seedChild('Jana Nama Negeri', 'Genarate Name State', 'generate-name-state', '/subsistence-allowance-renewal/generate-name-state', 4, 'Pembaharuan ESHND'); 
            Module::seedChild('Jana Nama HQ', 'Generate Name HQ', 'generate-name-hq', '/subsistence-allowance-renewal/generate-name-hq', 5, 'Pembaharuan ESHND');
            
        // Irfan - Modul Pembayaran ESH
        Module::seed('Pembayaran ESHND', 'Subsistence Allowance Payment', 'subsistenceallowancepayment', '/subsistenceallowancepayment', 'fas fa-edit', 54, true);
            Module::seedChild('Jana Nama Daerah', 'Generate Name District', 'generatenamedistrict', '/subsistenceallowancepayment/generatenamedistrict', 1, 'Pembayaran ESHND');  
            Module::seedChild('Sokongan Daerah', 'Support District', 'supportdistrict', '/subsistenceallowancepayment/supportdistrict', 2, 'Pembayaran ESHND');  
            Module::seedChild('Jana Nama Negeri', 'Generate Name State', 'generatenamestate', '/subsistenceallowancepayment/generatenamestate', 3, 'Pembayaran ESHND');  
            Module::seedChild('Kelulusan Negeri', 'Approval State', 'approvalstate', '/subsistenceallowancepayment/approvalstate', 4, 'Pembayaran ESHND');  
            Module::seedChild('Jana Nama Hq', 'Generate Name Hq', 'generatenamehq', '/subsistenceallowancepayment/generatenamehq', 5, 'Pembayaran ESHND');  
            Module::seedChild('Jana Peruntukan', 'Generate Allocation', 'generateallocation', '/subsistenceallowancepayment/generateallocation', 6, 'Pembayaran ESHND'); 
            Module::seedChild('Keputusan Bayaran', 'Payment Outcome', 'paymentoutcome', '/subsistenceallowancepayment/paymentoutcome', 7, 'Pembayaran ESHND');  
        
        // 13/3 Qistina 52 - Modul Permohonan Lucut Hak
        Module::seed('Permohonan Lucut Hak ESHND', 'Confiscation Application', 'confiscation', '/confiscation', 'fas fa-edit', 55, true);
            Module::seedChild('Permohonan', 'Application', 'update-application', '/confiscation/update-application', 1, 'Permohonan Lucut Hak ESHND');  
            Module::seedChild('Senarai Permohonan', 'Application List', 'support-application', '/confiscation/support-application', 2, 'Permohonan Lucut Hak ESHND');  
            Module::seedChild('Senarai Nama', 'Name List', 'name-list', '/confiscation/name-list', 3, 'Permohonan Lucut Hak ESHND');
            
        Module::seed('Temp Vessel', 'Temp Vessel', 'tempvessel', '/tempvessel', 'fas fa-edit', 99, true);
        
        //FADZLY 
        
    //     //  FARIS   =====================================
   
    
   //   // PERMOHONAN LESEN BAHARU
    //     Module::seed('Lesen Baharu', 'New License', 'lesenBaharu', '/lesenBaharu', 'fas fa-id-card-alt', 72, true);
    //     Module::seedChild('Permohonan', 'Application', 'permohonan-01', '/lesenBaharu/permohonan-01', 1, 'Lesen Baharu');
    //     Module::seedChild('Semakan Dokumen & Ulasan', 'Document Review & Commentary', 'semakanDokumen-01', '/lesenBaharu/semakanDokumen-01', 2, 'Lesen Baharu');
    //     Module::seedChild('Sah/Pinda Tarikh Pemeriksaan LPI', 'Validate/Amend LPI Inspection Date', 'pindaLpi-01', '/lesenBaharu/pindaLpi-01', 3, 'Lesen Baharu');
    //     Module::seedChild('Laporan LPI', 'LPI Report', 'laporanLpi-01', '/lesenBaharu/laporanLpi-01', 4, 'Lesen Baharu');
    //     Module::seedChild('Sokongan & Ulasan', 'Support And Comments', 'sokonganUlasan-01', '/lesenBaharu/sokonganUlasan-01', 5, 'Lesen Baharu');
    //     Module::seedChild('Semakan & Ulasan', 'Review & Commentary', 'semakanUlasan-01', '/lesenBaharu/semakanUlasan-01', 6, 'Lesen Baharu');
    //     Module::seedChild('Sokongan & Ulasan 2', 'Support And Comments 2', 'sokonganUlasan-1-01', '/lesenBaharu/sokonganUlasan-1-01', 7, 'Lesen Baharu');
    //     Module::seedChild('Keputusan', 'Decision', 'keputusan-01', '/lesenBaharu/keputusan-01', 8, 'Lesen Baharu');
    //     Module::seedChild('Resit Bayaran', 'Payment Receipt', 'resitBayaran-01', '/lesenBaharu/resitBayaran-01', 9, 'Lesen Baharu');
    //     Module::seedChild('Semakan & Pengesahan Bayaran', 'Payment Review & Confirmation', 'semakanBayaran-01', '/lesenBaharu/semakanBayaran-01', 10, 'Lesen Baharu');
    //     Module::seedChild('Cetak Lesen', 'Print License', 'cetakLesen-01', '/lesenBaharu/cetakLesen-01', 11, 'Lesen Baharu');

    //      // PERMOHONAN LESEN TAHUNAN
    //     Module::seed('Baharu Lesen Tahunan', 'Annual License Renewal', 'lesenTahunan', '/lesenTahunan', 'fas fa-calendar-check', 73, true);
    //     Module::seedChild('Permohonan', 'Application', 'permohonan-02', '/lesenTahunan/permohonan-02', 1, 'Baharu Lesen Tahunan');
    //     Module::seedChild('Semakan Dokumen & Ulasan', 'Document Review & Commentary', 'semakanDokumen-02', '/lesenTahunan/semakanDokumen-02', 2, 'Baharu Lesen Tahunan');
    //     Module::seedChild('Sah/Pinda Tarikh Pemeriksaan LPI', 'Validate/Amend LPI Inspection Date', 'pindaLpi-02', '/lesenTahunan/pindaLpi-02', 3, 'Baharu Lesen Tahunan');
    //     Module::seedChild('Laporan LPI', 'LPI Report', 'laporanLpi-02', '/lesenTahunan/laporanLpi-02', 4, 'Baharu Lesen Tahunan');
    //     Module::seedChild('Keputusan', 'Decision', 'keputusan-02', '/lesenTahunan/keputusan-02', 5, 'Baharu Lesen Tahunan');
    //     Module::seedChild('Resit Bayaran', 'Payment Receipt', 'resitBayaran-02', '/lesenTahunan/resitBayaran-02', 6, 'Baharu Lesen Tahunan');
    //     Module::seedChild('Semakan & Pengesahan Bayaran', 'Payment Review & Confirmation', 'semakanBayaran-02', '/lesenTahunan/semakanBayaran-02', 7, 'Baharu Lesen Tahunan');
    //     Module::seedChild('Cetak Lesen', 'Print License', 'cetakLesen-02', '/lesenTahunan/cetakLesen-02', 8, 'Baharu Lesen Tahunan');
    //     Module::seedChild('Sokongan & Ulasan Rayuan', 'Support And Comments Appeal', 'sokonganUlasanR-02', '/lesenTahunan/sokonganUlasanR-02', 9, 'Baharu Lesen Tahunan');
    //     Module::seedChild('Semakan & Ulasan Rayuan', 'Review & Commentary Appeal', 'semakanUlasanR-02', '/lesenTahunan/semakanUlasanR-02', 10, 'Baharu Lesen Tahunan');
    //     Module::seedChild('Keputusan Rayuan', 'Appeal Decision', 'keputusanR-02', '/lesenTahunan/keputusanR-02', 11, 'Baharu Lesen Tahunan');


    //      // PERMOHONAN PINDAH PANGKALAN
    //     Module::seed('Pindah Pangkalan', 'Change Base', 'pindahPangkalan', '/pindahPangkalan', 'fas fa-map-marker-alt', 77, true);
    //     Module::seedChild('Permohonan', 'Application', 'permohonan-03', '/pindahPangkalan/permohonan-03', 1, 'Pindah Pangkalan');
    //     Module::seedChild('Semakan Dokumen & Ulasan', 'Document Review & Commentary', 'semakanDokumen-03', '/pindahPangkalan/semakanDokumen-03', 2, 'Pindah Pangkalan');
    //     Module::seedChild('Sah/Pinda Tarikh Pemeriksaan LPI', 'Validate/Amend LPI Inspection Date', 'pindaLpi-03', '/pindahPangkalan/pindaLpi-03', 3, 'Pindah Pangkalan');
    //     Module::seedChild('Laporan LPI', 'LPI Report', 'laporanLpi-03', '/pindahPangkalan/laporanLpi-03', 4, 'Pindah Pangkalan');
    //     Module::seedChild('Keputusan', 'Decision', 'keputusan-03', '/pindahPangkalan/keputusan-03', 5, 'Pindah Pangkalan');
    //     Module::seedChild('Semakan & Ulasan', 'Review & Commentary', 'semakanUlasan-03', '/pindahPangkalan/semakanUlasan-03', 6, 'Pindah Pangkalan');
    //     Module::seedChild('Resit Bayaran', 'Payment Receipt', 'resitBayaran-03', '/pindahPangkalan/resitBayaran-03', 7, 'Pindah Pangkalan');
    //     Module::seedChild('Semakan & Pengesahan Bayaran', 'Payment Review & Confirmation', 'semakanBayaran-03', '/pindahPangkalan/semakanBayaran-03', 8, 'Pindah Pangkalan');
    //     Module::seedChild('Cetak Lesen', 'Print License', 'cetakLesen-03', '/pindahPangkalan/cetakLesen-03', 9, 'Pindah Pangkalan');
    //     Module::seedChild('Keputusan (Baru)', 'Decision (New)', 'keputusanBaru-03', '/pindahPangkalan/keputusanBaru-03', 10, 'Pindah Pangkalan');
    //     Module::seedChild('Resit Bayaran (Baru)', 'Payment Receipt (New)', 'resitBayaranBaru-03', '/pindahPangkalan/resitBayaranBaru-03', 11, 'Pindah Pangkalan');
    //     Module::seedChild('Semakan Bayaran (Baru)', 'Payment Review & Confirmation (New)', 'semakanBayaranBaru-03', '/pindahPangkalan/semakanBayaranBaru-03', 12, 'Pindah Pangkalan');
    //     Module::seedChild('Cetak Lesen (Baru)', 'Print License (New)', 'cetakLesenBaru-03', '/pindahPangkalan/cetakLesenBaru-03', 13, 'Pindah Pangkalan');
    //     Module::seedChild('Sokongan & Ulasan (Rayuan)', 'Support and Comments (Appeal)', 'sokonganUlasanR-03', '/pindahPangkalan/sokonganUlasanR-03', 14, 'Pindah Pangkalan');
    //     Module::seedChild('Semakan & Ulasan (Rayuan)', 'Review & Commentary (Appeal)', 'semakanUlasanR-03', '/pindahPangkalan/semakanUlasanR-03', 15, 'Pindah Pangkalan');
    //     Module::seedChild('Keputusan (Rayuan)', 'Appeal Decision', 'keputusanR-03', '/pindahPangkalan/keputusanR-03', 16, 'Pindah Pangkalan');

    //  //     //  TUKAR PERALATAN
         
    //         Module::seed('Tukar Peralatan', 'Change Equipment', 'tukarPeralatan', '/tukarPeralatan', 'fas fa-tools', 75, true);
    //         Module::seedChild('Permohonan', 'Application', 'permohonan-04', '/tukarPeralatan/permohonan-04', 1, 'Tukar Peralatan');
    //         Module::seedChild('Semakan Dokumen & Ulasan', 'Document Review & Commentary', 'semakanDokumen-04', '/tukarPeralatan/semakanDokumen-04', 2, 'Tukar Peralatan');
    //         Module::seedChild('Sah/Pinda Tarikh Pemeriksaan LPI', 'Validate/Amend LPI Inspection Date', 'pindaLpi-04', '/tukarPeralatan/pindaLpi-04', 3, 'Tukar Peralatan');
    //         Module::seedChild('Laporan LPI', 'LPI Report', 'laporanLpi-04', '/tukarPeralatan/laporanLpi-04', 4, 'Tukar Peralatan');
    //         Module::seedChild('Keputusan', 'Decision', 'keputusan-04', '/tukarPeralatan/keputusan-04', 5, 'Tukar Peralatan');
    //         Module::seedChild('Resit Bayaran', 'Payment Receipt', 'resitBayaran-04', '/tukarPeralatan/resitBayaran-04', 6, 'Tukar Peralatan');
    //         Module::seedChild('Semakan & Pengesahan Bayaran', 'Payment Review & Confirmation', 'semakanBayaran-04', '/tukarPeralatan/semakanBayaran-04', 7, 'Tukar Peralatan');
    //         Module::seedChild('Cetak Lesen', 'Print License', 'cetakLesen-04', '/tukarPeralatan/cetakLesen-04', 8, 'Tukar Peralatan');
    //         Module::seedChild('Sokongan & Ulasan Rayuan', 'Support And Comments Appeal', 'sokonganUlasanR-04', '/tukarPeralatan/sokonganUlasanR-04', 9, 'Tukar Peralatan');
    //         Module::seedChild('Semakan & Ulasan Rayuan', 'Review & Commentary Appeal', 'semakanUlasanR-04', '/tukarPeralatan/semakanUlasanR-04', 10, 'Tukar Peralatan');
    //         Module::seedChild('Keputusan Rayuan', 'Appeal Decision', 'keputusanR-04', '/tukarPeralatan/keputusanR-04', 11, 'Tukar Peralatan');

    //     // TUKAR ENJIN
    //          Module::seed('Tukar Enjin', 'Change Engine', 'tukarEnjin', '/tukarEnjin', 'fas fa-cogs', 76, true);
    //         Module::seedChild('Permohonan', 'Application', 'permohonan-05', '/tukarEnjin/permohonan-05', 1, 'Tukar Enjin');
    //         Module::seedChild('Semakan Dokumen & Ulasan', 'Document Review & Commentary', 'semakanDokumen-05', '/tukarEnjin/semakanDokumen-05', 2, 'Tukar Enjin');
    //         Module::seedChild('Sah/Pinda Tarikh Pemeriksaan LPI', 'Validate/Amend LPI Inspection Date', 'pindaLpi-05', '/tukarEnjin/pindaLpi-05', 3, 'Tukar Enjin');
    //         Module::seedChild('Laporan LPI', 'LPI Report', 'laporanLpi-05', '/tukarEnjin/laporanLpi-05', 4, 'Tukar Enjin');
    //         Module::seedChild('Keputusan', 'Decision', 'keputusan-05', '/tukarEnjin/keputusan-05', 5, 'Tukar Enjin');
    //         Module::seedChild('Resit Bayaran', 'Payment Receipt', 'resitBayaran-05', '/tukarEnjin/resitBayaran-05', 6, 'Tukar Enjin');
    //         Module::seedChild('Semakan & Pengesahan Bayaran', 'Payment Review & Confirmation', 'semakanBayaran-05', '/tukarEnjin/semakanBayaran-05', 7, 'Tukar Enjin');
    //         Module::seedChild('Cetak Lesen', 'Print License', 'cetakLesen-05', '/tukarEnjin/cetakLesen-05', 8, 'Tukar Enjin');
    //         Module::seedChild('Sokongan & Ulasan Rayuan', 'Support And Comments Appeal', 'sokonganUlasanR-05', '/tukarEnjin/sokonganUlasanR-05', 9, 'Tukar Enjin');
    //         Module::seedChild('Semakan & Ulasan Rayuan', 'Review & Commentary Appeal', 'semakanUlasanR-05', '/tukarEnjin/semakanUlasanR-05', 10, 'Tukar Enjin');
    //         Module::seedChild('Keputusan Rayuan', 'Appeal Decision', 'keputusanR-05', '/tukarEnjin/keputusanR-05', 11, 'Tukar Enjin');

            // // PENDAFTARAN KAD NELAYAN DARAT
            // Module::seed('Pendaftaran Kad Nelayan Darat', 'Fisherman Card Registration', 'kadPendaftaran', '/kadPendaftaran', 'fas fa-id-card', 70, true);
            // Module::seedChild('Permohonan', 'Application', 'permohonan-08', '/kadPendaftaran/permohonan-08', 1, 'Pendaftaran Kad Nelayan Darat');
            // Module::seedChild('Semakan Dokumen & Ulasan', 'Document Review & Commentary', 'semakanDokumen-08', '/kadPendaftaran/semakanDokumen-08', 2, 'Pendaftaran Kad Nelayan Darat');
            // Module::seedChild('Sah/Pinda Tarikh Pemeriksaan LPI', 'Validate/Amend LPI Inspection Date', 'pindaLpi-08', '/kadPendaftaran/pindaLpi-08', 3, 'Pendaftaran Kad Nelayan Darat');
            // Module::seedChild('Laporan LPI', 'LPI Report', 'laporanLpi-08', '/kadPendaftaran/laporanLpi-08', 4, 'Pendaftaran Kad Nelayan Darat');
            // Module::seedChild('Sokongan & Ulasan', 'Support And Comments', 'sokonganUlasan-08', '/kadPendaftaran/sokonganUlasan-08', 5, 'Pendaftaran Kad Nelayan Darat');
            // Module::seedChild('Semakan & Ulasan', 'Review & Commentary', 'semakanUlasan-08', '/kadPendaftaran/semakanUlasan-08', 6, 'Pendaftaran Kad Nelayan Darat');
            // Module::seedChild('Sokongan & Ulasan', 'Support And Comments', 'sokonganUlasan-1-08', '/kadPendaftaran/sokonganUlasan-1-08', 7, 'Pendaftaran Kad Nelayan Darat');
            // Module::seedChild('Keputusan', 'Decision', 'keputusan-08', '/kadPendaftaran/keputusan-08', 8, 'Pendaftaran Kad Nelayan Darat');
            // Module::seedChild('Resit Bayaran', 'Payment Receipt', 'resitBayaran-08', '/kadPendaftaran/resitBayaran-08', 9, 'Pendaftaran Kad Nelayan Darat');
            // Module::seedChild('Semakan & Pengesahan Bayaran', 'Payment Review & Confirmation', 'semakanBayaran-08', '/kadPendaftaran/semakanBayaran-08', 10, 'Pendaftaran Kad Nelayan Darat');
            // Module::seedChild('Cetak Lesen', 'Print License', 'cetakLesen-08', '/kadPendaftaran/cetakLesen-08', 11, 'Pendaftaran Kad Nelayan Darat');
            // Module::seedChild('Sokongan & Ulasan Rayuan', 'Support And Comments Appeal', 'sokonganUlasanR-08', '/kadPendaftaran/sokonganUlasanR-08', 12, 'Pendaftaran Kad Nelayan Darat');
            // Module::seedChild('Semakan & Ulasan Rayuan', 'Review & Commentary Appeal', 'semakanUlasanR-08', '/kadPendaftaran/semakanUlasanR-08', 13, 'Pendaftaran Kad Nelayan Darat');
            // Module::seedChild('Keputusan Rayuan', 'Appeal Decision', 'keputusanR-08', '/kadPendaftaran/keputusanR-08', 14, 'Pendaftaran Kad Nelayan Darat');

                 //     // GANTI KULI PELUPUSAN
       
        // Module::seed('Ganti Kulit Dan Pelupusan', 'Change Hull And Disposal', 'gantiKulit', '/gantiKulit', 'fas fa-recycle', 78, true);
        // Module::seedChild('Permohonan', 'Application', 'permohonan-06', '/gantiKulit/permohonan-06', 1, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Semakan Dokumen & Ulasan', 'Document Review & Comments', 'semakanDokumen-06', '/gantiKulit/semakanDokumen-06', 2, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Sah/Pinda Tarikh Pemeriksaan LPI', 'Verify/Amend LPI Inspection Date', 'pindaLpi-06', '/gantiKulit/pindaLpi-06', 3, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Laporan LPI', 'LPI Report', 'laporanLpi-06', '/gantiKulit/laporanLpi-06', 4, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Keputusan', 'Decision', 'keputusan-06', '/gantiKulit/keputusan-06', 5, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Resit Bayaran', 'Payment Receipt', 'resitBayaran-06', '/gantiKulit/resitBayaran-06', 6, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Semakan & Pengesahan Bayaran', 'Payment Verification & Confirmation', 'semakanBayaran-06', '/gantiKulit/semakanBayaran-06', 7, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Cetak Lesen', 'Print License', 'cetakLesen-06', '/gantiKulit/cetakLesen-06', 8, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Semakan Dokumen & Ulasan Lupus', 'Disposal Document Review & Comments', 'semakanDokumenLupus-06', '/gantiKulit/semakanDokumenLupus-06', 9, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Laporan LPI Lupus', 'Disposal LPI Report', 'laporanLpiLupus-06', '/gantiKulit/laporanLpiLupus-06', 10, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Semakan & Pengesahan Lupus', 'Disposal Verification & Confirmation', 'semakanLupus-06', '/gantiKulit/semakanLupus-06', 11, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Sokongan & Ulasan Rayuan', 'Appeal Support & Comments', 'sokonganUlasanR-06', '/gantiKulit/sokonganUlasanR-06', 12, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Semakan & Ulasan Rayuan', 'Appeal Review & Comments', 'semakanUlasanR-06', '/gantiKulit/semakanUlasanR-06', 13, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Keputusan Rayuan', 'Appeal Decision', 'keputusanR-06', '/gantiKulit/keputusanR-06', 14, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Keputusan Rayuan', 'Appeal Decision', 'keputusanR-06', '/gantiKulit/keputusanR-06', 14, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Pemeriksaan Vesel (Lupus)', 'Disposal LPI Report', 'laporanLpiLupus-06', '/gantiKulit/laporanLpiLupus-06', 15, 'Ganti Kulit Dan Pelupusan');
        // Module::seedChild('Semakan Pengesahan (Lupus)', 'Disposal Verification & Confirmation', 'semakanLupus-06', '/gantiKulit/semakanLupus-06', 16, 'Ganti Kulit Dan Pelupusan');

        //     //     // LESEN LEBIH 1 TAHUN
        //     // Module::seed('Lesen Lebih 1 Tahun', 'Extended License (>1 Year)', 'lebihTahun', '/lebihTahun', 'fas fa-user', 74, true);
        //     Module::seed('Lesen Lebih 1 Tahun', 'Extended License (>1 Year)', 'lebihTahun', '/lebihTahun', 'fas fa-file-alt', 74, true);
        //     Module::seedChild('Permohonan', 'Application', 'permohonan-07', '/lebihTahun/permohonan-07', 1, 'Lesen Lebih 1 Tahun');
        //     Module::seedChild('Semakan Dokumen & Ulasan', 'Document Review & Commentary', 'semakanDokumen-07', '/lebihTahun/semakanDokumen-07', 2, 'Lesen Lebih 1 Tahun');
        //     Module::seedChild('Sah/Pinda Tarikh Pemeriksaan LPI', 'Validate/Amend LPI Inspection Date', 'pindaLpi-07', '/lebihTahun/pindaLpi-07', 3, 'Lesen Lebih 1 Tahun');
        //     Module::seedChild('Laporan LPI', 'LPI Report', 'laporanLpi-07', '/lebihTahun/laporanLpi-07', 4, 'Lesen Lebih 1 Tahun');
        //     Module::seedChild('Sokongan & Ulasan', 'Support And Comments', 'sokonganUlasan-07', '/lebihTahun/sokonganUlasan-07', 5, 'Lesen Lebih 1 Tahun');
        //     Module::seedChild('Semakan & Ulasan', 'Review & Commentary', 'semakanUlasan-07', '/lebihTahun/semakanUlasan-07', 6, 'Lesen Lebih 1 Tahun');
        //     Module::seedChild('Sokongan & Ulasan', 'Additional Support & Comments', 'sokonganUlasan-1-07', '/lebihTahun/sokonganUlasan-1-07', 7, 'Lesen Lebih 1 Tahun');
        //     Module::seedChild('Keputusan', 'Decision', 'keputusan-07', '/lebihTahun/keputusan-07', 8, 'Lesen Lebih 1 Tahun');
        //     Module::seedChild('Resit Bayaran', 'Payment Receipt', 'resitBayaran-07', '/lebihTahun/resitBayaran-07', 9, 'Lesen Lebih 1 Tahun');
        //     Module::seedChild('Semakan & Pengesahan Bayaran', 'Payment Review & Confirmation', 'semakanBayaran-07', '/lebihTahun/semakanBayaran-07', 10, 'Lesen Lebih 1 Tahun');
        //     Module::seedChild('Cetak Lesen', 'Print License', 'cetakLesen-07', '/lebihTahun/cetakLesen-07', 11, 'Lesen Lebih 1 Tahun');

        //        //     //BAHARU KAD NELAYAN DARAT
        //      Module::seed('Baharu Kad Pendaftaran Nelayan', 'Fisherman Card Registration Renewal', 'baharuKadNelayan', '/baharuKadNelayan', 'fas fa-id-badge', 71, true);
        //     Module::seedChild('Permohonan', 'Application', 'permohonan-09', '/baharuKadNelayan/permohonan-09', 1, 'Baharu Kad Pendaftaran Nelayan');
        //     Module::seedChild('Semakan Dokumen & Ulasan', 'Document Review & Commentary', 'semakanDokumen-09', '/baharuKadNelayan/semakanDokumen-09', 2, 'Baharu Kad Pendaftaran Nelayan');
        //     Module::seedChild('Sah/Pinda Tarikh Pemeriksaan LPI', 'Validate/Amend LPI Inspection Date', 'pindaLpi-09', '/baharuKadNelayan/pindaLpi-09', 3, 'Baharu Kad Pendaftaran Nelayan');
        //     Module::seedChild('Laporan LPI', 'LPI Report', 'laporanLpi-09', '/baharuKadNelayan/laporanLpi-09', 4, 'Baharu Kad Pendaftaran Nelayan');
        //     Module::seedChild('Keputusan', 'Decision', 'keputusan-09', '/baharuKadNelayan/keputusan-09', 5, 'Baharu Kad Pendaftaran Nelayan');
        //     Module::seedChild('Resit Bayaran', 'Payment Receipt', 'resitBayaran-09', '/baharuKadNelayan/resitBayaran-09', 6, 'Baharu Kad Pendaftaran Nelayan');
        //     Module::seedChild('Semakan & Pengesahan Bayaran', 'Payment Review & Confirmation', 'semakanBayaran-09', '/baharuKadNelayan/semakanBayaran-09', 7, 'Baharu Kad Pendaftaran Nelayan');
        //     Module::seedChild('Cetak Lesen', 'Print License', 'cetakLesen-09', '/baharuKadNelayan/cetakLesen-09', 8, 'Baharu Kad Pendaftaran Nelayan');
        //     Module::seedChild('Sokongan & Ulasan Rayuan', 'Support And Comments Appeal', 'sokonganUlasanR-09', '/baharuKadNelayan/sokonganUlasanR-09', 9, 'Baharu Kad Pendaftaran Nelayan');
        //     Module::seedChild('Semakan & Ulasan Rayuan', 'Review & Commentary Appeal', 'semakanUlasanR-09', '/baharuKadNelayan/semakanUlasanR-09', 10, 'Baharu Kad Pendaftaran Nelayan');
        //     Module::seedChild('Keputusan Rayuan', 'Appeal Decision', 'keputusanR-09', '/baharuKadNelayan/keputusanR-09', 11, 'Baharu Kad Pendaftaran Nelayan');
 
    // //  FARIS   =====================================

    }
}