<?php

namespace App\Http\Controllers\SubsistenceAllowanceRenewal;
use Illuminate\Http\Request;

use App\Models\SubsistenceAllowance\SubsistenceList;
use App\Models\SubsistenceAllowance\SubApplication;


use App\Http\Controllers\Controller;
use Auth;
use Audit;
use Hash;
use Exception;
use Carbon\Carbon;
use Storage;
use Module;
use Helper;
use DB;
use Carbon\CarbonImmutable;
use App\Models\CodeMaster;

use Barryvdh\DomPDF\Facade\Pdf;

class SubAllowanceRenewalGenerateNameHQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listhq(Request $request)
    {

        $lists = SubsistenceList::wherein('status', ['Dihantar']);

        return view('app.subsistence_allowance_renewal.generatenamehq.listhq',  [
            'lists' => $request->has('sort') ? $lists->paginate(10) : $lists->orderBy('created_at','desc')->paginate(10), 
            
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
    public function edithq(Request $request, $id)
    {
        
         /// Ambil senarai permohonan dari database
         $applications = SubApplication::orderBy('registration_no', 'asc')
         ->where('batch_id', $id)
         ->where('status_quota', 'layak diluluskan');
 
         return view('app.subsistence_allowance_renewal.generatenamehq.edithq', [
             'applications' => $request->has('sort') ? $applications->paginate(10) : $applications->orderBy('created_at')->paginate(10), 
             'id' => $id
         ]);

    }

    public function verifyHq(Request $request)
    {
        // Find the document
        $app = SubApplication::findOrFail($request->application_id);

        // Update the verification status
        if($request->status == 'diluluskan')
        {
            $app->status_hq = $request->status; 
            $app->sub_application_status = 'Permohonan Diluluskan Peringkat HQ';

            // 130325 Arifah - Tambah approved date & expired date
            $immutable = CarbonImmutable::now();
            $modifiedImmutable = CarbonImmutable::now()->add(1, 'year');
            $app->application_approved_date = date("Y-m-d");
            $app->application_expired_date = $modifiedImmutable->format('Y-m-d');

            $app->save();
        }
        else if($request->status == 'ditolak') {

            $app->status_hq = $request->status; 
            $app->sub_application_status = 'Permohonan Tidak Diluluskan Peringkat HQ';
            $app->save();

        }
       

       

        // Redirect back with success message
        return back()->with('success', 'Status dokumen berjaya dikemaskini!');
    }

    public function generateHqPDF($id)
    {
        // Ambil senarai permohonan dari database
        $applications = SubApplication::orderBy('created_at', 'desc')
        ->where('status_quota', 'layak diluluskan')
        ->where('batch_id', $id)->get();


        $pdf = PDF::loadView('app.subsistence_allowance_renewal.generatenamehq.applisthqpdf',  compact('applications'));
        $pdf->setPaper('A4', 'portrait');
        $pdf->getDomPDF()->set_option('enable_php', true);

        // View on page
        return $pdf->stream('senarai_permohonan.pdf');
    }

    public function generateListNameHqPDF($id)
    {
        // Ambil senarai permohonan dari database
        $applications = SubApplication::orderBy('created_at', 'asc')
        ->where('status_quota', 'layak diluluskan')
        // ->wherein('status_hq', ['diluluskan', 'ditolak'])
        ->where('batch_id', $id)->get();

        // $list = SubsistenceList::findOrFail($id);
        // $list->update(['status' => 'Dicetak']);

        $pdf = PDF::loadView('app.subsistence_allowance_renewal.generatenamehq.applistnamehqpdf',  compact('applications'));
        $pdf->setPaper('A4', 'landscape');
        $pdf->getDomPDF()->set_option('enable_php', true);
        

        // View on page
        return $pdf->stream('senarai_permohonan.pdf');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

   
}
