<?php

namespace App\Http\Controllers\Kru\Kru02;

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

        $appTypeId = KruApplicationType::where('code','KRU02')->first()->id;
        $apps = KruApplication::leftJoin('users','users.id','kru_applications.user_id')
        ->where('kru_application_type_id', $appTypeId)
        ->where('kru_applications.kru_application_status_id',$statusId)
        ->where('kru_applications.entity_id',$user->entity_id)
        ->select('kru_applications.id','reference_number','users.name','vessel_id','kru_applications.entity_id','kru_application_status_id','kru_applications.submitted_at')->sortable();

        return view('app.kru.kru02.semakandaerah.index', [
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
        $selectedKrus = KruApplicationKru::where('kru_application_id',$id)->get();
        $applicant = User::find($app->user_id);

        //---------------start logs--------------------------
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

        return view('app.kru.kru02.semakandaerah.show', [
            'id' => $id,
            'app' => $app,
            'vessel' => $vessel,
            'selectedKrus' => $selectedKrus,
            'applicant' => $applicant,
            //------------start logs----------------
            'logs' => $logs,
            'redStatusIds' => $redStatusIds,
            'orangeStatusIds' => $orangeStatusIds,
            'savedLog' => $savedLog,
            //-------------end logs----------------
        ]);
    }
    
    public function showKru(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());

        $appKru = KruApplicationKru::find($id);
        $app = KruApplication::find($appKru->kru_application_id);
        $vessel = Vessel::withTrashed()->find($app->vessel_id);
        $kruDocs = KruDocument::where('kru_application_kru_id',$id)->get();

        return view('app.kru.kru02.semakandaerah.showKru', [
            'id' => $appKru->kru_application_id,
            'appKru' => $appKru,
            'vessel' => $vessel,
            'kruDocs' => $kruDocs,
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
                $auditLog->log('kru02SemakanDaerah', 'update', $audit_details);
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
                $auditLog->log('kru02SemakanDaerah', 'update', $audit_details, $e->getMessage());
    
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
                // if($app->start_counting_at==null && $request->isComplete == 'yes'){
                //     $app->start_counting_at = Carbon::now()->toDateTimeString();
                // }
                $app->kru_application_status_id = $status_id;
                $app->updated_by = $request->user()->id;
                $app->save();

                $audit_details = json_encode([
                    'action' => $request->action,
                    'completed' => $request->isComplete,
                    // 'remark' => $request->remark,
                ]);
                $auditLog = new AuditLog();
                $auditLog->log('kru02SemakanDaerah', 'update', $audit_details);
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
                $auditLog->log('kru02SemakanDaerah', 'update', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Maklumat gagal dihantar !!');
            }


            return redirect()->route('pembaharuankadpendaftarannelayan.semakandaerah.index')->with('alert', 'Maklumat berjaya dihantar !!');
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
