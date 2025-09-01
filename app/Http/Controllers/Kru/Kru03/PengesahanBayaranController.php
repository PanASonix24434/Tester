<?php

namespace App\Http\Controllers\Kru\Kru03;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Helper;
use App\Models\Kru\KruApplication;
use App\Models\Kru\KruApplicationKru;
use App\Models\Kru\KruApplicationLog;
use App\Models\Kru\KruApplicationType;
use App\Models\Kru\KruDocument;
use App\Models\Payment\Payment;
use App\Models\Payment\Receipt;
use App\Models\Payment\ReceiptItem;
use App\Models\Systems\AuditLog;
use App\Models\User;
use App\Models\Vessel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengesahanBayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('pengesahanbayaran');
        $user = $request->user();

        $helper = new Helper();
        $statusId = $helper->getCodeMasterIdByTypeName('kru_application_status','BAYARAN DITERIMA');

        $appTypeId = KruApplicationType::where('code','KRU03')->first()->id;
        $apps = KruApplication::leftJoin('users','users.id','kru_applications.user_id')
        ->where('kru_application_type_id', $appTypeId)
        ->where('kru_applications.kru_application_status_id',$statusId)
        ->where('kru_applications.entity_id',$user->entity_id)
        ->select('kru_applications.id','reference_number','users.name','vessel_id','kru_applications.entity_id','kru_application_status_id','kru_applications.submitted_at')->sortable();

        return view('app.kru.kru03.pengesahanbayaran.index', [
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
        $selectedKru = KruApplicationKru::where('kru_application_id',$id)->latest()->first();
        $applicant = User::find($app->user_id);
        $docs = KruDocument::where('kru_application_kru_id',$selectedKru->id)->latest()->get();

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

        $payment = Payment::getPaymentForKruApplication($id);
        $receipts = null;
        $paymentTotal = 0;
        if($payment!=null){
            $receipts=Receipt::where('payment_id',$payment->id)->get();
            $receiptsId = $receipts->pluck('id');
            $receiptItems = ReceiptItem::whereIn('receipt_id',$receiptsId)->get();
            $paymentTotal = number_format($receiptItems->sum('fee'), 2);
        }

        return view('app.kru.kru03.pengesahanbayaran.show', [
            'id' => $id,
            'app' => $app,
            'vessel' => $vessel,
            'selectedKru' => $selectedKru,
            'applicant' => $applicant,
            'docs' => $docs,
            //------------start logs----------------
            'logs' => $logs,
            'redStatusIds' => $redStatusIds,
            'orangeStatusIds' => $orangeStatusIds,
            'savedLog' => $savedLog,
            //-------------end logs----------------
            'payment' => $payment,
            'receipts' => $receipts,
            'paymentTotal' => $paymentTotal
        ]);
    }
    
    public function showKru(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());

        $appKru = KruApplicationKru::find($id);
        $app = KruApplication::find($appKru->kru_application_id);
        $kruDocs = KruDocument::where('kru_application_kru_id',$id)->get();

        return view('app.kru.kru03.pengesahanbayaran.showKru', [
            'id' => $appKru->kru_application_id,
            'appKru' => $appKru,
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
                $auditLog->log('kru03PengesahanBayaran', 'update', $audit_details);
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
                $auditLog->log('kru03PengesahanBayaran', 'update', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Maklumat Bayaran gagal disimpan !!');
            }
            return redirect()->back()->with('alert', 'Maklumat Bayaran berjaya disimpan !!');
        }
        else if ($request->action=='submit'){
            DB::beginTransaction();
    
            try {
                $helper = new Helper();
                $status_id='';//for application
                $status_id2='';//for log
                if($request->applicationStatus == 'complete'){
                    $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','BAYARAN DISAHKAN');
                    $status_id2 = $status_id;
                }
                else if($request->applicationStatus == 'incomplete'){
                    $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','BAYARAN TIDAK DISAHKAN');
                    $status_id2 = $status_id;
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
                $auditLog->log('kru03PengesahanBayaran', 'update', $audit_details);
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
                $auditLog->log('kru03PengesahanBayaran', 'update', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Maklumat Bayaran gagal dihantar !!');
            }
            return redirect()->route('gantiankadpendaftarannelayan.pengesahanbayaran.index')->with('alert', 'Maklumat Bayaran berjaya dihantar !!');
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
