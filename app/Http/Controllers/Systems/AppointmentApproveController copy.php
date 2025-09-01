<?php

namespace App\Http\Controllers\Systems;

use App\Models\User;
use App\Models\Appointment;
use App\Models\AppointmentApprove;
use App\Models\CodeMaster;
use App\Models\Entity;
use App\Models\Authorization\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Module;

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
use App\Mail\AppointmentApprove as AppointmentApproveMail;
use App\Mail\AppointmentApprove2 as AppointmentApproveMail2;

class AppointmentApproveController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexapprove(Request $request)
    {
        /*$apptApprove = User::join('appointments','icno','=','users.username')
        ->where('users.is_active','1')
        ->where('users.watikah_status','2')
        ->get();*/

        $apptApprove = Appointment::where('status_id','2')
        ->get();
        
        $appt_apv = AppointmentApprove::join('appointments','icno','=','appointment_approves.username')
        ->get();      

        return view('app.appointmentapprove.indexapprove', [
             'apptApprove' =>  $apptApprove,
             'appt_apv' => $appt_apv,
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

        //dd($request->txtResult);

        //Validation
        $this->validate($request, [
            'fileDoc' => 'max:5120',
        ],
        [
            'fileDoc.max' => 'Maksimum saiz fail adalah 5MB.',
        ]);

        DB::beginTransaction();

        try {
            
            if ($request->file('fileDoc')) {

                $peranan = $request->hide_peranan;

                //sebelum buat kelulusan,semak kuota dahulu
        
                /*$appt_role = Appointment::where('appointments.role',$request->hide_peranan)
                ->where('appointments.status_id',3)
                ->join('users','appointments.username','=','users.username')
                ->where('users.is_active',1)
                ->where('users.watikah_status',3)
                ->select('appointments.name')
                ->get();*/

                $appt_role = Appointment::where('appointments.role',$request->hide_peranan)
                ->where('appointments.status_id',3)
                ->select('appointments.name')
                ->get();
        
                $role_appt = count ($appt_role);
                //dd($role_appt);

                $app_peranan = $request->hide_role;

                if($role_appt >= $app_peranan){
                    //dd('kouta penuh');                 
                    return redirect()->action('Systems\AppointmentApproveController@indexapprove')->with('alert', 'Kuota peranan telah penuh !!');
                }else{

                    //dd('kouta blom penuh');
                    $userid = $request->hide_userid;

                    $user = User::find($userid);
                    $user->watikah_status = 3;
                    $user->updated_by = $request->user()->id;

                    $user->save();

                    $appt_id = $request->hide_appt;

                    $appt = Appointment::find($appt_id);
                    $appt->status_id = 3;
                    $appt->updated_by = $request->user()->id;

                    $appt->save();
                    
                    $file = $request->file('fileDoc');
                    $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                    $filename = $file_replace;				
                    $path = $request->file('fileDoc')->store('public/appointment');

                    //store your file into database
                    $apptApprove = new AppointmentApprove();
                    $apptApprove_id = Helper::uuid();
                    $apptApprove->id = $apptApprove_id;        
                    $apptApprove->username = $request->hide_username;
                    $apptApprove->cert_no = $request->txtFile;
                    $apptApprove->approval_status = $request->txtResult;
                    $apptApprove->approval_notes = $request->txtKPPNote;
                    
                    //File
                    $apptApprove->file_path = $path;
                    $apptApprove->file_name = $filename;

                    $apptApprove->created_by = $request->user()->id;
                    $apptApprove->updated_by = $request->user()->id;

                    $apptApprove->save();
                    
                    $audit_details = json_encode([ 
                        'cert_no'=> $request->txtFile,
                        'approval_status' => $request->txtResult,
                        'approval_notes'=> $request->txtKPPNote,
                        'path' => $path,
                    ]);

                    Audit::log('AppointmentApprove', 'Diluluskan', $audit_details);

                    DB::commit();

                    //dd('Lepas DB Commit');

                    //Send email approval ================================

                    $user_data = User::where('users.username',$request->hide_username)
                    ->where('users.watikah_status',3)
                    ->where('users.is_active',1)
                    ->join('appointments','appointments.username','=','users.username')                
                    ->where('appointments.status_id',3)
                    ->select('users.password')
                    ->get();

                    /*$mailDataArr = array(
                        'icno' => $request->hide_username,
                        'password' => $user_data->password,
                    );*/

                    $mailDataArr = array(
                        'icno' => $request->hide_username,
                        'password' => 'test',
                    );

                    $user_email = User::where('users.username',$request->hide_username)
                    //->where('users.watikah_status',3)
                    //->where('users.is_active',1)
                    ->join('appointments','appointments.username','=','users.username')                
                    //->where('appointments.status_id',3)
                    ->select('users.email')
                    ->get();
                    
                    //dd('hantar emel');
                    //dd($user_email[0]->email);

                    //Send email to penerima appointment
                    //Mail::to($user_email[0]->email)->queue(new AppointmentApproveMail($mailDataArr));
                    Mail::to($user_email[0]->email)->queue(new AppointmentApproveMail2($mailDataArr));

                }

                
        	}else{
                //dd('no attachment');
                
                $userid = $request->hide_userid;

                $user = User::find($userid);
                $user->watikah_status = 4;
                $user->updated_by = $request->user()->id;

                $user->save();

                $appt_id = $request->hide_appt;

                $appt = Appointment::find($appt_id);
                $appt->status_id = 4;
                $appt->updated_by = $request->user()->id;

                $appt->save();

				//store your file into database
				$apptApprove = new AppointmentApprove();
                $apptApprove_id = Helper::uuid();
                $apptApprove->id = $apptApprove_id;        
                $apptApprove->username = $request->hide_username;
                $apptApprove->cert_no = $request->txtFile;
                $apptApprove->approval_status = $request->txtResult;
                $apptApprove->approval_notes = $request->txtKPPNote;
	
				$apptApprove->created_by = $request->user()->id;
                $apptApprove->updated_by = $request->user()->id;

                $apptApprove->save();
                               
                $audit_details = json_encode([ 
                    'approval_status' => $request->txtResult,
                    'approval_notes'=> $request->txtKPPNote,
                ]);

                Audit::log('AppointmentApprove', 'Tambah', $audit_details);

                DB::commit();

            }

           
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'approval_status' => $request->txtResult,
                'approval_notes'=> $request->txtKPPNote,
            ]);

            Audit::log('AppointmentApprove', 'Tambah', $audit_details, $e->getMessage());

            //return redirect()->back()->with('t_error', __('app.error_occured'));
            return redirect()->back()->with('appApprove_failed', 'Appointment gagal disimpan !!');
        }
                        
        //DB::commit();
        return redirect()->action('Systems\AppointmentApproveController@indexapprove')->with('alert', 'Maklumat telah berjaya disimpan !!');
        //return redirect()->action('Systems\AppointmentApproveController@editApprove', $apptApprove_id)->with('alert', 'Pengguna berjaya dicipta !!');    
               
        
    }

      public function editApprove(Request $request, string $id)
    {
        $appt_approve_id = Helper::uuid();

        /*$apptApprove = User::join('appointments','icno','=','users.username')
        ->where('users.is_active','1')
        ->where('users.watikah_status','2')
        ->get();*/

        $appt_apv = AppointmentApprove::join('appointments','icno','=','appointment_approves.username')        
        ->where('appointments.id', $appt_approve_id)
        ->get();

        $appt = Appointment::where('id', $id)
        ->get();

        $entities = Entity::join('appointments','office_duty','=','entities.id') 
        ->get();

        $icno = $request->hide_username;

        $approve = AppointmentApprove::join('appointments','icno','=','appointment_approves.username')        
        ->where('appointments.icno', $icno)
        ->get();

        $role = Appointment::where('appointments.id', $id)
        ->join('roles','appointments.role','=','roles.name')
        ->select('roles.quota')
        ->get();

        $user = Appointment::where('appointments.id', $id)
        ->join('users','appointments.username','=','users.username')
        ->select('users.id')
        ->get();

        return view('app.appointmentapprove.editApprove', [
             //'apptApprove' =>  $apptApprove,
             'appt_apv' => $appt_apv,
             'appt' => $appt,
             'id' => $id,
             'entities' => $entities,
             'approve' => $approve,
             'role' => $role,
             'user' => $user,
        ]);

    }

}