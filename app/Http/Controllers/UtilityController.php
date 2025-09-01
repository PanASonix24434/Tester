<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perakuan;
use App\Models\Appeal;

class UtilityController extends Controller
{
    /**
     * Fix all perakuan records that have invalid or missing appeal_id.
     * This matches perakuan.user_id with appeal.applicant_id.
     */
    public function fixAppealIds()
    {
        $perakuans = Perakuan::where(function ($query) {
            $query->whereNull('appeal_id')->orWhere('appeal_id', '0');
        })->get();

        $fixedCount = 0;

        foreach ($perakuans as $perakuan) {
            $latestAppeal = Appeal::where('applicant_id', $perakuan->user_id)
                                  ->orderByDesc('created_at')
                                  ->first();

            if ($latestAppeal) {
                $perakuan->appeal_id = $latestAppeal->id;
                $perakuan->save();
                $fixedCount++;
            }
        }

        return response()->json([
            'message' => "Successfully fixed $fixedCount perakuan(s)."
        ]);
    }
}
