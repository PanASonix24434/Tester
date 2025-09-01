<?php

namespace App\Http\Controllers\Kru\Kru02;

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
use App\Models\Vesel;
use App\Models\Vessel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TerimaanBayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('terimaanbayaran');
        $user = $request->user();

        $helper = new Helper();
        $statusId = $helper->getCodeMasterIdByTypeName('kru_application_status','DILULUS');
        $statusId2 = $helper->getCodeMasterIdByTypeName('kru_application_status','BAYARAN TIDAK DISAHKAN');

        $appTypeId = KruApplicationType::where('code','KRU02')->first()->id;
        $apps = KruApplication::leftJoin('users','users.id','kru_applications.user_id')
        ->where('kru_application_type_id', $appTypeId)
        ->whereIn('kru_applications.kru_application_status_id',[$statusId,$statusId2])
        ->where('kru_applications.entity_id',$user->entity_id)
        ->select('kru_applications.id','reference_number','users.name','vessel_id','kru_applications.entity_id','kru_application_status_id','kru_applications.submitted_at')->sortable();

        return view('app.kru.kru02.terimaanbayaran.index', [
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
    
    public function storeReceipt(Request $request,string $id)
    {
        $request->validate(
        [
            'paymentReceiptNo' => 'required',
            'paymentReceipt' => 'required',
        ],
        [
            'selAppType.required' => 'Nombor Resit Bayaran diperlukan.',
            'paymentReceipt.required' => 'Resit Bayaran diperlukan.',
        ]);
        $items = $request->item_id;
        if($items==null){
            return redirect()->back()->with('alert', 'Item Bayaran Diperlukan!!');
        }
        else{
            DB::beginTransaction();

            try {
                $helper = new Helper();

                //try find payment for the application
                $payment = Payment::getPaymentForKruApplication($id);
                
                if($payment==null){
                    $payment = new Payment();
                    $payment->application_table_name = 'kru_applications';
                    $payment->application_id = $id;
                    $payment->created_by = $request->user()->id;
                    $payment->updated_by = $request->user()->id;
                    $payment->save();
                }

                // create receipt
                $receipt = new Receipt();
                $receipt->payment_id = $payment->id;
                $receipt->receipt_number = $request->paymentReceiptNo;
                
                $path='';
                if ($request->file('paymentReceipt')) {

                    $file = $request->file('paymentReceipt');
                    $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                    $filename = $file_replace;
                    $path = $request->file('paymentReceipt')->store('public/payment');

                    $receipt->file_name = $filename;
                    $receipt->file_path = $path;
                }

                $receipt->created_by = $request->user()->id;
                $receipt->updated_by = $request->user()->id;
                $receipt->save();

                $items = $request->item_id;
                $amount = $request->amount;

                for ($i=0; $i < count($items); $i++) { 
                    $receiptItem = new ReceiptItem();
                    $receiptItem->receipt_id = $receipt->id;
                    $receiptItem->payment_item_id = $items[$i];
                    $receiptItem->fee = $amount[$i];
                    $receiptItem->created_by = $request->user()->id;
                    $receiptItem->updated_by = $request->user()->id;
                    $receiptItem->save();
                }

                $audit_details = json_encode([
                ]);
                $auditLog = new AuditLog();
                $auditLog->log('kru02TerimaanBayaran', 'create', $audit_details);
                DB::commit();

            }
            catch (Exception $e) {
                DB::rollback();
                $audit_details = json_encode([
                ]);

                $auditLog = new AuditLog();
                $auditLog->log('kru02TerimaanBayaran', 'create', $audit_details, $e->getMessage());

                return redirect()->back()->with('alert', 'Maklumat Bayaran gagal disimpan !!');
            }

        }
        return redirect()->route('pembaharuankadpendaftarannelayan.terimaanbayaran.show', $id)->with('alert', 'Maklumat Bayaran berjaya disimpan !!');
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

        $payment = Payment::getPaymentForKruApplication($id);
        $receipts = null;
        $paymentTotal = 0;
        if($payment!=null){
            $receipts=Receipt::where('payment_id',$payment->id)->get();
            $receiptsId = $receipts->pluck('id');
            $receiptItems = ReceiptItem::whereIn('receipt_id',$receiptsId)->get();
            $paymentTotal = number_format($receiptItems->sum('fee'), 2);
        }
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

        return view('app.kru.kru02.terimaanbayaran.show', [
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
        $vessel = Vessel::withTrashed()->find($app->vessel_id);
        $kruDocs = KruDocument::where('kru_application_kru_id',$id)->get();

        return view('app.kru.kru02.terimaanbayaran.showKru', [
            'id' => $appKru->kru_application_id,
            'appKru' => $appKru,
            'vessel' => $vessel,
            'kruDocs' => $kruDocs,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function createReceipt(string $id)
    {
        $user = User::find(Auth::id());
        $helper = new Helper();
        $app = KruApplication::find($id);
        $vesel = Vessel::withTrashed()->find($app->vessel_id);
        $applicant = User::find($app->user_id);

        return view('app.kru.kru02.terimaanbayaran.create', [
            'id' => $id,
            'app' => $app,
            'vesel' => $vesel,
            'applicant' => $applicant,
            'paymentItems' => $helper->getCodeMastersByTypeOrder('payment_item'),
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
        $payment = Payment::getPaymentForKruApplication($id);
        if($payment!=null){
            $receipts = Receipt::where('payment_id',$payment->id)->get();
            if($receipts->count() <=0){
                return redirect()->back()->with('alert', 'Item Bayaran Diperlukan!!');
            }
        }
        else{
            return redirect()->back()->with('alert', 'Item Bayaran Diperlukan!!');
        }

        DB::beginTransaction();

        try {
            $helper = new Helper();

            $payment->payee = strtoupper($request->payee);
            $payment->updated_by = $request->user()->id;
            $payment->save();

            $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','BAYARAN DITERIMA');

            $latestLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->latest('updated_at')->first();

            //try find saved log if any
            $savedLog = KruApplicationLog::where('kru_application_id',$id)
            ->where('is_editing',true)
            ->where('created_by',$request->user()->id)
            ->where('created_at','>',$latestLog->updated_at)
            ->latest('created_at')
            ->first();

            if($savedLog != null){
                $savedLog->is_editing = false;
                $savedLog->kru_application_status_id = $status_id;
                $savedLog->updated_by = $request->user()->id;
                $savedLog->save();
            }
            else{
                $newLog = new KruApplicationLog();
                $newLog->kru_application_id = $id;
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
                //
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru02TerimaanBayaran', 'update', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
                //
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru02TerimaanBayaran', 'update', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Maklumat Bayaran gagal dihantar !!');
        }
        return redirect()->route('pembaharuankadpendaftarannelayan.terimaanbayaran.index')->with('alert', 'Maklumat Bayaran berjaya dihantar !!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
