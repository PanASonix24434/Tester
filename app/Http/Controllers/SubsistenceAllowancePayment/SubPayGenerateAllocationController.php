<?php

namespace App\Http\Controllers\SubsistenceAllowancePayment;
use Illuminate\Http\Request;
use App\Models\SubsistenceAllowance\SubsistenceListQuota;
use App\Models\SubsistenceAllowance\SubApplication;

use App\Http\Controllers\Controller;
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


class SubPayGenerateAllocationController extends Controller
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
        $lists = SubPaymentHq::whereIn('status', ['Dihantar','Dilulus PBKP'])->sortable();

        return view('app.subsistence_allowance_payment.generateallocation.index',  [
            'lists' => $request->has('sort') ? $lists->paginate(10) : $lists->orderBy('created_at')->paginate(10),
            'entity_id' => $entity_id,
        ]);
    }

    public function storeListName(Request $request)
    {

        $lists = SubPaymentHq::find($request->id);
        $lists->status = 'Dilulus PBKP';
        $lists->save();
        return redirect()->route('subsistenceallowancepayment.generateallocation.index')->with('alert', 'Senarai berjaya dihantar !!');
    }

    // public function updateStatus($id, $status)
    // {
    //     $list = SubsistenceListQuota::findOrFail($id);
    //     $list->update(['status' => $status]);

    //     return redirect()->back()->with('success', 'Status berjaya dikemaskini!');
    // }

    // public function destroy($id)
    // {
    //     SubPayment::findOrFail($id)->delete();
    //     return redirect()->back()->with('success', 'Senarai berjaya dipadam!');
    // }

    // public function generatePDF($id)
    // {
    //     // Ambil senarai permohonan dari database
    //     $applications = SubApplication::orderBy('created_at', 'desc')
    //     ->where('batch_id', $id)->get();


    //     $pdf = PDF::loadView('app.subsistence_allowance_payment.generateallocation.applistpdf',  compact('applications'));
    //     $pdf->setPaper('A4', 'portrait');
    //     $pdf->getDomPDF()->set_option('enable_php', true);

    //     // View on page
    //     return $pdf->stream('senarai_permohonan.pdf');
    // }

    // public function generateListNamePDF($id)
    // {
    //     // Ambil senarai permohonan dari database
    //     $applications = SubApplication::orderBy('created_at', 'asc')
    //     ->where('batch_id', $id)->get();

        
    //     $list = SubsistenceListQuota::findOrFail($id);
    //     $list->update(['status' => 'Dicetak']);


    //     $pdf = PDF::loadView('app.subsistence_allowance_payment.generateallocation.applistnamepdf',  compact('applications'));
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
    //     $payee = SubPaymentPayee::find($request->application_id);
    
    //     // Get batch details
    //     // $appq = SubsistenceListQuota::findOrFail($application->batch_id);
    
    //     // Get all applications under the same batch
    //     // $applications = SubApplication::where('batch_id', $application->batch_id)
    //     //     ->orderBy('created_at', 'asc')
    //     //     ->get();

           
    
    //     // Count already approved applications
    //     // $approvedCount = $applications->where('status_quota', 'layak diluluskan')->count();

    //     if ($request->status == 'sokong') {
    //         $payee->decision_district = 'Sokong';
    //     } 
    //     elseif ($request->status == 'tidak sokong') {
    //         $payee->decision_district = 'Tidak Sokong';
    //     }
    //     $payee->save();
    
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
        $stateIds = SubPaymentState::where('subsistence_payment_hq_id',$id)->pluck('id')->toArray();
        $districtIds = SubPayment::whereIn('subsistence_payment_states_id',$stateIds)->pluck('id')->toArray();
        $payees = SubPaymentPayee::whereIn('subsistence_payment_id', $districtIds)->sortable();

        return view('app.subsistence_allowance_payment.generateallocation.edit', [
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
