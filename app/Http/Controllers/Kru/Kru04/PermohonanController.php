<?php

namespace App\Http\Controllers\Kru\Kru04;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Helper;
use App\Models\Kru\KruApplication;
use App\Models\Kru\KruApplicationKru;
use App\Models\Kru\KruApplicationLog;
use App\Models\Kru\KruApplicationType;
use App\Models\Kru\KruDocument;
use App\Models\Kru\NelayanMarin;
use App\Models\ReferenceNumber;
use App\Models\Systems\AuditLog;
use App\Models\User;
use App\Models\Vessel;
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

        $appTypeId = KruApplicationType::where('code','KRU04')->first()->id;
        $apps = KruApplication::leftJoin('vessels', 'kru_applications.vessel_id', '=', 'vessels.id')
        ->where('kru_application_type_id', $appTypeId)
        ->where('kru_applications.user_id',$request->user()->id)
        ->select('kru_applications.id','reference_number','no_pendaftaran','kru_applications.entity_id','kru_application_status_id','kru_applications.created_at')->sortable();

        return view('app.kru.kru04.index', [
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

        return view('app.kru.kru04.create', [
            'vessels' => Vessel::where('user_id',$user->id)->orderBy('no_pendaftaran')->get(),
            'kruPositions' => $helper->getCodeMastersByTypeOrder('kru_position'),
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
            $appType = KruApplicationType::where('code','KRU04')->first();
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
            $auditLog->log('kru04', 'create', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
                'vessel_id' => $request->selVessel,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru04', 'create', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('pembatalankadpendaftarannelayan.permohonan.edit', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
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
        $selectedKrus = KruApplicationKru::where('kru_application_id',$id)->get();
        
        $statusDilulusId = $helper->getCodeMasterIdByTypeName('kru_application_status','DILULUS');
        $statusRejectedId = $helper->getCodeMasterIdByTypeName('kru_application_status','DITOLAK');
        $statusIncompleteId = $helper->getCodeMasterIdByTypeName('kru_application_status','TIDAK LENGKAP');
        $rejectedLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->where('kru_application_status_id',$statusRejectedId)->latest('updated_at')->first();
        $incompleteLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->where('kru_application_status_id',$statusIncompleteId)->latest('updated_at')->first();

        $decisionStatusIds = CodeMaster::where('type','kru_application_status') //used at decision to enable/disable tab
        ->whereIn('name',[
            'DILULUS',
        ])->select('id')->get();
        return view('app.kru.kru04.show', [
            'id' => $id,
            'app' => $app,
            'vessel' => $vessel,
            'selectedKrus' => $selectedKrus,
            'statusDilulusId' => $statusDilulusId,
            'statusRejectedId' => $statusRejectedId,
            'statusIncompleteId' => $statusIncompleteId,
            'rejectedLog' => $rejectedLog,
            'incompleteLog' => $incompleteLog,
            //-----------start decision------------
            'decisionStatusIds' => $decisionStatusIds,
            //------------end decision-------------
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
        $vessel = Vessel::find($app->vessel_id);
        $nelayanMarin = NelayanMarin::where('vessel_id',$vessel->id)->get();
        $selectedKrus = KruApplicationKru::where('kru_application_id',$id)->select('ic_number')->get();

        return view('app.kru.kru04.edit', [
            'id' => $id,
            'vessel' => $vessel,
            'krus' => $nelayanMarin,
            'selectedKrus' => $selectedKrus
        ]);
    }

    public function editF(string $id)
    {
        // $helper = new Helper();
        // $user = User::find(Auth::id());
        // $app = KruApplication::find($id);
        // $app2 = Kru04Application::where('kru_application_id',$id)->first();

        return view('app.kru.kru04.editF', [
            'id' => $id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $selKrus = $request->selKrus;
        if($selKrus==null){
            return redirect()->back()->with('alert', 'Permohonan Perlu Minimum Seorang Kru Dipilih untuk Dibatalkan !!');
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
                if($appKru==null){
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
        return redirect()->route('pembatalankadpendaftarannelayan.permohonan.editF', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    public function updateF(Request $request, string $id)
    {
        $selectedKrus = KruApplicationKru::where('kru_application_id',$id)->select('health_declaration')->get();
        if($selectedKrus->isEmpty()){
            return redirect()->back()->with('alert', 'Permohonan Perlu Minimun Seorang Kru Dipilih untuk Dibatalkan !!');
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
            $appLog->remark	= 'Pemohon';
            $appLog->created_by = Auth::id();
            $appLog->updated_by = Auth::id();
            $appLog->save();

            $audit_details = json_encode([
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru04', 'editF', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru04', 'editF', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal dihantar !!');
        }
        return redirect()->route('pembatalankadpendaftarannelayan.permohonan.index')->with('alert', 'Permohonan berjaya dihantar !!');
    }
}
