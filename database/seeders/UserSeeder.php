<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\User as User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('username', 'superadmin')->first();
        if (empty($admin)) {
            $user = new User();
            $user->name = 'Super Admin';
            $user->username = '111111111111';
            $user->email = 'superadmin@admin.com';
            $user->email_verified_at = Carbon::now();
            //$user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password
            $user->password = '$2y$10$yTDOfD1VhG/i0.VOCa4W.eFL6uJChubkEaeovAHrM1B94y/x6t8vq'; //P@ssw0rd12345
            $user->is_active = true;
            $user->is_admin = true;
            $user->save();
        }

    }
}