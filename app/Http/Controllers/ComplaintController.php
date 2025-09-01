<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Complaint;
use App\Models\ComplaintLog;

use Auth;
use Audit;
use Hash;
use DB;
use Exception;
use Carbon\Carbon;
use PDF;
use Storage;
use Image;
use Helper;

//Mail
use Mail;
use App\Mail\ComplaintReceived;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('app.complaint.index', [		

		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.complaint.create', [		
            'return_value' => null,
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'txtName' => 'required|string|max:255',
            'txtEmel' => 'required|string|email|max:50',
        ],
        [
            'name.required' => 'Nama Penuh diperlukan.',
            'email.required' => 'Emel diperlukan.',
            'email.email' => 'Format emel yang dimasukkan tidak sah.',
        ]);

        DB::beginTransaction();

        try {

            $running_no = Complaint::orderby('complaint_no','DESC')
            ->limit(1)
            ->get();

            //store your file into database
			$com = new Complaint();

            $com->id = $request->hide_aid;

            if(count($running_no) == 0){
                $com->complaint_no = 1;
                $return_value = 1;
            }else{
                
                $return_value = $running_no[0]->complaint_no + 1;
                $com->complaint_no = $return_value;
            }
            
            $com->title = $request->txtTitle;
            $com->description = strtoupper($request->txtDesc);
            $com->name = $request->txtName;
            $com->email = $request->txtEmel;
            $com->phone_no = "+60".$request->txtPhoneNo;
            //$com->assign_to = ;
            $com->complaint_type = $request->selComplaintType;
            $com->complaint_status = 1;

            if ($request->file('fileDoc')) {

                $file = $request->file('fileDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;				
                $path = $request->file('fileDoc')->store('public/aduan');

                $com->file_path = $path;
                $com->file_name = $filename;
            }

            $com->save();

            //Insert Complaint Log

            $logs = new ComplaintLog();
            $logs->complaint_id = $request->hide_aid;
            $logs->status = 1;
            $logs->remark = 'Aduan Dihantar';
            $logs->save();
                
            $audit_details = json_encode([ 
                'title' => $request->txtTitle,
                'description' => $request->txtDesc,
                'name'=> $request->txtName,
                'email' => $request->txtEmel,
                'phone_no' => $request->txtPhoneNo,
                'complaint_type' => $request->selComplaintType, 
            ]);

            Audit::log('complaint', 'add', $audit_details);
            
            DB::commit();

            //Send email to Pengadu ================================

            $mailDataArr = array(
                'complaint_no' => $return_value,
            );

            if(!empty($request->txtEmel)){
                Mail::to($request->txtEmel)->queue(new ComplaintReceived($mailDataArr));
            }
            
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'title' => $request->txtTitle,
                'description' => $request->txtDesc,
                'name'=> $request->txtName,
                'email' => $request->txtEmel,
                'phone_no' => $request->txtPhoneNo,
                'complaint_type' => $request->selComplaintType, 
            ]);

            Audit::log('complaint', 'add', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return view('app.complaint.create', [		
            'return_value' => $return_value,
		]);

        //return redirect()->action('Auth\AuthenticatedSessionController@welcome')->with('t_success', 'Aduan anda telah berjaya dihantar.');

        /*return redirect()->back()
            ->with('sa_success', __('app.data_submitted', [
                'type' => __('module.ticket'),
            ]));*/
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
