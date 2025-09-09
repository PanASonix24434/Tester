<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FishType;
use App\Models\StatusStock;

class StatusStockController extends Controller
{
    /**
     * Display the stock status page.
     */
    public function index()
    {
        $user = auth()->user();
        $peranan = strtoupper($user->peranan ?? '');
        \Log::info('User peranan (index): ' . $peranan);
        if (strpos($peranan, 'PEGAWAI PERIKANAN NEGERI') !== false) {
            \Log::info('Access granted to status-stock.kemaskini');
            // continue to show the page
        } elseif (strpos($peranan, 'KETUA CAWANGAN') !== false) {
            \Log::info('Redirecting to semakan-stok.index from index');
            return redirect()->route('semakan-stok.index');
        } elseif (strpos($peranan, 'PENGARAH KANAN') !== false) {
            \Log::info('Redirecting to keputusan-status.index from index');
            return redirect()->route('keputusan-status.index');
        } else {
            abort(403, 'Unauthorized');
        }
        $fishTypes = FishType::orderBy('name')->get();
        $selectedYear = request('tahun');
        $statusStocks = $selectedYear
            ? StatusStock::with('fishType')->where('tahun', $selectedYear)->whereNotNull('fish_type_id')->get()
            : StatusStock::with('fishType')->whereNotNull('fish_type_id')->get();
            
        // Group status stocks by fish type and filter out any invalid records
        $groupedStatusStocks = $statusStocks->groupBy('fish_type_id')->filter(function ($stocks, $fishTypeId) {
            // Only include groups that have valid fish type relationships
            return $stocks->first() && $stocks->first()->fishType;
        });
        
        // Sort groups by fish type name for consistent ordering
        $groupedStatusStocks = $groupedStatusStocks->sortBy(function ($stocks, $fishTypeId) {
            return $stocks->first()->fishType->name;
        });
        
        // Remove duplicate FMA entries (keep the latest one if duplicates exist)
        foreach ($groupedStatusStocks as $fishTypeId => $stocks) {
            $uniqueStocks = $stocks->unique('fma');
            $groupedStatusStocks[$fishTypeId] = $uniqueStocks;
            
            // Log the grouping for debugging
            $fishTypeName = $stocks->first()->fishType->name ?? 'Unknown';
            \Log::info("Fish Type: {$fishTypeName} (ID: {$fishTypeId}) - Original: {$stocks->count()} records, After deduplication: {$uniqueStocks->count()} records");
        }
        
        return view('app.status_stock.index', compact('fishTypes', 'statusStocks', 'groupedStatusStocks', 'selectedYear'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'dokumen_kpp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('dokumen_kpp')) {
            $file = $request->file('dokumen_kpp');
            $path = $file->store('kelulusan_kpp', 'public');
            return response()->json(['success' => true, 'path' => $path]);
        }

        return response()->json(['success' => false]);
    }

    public function store(Request $request)
    {
        \Log::info('store method called');
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request data: ' . json_encode($request->all()));
        
        // More explicit file detection for dokumen_kpp
        $hasDokumenKpp = $request->hasFile('dokumen_kpp');
        $dokumenKppIsValid = false;
        $dokumenKppSize = 0;
        
        if ($hasDokumenKpp) {
            $file = $request->file('dokumen_kpp');
            $dokumenKppIsValid = $file->isValid();
            $dokumenKppSize = $file->getSize();
            $dokumenKppMimeType = $file->getMimeType();
            $dokumenKppExtension = $file->getClientOriginalExtension();
            $dokumenKppName = $file->getClientOriginalName();
            \Log::info('Dokumen KPP details - Name: ' . $dokumenKppName . ', Size: ' . $dokumenKppSize . ', Valid: ' . ($dokumenKppIsValid ? 'yes' : 'no') . ', MimeType: ' . $dokumenKppMimeType . ', Extension: ' . $dokumenKppExtension);
        }
        
        // Only consider it a valid file if it exists, is valid, and has size > 0
        $hasValidDokumenKpp = $hasDokumenKpp && $dokumenKppIsValid && $dokumenKppSize > 0;
        
        \Log::info('Has valid dokumen KPP file: ' . ($hasValidDokumenKpp ? 'yes' : 'no'));
        
        $validationRules = [
            'tahun' => 'required|string|max:10',
        ];
        
        // Only validate file if it's actually a valid uploaded file
        if ($hasValidDokumenKpp) {
            // Temporarily remove strict file validation for debugging
            // $validationRules['dokumen_kpp'] = 'file|mimes:jpg,jpeg,png,pdf|max:2048';
            $validationRules['dokumen_kpp'] = 'file|max:10240'; // Allow larger files and all types for testing
            \Log::info('Added dokumen_kpp validation rule (relaxed for testing)');
        } else {
            \Log::info('No dokumen_kpp validation rule added');
        }
        
        \Log::info('Validation rules: ' . json_encode($validationRules));
        
        try {
            $request->validate($validationRules);
            
            $dokumenKppPath = null;
            if ($hasValidDokumenKpp) {
                $file = $request->file('dokumen_kpp');
                $fileName = time() . '_kelulusan_kpp_' . $file->getClientOriginalName();
                $dokumenKppPath = $file->storeAs('kelulusan_kpp', $fileName, 'public');
                \Log::info('Uploaded dokumen KPP file: ' . $dokumenKppPath);
            } else {
                \Log::warning('No valid dokumen KPP file found in request');
            }

            // Update all items for the given year to set dokumen_kelulusan_kpp and status to submitted
            $updateData = [
                'status' => 'submitted'
            ];
            if ($dokumenKppPath) {
                $updateData['dokumen_kelulusan_kpp'] = $dokumenKppPath;
            }
            
            $updated = StatusStock::where('tahun', $request->tahun)->update($updateData);
            \Log::info('Updated ' . $updated . ' records with status=submitted and dokumen_kelulusan_kpp for year ' . $request->tahun);

            // Return JSON response for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status stok berjaya dihantar! ' . $updated . ' rekod telah dikemaskini dengan status "Dihantar".'
                ]);
            }

