<?php

namespace App\Http\Controllers\Kru\Kru01;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Entity;
use App\Models\Helper;
use App\Models\Kru\KruApplication;
use App\Models\Kru\KruApplicationKru;
use App\Models\Kru\KruApplicationLog;
use App\Models\Kru\KruApplicationType;
use App\Models\Kru\KruDocument;
use App\Models\Systems\AuditLog;
use App\Models\User;
use App\Models\Vesel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SemakanNegeriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('semakannegeri');
        $user = $request->user();

        $helper = new Helper();
        $statusId = $helper->getCodeMasterIdByTypeName('kru_application_status','DISOKONG DAERAH');
        $statusId2 = $helper->getCodeMasterIdByTypeName('kru_application_status','TIDAK DISOKONG DAERAH');
        
        $statusId3 = $helper->getCodeMasterIdByTypeName('kru_application_status','DISOKONG WILAYAH');
        $statusId4 = $helper->getCodeMasterIdByTypeName('kru_application_status','TIDAK DISOKONG WILAYAH');
        $sarawakEntityId = Entity::where('entity_name','Pejabat Perikanan Negeri Sarawak')->first()->id;
        $wilayahIds = Entity::where('entity_level','3')->select('id')->get()->pluck('id')->toArray();

        $appTypeId = KruApplicationType::where('code','KRU01')->first()->id;
        $apps = KruApplication::leftJoin('users','users.id','kru_applications.user_id')
        ->leftJoin('entities', 'kru_applications.entity_id', '=', 'entities.id')
        ->leftJoin('entities as entities2', 'entities.parent_id', '=', 'entities2.id')
        ->where(function ($query) use ($appTypeId, $statusId, $statusId2, $wilayahIds, $user) {
            $query->where('kru_application_type_id', $appTypeId)
                ->whereIn('kru_applications.kru_application_status_id',[$statusId,$statusId2])
                ->whereNotIn('entities.parent_id',$wilayahIds);
                if($user->username != '111111111111'){
                    $query->where('entities.parent_id',$user->entity_id);
                }
        })->orWhere(function ($query) use ($appTypeId, $statusId3, $statusId4, $wilayahIds, $user) {
            $query->where('kru_application_type_id', $appTypeId)
            ->whereIn('kru_applications.kru_application_status_id',[$statusId3,$statusId4])
                ->whereIn('entities.parent_id',$wilayahIds);
                if($user->username != '111111111111'){
                    $query->where('entities2.parent_id',$user->entity_id);
                }
        })
        ->select('kru_applications.id','kru_applications.reference_number','users.name','kru_applications.vessel_id','kru_applications.entity_id','kru_applications.kru_application_status_id','kru_applications.submitted_at')->sortable();

        return view('app.kru.kru01.semakannegeri.index', [
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
        $kru = KruApplicationKru::where('kru_application_id',$id)->first();
        $applicant = User::find($app->user_id);
        $docs = KruDocument::where('kru_application_kru_id',$kru->id)->latest()->get();

        //---------------start logs--------------------------
        $logs = KruApplicationLog::where('kru_application_id',$id)
        ->where('is_editing',false)
        ->leftJoin('users', 'kru_application_logs.created_by', '=', 'users.id')
        ->select('kru_application_logs.*','users.name')
        ->orderBy('updated_at','ASC')
        ->get();

        $latestLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->latest('updated_at')->first();

        //try find saved log if any
        $savedLog = KruApplicationLog::where('kru_application_id',$id)
        ->where('is_editing',true)
        ->where('created_by',$user->id)
        ->where('created_at','>',$latestLog->updated_at)
        ->latest('created_at')
        ->first();
        //-----------------end logs--------------------------

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

        return view('app.kru.kru01.semakannegeri.show', [
            'id' => $id,
            'app' => $app,
            'kru' => $kru,
            'applicant' => $applicant,
            'docs' => $docs,
            'logs' => $logs,
            //------------start logs----------------
            'logs' => $logs,
            'redStatusIds' => $redStatusIds,
            'orangeStatusIds' => $orangeStatusIds,
            //-------------end logs----------------
            'savedLog' => $savedLog,
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
                    $savedLog->completed = $request->applicationStatus == 'complete' ? true : 
                                        ( $request->applicationStatus == 'incomplete' ? false : null);
                    $savedLog->updated_by = $request->user()->id;
                    $savedLog->save();
                }
                else{
                    $newLog = new KruApplicationLog();
                    $newLog->kru_application_id = $id;
                    $newLog->remark = $request->remark;
                    $newLog->completed = $request->applicationStatus == 'complete' ? true : 
                                        ( $request->applicationStatus == 'incomplete' ? false : null);
                    $newLog->is_editing = true;
                    $newLog->created_by = $request->user()->id;
                    $newLog->updated_by = $request->user()->id;
                    $newLog->save();
                }
    
                $audit_details = json_encode([
                    'action' => $request->action,
                    'applicationStatus' => $request->applicationStatus,
                    // 'remark' => $request->remark,
                ]);
                $auditLog = new AuditLog();
                $auditLog->log('kru01SemakanNegeri', 'update', $audit_details);
                DB::commit();
            }
            catch (Exception $e) {
                DB::rollback();
                $audit_details = json_encode([
                    'action' => $request->action,
                    'applicationStatus' => $request->applicationStatus,
                    // 'remark' => $request->remark,
                ]);
    
                $auditLog = new AuditLog();
                $auditLog->log('kru01SemakanNegeri', 'update', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Maklumat gagal disimpan !!');
            }
            return redirect()->back()->with('alert', 'Maklumat berjaya disimpan !!');
        }
        else if ($request->action=='submit'){
            DB::beginTransaction();
    
            try {
                $helper = new Helper();
                $status_id='';//for application
                $status_id2='';//for log
                $sarawakEntityId = Entity::where('entity_name','Pejabat Perikanan Negeri Sarawak')->first()->id;

                $app = KruApplication::leftJoin('entities', 'kru_applications.entity_id', '=', 'entities.id')
                ->find($id);
                

                if($request->applicationStatus == 'complete'){
                    $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DISEMAK NEGERI');
                    $status_id2 = $status_id;
                }
                else if($request->applicationStatus == 'incomplete'){
                    if($app->parent_id == $sarawakEntityId){
                        $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DISOKONG DAERAH');
                    }
                    else{
                        $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DISEMAK DAERAH');
                    }
                    $status_id2 = $helper->getCodeMasterIdByTypeName('kru_application_status','TIDAK LENGKAP');
                }

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
                    $savedLog->completed = $request->applicationStatus == 'complete' ? true : 
                                        ( $request->applicationStatus == 'incomplete' ? false : null);
                    $savedLog->is_editing = false;
                    $savedLog->kru_application_status_id = $status_id2;
                    $savedLog->updated_by = $request->user()->id;
                    $savedLog->save();
                }
                else{
                    $newLog = new KruApplicationLog();
                    $newLog->kru_application_id = $id;
                    $newLog->remark = $request->remark;
                    $newLog->completed = $request->applicationStatus == 'complete' ? true : 
                                        ( $request->applicationStatus == 'incomplete' ? false : null);
                    $newLog->is_editing = false;
                    $newLog->kru_application_status_id = $status_id2;
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
                    'applicationStatus' => $request->applicationStatus,
                    // 'remark' => $request->remark,
                ]);
                $auditLog = new AuditLog();
                $auditLog->log('kru01SemakanNegeri', 'update', $audit_details);
                DB::commit();
            }
            catch (Exception $e) {
                DB::rollback();
                $audit_details = json_encode([
                    'action' => $request->action,
                    'applicationStatus' => $request->applicationStatus,
                    // 'remark' => $request->remark,
                ]);
    
                $auditLog = new AuditLog();
                $auditLog->log('kru01SemakanNegeri', 'update', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Maklumat gagal dihantar !!');
            }
            return redirect()->route('kadpendaftarannelayan.semakannegeri.index')->with('alert', 'Maklumat berjaya dihantar !!');
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
