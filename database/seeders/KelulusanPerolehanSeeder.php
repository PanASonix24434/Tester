<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KelulusanPerolehan;
use App\Models\Permit;
use App\Models\User;

class KelulusanPerolehanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a user to assign the approvals to
        $user = User::first();
        
        if (!$user) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        // Create dummy kelulusan perolehan data
        $kelulusanData = [
            [
                'no_rujukan' => 'PPKPV01-923',
                'jenis_permohonan' => 'kvp07',
                'status' => 'active',
                'tarikh_kelulusan' => '2024-01-15',
                'tarikh_tamat' => '2025-01-15',
                'user_id' => $user->id,
                'permits' => [
                    ['no_permit' => '112341', 'jenis_peralatan' => 'Pukat Hanyut', 'status' => 'ada_kemajuan'],
                    ['no_permit' => '112342', 'jenis_peralatan' => 'Pukat Hanyut', 'status' => 'ada_kemajuan'],
                    ['no_permit' => '112343', 'jenis_peralatan' => 'Pukat Tunda', 'status' => 'tiada_kemajuan'],
                ]
            ],
            [
                'no_rujukan' => 'PPKPV02-512',
                'jenis_permohonan' => 'kvp07',
                'status' => 'active',
                'tarikh_kelulusan' => '2024-02-20',
                'tarikh_tamat' => '2025-02-20',
                'user_id' => $user->id,
                'permits' => [
                    ['no_permit' => '112344', 'jenis_peralatan' => 'Pukat Tunda', 'status' => 'ada_kemajuan'],
                    ['no_permit' => '112345', 'jenis_peralatan' => 'Rawai', 'status' => 'tiada_kemajuan'],
                ]
            ],
            [
                'no_rujukan' => 'PPKPV03-351',
                'jenis_permohonan' => 'kvp08',
                'status' => 'active',
                'tarikh_kelulusan' => '2024-03-10',
                'tarikh_tamat' => '2025-03-10',
                'user_id' => $user->id,
                'permits' => [
                    ['no_permit' => '112346', 'jenis_peralatan' => 'Pukat Hanyut', 'status' => 'ada_kemajuan'],
                    ['no_permit' => '112347', 'jenis_peralatan' => 'Pukat Tunda', 'status' => 'tiada_kemajuan'],
                    ['no_permit' => '112348', 'jenis_peralatan' => 'Rawai', 'status' => 'ada_kemajuan'],
                ]
            ],
        ];

        foreach ($kelulusanData as $data) {
            $permits = $data['permits'];
            unset($data['permits']);
            
            $kelulusan = KelulusanPerolehan::create($data);
            
            // Create permits for this kelulusan
            foreach ($permits as $permitData) {
                Permit::create([
                    'no_permit' => $permitData['no_permit'],
                    'kelulusan_perolehan_id' => $kelulusan->id,
                    'jenis_peralatan' => $permitData['jenis_peralatan'],
                    'status' => $permitData['status'],
                    'is_active' => true,
                ]);
            }
        }

        $this->command->info('Kelulusan Perolehan and Permits seeded successfully!');
    }
}
