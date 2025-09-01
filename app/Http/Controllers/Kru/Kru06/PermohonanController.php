<?php

namespace App\Http\Controllers\Kru\Kru06;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Entity;
use App\Models\Helper;
use App\Models\Kru\ForeignCrew;
use App\Models\Kru\ImmigrationGate;
use App\Models\Kru\ImmigrationOffice;
use App\Models\Kru\KruApplication;
use App\Models\Kru\KruApplicationDocument;
use App\Models\Kru\KruApplicationForeign;
use App\Models\Kru\KruApplicationForeignKru;
use App\Models\Kru\KruApplicationKru;
use App\Models\Kru\KruApplicationLog;
use App\Models\Kru\KruApplicationType;
use App\Models\Kru\KruDocument;
use App\Models\Kru\KruForeignDocument;
use App\Models\Kru\NelayanMarin;
use App\Models\ReferenceNumber;
use App\Models\Systems\AuditLog;
use App\Models\User;
use App\Models\Vessel;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('permohonan');

        $helper = new Helper();
        $statusDisimpanId = $helper->getCodeMasterIdByTypeName('kru_application_status','DISIMPAN');

        $appTypeId = KruApplicationType::where('code','KRU06')->first()->id;
        $apps = KruApplication::leftJoin('vessels', 'kru_applications.vessel_id', '=', 'vessels.id')
        ->where('kru_application_type_id', $appTypeId)
        ->where('kru_applications.user_id',$request->user()->id)
        ->select('kru_applications.id','reference_number','no_pendaftaran','kru_applications.entity_id','kru_application_status_id','kru_applications.created_at')->sortable();

        return view('app.kru.kru06.index', [
            'applications' => $request->has('sort') ? $apps->paginate(10) : $apps->orderBy('kru_applications.created_at','DESC')->paginate(10),
            'statusDisimpanId' => $statusDisimpanId,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $kru05Id = KruApplicationType::where('code','KRU05')->first()->id;
        $kru06Id = KruApplicationType::where('code','KRU06')->first()->id;
        $kru07Id = KruApplicationType::where('code','KRU07')->first()->id;

        $usedPermissionIds = KruApplication::leftJoin('kru_application_foreigns', 'kru_applications.id', '=', 'kru_application_foreigns.kru_application_id')->where('kru_application_type_id', $kru06Id)->where('permission_application_id','!=',null)->get()->pluck('permission_application_id')->unique()->toArray();

        $permissionLetters = KruApplication::where('user_id',$user->id)->whereIn('kru_application_type_id', [$kru05Id,$kru07Id])->where('is_approved',true)->whereNotIn('id',$usedPermissionIds)->get();

        return view('app.kru.kru06.create', [
            'vessels' => Vessel::where('user_id',$user->id)->whereIn('zon',['C','C2'])->orderBy('no_pendaftaran')->get(),
            'permissionLetters' => $permissionLetters,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $helper = new Helper();

            //Initiated required data
            $appType = KruApplicationType::where('code','KRU06')->first();
            $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DISIMPAN');

            //get vessel's entity (pejabat perikanan daerah)
            $approvalType = $request->selApprovalType;
            $permissionLetterId = $request->selLetter;
            // $plksEndDate = $request->txtDate;

            $appLetter = KruApplication::find($permissionLetterId);
            $appLetterForeign = KruApplicationForeign::where('kru_application_id',$appLetter->id)->first();
            $appLetterForeignKrus = KruApplicationForeignKru::where('kru_application_id',$appLetter->id)->get();
            $appDocuments = KruApplicationDocument::where('kru_application_id',$appLetter->id)->get();
            $vessel = Vessel::find($appLetter->vessel_id);
            // $vessel_entity = Vessel::find($request->selVessel)->entity_id;

            //create new application
            $app = new KruApplication();
            $app->kru_application_type_id = $appType->id;
            $app->user_id = $request->user()->id;
            $app->kru_application_status_id = $status_id;
            $app->vessel_id = $vessel->id;
            $app->application_type = $approvalType;
            $app->created_by = Auth::id();
            $app->updated_by = Auth::id();
            $app->save();

            $appForeign = new KruApplicationForeign();
            $appForeign->kru_application_id = $app->id;
            // $appForeign->plks_end_date = $plksEndDate;
            $appForeign->permission_application_id = $appLetter->id;
            $appForeign->immigration_office_id = $appLetterForeign->immigration_office_id;
            $appForeign->immigration_date = $appLetterForeign->immigration_date;
            $appForeign->immigration_gate_id = $appLetterForeign->immigration_gate_id;
            $appForeign->crew_placement = $appLetterForeign->crew_placement;
            $appForeign->supervised = $appLetterForeign->supervised;
            $appForeign->created_by = Auth::id();
            $appForeign->updated_by = Auth::id();
            $appForeign->save();

            foreach ($appLetterForeignKrus as $fk) {
                $foreignKru = new KruApplicationForeignKru();
                $foreignKru->kru_application_id = $app->id;
                $foreignKru->passport_number = $fk->passport_number;
                $foreignKru->passport_end_date = $fk->passport_end_date;
                $foreignKru->name = $fk->name;
                $foreignKru->birth_date = $fk->birth_date;
                $foreignKru->gender_id = $fk->gender_id;
                $foreignKru->source_country_id = $fk->source_country_id;
                $foreignKru->foreign_kru_position_id = $fk->foreign_kru_position_id;
                $foreignKru->crew_whereabout = $fk->crew_whereabout;
                $foreignKru->created_by = Auth::id();
                $foreignKru->updated_by = Auth::id();
                $foreignKru->save();
            }

            foreach ($appDocuments as $doc) {
                $kruAppDoc = new KruApplicationDocument();
                $kruAppDoc->kru_application_id = $app->id;
                $kruAppDoc->file_name = $doc->file_name;
                $kruAppDoc->file_path = $doc->file_path;
                $kruAppDoc->description = $doc->description;
				$kruAppDoc->created_by = $request->user()->id;
                $kruAppDoc->updated_by = $request->user()->id;
                $kruAppDoc->save();
            }

            $audit_details = json_encode([
                'vessel_id' => $request->selVessel,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru06', 'create', $audit_details);
            DB::commit();
            return redirect()->route('kelulusanpenggunaankrubukanwarganegara.permohonan.editB', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
                'vessel_id' => $request->selVessel,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru06', 'create', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        $vessel = Vessel::withTrashed()->find($app->vessel_id);
        $vesselOwner = User::withTrashed()->select('id','name')->find($vessel->user_id);
        $appForeign = KruApplicationForeign::where('kru_application_id',$id)->latest()->first();
        $foreignKrus = KruApplicationForeignKru::where('kru_application_id',$id)->orderBy('created_at','ASC')->get();
        //---------------------start vessel-------------------
        $vessels = Vessel::where('user_id',$vesselOwner->id)->whereIn('zon',['C','C2'])->orderBy('no_pendaftaran')->get();
        //-----------------------end vessel-------------------
        //---------------------start document------------------
        $docs = KruApplicationDocument::where('kru_application_id',$id)->latest()->get();
        //----------------------end document-------------------
        
        $statusApprovedId = $helper->getCodeMasterIdByTypeName('kru_application_status','DILULUS');
        $statusRejectedId = $helper->getCodeMasterIdByTypeName('kru_application_status','DITOLAK');
        $statusIncompleteId = $helper->getCodeMasterIdByTypeName('kru_application_status','TIDAK LENGKAP');
        $rejectedLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->where('kru_application_status_id',$statusRejectedId)->latest('updated_at')->first();
        $incompleteLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->where('kru_application_status_id',$statusIncompleteId)->latest('updated_at')->first();

        $decisionStatusIds = CodeMaster::where('type','kru_application_status') //used at decision to enable/disable tab
        ->whereIn('name',[
            'DILULUS',
        ])->select('id')->get();
        
        
        $appPermission = KruApplication::find($appForeign->permission_application_id);
        
        $kru05Id = KruApplicationType::where('code','KRU05')->first()->id;
        $kru07Id = KruApplicationType::where('code','KRU07')->first()->id;

        return view('app.kru.kru06.show', [
            'id' => $id,
            'app' => $app,
            'appForeign' => $appForeign,
            'appPermission' => $appPermission,
            'vessel' => $vessel,
            'vesselOwner' => $vesselOwner,
            'foreignKrus' => $foreignKrus,
            //------------start vessel--------------
            'vessels' => $vessels,
            //-------------end vessel---------------
            //-----------start document-------------
            'docs' => $docs,
            //------------end document--------------
            'rejectedLog' => $rejectedLog,
            'incompleteLog' => $incompleteLog,
            //-----------start decision------------
            'decisionStatusIds' => $decisionStatusIds,
            //------------end decision-------------
            'statusApprovedId' => $statusApprovedId,
            'statusRejectedId' => $statusRejectedId,
            'statusIncompleteId' => $statusIncompleteId,
            
            
            'passportDocName' => KruForeignDocument::DOC_PASSPORT_PLKS,
            'kru05Id' => $kru05Id,
            'kru07Id' => $kru07Id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);

        return view('app.kru.kru06.edit', [
            'id' => $id,
            'app' => $app,
            'vessels' => Vessel::where('user_id',$user->id)->whereIn('zon',['C','C2'])->orderBy('no_pendaftaran')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editB(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        $appForeign = KruApplicationForeign::where('kru_application_id',$id)->latest()->first();
        $appPermission = KruApplication::find($appForeign->permission_application_id);
        $vessel = Vessel::withTrashed()->find($app->vessel_id);
        $vesselOwner = User::withTrashed()->select('name')->find($vessel->user_id);
        
        $kru05Id = KruApplicationType::where('code','KRU05')->first()->id;
        $kru07Id = KruApplicationType::where('code','KRU07')->first()->id;

        return view('app.kru.kru06.editB', [
            'id' => $id,
            'app' => $app,
            'appForeign' => $appForeign,
            'appPermission' => $appPermission,
            'vessel' => $vessel,
            'vesselOwner' => $vesselOwner,
            'imigresenOffices' => ImmigrationOffice::orderBy('name')->get(),
            'imigresenGates' => ImmigrationGate::orderBy('name')->get(),
            'kru05Id' => $kru05Id,
            'kru07Id' => $kru07Id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editC(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        $appForeign = KruApplicationForeign::where('kru_application_id',$id)->latest()->first();
        $vessel = Vessel::withTrashed()->find($app->vessel_id);
        $foreignKrus = KruApplicationForeignKru::where('kru_application_id',$id)->orderBy('created_at','ASC')->get();

        return view('app.kru.kru06.editC', [
            'id' => $id,
            'app' => $app,
            'appForeign' => $appForeign,
            'vessel' => $vessel,
            'foreignKrus' => $foreignKrus,
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function editCAddKru(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $foreignKru = KruApplicationForeignKru::find($id);
        // $app = KruApplication::find($id);
        // $appForeign = KruApplicationForeign::where('kru_application_id',$id)->latest()->first();
        $docPassport = KruForeignDocument::where('kru_application_foreign_kru_id',$id)->where('description',KruForeignDocument::DOC_PASSPORT_PLKS)->first();

        return view('app.kru.kru06.editCAddKru', [
            'id' => $foreignKru->kru_application_id,
            'foreignKru' => $foreignKru,
            // 'app' => $app,
            // 'appForeign' => $appForeign,
            'genders' => $helper->getCodeMastersByType('gender'),
            'positions' => $helper->getCodeMastersByType('foreign_kru_position'),
            'docPassport' => $docPassport,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editD(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        
        $docIc = KruApplicationDocument::where('kru_application_id',$id)->where('description',KruApplicationDocument::DOC_IC)->latest()->first();
        $docSsm = KruApplicationDocument::where('kru_application_id',$id)->where('description',KruApplicationDocument::DOC_PENDAFTARAN_SYARIKAT)->latest()->first();
        $docPenggajian = KruApplicationDocument::where('kru_application_id',$id)->where('description',KruApplicationDocument::DOC_PENGGAJIAN)->latest()->first();
        // $docPassportPLKS = KruApplicationDocument::where('kru_application_id',$id)->where('description',KruApplicationDocument::DOC_PASSPORTS_PLKS)->latest()->first();

        return view('app.kru.kru06.editD', [
            'id' => $id,
            'app' => $app,
            
            'docIc' => $docIc,
            'docSsm' => $docSsm,
            'docPenggajian' => $docPenggajian,
            // 'docPassportPLKS' => $docPassportPLKS,
        ]);
    }

    public function editE(string $id)
    {
        $helper = new Helper();
        // $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        $statusIncompleteId = $helper->getCodeMasterIdByTypeName('kru_application_status','TIDAK LENGKAP');

        return view('app.kru.kru06.editE', [
            'id' => $id,
            'app' => $app,
            'statusIncompleteId' => $statusIncompleteId,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $selKrus = $request->selKrus;
        if($selKrus==null){
            return redirect()->back()->with('alert', 'Permohonan Perlu Minimun Seorang Kru Dipilih untuk Dibatalkan !!');
        }
        DB::beginTransaction();

        try {
            $app = KruApplication::find($id);
            $app->updated_by = Auth::id();
            $app->save();

            //delete already selected kru from before if any
            $appKrus = KruApplicationKru::where('kru_application_id',$id)->get();
            foreach ($appKrus as $appKru) {
                $appKru->deleted_by = Auth::id();
                $appKru->save();
                $appKru->delete();
            }

            //add selected kru
            foreach ($selKrus as $selKru) {
                $nelayan = NelayanMarin::find($selKru);

                //search if there are any deleted kru
                $appKru = KruApplicationKru::withTrashed()->where('kru_application_id',$app->id)->where('ic_number',$nelayan->ic_number)->first();
                if($appKru == null){
                    $appKru = new KruApplicationKru();
                    $appKru->kru_application_id = $app->id;
                    $appKru->ic_number = $nelayan->ic_number;
                    $appKru->name = $nelayan->name;
                    $appKru->created_by = Auth::id();
                    $appKru->updated_by = Auth::id();
                    $appKru->save();
                    
                    $kruOriginalDocs = KruDocument::where('kru_application_kru_id',$nelayan->kru_application_kru_id)->whereIn('description',[KruDocument::DOC_IC,KruDocument::DOC_PIC])->get();
                    if(!$kruOriginalDocs->isEmpty()){
                        foreach ($kruOriginalDocs as $kruOriginalDoc) {
                            $doc = new KruDocument();
                            $doc->kru_application_kru_id = $appKru->id;
                            $doc->file_name = $kruOriginalDoc->file_name;
                            $doc->file_path = $kruOriginalDoc->file_path;
                            $doc->description = $kruOriginalDoc->description;
                            $doc->created_by = $request->user()->id;
                            $doc->updated_by = $request->user()->id;
                            $doc->save();
                        }
                    }
                }
                else{
                    $appKru->deleted_by = null;
                    $appKru->deleted_at = null;
                    $appKru->created_by = Auth::id();
                    $appKru->updated_by = Auth::id();
                    $appKru->save();
                }
            }

            $audit_details = json_encode([
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru04', 'edit', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru04', 'edit', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('kelulusanpenggunaankrubukanwarganegara.permohonan.editF', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateB(Request $request, string $id)
    {
        // $selKrus = $request->selKrus;
        // if($selKrus==null){
        //     return redirect()->back()->with('alert', 'Permohonan Perlu Minimun Seorang Kru Dipilih untuk Dibatalkan !!');
        // }
        DB::beginTransaction();

        try {
            $app = KruApplication::find($id);
            $app->updated_by = Auth::id();
            $app->save();

            $kruAppForeign = KruApplicationForeign::where('kru_application_id',$id)->latest()->first();
            if($kruAppForeign==null){
                $kruAppForeign = new KruApplicationForeign();
                $kruAppForeign->kru_application_id = $id;
                $kruAppForeign->created_by = Auth::id();
            }
            $kruAppForeign->immigration_office_id = $request->selOffice;
            $kruAppForeign->immigration_date = $request->txtDate;
            $kruAppForeign->immigration_gate = strtoupper($request->txtGate);
            $kruAppForeign->updated_by = Auth::id();
            $kruAppForeign->save();

            $audit_details = json_encode([
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru05', 'editB', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru05', 'editB', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('kelulusanpenggunaankrubukanwarganegara.permohonan.editC', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateC(Request $request, string $id)
    {
        // $selKrus = $request->selKrus;
        // if($selKrus==null){
        //     return redirect()->back()->with('alert', 'Permohonan Perlu Minimun Seorang Kru Dipilih untuk Dibatalkan !!');
        // }
        DB::beginTransaction();

        try {
            $app = KruApplication::find($id);
            $app->updated_by = Auth::id();
            $app->save();
                
            //reset all kru
            $appKrus = KruApplicationForeignKru::where('kru_application_id',$id)->get();
            foreach ($appKrus as $appKru) {
                $appKru->has_plks = false;
                $appKru->updated_by = Auth::id();
                $appKru->save();
            }

            //check plks selected kru
            $selKrus = $request->selKrus;
            if($selKrus != null){
                foreach ($selKrus as $selKru) {
                    $appKru = KruApplicationForeignKru::find($selKru);
                    $appKru->has_plks = true;
                    $appKru->updated_by = Auth::id();
                    $appKru->save();
                }
            }

            $audit_details = json_encode([
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru06', 'editC', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru06', 'editC', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('kelulusanpenggunaankrubukanwarganegara.permohonan.editC', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCAddKru(Request $request, string $id)
    {
        // $selKrus = $request->selKrus;
        // if($selKrus==null){
        //     return redirect()->back()->with('alert', 'Permohonan Perlu Minimun Seorang Kru Dipilih untuk Dibatalkan !!');
        // }
        
        // $request->validate(
        //     [
        //         'passportDoc' => 'mimes:jpg,bmp,png',
        //     ],
        //     [
        //         'passportDoc.mimes' => 'Jenis file dibenarkan adalah jpg,png,bmp.',
        //     ]);
        DB::beginTransaction();

        try {

            // $kruAppForeignKru = KruApplicationForeignKru::withTrashed()->where('kru_application_id', $id)->whereRaw('UPPER(passport_number) = ?', [strtoupper($request->passport)])->first();
            $kruAppForeignKru = KruApplicationForeignKru::find($id);
            // if($kruAppForeignKru == null){
            //     $kruAppForeignKru = new KruApplicationForeignKru();
            //     $kruAppForeignKru->kru_application_id = $id;
            //     $kruAppForeignKru->passport_number = strtoupper($request->passport);
            //     $kruAppForeignKru->created_by = Auth::id();
            // }
            // else{
            //     $kruAppForeignKru->deleted_at = null;
            //     $kruAppForeignKru->deleted_by = null;
            //     $kruAppForeignKru->created_at = Carbon::now()->toDateTimeString();
            // }
            // $kruAppForeignKru->name = strtoupper($request->name);
            // $kruAppForeignKru->birth_date = $request->birthDate;
            // $kruAppForeignKru->gender_id = $request->gender;
            // $kruAppForeignKru->nationality = strtoupper($request->nationality);
            // $kruAppForeignKru->foreign_kru_position_id = $request->position;
            // $kruAppForeignKru->crew_whereabout = strtoupper($request->kruWhereabout);
            $kruAppForeignKru->plks_number = strtoupper($request->plksNo);
            $kruAppForeignKru->plks_end_date = $request->plksEndDate;
            $kruAppForeignKru->updated_by = Auth::id();
            $kruAppForeignKru->save();
            
            $app = KruApplication::find($kruAppForeignKru->kru_application_id);
            $app->updated_by = Auth::id();
            $app->save();
            
            if ($request->file('passportDoc')) {

                $file = $request->file('passportDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('passportDoc')->store('public/kru/kruforeigndoc');

                $doc = KruForeignDocument::where('kru_application_foreign_kru_id',$id)->where('description',KruForeignDocument::DOC_PASSPORT_PLKS)->first();
                if($doc!=null){
                    $doc->deleted_by = $request->user()->id;
                    $doc->save();
                    $doc->delete();
                }
                $doc = new KruForeignDocument();
                $doc->kru_application_foreign_kru_id = $kruAppForeignKru->id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = KruForeignDocument::DOC_PASSPORT_PLKS;
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }


            $audit_details = json_encode([
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru06', 'editCAddKru', $audit_details);
            DB::commit();
            
            return redirect()->route('kelulusanpenggunaankrubukanwarganegara.permohonan.editC', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru06', 'editCAddKru', $audit_details, $e->getMessage());

            return redirect()->back()->withInput()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    // public function updateD(Request $request, string $id)
    // {
    //     // $request->validate(
    //     // [
    //     //     'kruPic' => 'mimes:jpg,bmp,png',
    //     // ],
    //     // [
    //     //     'kruPic.mimes' => 'Jenis file dibenarkan adalah jpg,png,bmp.',
    //     // ]);

    //     DB::beginTransaction();

    //     try {
    //         $app = KruApplication::find($id);
    //         $app->updated_by = Auth::id();
    //         $app->save();

    //         $path='';
    //         if ($request->file('kadPengenalanDoc')) {
                
    //             $audit_details = json_encode([
    //             ]);

    //             $auditLog = new AuditLog();
    //             $auditLog->log('kru05', 'editD', $audit_details);

    //             $file = $request->file('kadPengenalanDoc');
    //             $file_replace = str_replace(' ', '', $file->getClientOriginalName());
    //             $filename = $file_replace;
    //             $path = $request->file('kadPengenalanDoc')->store('public/kru');

    //             $doc = new KruApplicationDocument();
    //             $doc->kru_application_id = $app->id;
    //             $doc->file_name = $filename;
    //             $doc->file_path = $path;
    //             $doc->description = KruApplicationDocument::DOC_IC;
	// 			$doc->created_by = $request->user()->id;
    //             $doc->updated_by = $request->user()->id;
    //             $doc->save();
    //         }
    //         if ($request->file('ssmDoc')) {

    //             $file = $request->file('ssmDoc');
    //             $file_replace = str_replace(' ', '', $file->getClientOriginalName());
    //             $filename = $file_replace;
    //             $path = $request->file('ssmDoc')->store('public/kru');

    //             $doc = new KruApplicationDocument();
    //             $doc->kru_application_id = $app->id;
    //             $doc->file_name = $filename;
    //             $doc->file_path = $path;
    //             $doc->description = KruApplicationDocument::DOC_SSM;
	// 			$doc->created_by = $request->user()->id;
    //             $doc->updated_by = $request->user()->id;
    //             $doc->save();
    //         }
    //         if ($request->file('penggajianDoc')) {

    //             $file = $request->file('penggajianDoc');
    //             $file_replace = str_replace(' ', '', $file->getClientOriginalName());
    //             $filename = $file_replace;
    //             $path = $request->file('penggajianDoc')->store('public/kru');

    //             $doc = new KruApplicationDocument();
    //             $doc->kru_application_id = $app->id;
    //             $doc->file_name = $filename;
    //             $doc->file_path = $path;
    //             $doc->description = KruApplicationDocument::DOC_PENGGAJIAN;
	// 			$doc->created_by = $request->user()->id;
    //             $doc->updated_by = $request->user()->id;
    //             $doc->save();
    //         }
    //         if ($request->file('passportDoc')) {

    //             $file = $request->file('passportDoc');
    //             $file_replace = str_replace(' ', '', $file->getClientOriginalName());
    //             $filename = $file_replace;
    //             $path = $request->file('passportDoc')->store('public/kru');

    //             $doc = new KruApplicationDocument();
    //             $doc->kru_application_id = $app->id;
    //             $doc->file_name = $filename;
    //             $doc->file_path = $path;
    //             $doc->description = KruApplicationDocument::DOC_PASSPORTS_PLKS;
	// 			$doc->created_by = $request->user()->id;
    //             $doc->updated_by = $request->user()->id;
    //             $doc->save();
    //         }

    //         $audit_details = json_encode([
    //         ]);
    //         $auditLog = new AuditLog();
    //         $auditLog->log('kru05', 'editD', $audit_details);
    //         DB::commit();
    //     }
    //     catch (Exception $e) {
    //         DB::rollback();
    //         $audit_details = json_encode([
    //         ]);

    //         $auditLog = new AuditLog();
    //         $auditLog->log('kru05', 'editD', $audit_details, $e->getMessage());

    //         return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
    //     }
    //     return redirect()->route('kelulusanpenggunaankrubukanwarganegara.permohonan.editE', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
    // }

    public function updateE(Request $request, string $id)
    {
        $app = KruApplication::find($id);
        $app->updated_by = Auth::id();
        $app->save();

        // $docs = KruApplicationDocument::where('kru_application_id',$app->id)->get();
        // if(!($docs->contains('description', KruApplicationDocument::DOC_IC) || $docs->contains('description', KruApplicationDocument::DOC_PENDAFTARAN_SYARIKAT))){
        //     return redirect()->back()->with('alert', 'Perlukan Dokumen SALINAN KAD PENGENALAN MAJIKAN atau SALINAN SIJIL SURUHANJAYA SYARIKAT MALAYSIA!!');
        // }
        // elseif(!$docs->contains('description', KruApplicationDocument::DOC_PENGGAJIAN)){
        //     return redirect()->back()->with('alert', 'Perlukan Dokumen SALINAN KELULUSAN PENGGAJIAN PEKERJA ASING!!');
        // }
        // elseif(!$docs->contains('description', KruApplicationDocument::DOC_PASSPORTS_PLKS)){
        //     return redirect()->back()->with('alert', 'Perlukan Dokumen SALINAN PASPORT KRU!!');
        // }

        DB::beginTransaction();

        try {
            $helper = new Helper();
            $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DIHANTAR');

            $app = KruApplication::find($id);
            $veselEntity = Vessel::find($app->vessel_id)->entity_id;

            $app->kru_application_status_id = $status_id;
            $app->entity_id = $veselEntity;
            if($app->submitted_at == null){
                $app->submitted_at = Carbon::now()->toDateTimeString();
            }
            if($app->reference_number == null){
                $refNum = new ReferenceNumber();
                $app->reference_number = $refNum->generateReferenceNumber($request->user()->id);
            }
            $app->updated_by = Auth::id();
            $app->save();
            
            $appLog = new KruApplicationLog();
            $appLog->kru_application_id =  $id;
            $appLog->kru_application_status_id = $status_id;
            $appLog->remark	= 'Pemohon';
            $appLog->created_by = Auth::id();
            $appLog->updated_by = Auth::id();
            $appLog->save();

            $audit_details = json_encode([
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru06', 'editE', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru06', 'editE', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal dihantar !!');
        }
        return redirect()->route('kelulusanpenggunaankrubukanwarganegara.permohonan.index')->with('alert', 'Permohonan berjaya dihantar !!');
    }

    public function deleteKru(Request $request, string $id)
    {
        DB::beginTransaction();

        try 
        {
            //Update status in table applications
            $appKru = KruApplicationForeignKru::find($id);
            $appKru->deleted_by=$request->user()->id;
			$appKru->save();
			$appKru->delete();

            DB::commit();

            return redirect()->back()->with('alert', 'Kru berjaya dihapus !!');
        }
        catch (Exception $e) {

            DB::rollback();
            return redirect()->back()->with('alert', 'Kru gagal dihapus !!');
        }
    }
    
    //Export approval letter PDF
    public function exportApprovalLetter(Request $request, $id) 
    {
        $app = KruApplication::find($id);
        $appForeign = KruApplicationForeign::where('kru_application_id',$id)->first();
        $vessel = Vessel::find($app->vessel_id);
        $foreignKrus = KruApplicationForeignKru::where('kru_application_id',$id)->where('selected_for_approval',true)->get();
        

        $owner = User::find($vessel->user_id);
        $allVessel = Vessel::where('user_id',$owner->id)->get();
        $vesselIds = Vessel::where('user_id',$owner->id)->select('id')->get()->pluck('id')->toArray();
        $foreignCrews = ForeignCrew::whereIn('vessel_id',$vesselIds)->get();

        $data = [
            'immigrationOffice' => ImmigrationOffice::find($appForeign->immigration_office_id)->name,
            'owner' => $owner->name,

            'vessel' => $vessel,
            // 'foreignCrews' => $foreignCrews,
            'foreignCrews' => $foreignKrus,

            'immigrationDate' => optional($appForeign->immigration_date)->format('d-m-Y'),
            'immigrationGate' => strtoupper($appForeign->immigration_gate),
            'entity' => Entity::find($app->entity_id),

            'allVessel' => $allVessel,
        ];

        $pdf = Pdf::loadView('app.kru.kru06.approvalletterpdf', $data);
        $pdf->setPaper('letter');//setPaper('A4', 'portrait');
        $pdf->getDomPDF()->set_option('enable_php', true);

        // View on page
        return $pdf->stream('suratkelulusan_'.$app->reference_number.'.pdf');
    }
}
