<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appeal;
use App\Models\Perakuan;
use App\Models\User;
use Illuminate\Support\Str;

class TestAppealDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find or create a test user
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'username' => '123456789012',
                'password' => bcrypt('password'),
                'peranan' => 'pelesen'
            ]);
        }

        // Create test KPV-07 applications (Rayuan Pindaan Syarat)
        for ($i = 1; $i <= 3; $i++) {
            $appeal = Appeal::create([
                'id' => (string) Str::uuid(),
                'applicant_id' => $user->id,
                'status' => 'submitted',
                'created_at' => now()->subDays($i),
                'updated_at' => now()->subDays($i)
            ]);

            Perakuan::create([
                'user_id' => (string) $user->id,
                'appeal_id' => $appeal->id,
                'type' => 'kvp07',
                'jenis_pindaan_syarat' => 'Permohonan Rayuan Pindaan Syarat',
                'jenis_bahan_binaan_vesel' => 'Gentian Kaca (Fiber)',
                'jenis_perolehan' => 'Vesel Bina Baru Dalam Negara',
                'justifikasi_pindaan' => 'Test justification for amendment ' . $i,
                'tarikh_mula_kelulusan' => now()->subDays(30)->format('Y-m-d'),
                'tarikh_tamat_kelulusan' => now()->addDays(30)->format('Y-m-d'),
                'status' => 'submitted',
                'created_at' => now()->subDays($i),
                'updated_at' => now()->subDays($i)
            ]);
        }

        // Create test KPV-07 application with Luar Negara
        $appeal = Appeal::create([
            'id' => (string) Str::uuid(),
            'applicant_id' => $user->id,
            'status' => 'submitted',
            'created_at' => now()->subDays(4),
            'updated_at' => now()->subDays(4)
        ]);

        Perakuan::create([
            'user_id' => (string) $user->id,
            'appeal_id' => $appeal->id,
            'type' => 'kvp07',
            'jenis_pindaan_syarat' => 'Permohonan Rayuan Pindaan Syarat',
            'jenis_bahan_binaan_vesel' => 'Kayu',
            'jenis_perolehan' => 'Vesel Bina Baru Luar Negara',
            'alamat_limbungan_luar_negara' => 'Jalan Limbungan Luar Negara, Taman Limbungan, 12345 Luar Negara',
            'negara_limbungan' => 'Indonesia',
            'justifikasi_pindaan' => 'Test justification for luar negara amendment',
            'tarikh_mula_kelulusan' => now()->subDays(25)->format('Y-m-d'),
            'tarikh_tamat_kelulusan' => now()->addDays(35)->format('Y-m-d'),
            'status' => 'submitted',
            'created_at' => now()->subDays(4),
            'updated_at' => now()->subDays(4)
        ]);

        // Create test KPV-08 applications (Rayuan Lanjut Tempoh)
        for ($i = 1; $i <= 2; $i++) {
            $appeal = Appeal::create([
                'id' => (string) Str::uuid(),
                'applicant_id' => $user->id,
                'status' => 'submitted',
                'created_at' => now()->subDays($i + 3),
                'updated_at' => now()->subDays($i + 3)
            ]);

            Perakuan::create([
                'user_id' => (string) $user->id,
                'appeal_id' => $appeal->id,
                'type' => 'kvp08',
                'jenis_pindaan_syarat' => 'Permohonan Lanjut Tempoh Sah Kelulusan Perolehan',
                'jenis_bahan_binaan_vesel' => 'Besi',
                'jenis_perolehan' => 'Vesel Terpakai Tempatan',
                'justifikasi_lanjutan_tempoh' => 'Test justification for extension ' . $i,
                'tarikh_mula_kelulusan' => now()->subDays(60)->format('Y-m-d'),
                'tarikh_tamat_kelulusan' => now()->subDays(30)->format('Y-m-d'),
                'status' => 'Draft',
                'created_at' => now()->subDays($i + 3),
                'updated_at' => now()->subDays($i + 3)
            ]);
        }

        $this->command->info('Test appeal data created successfully!');
        $this->command->info('- 3 KPV-07 applications (Rayuan Pindaan Syarat)');
        $this->command->info('- 2 KPV-08 applications (Rayuan Lanjut Tempoh)');
    }
}
