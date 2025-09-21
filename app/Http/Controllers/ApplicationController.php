<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\ApplicationEspp;
use App\Models\User;
use App\Models\CodeMaster;
use Auth;
use Audit;
use Hash;
use Exception;
use Carbon\Carbon;
use Storage;
use Module;
use Helper;
use DB;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function form()
    {
        // Redirect to the new Lain-lain Permohonan page
        return redirect()->route('application.borangpermohonan');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Handle form submission logic here
        // For now, redirect back to form with success message
        return redirect()->route('application.form')->with('success', 'Application submitted successfully!');
    }

    public function storefinancing(Request $request)
    {
        // Handle financing form submission
        return redirect()->back()->with('success', 'Financing information saved successfully!');
    }

    public function storeguarantor(Request $request)
    {
        // Handle guarantor form submission
        return redirect()->back()->with('success', 'Guarantor information saved successfully!');
    }

    public function storevehicle(Request $request)
    {
        // Handle vehicle form submission
        return redirect()->back()->with('success', 'Vehicle information saved successfully!');
    }

    public function storedocument(Request $request)
    {
        // Handle document form submission
        return redirect()->back()->with('success', 'Document information saved successfully!');
    }

    public function formlist()
    {
        $applications = \App\Models\Perakuan::where('status', 'submitted')
            ->where('user_id', auth()->id())
            ->get();
        return view('appeals.list_for_amendment', compact('applications'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function otherApplications()
    {
        $applications = [
            ['name' => 'Permohonan Perolehan Lesen Vesel Dan Peralatan Menangkap Ikan C2'],
            ['name' => 'Permohonan Perolehan Lesen Vesel Dan Peralatan Menangkap Ikan C3/Angkut'],
            ['name' => 'Permohonan Perolehan Lesen Vesel MPPI (Bina Baru)'],
            ['name' => 'Permohonan Perolehan Lesen Vesel MPPI (Terpakai)'],
            ['name' => 'Permohonan Perolehan Lesen Vesel SKL'],
            ['name' => 'Permohonan Lesen Sampan'],
            ['name' => 'Permohonan Perolehan Vesel & Peralatan Menangkap Ikan Khas'],
            ['name' => 'Permohonan Rayuan Pindaan Syarat'],
            ['name' => 'Permohonan Lanjutan Tempoh Sah Kelulusan Perolehan'],
        ];
        $user = Auth::user();
        return view('app.application.borangpermohonan', compact('applications', 'user'));
    }

    public function lanjutanTempohIndex()
    {
        return view('app.application.lanjutan_tempoh');
    }

    public function lanjutanTempohPerakuanStore(Request $request)
    {
        try {
            // Step 1: Validate request including permit selection
            try {
                $request->validate([
                    'permit_id' => 'required|array',
                    'permit_id.*' => 'exists:permits_new,id',
                    'justifikasi' => 'required|string',
                    'dokumen_sokongan' => 'required|file|max:5120',
                    'perakuan_checkbox' => 'required|accepted',
                ]);
            } catch (\Illuminate\Validation\ValidationException $ve) {
                return 'VALIDATION FAILED: ' . json_encode($ve->errors());
            }

            // Step 2: Check business rules for all selected permits
            $permitIds = $request->input('permit_id');
            $permits = \App\Models\Permit::whereIn('id', $permitIds)->get();
            
            foreach ($permits as $permit) {
                if (!$permit->canApplyForExtension()) {
                    return 'BUSINESS RULE VIOLATION: Permit ' . $permit->no_permit . ' tidak boleh dilanjutkan kerana tiada progress dan telah mencapai had maksimum permohonan.';
                }
            }

            // Step 3: File upload
            try {
                $file = $request->file('dokumen_sokongan');
                if (!$file) {
                    return 'FILE UPLOAD FAILED: No file received.';
                }
                
                // Preserve original filename and extension
                $originalName = $file->getClientOriginalName();
                $dokumenPath = $file->storeAs('dokumen_sokongan', $originalName, 'public');
            } catch (\Exception $e) {
                return 'FILE UPLOAD FAILED: ' . $e->getMessage();
            }

            // Step 4: Save to DB
            try {
                // Find or create the Appeal record for this user and permohonan type
                $appeal = \App\Models\Appeal::firstOrCreate([
                    'applicant_id' => auth()->id(),
                    'jenis_permohonan' => 'lanjutan_tempoh',
                ], [
                    'status' => 'submitted',
                ]);
                
                // Always update status to 'submitted'
                $appeal->status = 'submitted';
                $appeal->save();

                // Create Perakuan record
                $perakuan = \App\Models\Perakuan::create([
                    'user_id' => auth()->id(),
                    'appeal_id' => $appeal->id,
                    'perakuan' => true,
                    'type' => 'kvp08',
                    'status' => 'submitted',
                    'dokumen_sokongan_path' => $dokumenPath,
                    'justifikasi_lanjutan_tempoh' => $request->input('justifikasi'),
                    'jenis_pindaan_syarat' => 'Permohonan Lanjutan Tempoh Sah Kelulusan Perolehan',
                ]);

                // Create Kpv08Application records for each selected permit
                foreach ($permits as $permit) {
                    $extensionMonths = $permit->getExtensionPeriod();
                    $newExpiryDate = $permit->expiry_date->addMonths($extensionMonths);
                    $nextApplicationCount = $permit->getNextApplicationCount();
                    
                    \App\Models\Kpv08Application::create([
                        'appeal_id' => $appeal->id,
                        'permit_id' => $permit->id,
                        'justifikasi' => $request->input('justifikasi'),
                        'extension_period' => $extensionMonths . ' bulan',
                        'new_expiry_date' => $newExpiryDate,
                        'status' => 'submitted',
                        'application_count' => $nextApplicationCount,
                    ]);
                }

            } catch (\Exception $e) {
                return 'DB SAVE FAILED: ' . $e->getMessage();
            }

            if (!$perakuan->id) {
                return 'DB SAVE FAILED: No ID returned';
            }

            // Step 5: Redirect to summary
            return redirect()->route('lanjutan-tempoh.summary', ['id' => $perakuan->id]);
        } catch (\Exception $e) {
            return 'UNEXPECTED ERROR: ' . $e->getMessage();
        }
    }

    public function lanjutanTempohSummary($id)
    {
        $perakuan = \App\Models\Perakuan::findOrFail($id);
        return view('app.application.lanjutan_tempoh_summary', compact('perakuan'));
    }

    public function lanjutanTempohConfirm($id)
    {
        $perakuan = \App\Models\Perakuan::findOrFail($id);
        $perakuan->status = 'submitted';
        $perakuan->save();
        return redirect()->route('lanjutan-tempoh.summary', ['id' => $perakuan->id]);
    }
    
    
}
