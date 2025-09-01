<?php

use App\Models\Perakuan;
use App\Models\Appeal;
use Illuminate\Support\Str;

// Run with: php artisan tinker --execute="require 'database/scripts/fix_perakuan_appeal_id.php';"

$orphans = Perakuan::whereNull('appeal_id')->orWhere('appeal_id', '0')->get();

foreach ($orphans as $perakuan) {
    $appeal = Appeal::where('applicant_id', $perakuan->user_id)->latest()->first();
    if (!$appeal) {
        // Create a new Appeal if none exists
        $appeal = Appeal::create([
            'id' => (string) Str::uuid(),
            'applicant_id' => $perakuan->user_id,
            'status' => 'submitted',
        ]);
        echo "Created new appeal {$appeal->id} for user {$perakuan->user_id}\n";
    }
    $perakuan->appeal_id = $appeal->id;
    $perakuan->save();
    echo "Updated perakuan {$perakuan->id} with appeal_id {$appeal->id}\n";
}
echo "Done updating perakuan appeal_id.\n"; 