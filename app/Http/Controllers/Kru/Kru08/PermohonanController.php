<?php

namespace App\Http\Controllers\Kru\Kru08;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Entity;
use App\Models\Helper;
use App\Models\Kru\ForeignCrew;
use App\Models\Kru\ImmigrationOffice;
use App\Models\Kru\KruApplication;
use App\Models\Kru\KruApplicationDocument;
use App\Models\Kru\KruApplicationForeign;
use App\Models\Kru\KruApplicationForeignKru;
use App\Models\Kru\KruApplicationLog;
use App\Models\Kru\KruApplicationType;
use App\Models\Kru\KruForeignDocument;
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

        $appTypeId = KruApplicationType::where('code','KRU08')->first()->id;
        $apps = KruApplication::leftJoin('vessels', 'kru_applications.vessel_id', '=', 'vessels.id')
        ->where('kru_application_type_id', $appTypeId)
        ->where('kru_applications.user_id',$request->user()->id)
        ->select('kru_applications.id','reference_number','no_pendaftaran','kru_applications.entity_id','kru_application_status_id','kru_applications.created_at')->sortable();

        return view('app.kru.kru08.index', [
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

        return view('app.kru.kru08.create', [
            'vessels' => Vessel::where('user_id',$user->id)->whereIn('zon',['C','C2'])->orderBy('no_pendaftaran')->get(),
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
            $appType = KruApplicationType::where('code','KRU08')->first();
            $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DISIMPAN');

            //get vessel's entity (pejabat perikanan daerah)
            $vessel_entity = Vessel::find($request->selVessel)->entity_id;

            //create new application
            $app = new KruApplication();
            $app->kru_application_type_id = $appType->id;
            $app->user_id = $request->user()->id;
            $app->kru_application_status_id = $status_id;
            $app->vessel_id = $request->selVessel;
            $app->entity_id = $vessel_entity;
            $app->created_by = Auth::id();
            $app->updated_by = Auth::id();
            $app->save();

            $audit_details = json_encode([
                'vessel_id' => $request->selVessel,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru08', 'create', $audit_details);
            DB::commit();
            return redirect()->route('pembatalanpenggunaankrubukanwarganegara.permohonan.editB', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
                'vessel_id' => $request->selVessel,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru08', 'create', $audit_details, $e->getMessage());

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
        return view('app.kru.kru08.show', [
            'id' => $id,
            'app' => $app,
            'appForeign' => $appForeign,
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
            
            'passportDocName' => KruForeignDocument::DOC_PASSPORT,
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

        return view('app.kru.kru08.edit', [
            'id' => $id,
            'app' => $app,
            'vessels' => Vessel::where('user_id',$user->id)->whereIn('zon',['C','C2'])->orderBy('no_pendaftaran')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function editB(string $id)
    // {
    //     $helper = new Helper();
    //     $user = User::find(Auth::id());
    //     $app = KruApplication::find($id);
    //     $appForeign = KruApplicationForeign::where('kru_application_id',$id)->latest()->first();
    //     $vessel = Vessel::withTrashed()->find($app->vessel_id);
    //     $vesselOwner = User::withTrashed()->select('name')->find($vessel->user_id);
    //     $immigrationGates = $helper->getCodeMastersByTypeOrder('immigration_gate');

    //     return view('app.kru.kru08.editB', [
    //         'id' => $id,
    //         'app' => $app,
    //         'appForeign' => $appForeign,
    //         'vessel' => $vessel,
    //         'vesselOwner' => $vesselOwner,
    //         'imigresenOffices' => ImmigrationOffice::orderBy('name')->get(),
    //         'imigresenGates' => $immigrationGates,
    //     ]);
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function editB(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        $appForeign = KruApplicationForeign::where('kru_application_id',$id)->latest()->first();
        $vessel = Vessel::withTrashed()->find($app->vessel_id);
        $foreignCrews = ForeignCrew::where('vessel_id',$app->vessel_id)->orderBy('created_at','ASC')->get();
        $selectedCrews = KruApplicationForeignKru::where('kru_application_id',$id)->select('passport_number','revocation_reason')->get();

        return view('app.kru.kru08.editB', [
            'id' => $id,
            'app' => $app,
            'appForeign' => $appForeign,
            'vessel' => $vessel,
            'foreignCrews' => $foreignCrews,
            'selectedCrews' => $selectedCrews,
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function editCAddKru(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        $appForeign = KruApplicationForeign::where('kru_application_id',$id)->latest()->first();
        $sourceCountries = $helper->getCodeMastersByType('source_country');

        return view('app.kru.kru08.editCAddKru', [
            'id' => $id,
            'app' => $app,
            'appForeign' => $appForeign,
            'genders' => $helper->getCodeMastersByType('gender'),
            'positions' => $helper->getCodeMastersByType('foreign_kru_position'),
            'sourceCountries' => $sourceCountries,
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
        // $docPassport = KruApplicationDocument::where('kru_application_id',$id)->where('description',KruApplicationDocument::DOC_PASSPORTS)->latest()->first();

        return view('app.kru.kru08.editD', [
            'id' => $id,
            'app' => $app,
            
            'docIc' => $docIc,
            'docSsm' => $docSsm,
            'docPenggajian' => $docPenggajian,
            // 'docPassport' => $docPassport,
        ]);
    }

    public function editE(string $id)
    {
        $helper = new Helper();
        // $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        $statusIncompleteId = $helper->getCodeMasterIdByTypeName('kru_application_status','TIDAK LENGKAP');

        return view('app.kru.kru08.editE', [
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
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateB(Request $request, string $id)
    {
        $selKrus = $request->selKrus;
        $reasons = $request->reasons;
        if($selKrus==null){
            return redirect()->back()->with('alert', 'Permohonan Perlu Minimun Seorang Kru Dipilih untuk Dibatalkan !!');
        }
        DB::beginTransaction();

        try {
            $app = KruApplication::find($id);
            $app->updated_by = Auth::id();
            $app->save();

            //delete already selected kru from before if any
            $appKrus = KruApplicationForeignKru::where('kru_application_id',$id)->get();
            foreach ($appKrus as $appKru) {
                $appKru->deleted_by = Auth::id();
                $appKru->save();
                $appKru->delete();
            }

            //add selected kru
            for( $i = 0; $i < count($selKrus); $i++) {
                $nelayan = ForeignCrew::find($selKrus[$i]);

                //search if there are any deleted kru
                $appKru = KruApplicationForeignKru::withTrashed()->where('kru_application_id',$app->id)->where('passport_number',$nelayan->passport_number)->first();
                if($appKru == null){
                    $appKru = new KruApplicationForeignKru();
                    $appKru->kru_application_id = $app->id;
                    $appKru->passport_number = $nelayan->passport_number;
                    $appKru->passport_end_date = $nelayan->passport_end_date;
                    // $appKru->plks_end_date = $nelayan->plks_end_date;
                    $appKru->name = $nelayan->name;
                    $appKru->birth_date = $nelayan->birth_date;
                    $appKru->gender_id = $nelayan->gender_id;
                    $appKru->source_country_id = $nelayan->source_country_id;
                    $appKru->foreign_kru_position_id = $nelayan->foreign_kru_position_id;
                    if($reasons!=null && count($reasons) == count($selKrus))
                        $appKru->revocation_reason = $reasons[$i];
                    $appKru->created_by = Auth::id();
                    $appKru->updated_by = Auth::id();
                    $appKru->save();
                }
                else{
                    $appKru->passport_end_date = $nelayan->passport_end_date;
                    // $appKru->plks_end_date = $nelayan->plks_end_date;
                    $appKru->name = $nelayan->name;
                    $appKru->birth_date = $nelayan->birth_date;
                    $appKru->gender_id = $nelayan->gender_id;
                    $appKru->source_country_id = $nelayan->source_country_id;
                    $appKru->foreign_kru_position_id = $nelayan->foreign_kru_position_id;
                    if($reasons!=null && count($reasons) == count($selKrus))
                        $appKru->revocation_reason = $reasons[$i];
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
            $auditLog->log('kru08', 'editB', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru08', 'editB', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('pembatalanpenggunaankrubukanwarganegara.permohonan.editB', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCAddKru(Request $request, string $id)
    {
        
        $request->validate(
            [
                'passportDoc' => 'mimes:jpg,bmp,png',
            ],
            [
                'passportDoc.mimes' => 'Jenis file dibenarkan adalah jpg,png,bmp.',
            ]);

        $helper = new Helper();
        DB::beginTransaction();

        try {
            //start validation checking
            $positionId = $request->position;
            $taikongId = $helper->getCodeMasterIdByTypeName('foreign_kru_position','KAPTEN / TAIKONG');
            $filipinaId = $helper->getCodeMasterIdByTypeName('source_country','FILIPINA');
            $femaleId = $helper->getCodeMasterIdByTypeName('gender','PEREMPUAN');
            $date = Carbon::parse($request->birthDate);
            $age = $date->age;
            if($age<18){
                DB::rollback();
                return redirect()->back()->withInput()->with('alert', 'Kru perlu berumur 18 tahun keatas !!');
            }
            elseif(($age>60) && ($positionId!=$taikongId)){
                DB::rollback();
                return redirect()->back()->withInput()->with('alert', 'Kru perlu berumur dibawah 60 tahun !!');
            }
            elseif($request->nationality == $filipinaId && $request->gender == $femaleId){
                DB::rollback();
                return redirect()->back()->withInput()->with('alert', 'Hanya Kru lelaki sahaja boleh dibawa masuk dari FILIPINA !!');
            }
            //end validation checking

            $app = KruApplication::find($id);
            $app->updated_by = Auth::id();
            $app->save();

            $kruAppForeignKru = KruApplicationForeignKru::withTrashed()->where('kru_application_id', $id)->whereRaw('UPPER(passport_number) = ?', [strtoupper($request->passport)])->first();
            if($kruAppForeignKru == null){
                $kruAppForeignKru = new KruApplicationForeignKru();
                $kruAppForeignKru->kru_application_id = $id;
                $kruAppForeignKru->passport_number = strtoupper($request->passport);
                $kruAppForeignKru->created_by = Auth::id();
            }
            else{
                $kruAppForeignKru->deleted_at = null;
                $kruAppForeignKru->deleted_by = null;
                $kruAppForeignKru->created_at = Carbon::now()->toDateTimeString();
            }
            $kruAppForeignKru->name = strtoupper($request->name);
            $kruAppForeignKru->source_country_id = $request->nationality;
            $kruAppForeignKru->birth_date = $request->birthDate;
            $kruAppForeignKru->gender_id = $request->gender;
            $kruAppForeignKru->foreign_kru_position_id = $request->position;
            $kruAppForeignKru->crew_whereabout = strtoupper($request->kruWhereabout);
            $kruAppForeignKru->passport_end_date = $request->passportEndDate;
            $kruAppForeignKru->updated_by = Auth::id();
            $kruAppForeignKru->save();

            if ($request->file('passportDoc')) {

                $file = $request->file('passportDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('passportDoc')->store('public/kru/kruforeigndoc');

                $doc = new KruForeignDocument();
                $doc->kru_application_foreign_kru_id = $kruAppForeignKru->id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = KruForeignDocument::DOC_PASSPORT;
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }

            $audit_details = json_encode([
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru05', 'editCAddKru', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru05', 'editCAddKru', $audit_details, $e->getMessage());

            return redirect()->back()->withInput()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('pembatalanpenggunaankrubukanwarganegara.permohonan.editC', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateD(Request $request, string $id)
    {
        // $request->validate(
        // [
        //     'kruPic' => 'mimes:jpg,bmp,png',
        // ],
        // [
        //     'kruPic.mimes' => 'Jenis file dibenarkan adalah jpg,png,bmp.',
        // ]);

        DB::beginTransaction();

        try {
            $app = KruApplication::find($id);
            $app->updated_by = Auth::id();
            $app->save();

            $path='';
            if ($request->file('kadPengenalanDoc')) {
                
                $audit_details = json_encode([
                ]);

                $auditLog = new AuditLog();
                $auditLog->log('kru05', 'editD', $audit_details);

                $file = $request->file('kadPengenalanDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('kadPengenalanDoc')->store('public/kru');

                $doc = new KruApplicationDocument();
                $doc->kru_application_id = $app->id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = KruApplicationDocument::DOC_IC;
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }
            if ($request->file('ssmDoc')) {

                $file = $request->file('ssmDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('ssmDoc')->store('public/kru');

                $doc = new KruApplicationDocument();
                $doc->kru_application_id = $app->id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = KruApplicationDocument::DOC_PENDAFTARAN_SYARIKAT;
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }
            if ($request->file('penggajianDoc')) {

                $file = $request->file('penggajianDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('penggajianDoc')->store('public/kru');

                $doc = new KruApplicationDocument();
                $doc->kru_application_id = $app->id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = KruApplicationDocument::DOC_PENGGAJIAN;
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }

            $audit_details = json_encode([
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru05', 'editD', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru05', 'editD', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('pembatalanpenggunaankrubukanwarganegara.permohonan.editE', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    public function updateE(Request $request, string $id)
    {
        $app = KruApplication::find($id);
        $app->updated_by = Auth::id();
        $app->save();
        
        $foreignKrus = KruApplicationForeignKru::where('kru_application_id',$id)->get();
        if($foreignKrus->isEmpty()){
            return redirect()->back()->with('alert', 'Permohonan Perlu Minimum Seorang Kru Bukan Warganegara!!');
        }

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
            $appLog->remark	= $request->remark != null ? $request->remark : 'Pemohon';
            $appLog->created_by = Auth::id();
            $appLog->updated_by = Auth::id();
            $appLog->save();

            $audit_details = json_encode([
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru08', 'editE', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru08', 'editE', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal dihantar !!');
        }
        return redirect()->route('pembatalanpenggunaankrubukanwarganegara.permohonan.index')->with('alert', 'Permohonan berjaya dihantar !!');
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

    

    //Export permission letter PDF
    public function exportPermissionLetter(Request $request, $id) 
    {
        $app = KruApplication::find($id);
        $appForeign = KruApplicationForeign::where('kru_application_id',$id)->first();
        $vessel = Vessel::find($app->vessel_id);
        $foreignKrus = KruApplicationForeignKru::where('kru_application_id',$id)->get();

        $owner = User::find($vessel->user_id);
        $allVessel = Vessel::where('user_id',$owner->id)->get();

        $data = [
            'immigrationOffice' => ImmigrationOffice::find($appForeign->immigration_office_id)->name,
            'owner' => $owner->name,

            'vessel' => $vessel,
            'foreignKrus' => $foreignKrus,

            'immigrationDate' => optional($appForeign->immigration_date)->format('d-m-Y'),
            'immigrationGate' => strtoupper($appForeign->immigration_gate),
            'entity' => Entity::find($app->entity_id),

            'allVessel' => $allVessel,
        ];

        $pdf = Pdf::loadView('app.kru.kru08.permissionletterpdf', $data);
        $pdf->setPaper('letter');//setPaper('A4', 'portrait');
        $pdf->getDomPDF()->set_option('enable_php', true);

        // View on page
        return $pdf->stream('suratkebenaran_'.$app->reference_number.'.pdf');

    }
}
