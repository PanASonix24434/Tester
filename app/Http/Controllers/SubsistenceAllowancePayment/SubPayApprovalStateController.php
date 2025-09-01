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


class SubPayApprovalStateController extends Controller
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
        $lists = SubPaymentState::where('entity_id', $entity_id)->whereIn('status', ['Dihantar','Dilulus Negeri'])->sortable();

        return view('app.subsistence_allowance_payment.approvalstate.index',  [
            'lists' => $request->has('sort') ? $lists->paginate(10) : $lists->orderBy('created_at')->paginate(10),
            'entity_id' => $entity_id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create(Request $request, $entity_id)
    // {

    //     $activeESH = SubApplication::where('entity_id',$entity_id)->where('sub_application_status','Permohonan Diluluskan Peringkat HQ')->sortable();
    //     return view('app.subsistence_allowance_payment.approvalstate.create',  [
    //         'lists' => $request->has('sort') ? $activeESH->paginate(10) : $activeESH->orderBy('created_at')->paginate(10),
    //         'entity_id' => $entity_id,
    //     ]);
    // }

    

    

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

            $activeESHs = SubApplication::where('entity_id',$entity->id)
            ->where('sub_application_status','Permohonan Diluluskan Peringkat HQ')
            ->select('icno')->latest()->get()->unique();

            // $totalApplicants = SubApplication::leftJoin('entities','entities.id','subsistence_application.entity_id')
            // ->where('sub_application_status', 'Permohonan Disokong KDP')->select('subsistence_application.*')->count();
            $subPayment = null;
            if(!$activeESHs->isEmpty()){
                $subPayment = new SubPayment();
                $subPayment->generated_date = Carbon::now();
                $subPayment->status = 'Dijana';
                $subPayment->entity_id = $entity->id;
                $subPayment->created_by = Auth::user()->id;
                $subPayment->updated_by = Auth::user()->id;
                $subPayment->save();

                foreach ($activeESHs as $esh){
                    $user = User::where('username',$esh->icno)->first();

                    $payee = new SubPaymentPayee();
                    $payee->subsistence_payment_id = $subPayment->id;
                    $payee->user_id = $user->id;
                    $payee->created_by = Auth::user()->id;
                    $payee->updated_by = Auth::user()->id;
                    $payee->save();
                }
            }
            DB::commit();
            return redirect()->route('subsistenceallowancepayment.approvalstate.index')->with('alert', 'Senarai berjaya disimpan !!');
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
        $lists->status = 'Dilulus Negeri';
        $lists->save();

        // return view('app.subsistence_allowance_payment.approvalstate.index',  [
        //     // 'lists' =>  $lists,
        //     'lists' => $request->has('sort') ? $lists->paginate(10) : $lists->orderBy('created_at')->paginate(10), 
        // ]);
        return redirect()->route('subsistenceallowancepayment.approvalstate.index')->with('alert', 'Senarai berjaya dihantar !!');
    }

    public function updateStatus($id, $status)
    {
        $list = SubsistenceListQuota::findOrFail($id);
        $list->update(['status' => $status]);

        return redirect()->back()->with('success', 'Status berjaya dikemaskini!');
    }

    public function destroy($id)
    {
        SubPayment::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Senarai berjaya dipadam!');
    }

    public function generatePDF($id)
    {
        // Ambil senarai permohonan dari database
        $applications = SubApplication::orderBy('created_at', 'desc')
        ->where('batch_id', $id)->get();


        $pdf = PDF::loadView('app.subsistence_allowance_payment.approvalstate.applistpdf',  compact('applications'));
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


        $pdf = PDF::loadView('app.subsistence_allowance_payment.approvalstate.applistnamepdf',  compact('applications'));
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
        $payee = SubPaymentPayee::find($request->application_id);
    
        // Get batch details
        // $appq = SubsistenceListQuota::findOrFail($application->batch_id);
    
        // Get all applications under the same batch
        // $applications = SubApplication::where('batch_id', $application->batch_id)
        //     ->orderBy('created_at', 'asc')
        //     ->get();

           
    
        // Count already approved applications
        // $approvedCount = $applications->where('status_quota', 'layak diluluskan')->count();

        if ($request->status == 'sokong') {
            $payee->decision_district = 'Sokong';
        } 
        elseif ($request->status == 'tidak sokong') {
            $payee->decision_district = 'Tidak Sokong';
        }
        $payee->save();
    
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
        $districtIds = SubPayment::where('subsistence_payment_states_id',$id)->pluck('id')->toArray();
        $payees = SubPaymentPayee::whereIn('subsistence_payment_id', $districtIds)->sortable();

        return view('app.subsistence_allowance_payment.approvalstate.edit', [
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
