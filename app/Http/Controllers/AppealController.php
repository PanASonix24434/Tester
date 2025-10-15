<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appeal;
use App\Models\Perakuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Events\AppealUpdated;
use PDF;
use Illuminate\Support\Facades\File;

class AppealController extends Controller
{
    // Applicant: Show form
    public function create() {
        return view('appeals.create');
    }
    // Applicant: Store application
    public function store(Request $request) {
        $appeal = Appeal::create([
            
            'applicant_id' => auth()->id(),
            'status' => 'submitted',
            'pemohon_status' => 'Permohonan Dihantar',
            'pegawai_status' => 'Permohonan Diterima',
        ]);
        event(new AppealUpdated($appeal));
        return redirect()->route('appeals.status', $appeal->id);
    }
    // Applicant: Show status
    public function status($id)
    {
        // Fetch the appeal by ID
        $appeal = Appeal::where('id', $id)->firstOrFail();
        // Fetch the applicant user
        $applicant = \App\Models\User::find($appeal->applicant_id);
        // Fetch the perakuan data to get the surat kelulusan KPP file
        $perakuan = \App\Models\Perakuan::where('appeal_id', $id)->first();
        
        // Get reviewer names - prioritize the final approver
        $reviewerName = '';
        
        // Check for KPP reviewer first (final approver)
        if ($appeal->kpp_reviewer_id) {
            $kppReviewer = \App\Models\User::find($appeal->kpp_reviewer_id);
            $reviewerName = $kppReviewer ? $kppReviewer->name : 'Unknown';
        }
        // Check for PK reviewer
        elseif ($appeal->pk_reviewer_id) {
            $pkReviewer = \App\Models\User::find($appeal->pk_reviewer_id);
            $reviewerName = $pkReviewer ? $pkReviewer->name : 'Unknown';
        }
        // Check for KCL reviewer
        elseif ($appeal->kcl_reviewer_id) {
            $kclReviewer = \App\Models\User::find($appeal->kcl_reviewer_id);
            $reviewerName = $kclReviewer ? $kclReviewer->name : 'Unknown';
        }
        // Check for PPL reviewer
        elseif ($appeal->ppl_reviewer_id) {
            $pplReviewer = \App\Models\User::find($appeal->ppl_reviewer_id);
            $reviewerName = $pplReviewer ? $pplReviewer->name : 'Unknown';
        }
        
        // If no reviewer found, use current user as fallback
        if (empty($reviewerName)) {
            $reviewerName = auth()->user()->name ?? 'Unknown';
        }
        // Return the status view with the appeal, applicant, perakuan, and reviewer data
        return view('appeals.status', compact('appeal', 'applicant', 'perakuan', 'reviewerName'));
    }
    // Applicant: Edit application after incomplete or rejected
    public function edit($id)
    {
        $appeal = \App\Models\Appeal::findOrFail($id);
        $perakuan = \App\Models\Perakuan::where('appeal_id', $appeal->id)->latest()->first();
        $user = auth()->user();
        if ($appeal->applicant_id !== $user->id) {
            abort(403, 'Anda tidak dibenarkan mengedit permohonan ini.');
        }
        return view('appeals.edit', compact('appeal', 'perakuan'));
    }

