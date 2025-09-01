<?php

namespace App\Http\Controllers\semakan_stok;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatusStock;
use App\Models\FishType;
use App\Models\LicensingQuota;

class SemakanStokController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        \Log::info('SemakanStokController user peranan: ' . ($user->peranan ?? 'NULL'));
        if (!$user || stripos($user->peranan ?? '', 'KETUA CAWANGAN') === false) {
            abort(403, 'Unauthorized');
        }

        // Get all available years from status_stocks
        $years = \App\Models\StatusStock::whereNotNull('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $selectedYear = request('tahun');

        // Get all status_stocks for the selected year
        $statusStocks = collect();
        $fmas = collect();
        if ($selectedYear) {
            $statusStocks = \App\Models\StatusStock::with('fishType')->where('tahun', $selectedYear)->get();
            $fmas = \App\Models\StatusStock::where('tahun', $selectedYear)->distinct()->orderBy('fma')->pluck('fma');
        }

        // Get all fish types from database
        $fishTypes = \App\Models\FishType::orderBy('name')->get();

        return view('app.semakan_stok.semakan_stok', [
            'years' => $years,
            'selectedYear' => $selectedYear,
            'statusStocks' => $statusStocks,
            'fmas' => $fmas,
            'fishTypes' => $fishTypes,
        ]);
    }

    public function senaraiStatus()
    {
        $user = auth()->user();
        if (!$user || stripos($user->peranan ?? '', 'KETUA CAWANGAN') === false) {
            abort(403, 'Unauthorized');
        }

        $years = \App\Models\StatusStock::whereNotNull('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $selectedYear = request('tahun');
        $statusStocks = collect();
        $fmas = collect();
        $licensingQuotas = collect();
        
        if ($selectedYear) {
            $statusStocks = \App\Models\StatusStock::with('fishType')->where('tahun', $selectedYear)->get();
            $fmas = \App\Models\StatusStock::where('tahun', $selectedYear)->distinct()->orderBy('fma')->pluck('fma');
            
            // Get licensing quotas for the selected year
            try {
                $licensingQuotas = LicensingQuota::where('tahun', $selectedYear)
                    ->where('is_active', true)
                    ->orderBy('category')
                    ->orderBy('sub_category')
                    ->get();
            } catch (\Exception $e) {
                \Log::error('Error fetching licensing quotas: ' . $e->getMessage());
                $licensingQuotas = collect();
            }
        }

        // Get all fish types from database
        $fishTypes = \App\Models\FishType::orderBy('name')->get();

        return view('app.semakan_stok.senarai_status', [
            'years' => $years,
            'selectedYear' => $selectedYear,
            'statusStocks' => $statusStocks,
            'fmas' => $fmas,
            'fishTypes' => $fishTypes,
            'licensingQuotas' => $licensingQuotas,
        ]);
    }

    public function downloadDokumenKelulusanKpp()
    {
        $tahun = request('tahun');
        $dokumen = \App\Models\StatusStock::where('tahun', $tahun)
            ->whereNotNull('dokumen_kelulusan_kpp')
            ->orderByDesc('id')
            ->first();
        if ($dokumen && $dokumen->dokumen_kelulusan_kpp && \Storage::disk('public')->exists($dokumen->dokumen_kelulusan_kpp)) {
            return \Storage::disk('public')->download($dokumen->dokumen_kelulusan_kpp);
        }
        abort(404, 'Dokumen tidak dijumpai');
    }

    public function uploadDokumen(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'dokumen_kelulusan_kpp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $file = $request->file('dokumen_kelulusan_kpp');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('kelulusan_kpp', $fileName, 'public');

        // Update all status_stocks records for the given year
        \App\Models\StatusStock::where('tahun', $request->tahun)
            ->update(['dokumen_kelulusan_kpp' => $filePath]);

        return redirect()->back()->with('success', 'Dokumen berjaya dimuatnaik!');
    }

    /**
     * Store draft data for user submission
     */
    public function storeDraft(Request $request)
    {
        \Log::info('storeDraft method called');
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request URL: ' . $request->url());
        \Log::info('Request data: ' . json_encode($request->all()));
        \Log::info('CSRF token: ' . $request->header('X-CSRF-TOKEN'));
        
        // Check if files are actually uploaded
        $hasSenaraiStok = $request->hasFile('dokumen_senarai_stok') && $request->file('dokumen_senarai_stok')->isValid();
        $hasKelulusanKpp = $request->hasFile('dokumen_kelulusan_kpp') && $request->file('dokumen_kelulusan_kpp')->isValid();
        
        \Log::info('Has senarai stok file: ' . ($hasSenaraiStok ? 'yes' : 'no'));
        \Log::info('Has kelulusan kpp file: ' . ($hasKelulusanKpp ? 'yes' : 'no'));
        
        // Add detailed file information logging
        if ($request->hasFile('dokumen_senarai_stok')) {
            $file = $request->file('dokumen_senarai_stok');
            \Log::info('Senarai stok file details - Name: ' . $file->getClientOriginalName() . ', Size: ' . $file->getSize() . ', Valid: ' . ($file->isValid() ? 'yes' : 'no') . ', MimeType: ' . $file->getMimeType() . ', Extension: ' . $file->getClientOriginalExtension());
        }
        
        if ($request->hasFile('dokumen_kelulusan_kpp')) {
            $file = $request->file('dokumen_kelulusan_kpp');
            \Log::info('Kelulusan KPP file details - Name: ' . $file->getClientOriginalName() . ', Size: ' . $file->getSize() . ', Valid: ' . ($file->isValid() ? 'yes' : 'no') . ', MimeType: ' . $file->getMimeType() . ', Extension: ' . $file->getClientOriginalExtension());
        }
        
        $validationRules = [
            'tahun' => 'required|integer',
            'fish_type_id' => 'required|integer',
            'pengesahan_status' => 'nullable|string|in:approved,rejected,false',
        ];
        
        // Only validate files if they are actually uploaded
        if ($hasSenaraiStok) {
            // Temporarily remove strict file validation for debugging
            // $validationRules['dokumen_senarai_stok'] = 'file|mimes:pdf,jpg,jpeg,png|max:2048';
            $validationRules['dokumen_senarai_stok'] = 'file|max:10240'; // Allow larger files and all types for testing
        }
        
        if ($hasKelulusanKpp) {
            // Temporarily remove strict file validation for debugging
            // $validationRules['dokumen_kelulusan_kpp'] = 'file|mimes:pdf,jpg,jpeg,png|max:2048';
            $validationRules['dokumen_kelulusan_kpp'] = 'file|max:10240'; // Allow larger files and all types for testing
        }
        
        $request->validate($validationRules);

        try {
            \DB::beginTransaction();

            // Find all existing records for the given year
            $existingRecords = StatusStock::where('tahun', $request->tahun)->get();
            
            if ($existingRecords->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiada rekod dijumpai untuk tahun ' . $request->tahun . '. Sila tambah item stok terlebih dahulu.'
                ], 400);
            }

            $updatedCount = 0;

            // Prepare common data for all records
            $commonData = [
                'status' => 'submitted',
            ];

            // Handle approval status (same for all records)
            if ($request->filled('pengesahan_status') && $request->pengesahan_status !== 'false') {
                $commonData['pengesahan_status'] = $request->pengesahan_status;
            } else {
                $commonData['pengesahan_status'] = null;
            }

            // Handle file uploads
            $dokumenSenaraiStokPath = null;
            $dokumenKelulusanKppPath = null;

            if ($hasSenaraiStok) {
                $file = $request->file('dokumen_senarai_stok');
                $fileName = time() . '_senarai_stok_' . $file->getClientOriginalName();
                $dokumenSenaraiStokPath = $file->storeAs('dokumen_stok', $fileName, 'public');
                \Log::info('Uploaded senarai stok file: ' . $dokumenSenaraiStokPath);
            }

            if ($hasKelulusanKpp) {
                $file = $request->file('dokumen_kelulusan_kpp');
                $fileName = time() . '_kelulusan_kpp_' . $file->getClientOriginalName();
                $dokumenKelulusanKppPath = $file->storeAs('kelulusan_kpp', $fileName, 'public');
                \Log::info('Uploaded kelulusan kpp file: ' . $dokumenKelulusanKppPath);
            }

            // Update all existing records for the given year
            foreach ($existingRecords as $record) {
                $updateData = $commonData;
                
                // Add file paths if files were uploaded
                if ($dokumenSenaraiStokPath) {
                    $updateData['dokumen_senarai_stok'] = $dokumenSenaraiStokPath;
                }
                
                if ($dokumenKelulusanKppPath) {
                    $updateData['dokumen_kelulusan_kpp'] = $dokumenKelulusanKppPath;
                }

                $record->update($updateData);
                $updatedCount++;
                \Log::info("Updated existing record ID: {$record->id} for fish type: {$record->fishType->name} (FMA: {$record->fma})");
            }

            \DB::commit();

            $message = "Data berjaya dikemaskini! {$updatedCount} rekod telah dikemaskini untuk tahun {$request->tahun}.";

            \Log::info("Final submission completed for year {$request->tahun} by user " . auth()->id());
            \Log::info("Updated {$updatedCount} existing records");

            return response()->json([
                'success' => true,
                'message' => $message,
                'updated_count' => $updatedCount,
                'pengesahan_status' => $request->pengesahan_status
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Error storing draft: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ralat semasa menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update approval status for a document
     */
    public function updateApprovalStatus(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'fish_type_id' => 'required|exists:fish_types,id',
            'pengesahan_status' => 'required|string|in:approved,rejected,false',
        ]);

        try {
            $statusStock = StatusStock::where('fish_type_id', $request->fish_type_id)
                ->where('tahun', $request->tahun)
                ->first();

            if (!$statusStock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Record tidak dijumpai'
                ], 404);
            }

            $approvalStatus = $request->pengesahan_status === 'false' ? null : $request->pengesahan_status;
            $statusStock->update(['pengesahan_status' => $approvalStatus]);

            \Log::info('Approval status updated: ' . ($approvalStatus ?? 'null'));

            return response()->json([
                'success' => true,
                'message' => 'Status pengesahan berjaya dikemaskini!',
                'pengesahan_status' => $approvalStatus
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating approval status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ralat semasa mengemaskini status pengesahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update approval status for all records in a specific year
     */
    public function updateAllRecordsForYear(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'pengesahan_status' => 'required|string|in:approved,rejected',
        ]);

        try {
            // Update all records for the specified year
            $updatedCount = StatusStock::where('tahun', $request->tahun)
                ->update(['pengesahan_status' => $request->pengesahan_status]);

            \Log::info("Updated {$updatedCount} records for year {$request->tahun} with status: {$request->pengesahan_status}");

            return response()->json([
                'success' => true,
                'message' => "Berjaya mengemaskini {$updatedCount} rekod untuk tahun {$request->tahun}",
                'updated_count' => $updatedCount,
                'tahun' => $request->tahun,
                'pengesahan_status' => $request->pengesahan_status
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating all records for year: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ralat semasa mengemaskini rekod: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update semakan status for all records of a given year
     */
    public function updateSemakanStatus(Request $request)
    {
        \Log::info('updateSemakanStatus method called');
        \Log::info('Request data: ' . json_encode($request->all()));
        
        try {
            $request->validate([
                'tahun' => 'required|string',
                'semakan_status' => 'required|string|in:disemak'
            ]);
            
            // Update all records for the given year
            $updated = StatusStock::where('tahun', $request->tahun)->update([
                'semakan_status' => $request->semakan_status
            ]);
            
            \Log::info("Updated {$updated} records with semakan_status: {$request->semakan_status} for year: {$request->tahun}");
            
            return response()->json([
                'success' => true,
                'message' => "Status semakan berjaya dikemaskini! {$updated} rekod telah dikemaskini untuk tahun {$request->tahun}.",
                'updated_count' => $updated
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error updating semakan status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ralat semasa mengemaskini status semakan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get draft data for editing
     */
    public function getDraft(Request $request)
    {
        $request->validate([
            'fish_type_id' => 'required|exists:fish_types,id',
            'tahun' => 'required|integer',
        ]);

        $draft = StatusStock::where('fish_type_id', $request->fish_type_id)
            ->where('tahun', $request->tahun)
            ->where('status', 'draft')
            ->first();

        if ($draft) {
            return response()->json([
                'success' => true,
                'data' => $draft,
                'pengesahan_status' => $draft->pengesahan_status
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Draft tidak dijumpai'
        ], 404);
    }

    /**
     * Submit draft for approval
     */
    public function submitDraft(Request $request)
    {
        $request->validate([
            'fish_type_id' => 'required|exists:fish_types,id',
            'tahun' => 'required|integer',
        ]);

        try {
            $draft = StatusStock::where('fish_type_id', $request->fish_type_id)
                ->where('tahun', $request->tahun)
                ->where('status', 'draft')
                ->first();

            if (!$draft) {
                return response()->json([
                    'success' => false,
                    'message' => 'Draft tidak dijumpai'
                ], 404);
            }

            $draft->update(['status' => 'submitted']);

            return response()->json([
                'success' => true,
                'message' => 'Permohonan berjaya dihantar untuk semakan!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Error submitting draft: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ralat semasa menghantar permohonan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get current approval status for a specific year
     */
    public function getCurrentApprovalStatus(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
        ]);

        try {
            // Get the first record for the year to check the approval status
            $record = StatusStock::where('tahun', $request->tahun)
                ->whereNotNull('pengesahan_status')
                ->first();

            $pengesahanStatus = $record ? $record->pengesahan_status : null;

            \Log::info("Current approval status for year {$request->tahun}: " . ($pengesahanStatus ?? 'null'));

            return response()->json([
                'success' => true,
                'pengesahan_status' => $pengesahanStatus,
                'tahun' => $request->tahun
            ]);

        } catch (\Exception $e) {
            \Log::error('Error getting current approval status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ralat semasa mendapatkan status pengesahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Final submission from tindakan page - updates both dokumen permohonan and tindakan status
     */
    public function finalSubmission(Request $request)
    {
        \Log::info('Final submission request received:', $request->all());
        
        $request->validate([
            'tahun' => 'required|integer',
            'semakan_status' => 'required|string|in:disemak',
            'pengesahan_status' => 'nullable|string|in:approved,rejected',
        ]);

        try {
            \DB::beginTransaction();

            // Check if there are any records for the given year
            $existingRecords = StatusStock::where('tahun', $request->tahun)->count();
            \Log::info("Found {$existingRecords} existing records for year {$request->tahun}");

            // Update all status_stocks records for the given year
            $updatedCount = StatusStock::where('tahun', $request->tahun)
                ->update([
                    'status' => 'submitted',
                    'semakan_status' => $request->semakan_status,
                    'pengesahan_status' => $request->pengesahan_status,
                ]);

            // Log the submission
            \Log::info("Final submission completed for year {$request->tahun} by user " . auth()->id());
            \Log::info("Updated {$updatedCount} records with status: {$request->semakan_status}, pengesahan: {$request->pengesahan_status}");

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Permohonan berjaya dihantar! {$updatedCount} rekod telah dikemaskini.",
                'updated_count' => $updatedCount,
                'tahun' => $request->tahun,
                'semakan_status' => $request->semakan_status,
                'pengesahan_status' => $request->pengesahan_status,
                'existing_records' => $existingRecords
            ]);

        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error('Error in final submission: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'Ralat semasa menghantar permohonan: ' . $e->getMessage()
            ], 500);
        }
    }
} 