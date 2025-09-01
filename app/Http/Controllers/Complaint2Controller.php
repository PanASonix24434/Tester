<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Complaint;
use App\Models\ComplaintLog;
use App\Models\User;
use App\Models\Authorization\Role;

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
use Illuminate\Support\Str;

//Mail
use Mail;
use App\Mail\ComplaintTest;
use App\Mail\AduanPengadu;

class Complaint2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function complaintlist(Request $request)
    {
        $complaints = Complaint::whereNull('deleted_by')
        ->leftjoin('user_role','complaints.assign_to','=','user_role.role_id')
        ->where('user_role.user_id', Auth::id())
        ->orwhere('assign_to', null);
        //->where('assign_to', Auth::id())

        $filterComplaintNo = !empty($request->txtComplaintNo) ? $request->txtComplaintNo : '';
        $filterComplaintName = !empty($request->txtName) ? $request->txtName : '';
        $filterStatus = !empty($request->selStatus) ? $request->selStatus : '';

        if (!empty($filterComplaintNo)) {
            $complaints->where('complaints.complaint_no', 'like', '%'.$filterComplaintNo.'%');
        }

        if (!empty($filterComplaintName)) {
            $complaints->where('complaints.name', 'like', '%'.$filterComplaintName.'%');
        }

        if (!empty($filterStatus)) {
            $complaints->where('complaints.complaint_status', '=', $filterStatus);
        }

        return view('app.complaint2.index', [		
            'complaints' => $complaints->orderBy('complaint_no','DESC')->paginate(10),
            'filterComplaintNo' => $filterComplaintNo,
            'filterComplaintName' => $filterComplaintName,
            'filterStatus' => $filterStatus,
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
        //
    }

    public function complaintview(Request $request, string $id)
    {
        $complaints = Complaint::find($id);

        /*$complaintLogs = Complaint::join('complaint_logs','complaints.id','=','complaint_logs.complaint_id')
        ->where('complaints.id', $id)
        ->select('complaints.complaint_status','complaint_logs.*');*/

        $complaintLogs = ComplaintLog::where('complaint_id', $id);

        return view('app.complaint2.view', [		
            'id' => $id,
            'complaints' => $complaints,
            'complaintLogs' => $complaintLogs->orderBy('updated_at','DESC')->paginate(10)
		]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function editAssign(string $id)
    {
        $complaints = Complaint::find($id);

        /*$users = User::join('user_role','users.id','=','user_role.user_id')
        ->join('roles','user_role.role_id','=','roles.id')
        ->select('users.*')
        ->distinct()
        ->get();*/

        $roles = Role::where('is_active', 1)
        ->whereNotIn('name',['PELESEN'])
        ->get();

        return view('app.complaint2.editAssign', [		
            'id' => $id,
            'complaints' => $complaints,
            'roles' => $roles
		]);
    }

    public function editSolve(string $id)
    {
        $complaints = Complaint::find($id);

        return view('app.complaint2.editSolve', [		
            'id' => $id,
            'complaints' => $complaints,
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updateAssign(Request $request, string $id)
    {
        DB::beginTransaction();

        try {

            //store your file into database
			$com = Complaint::find($id);

            $com->assign_to = $request->selAssign;
            $com->complaint_status = 2;

            $com->updated_by = Auth::id();

            $com->save();

            //Insert Complaint Log

            //$userAssign = User::find($request->selAssign);
            $userRole = Role::find($request->selAssign);

            $logs = new ComplaintLog();
            $logs->complaint_id = $id;
            $logs->status = 2;
            $logs->text_assign_to = $userRole->name;
            $logs->remark = $request->txtRemark.' (Aduan Ditugaskan Kepada '.$userRole->name.')'; 

            $logs->created_by = Auth::id();
            $logs->updated_by = Auth::id();
            $logs->save();
                
            $audit_details = json_encode([ 
                'complaint_id' => $id,
                'assign_to' => $request->selAssign,
                'remark' => $request->txtRemark,
                'complaint_status' => 2, 
            ]);

            Audit::log('complaint', 'update-assign', $audit_details);
            
            DB::commit();
            
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'complaint_id' => $id,
                'assign_to' => $request->selAssign,
                'remark' => $request->txtRemark,
                'complaint_status' => 2,  
            ]);

            Audit::log('complaint', 'update-assign', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        /*return view('app.complaint.create', [		
            'return_value' => $return_value,
		]);*/

        return redirect()->action('Complaint2Controller@complaintlist')->with('t_success', 'Aduan anda telah berjaya ditugaskan.');

    }

    public function updateSolve(Request $request, string $id)
    {
        DB::beginTransaction();

        try {

            //store your file into database
			$com = Complaint::find($id);

            $com->complaint_status = 3;
            $com->close_date = Carbon::now();

            $com->updated_by = Auth::id();

            $com->save();

            //Insert Complaint Log

            $logs = new ComplaintLog();
            $logs->complaint_id = $id;
            $logs->status = 3;
            $logs->remark = strtoupper($request->txtRemark); 

            $logs->created_by = Auth::id();
            $logs->updated_by = Auth::id();
            $logs->save();
                
            $audit_details = json_encode([ 
                'complaint_id' => $id,
                'remark' => $request->txtRemark,
                'complaint_status' => 3, 
            ]);

            Audit::log('complaint', 'update-solve', $audit_details);
            
            DB::commit();

            $mailDataArr = array(
                'complaint_no' => $com->complaint_no,
                'complaint_remark' => strtoupper($request->txtRemark),
            );

            //Send email to Pengadu ================================

            if(!empty($com->email)){
                Mail::to($com->email)->queue(new AduanPengadu($mailDataArr));
            }

            //Send email to Pengarah Kanan ================================

            //Get Pengarah Kanan Email
            $kp = User::where('users.is_active', true)
            ->join('user_role','users.id','=','user_role.user_id')
            ->join('roles','user_role.role_id','=','roles.id')
            ->where('roles.name', 'PENGARAH KANAN')
            ->where('roles.is_active',true)
            ->select('users.email')
            ->get();

            if(count($kp) > 0){

                Mail::to($kp[0]->email)->queue(new ComplaintTest($mailDataArr)); 
            }
  
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'complaint_id' => $id,
                'remark' => $request->txtRemark,
                'complaint_status' => 3,  
            ]);

            Audit::log('complaint', 'update-solve', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('Complaint2Controller@complaintlist')->with('t_success', 'Aduan anda telah berjaya diselesaikan.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //Download Document Aduan
    public function downloadDoc($id)
    {
        $complaint = Complaint::find($id);

        if (Storage::exists($complaint->file_path)) {

            //Format - PDF
            if (Str::contains($complaint->file_path, '.pdf'))
            {
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
            }
            //Format - JPG
            elseif(Str::contains($complaint->file_path, '.jpg'))
            {
                $headers = [
                    'Content-Type' => 'application/jpg',
                ];
            }
            //Format - PNG
            elseif(Str::contains($complaint->file_path, '.PNG'))
            {
                $headers = [
                    'Content-Type' => 'application/PNG',
                ];
            }
            else
            {
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
            }
                
            return Storage::download($complaint->file_path, $complaint->file_name, $headers);
        }
        return redirect('/404');
    }
}
