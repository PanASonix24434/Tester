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
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Clear existing stock modules first (delete children first, then parent)
        \App\Models\Systems\Module::where('name', 'Status Stok')->delete();
        \App\Models\Systems\Module::where('name', 'Pengurusan Stok SSD')->delete();
        \App\Models\Systems\Module::where('name', 'Pengurusan Stok')->delete();
        
        // Clear role-based modules
        \App\Models\Systems\Module::where('name', 'KDP - SSD Management')->delete();
        \App\Models\Systems\Module::where('name', 'KCSPT(N) - SSD Management')->delete();
        \App\Models\Systems\Module::where('name', 'PPN - SSD Management')->delete();
        \App\Models\Systems\Module::where('name', 'FA (HQ) - SSD Management')->delete();
        \App\Models\Systems\Module::where('name', 'PPL - SSD Management')->delete();
        
        // 56 - Modul Pengurusan Stok
        Module::seed('Pengurusan Stok', 'Stock Management', 'stock-management', '/stock-management', 'fas fa-boxes', 56, true);
            Module::seedChild('Status Stok', 'Stock Status', 'status-stock', '/status_stok', 1, 'Pengurusan Stok');
            Module::seedChild('Pengurusan Stok SSD', 'SSD Stock Management', 'ssd-stock-management', '/ssd-stock', 2, 'Pengurusan Stok');
            
        // Role-based SSD Stock Management Modules
        // KDP Role Modules
        Module::seed('KDP - SSD Management', 'KDP SSD Management', 'kdp-ssd-management', '/ssd-stock', 'fas fa-building', 57, true);
            Module::seedChild('Permohonan Stok SSD', 'Apply SSD Stock', 'permohonan-stok-ssd', '/ssd-stock', 1, 'KDP - SSD Management');
            Module::seedChild('Semakan Key In - KDP', 'Key In Review - KDP', 'semakan-key-in-kdp', '/ssd-stock/semakan-key-in-kdp', 2, 'KDP - SSD Management');
            Module::seedChild('Pelupusan SSD - KDP', 'SSD Disposal - KDP', 'pelupusan-ssd-kdp', '/ssd-stock/pelupusan-ssd-kdp', 3, 'KDP - SSD Management');
            
        // KCSPT(N) Role Modules
        Module::seed('KCSPT(N) - SSD Management', 'KCSPT(N) SSD Management', 'kcspt-ssd-management', '/ssd-stock', 'fas fa-warehouse', 58, true);
            Module::seedChild('Semakan Sokongan', 'Support Review', 'semakan-sokongan', '/ssd-stock/semakan-sokongan', 1, 'KCSPT(N) - SSD Management');
            Module::seedChild('Semakan Key In - KCSPT', 'Key In Review - KCSPT', 'semakan-key-in-kcspt', '/ssd-stock/semakan-key-in', 2, 'KCSPT(N) - SSD Management');
            Module::seedChild('Semakan Key Out - KCSPT(N)', 'Key Out Review - KCSPT(N)', 'semakan-key-out-kcspt', '/ssd-stock/semakan-key-out-kcspt', 3, 'KCSPT(N) - SSD Management');
            
        // PPN Role Modules
        Module::seed('PPN - SSD Management', 'PPN SSD Management', 'ppn-ssd-management', '/ssd-stock', 'fas fa-check-circle', 59, true);
            Module::seedChild('Semakan Key Out - PPN', 'Key Out Review - PPN', 'semakan-key-out-ppn', '/ssd-stock/semakan-key-out-ppn', 1, 'PPN - SSD Management');
            
        // FA (HQ) Role Modules
        Module::seed('FA (HQ) - SSD Management', 'FA (HQ) SSD Management', 'fa-hq-ssd-management', '/ssd-stock', 'fas fa-university', 60, true);
            Module::seedChild('Semakan Key Out - FA', 'Key Out Review - FA', 'semakan-key-out-fa', '/ssd-stock/semakan-key-out', 1, 'FA (HQ) - SSD Management');
            
        // PPL Role Modules
        Module::seed('PPL - SSD Management', 'PPL SSD Management', 'ppl-ssd-management', '/ssd-stock', 'fas fa-gavel', 61, true);
            Module::seedChild('Semakan Keputusan', 'Decision Review', 'semakan-keputusan', '/ssd-stock/semakan-keputusan', 1, 'PPL - SSD Management');
            
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}