            return back()->with('success', 'Status stok berjaya dihantar! ' . $updated . ' rekod telah dikemaskini dengan status "Dihantar".');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ' . json_encode($e->errors()));
            
            // Return JSON response for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            \Log::error('Error in store method: ' . $e->getMessage());
            
            // Return JSON response for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ralat semasa menyimpan data: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Ralat semasa menyimpan data: ' . $e->getMessage());
        }
    }

    public function saveDraft(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string|max:10',
            'dokumen_kpp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kumpulanIkan' => 'required|exists:fish_types,id',
            'fma' => 'required|in:FMA01,FMA02,FMA03,FMA04,FMA05,FMA06,FMA07',
            'bilanganStok' => 'required|integer|min:0',
            'dokumenSenaraiStok' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $dokumenKppPath = null;
        if ($request->hasFile('dokumen_kpp')) {
            $dokumenKppPath = $request->file('dokumen_kpp')->store('kelulusan_kpp', 'public');
        }

        $dokumenPath = null;
        if ($request->hasFile('dokumenSenaraiStok')) {
            $dokumenPath = $request->file('dokumenSenaraiStok')->store('stok_dokumen', 'public');
        }

        StatusStock::create([
            'tahun' => $request->tahun,
            'dokumen_kelulusan_kpp' => $dokumenKppPath,
            'fish_type_id' => $request->kumpulanIkan,
            'fma' => $request->fma,
            'bilangan_stok' => $request->bilanganStok,
            'dokumen_senarai_stok' => $dokumenPath,
            'status' => 'draft',
        ]);

        return back()->with('success', 'Status stok berjaya disimpan sebagai draf!');
    }

    public function addItem(Request $request)
    {
        \Log::info('addItem method called');
        \Log::info('Request method: ' . $request->method());
        \Log::info('Request URL: ' . $request->url());
        \Log::info('Request headers: ' . json_encode($request->headers->all()));
        \Log::info('Request data: ' . json_encode($request->all()));
        \Log::info('CSRF token: ' . $request->header('X-CSRF-TOKEN'));
        
        // Check if this is a GET request (which shouldn't happen)
        if ($request->isMethod('GET')) {
            \Log::error('GET request received instead of POST for addItem method');
            abort(405, 'Method Not Allowed. This endpoint only accepts POST requests.');
        }
        
        // More explicit file detection
        $hasFile = $request->hasFile('dokumenSenaraiStok');
        $fileIsValid = false;
        $fileSize = 0;
        $fileMimeType = '';
        $fileExtension = '';
        
        if ($hasFile) {
            $file = $request->file('dokumenSenaraiStok');
            $fileIsValid = $file->isValid();
            $fileSize = $file->getSize();
            $fileMimeType = $file->getMimeType();
            $fileExtension = $file->getClientOriginalExtension();
            \Log::info('File details - Name: ' . $file->getClientOriginalName() . ', Size: ' . $fileSize . ', Valid: ' . ($fileIsValid ? 'yes' : 'no') . ', MimeType: ' . $fileMimeType . ', Extension: ' . $fileExtension);
        }
        
        // Only consider it a valid file if it exists, is valid, and has size > 0
        $hasDokumenSenaraiStok = $hasFile && $fileIsValid && $fileSize > 0;
        
        \Log::info('Has dokumen senarai stok file: ' . ($hasDokumenSenaraiStok ? 'yes' : 'no'));
        \Log::info('Request hasFile dokumenSenaraiStok: ' . ($hasFile ? 'yes' : 'no'));
        \Log::info('File is valid: ' . ($fileIsValid ? 'yes' : 'no'));
        \Log::info('File size: ' . $fileSize);
        \Log::info('File mime type: ' . $fileMimeType);
        \Log::info('File extension: ' . $fileExtension);
        
        $validationRules = [
            'kumpulanIkan' => 'required|exists:fish_types,id',
            'fma' => 'required|in:FMA01,FMA02,FMA03,FMA04,FMA05,FMA06,FMA07',
            'selection_type' => 'required|in:vesel,zon',
            'jenis_sumber' => 'required|in:Pelagik,Demersal',
            'bilanganStok' => 'required|integer|min:0',
        ];
        
        // Add conditional validation based on selection_type
        if ($request->selection_type === 'vesel') {
            $validationRules['vesel_type'] = 'required|in:Sampan,Jerut Bilis,PTMT,Kenka 2 bot,Siput retak seribu';
        } elseif ($request->selection_type === 'zon') {
            $validationRules['zon_type'] = 'required|in:A,B,C,C2';
        }
        
        // Only validate file if it's actually a valid uploaded file
        if ($hasDokumenSenaraiStok) {
            // Temporarily remove file validation to test
            // $validationRules['dokumenSenaraiStok'] = 'file|max:10240';
            \Log::info('Skipping file validation for testing');
        } else {
            \Log::info('No file validation rule added for dokumenSenaraiStok');
        }
        
        \Log::info('Validation rules: ' . json_encode($validationRules));
        
        try {
            $request->validate($validationRules);
            
            // Check for duplicate fish type and FMA combination
            $existingRecord = StatusStock::where('fish_type_id', $request->kumpulanIkan)
                ->where('fma', $request->fma)
                ->where('tahun', $request->tahun)
                ->first();
                
            if ($existingRecord) {
                $fishTypeName = \App\Models\FishType::find($request->kumpulanIkan)->name ?? 'Unknown';
                $errorMessage = "Rekod untuk {$fishTypeName} dengan FMA {$request->fma} sudah wujud untuk tahun {$request->tahun}. Sila pilih kombinasi yang berbeza.";
                
                \Log::warning('Duplicate record attempt: ' . $errorMessage);
                
                // Return JSON response for AJAX requests
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMessage,
                        'isDuplicate' => true
                    ], 422);
                }
                
                return back()->withErrors(['duplicate' => $errorMessage])->withInput();
            }
            
            $dokumenPath = null;
            if ($hasDokumenSenaraiStok) {
                $file = $request->file('dokumenSenaraiStok');
                $fileName = time() . '_senarai_stok_' . $file->getClientOriginalName();
                $dokumenPath = $file->storeAs('stok_dokumen', $fileName, 'public');
                \Log::info('Uploaded dokumen senarai stok file: ' . $dokumenPath);
            }

            $dataToInsert = [
                'tahun' => $request->tahun,
                'dokumen_kelulusan_kpp' => $request->dokumen_kelulusan_kpp,
                'fish_type_id' => $request->kumpulanIkan,
                'fma' => $request->fma,
                'selection_type' => $request->selection_type,
                'vesel_type' => $request->selection_type === 'vesel' ? $request->vesel_type : null,
                'zon_type' => $request->selection_type === 'zon' ? $request->zon_type : null,
                'jenis_sumber' => $request->jenis_sumber,
                'bilangan_stok' => $request->bilanganStok,
                'dokumen_senarai_stok' => $dokumenPath,
                'status' => 'draft',
            ];
            
            \Log::info('Data to insert: ' . json_encode($dataToInsert));

            $newRecord = StatusStock::create($dataToInsert);
            \Log::info('Successfully created StatusStock record with ID: ' . $newRecord->id);

            // Return JSON response for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item stok berjaya ditambah!'
                ]);
            }

            return back()->with('success', 'Item stok berjaya ditambah!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ' . json_encode($e->errors()));
            
            // Return JSON response for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $e->errors()
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            \Log::error('Error adding item: ' . $e->getMessage());
            
            // Return JSON response for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ralat semasa menambah item: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Ralat semasa menambah item: ' . $e->getMessage());
        }
    }

    public function ajaxStatus(Request $request)
    {
        $tahun = $request->get('tahun');
        $statusStocks = StatusStock::with('fishType')->where('tahun', $tahun)->get();
        return view('app.status_stock.partials.table_rows', compact('statusStocks'))->render();
    }

    public function entrypoint()
    {
        $user = auth()->user();
        $peranan = strtoupper($user->peranan ?? '');
        \Log::info('User peranan: ' . $peranan);
        if (strpos($peranan, 'PEGAWAI PERIKANAN NEGERI') !== false) {
            \Log::info('Redirecting to status-stock.kemaskini');
            return redirect()->route('status-stock.kemaskini');
        } elseif (strpos($peranan, 'KETUA CAWANGAN') !== false) {
            \Log::info('Redirecting to semakan-stok.index');
            return redirect()->route('semakan-stok.index');
        } else {
            \Log::info('Redirecting to keputusan-status.index');
            return redirect()->route('keputusan-status.index');
        }
    }

    public function finalDecision(Request $request)
    {
        \Log::info('finalDecision method called');
        \Log::info('Request data: ' . json_encode($request->all()));

        try {
            $request->validate([
                'tahun' => 'required|string',
                'semakan_status' => 'required|string|in:disemak',
                'pengesahan_status' => 'required|string|in:approved,rejected'
            ]);

            $tahun = $request->tahun;
            $semakanStatus = $request->semakan_status;
            $pengesahanStatus = $request->pengesahan_status;
            $user = auth()->user();

            // Update all status_stocks records for the given year
            $updatedCount = StatusStock::where('tahun', $tahun)->update([
                'semakan_status' => $semakanStatus,
                'pengesahan_status' => $pengesahanStatus,
                'final_decision' => 'approved',
                'final_decision_by' => $user->id,
                'final_decision_at' => now(),
                'updated_at' => now()
            ]);

            \Log::info("Updated {$updatedCount} records for year {$tahun} with semakan_status: {$semakanStatus}, pengesahan_status: {$pengesahanStatus}, final_decision_by: {$user->id}");

            return response()->json([
                'success' => true,
                'message' => "Perakuan keputusan berjaya dihantar! {$updatedCount} rekod telah dikemaskini untuk tahun {$tahun}.",
                'updated_count' => $updatedCount,
                'decision_made_by' => $user->name ?? $user->id,
                'decision_made_at' => now()->format('Y-m-d H:i:s')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in finalDecision: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error in finalDecision: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ralat semasa menghantar perakuan keputusan: ' . $e->getMessage()
            ], 500);
        }
    }
} 