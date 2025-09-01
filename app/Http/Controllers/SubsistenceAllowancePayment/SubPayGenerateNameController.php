<?php

namespace App\Http\Controllers\SubsistenceAllowancePayment;
use Illuminate\Http\Request;
use App\Models\SubsistenceAllowance\SubsistenceListQuota;
use App\Models\SubsistenceAllowance\SubApplication;

use App\Http\Controllers\Controller;
use App\Models\Helper;
use App\Models\LandingDeclaration\LandingDeclarationMonthly;
use App\Models\SubsistencePayment\SubPayment;
use App\Models\SubsistencePayment\SubPaymentPayee;
use App\Models\Systems\AuditLog;
use App\Models\User;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SubPayGenerateNameController extends Controller
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
            $lists = SubPayment::where('entity_id', $entity_id)->sortable();
        }

        return view('app.subsistence_allowance_payment.generatename.index',  [
            'lists' => $request->has('sort') ? $lists->paginate(10) : $lists->orderBy('created_at')->paginate(10),
            'entity_id' => $entity_id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = User::find(Auth::user()->id);

        // $helper = new Helper();
        // $landingSahStatus = $helper->getCodeMasterIdByTypeName('landing_status','DISAHKAN DAERAH');
        // $landingMonthlies = LandingDeclarationMonthly::where('year',$request->selYear)
        // ->where('month',$request->selMonth)
        // ->where('landing_status_id',$landingSahStatus)
        // ->where(function ($query) {
        //     $query->where('used_in_payment', false)
        //         ->orWhereNull('used_in_payment');
        // })
        // ->get()->pluck('user_id')->toArray();
        $today = Carbon::today();

        $activeESH = SubApplication::leftJoin('users','users.username','subsistence_application.icno')
        // ->whereIn('users.id',$landingMonthlies)
        ->where('subsistence_application.entity_id',$user->entity_id)
        ->where('sub_application_status','Permohonan Diluluskan Peringkat HQ')
        ->where('subsistence_application.application_expired_date','>=',$today)
        ->whereIn('subsistence_application.id', function ($query) {
            $query->select(DB::raw('SUBSTRING_INDEX(GROUP_CONCAT(id ORDER BY subsistence_application.application_expired_date), ",", 1)'))
                ->from('subsistence_application AS inner_table')
                ->groupBy('icno');
        })
        ->select('subsistence_application.*','users.id as user_id')
        ->sortable();

        return view('app.subsistence_allowance_payment.generatename.create',  [
            'lists' => $request->has('sort') ? $activeESH->paginate(10) : $activeESH->orderBy('subsistence_application.created_at')->paginate(10),
            'entity_id' => $user->entity_id,
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
            $user = User::find(Auth::user()->id);

            $helper = new Helper();
            $landingSahStatus = $helper->getCodeMasterIdByTypeName('landing_status','DISAHKAN DAERAH');
            // $landingMonthlies = LandingDeclarationMonthly::where('year',$request->selYear)
            // ->where('month',$request->selMonth)
            // ->where('landing_status_id',$landingSahStatus)
            // ->where(function ($query) {
            //     $query->where('used_in_payment', false)
            //         ->orWhereNull('used_in_payment');
            // })
            // ->get()->pluck('user_id')->toArray();

            $activeESHs = SubApplication::leftJoin('users','users.username','subsistence_application.icno')
            // ->whereIn('users.id',$landingMonthlies)
            ->where('subsistence_application.entity_id',$user->entity_id)
            ->where('sub_application_status','Permohonan Diluluskan Peringkat HQ')
            ->whereIn('subsistence_application.id', function ($query) {
                $query->select(DB::raw('SUBSTRING_INDEX(GROUP_CONCAT(id ORDER BY subsistence_application.application_expired_date), ",", 1)'))
                    ->from('subsistence_application AS inner_table')
                    ->groupBy('icno');
            })
            ->select('users.id as user_id','icno')->get();

            // $totalApplicants = SubApplication::leftJoin('entities','entities.id','subsistence_application.entity_id')
            // ->where('sub_application_status', 'Permohonan Disokong KDP')->select('subsistence_application.*')->count();
            $subPayment = null;
            $today = Carbon::now();
            if(!$activeESHs->isEmpty()){
                $subPayment = new SubPayment();
                $subPayment->generated_date = $today;
                $subPayment->status = 'Dijana';
                $subPayment->year = $request->selYear;
                $subPayment->month = $request->selMonth;
                $subPayment->entity_id = $user->entity_id;
                $subPayment->created_by = Auth::user()->id;
                $subPayment->updated_by = Auth::user()->id;
                $subPayment->save();

                foreach ($activeESHs as $esh){
                    // $user = User::where('username',$esh->icno)->first();

                    $landingMonthly = LandingDeclarationMonthly::where('user_id',$esh->user_id)
                    ->where('landing_status_id',$landingSahStatus)
                    ->where('year',$request->selYear)
                    ->where('month',$request->selMonth)->select('id','used_in_payment','has_payed')->latest()->first();

                    if($landingMonthly != null){
                        $landingMonthly->used_in_payment = true;
                        $landingMonthly->save();
                    }

                    $payee = new SubPaymentPayee();
                    $payee->subsistence_payment_id = $subPayment->id;
                    $payee->user_id = $esh->user_id;
                    if ($landingMonthly != null) {
                        $payee->has_landing = true;
                        $payee->landing_monthly_id = $landingMonthly->id;

                        if ($landingMonthly->used_in_payment){
                            $payee->in_process = true;
                            if($landingMonthly->has_payed){
                                $payee->have_paid = true;
                            }
                            // else{
                            //     $payee->have_paid = false;
                            // }
                        }
                        // else{
                        //     $payee->in_process = false;
                        //     $payee->have_paid = false;
                        // }
                    }
                    // else{
                    //     $payee->has_landing = false;
                    //     $payee->in_process = false;
                    //     $payee->have_paid = false;
                    // }

                    $payee->created_by = Auth::user()->id;
                    $payee->updated_by = Auth::user()->id;
                    $payee->save();
                }
            }
            DB::commit();
            return redirect()->route('subsistenceallowancepayment.generatenamedistrict.index')->with('alert', 'Senarai berjaya disimpan !!');
        }
        catch(Exception $e){
            DB::rollback();
            $audit_details = json_encode([
            ]);	
            $auditLog = new AuditLog();
            $auditLog->log('ESH03', 'store', $audit_details, $e->getMessage());
            return redirect()->back()->with('alert', 'Senarai gagal disimpan !!');
        }
        
        return redirect()->back()->with('success', 'Senarai berjaya dijana!');
    }

    public function storeListName(Request $request)
    {

        $lists = SubPayment::find($request->id);
        $lists->status = 'Dihantar';
        $lists->save();

        // return view('app.subsistence_allowance_payment.generatename.index',  [
        //     // 'lists' =>  $lists,
        //     'lists' => $request->has('sort') ? $lists->paginate(10) : $lists->orderBy('created_at')->paginate(10), 
        // ]);
        return redirect()->route('subsistenceallowancepayment.generatenamedistrict.index')->with('alert', 'Senarai berjaya dihantar !!');
    }

    public function updateStatus($id, $status)
    {
        $list = SubsistenceListQuota::findOrFail($id);
        $list->update(['status' => $status]);

        return redirect()->back()->with('success', 'Status berjaya dikemaskini!');
    }

    public function destroy($id)
    {
        $helper = new Helper();
        $landingSahStatus = $helper->getCodeMasterIdByTypeName('landing_status','DISAHKAN DAERAH');

        $subPayment = SubPayment::find($id);
        $payees = SubPaymentPayee::where('subsistence_payment_id',$id)->get();

        foreach ($payees as $payee) {
            $landingMonthly = LandingDeclarationMonthly::where('year',$subPayment->year)
            ->where('month',$subPayment->month)->where('landing_status_id',$landingSahStatus)
            ->where('user_id',$payee->user_id)->latest()->first();
            $landingMonthly->used_in_payment = false;
            $landingMonthly->save();
            $payee->delete();
        }
        $subPayment->delete();
        //             $payee = new SubPaymentPayee();
        //             $payee->subsistence_payment_id = $subPayment->id;
        //             $payee->user_id = $user->id;
        //             $payee->created_by = Auth::user()->id;
        //             $payee->updated_by = Auth::user()->id;
        //             $payee->save();
        
        // $user = User::where('username',$esh->icno)->first();

        

        return redirect()->back()->with('success', 'Senarai berjaya dipadam!');
    }

    public function generatePDF($id)
    {
        // Ambil senarai permohonan dari database
        $applications = SubApplication::orderBy('created_at', 'desc')
        ->where('batch_id', $id)->get();


        $pdf = PDF::loadView('app.subsistence_allowance_payment.generatename.applistpdf',  compact('applications'));
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


        $pdf = PDF::loadView('app.subsistence_allowance_payment.generatename.applistnamepdf',  compact('applications'));
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
        $applications = SubPayment::find($id);
        $payees = SubPaymentPayee::where('subsistence_payment_id',$id)->sortable();

        return view('app.subsistence_allowance_payment.generatename.edit', [
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
