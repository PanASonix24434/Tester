<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update specific user data
        DB::table('users')
            ->where('id', 'd43950e4-c42f-4c3d-b73a-f1b3d0c659dc')
            ->update([
                'bumiputera_type' => 1, // 1 = Bumiputera, 0 = Non-Bumiputera
                'address1' => 'No. 123, Jalan Contoh',
                'address2' => 'Taman Contoh',
                'postcode' => '12345',
                'district' => 'Kuala Lumpur',
                'state_id' => 1, // Use actual state ID from states table
                'user_type' => 1, // 1 = applicant, 2 = officer, etc.
                'contact_number' => '0123456789',
                'updated_at' => now(),
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the changes (you may need to adjust these values based on original data)
        DB::table('users')
            ->where('id', 'd43950e4-c42f-4c3d-b73a-f1b3d0c659dc')
            ->update([
                'bumiputera_type' => null,
                'address1' => null,
                'address2' => null,
                'postcode' => null,
                'district' => null,
                'state_id' => null,
                'user_type' => null,
                'contact_number' => null,
                'updated_at' => now(),
            ]);
    }
};
