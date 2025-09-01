<?php

namespace App\Http\Controllers\Kru\KeseluruhanPermohonan;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Entity;
use App\Models\Helper;
use App\Models\Kru\KruApplication;
use App\Models\Kru\KruApplicationDocument;
use App\Models\Kru\KruApplicationForeign;
use App\Models\Kru\KruApplicationForeignKru;
use App\Models\Kru\KruApplicationKru;
use App\Models\Kru\KruApplicationLog;
use App\Models\Kru\KruApplicationType;
use App\Models\Kru\KruDocument;
use App\Models\Kru\KruForeignDocument;
use App\Models\Payment\Payment;
use App\Models\Payment\Receipt;
use App\Models\Payment\ReceiptItem;
use App\Models\User;
use App\Models\Vessel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('keseluruhanpermohonankru');
        $authUser = User::leftJoin('entities', 'entities.id', '=', 'users.entity_id')->find(Auth::id());
        $authUserEntityLevel = $authUser->entity_level;

        if($authUser->username == '111111111111') $authUserEntityLevel = '1';

        $helper = new Helper();
        $kru01Id = KruApplicationType::where('code','KRU01')->first()->id;
        $kru02Id = KruApplicationType::where('code','KRU02')->first()->id;
        $kru03Id = KruApplicationType::where('code','KRU03')->first()->id;
        $kru04Id = KruApplicationType::where('code','KRU04')->first()->id;
        $kru05Id = KruApplicationType::where('code','KRU05')->first()->id;
        $kru06Id = KruApplicationType::where('code','KRU06')->first()->id;
        $kru07Id = KruApplicationType::where('code','KRU07')->first()->id;
        $kru08Id = KruApplicationType::where('code','KRU08')->first()->id;

        $ignoredStatusIds = CodeMaster::where('type','kru_application_status')->whereIn('name',['DISIMPAN','TIDAK LENGKAP'])->select('id')->get()->pluck('id')->toArray(); // ignore application that have status disimpan and tidak lengkap
        $processStatusIds = CodeMaster::where('type','kru_application_status')
        ->whereIn('name',[
            'DIHANTAR',
            'DISEMAK DAERAH',
            'DISOKONG DAERAH',
            'TIDAK DISOKONG DAERAH',
            'DISOKONG WILAYAH',
            'TIDAK DISOKONG WILAYAH',
            'DISEMAK NEGERI',
            'DISOKONG NEGERI',
            'TIDAK DISOKONG NEGERI',
        ])->select('id')->get();
        $finishedStatusIds = CodeMaster::where('type','kru_application_status')
        ->whereIn('name',[
            'DITOLAK',
            'PERMOHONAN SELESAI',
        ])->select('id')->get();
        
        $apps = KruApplication::leftJoin('users','users.id','kru_applications.user_id')
        ->whereIn('kru_application_type_id', [$kru01Id, $kru02Id, $kru03Id, $kru04Id, $kru05Id, $kru06Id, $kru07Id, $kru08Id ])//$kru05Id, $kru06Id, $kru07Id, $kru08Id
        ->whereNotIn('kru_applications.kru_application_status_id',$ignoredStatusIds);

        //Filter No Rujukan
        $filterRefNo = !empty($request->txtRefNo) ? $request->txtRefNo : '';
        if (!empty($filterRefNo)) {
            $apps->whereRaw('UPPER(kru_applications.reference_number) like ?', ['%'.strtoupper($filterRefNo).'%']);
        }

        //Filter Jenis Permohonan
        $filterAppType = !empty($request->selAppType) ? $request->selAppType : '';
        if (!empty($filterAppType)) {
			$apps->where('kru_applications.kru_application_type_id', $filterAppType);
        }

        //Filter Status Permohonan
        $filterAppStatus = !empty($request->selAppStatus) ? $request->selAppStatus : '';
        if (!empty($filterAppStatus)) {
			$apps->where('kru_applications.kru_application_status_id', $filterAppStatus);
        }

        //------------------------------------------------Start Filter Pejabat------------------------------------------------------
        $defaultEntityStateId = null;
        $defaultEntityRegionId = null;
        $defaultEntityDistrictId = null;
        if($authUserEntityLevel == '1') { //can access all data
        }
        elseif($authUserEntityLevel == '2') { //can access all data under user state jurisdiction only
            $defaultEntityStateId = $authUser->entity_id;
        }
        elseif($authUserEntityLevel == '3') { //can access all data under user region jurisdiction only
            $defaultEntityStateId = $authUser->parent_id;
            $defaultEntityRegionId = $authUser->entity_id;
        }
        elseif($authUserEntityLevel == '4') { //can access all data under user district jurisdiction only
            $defaultEntityDistrictId = $authUser->entity_id;
            $parentEntity = Entity::find($authUser->parent_id);
            if($parentEntity->entity_level == '2'){//ie state
                $defaultEntityStateId = $parentEntity->id;
            }else if ($parentEntity->entity_level == '3'){//ie region
                $defaultEntityStateId = $parentEntity->parent_id;
            }
        }

        //Filter Pejabat Permohonan (Negeri)
        $filterAppStateEntity = !empty($request->selAppStateEntity) ? $request->selAppStateEntity : '';
        $sarawakEntityId = Entity::where('entity_level','2')->where('entity_name','Pejabat Perikanan Negeri Sarawak')->latest()->first()->id;
        $wilayahIds = Entity::where('entity_level','3')->select('id')->get()->pluck('id')->toArray();
        if($authUserEntityLevel != '1') $filterAppStateEntity = $defaultEntityStateId;
        if (!empty($filterAppStateEntity)) {
			$apps->leftJoin('entities as query1','kru_applications.entity_id','=','query1.id');
            if($authUserEntityLevel == '3'){
                $apps->where('query1.parent_id', $defaultEntityRegionId);
            }
            else{
                if($filterAppStateEntity==$sarawakEntityId){
                    $apps->whereIn('query1.parent_id', $wilayahIds);
                }else{
                    $apps->where('query1.parent_id', $filterAppStateEntity);
                }
            }
        }

        //Filter Pejabat Permohonan (Daerah)
        $filterAppDistrictEntity = !empty($request->selAppDistrictEntity) ? $request->selAppDistrictEntity : '';
        if($authUserEntityLevel == '4') $filterAppDistrictEntity = $defaultEntityDistrictId;
        if (!empty($filterAppDistrictEntity)) {
			$apps->where('kru_applications.entity_id', $filterAppDistrictEntity);
        }
        //------------------------------------------------End Filter Pejabat------------------------------------------------------
        
        $apps->select('kru_applications.id','kru_applications.reference_number','kru_applications.kru_application_type_id','users.name','kru_applications.vessel_id','kru_applications.entity_id','kru_applications.kru_application_status_id','kru_applications.submitted_at')->sortable();

        return view('app.kru.keseluruhanpermohonan.index', [
            'applications' => $request->has('sort') ? $apps->paginate(10) : $apps->orderBy('kru_applications.submitted_at','DESC')->paginate(10),
            'kru01Id' => $kru01Id,
            'kru02Id' => $kru02Id,
            'kru03Id' => $kru03Id,
            'kru04Id' => $kru04Id,
            'kru05Id' => $kru05Id,
            'kru06Id' => $kru06Id,
            'kru07Id' => $kru07Id,
            'kru08Id' => $kru08Id,
            'processStatusIds' => $processStatusIds,
            'finishedStatusIds' => $finishedStatusIds,

            //filter dropdowns
            'applicationTypes' 	=> KruApplicationType::whereIn('code',['KRU01','KRU02','KRU03','KRU04','KRU05','KRU06','KRU07','KRU08'])->select('id','code','name')->orderBy('type')->get(),
            'applicationStatus' => CodeMaster::where('type','kru_application_status')->whereNotIn('name',['DISIMPAN','TIDAK LENGKAP'])->select('id','name_ms')->orderBy('name_ms')->get(),
            'entityLevel' => $authUserEntityLevel,
            'applicationStateEntities' => Entity::where('entity_level', '2')->orderBy('state_code','ASC')->get(),
            'applicationDistrictEntities' => $authUserEntityLevel == '1' ? 
            Entity::where('entity_level', '4')->orderBy('state_code','ASC')->get() : // hq = all district
            (
                $authUserEntityLevel == '2' && $defaultEntityStateId == $sarawakEntityId ? 
                Entity::where('entity_level', '4')->whereIn('parent_id',$wilayahIds)->orderBy('state_code','ASC')->get() : // state(sarawak) = all district under that state
                (
                    $authUserEntityLevel == '2' && $defaultEntityStateId != $sarawakEntityId ?
                    Entity::where('entity_level', '4')->where('parent_id',$defaultEntityStateId)->orderBy('state_code','ASC')->get() : // state = all district under that state
                    (
                        $authUserEntityLevel == '3' ?
                        Entity::where('entity_level', '4')->where('parent_id',$defaultEntityRegionId)->orderBy('state_code','ASC')->get() : // region = all district under that region
                        Entity::where('entity_level', '4')->where('id',$defaultEntityDistrictId)->get() //district = that district
                    )
                )
            ),

            //filter
            'filterRefNo' => $filterRefNo,
            'filterAppType' => $filterAppType,
            'filterAppStatus' => $filterAppStatus,
            'filterAppStateEntity' => $filterAppStateEntity,
            'filterAppDistrictEntity' => $filterAppDistrictEntity,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showKru01(string $id)
    {
        $user = User::find(Auth::id());
        $helper = new Helper();
        $app = KruApplication::find($id);
        $applicant = User::find($app->user_id);
        $kru = KruApplicationKru::where('kru_application_id',$id)->first();
        //----------------start document---------------------
        $docs = KruDocument::where('kru_application_kru_id',$kru->id)->latest()->get();
        //-----------------end document----------------------
        //----------------start payment----------------------
        $payment = Payment::getPaymentForKruApplication($id);
        $receipts = null;
        $paymentTotal = 0;
        if($payment!=null){
            $receipts=Receipt::where('payment_id',$payment->id)->get();
            $receiptsId = $receipts->pluck('id');
            $receiptItems = ReceiptItem::whereIn('receipt_id',$receiptsId)->get();
            $paymentTotal = number_format($receiptItems->sum('fee'), 2);
        }
        //-----------------end payment-----------------------
        //---------------start logs--------------------------
        $logs = KruApplicationLog::where('kru_application_id',$id)
        ->where('is_editing',false)
        ->leftJoin('users', 'kru_application_logs.created_by', '=', 'users.id')
        ->select('kru_application_logs.*','users.name')
        ->orderBy('updated_at','ASC')
        ->get();
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
        $decisionStatusIds = CodeMaster::where('type','kru_application_status') //used at decision to enable/disable tab
        ->whereIn('name',[
            'DILULUS',
            'DITOLAK',
            'BAYARAN DITERIMA',
            'BAYARAN DISAHKAN',
            'BAYARAN TIDAK DISAHKAN',
        ])->select('id')->get();
        //----------------end statusIds--------------------

        return view('app.kru.keseluruhanpermohonan.showKru01', [
            'id' => $id,
            'app' => $app,
            'applicant' => $applicant,
            'kru' => $kru,
            //------------start document-----------
            'docs' => $docs,
            //-------------end document------------
            //------------start payment------------
            'payment' => $payment,
            'receipts' => $receipts,
            'paymentTotal' => $paymentTotal,
            //------------end payment--------------
            //------------start logs----------------
            'logs' => $logs,
            'redStatusIds' => $redStatusIds,
            'orangeStatusIds' => $orangeStatusIds,
            //-------------end logs----------------
            //-----------start decision------------
            'decisionStatusIds' => $decisionStatusIds,
            //------------end decision-------------
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showKru02(string $id)
    {
        $user = User::find(Auth::id());
        $helper = new Helper();
        $app = KruApplication::find($id);
        $applicant = User::find($app->user_id);
        $selectedKrus = KruApplicationKru::where('kru_application_id',$id)->get();
        //----------------start payment----------------------
        $payment = Payment::getPaymentForKruApplication($id);
        $receipts = null;
        $paymentTotal = 0;
        if($payment!=null){
            $receipts=Receipt::where('payment_id',$payment->id)->get();
            $receiptsId = $receipts->pluck('id');
            $receiptItems = ReceiptItem::whereIn('receipt_id',$receiptsId)->get();
            $paymentTotal = number_format($receiptItems->sum('fee'), 2);
        }
        //-----------------end payment-----------------------
        //---------------start logs--------------------------
        $logs = KruApplicationLog::where('kru_application_id',$id)
        ->where('is_editing',false)
        ->leftJoin('users', 'kru_application_logs.created_by', '=', 'users.id')
        ->select('kru_application_logs.*','users.name')
        ->orderBy('updated_at','ASC')
        ->get();
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
        $decisionStatusIds = CodeMaster::where('type','kru_application_status') //used at decision to enable/disable tab
        ->whereIn('name',[
            'DILULUS',
            'BAYARAN DITERIMA',
            'BAYARAN DISAHKAN',
            'BAYARAN TIDAK DISAHKAN',
            'PERMOHONAN SELESAI'
        ])->select('id')->get();
        //----------------end statusIds--------------------

        return view('app.kru.keseluruhanpermohonan.showKru02', [
            'id' => $id,
            'app' => $app,
            'applicant' => $applicant,
            'selectedKrus' => $selectedKrus,
            //------------start payment------------
            'payment' => $payment,
            'receipts' => $receipts,
            'paymentTotal' => $paymentTotal,
            //------------end payment--------------
            //------------start logs----------------
            'logs' => $logs,
            'redStatusIds' => $redStatusIds,
            'orangeStatusIds' => $orangeStatusIds,
            //-------------end logs----------------
            //-----------start decision------------
            'decisionStatusIds' => $decisionStatusIds,
            //------------end decision-------------
        ]);
    }
    
    public function showKru02Kru(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());

        $appKru = KruApplicationKru::find($id);
        $app = KruApplication::find($appKru->kru_application_id);
        $kruDocs = KruDocument::where('kru_application_kru_id',$id)->get();

        return view('app.kru.keseluruhanpermohonan.showKru02Kru', [
            'id' => $appKru->kru_application_id,
            'app' => $app,
            'appKru' => $appKru,
            'kruDocs' => $kruDocs,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showKru03(string $id)
    {
        $user = User::find(Auth::id());
        $helper = new Helper();
        $app = KruApplication::find($id);
        $applicant = User::find($app->user_id);
        $selectedKru = KruApplicationKru::where('kru_application_id',$id)->latest()->first();
        //----------------start document---------------------
        $docs = KruDocument::where('kru_application_kru_id',$selectedKru->id)->latest()->get();
        //-----------------end document----------------------
        //----------------start payment----------------------
        $payment = Payment::getPaymentForKruApplication($id);
        $receipts = null;
        $paymentTotal = 0;
        if($payment!=null){
            $receipts=Receipt::where('payment_id',$payment->id)->get();
            $receiptsId = $receipts->pluck('id');
            $receiptItems = ReceiptItem::whereIn('receipt_id',$receiptsId)->get();
            $paymentTotal = number_format($receiptItems->sum('fee'), 2);
        }
        //-----------------end payment-----------------------
        //---------------start logs--------------------------
        $logs = KruApplicationLog::where('kru_application_id',$id)
        ->where('is_editing',false)
        ->leftJoin('users', 'kru_application_logs.created_by', '=', 'users.id')
        ->select('kru_application_logs.*','users.name')
        ->orderBy('updated_at','ASC')
        ->get();
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
        $decisionStatusIds = CodeMaster::where('type','kru_application_status') //used at decision to enable/disable tab
        ->whereIn('name',[
            'DILULUS',
            'DITOLAK',
        ])->select('id')->get();
        //----------------end statusIds--------------------

        return view('app.kru.keseluruhanpermohonan.showKru03', [
            'id' => $id,
            'app' => $app,
            'applicant' => $applicant,
            'selectedKru' => $selectedKru,
            //------------start document-----------
            'docs' => $docs,
            //-------------end document------------
            //------------start payment------------
            'payment' => $payment,
            'receipts' => $receipts,
            'paymentTotal' => $paymentTotal,
            //------------end payment--------------
            //------------start logs----------------
            'logs' => $logs,
            'redStatusIds' => $redStatusIds,
            'orangeStatusIds' => $orangeStatusIds,
            //-------------end logs----------------
            //-----------start decision------------
            'decisionStatusIds' => $decisionStatusIds,
            //------------end decision-------------
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showKru04(string $id)
    {
        $user = User::find(Auth::id());
        $helper = new Helper();
        $app = KruApplication::find($id);
        $applicant = User::find($app->user_id);
        $selectedKrus = KruApplicationKru::where('kru_application_id',$id)->get();

        //---------------start logs--------------------------
        $logs = KruApplicationLog::where('kru_application_id',$id)
        ->where('is_editing',false)
        ->leftJoin('users', 'kru_application_logs.created_by', '=', 'users.id')
        ->select('kru_application_logs.*','users.name')
        ->orderBy('updated_at','ASC')
        ->get();
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
        $decisionStatusIds = CodeMaster::where('type','kru_application_status') //used at decision to enable/disable tab
        ->whereIn('name',[
            'DILULUS',
            'BAYARAN DITERIMA',
            'BAYARAN DISAHKAN',
            'BAYARAN TIDAK DISAHKAN',
            'PERMOHONAN SELESAI'
        ])->select('id')->get();
        //----------------end statusIds--------------------

        return view('app.kru.keseluruhanpermohonan.showKru04', [
            'id' => $id,
            'app' => $app,
            'applicant' => $applicant,
            'selectedKrus' => $selectedKrus,
            //------------start logs----------------
            'logs' => $logs,
            'redStatusIds' => $redStatusIds,
            'orangeStatusIds' => $orangeStatusIds,
            //-------------end logs----------------
            //-----------start decision------------
            'decisionStatusIds' => $decisionStatusIds,
            //------------end decision-------------
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showKru05(string $id)
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

        return view('app.kru.keseluruhanpermohonan.showKru05', [
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
            //-------------end logs----------------
            
            'passportDocName' => KruForeignDocument::DOC_PASSPORT,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showKru06(string $id)
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
        
        $appPermission = KruApplication::find($appForeign->permission_application_id);
        
        $kru05Id = KruApplicationType::where('code','KRU05')->first()->id;
        $kru07Id = KruApplicationType::where('code','KRU07')->first()->id;

        return view('app.kru.keseluruhanpermohonan.showKru06', [
            'id' => $id,
            'app' => $app,
            'appForeign' => $appForeign,
            'appPermission' => $appPermission,
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
            //-------------end logs----------------
            
            'passportDocName' => KruForeignDocument::DOC_PASSPORT_PLKS,
            'kru05Id' => $kru05Id,
            'kru07Id' => $kru07Id,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function showKru07(string $id)
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

        return view('app.kru.keseluruhanpermohonan.showKru07', [
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
            //-------------end logs----------------
            
            'passportDocName' => KruForeignDocument::DOC_PASSPORT,
        ]);
    }
    
    /**
     * Display the specified resource.
     */
    public function showKru08(string $id)
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

        return view('app.kru.keseluruhanpermohonan.showKru08', [
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
            //-------------end logs----------------
            
            'passportDocName' => KruForeignDocument::DOC_PASSPORT,
        ]);
    }
}
