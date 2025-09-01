<?php

namespace App\Http\Controllers\SubsistenceAllowancePayment;
use Illuminate\Http\Request;
use App\Models\SubsistenceAllowance\SubsistenceListQuota;
use App\Models\SubsistenceAllowance\SubApplication;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Entity;
use App\Models\SubsistencePayment\SubPayment;
use App\Models\SubsistencePayment\SubPaymentHq;
use App\Models\SubsistencePayment\SubPaymentPayee;
use App\Models\SubsistencePayment\SubPaymentState;
use App\Models\Systems\AuditLog;
use App\Models\User;
use Illuminate\Support\Str;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SubPayGenerateNameHqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $entity_id = $user->entity_id;
        $lists = SubPaymentHq::sortable();

        return view('app.subsistence_allowance_payment.generatenamehq.index',  [
            'lists' => $request->has('sort') ? $lists->paginate(10) : $lists->orderBy('created_at')->paginate(10),
            'entity_id' => $entity_id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $entity_id)
    {
        $statesIds = SubPaymentState::leftJoin('entities','entities.id','subsistence_payment_states.entity_id')
        ->where('subsistence_payment_hq_id',null)
        ->where('year',$request->selYear)
        ->where('month',$request->selMonth)
        ->where('parent_id',$entity_id)->pluck('subsistence_payment_states.id')->toArray();
        
        $activeESH = SubPayment::leftJoin('entities','entities.id','subsistence_payments.entity_id')
        ->leftJoin('subsistence_payment_payees','subsistence_payment_payees.subsistence_payment_id','subsistence_payments.id')
        ->whereIn('subsistence_payment_states_id',$statesIds)->sortable();

        return view('app.subsistence_allowance_payment.generatenamehq.create',  [
            'lists' => $request->has('sort') ? $activeESH->paginate(10) : $activeESH->paginate(10),
            'entity_id' => $entity_id,
            'year' => $request->selYear,
            'month' => $request->selMonth,
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $states = SubPaymentState::where('subsistence_payment_hq_id',null)->get();

            $hqGen = new SubPaymentHq();
            $hqGen->generated_date = Carbon::now();
            $hqGen->status = 'Dijana';
            $hqGen->year = $request->selYear;
            $hqGen->month = $request->selMonth;
            $hqGen->created_by = Auth::user()->id;
            $hqGen->updated_by = Auth::user()->id;
            $hqGen->save();

            if(!$states->isEmpty()){
                foreach ($states as $state){
                    $state->subsistence_payment_hq_id = $hqGen->id;
                    $state->updated_by = Auth::user()->id;
                    $state->save();
                }
            }
            DB::commit();
            return redirect()->route('subsistenceallowancepayment.generatenamehq.index')->with('alert', 'Senarai berjaya disimpan !!');
        }
        catch(Exception $e){
            DB::rollback();
            $audit_details = json_encode([
            ]);	
            $auditLog = new AuditLog();
            $auditLog->log('ESH03', 'store', $audit_details, $e->getMessage());
            return redirect()->back()->with('alert', 'Senarai gagal disimpan !!');
        }
    }

    public function storeListName(Request $request)
    {
        $lists = SubPaymentHq::find($request->id);
        $lists->status = 'Dihantar';
        $lists->save();
        
        return redirect()->route('subsistenceallowancepayment.generatenamehq.index')->with('alert', 'Senarai berjaya dihantar !!');
    }

    // public function updateStatus($id, $status)
    // {
    //     $list = SubsistenceListQuota::findOrFail($id);
    //     $list->update(['status' => $status]);

    //     return redirect()->back()->with('success', 'Status berjaya dikemaskini!');
    // }

    public function destroy($id)
    {
        $subPaymentHq = SubPaymentHq::find($id);
        $subPayments = SubPaymentState::where('subsistence_payment_hq_id',$id)->get();
        foreach ($subPayments as $subPayment) {
            $subPayment->subsistence_payment_hq_id = null;
            $subPayment->updated_by = Auth::user()->id;
            $subPayment->save();
        }
        $subPaymentHq->delete();
        return redirect()->back()->with('success', 'Senarai berjaya dipadam!');
    }

    public function print($id)
    {
        $subPaymentHq = SubPaymentHq::find($id);
        
        $plsId = Entity::where('entity_level',2)->where('state_code','09')->first()->id;
        $kdhId = Entity::where('entity_level',2)->where('state_code','02')->first()->id;
        $pngId = Entity::where('entity_level',2)->where('state_code','07')->first()->id;
        $prkId = Entity::where('entity_level',2)->where('state_code','08')->first()->id;
        $slgId = Entity::where('entity_level',2)->where('state_code','10')->first()->id;
        $n9Id = Entity::where('entity_level',2)->where('state_code','05')->first()->id;
        $mlkId = Entity::where('entity_level',2)->where('state_code','04')->first()->id;
        $jhrId = Entity::where('entity_level',2)->where('state_code','01')->first()->id;
        $phgId = Entity::where('entity_level',2)->where('state_code','06')->first()->id;
        $trgId = Entity::where('entity_level',2)->where('state_code','11')->first()->id;
        $klnId = Entity::where('entity_level',2)->where('state_code','03')->first()->id;
        $swkId = Entity::where('entity_level',2)->where('state_code','13')->first()->id;
        $sbhId = Entity::where('entity_level',2)->where('state_code','12')->first()->id;

        $spPlsIds = SubPaymentState::where('subsistence_payment_hq_id',$id)->where('entity_id',$plsId)->pluck('subsistence_payment_states.id')->toArray();
        $spKdhIds = SubPaymentState::where('subsistence_payment_hq_id',$id)->where('entity_id',$kdhId)->pluck('subsistence_payment_states.id')->toArray();
        $spPngIds = SubPaymentState::where('subsistence_payment_hq_id',$id)->where('entity_id',$pngId)->pluck('subsistence_payment_states.id')->toArray();
        $spPrkIds = SubPaymentState::where('subsistence_payment_hq_id',$id)->where('entity_id',$prkId)->pluck('subsistence_payment_states.id')->toArray();
        $spSlgIds = SubPaymentState::where('subsistence_payment_hq_id',$id)->where('entity_id',$slgId)->pluck('subsistence_payment_states.id')->toArray();
        $spN9Ids = SubPaymentState::where('subsistence_payment_hq_id',$id)->where('entity_id',$n9Id)->pluck('subsistence_payment_states.id')->toArray();
        $spMlkIds = SubPaymentState::where('subsistence_payment_hq_id',$id)->where('entity_id',$mlkId)->pluck('subsistence_payment_states.id')->toArray();
        $spJhrIds = SubPaymentState::where('subsistence_payment_hq_id',$id)->where('entity_id',$jhrId)->pluck('subsistence_payment_states.id')->toArray();
        $spPhgIds = SubPaymentState::where('subsistence_payment_hq_id',$id)->where('entity_id',$phgId)->pluck('subsistence_payment_states.id')->toArray();
        $spTrgIds = SubPaymentState::where('subsistence_payment_hq_id',$id)->where('entity_id',$trgId)->pluck('subsistence_payment_states.id')->toArray();
        $spKlnIds = SubPaymentState::where('subsistence_payment_hq_id',$id)->where('entity_id',$klnId)->pluck('subsistence_payment_states.id')->toArray();
        $spSwkIds = SubPaymentState::where('subsistence_payment_hq_id',$id)->where('entity_id',$swkId)->pluck('subsistence_payment_states.id')->toArray();
        $spSbhIds = SubPaymentState::where('subsistence_payment_hq_id',$id)->where('entity_id',$sbhId)->pluck('subsistence_payment_states.id')->toArray();
        
        // dd($spKdhIds);
        // $subPaymentStatesIds = SubPaymentState::where('subsistence_payment_hq_id',$id)->pluck('subsistence_payment_states.id')->toArray();

        $spdPlsIds = SubPayment::whereIn('subsistence_payment_states_id',$spPlsIds)->pluck('subsistence_payments.id')->toArray();
        $spdKdhIds = SubPayment::whereIn('subsistence_payment_states_id',$spKdhIds)->pluck('subsistence_payments.id')->toArray();
        $spdPngIds = SubPayment::whereIn('subsistence_payment_states_id',$spPngIds)->pluck('subsistence_payments.id')->toArray();
        $spdPrkIds = SubPayment::whereIn('subsistence_payment_states_id',$spPrkIds)->pluck('subsistence_payments.id')->toArray();
        $spdSlgIds = SubPayment::whereIn('subsistence_payment_states_id',$spSlgIds)->pluck('subsistence_payments.id')->toArray();
        $spdN9Ids = SubPayment::whereIn('subsistence_payment_states_id',$spN9Ids)->pluck('subsistence_payments.id')->toArray();
        $spdMlkIds = SubPayment::whereIn('subsistence_payment_states_id',$spMlkIds)->pluck('subsistence_payments.id')->toArray();
        $spdJhrIds = SubPayment::whereIn('subsistence_payment_states_id',$spJhrIds)->pluck('subsistence_payments.id')->toArray();
        $spdPhgIds = SubPayment::whereIn('subsistence_payment_states_id',$spPhgIds)->pluck('subsistence_payments.id')->toArray();
        $spdTrgIds = SubPayment::whereIn('subsistence_payment_states_id',$spTrgIds)->pluck('subsistence_payments.id')->toArray();
        $spdKlnIds = SubPayment::whereIn('subsistence_payment_states_id',$spKlnIds)->pluck('subsistence_payments.id')->toArray();
        $spdSwkIds = SubPayment::whereIn('subsistence_payment_states_id',$spSwkIds)->pluck('subsistence_payments.id')->toArray();
        $spdSbhIds = SubPayment::whereIn('subsistence_payment_states_id',$spSbhIds)->pluck('subsistence_payments.id')->toArray();

        // $subPaymentDistrictIds = SubPayment::whereIn('subsistence_payment_states_id',$subPaymentStatesIds)->pluck('subsistence_payments.id')->toArray();

        $payeesPls = SubPaymentPayee::leftJoin('users','users.id','subsistence_payment_payees.user_id')->whereIn('subsistence_payment_id',$spdPlsIds)->where('has_landing',true)->select('name','username as icno')->get();
        $payeesKdh = SubPaymentPayee::leftJoin('users','users.id','subsistence_payment_payees.user_id')->whereIn('subsistence_payment_id',$spdKdhIds)->where('has_landing',true)->select('name','username as icno')->get();
        $payeesPng = SubPaymentPayee::leftJoin('users','users.id','subsistence_payment_payees.user_id')->whereIn('subsistence_payment_id',$spdPngIds)->where('has_landing',true)->select('name','username as icno')->get();
        $payeesPrk = SubPaymentPayee::leftJoin('users','users.id','subsistence_payment_payees.user_id')->whereIn('subsistence_payment_id',$spdPrkIds)->where('has_landing',true)->select('name','username as icno')->get();
        $payeesSlg = SubPaymentPayee::leftJoin('users','users.id','subsistence_payment_payees.user_id')->whereIn('subsistence_payment_id',$spdSlgIds)->where('has_landing',true)->select('name','username as icno')->get();
        $payeesN9 = SubPaymentPayee::leftJoin('users','users.id','subsistence_payment_payees.user_id')->whereIn('subsistence_payment_id',$spdN9Ids)->where('has_landing',true)->select('name','username as icno')->get();
        $payeesMlk = SubPaymentPayee::leftJoin('users','users.id','subsistence_payment_payees.user_id')->whereIn('subsistence_payment_id',$spdMlkIds)->where('has_landing',true)->select('name','username as icno')->get();
        $payeesJhr = SubPaymentPayee::leftJoin('users','users.id','subsistence_payment_payees.user_id')->whereIn('subsistence_payment_id',$spdJhrIds)->where('has_landing',true)->select('name','username as icno')->get();
        $payeesPhg = SubPaymentPayee::leftJoin('users','users.id','subsistence_payment_payees.user_id')->whereIn('subsistence_payment_id',$spdPhgIds)->where('has_landing',true)->select('name','username as icno')->get();
        $payeesTrg = SubPaymentPayee::leftJoin('users','users.id','subsistence_payment_payees.user_id')->whereIn('subsistence_payment_id',$spdTrgIds)->where('has_landing',true)->select('name','username as icno')->get();
        $payeesKln = SubPaymentPayee::leftJoin('users','users.id','subsistence_payment_payees.user_id')->whereIn('subsistence_payment_id',$spdKlnIds)->where('has_landing',true)->select('name','username as icno')->get();
        $payeesSwk = SubPaymentPayee::leftJoin('users','users.id','subsistence_payment_payees.user_id')->whereIn('subsistence_payment_id',$spdSwkIds)->where('has_landing',true)->select('name','username as icno')->get();
        $payeesSbh = SubPaymentPayee::leftJoin('users','users.id','subsistence_payment_payees.user_id')->whereIn('subsistence_payment_id',$spdSbhIds)->where('has_landing',true)->select('name','username as icno')->get();

        $count = $payeesPls->count() +
            $payeesKdh->count() +
            $payeesPng->count() +
            $payeesPrk->count() +
            $payeesSlg->count() +
            $payeesN9->count() +
            $payeesMlk->count() +
            $payeesJhr->count() +
            $payeesPhg->count() +
            $payeesTrg->count() +
            $payeesKln->count() +
            $payeesSwk->count() +
            $payeesSbh->count();
        // $count = SubPaymentPayee::whereIn('subsistence_payment_id',$subPaymentDistrictIds)->where('has_landing',true)->count();



        $pdf = PDF::loadView(
            'app.subsistence_allowance_payment.generatenamehq.memopdf',
            compact(
                'subPaymentHq',
                
                'payeesPls',
                'payeesKdh',
                'payeesPng',
                'payeesPrk',
                'payeesSlg',
                'payeesN9',
                'payeesMlk',
                'payeesJhr',
                'payeesPhg',
                'payeesTrg',
                'payeesKln',
                'payeesSwk',
                'payeesSbh',

                'count'
            )
        );
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        // $pdf->getDomPDF()->set_option('enable_php', true);
        return $pdf->stream('memo.pdf');
    }

    // public function generateListNamePDF($id)
    // {
    //     // Ambil senarai permohonan dari database
    //     $applications = SubApplication::orderBy('created_at', 'asc')
    //     ->where('batch_id', $id)->get();

        
    //     $list = SubsistenceListQuota::findOrFail($id);
    //     $list->update(['status' => 'Dicetak']);


    //     $pdf = PDF::loadView('app.subsistence_allowance_payment.generatenamehq.applistnamepdf',  compact('applications'));
    //     $pdf->setPaper('A4', 'landscape');
    //     $pdf->getDomPDF()->set_option('enable_php', true);
        

    //     // View on page
    //     return $pdf->stream('senarai_permohonan.pdf');
    // }

    // public function verifyListName(Request $request)
    // {
    //     // Ensure request is received
    //     if (!$request->has('application_id')) {
    //         return back()->with('error', 'Application ID missing!');
    //     }
    
    //     // Find the application
    //     $application = SubApplication::findOrFail($request->application_id);
    
    //     // Get batch details
    //     $appq = SubsistenceListQuota::findOrFail($application->batch_id);
    
    //     // Get all applications under the same batch
    //     $applications = SubApplication::where('batch_id', $application->batch_id)
    //         ->orderBy('created_at', 'asc')
    //         ->get();

           
    
    //     // Count already approved applications
    //     $approvedCount = $applications->where('status_quota', 'layak diluluskan')->count();

    //     if ($request->status == 'ditolak') {
    //         $application->status_quota = 'ditolak';

    //         $application->sub_application_status = 'Permohonan Ditolak Peringkat Negeri';
    //     } 
    //     else {
    //         if ($approvedCount < $appq->quota) {
    //             $application->status_quota = 'layak diluluskan';  // Approve if quota is available

    //             $application->sub_application_status = 'Permohonan Diluluskan Peringkat Negeri';

    //         } else {
    //             $application->status_quota = 'layak tidak diluluskan';  // Reject if quota exceeded

    //             $application->sub_application_status = 'Permohonan Tidak Diluluskan Peringkat Negeri';
               

    //             // Get an existing batch_id from the latest quota record
    //             // $existingBatch = SubsistenceListQuota::whereNotNull('id')->where('status', 'Dijana')->latest('created_at')->value('id');

    //             // if ($existingBatch) {
    //             //     $application->batch_id = $existingBatch; // Assign the latest existing batch_id
    //             // } else {
    //             //     $application->batch_id = null;  // Fallback to a new batch_id if none exist
    //             // }
    //         }
    //     }

    //     $application->save();
    
    //     return back()->with('success', 'Status berjaya dikemaskini!');
    // }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $applications = SubPaymentHq::find($id);
        $statesIds = SubPaymentState::where('subsistence_payment_hq_id',$id)->pluck('id')->toArray();
        $distictIds = SubPayment::whereIn('subsistence_payment_states_id',$statesIds)->pluck('id')->toArray();
        $payees = SubPaymentPayee::whereIn('subsistence_payment_id',$distictIds)->sortable();

        return view('app.subsistence_allowance_payment.generatenamehq.edit', [
            'application' => $applications,
            'payees' => $request->has('sort') ? $payees->paginate(10) : $payees->orderBy('created_at')->paginate(10), 
            'id' => $id
        ]);
    }
}