    // Applicant: Update/resubmit application
    public function update(Request $request, $id)
    {
        try {
        $appeal = \App\Models\Appeal::findOrFail($id);
        $perakuan = \App\Models\Perakuan::where('appeal_id', $appeal->id)->latest()->first();
        $user = auth()->user();
            
        if ($appeal->applicant_id !== $user->id) {
            abort(403, 'Anda tidak dibenarkan mengedit permohonan ini.');
        }
            
            // Validate and update fields as needed
        $request->validate([
            'justifikasi_pindaan' => 'required|string',
            ]);
            
            // Custom validation for dokumen sokongan files
            $dokumenSokonganTypes = [
                'dokumen_sokongan_bina_baru',
                'dokumen_sokongan_bina_baru_luar_negara', 
                'dokumen_sokongan_terpakai',
                'dokumen_sokongan_pangkalan',
                'dokumen_sokongan_bahan_binaan',
                'dokumen_sokongan_tukar_peralatan',
            ];
            
            foreach ($dokumenSokonganTypes as $fieldName) {
                // Check both array and non-array versions
                if ($request->hasFile($fieldName)) {
                    $file = $request->file($fieldName);
                    
                    // Handle both single file and array of files
                    if (is_array($file)) {
                        foreach ($file as $singleFile) {
                            if ($singleFile && $singleFile->isValid()) {
                                $allowedMimes = ['application/pdf', 'image/png', 'image/jpg', 'image/jpeg'];
                                if (!in_array($singleFile->getMimeType(), $allowedMimes)) {
                                    return redirect()->back()->withErrors([
                                        $fieldName => 'File mesti dalam format PDF, PNG, JPG, atau JPEG.'
                                    ])->withInput();
                                }
                                if ($singleFile->getSize() > 10240 * 1024) { // 10MB
                                    return redirect()->back()->withErrors([
                                        $fieldName => 'Saiz file mesti kurang daripada 10MB.'
                                    ])->withInput();
                                }
                            }
                        }
                    } else {
                        if ($file && $file->isValid()) {
                            $allowedMimes = ['application/pdf', 'image/png', 'image/jpg', 'image/jpeg'];
                            if (!in_array($file->getMimeType(), $allowedMimes)) {
                                return redirect()->back()->withErrors([
                                    $fieldName => 'File mesti dalam format PDF, PNG, JPG, atau JPEG.'
                                ])->withInput();
                            }
                            if ($file->getSize() > 10240 * 1024) { // 10MB
                                return redirect()->back()->withErrors([
                                    $fieldName => 'Saiz file mesti kurang daripada 10MB.'
                                ])->withInput();
                            }
                        }
                    }
                }
                
                // Check array version
                $arrayFieldName = $fieldName . '[]';
                if ($request->hasFile($arrayFieldName)) {
                    $files = $request->file($arrayFieldName);
                    if (!is_array($files)) {
                        $files = [$files];
                    }
                    
                    foreach ($files as $file) {
                        if ($file && $file->isValid()) {
                            $allowedMimes = ['application/pdf', 'image/png', 'image/jpg', 'image/jpeg'];
                            if (!in_array($file->getMimeType(), $allowedMimes)) {
                                return redirect()->back()->withErrors([
                                    $arrayFieldName => 'File mesti dalam format PDF, PNG, JPG, atau JPEG.'
                                ])->withInput();
                            }
                            if ($file->getSize() > 10240 * 1024) { // 10MB
                                return redirect()->back()->withErrors([
                                    $arrayFieldName => 'Saiz file mesti kurang daripada 10MB.'
                                ])->withInput();
                            }
                        }
                    }
                }
            }
            
            // Update perakuan fields
        $perakuan->justifikasi_pindaan = $request->input('justifikasi_pindaan');
        $perakuan->status = 'submitted';
            $perakuan->updated_at = now(); // Update timestamp
        $perakuan->save();
            
            \Log::info('Perakuan updated successfully', [
                'perakuan_id' => $perakuan->id,
                'appeal_id' => $appeal->id,
                'user_id' => $user->id,
                'justifikasi_pindaan' => $request->input('justifikasi_pindaan')
            ]);
            
            // Handle dokumen sokongan uploads - ADD NEW FILES ONLY (don't replace existing)
            $dokumenSokonganTypes = [
                'dokumen_sokongan_bina_baru' => 'bina_baru',
                'dokumen_sokongan_bina_baru_luar_negara' => 'bina_baru_luar_negara',
                'dokumen_sokongan_terpakai' => 'terpakai',
                'dokumen_sokongan_pangkalan' => 'pangkalan',
                'dokumen_sokongan_bahan_binaan' => 'bahan_binaan',
                'dokumen_sokongan_tukar_peralatan' => 'tukar_peralatan',
            ];
            
            \Log::info('Processing dokumen sokongan uploads for edit', [
                'appeal_id' => $appeal->id,
                'user_id' => $user->id,
                'existing_docs_count' => \App\Models\DokumenSokongan::where('appeals_id', $appeal->id)->count(),
                'all_files' => $request->allFiles(),
                'all_input' => $request->all(),
                'request_method' => $request->method(),
                'content_type' => $request->header('Content-Type'),
                'has_files' => $request->hasFile('dokumen_sokongan_terpakai') || $request->hasFile('dokumen_sokongan_terpakai[]'),
                'form_data_keys' => array_keys($request->all()),
                'file_keys' => array_keys($request->allFiles()),
                'dokumen_sokongan_terpakai' => $request->file('dokumen_sokongan_terpakai'),
                'dokumen_sokongan_terpakai_array' => $request->file('dokumen_sokongan_terpakai[]'),
                'dokumen_sokongan_bahan_binaan' => $request->file('dokumen_sokongan_bahan_binaan'),
                'dokumen_sokongan_bahan_binaan_array' => $request->file('dokumen_sokongan_bahan_binaan[]')
            ]);

            foreach ($dokumenSokonganTypes as $inputName => $fileType) {
                // Check both array and non-array versions
                $arrayInputName = $inputName . '[]';
                $hasArrayFiles = $request->hasFile($arrayInputName);
                $hasSingleFiles = $request->hasFile($inputName);
                
                \Log::info('Checking for files', [
                    'input_name' => $inputName,
                    'array_input_name' => $arrayInputName,
                    'file_type' => $fileType,
                    'has_array_files' => $hasArrayFiles,
                    'has_single_files' => $hasSingleFiles
                ]);
                
                $files = null;
                if ($hasArrayFiles) {
                    $files = $request->file($arrayInputName);
                    \Log::info('Array files found', [
                        'input_name' => $arrayInputName,
                        'files_type' => gettype($files),
                        'files_count' => is_array($files) ? count($files) : 1,
                        'files_content' => $files
                    ]);
                } elseif ($hasSingleFiles) {
                    $files = $request->file($inputName);
                    \Log::info('Single files found', [
                        'input_name' => $inputName,
                        'files_type' => gettype($files),
                        'files_count' => is_array($files) ? count($files) : 1,
                        'files_content' => $files
                    ]);
                }
                
                if ($files) {
                    // Ensure we have an array of files
                    if (!is_array($files)) {
                        $files = [$files]; // Convert single file to array
                    }
                    
                    foreach ($files as $index => $file) {
                        \Log::info('Processing individual file', [
                            'file_index' => $index,
                            'file_valid' => ($file && method_exists($file, 'isValid')) ? $file->isValid() : 'null',
                            'file_name' => $file ? $file->getClientOriginalName() : 'null',
                            'file_size' => $file ? $file->getSize() : 'null'
                        ]);
                        
                        if ($file && $file->isValid()) {
                            try {
                                // Preserve original filename and extension
                                $originalName = $file->getClientOriginalName();
                                $path = $file->storeAs('dokumen_permohonan/' . $user->id, $originalName, 'public');
                                
                                \Log::info('File stored successfully', [
                                    'original_name' => $originalName,
                                    'stored_path' => $path,
                                    'file_type' => $fileType
                                ]);
                                
                                // Create individual dokumen_sokongan record - ADD NEW FILE (don't replace existing)
                                $dokumenSokongan = \App\Models\DokumenSokongan::create([
                                    'id' => (string) \Str::uuid(),
                                    'appeals_id' => $appeal->id,
                                    'ref_number' => $appeal->ref_number,
                                    'user_id' => $user->id,
                                    'file_path' => $path,
                                    'file_name' => $originalName,
                                    'file_type' => $fileType,
                                    'file_size' => $file->getSize(),
                                    'mime_type' => $file->getMimeType(),
                                    'upload_date' => now(),
                                ]);
                                
                                \Log::info('New dokumen sokongan added to database', [
                                    'dokumen_id' => $dokumenSokongan->id,
                                    'appeal_id' => $appeal->id,
                                    'file_name' => $originalName,
                                    'file_type' => $fileType,
                                    'file_path' => $path,
                                    'created_successfully' => true,
                                    'database_record' => $dokumenSokongan->toArray()
                                ]);
                                
                            } catch (\Exception $e) {
                                \Log::error("Error storing file {$inputName}: " . $e->getMessage(), [
                                    'file_name' => $file ? $file->getClientOriginalName() : 'unknown',
                                    'error_trace' => $e->getTraceAsString()
                                ]);
                                continue; // Skip this file and continue with others
                            }
                        } else {
                            \Log::warning('Invalid file skipped', [
                                'file_index' => $index,
                                'file_valid' => $file ? $file->isValid() : false,
                                'file_name' => $file ? $file->getClientOriginalName() : 'null'
                            ]);
                        }
                    }
                }
            }
            
            // Log final dokumen count after uploads - ADDITIVE BEHAVIOR
            $finalDocCount = \App\Models\DokumenSokongan::where('appeals_id', $appeal->id)->count();
            $initialDocCount = \App\Models\DokumenSokongan::where('appeals_id', $appeal->id)
                ->where('created_at', '<', now()->subMinutes(5))
                ->count();
            $newDocsAdded = $finalDocCount - $initialDocCount;
            
            \Log::info('Dokumen sokongan upload completed - ADDITIVE BEHAVIOR', [
                'appeal_id' => $appeal->id,
                'initial_docs_count' => $initialDocCount,
                'new_docs_added' => $newDocsAdded,
                'final_docs_count' => $finalDocCount,
                'behavior' => 'ADDITIVE - New files added without replacing existing ones'
            ]);
            
            // Update appeal status and reset workflow timestamps when edited
        $appeal->status = 'submitted';
            $appeal->updated_at = now(); // Update timestamp
        
        // Reset workflow timestamps and decisions when application is edited
        $appeal->ppl_submitted_at = null;
        $appeal->kcl_submitted_at = null;
        $appeal->pk_submitted_at = null;
        $appeal->ppl_reviewer_id = null;
        $appeal->kcl_reviewer_id = null;
        $appeal->pk_reviewer_id = null;
        // Reset all status and decision fields - workflow starts fresh after edit
        $appeal->ppl_status = null;
        $appeal->kcl_status = null;
        $appeal->kcl_support = null;
        $appeal->pk_semakan_status = null;
        $appeal->pk_decision = null;
        $appeal->ppl_comments = null;
        $appeal->kcl_comments = null;
        $appeal->pk_comments = null;
        
        $appeal->save();
            
            \Log::info('Appeal updated successfully', [
                'appeal_id' => $appeal->id,
                'user_id' => $user->id,
                'status' => 'submitted',
                'updated_at' => $appeal->updated_at
            ]);
            
        event(new \App\Events\AppealUpdated($appeal));
        
        // Handle new documents from edit form (ADDITIVE - don't replace existing)
        if ($request->hasFile('documents') && $request->has('document_names')) {
            $documentNames = $request->input('document_names', []);
            $documents = $request->file('documents', []);
            
            \Log::info('Processing new documents from edit form', [
                'appeal_id' => $appeal->id,
                'document_names_count' => count($documentNames),
                'documents_count' => count($documents),
                'document_names' => $documentNames
            ]);
            
            foreach ($documents as $index => $document) {
                if ($document && $document->isValid()) {
                    $documentName = $documentNames[$index] ?? 'Dokumen Sokongan ' . ($index + 1);
                    
                    // Generate unique filename
                    $originalName = $document->getClientOriginalName();
                    $extension = $document->getClientOriginalExtension();
                    $filename = time() . '_' . $index . '_' . $originalName;
                    
                    // Store file
                    $path = $document->storeAs('appeals/documents', $filename, 'public');
                    
                    // Save to database
                    \App\Models\DokumenSokongan::create([
                        'appeals_id' => $appeal->id,
                        'file_type' => 'dokumen_sokongan_tambahan',
                        'file_name' => $documentName,
                        'file_path' => $path,
                        'original_name' => $originalName,
                        'file_size' => $document->getSize(),
                        'mime_type' => $document->getMimeType(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    
                    \Log::info('New document saved', [
                        'appeal_id' => $appeal->id,
                        'document_name' => $documentName,
                        'file_path' => $path,
                        'original_name' => $originalName
                    ]);
                }
            }
        }
            
            // Count new files added (ADDITIVE BEHAVIOR)
            $newFilesCount = \App\Models\DokumenSokongan::where('appeals_id', $appeal->id)
                ->where('created_at', '>=', now()->subMinutes(2))
                ->count();
            
            $totalFilesCount = \App\Models\DokumenSokongan::where('appeals_id', $appeal->id)->count();
            
            $successMessage = 'Permohonan berjaya dikemaskini dan dihantar semula.';
            if ($newFilesCount > 0) {
                $successMessage .= ' ' . $newFilesCount . ' dokumen sokongan baru telah ditambah (dokumen sedia ada dikekalkan).';
                $successMessage .= ' (Jumlah keseluruhan: ' . $totalFilesCount . ' dokumen)';
            }
            
            return redirect()->route('dashboard')->with('success', $successMessage);
            
        } catch (\Exception $e) {
            \Log::error('Error updating appeal: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ralat mengemaskini permohonan: ' . $e->getMessage());
        }
    }
    // PPL: Review
    public function pplReview($id) {
        $appeal = \App\Models\Appeal::findOrFail($id);
        
        // Get applicant's submission details
        $perakuan = \App\Models\Perakuan::where('user_id', $appeal->applicant_id)
            ->where('status', 'submitted')
            ->latest()
            ->first();
            
        // Get applicant user details
        $applicant = \App\Models\User::find($appeal->applicant_id);
        
        // Fetch dokumen sokongan from the new table
        $dokumenSokongan = \App\Models\DokumenSokongan::where('appeals_id', $appeal->id)->get();
        
        $canEdit = true;
        
        // PPL can submit if not yet submitted by PPL
        // When application is edited, workflow timestamps are reset, so PPL can submit again
        $canSubmit = empty($appeal->ppl_submitted_at);
        
        return view('appeals.ppl_review', compact('appeal', 'perakuan', 'applicant', 'dokumenSokongan', 'canEdit', 'canSubmit'));
    }
    public function pplSubmit(Request $request, $id)
    {
        $status = $request->input('status');
        $rules = [
            'status' => 'required',
        ];
        $messages = [];
        if ($status === 'Tidak Lengkap') {
            $rules['comments'] = 'required|string|min:3';
            $messages['comments.required'] = 'Ulasan wajib diisi jika permohonan tidak lengkap.';
        }
        $validated = $request->validate($rules, $messages);

        $appeal = Appeal::findOrFail($id);
        
        // Only update comments if provided, otherwise keep existing
        $updateData = [
            'ppl_status' => $status,
            'status' => $status === 'Lengkap' ? 'kcl_review' : 'ppl_incomplete',
            'pemohon_status' => 'Diproses Ibupejabat',
            'pegawai_status' => 'Semakan Ulasan - Ibupejabat',
            'ppl_reviewer_id' => auth()->id(), // Set reviewer ID
            'ppl_submitted_at' => now() // Record submission timestamp
        ];
        
        // Only update comments if provided and not empty
        if ($request->filled('comments')) {
            $updateData['ppl_comments'] = $request->input('comments');
        }
        
        // Debug: Log what's happening
        \Log::info('PPL Submit Debug', [
            'status' => $status,
            'comments_provided' => $request->has('comments'),
            'comments_filled' => $request->filled('comments'),
            'comments_value' => $request->input('comments'),
            'existing_comments' => $appeal->ppl_comments,
            'will_update_comments' => $request->filled('comments')
        ]);
        
        $appeal->update($updateData);
        event(new AppealUpdated($appeal));
        // Update perakuan status using appeal_id for direct linkage
        $perakuan = \App\Models\Perakuan::where('appeal_id', $appeal->id)->latest()->first();
        if ($perakuan) {
            $perakuan->status = $appeal->status;
            $perakuan->save();
        }
        return redirect()->route('appeals.amendment');
    }
    
    // KCL: Review
    public function kclReview($id) {
        $appeal = Appeal::findOrFail($id);
        // Fetch perakuan by appeal_id for accurate linkage
        $perakuan = \App\Models\Perakuan::where('appeal_id', $appeal->id)->latest()->first();
        $applicant = \App\Models\User::find($appeal->applicant_id);
        
        // Fetch dokumen sokongan from the new table
        $dokumenSokongan = \App\Models\DokumenSokongan::where('appeals_id', $appeal->id)->get();
        
        $canEdit = true;
        $canSubmit = empty($appeal->kcl_submitted_at); // KCL can only submit if not yet submitted
        return view('appeals.kcl_review', compact('appeal', 'perakuan', 'applicant', 'dokumenSokongan', 'canEdit', 'canSubmit'));
    }
    public function kclSubmit(Request $request, $id)
    {
        $status = $request->input('status'); // Lengkap or Tidak Lengkap
        $support = $request->input('support'); // Sokong or Tidak Sokong
        
        // Validation rules
        $rules = [
            'status' => 'required',
            'support' => 'required',
        ];
        $messages = [];
        if ($support === 'Tidak Sokong' || $status === 'Tidak Lengkap') {
            $rules['comments'] = 'required|string|min:3';
            $messages['comments.required'] = 'Ulasan wajib diisi jika permohonan tidak lengkap atau tidak disokong.';
        }
        $validated = $request->validate($rules, $messages);
        
        $appeal = Appeal::findOrFail($id);
        
        // Determine overall status based on both semakan and sokongan
        $overallStatus = 'kcl_incomplete'; // Default
        if ($status === 'Lengkap' && $support === 'Sokong') {
            $overallStatus = 'pk_review'; // Move to PK review
        } elseif ($status === 'Tidak Lengkap') {
            $overallStatus = 'kcl_incomplete'; // Incomplete
        } elseif ($support === 'Tidak Sokong') {
            $overallStatus = 'kcl_rejected'; // Not supported
        }
        
        // Only update comments if provided, otherwise keep existing
        $updateData = [
            'kcl_status' => $status, // Store semakan status (Lengkap/Tidak Lengkap)
            'kcl_support' => $support, // Store sokongan status (Sokong/Tidak Sokong)
            'status' => $overallStatus,
            'pemohon_status' => 'Diproses Ibupejabat',
            'pegawai_status' => 'Semakan Sokongan - Ibupejabat',
            'kcl_reviewer_id' => auth()->id(), // Set reviewer ID
            'kcl_submitted_at' => now() // Record submission timestamp
        ];
        
        // Only update comments if provided and not empty
        if ($request->filled('comments')) {
            $updateData['kcl_comments'] = $request->input('comments');
        }
        
        // Debug: Log what's happening
        \Log::info('KCL Submit Debug', [
            'status' => $status,
            'support' => $support,
            'overall_status' => $overallStatus,
            'comments_provided' => $request->has('comments'),
            'comments_filled' => $request->filled('comments'),
            'comments_value' => $request->input('comments'),
            'existing_comments' => $appeal->kcl_comments,
            'will_update_comments' => $request->filled('comments')
        ]);
        
        $appeal->update($updateData);
        event(new AppealUpdated($appeal));
        // Update perakuan status as well using appeal_id
        $perakuan = \App\Models\Perakuan::where('appeal_id', $appeal->id)->latest()->first();
        if ($perakuan) {
            $perakuan->status = $appeal->status;
            $perakuan->save();
        }
        return redirect()->route('appeals.amendment');
    }
    // PK(SPT): Review
    public function pkReview($id) {
        $appeal = Appeal::findOrFail($id);
        // Fetch perakuan by appeal_id for accurate linkage
        $perakuan = \App\Models\Perakuan::where('appeal_id', $appeal->id)->latest()->first();
        $applicant = \App\Models\User::find($appeal->applicant_id);
        
        // Fetch dokumen sokongan from the new table
        $dokumenSokongan = \App\Models\DokumenSokongan::where('appeals_id', $appeal->id)->get();
        
        $canEdit = true; // For backward compatibility
        $canSubmit = empty($appeal->pk_submitted_at); // PK can only save/submit if not yet submitted
        return view('appeals.pk_review', compact('appeal', 'perakuan', 'applicant', 'dokumenSokongan', 'canEdit', 'canSubmit'));
    }
    
    public function redirectToRoleReview($id)
    {
        \Log::info("=== redirectToRoleReview called for appeal ID: $id ===");
        
        if (!auth()->check()) {
            \Log::info('User not logged in, redirecting to login.');
            return redirect()->route('login');
        }

        $user = auth()->user();
        $userRole = strtolower(trim($user->peranan ?? ''));
        $userId = $user->id ?? 'unknown';

        \Log::info("User ID: $userId, Role: '$userRole'");

        if (empty($userRole)) {
            \Log::warning('User has empty role. User ID: ' . $userId);
            abort(403, 'Role is not set. Please contact the administrator.');
        }

        \Log::info("User role: $userRole, redirecting to appropriate review page for appeal ID: $id");

        if (stripos($userRole, 'pegawai perikanan') !== false) {
            \Log::info("Redirecting to PPL review for appeal: $id");
            return redirect()->route('appeals.ppl_review', ['id' => $id]);
        } elseif (stripos($userRole, 'ketua cawangan') !== false) {
            \Log::info("Redirecting to KCL review for appeal: $id");
            return redirect()->route('appeals.kcl_review', ['id' => $id]);
        } elseif (stripos($userRole, 'pengarah kanan') !== false) {
            \Log::info("Redirecting to PK review for appeal: $id");
            return redirect()->route('appeals.pk_review', ['id' => $id]);
        } elseif (stripos($userRole, 'pelesen') !== false) {
            \Log::info("Redirecting to status page for appeal: $id");
            return redirect()->route('appeals.status', ['id' => $id]);
        }

        \Log::warning('No matching role found for user with ID: ' . $userId);
        abort(403, 'Unauthorized action.');
    }
    

    public function pkSubmit(Request $request, $id)
    {
        try {
        $appeal = Appeal::findOrFail($id);
            $perakuan = Perakuan::where('appeal_id', $id)->first();
            
            if (!$perakuan) {
                return redirect()->back()->with('error', 'Perakuan tidak ditemui.');
            }

            $action = $request->input('action', 'submit');
            $pkStatus = $request->input('decision');
            $semakanStatus = $request->input('semakan_status');
            
            // Check if PK has already submitted (only for submit action, not save)
            if ($action === 'submit' && !empty($appeal->pk_submitted_at)) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Permohonan ini telah dihantar sebelum ini. Anda hanya boleh menghantar sekali sahaja.'
                    ], 403);
                }
                return redirect()->back()->with('error', 'Permohonan ini telah dihantar sebelum ini. Anda hanya boleh menghantar sekali sahaja.');
            }
            
            // Server-side validation only for submit action
            if ($action === 'submit') {
                if ($pkStatus === 'Diluluskan') {
                    if (!$request->hasFile('surat_kelulusan_kpp')) {
                        return redirect()->back()->with('error', 'Surat Kelulusan KPP wajib dimuat naik jika permohonan diluluskan.');
                    }
                    if (empty($request->input('no_rujukan_surat'))) {
                        return redirect()->back()->with('error', 'No. Rujukan Surat Kelulusan KPP wajib diisi jika permohonan diluluskan.');
                    }
                } elseif ($pkStatus === 'Tidak Diluluskan') {
                    if (empty($request->input('comments'))) {
                        return redirect()->back()->with('error', 'Ulasan wajib diisi jika permohonan tidak diluluskan.');
                    }
                }
            }
            
            // Determine final status based on PK decision
            $finalStatus = '';
            if ($pkStatus === 'Diluluskan') {
                $finalStatus = 'approved';
            } elseif ($pkStatus === 'Tidak Diluluskan') {
                $finalStatus = 'rejected';
            } else {
                $finalStatus = 'pk_incomplete';
            }
            
            // Update appeal data
            $updateData = [
                'pk_status' => $pkStatus,
                'pk_semakan_status' => $semakanStatus,
                'pk_decision' => $pkStatus, // Save decision separately for auto-fill
                'kpp_ref_no' => $request->input('no_rujukan_surat'),
                'pk_reviewer_id' => auth()->id() // Set reviewer ID
            ];
            
            // Update dual statuses based on PK decision
            if ($pkStatus === 'Diluluskan') {
                $updateData['pemohon_status'] = 'Diluluskan';
                $updateData['pegawai_status'] = 'Diluluskan';
                
                // Set serial number same as reference number when approved (only if not already generated)
                if (empty($appeal->no_siri) && $action === 'submit') {
                    $updateData['no_siri'] = $appeal->ref_number;
                }
            } elseif ($pkStatus === 'Tidak Diluluskan') {
                $updateData['pemohon_status'] = 'Ditolak';
                $updateData['pegawai_status'] = 'Ditolak';
            } else {
                $updateData['pemohon_status'] = 'Diproses Ibupejabat';
                $updateData['pegawai_status'] = 'Semakan PK - Ibupejabat';
            }
            
            // Only update final status and timestamp if action is submit
            if ($action === 'submit') {
                $updateData['status'] = $finalStatus;
                $updateData['pk_submitted_at'] = now(); // Record submission timestamp
            }
            
            // Only update comments if provided and not empty
            if ($request->filled('comments')) {
                $updateData['pk_comments'] = $request->input('comments');
            }
            
            // Debug: Log what's happening
            \Log::info('PK Submit Debug', [
                'status' => $pkStatus,
                'comments_provided' => $request->has('comments'),
                'comments_filled' => $request->filled('comments'),
                'comments_value' => $request->input('comments'),
                'existing_comments' => $appeal->pk_comments,
                'will_update_comments' => $request->filled('comments')
            ]);
            
            $appeal->update($updateData);

            // Handle file upload for surat kelulusan KPP
            if ($request->hasFile('surat_kelulusan_kpp')) {
                $file = $request->file('surat_kelulusan_kpp');
                // Preserve original filename and extension
                $originalName = $file->getClientOriginalName();
                $path = $file->storeAs('surat_kelulusan_kpp/' . auth()->id(), $originalName, 'public');
                $appeal->update(['surat_kelulusan_kpp' => $path]);
            }

            // Update perakuan status only if action is submit
            if ($action === 'submit') {
                $perakuan->update(['status' => $finalStatus]);
            }

            event(new AppealUpdated($appeal));
            
            $successMessage = $action === 'save' ? 'Data berjaya disimpan!' : 'Keputusan PK berjaya dihantar!';
            
            // Return JSON response for AJAX (save action)
            if ($request->ajax() || $action === 'save') {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage
                ]);
            }
            
            // Regular redirect for submit action
            return redirect()->route('appeals.amendment')->with('success', $successMessage);
        } catch (\Exception $e) {
            \Log::error('Error in pkSubmit: ' . $e->getMessage());
            
            // Return JSON error for AJAX requests
            if ($request->ajax() || $request->input('action') === 'save') {
                return response()->json([
                    'success' => false,
                    'message' => 'Ralat menyimpan keputusan PK: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Ralat menyimpan keputusan PK: ' . $e->getMessage());
        }
    }

    public function approvePermit(Request $request, $id)
    {
        try {
            $kvp08Application = \App\Models\Kpv08Application::findOrFail($id);
            
            // Check if user has permission to approve (PK role)
            $userRole = strtolower(trim(auth()->user()->peranan ?? ''));
            if (stripos($userRole, 'pengarah kanan') === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak mempunyai kebenaran untuk meluluskan permit. Hanya Pengarah Kanan boleh meluluskan permit.'
                ], 403);
            }

            $kvp08Application->approveByPK($request->input('remarks'));
            
            return response()->json([
                'success' => true,
                'message' => 'Permit berjaya diluluskan!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error approving permit: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ralat meluluskan permit: ' . $e->getMessage()
            ], 500);
        }
    }

    public function rejectPermit(Request $request, $id)
    {
        try {
            $kvp08Application = \App\Models\Kpv08Application::findOrFail($id);
            
            // Check if user has permission to reject (PK role)
            $userRole = strtolower(trim(auth()->user()->peranan ?? ''));
            if (stripos($userRole, 'pengarah kanan') === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak mempunyai kebenaran untuk menolak permit. Hanya Pengarah Kanan boleh menolak permit.'
                ], 403);
            }

            $kvp08Application->rejectByPK($request->input('remarks'));
            
            return response()->json([
                'success' => true,
                'message' => 'Permit berjaya ditolak!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error rejecting permit: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ralat menolak permit: ' . $e->getMessage()
            ], 500);
        }
    }
    // KPP: Decision
    public function kppDecision(Request $request, $id)
    {
        $appeal = Appeal::findOrFail($id);
        $canEdit = true;
        $appeal->kpp_decision = $request->input('decision');
        $appeal->kpp_comments = $request->input('comments');
        $appeal->kpp_ref_no = $request->input('ref_no');
        $appeal->status = $request->input('decision') === 'Lulus' ? 'approved' : 'rejected';
        $appeal->kpp_reviewer_id = auth()->id(); // Set reviewer ID
        $appeal->save();
        event(new AppealUpdated($appeal));
        return redirect()->route('appeals.amendment');
    }
    // Print letter (stub)
    public function printLetter($id) {
        $appeal = Appeal::with('perakuan')->findOrFail($id);
        
        // Get the current user (the one who is approving)
        $approver = auth()->user();
        
        // Get applicant details
        $applicant = \App\Models\User::find($appeal->applicant_id);
        
        // Get PK reviewer details (the one who made the decision)
        $pkReviewer = null;
        if ($appeal->pk_reviewer_id) {
            $pkReviewer = \App\Models\User::find($appeal->pk_reviewer_id);
        }
        
        // Get the perakuan data
        $perakuan = $appeal->perakuan;
        
        return view('appeals.print_letter', compact('appeal', 'approver', 'applicant', 'perakuan', 'pkReviewer'));
    }

    // Download letter as PDF
    public function downloadLetterPDF($id) {
        $appeal = Appeal::with('perakuan')->findOrFail($id);
        
        // Get the current user (the one who is approving)
        $approver = auth()->user();
        
        // Get applicant details
        $applicant = \App\Models\User::find($appeal->applicant_id);
        
        // Get the perakuan data
        $perakuan = $appeal->perakuan;
        
        // Generate PDF using DomPDF
        $pdf = PDF::loadView('appeals.print_letter_pdf', compact('appeal', 'approver', 'applicant', 'perakuan'));
        
        // Generate filename
        $refNumber = $appeal->kpp_ref_no ?? 'KPP-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        $filename = 'Surat_Kelulusan_' . preg_replace('/[^a-zA-Z0-9]/', '_', $refNumber) . '.pdf';
        
        return $pdf->download($filename);
    }

    // KPP Letter (for PK review tindakan tab)
    public function KPPLetter($id) {
        $appeal = Appeal::with('perakuan')->findOrFail($id);
        
        // Get the current user (the one who is approving)
        $approver = auth()->user();
        
        // Get applicant details
        $applicant = \App\Models\User::find($appeal->applicant_id);
        
        // Get the perakuan data
        $perakuan = $appeal->perakuan;
        
        return view('appeals.KPP_letter', compact('appeal', 'approver', 'applicant', 'perakuan'));
    }

    // KPP Letter PDF (for PK review tindakan tab)
    public function KPPLetterPDF($id) {
        $appeal = Appeal::with('perakuan')->findOrFail($id);
        
        // Get the current user (the one who is approving)
        $approver = auth()->user();
        
        // Get applicant details
        $applicant = \App\Models\User::find($appeal->applicant_id);
        
        // Get the perakuan data
        $perakuan = $appeal->perakuan;
        
        // Generate PDF using DomPDF
        $pdf = PDF::loadView('appeals.KPP_letter_pdf', compact('appeal', 'approver', 'applicant', 'perakuan'));
        
        // Generate filename
        $refNumber = $appeal->kpp_ref_no ?? 'KPP-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        $filename = 'Surat_Kelulusan_KPP_' . preg_replace('/[^a-zA-Z0-9]/', '_', $refNumber) . '.pdf';
        
        return $pdf->download($filename);
    }

    // Update reference number
    public function updateReference(Request $request, $id) {
        $appeal = Appeal::findOrFail($id);
        
        $request->validate([
            'reference_number' => 'required|string|max:255'
        ]);
        
        $appeal->update([
            'kpp_ref_no' => $request->reference_number
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Reference number updated successfully',
            'reference_number' => $request->reference_number
        ]);
    }
    // Senarai Permohonan Landing Page
    public function senaraiPermohonanIndex()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Sila log masuk.');
        }

        $userRole = strtolower($user->peranan ?? '');
        $isOfficer = in_array($userRole, [
            'pegawai perikanan negeri',
            'ketua cawangan',
            'pengarah kanan'
        ]);
        
        return view('appeals.senarai_permohonan_index', compact('isOfficer', 'userRole'));
    }

    // List applications for amendment (Skrin Senarai Permohonan Untuk Pindaan Syarat)
    public function listApplicationsForAmendment(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Sila log masuk.');
        }

        $userRole = strtolower($user->peranan ?? '');
        $applicationType = $request->query('type'); // kvp07 or kvp08
        $role = $request->query('role'); // officer or applicant
        
        // Determine if user is an officer
        $isOfficer = in_array($userRole, [
            'pegawai perikanan negeri',
            'ketua cawangan',
            'pengarah kanan'
        ]);
        
        $query = \App\Models\Appeal::with(['perakuan', 'applicant']);

        // Filter by user role
        if (strpos($userRole, 'pelesen') !== false) {
            // Only show their own appeals
            $query->where('applicant_id', $user->id);
        } elseif (strpos($userRole, 'pegawai perikanan') !== false) {
            // PPL can see: submitted, ppl_review, ppl_incomplete, and kcl_review (to track progress)
            $query->whereIn('status', ['submitted', 'ppl_review', 'ppl_incomplete', 'kcl_review']);
        } elseif (strpos($userRole, 'ketua cawangan') !== false) {
            // KCL can see: kcl_review, kcl_incomplete, and pk_review (to track progress)
            $query->whereIn('status', ['kcl_review', 'kcl_incomplete', 'pk_review']);
        } elseif (strpos($userRole, 'pengarah kanan') !== false) {
            // PK can see: pk_review, pk_incomplete, approved, rejected
            $query->whereIn('status', ['pk_review', 'pk_incomplete', 'approved', 'rejected']);
        } else {
            $query->where('applicant_id', $user->id);
        }

        // Filter by application type if specified
        if ($applicationType) {
            if ($applicationType === 'kvp07') {
                $query->whereHas('perakuan', function($q) {
                    $q->where('type', 'kvp07');
                });
            } elseif ($applicationType === 'kvp08') {
                $query->whereHas('perakuan', function($q) {
                    $q->where('type', 'kvp08');
                });
            }
        }

        $applications = $query->orderByDesc('created_at')->get();

        if ($applications->isEmpty()) {
            \Log::info('Tiada permohonan dijumpai untuk peranan: ' . $userRole . ' dan jenis: ' . $applicationType);
        }

        return view('appeals.list_for_amendment', compact('applications', 'applicationType', 'role', 'userRole', 'isOfficer'));
    }

    // List KPV-07 applications only (Rayuan Pindaan Syarat)
    public function listKvp07Applications(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Sila log masuk.');
        }

        $userRole = strtolower($user->peranan ?? '');
        $role = $request->query('role', 'applicant'); // officer or applicant
        
        // Debug: Log the actual role value
        \Log::info('User role detected: ' . $userRole);
        
        // Determine if user is an officer - fix the role detection
        $isOfficer = false;
        if (strpos($userRole, 'pegawai perikanan') !== false || 
            strpos($userRole, 'ketua cawangan') !== false || 
            strpos($userRole, 'pengarah kanan') !== false) {
            $isOfficer = true;
        }
        
        \Log::info('Is Officer: ' . ($isOfficer ? 'YES' : 'NO'));
        
        $query = \App\Models\Appeal::with(['perakuan', 'applicant']);

        // Filter by user role
        if (strpos($userRole, 'pelesen') !== false) {
            // Only show their own appeals
            $query->where('applicant_id', $user->id);
        } elseif (strpos($userRole, 'pegawai perikanan') !== false) {
            // PPL can see: submitted, ppl_review, ppl_incomplete, and kcl_review (to track progress)
            $query->whereIn('status', ['submitted', 'ppl_review', 'ppl_incomplete', 'kcl_review']);
        } elseif (strpos($userRole, 'ketua cawangan') !== false) {
            // KCL can see: kcl_review, kcl_incomplete, and pk_review (to track progress)
            $query->whereIn('status', ['kcl_review', 'kcl_incomplete', 'pk_review']);
        } elseif (strpos($userRole, 'pengarah kanan') !== false) {
            // PK can see: pk_review, pk_incomplete, approved, rejected
            $query->whereIn('status', ['pk_review', 'pk_incomplete', 'approved', 'rejected']);
        } else {
            $query->where('applicant_id', $user->id);
        }

        // Filter ONLY for KPV-07 applications
        $query->whereHas('perakuan', function($q) {
            $q->where('type', 'kvp07');
        });

        $applications = $query->orderByDesc('created_at')->get();

        if ($applications->isEmpty()) {
            \Log::info('Tiada permohonan KPV-07 dijumpai untuk peranan: ' . $userRole);
        }

        return view('appeals.list_for_amendment', compact('applications', 'role', 'userRole', 'isOfficer'))->with('applicationType', 'kvp07');
    }

    // List KPV-08 applications only (Rayuan Lanjut Tempoh)
    public function listKvp08Applications(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Sila log masuk.');
        }

        $userRole = strtolower($user->peranan ?? '');
        $role = $request->query('role', 'applicant'); // officer or applicant
        
        // Debug: Log the actual role value
        \Log::info('User role detected: ' . $userRole);
        
        // Determine if user is an officer - fix the role detection
        $isOfficer = false;
        if (strpos($userRole, 'pegawai perikanan') !== false || 
            strpos($userRole, 'ketua cawangan') !== false || 
            strpos($userRole, 'pengarah kanan') !== false) {
            $isOfficer = true;
        }
        
        \Log::info('Is Officer: ' . ($isOfficer ? 'YES' : 'NO'));
        
        $query = \App\Models\Appeal::with(['perakuan', 'applicant']);

        // Filter by user role
        if (strpos($userRole, 'pelesen') !== false) {
            // Only show their own appeals
            $query->where('applicant_id', $user->id);
        } elseif (strpos($userRole, 'pegawai perikanan') !== false) {
            // PPL can see: submitted, ppl_review, ppl_incomplete, and kcl_review (to track progress)
            $query->whereIn('status', ['submitted', 'ppl_review', 'ppl_incomplete', 'kcl_review']);
        } elseif (strpos($userRole, 'ketua cawangan') !== false) {
            // KCL can see: kcl_review, kcl_incomplete, and pk_review (to track progress)
            $query->whereIn('status', ['kcl_review', 'kcl_incomplete', 'pk_review']);
        } elseif (strpos($userRole, 'pengarah kanan') !== false) {
            // PK can see: pk_review, pk_incomplete, approved, rejected
            $query->whereIn('status', ['pk_review', 'pk_incomplete', 'approved', 'rejected']);
        } else {
            $query->where('applicant_id', $user->id);
        }

        // Filter ONLY for KPV-08 applications
        $query->whereHas('perakuan', function($q) {
            $q->where('type', 'kvp08');
        });

        $applications = $query->orderByDesc('created_at')->get();

        if ($applications->isEmpty()) {
            \Log::info('Tiada permohonan KPV-08 dijumpai untuk peranan: ' . $userRole);
        }

        return view('appeals.list_for_amendment', compact('applications', 'role', 'userRole', 'isOfficer'))->with('applicationType', 'kvp08');
    }

    public function showBorangPermohonanButiran()
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Sila log masuk untuk mengakses borang permohonan.');
        }
        
        $jenisPindaanOptions = \App\Models\CodeMaster::where('type', 'jenis_pindaan_syarat')->where('is_active', 1)->orderBy('order')->pluck('name', 'id');
        $jenisPerolehanOptions = \App\Models\CodeMaster::where('type', 'jenis_perolehan')->where('is_active', 1)->orderBy('order')->pluck('name', 'id');
        $jenisBahanBinaanOptions = \App\Models\CodeMaster::where('type', 'jenis_bahan_binaan_vesel')->where('is_active', 1)->orderBy('order')->pluck('name', 'id');
        
        // Load existing draft if available
                    $existingDraft = \App\Models\Perakuan::where('user_id', (string) $user->id)
            ->where('status', 'draft')
            ->latest()
            ->first();
            
        return view('appeals.borang_permohonan_butiran', compact(
            'jenisPindaanOptions', 
            'jenisPerolehanOptions', 
            'jenisBahanBinaanOptions',
            'existingDraft'
        ));
    }
    public function saveDokumen(Request $request)
    {
        $user = auth()->user();

        // Strict file validation for dokumen_sokongan uploads
        $validationRules = [
            'dokumen_sokongan_terpakai' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:10240',
            'dokumen_sokongan_bina_baru' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:10240',
            'dokumen_sokongan_pangkalan' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:10240',
            'dokumen_sokongan_bahan_binaan' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:10240',
        ];
        $messages = [
            'mimes' => 'Dokumen Sokongan mesti dalam format PDF, PNG, JPG, atau JPEG.',
            'max' => 'Dokumen Sokongan tidak boleh melebihi 10MB.',
        ];
        $this->validate($request, $validationRules, $messages);

        // Define document types
        $dokumenTypes = [
            'surat_jual_beli_terpakai',
            'lesen_skl_terpakai',
            'dokumen_sokongan_terpakai',
            'akuan_sumpah_bina_baru',
            'lesen_skl_bina_baru',
            'dokumen_sokongan_bina_baru',
            'dokumen_sokongan_pangkalan',
            'dokumen_sokongan_bahan_binaan',
        ];
    
        // Upload files and store their paths in the database
        foreach ($dokumenTypes as $type) {
            if ($request->hasFile($type)) {
                $file = $request->file($type);
                // Preserve original filename and extension
                $originalName = $file->getClientOriginalName();
                $path = $file->storeAs('dokumen_permohonan/' . $user->id, $originalName, 'public');
                \App\Models\DokumenPermohonan::create([
                    'user_id' => $user->id,
                    'file_path' => $path,
                    'type' => $type,
                ]);
            }
        }
    
        // After saving documents, redirect to the next step (Perakuan)
        return redirect()->route('appeals.savePerakuan');
    }
    
    public function savePerakuan(Request $request)
    {
        \Log::info('=== savePerakuan METHOD CALLED ===');
        \Log::info('Request data: ' . json_encode($request->all()));
        \Log::info('Files: ' . json_encode($request->allFiles()));
        
        try {
            $user = auth()->user();

            if (!$user) {
                return redirect()->route('login')->with('error', 'Sila log masuk untuk menghantar permohonan.');
            }

            // ✅ VALIDATION FOR KPV-07 (Pindaan Syarat)
            $jenisPerolehan = $request->input('jenis_perolehan');
            
            // Check if kertas kerja is uploaded based on jenis perolehan
            $kertasKerjaRequired = false;
            $kertasKerjaUploaded = false;
            
            if ($jenisPerolehan === 'Vesel Bina Baru Dalam Negara') {
                $kertasKerjaRequired = true;
                $kertasKerjaUploaded = $request->hasFile('kertas_kerja_bina_baru');
            } elseif ($jenisPerolehan === 'Vesel Bina Baru Luar Negara') {
                $kertasKerjaRequired = true;
                $kertasKerjaUploaded = $request->hasFile('kertas_kerja_bina_baru_luar_negara');
            }
            
            // Validate kertas kerja requirement
            if ($kertasKerjaRequired && !$kertasKerjaUploaded) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Kertas Kerja adalah wajib untuk ' . $jenisPerolehan . '. Sila upload dokumen tersebut.');
            }

            // ✅ Get or create the correct Appeal (status = submitted)
            $appeal = Appeal::where('applicant_id', $user->id)
                            ->where('status', 'submitted')
                            ->latest()
                            ->first();

            if (!$appeal) {
                \Log::info('Creating new appeal for user: ' . $user->id);
                $appeal = Appeal::create([
                    'applicant_id' => $user->id,
                    'status' => 'submitted',
                ]);
                \Log::info('New appeal created with ID: ' . $appeal->id);
            } else {
                \Log::info('Using existing appeal with ID: ' . $appeal->id);
            }

            // ✅ Prepare the Perakuan data
            $data = [
                'user_id' => (string) $user->id,
                'appeal_id' => $appeal->id, // 💡 always valid UUID
                'perakuan' => $request->has('perakuan') ? 1 : 0,
                'type' => 'kvp07', // Set type for KPV-07 form
                'jenis_pindaan_syarat' => $request->input('jenis_pindaan_syarat'),
                'jenis_bahan_binaan_vesel' => $request->input('jenis_bahan_binaan_vesel'),
                'nyatakan' => $request->input('nyatakan'),
                'jenis_perolehan' => $request->input('jenis_perolehan'),
                'negeri_limbungan_baru' => $request->input('negeri_limbungan_baru'),
                'nama_limbungan_baru' => $request->input('nama_limbungan_baru'),
                'daerah_baru' => $request->input('daerah_baru'),
                'alamat_baru' => $request->input('alamat_baru'),
                'poskod_baru' => $request->input('poskod_baru'),
                'pernah_berdaftar' => $request->input('pernah_berdaftar'),
                'no_pendaftaran_vesel' => $request->input('no_pendaftaran_vesel'),
                'negeri_asal_vesel' => $request->input('negeri_asal_vesel'),
                'pelabuhan_pangkalan' => $request->input('pelabuhan_pangkalan'),
                'pangkalan_asal' => $request->input('pangkalan_asal'),
                'pangkalan_baru' => $request->input('pangkalan_baru'),
                'justifikasi_pindaan' => $request->input('justifikasi_pindaan'),
                'justifikasi_perolehan' => $request->input('justifikasi_perolehan'),
                'tarikh_mula_kelulusan' => $request->input('tarikh_mula_kelulusan'),
                'tarikh_tamat_kelulusan' => $request->input('tarikh_tamat_kelulusan'),
                // New fields for Vesel Bina Baru Luar Negara
                'alamat_limbungan_luar_negara' => $request->input('alamat_limbungan_luar_negara'),
                'negara_limbungan' => $request->input('negara_limbungan'),
                // New fields for equipment change
                'no_permit_peralatan' => $request->input('no_permit_peralatan'),
                'jenis_peralatan_asal' => $request->input('jenis_peralatan_asal'),
                'jenis_peralatan_baru' => $request->input('jenis_peralatan_baru'),
                'justifikasi_tukar_peralatan' => $request->input('justifikasi_tukar_peralatan'),
                // New fields for company name change
                'no_pendaftaran_perniagaan' => $request->input('no_pendaftaran_perniagaan'),
                'tarikh_pendaftaran_syarikat' => $request->input('tarikh_pendaftaran_syarikat'),
                'tarikh_luput_pendaftaran' => $request->input('tarikh_luput_pendaftaran'),
                'status_perniagaan' => $request->input('status_perniagaan'),
                'nama_syarikat_baru' => $request->input('nama_syarikat_baru'),
                'justifikasi_tukar_nama' => $request->input('justifikasi_tukar_nama'),
                // Kelulusan Perolehan fields
                'kelulusan_perolehan_id' => $request->input('kelulusan_perolehan_id'),
                'selected_permits' => json_encode($request->input('selected_permits', [])),
                'status' => 'submitted',
            ];

        // ✅ File uploads
        $dokumenTypes = [
            'surat_jual_beli_terpakai' => 'surat_jual_beli_terpakai_path',
            'lesen_skl_terpakai' => 'lesen_skl_terpakai_path',
            'kertas_kerja_bina_baru' => 'kertas_kerja_bina_baru_path',
            'kertas_kerja_bina_baru_luar_negara' => 'kertas_kerja_bina_baru_luar_negara_path',
            'lesen_skl_bina_baru' => 'lesen_skl_bina_baru_path',
            // New document fields for company name change
            'borang_e_kaedah_13' => 'borang_e_kaedah_13_path',
            'profil_perniagaan_enterprise' => 'profil_perniagaan_enterprise_path',
            'form_9' => 'form_9_path',
            'form_24' => 'form_24_path',
            'form_44' => 'form_44_path',
            'form_49' => 'form_49_path',
            'pendaftaran_persatuan' => 'pendaftaran_persatuan_path',
            'profil_persatuan' => 'profil_persatuan_path',
            'pendaftaran_koperasi' => 'pendaftaran_koperasi_path',
            'profil_koperasi' => 'profil_koperasi_path',
        ];

        foreach ($dokumenTypes as $inputName => $dbField) {
            if ($request->hasFile($inputName)) {
                try {
                    $file = $request->file($inputName);
                    if ($file && $file->isValid()) {
                        // Preserve original filename and extension
                        $originalName = $file->getClientOriginalName();
                        $path = $file->storeAs('dokumen_permohonan/' . $user->id, $originalName, 'public');
                        $data[$dbField] = $path;
                    }
                } catch (\Exception $e) {
                    \Log::error("Error storing single file {$inputName}: " . $e->getMessage());
                    continue; // Skip this file and continue with others
                }
            }
        }

        // Handle unlimited dokumen sokongan arrays - NEW APPROACH
        $dokumenSokonganTypes = [
            'dokumen_sokongan_bina_baru' => 'bina_baru',
            'dokumen_sokongan_bina_baru_luar_negara' => 'bina_baru_luar_negara',
            'dokumen_sokongan_terpakai' => 'terpakai',
            'dokumen_sokongan_pangkalan' => 'pangkalan',
            'dokumen_sokongan_bahan_binaan' => 'bahan_binaan',
            'dokumen_sokongan_tukar_peralatan' => 'tukar_peralatan',
        ];

        \Log::info('Processing dokumen sokongan files...');
        \Log::info('Appeal ID: ' . $appeal->id);
        \Log::info('Ref Number: ' . $appeal->ref_number);
        \Log::info('Request all data: ' . json_encode($request->all()));
        \Log::info('Request files: ' . json_encode($request->allFiles()));
        \Log::info('Request has files: ' . ($request->hasFile('dokumen_sokongan_bahan_binaan') ? 'YES' : 'NO'));
        \Log::info('Request file count: ' . count($request->allFiles()));

        foreach ($dokumenSokonganTypes as $inputName => $fileType) {
            \Log::info('Checking input: ' . $inputName);
            \Log::info('hasFile(' . $inputName . '): ' . ($request->hasFile($inputName) ? 'YES' : 'NO'));
            
            if ($request->hasFile($inputName)) {
                \Log::info('Found files for: ' . $inputName);
                $files = $request->file($inputName);
                \Log::info('Files object: ' . gettype($files));
                \Log::info('Files content: ' . json_encode($files));
                
                // Ensure we have an array of files
                if (!is_array($files)) {
                    $files = [$files]; // Convert single file to array
                }
                
                \Log::info('Number of files: ' . count($files));
                
                foreach ($files as $index => $file) {
                    \Log::info('Processing file ' . ($index + 1) . ': ' . $file->getClientOriginalName());
                    
                    if ($file && $file->isValid()) {
                        try {
                            // Preserve original filename and extension
                            $originalName = $file->getClientOriginalName();
                            $path = $file->storeAs('dokumen_permohonan/' . $user->id, $originalName, 'public');
                            \Log::info('File stored at: ' . $path);
                            
                            // Create individual dokumen_sokongan record
                            $dokumenSokongan = \App\Models\DokumenSokongan::create([
                                'id' => (string) \Str::uuid(),
                                'appeals_id' => $appeal->id,
                                'ref_number' => $appeal->ref_number,
                                'user_id' => $user->id,
                                'file_path' => $path,
                                'file_name' => $originalName,
                                'file_type' => $fileType,
                                'file_size' => $file->getSize(),
                                'mime_type' => $file->getMimeType(),
                            ]);
                            
                            \Log::info('DokumenSokongan record created with ID: ' . $dokumenSokongan->id);
                        } catch (\Exception $e) {
                            \Log::error("Error storing file {$inputName}: " . $e->getMessage());
                            \Log::error("Stack trace: " . $e->getTraceAsString());
                            continue; // Skip this file and continue with others
                        }
                    } else {
                        \Log::warning('File is invalid: ' . $file->getClientOriginalName());
                    }
                }
            } else {
                \Log::info('No files found for: ' . $inputName);
            }
        }

        // ✅ Save or update Perakuan
        \Log::info('Saving Perakuan record...');
        \Log::info('Perakuan data: ' . json_encode($data));
        
        $existingDraft = Perakuan::where('user_id', $user->id)
                                 ->where('status', 'draft')
                                 ->first();

        if ($existingDraft) {
            \Log::info('Updating existing draft with ID: ' . $existingDraft->id);
            $existingDraft->update($data);
            \Log::info('Draft updated successfully');
        } else {
            \Log::info('Creating new Perakuan record');
            $perakuan = Perakuan::create($data);
            \Log::info('New Perakuan created with ID: ' . $perakuan->id);
        }

        // ✅ Update appeal status to submitted
        \Log::info('Updating appeal status to submitted...');
        $appeal->update(['status' => 'submitted']);
        \Log::info('Appeal status updated successfully');

        \Log::info('All operations completed successfully');
        event(new AppealUpdated($appeal));
        return redirect()->route('appeals.amendment')->with('success', 'Permohonan anda telah berjaya dihantar!');
    } catch (\Exception $e) {
        \Log::error('Error saving perakuan: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Ralat menyimpan permohonan: ' . $e->getMessage());
    }
}

        
    public function saveButiran(Request $request)
    {
        $user = auth()->user();
    
        // Save or update the application details
        $application = \App\Models\Application::updateOrCreate(
            ['ic_no' => $user->username],  // Check if the user exists based on IC number
            [
                'full_name' => $request->input('full_name'),
                'ic_no' => $user->username,
                'date_of_birth' => $request->input('date_of_birth'),
                'phone_no' => $request->input('phone_no'),
                'home_address1' => $request->input('home_address1'),
                'home_address2' => $request->input('home_address2'),
                'home_address3' => $request->input('home_address3'),
                // Add other fields as needed
            ]
        );
    
        // After saving the Butiran Permohonan, redirect to the next step (Dokumen Permohonan)
        return redirect()->route('appeals.saveDokumen');
    }
    
    public function summary()
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Sila log masuk untuk melihat ringkasan permohonan.');
        }
        
        $perakuan = \App\Models\Perakuan::where('user_id', (string) $user->id)->latest()->first();
        
        // Get the latest appeal for this user
        $appeal = \App\Models\Appeal::where('applicant_id', $user->id)->latest()->first();
        
        // Get dokumen sokongan for this appeal
        $dokumenSokongan = collect();
        if ($appeal) {
            $dokumenSokongan = \App\Models\DokumenSokongan::where('appeals_id', $appeal->id)->get();
        }
        
        return view('appeals.summary', compact('perakuan', 'dokumenSokongan'));
    }

    public function saveDraft(Request $request)
    {
        try {
            $user = auth()->user();
            
            if (!$user) {
                return redirect()->route('login')->with('error', 'Sila log masuk untuk menyimpan draft.');
            }
        
            // Always ensure there is an Appeal for this user
            $appeal = \App\Models\Appeal::where('applicant_id', $user->id)
                ->where('status', 'submitted')
                ->latest()
                ->first();
            if (!$appeal) {
                $appeal = \App\Models\Appeal::create([
                    'id' => (string) \Str::uuid(),
                    'applicant_id' => $user->id,
                    'status' => 'submitted',
                ]);
            }
        
            // Prepare the data to be saved for draft - only include fields that are present
            $data = [
                'user_id' => (string) $user->id,
                'appeal_id' => $appeal->id, // Always set appeal_id
                'type' => 'kvp07', // Set type for KPV-07 form
                'status' => 'draft', // Mark as draft
            ];
            
            // Only add fields that are present in the request
            $fields = [
                'perakuan',
                'jenis_pindaan_syarat',
                'jenis_bahan_binaan_vesel',
                'nyatakan',
                'jenis_perolehan',
                'negeri_limbungan_baru',
                'nama_limbungan_baru',
                'daerah_baru',
                'alamat_baru',
                'poskod_baru',
                'pernah_berdaftar',
                'no_pendaftaran_vesel',
                'negeri_asal_vesel',
                'pelabuhan_pangkalan',
                'pangkalan_asal',
                'pangkalan_baru',
                'justifikasi_pindaan',
                'justifikasi_perolehan',
                'tarikh_mula_kelulusan',
                'tarikh_tamat_kelulusan',
                // New fields for Vesel Bina Baru Luar Negara
                'alamat_limbungan_luar_negara',
                'negara_limbungan',
                // New fields for equipment change
                'no_permit_peralatan',
                'jenis_peralatan_asal',
                'jenis_peralatan_baru',
                'justifikasi_tukar_peralatan',
                // New fields for company name change
                'no_pendaftaran_perniagaan',
                'tarikh_pendaftaran_syarikat',
                'tarikh_luput_pendaftaran',
                'status_perniagaan',
                'nama_syarikat_baru',
                'justifikasi_tukar_nama',
                // Kelulusan Perolehan fields
                'kelulusan_perolehan_id',
                'selected_permits',
            ];
            
            foreach ($fields as $field) {
                if ($request->has($field)) {
                    if ($field === 'selected_permits') {
                        // Handle array input for selected_permits
                        $data[$field] = json_encode($request->input($field, []));
                    } else {
                        $data[$field] = $request->input($field);
                    }
                }
            }
            
            // Handle perakuan checkbox specifically
            if ($request->has('perakuan')) {
                $data['perakuan'] = 1;
            } else {
                $data['perakuan'] = 0;
            }
        
            // Handle file uploads
            $dokumenTypes = [
                'surat_jual_beli_terpakai' => 'surat_jual_beli_terpakai_path',
                'lesen_skl_terpakai' => 'lesen_skl_terpakai_path',
                'dokumen_sokongan_terpakai' => 'dokumen_sokongan_terpakai_path',
                'akuan_sumpah_bina_baru' => 'akuan_sumpah_bina_baru_path',
                'lesen_skl_bina_baru' => 'lesen_skl_bina_baru_path',
                'dokumen_sokongan_bina_baru' => 'dokumen_sokongan_bina_baru_path',
                'dokumen_sokongan_pangkalan' => 'dokumen_sokongan_pangkalan_path',
                'dokumen_sokongan_bahan_binaan' => 'dokumen_sokongan_bahan_binaan_path',
                // New document fields for equipment change
                'dokumen_sokongan_tukar_peralatan' => 'dokumen_sokongan_tukar_peralatan_path',
                // New document fields for company name change
                'borang_e_kaedah_13' => 'borang_e_kaedah_13_path',
                'profil_perniagaan_enterprise' => 'profil_perniagaan_enterprise_path',
                'form_9' => 'form_9_path',
                'form_24' => 'form_24_path',
                'form_44' => 'form_44_path',
                'form_49' => 'form_49_path',
                'pendaftaran_persatuan' => 'pendaftaran_persatuan_path',
                'profil_persatuan' => 'profil_persatuan_path',
                'pendaftaran_koperasi' => 'pendaftaran_koperasi_path',
                'profil_koperasi' => 'profil_koperasi_path',
            ];
            
            foreach ($dokumenTypes as $inputName => $dbField) {
                if ($request->hasFile($inputName)) {
                    $file = $request->file($inputName);
                    // Preserve original filename and extension
                    $originalName = $file->getClientOriginalName();
                    $path = $file->storeAs('dokumen_permohonan/' . $user->id, $originalName, 'public');
                    $data[$dbField] = $path;
                }
            }
            
            // Save or update the draft data
            \App\Models\Perakuan::updateOrCreate(
                ['user_id' => (string) $user->id, 'status' => 'draft'],
                $data
            );
        
            event(new AppealUpdated($appeal));
            return response()->json(['success' => true, 'message' => 'Draft berjaya disimpan!']);
        } catch (\Exception $e) {
            \Log::error('Error saving draft: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Ralat menyimpan draft: ' . $e->getMessage()], 500);
        }
    }

    public function amendmentListPartial()
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userRole = strtolower($user->peranan ?? '');
        
        // Debug: Log the actual role value
        \Log::info('User role detected: ' . $userRole);
        
        // Determine if user is an officer - fix the role detection
        $isOfficer = false;
        if (strpos($userRole, 'pegawai perikanan') !== false || 
            strpos($userRole, 'ketua cawangan') !== false || 
            strpos($userRole, 'pengarah kanan') !== false) {
            $isOfficer = true;
        }
        
        \Log::info('Is Officer: ' . ($isOfficer ? 'YES' : 'NO'));
        
        // For applicants (pelesen), return empty or redirect
        if (strpos($userRole, 'pelesen') !== false) {
            return view('appeals.list_for_amendment_table', ['appeals' => collect(), 'isOfficer' => false, 'userRole' => $userRole]);
        }
        
        // For reviewers, show only appeals that are relevant to their role
        $query = \App\Models\Appeal::with(['perakuan', 'applicant']);
        
        if (strpos($userRole, 'pegawai perikanan') !== false) {
            // PPL can see: submitted, ppl_review, ppl_incomplete, and kcl_review (to track progress)
            $query->whereIn('status', ['submitted', 'ppl_review', 'ppl_incomplete', 'kcl_review']);
        } elseif (strpos($userRole, 'ketua cawangan') !== false) {
            // KCL can see: kcl_review, kcl_incomplete, and pk_review (to track progress)
            $query->whereIn('status', ['kcl_review', 'kcl_incomplete', 'pk_review']);
        } elseif (strpos($userRole, 'pengarah kanan') !== false) {
            // PK can see: pk_review, pk_incomplete, approved, rejected
            $query->whereIn('status', ['pk_review', 'pk_incomplete', 'approved', 'rejected']);
        } else {
            // For other roles or no role, show only their own appeals or none
            $query->where('applicant_id', $user->id);
        }
        
        $applications = $query->orderByDesc('created_at')->get();
        return view('appeals.list_for_amendment_table', ['appeals' => $applications, 'isOfficer' => $isOfficer, 'userRole' => $userRole]);
    }

    public function show($id)
    {
        // Retrieve the appeal based on the ID and return the view
        $appeal = Appeal::findOrFail($id);
        return view('appeals.show', compact('appeal'));
    }  

    public function index()
    {
        // Fetch all appeals or add any other logic here to retrieve them
        $appeals = Appeal::all();

        // Return the 'appeals.index' view with the list of appeals
        return view('appeals.index', compact('appeals'));
    }

    public function destroy($id)
    {
        $appeal = \App\Models\Appeal::findOrFail($id);
        // Optionally, add authorization logic here to ensure only the owner can delete
        $user = auth()->user();
        if (strtolower($user->peranan ?? '') !== 'pelesen' || $appeal->applicant_id !== $user->id) {
            abort(403, 'Anda tidak dibenarkan memadam permohonan ini.');
        }
        $appeal->delete();
        return redirect()->route('appeals.amendment')->with('success', 'Permohonan berjaya dipadam.');
    }

    public function viewSuratKelulusanKpp($id)
    {
        $appeal = \App\Models\Appeal::findOrFail($id);
        
        if (!$appeal->surat_kelulusan_kpp) {
            abort(404);
        }
        
        $path = storage_path('app/public/' . $appeal->surat_kelulusan_kpp);
        if (!file_exists($path)) {
            abort(404);
        }

        // Force correct Content-Type based on file extension
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $mime = 'application/octet-stream';
        if ($ext === 'pdf') {
            $mime = 'application/pdf';
        } elseif (in_array($ext, ['jpg', 'jpeg'])) {
            $mime = 'image/jpeg';
        } elseif ($ext === 'png') {
            $mime = 'image/png';
        }

        $headers = [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="'.basename($path).'"'
        ];
        return response()->file($path, $headers);
    }

    // Status content for AJAX loading
    public function statusContent($id)
    {
        $appeal = Appeal::where('id', $id)->firstOrFail();
        $applicant = \App\Models\User::find($appeal->applicant_id);
        $perakuan = \App\Models\Perakuan::where('appeal_id', $id)->first();
        
        
        // Get reviewer names - prioritize the final approver
        $reviewerName = '';
        
        // Check for KPP reviewer first (final approver)
        if ($appeal->kpp_reviewer_id) {
            $kppReviewer = \App\Models\User::find($appeal->kpp_reviewer_id);
            $reviewerName = $kppReviewer ? $kppReviewer->name : 'Unknown';
        }
        // Check for PK reviewer
        elseif ($appeal->pk_reviewer_id) {
            $pkReviewer = \App\Models\User::find($appeal->pk_reviewer_id);
            $reviewerName = $pkReviewer ? $pkReviewer->name : 'Unknown';
        }
        // Check for KCL reviewer
        elseif ($appeal->kcl_reviewer_id) {
            $kclReviewer = \App\Models\User::find($appeal->kcl_reviewer_id);
            $reviewerName = $kclReviewer ? $kclReviewer->name : 'Unknown';
        }
        // Check for PPL reviewer
        elseif ($appeal->ppl_reviewer_id) {
            $pplReviewer = \App\Models\User::find($appeal->ppl_reviewer_id);
            $reviewerName = $pplReviewer ? $pplReviewer->name : 'Unknown';
        }
        
        // If no reviewer found, use current user as fallback
        if (empty($reviewerName)) {
            $reviewerName = auth()->user()->name ?? 'Unknown';
        }
        
        return view('appeals.status_content', compact('appeal', 'applicant', 'perakuan', 'reviewerName'));
    }



    /**
     * Get permits for a specific kelulusan perolehan
     */
    public function getPermits($kelulusanId)
    {
        try {
            $kelulusan = \App\Models\KelulusanPerolehan::with('permits')->findOrFail($kelulusanId);
            
            // Check if user has access to this kelulusan (temporarily disabled for testing)
            // if ($kelulusan->user_id !== auth()->id()) {
            //     return response()->json(['error' => 'Unauthorized'], 403);
            // }
            
            $permits = $kelulusan->permits()->where('is_active', true)->get();
            
            return response()->json([
                'success' => true,
                'permits' => $permits->map(function($permit) {
                    return [
                        'id' => $permit->id,
                        'no_permit' => $permit->no_permit,
                        'jenis_peralatan' => $permit->jenis_peralatan,
                        'status' => $permit->status,
                        'status_text' => $permit->getStatusText(),
                        'status_class' => $permit->getStatusClass(),
                    ];
                })
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error getting permits: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load permits'], 500);
        }
    }

    /**
     * Show error page for corrupted documents
     */
    private function showDocumentError()
    {
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <title>Document Error</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 50px; background: #f8f9fa; }
                .error-box { border: 2px solid #ff6b6b; padding: 30px; border-radius: 10px; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto; }
                .error-title { color: #d63031; font-size: 24px; font-weight: bold; margin-bottom: 15px; }
                .error-message { color: #636e72; margin: 15px 0; font-size: 16px; }
                .solution { background: #e8f5e8; border: 1px solid #00b894; padding: 20px; border-radius: 8px; margin-top: 20px; }
                .solution-title { color: #00b894; font-weight: bold; margin-bottom: 10px; }
                .btn { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; display: inline-block; margin-top: 15px; }
                .btn:hover { background: #0056b3; }
            </style>
        </head>
        <body>
            <div class="error-box">
                <div class="error-title">⚠️ Dokumen Tidak Dapat Dibuka</div>
                <div class="error-message">
                    Dokumen ini rosak atau tidak dapat dibaca dengan betul. Ini mungkin berlaku kerana masalah teknikal semasa muat naik.
                </div>
                <div class="solution">
                    <div class="solution-title">Penyelesaian:</div>
                    1. <strong>Muat semula dokumen</strong> - Sila muat naik semula dokumen ini<br>
                    2. <strong>Semak format fail</strong> - Pastikan format adalah PDF, JPG, PNG, atau DOC<br>
                    3. <strong>Hubungi pentadbir</strong> - Jika masalah berterusan, hubungi pentadbir sistem
                </div>
                <a href="javascript:history.back()" class="btn">Kembali</a>
            </div>
        </body>
        </html>';
        
        return response($html, 200, ['Content-Type' => 'text/html']);
    }

    /**
     * View document for appeals
     */
    public function viewDocument($appealId, $field)
    {
        try {
            // Find the appeal
            $appeal = Appeal::findOrFail($appealId);
            
            // Find the associated perakuan
            $perakuan = \App\Models\Perakuan::where('appeal_id', $appealId)->latest()->first();
            
            if (!$perakuan) {
                abort(404, 'Perakuan not found');
            }

            // Check if the field exists and has a value
            if (!isset($perakuan->$field) || empty($perakuan->$field)) {
                abort(404, 'Document not found');
            }

            $filePath = storage_path('app/public/' . $perakuan->$field);

            if (!file_exists($filePath)) {
                abort(404, 'File not found on server');
            }

            // Get file info
            $fileInfo = pathinfo($filePath);
            $extension = strtolower($fileInfo['extension'] ?? '');
            $filename = $fileInfo['basename'];

            // Handle corrupted .bin files - show error message instead
            if ($extension === 'bin') {
                return $this->showDocumentError();
            }
            
            // Check if file is actually corrupted by reading the first few bytes
            $handle = fopen($filePath, 'rb');
            $header = fread($handle, 4);
            fclose($handle);
            
            // Check for common file signatures
            $isValidFile = false;
            if (strpos($header, '%PDF') === 0) {
                $isValidFile = true; // PDF
            } elseif (strpos($header, "\xFF\xD8\xFF") === 0) {
                $isValidFile = true; // JPEG
            } elseif (strpos($header, "\x89PNG") === 0) {
                $isValidFile = true; // PNG
            } elseif (strpos($header, "GIF8") === 0) {
                $isValidFile = true; // GIF
            }
            
            // If file doesn't have a valid signature, show error
            if (!$isValidFile) {
                \Log::warning("Corrupted file detected: $filePath, header: " . bin2hex($header));
                return $this->showDocumentError();
            }

            // Determine content type
            $contentTypes = [
                'pdf' => 'application/pdf',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'bmp' => 'image/bmp',
                'tiff' => 'image/tiff',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'xls' => 'application/vnd.ms-excel',
                'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'txt' => 'text/plain',
            ];

            $contentType = $contentTypes[$extension] ?? 'application/octet-stream';

            // Always try to display inline for viewable files
            if (in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'txt'])) {
                return response()->file($filePath, [
                    'Content-Type' => $contentType,
                    'Content-Disposition' => 'inline; filename="' . $filename . '"'
                ]);
            }

            // For other files, still try to display inline but with download fallback
            return response()->file($filePath, [
                'Content-Type' => $contentType,
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]);

        } catch (\Exception $e) {
            \Log::error('Document viewing error: ' . $e->getMessage());
            abort(404, 'Document not found or access denied');
        }
    }

    /**
     * View supporting documents (DokumenSokongan)
     */
    public function viewDokumenSokongan($id)
    {
        try {
            // Find the supporting document
            $dokumen = \App\Models\DokumenSokongan::findOrFail($id);

            if (empty($dokumen->file_path)) {
                abort(404, 'Document not found');
            }

            $filePath = storage_path('app/public/' . $dokumen->file_path);

            if (!file_exists($filePath)) {
                abort(404, 'File not found on server');
            }

            // Get file info
            $fileInfo = pathinfo($filePath);
            $extension = strtolower($fileInfo['extension'] ?? '');
            $filename = $dokumen->file_name ?: $fileInfo['basename'];

            // Handle corrupted .bin files - show error message instead
            if ($extension === 'bin') {
                return $this->showDocumentError();
            }

            // Determine content type
            $contentTypes = [
                'pdf' => 'application/pdf',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'gif' => 'image/gif',
                'bmp' => 'image/bmp',
                'tiff' => 'image/tiff',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'xls' => 'application/vnd.ms-excel',
                'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'txt' => 'text/plain',
            ];

            $contentType = $contentTypes[$extension] ?? 'application/octet-stream';

            // Always try to display inline for viewable files
            if (in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'txt'])) {
                return response()->file($filePath, [
                    'Content-Type' => $contentType,
                    'Content-Disposition' => 'inline; filename="' . $filename . '"'
                ]);
            }

            // For other files, still try to display inline but with download fallback
            return response()->file($filePath, [
                'Content-Type' => $contentType,
                'Content-Disposition' => 'inline; filename="' . $filename . '"'
            ]);

        } catch (\Exception $e) {
            \Log::error('Supporting document viewing error: ' . $e->getMessage());
            abort(404, 'Document not found or access denied');
        }
    }
}   