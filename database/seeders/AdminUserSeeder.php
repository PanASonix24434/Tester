<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'username' => '111111111111',
            'email' => 'admin@example.com',
            'password' => Hash::make('P@ssw0rd12345'),
            'is_admin' => true,
            'is_active' => true,
        ]);
    }
} 