<?php

namespace App\Http\Controllers\SubsistenceAllowancePayment;
use Illuminate\Http\Request;
use App\Models\SubsistenceAllowance\SubsistenceListQuota;
use App\Models\SubsistenceAllowance\SubApplication;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\SubsistencePayment\SubPayment;
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


class SubPayGenerateNameStateController extends Controller
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
        
        if(Auth::user()->name == 'Super Admin'){
            $lists = SubPayment::sortable();
        }
        else{
            $lists = SubPaymentState::where('entity_id', $entity_id)->sortable();
        }

        return view('app.subsistence_allowance_payment.generatenamestate.index',  [
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
        $user = User::find(Auth::user()->id);

        $activeESH = SubPayment::leftJoin('entities','entities.id','subsistence_payments.entity_id')
        ->leftJoin('subsistence_payment_payees','subsistence_payment_payees.subsistence_payment_id','subsistence_payments.id')
        ->where('subsistence_payment_states_id',null)
        ->where('year',$request->selYear)
        ->where('month',$request->selMonth)
        ->where('parent_id',$entity_id)
        ->where('status','Disokong Daerah')
        ->whereNull('subsistence_payment_states_id')
        ->sortable();
        
        return view('app.subsistence_allowance_payment.generatenamestate.create',  [
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
            $entity = Entity::find($request->entity_id);

            $activeESHs = SubPayment::leftJoin('entities','entities.id','subsistence_payments.entity_id')
            ->where('subsistence_payment_states_id',null)
            ->where('year',$request->selYear)
            ->where('month',$request->selMonth)
            ->where('status','Disokong Daerah')
            ->whereNull('subsistence_payment_states_id')
            ->where('parent_id',$entity->id)->select('subsistence_payments.*')->get();

            $stateGen = new SubPaymentState();
            $stateGen->generated_date = Carbon::now();
            $stateGen->status = 'Dijana';
            $stateGen->year = $request->selYear;
            $stateGen->month = $request->selMonth;
            $stateGen->entity_id = $entity->id;
            $stateGen->created_by = Auth::user()->id;
            $stateGen->updated_by = Auth::user()->id;
            $stateGen->save();

            if(!$activeESHs->isEmpty()){
                foreach ($activeESHs as $esh){
                    // $temp = SubPayment::find();
                    $esh->subsistence_payment_states_id = $stateGen->id;
                    $esh->updated_by = Auth::user()->id;
                    $esh->save();
                }
            }
            DB::commit();
            return redirect()->route('subsistenceallowancepayment.generatenamestate.index')->with('alert', 'Senarai berjaya disimpan !!');
        }
        catch(Exception $e){
            DB::rollback();
            $audit_details = json_encode([
            ]);	
            $auditLog = new AuditLog();
            $auditLog->log('ESH03', 'store', $audit_details, $e->getMessage());
            return redirect()->back()->with('alert', 'Senarai gagal disimpan !!');
        }

            // $pendingAppIds = $pendingApps->pluck('id')->toArray(); 

            // // \Log::info('Pending Application IDs:', $pendingAppIds); // Debugging log
            
            // if (!empty($pendingAppIds)) { 
            //     SubApplication::whereIn('id', $pendingAppIds)
            //         ->update([
            //             'status_quota' => 'senarai_menunggu',
            //             'batch_id' => $listq->id,
            //             'sub_application_status' => 'Permohonan Dalam Senarai Menunggu',
            //         ]);
            // }

        

        return redirect()->back()->with('success', 'Senarai berjaya dijana!');
    }

    public function storeListName(Request $request)
    {

        $lists = SubPaymentState::find($request->id);
        $lists->status = 'Dihantar';
        $lists->save();

        // return view('app.subsistence_allowance_payment.generatenamestate.index',  [
        //     // 'lists' =>  $lists,
        //     'lists' => $request->has('sort') ? $lists->paginate(10) : $lists->orderBy('created_at')->paginate(10), 
        // ]);
        return redirect()->route('subsistenceallowancepayment.generatenamestate.index')->with('alert', 'Senarai berjaya dihantar !!');
    }

    public function updateStatus($id, $status)
    {
        $list = SubsistenceListQuota::findOrFail($id);
        $list->update(['status' => $status]);

        return redirect()->back()->with('success', 'Status berjaya dikemaskini!');
    }

    public function destroy($id)
    {
        $subPaymentState = SubPaymentState::find($id);
        $subPayments = SubPayment::where('subsistence_payment_states_id',$id)->get();
        foreach ($subPayments as $subPayment) {
            $subPayment->subsistence_payment_states_id = null;
            $subPayment->updated_by = Auth::user()->id;
            $subPayment->save();
        }
        $subPaymentState->delete();
        return redirect()->back()->with('success', 'Senarai berjaya dipadam!');
    }

    public function generatePDF($id)
    {
        // Ambil senarai permohonan dari database
        $applications = SubApplication::orderBy('created_at', 'desc')
        ->where('batch_id', $id)->get();


        $pdf = PDF::loadView('app.subsistence_allowance_payment.generatenamestate.applistpdf',  compact('applications'));
        $pdf->setPaper('A4', 'portrait');
        $pdf->getDomPDF()->set_option('enable_php', true);

        // View on page
        return $pdf->stream('senarai_permohonan.pdf');
    }

    public function generateListNamePDF($id)
    {
        // Ambil senarai permohonan dari database
        $applications = SubApplication::orderBy('created_at', 'asc')
        ->where('batch_id', $id)->get();

        
        $list = SubsistenceListQuota::findOrFail($id);
        $list->update(['status' => 'Dicetak']);


        $pdf = PDF::loadView('app.subsistence_allowance_payment.generatenamestate.applistnamepdf',  compact('applications'));
        $pdf->setPaper('A4', 'landscape');
        $pdf->getDomPDF()->set_option('enable_php', true);
        

        // View on page
        return $pdf->stream('senarai_permohonan.pdf');
    }

    public function verifyListName(Request $request)
    {
        // Ensure request is received
        if (!$request->has('application_id')) {
            return back()->with('error', 'Application ID missing!');
        }
    
        // Find the application
        $application = SubApplication::findOrFail($request->application_id);
    
        // Get batch details
        $appq = SubsistenceListQuota::findOrFail($application->batch_id);
    
        // Get all applications under the same batch
        $applications = SubApplication::where('batch_id', $application->batch_id)
            ->orderBy('created_at', 'asc')
            ->get();

           
    
        // Count already approved applications
        $approvedCount = $applications->where('status_quota', 'layak diluluskan')->count();

        if ($request->status == 'ditolak') {
            $application->status_quota = 'ditolak';

            $application->sub_application_status = 'Permohonan Ditolak Peringkat Negeri';
        } 
        else {
            if ($approvedCount < $appq->quota) {
                $application->status_quota = 'layak diluluskan';  // Approve if quota is available

                $application->sub_application_status = 'Permohonan Diluluskan Peringkat Negeri';

            } else {
                $application->status_quota = 'layak tidak diluluskan';  // Reject if quota exceeded

                $application->sub_application_status = 'Permohonan Tidak Diluluskan Peringkat Negeri';
               

                // Get an existing batch_id from the latest quota record
                // $existingBatch = SubsistenceListQuota::whereNotNull('id')->where('status', 'Dijana')->latest('created_at')->value('id');

                // if ($existingBatch) {
                //     $application->batch_id = $existingBatch; // Assign the latest existing batch_id
                // } else {
                //     $application->batch_id = null;  // Fallback to a new batch_id if none exist
                // }
            }
        }

        $application->save();
    
        return back()->with('success', 'Status berjaya dikemaskini!');
    }
    
    

   

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

        /// Ambil senarai permohonan dari database
        $applications = SubPaymentState::find($id);
        $distictIds = SubPayment::where('subsistence_payment_states_id',$id)->pluck('id')->toArray();
        $payees = SubPaymentPayee::whereIn('subsistence_payment_id',$distictIds)->sortable();

        return view('app.subsistence_allowance_payment.generatenamestate.edit', [
            'application' => $applications,
            'payees' => $request->has('sort') ? $payees->paginate(10) : $payees->orderBy('created_at')->paginate(10), 
            'id' => $id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

   
}
