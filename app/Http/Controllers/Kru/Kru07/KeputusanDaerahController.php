<?php

namespace App\Http\Controllers\Kru\Kru07;

use App\Http\Controllers\Controller;
use App\Mail\Kru\Kru05Approved;
use App\Mail\Kru\Kru07Approved;
use App\Models\CodeMaster;
use App\Models\Entity;
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
use Illuminate\Support\Facades\Mail;

class KeputusanDaerahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('keputusandaerah');
        $user = $request->user();

        $helper = new Helper();
        $statusId = $helper->getCodeMasterIdByTypeName('kru_application_status','DISEMAK DAERAH');

        $appTypeId = KruApplicationType::where('code','KRU07')->first()->id;
        $apps = KruApplication::leftJoin('users','users.id','kru_applications.user_id')
        ->where('kru_application_type_id', $appTypeId)
        ->where('kru_applications.kru_application_status_id',$statusId);
        if($user->username != '111111111111'){
            $apps->where('kru_applications.entity_id',$user->entity_id);
        }
        $apps->select('kru_applications.id','reference_number','users.name','kru_applications.vessel_id','kru_applications.entity_id','kru_application_status_id','kru_applications.submitted_at')->sortable();

        return view('app.kru.kru07.keputusandaerah.index', [
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
        $foreignKrus = KruApplicationForeignKru::where('kru_application_id',$id)->orderBy('created_at','ASC')->get();
        // $selectedKrus = KruApplicationKru::where('kru_application_id',$id)->get();
        $applicant = User::find($app->user_id);
        $vesselOwner = User::withTrashed()->select('id','name')->find($vessel->user_id);
        $appForeign = KruApplicationForeign::where('kru_application_id',$id)->latest()->first();
        // $docs = KruApplicationDocument::where('kru_application_id',$id)->latest()->get();
        //---------------------start vessel-------------------
        $vessels = Vessel::where('user_id',$vesselOwner->id)->orderBy('no_pendaftaran')->get();
        //-----------------------end vessel-------------------
        //---------------------start document------------------
        $docs = KruApplicationDocument::where('kru_application_id',$id)->latest()->get();
        //----------------------end document-------------------

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

        return view('app.kru.kru07.keputusandaerah.show', [
            'id' => $id,
            'app' => $app,
            'appForeign' => $appForeign,
            'vessel' => $vessel,
            'vesselOwner' => $vesselOwner,
            'foreignKrus' => $foreignKrus,
            // 'selectedKrus' => $selectedKrus,
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
                    $savedLog->completed = $request->applicationStatus == 'approved' || $request->applicationStatus == 'rejected' ? true : 
                                        ( $request->applicationStatus == 'incomplete' ? false : null);
                    $savedLog->approved = $request->applicationStatus == 'approved' ? true : 
                                        ( $request->applicationStatus == 'rejected' ? false : null);
                    $savedLog->updated_by = $request->user()->id;
                    $savedLog->save();
                }
                else{
                    $newLog = new KruApplicationLog();
                    $newLog->kru_application_id = $id;
                    $newLog->remark = $request->remark;
                    $newLog->completed = $request->applicationStatus == 'approved' || $request->applicationStatus == 'rejected' ? true : 
                                        ( $request->applicationStatus == 'incomplete' ? false : null);
                    $newLog->approved = $request->applicationStatus == 'approved' ? true : 
                                        ( $request->applicationStatus == 'rejected' ? false : null);
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
                $auditLog->log('kru05KeputusanDaerah', 'update', $audit_details);
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
                $auditLog->log('kru05KeputusanDaerah', 'update', $audit_details, $e->getMessage());
    
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
                if($request->applicationStatus == 'approved'){
                    $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DILULUS');
                    $status_id2 = $status_id;
                }
                else if($request->applicationStatus == 'rejected'){
                    $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DITOLAK');
                    $status_id2 = $status_id;
                }
                else if($request->applicationStatus == 'incomplete'){
                    $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DIHANTAR');
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
                    $savedLog->completed = $request->applicationStatus == 'approved' || $request->applicationStatus == 'rejected' ? true : 
                                        ( $request->applicationStatus == 'incomplete' ? false : null);
                    $savedLog->approved = $request->applicationStatus == 'approved' ? true : 
                                        ( $request->applicationStatus == 'rejected' ? false : null);
                    $savedLog->is_editing = false;
                    $savedLog->kru_application_status_id = $status_id2;
                    $savedLog->updated_by = $request->user()->id;
                    $savedLog->save();
                }
                else{
                    $newLog = new KruApplicationLog();
                    $newLog->kru_application_id = $id;
                    $newLog->remark = $request->remark;
                    $newLog->completed = $request->applicationStatus == 'approved' || $request->applicationStatus == 'rejected' ? true : 
                                        ( $request->applicationStatus == 'incomplete' ? false : null);
                    $newLog->approved = $request->applicationStatus == 'approved' ? true : 
                                        ( $request->applicationStatus == 'rejected' ? false : null);
                    $newLog->is_editing = false;
                    $newLog->kru_application_status_id = $status_id2;
                    $newLog->created_by = $request->user()->id;
                    $newLog->updated_by = $request->user()->id;
                    $newLog->save();
                }

                $app = KruApplication::find($id);
                $vessel = Vessel::find($app->vessel_id);
                $app->kru_application_status_id = $status_id;
                if($request->applicationStatus == 'approved'){
                    $app->is_approved = true;

                    //reset all kru
                    $appKrus = KruApplicationForeignKru::where('kru_application_id',$id)->get();
                    foreach ($appKrus as $appKru) {
                        $appKru->approved = false;
                        $appKru->selected_for_approval = true;
                        $appKru->updated_by = Auth::id();
                        $appKru->save();
                    }

                    //check approved selected kru
                    $selKrus = $request->selApprovedKrus;
                    if($selKrus != null){
                        foreach ($selKrus as $selKru) {
                            $appKru = KruApplicationForeignKru::find($selKru);
                            $appKru->approved = true;
                            $appKru->updated_by = Auth::id();
                            $appKru->save();
                        }
                    }
                }
                elseif ($request->applicationStatus == 'rejected') {
                    $app->is_approved = false;
                }
                else{
                    $app->is_approved = null;
                }
                $app->decision_by = $request->user()->id;
                $app->decision_at = Carbon::now()->toDateTimeString();
                $app->updated_by = $request->user()->id;
                $app->save();

                $audit_details = json_encode([
                    'action' => $request->action,
                    'applicationStatus' => $request->applicationStatus,
                    // 'remark' => $request->remark,
                ]);
                $auditLog = new AuditLog();
                $auditLog->log('kru07KeputusanDaerah', 'update', $audit_details);
                DB::commit();
                
                if($request->applicationStatus == 'approved'){

                    //Send email permohonan ================================
                    $pemilikVesel = User::find($vessel->user_id);
                    $entity = Entity::find($app->entity_id);
                    $selKrus = KruApplicationForeignKru::where('kru_application_id',$id)->select('passport_number','name')->get()->toArray();
                    $mailDataArr = array(
                        'ref_no' => $app->reference_number,
                        'owner' => strtoupper($pemilikVesel->name),
                        'vessel' => strtoupper($vessel->no_pendaftaran),
                        'krus' => $selKrus,
                        'entity_name' => $entity->entity_name,
                    );

                    //Send email to penerima hebahan
                    Mail::to($pemilikVesel->email)->queue(new Kru07Approved($mailDataArr));

                }
            }
            catch (Exception $e) {
                DB::rollback();
                $audit_details = json_encode([
                    'action' => $request->action,
                    'applicationStatus' => $request->applicationStatus,
                    // 'remark' => $request->remark,
                ]);
    
                $auditLog = new AuditLog();
                $auditLog->log('kru07KeputusanDaerah', 'update', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Maklumat gagal dihantar !!');
            }
            return redirect()->route('pembaharuanpenggunaankrubukanwarganegara.keputusandaerah.index')->with('alert', 'Maklumat berjaya dihantar !!');
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
