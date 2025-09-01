<?php

namespace App\Http\Controllers\keputusan_status;

use App\Http\Controllers\Controller;
use App\Models\StatusStock;
use App\Models\FishType;

class KeputusanStatusController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        \Log::info('KeputusanStatusController user peranan: ' . ($user->peranan ?? 'NULL'));
        if (!$user || stripos($user->peranan ?? '', 'PENGARAH KANAN') === false) {
            abort(403, 'Unauthorized');
        }
        
        // Get all fish types from database
        $fishTypes = FishType::orderBy('name')->get();
        
        return view('app.keputusan_status.keputusan_status', [
            'fishTypes' => $fishTypes,
        ]);
    }

    public function downloadDokumenSenaraiStok()
    {
        $tahun = request('tahun');
        $dokumen = StatusStock::where('tahun', $tahun)
            ->whereNotNull('dokumen_senarai_stok')
            ->orderByDesc('id')
            ->first();
        
        if ($dokumen && $dokumen->dokumen_senarai_stok && \Storage::disk('public')->exists($dokumen->dokumen_senarai_stok)) {
            return \Storage::disk('public')->download($dokumen->dokumen_senarai_stok);
        }
        abort(404, 'Dokumen Senarai Stok tidak dijumpai');
    }

    public function downloadDokumenKelulusanKpp()
    {
        $tahun = request('tahun');
        $dokumen = StatusStock::where('tahun', $tahun)
            ->whereNotNull('dokumen_kelulusan_kpp')
            ->orderByDesc('id')
            ->first();
        
        if ($dokumen && $dokumen->dokumen_kelulusan_kpp && \Storage::disk('public')->exists($dokumen->dokumen_kelulusan_kpp)) {
            return \Storage::disk('public')->download($dokumen->dokumen_kelulusan_kpp);
        }
        abort(404, 'Dokumen Kelulusan KPP tidak dijumpai');
    }
} 