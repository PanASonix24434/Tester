<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LanjutanTempohController extends Controller
{
    public function storeDokumen(Request $request)
    {
        return response()->json(['message' => 'Dokumen disimpan']);
    }
}
