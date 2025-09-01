<?php

namespace App\Http\Controllers\Kru\Kru05;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Helper;
use App\Models\Kru\KruApplication;
use App\Models\Kru\KruApplicationDocument;
use App\Models\Kru\KruApplicationForeign;
use App\Models\Kru\KruApplicationForeignKru;
use App\Models\Kru\KruApplicationLog;
use App\Models\Kru\KruApplicationType;
use App\Models\Kru\KruForeignDocument;
use App\Models\Systems\AuditLog;
use App\Models\User;
use App\Models\Vessel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SemakanDaerahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('semakandaerah');
        $user = $request->user();

        $helper = new Helper();
        $statusId = $helper->getCodeMasterIdByTypeName('kru_application_status','DIHANTAR');

        $appTypeId = KruApplicationType::where('code','KRU05')->first()->id;
        $apps = KruApplication::leftJoin('users','users.id','kru_applications.user_id')
        ->where('kru_application_type_id', $appTypeId)
        ->where('kru_application_status_id',$statusId);
        if($user->username != '111111111111'){
            $apps->where('kru_applications.entity_id',$user->entity_id);
        }
        $apps->select('kru_applications.id','reference_number','users.name','kru_applications.vessel_id','kru_applications.entity_id','kru_application_status_id','kru_applications.submitted_at')->sortable();

        return view('app.kru.kru05.semakandaerah.index', [
            'applications' => $request->has('sort') ? $apps->paginate(10) : $apps->orderBy('kru_applications.submitted_at','DESC')->paginate(10),
            'statusDisimpanId' => $statusId,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find(Auth::id());
        $helper = new Helper();
        $app = KruApplication::find($id);
        $vessel = Vessel::withTrashed()->find($app->vessel_id);
        // $selectedKrus = KruApplicationKru::where('kru_application_id',$id)->get();
        $foreignKrus = KruApplicationForeignKru::where('kru_application_id',$id)->orderBy('created_at','ASC')->get();
        $applicant = User::find($app->user_id);
        $vesselOwner = User::withTrashed()->select('id','name')->find($vessel->user_id);
        $appForeign = KruApplicationForeign::where('kru_application_id',$id)->latest()->first();
        //---------------------start vessel-------------------
        $vessels = Vessel::where('user_id',$vesselOwner->id)->orderBy('no_pendaftaran')->get();
        //-----------------------end vessel-------------------
        //---------------------start document------------------
        $docs = KruApplicationDocument::where('kru_application_id',$id)->latest()->get();
        //----------------------end document-------------------
        //----------------------start logs---------------------
        $logs = KruApplicationLog::where('kru_application_id',$id)
        ->where('is_editing',false)
        ->leftJoin('users', 'kru_application_logs.created_by', '=', 'users.id')
        ->select('kru_application_logs.*','users.name')
        ->orderBy('updated_at','ASC')
        ->get();

        $latestLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->latest('updated_at')->first();

        //try find saved log if any
        $savedLog=null;
        if($latestLog!=null){
            $savedLog = KruApplicationLog::where('kru_application_id',$id)
            ->where('is_editing',true)
            ->where('created_by',$user->id)
            ->where('created_at','>',$latestLog->updated_at)
            ->latest('created_at')
            ->first();
        }
        //--------------------end logs--------------------------
        //----------------start statusIds--------------------
        $redStatusIds = CodeMaster::where('type','kru_application_status') //used at logs
        ->whereIn('name',[
            'TIDAK DISOKONG DAERAH',
            'TIDAK DISOKONG WILAYAH',
            'TIDAK DISOKONG NEGERI',
            'DITOLAK',
        ])->select('id')->get();
        $orangeStatusIds = CodeMaster::where('type','kru_application_status') //used at logs
        ->whereIn('name',[
            'TIDAK LENGKAP',
            'BAYARAN TIDAK DISAHKAN',
        ])->select('id')->get();
        //----------------end statusIds--------------------

        return view('app.kru.kru05.semakandaerah.show', [
            'id' => $id,
            'app' => $app,
            'appForeign' => $appForeign,
            'vessel' => $vessel,
            'vesselOwner' => $vesselOwner,
            'foreignKrus' => $foreignKrus,
            'applicant' => $applicant,
            //------------start vessel--------------
            'vessels' => $vessels,
            //-------------end vessel---------------
            //-----------start document-------------
            'docs' => $docs,
            //------------end document--------------
            //------------start logs----------------
            'logs' => $logs,
            'redStatusIds' => $redStatusIds,
            'orangeStatusIds' => $orangeStatusIds,
            'savedLog' => $savedLog,
            //-------------end logs----------------
            
            'passportDocName' => KruForeignDocument::DOC_PASSPORT,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->action=='save'){
            DB::beginTransaction();
    
            try {
                $latestLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->latest('updated_at')->first();

                //try find saved log if any
                $savedLog = KruApplicationLog::where('kru_application_id',$id)
                ->where('is_editing',true)
                ->where('created_by',$request->user()->id)
                ->where('created_at','>',$latestLog->updated_at)
                ->latest('created_at')
                ->first();

                if($savedLog != null){
                    $savedLog->remark = $request->remark;
                    $savedLog->completed = $request->isComplete == 'yes' ? true : 
                                        ( $request->isComplete == 'no' ? false : null);
                    $savedLog->updated_by = $request->user()->id;
                    $savedLog->save();
                }
                else{
                    $newLog = new KruApplicationLog();
                    $newLog->kru_application_id = $id;
                    $newLog->remark = $request->remark;
                    $newLog->completed = $request->isComplete == 'yes' ? true : 
                                        ( $request->isComplete == 'no' ? false : null);
                    $newLog->is_editing = true;
                    $newLog->created_by = $request->user()->id;
                    $newLog->updated_by = $request->user()->id;
                    $newLog->save();
                }
    
                $audit_details = json_encode([
                    'action' => $request->action,
                    'completed' => $request->isComplete,
                    // 'remark' => $request->remark,
                ]);
                $auditLog = new AuditLog();
                $auditLog->log('kru04SemakanDaerah', 'update', $audit_details);
                DB::commit();
            }
            catch (Exception $e) {
                DB::rollback();
                $audit_details = json_encode([
                    'action' => $request->action,
                    'completed' => $request->isComplete,
                    // 'remark' => $request->remark,
                ]);
    
                $auditLog = new AuditLog();
                $auditLog->log('kru04SemakanDaerah', 'update', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Maklumat gagal disimpan !!');
            }
            return redirect()->back()->with('alert', 'Maklumat berjaya disimpan !!');
        }
        else if ($request->action=='submit'){
            DB::beginTransaction();
    
            try {
                $helper = new Helper();
                $status_id='';
                if($request->isComplete == 'yes'){
                    $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DISEMAK DAERAH');
                }
                else if($request->isComplete == 'no'){
                    $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','TIDAK LENGKAP');
                }

                $latestLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->latest('updated_at')->first();

                //try find saved log if any
                $savedLog = null;
                if($latestLog!=null){
                    $savedLog = KruApplicationLog::where('kru_application_id',$id)
                    ->where('is_editing',true)
                    ->where('created_by',$request->user()->id)
                    ->where('created_at','>',$latestLog->updated_at)
                    ->latest('created_at')
                    ->first();
                }

                if($savedLog != null){
                    $savedLog->remark = $request->remark;
                    $savedLog->completed = $request->isComplete == 'yes' ? true : 
                                        ( $request->isComplete == 'no' ? false : null);
                    $savedLog->is_editing = false;
                    $savedLog->kru_application_status_id = $status_id;
                    $savedLog->updated_by = $request->user()->id;
                    $savedLog->save();
                }
                else{
                    $newLog = new KruApplicationLog();
                    $newLog->kru_application_id = $id;
                    $newLog->remark = $request->remark;
                    $newLog->completed = $request->isComplete == 'yes' ? true : 
                                        ( $request->isComplete == 'no' ? false : null);
                    $newLog->is_editing = false;
                    $newLog->kru_application_status_id = $status_id;
                    $newLog->created_by = $request->user()->id;
                    $newLog->updated_by = $request->user()->id;
                    $newLog->save();
                }

                $app = KruApplication::find($id);
                $app->kru_application_status_id = $status_id;
                $app->updated_by = $request->user()->id;
                $app->save();

                $audit_details = json_encode([
                    'action' => $request->action,
                    'completed' => $request->isComplete,
                    // 'remark' => $request->remark,
                ]);
                $auditLog = new AuditLog();
                $auditLog->log('kru05SemakanDaerah', 'update', $audit_details);
                DB::commit();
            }
            catch (Exception $e) {
                DB::rollback();
                $audit_details = json_encode([
                    'action' => $request->action,
                    'completed' => $request->isComplete,
                    // 'remark' => $request->remark,
                ]);
    
                $auditLog = new AuditLog();
                $auditLog->log('kru05SemakanDaerah', 'update', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Maklumat gagal dihantar !!');
            }
            return redirect()->route('kebenaranpenggunaankrubukanwarganegara.semakandaerah.index')->with('alert', 'Maklumat berjaya dihantar !!');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
