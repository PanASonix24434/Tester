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
use App\Models\Ssd;
use App\Models\Systems\AuditLog;
use App\Models\User;
use App\Models\Vessel;
use Exception;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CetakanKadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('cetakankad');
        $user = $request->user();

        $helper = new Helper();
        $statusId = $helper->getCodeMasterIdByTypeName('kru_application_status','BAYARAN DISAHKAN');

        $appTypeId = KruApplicationType::where('code','KRU03')->first()->id;
        $apps = KruApplication::leftJoin('users','users.id','kru_applications.user_id')
        ->where('kru_application_type_id', $appTypeId)
        ->where('kru_applications.kru_application_status_id',$statusId)
        ->where('kru_applications.entity_id',$user->entity_id)
        ->select('kru_applications.id','reference_number','users.name','vessel_id','kru_applications.entity_id','kru_application_status_id','kru_applications.submitted_at')->sortable();

        return view('app.kru.kru03.cetakankad.index', [
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

        return view('app.kru.kru03.cetakankad.show', [
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
        $vessel = Vessel::withTrashed()->find($app->vessel_id);
        $kruDocs = KruDocument::where('kru_application_kru_id',$id)->get();

        return view('app.kru.kru03.cetakankad.showKru', [
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
    public function checkPin(Request $request, string $id)
    {
        $helper = new Helper();
        $app = KruApplication::find($id);
        $selectedKrus = KruApplicationKru::where('kru_application_id',$id)->get();
        $allHasPrintedSucessfully = true;
        foreach ($selectedKrus as $selectedKru) {
            if ($selectedKru->has_sucessfully_printed !== true){
                $allHasPrintedSucessfully = false;
                break;
            }
        }
        if($app->pin_number == $request->pin){
            return view('app.kru.kru03.cetakankad.create', [
                'id' => $id,
                'app' => $app,
                'selectedKrus' => $selectedKrus,
                'allHasPrintedSucessfully' => $allHasPrintedSucessfully,
                'warganegaraId' => $helper->getCodeMasterIdByTypeName('kewarganegaraan_status','WARGANEGARA'),
                'pemastautinId' => $helper->getCodeMasterIdByTypeName('kewarganegaraan_status','PEMASTAUTIN TETAP'),
            ]);
        }
        else{
            return redirect()->back()->with('alert', 'Nombor PIN yang dimasukkan Tidak Sama!!');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function createSSD(Request $request, string $id)
    {
        // $app = KruApplication::find($id);
        // $selectedKrus = KruApplicationKru::where('kru_application_id',$id)->where('selected_for_approval',true)->get();
        $selectedKru = KruApplicationKru::find($id);
        $app = KruApplication::find($selectedKru->kru_application_id);
        $pin = $app->pin_number;
        return view('app.kru.kru03.cetakankad.createSSD', [
            'id' => $app->id,
            'pin' => $pin,
            'selectedKru' => $selectedKru,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateSSD(Request $request, string $id)
    {        
        $request->validate(
        [
            'ssd' => 'unique:ssds,ssd_number',
        ],
        [
            'ssd.unique' => 'No. SSD Ini Telah Digunakan',
        ]);
        DB::beginTransaction();

        $selectedKru = null;
        $app = null;
        try {
            $helper = new Helper();

            $selectedKru = KruApplicationKru::find($id);
            if($selectedKru->ssd_number != null){
                $oldSSD = Ssd::where('ssd_number',$selectedKru->ssd_number)->latest()->first();
                if($oldSSD != null){
                    $oldSSD->has_used = true;
                    $oldSSD->is_faulty = true;
                    $oldSSD->save();
                }
            }
            $selectedKru->ssd_number = strtoupper($request->ssd);
            $selectedKru->has_sucessfully_printed = null;
            $selectedKru->updated_by = $request->user()->id;
            $selectedKru->save();

            $newSsd = new Ssd();
            $newSsd->ssd_number = $selectedKru->ssd_number;
            $newSsd->application_table_name = 'kru_application_krus';
            $newSsd->application_id = $selectedKru->id;
            $newSsd->has_used = true;
            $newSsd->created_by = $request->user()->id;
            $newSsd->updated_by = $request->user()->id;
            $newSsd->save();

            $app = KruApplication::find($selectedKru->kru_application_id);
            // $app->ssd_number = $request->ssd;
            $app->updated_by = $request->user()->id;
            $app->save();

            $audit_details = json_encode([
                'id' => $id,
                'ssd_number' => $request->ssd,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru03CetakanKad', 'updateSSD', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
                'id' => $id,
                'ssd_number' => $request->ssd,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru03CetakanKad', 'updateSSD', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Maklumat SSD gagal disampan !!');
        }
        
        $selectedKrus = KruApplicationKru::where('kru_application_id',$selectedKru->kru_application_id)->get();
        $allHasPrintedSucessfully = true;
        foreach ($selectedKrus as $selectedKru) {
            if ($selectedKru->has_sucessfully_printed !== true){
                $allHasPrintedSucessfully = false;
                break;
            }
        }
        return view('app.kru.kru03.cetakankad.create', [
            'id' => $selectedKru->kru_application_id,
            'app' => $app,
            'selectedKrus' => $selectedKrus,
            'allHasPrintedSucessfully' => $allHasPrintedSucessfully,
            'warganegaraId' => $helper->getCodeMasterIdByTypeName('kewarganegaraan_status','WARGANEGARA'),
            'pemastautinId' => $helper->getCodeMasterIdByTypeName('kewarganegaraan_status','PEMASTAUTIN TETAP'),
        ]);
        // return redirect()->route('kadpendaftarannelayan.cetakankad.index')->with('alert', 'Maklumat SSD berjaya disimpan !!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePrinted(Request $request, string $id)
    {        
        DB::beginTransaction();

        $selectedKru = null;
        $app = null;
        try {
            $helper = new Helper();

            $selectedKru = KruApplicationKru::find($id);
            if ($request->printCondition == 'good'){
                $selectedKru->has_sucessfully_printed = true;
            }
            elseif ($request->printCondition == 'broken'){
                $selectedKru->has_sucessfully_printed = false;
                $ssd = Ssd::where('ssd_number',$selectedKru->ssd_number)->first();
                $ssd->is_faulty = true;
                $ssd->updated_by = $request->user()->id;
                $ssd->save();
            }
            else{
                $selectedKru->has_sucessfully_printed = null;
            }
            $selectedKru->updated_by = $request->user()->id;
            $selectedKru->save();

            $app = KruApplication::find($selectedKru->kru_application_id);
            // $app->ssd_number = $request->ssd;
            $app->updated_by = $request->user()->id;
            $app->save();

            $audit_details = json_encode([
                'id' => $id,
                'ssd_number' => $request->printCondition,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru03CetakanKad', 'updatePrinted', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
                'id' => $id,
                'ssd_number' => $request->printCondition,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru03CetakanKad', 'updatePrinted', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Maklumat SSD gagal disimpan !!');
        }
        
        $selectedKrus = KruApplicationKru::where('kru_application_id',$selectedKru->kru_application_id)->get();
        $allHasPrintedSucessfully = true;
        foreach ($selectedKrus as $selectedKru) {
            if ($selectedKru->has_sucessfully_printed !== true){
                $allHasPrintedSucessfully = false;
                break;
            }
        }
        $selectedKrus = KruApplicationKru::where('kru_application_id',$selectedKru->kru_application_id)->get();
        return view('app.kru.kru03.cetakankad.create', [
            'id' => $selectedKru->kru_application_id,
            'app' => $app,
            'selectedKrus' => $selectedKrus,
            'allHasPrintedSucessfully' => $allHasPrintedSucessfully,
            'warganegaraId' => $helper->getCodeMasterIdByTypeName('kewarganegaraan_status','WARGANEGARA'),
            'pemastautinId' => $helper->getCodeMasterIdByTypeName('kewarganegaraan_status','PEMASTAUTIN TETAP'),
        ]);
        // return redirect()->back()->with('alert', 'Maklumat SSD berjaya disimpan !!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function print(Request $request, string $id)
    {    
        //$request->user()->isAuthorize('export-user');
        
        $auditLog = new AuditLog();
        $auditLog->log('kru03CetakanKad', 'print', json_encode(['file_type' => 'PDF']));
        
        $selectedKru = KruApplicationKru::find($id);
        $data['appKru'] = $selectedKru;
        $data['app'] = KruApplication::find($selectedKru->kru_application_id);
        // $data['app2'] = Kru03Application::where('kru_application_id',$selectedKru->kru_application_id)->latest()->first();
        $data['vessel'] = Vessel::find($data['app']->vessel_id);
        
        $pdf = PDF::loadView('app.kru.kadnelayanpdf2', $data);
        $pdf->setPaper('A4', 'potrait');
        $pdf->getDomPDF()->set_option('enable_php', true);

        // View on page
        return $pdf->stream('kadpendaftarannelayan'.'_'.$data['app']->reference_number.'.pdf');
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateCompleted(Request $request, string $id)
    {        
        DB::beginTransaction();

        // $selectedKru = null;
        $app = null;
        try {
            $helper = new Helper();

            $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','PERMOHONAN SELESAI');
            $app = KruApplication::find($id);
            $app->kru_application_status_id = $status_id;
            $app->updated_by = $request->user()->id;
            $app->save();
            
            $newLog = new KruApplicationLog();
            $newLog->kru_application_id = $id;
            $newLog->is_editing = false;
            $newLog->kru_application_status_id = $status_id;
            $newLog->created_by = $request->user()->id;
            $newLog->updated_by = $request->user()->id;
            $newLog->save();

            $audit_details = json_encode([
                'id' => $id,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru03CetakanKad', 'updateCompleted', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
                'id' => $id,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru03CetakanKad', 'updateCompleted', $audit_details, $e->getMessage());

            $selectedKrus = KruApplicationKru::where('kru_application_id',$id)->get();
            $allHasPrintedSucessfully = true;
            foreach ($selectedKrus as $selectedKru) {
                if ($selectedKru->has_sucessfully_printed !== true){
                    $allHasPrintedSucessfully = false;
                    break;
                }
            }
            return view('app.kru.kru02.cetakankad.create', [
                'id' => $id,
                'app' => $app,
                'selectedKrus' => $selectedKrus,
                'allHasPrintedSucessfully' => $allHasPrintedSucessfully,
            ])->with('alert', 'Permohonan Tidak Selesai !!');
        }
        return redirect()->route('pembaharuankadpendaftarannelayan.cetakankad.index')->with('alert', 'Permohonan Selesai !!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
