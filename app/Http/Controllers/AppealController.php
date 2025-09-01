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
        // Determine reviewer name for the current stage
        $status = $appeal->status;
        if (in_array($status, ['submitted', 'ppl_review', 'ppl_incomplete'])) {
            $reviewerUser = \App\Models\User::whereRaw('LOWER(TRIM(peranan)) = ?', [strtolower(trim('PEGAWAI PERIKANAN NEGERI'))])->first();
            $reviewerName = $reviewerUser->name ?? '-';
        } elseif (in_array($status, ['kcl_review', 'kcl_incomplete'])) {
            $reviewerUser = \App\Models\User::whereRaw('LOWER(TRIM(peranan)) = ?', [strtolower(trim('KETUA CAWANGAN'))])->first();
            $reviewerName = $reviewerUser->name ?? '-';
        } elseif (in_array($status, ['pk_review', 'pk_incomplete', 'approved', 'rejected'])) {
            $reviewerUser = \App\Models\User::whereRaw('LOWER(TRIM(peranan)) = ?', [strtolower(trim('PENGARAH KANAN'))])->first();
            $reviewerName = $reviewerUser->name ?? '-';
        } else {
            $reviewerName = $applicant->name ?? '-';
        }
        // Return the status view with the appeal and applicant data
        return view('appeals.status', compact('appeal', 'applicant', 'reviewerName'));
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
        $appeal = \App\Models\Appeal::findOrFail($id);
        $perakuan = \App\Models\Perakuan::where('appeal_id', $appeal->id)->latest()->first();
        $user = auth()->user();
        if ($appeal->applicant_id !== $user->id) {
            abort(403, 'Anda tidak dibenarkan mengedit permohonan ini.');
        }
        // Validate and update fields as needed (simplified example)
        $request->validate([
            'justifikasi_pindaan' => 'required|string',
            // Add other fields and file validation as needed
        ]);
        $perakuan->justifikasi_pindaan = $request->input('justifikasi_pindaan');
        // Add other fields as needed
        $perakuan->status = 'submitted';
        $perakuan->save();
        $appeal->status = 'submitted';
        $appeal->save();
        event(new \App\Events\AppealUpdated($appeal));
        return redirect()->route('appeals.status', $appeal->id)->with('success', 'Permohonan berjaya dikemaskini dan dihantar semula.');
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
        
        return view('appeals.ppl_review', compact('appeal', 'perakuan', 'applicant', 'dokumenSokongan', 'canEdit'));
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
        $appeal->ppl_comments = $request->input('comments');
        $appeal->ppl_status = $status; // Save the status (e.g., 'Lengkap', 'Tidak Lengkap')
        if ($status === 'Lengkap') {
            $appeal->status = 'kcl_review';
        } else {
            $appeal->status = 'ppl_incomplete';
        }
        $appeal->save();
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
        return view('appeals.kcl_review', compact('appeal', 'perakuan', 'applicant', 'dokumenSokongan', 'canEdit'));
    }
    public function kclSubmit(Request $request, $id)
    {
        $appeal = Appeal::findOrFail($id);
        $appeal->kcl_comments = $request->input('comments');
        $status = $request->input('status');
        $appeal->kcl_status = $status; // Save the status (e.g., 'Disokong', 'Tidak Disokong')
        if ($status === 'Disokong') {
            $appeal->status = 'pk_review';
        } else {
            $appeal->status = 'kcl_incomplete';
        }
        $appeal->save();
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
        
        $canEdit = true;
        return view('appeals.pk_review', compact('appeal', 'perakuan', 'applicant', 'dokumenSokongan', 'canEdit'));
    }
    
    public function redirectToRoleReview($id)
    {
        if (!auth()->check()) {
            \Log::info('User not logged in, redirecting to login.');
            return redirect()->route('login');
        }

        $user = auth()->user();
        $userRole = strtolower(trim($user->peranan ?? ''));
        $userId = $user->id ?? 'unknown';

        if (empty($userRole)) {
            \Log::warning('User has empty role. User ID: ' . $userId);
            abort(403, 'Role is not set. Please contact the administrator.');
        }

        \Log::info("User role: $userRole, redirecting to appropriate review page for appeal ID: $id");

        if (stripos($userRole, 'pegawai perikanan') !== false) {
            return redirect()->route('appeals.ppl_review', ['id' => $id]);
        } elseif (stripos($userRole, 'ketua cawangan') !== false) {
            return redirect()->route('appeals.kcl_review', ['id' => $id]);
        } elseif (stripos($userRole, 'pengarah kanan') !== false) {
            return redirect()->route('appeals.pk_review', ['id' => $id]);
        } elseif (stripos($userRole, 'pelesen') !== false) {
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

            $pkStatus = $request->input('status');
            
            // Determine final status based on PK decision
            $finalStatus = '';
            if ($pkStatus === 'Diluluskan') {
                $finalStatus = 'approved';
            } elseif ($pkStatus === 'Ditolak') {
                $finalStatus = 'rejected';
            } else {
                $finalStatus = 'pk_incomplete';
            }
            
            // Update appeal status
            $appeal->update([
                'status' => $finalStatus,
                'pk_status' => $pkStatus,
                'pk_comments' => $request->input('comments'),
                'pk_no_rujukan_surat' => $request->input('no_rujukan_surat'),
            ]);

            // Handle file upload for surat kelulusan KPP
            if ($request->hasFile('surat_kelulusan_kpp')) {
                $file = $request->file('surat_kelulusan_kpp');
                $path = $file->store('surat_kelulusan_kpp/' . auth()->id(), 'public');
                $perakuan->update(['surat_kelulusan_kpp_path' => $path]);
            }

            // Update perakuan status
            $perakuan->update(['status' => $finalStatus]);

            event(new AppealUpdated($appeal));
            return redirect()->route('appeals.amendment')->with('success', 'Keputusan PK berjaya disimpan!');
        } catch (\Exception $e) {
            \Log::error('Error in pkSubmit: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ralat menyimpan keputusan PK: ' . $e->getMessage());
        }
    }

    public function approvePermit(Request $request, $id)
    {
        try {
            $kvp08Application = \App\Models\Kpv08Application::findOrFail($id);
            
            // Check if user has permission to approve (PK/SPT role)
            if (!auth()->user()->hasRole(['pk', 'spt', 'pk_spt'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak mempunyai kebenaran untuk meluluskan permit.'
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
            
            // Check if user has permission to reject (PK/SPT role)
            if (!auth()->user()->hasRole(['pk', 'spt', 'pk_spt'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak mempunyai kebenaran untuk menolak permit.'
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
        $appeal->save();
        event(new AppealUpdated($appeal));
        return redirect()->route('appeals.amendment');
    }
    // Print letter (stub)
    public function printLetter($id) {
        $appeal = Appeal::findOrFail($id);
        return view('appeals.print_letter', compact('appeal'));
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
            'dokumen_sokongan_terpakai' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'dokumen_sokongan_bina_baru' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'dokumen_sokongan_pangkalan' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'dokumen_sokongan_bahan_binaan' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
        ];
        $messages = [
            'mimes' => 'Dokumen Sokongan mesti dalam format PDF, PNG, JPG, atau JPEG.',
            'max' => 'Dokumen Sokongan tidak boleh melebihi 5MB.',
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
                $path = $file->store('dokumen_permohonan/' . $user->id, 'public');
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
                        $path = $file->store('dokumen_permohonan/' . $user->id, 'public');
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
                            $path = $file->store('dokumen_permohonan/' . $user->id, 'public');
                            \Log::info('File stored at: ' . $path);
                            
                            // Create individual dokumen_sokongan record
                            $dokumenSokongan = \App\Models\DokumenSokongan::create([
                                'id' => (string) \Str::uuid(),
                                'appeals_id' => $appeal->id,
                                'ref_number' => $appeal->ref_number,
                                'user_id' => $user->id,
                                'file_path' => $path,
                                'file_name' => $file->getClientOriginalName(),
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
            ];
            
            foreach ($fields as $field) {
                if ($request->has($field)) {
                    $data[$field] = $request->input($field);
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
                    $path = $file->store('dokumen_permohonan/' . $user->id, 'public');
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
}   