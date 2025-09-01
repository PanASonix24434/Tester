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
use App\Mail\AppointmentNotification as AppointmentNotification;
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

        $pathic = Appointment:://where('appointments.id', $id)
        where('status_id','2')
        ->select('appointments.ic_file_path')
        ->get();

        $pathletter = Appointment:://where('appointments.id', $id)
        where('status_id','2')
        ->select('appointments.letter_file_path')
        ->get();

        return view('app.appointmentapprove.indexapprove', [
             'apptApprove' =>  $apptApprove,
             'appt_apv' => $appt_apv,
             'pathic' => $pathic,
             'pathletter' => $pathletter,
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

        //sebelum buat kelulusan,semak kuota dahulu

        //$action = $request->input('action'); // Retrieve the value of the clicked button

        $result = $request->txtResult;

        //Validation
        $this->validate($request, [
            'fileDoc' => 'max:5120',
        ],
        [
            'fileDoc.max' => 'Maksimum saiz fail adalah 5MB.',
        ]);

        DB::beginTransaction();

        try {

            //if($result == 'Diluluskan'){

            if ($request->file('fileDoc')) {

                $peranan = $request->hide_peranan;

                //semak kouta dulu sebelum kelulusan

                $appt_role = Appointment::where('appointments.role',$request->hide_peranan)
                ->where('appointments.status_id',3)
                ->select('appointments.username')
                //->select('appointments.state')
                ->get();
        
                $role_appt = count ($appt_role);
                //dd($role_appt);

                $app_peranan = $request->hide_role;
                //dd($app_peranan);

                if($role_appt >= $app_peranan){
                    //dd('kouta penuh');                 
                    return redirect()->action('Systems\AppointmentApproveController@indexapprove')->with('alert', 'Kuota peranan telah penuh !!');
                }else{

                    //dd('kouta blom penuh');

                    //$userid = $request->hide_userid;

                    //Check user
                   /* $checkUser = User::where('users.username', $request->hide_username)
                    ->get();

                    if((count($checkUser) == '') || (count($checkUser) == NULL)){
                        
                        //dd('user baru');

                        //store your file into database
                        $user = new User();

                        $userid = $request->userid;

                        //$user_id = Helper::uuid();

                        //dd($request->hide_email);

                        $user->id = $userid;
                        $user->name = $request->hide_name;
                        $user->username = $request->hide_username;
                        $user->email = $request->hide_email;
                        $user->password = '$2y$10$yTDOfD1VhG/i0.VOCa4W.eFL6uJChubkEaeovAHrM1B94y/x6t8vq'; //Hash::make($request->password);
                        $user->is_active = true;
                        $user->is_admin = false;
                        $user->watikah_status = 3;

                        //$user->save();

                        $appt_id = $request->hide_appt;

                        $appt = Appointment::find($appt_id);
                        $appt->user_id = $userid;                                            
                        $appt->status_id = 3;
                        $appt->updated_by = $request->user()->id;

                        //$appt->save();
                    }else{

                        //dd('user lama');

                        //dd($request->olduser);

                        $user = User::find($request->olduser);
                        $user->is_active = true;
                        $user->watikah_status = 3;
                        $user->updated_by = $request->user()->id;

                        $user->save();

                        $appt_id = $request->hide_appt;

                        $appt = Appointment::find($appt_id);
                        $appt->user_id = $request->olduser;                        
                        $appt->status_id = 3;
                        $appt->updated_by = $request->user()->id;

                        $appt->save();
                    }*/

                   /* $appt_id = $request->hide_appt;

                    $appt = Appointment::find($appt_id);
                    $appt->status_id = 3;
                    $appt->updated_by = $request->user()->id;*/

                    //$appt->save();

                    //store your file into database
                    $user = new User();

                    $userid = $request->userid;
                    $user->id = $userid;
                    $user->name = $request->hide_name;
                    $user->username = $request->hide_username;
                    $user->email = $request->hide_email;
                    $user->password = '$2y$10$yTDOfD1VhG/i0.VOCa4W.eFL6uJChubkEaeovAHrM1B94y/x6t8vq'; //Hash::make($request->password);
                    $user->is_active = true;
                    $user->is_admin = false;
                    $user->watikah_status = 3;

                    $appt_id = $request->hide_appt;

                    $appt = Appointment::find($appt_id);
                    $appt->user_id = $userid;                                            
                    $appt->status_id = 3;
                    $appt->updated_by = $userid;
                    
                    $file = $request->file('fileDoc');
                    $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                    $filename = $file_replace;				
                    $path = $request->file('fileDoc')->store('public/appointment');

                    //store your file into database
                    $apptApprove = new AppointmentApprove();
                    $apptApprove_id = Helper::uuid();
                    $apptApprove->id = $apptApprove_id;        
                    $apptApprove->username = $request->hide_username;
                    $apptApprove->approval_date = $request->txtApproveDate;
                    $apptApprove->approval_status = $request->txtResult;
                    
                    //dd($request->txtResult);
                    
                    //File
                    $apptApprove->file_path = $path;
                    $apptApprove->file_name = $filename;

                    $apptApprove->created_by = $request->user()->id;
                    $apptApprove->updated_by = $request->user()->id;

                    //$apptApprove->save();
                    
                    $audit_details = json_encode([ 
                        'cert_no'=> $request->txtFile,
                        'approval_status' => $request->txtResult,
                        'approval_notes'=> $request->txtKPPNote,
                        'path' => $path,
                    ]);

                    /*if ($action == 'save') {
                        //dd('save');
                        $appt->save();
                        $apptApprove->save();
                        DB::commit();
                        return redirect()->action('Systems\AppointmentApproveController@editApprove',$id)->with('alert', 'Maklumat telah berjaya disimpan !!');
                     }else if ($action == 'submit'){*/
                        //dd('hantar');
                        $user->save();
                        $appt->save();
                        $apptApprove->save();
                        DB::commit();
                        //dd('dah hantar');

                        //Send email to PPN,KC(N),KDP ================================

                        $watikahPath = AppointmentApprove::where('appointment_approves.username',$request->hide_username)
                        ->where('appointment_approves.approval_status', 'Diluluskan')
                        ->select('appointment_approves.file_path')
                        ->get();

                        $info_email = User::where('users.name','PPN')
                        ->orwhere('users.name','KC(N)')
                        ->orwhere('users.name','KDP')
                        ->select('users.email')
                        ->get();

                        $notiMailDataArr = array(
                            'name' => $request->hide_name,
                            'watikahPath' => $watikahPath,
                        );
                        
                        foreach ($info_email as $item) {
                            $emailInfo = $item->email;  
                            //dd($emailInfo);

                            // Send the email to each user
                            Mail::to($emailInfo = $item->email)->queue(new AppointmentNotification($notiMailDataArr));
                            //return redirect()->action('Systems\AppointmentApproveController@indexapprove')->with('alert', 'Maklumat telah berjaya dihantar !!');
                
                        }             

                        //Send email approval ================================

                        
                        $user_data = User::where('users.username',$request->hide_username)
                        ->where('users.watikah_status',3)
                        ->where('users.is_active',1)
                        ->join('appointments','appointments.username','=','users.username')                
                        ->where('appointments.status_id',3)
                        ->select('users.password')
                        ->get();

                        $mailDataArr = array(
                            'icno' => $request->hide_username,
                            'password' => 'test',
                        );

                        $user_email = User::where('users.username',$request->hide_username)
                        ->where('users.watikah_status',3)
                        ->where('users.is_active',1)
                        ->select('users.email')
                        ->get();

                        $email = $user_email[0]->email;

                        Mail::to($email)->queue(new AppointmentApproveMail2($mailDataArr));

                        return redirect()->action('Systems\AppointmentApproveController@indexapprove')->with('alert', 'Maklumat telah berjaya dihantar !!');
                        
                    //}

                    Audit::log('AppointmentApprove', 'Diluluskan', $audit_details);

                    DB::commit();

                    //dd('Lepas DB Commit');
                }

             //}
        	}else{
                //dd('x lulus');
                
                //$user->save();

                //Check user
                $checkUser = User::where('users.username', $request->hide_username)
                ->get();

                if((count($checkUser) == '') || (count($checkUser) == NULL)){

                    $appt_id = $request->hide_appt;

                    $appt = Appointment::find($appt_id);
                    $appt->status_id = 4;
                    $appt->updated_by = $request->user()->id;
    
                    //$appt->save();
    
                    //store your file into database
                    $apptApprove = new AppointmentApprove();
                    $apptApprove_id = Helper::uuid();
                    $apptApprove->id = $apptApprove_id;        
                    $apptApprove->username = $request->hide_username;
                    $apptApprove->approval_date = $request->txtApproveDate;
                    $apptApprove->approval_status = $request->txtResult;
        
                    $apptApprove->created_by = $request->user()->id;
                    $apptApprove->updated_by = $request->user()->id;

                    //$user->save();
                }else{
                    //dd('update');
     
                    $user = User::find($request->hide_username);
                    $user->watikah_status = 4;
                    $user->updated_by = $request->user()->id;
                    
                    $user->save();

                    $appt_id = $request->hide_appt;

                    $appt = Appointment::find($appt_id);
                    $appt->status_id = 4;
                    $appt->updated_by = $request->user()->id;
    
                    //$appt->save();
    
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
                }

                //$apptApprove->save();
                               
                $audit_details = json_encode([ 
                    'approval_status' => $request->txtResult,
                    'approval_notes'=> $request->txtKPPNote,
                ]);

                Audit::log('AppointmentApprove', 'Tambah', $audit_details);

                //DB::commit();

                /*if ($action == 'save') {
                    //dd('save');
                    //$appt->save();
                    $apptApprove->save();
                    DB::commit();
                    //dd('dah commit');
                    //return redirect()->action('Systems\AppointmentApproveController@indexapprove')->with('alert', 'Maklumat telah berjaya disimpan !!');
                    //return redirect()->action('Systems\AppointmentApproveController@updateApprove2',$id)->with('alert', 'Maklumat telah berjaya disimpan !!');
                   
                }else if ($action == 'submit'){*/
                    //dd('hantar');
                    $appt->save();
                    $apptApprove->save();
                    DB::commit();
                    return redirect()->action('Systems\AppointmentApproveController@indexapprove')->with('alert', 'Maklumat telah berjaya dihantar !!');
                //}

           
        
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

        $pathic = Appointment::where('appointments.id', $id)
        ->where('status_id','2')
        ->select('appointments.ic_file_path')
        ->get();

        //$pathic = $icpath[0]->ic_file_path;

        $pathletter = Appointment::where('appointments.id', $id)
        ->where('status_id','2')
        ->select('appointments.letter_file_path')
        ->get();

        //$pathletter = $letterpath[0]->letter_file_path;

        return view('app.appointmentapprove.editApprove', [
             //'apptApprove' =>  $apptApprove,
             'appt_apv' => $appt_apv,
             'appt' => $appt,
             'id' => $id,
             'entities' => $entities,
             'approve' => $approve,
             'role' => $role,
             'user' => $user,
             'pathic' => $pathic,
             'pathletter' => $pathletter,
        ]);

    }

    public function updateApprove(Request $request, string $id)
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

        return view('app.appointmentapprove.updateApprove', [
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

     /**
     * Export appointments to pdf.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function exportPdf(Request $request, string $id) 
    {
        
        Audit::log('appointments', 'export', json_encode(['file_type' => 'PDF']));

        $appData = Appointment::where('appointments.id','=', $id)
        ->where('appointments.status_id', 2)
        ->get();

        $postData = Appointment::where('appointments.id','=', $id)
        ->where('appointments.status_id', 2)
        ->select('appointments.role')
        ->get();

        $post = $postData[0]->role;

        $role_timbalan = 'TIMBALAN PENGARAH KANAN';
        $role_ketua = 'KETUA PENGARAH PERIKANAN MALAYSIA';

        $role_id = Role::where('roles.name',$role_timbalan)
        ->select('roles.id')
        ->get();

        $rid = $role_id[0]->id;

        $userData = User::join('user_role','user_id','=','users.id')
        ->where('user_role.role_id',$rid)
        ->get();

        $role_idK = Role::where('roles.name',$role_ketua)
        ->select('roles.id')
        ->get();

        $ridK = $role_idK[0]->id;

        $userDataK = User::join('user_role','user_id','=','users.id')
        ->where('user_role.role_id',$ridK)
        ->get();

        $certData = AppointmentApprove::join('appointments','icno','=','appointment_approves.username')        
        ->where('appointments.id', $id)
        ->where('appointments.status_id', 3)
        ->get();


        if (!empty($request->q)) {
            $filter = $request->q;
        }
        
        // Combine the data into a single array
        $data = [
            'appointments' => $appData,
            'users'        => $userData,
            'ketuausers'   => $userDataK,
            'approves'     => $certData,
            'position'     => $post,
        ];

        $pdf = PDF::loadView('app.appointmentapprove.pdf', $data);
        $pdf->setPaper('A4', 'potrait');
        $pdf->getDomPDF()->set_option('enable_php', true);

        // View on page
        //return $pdf->stream(__('module.appointments').'_'.Carbon::now()->format('YmdHis').'.pdf');
        return $pdf->stream('appointments.pdf');

    }

    //Download  IC
    public function downloadDoc($id)
    {
        $appointment = Appointment::find($id);

        $icPath = $appointment->ic_file_path;

        if (Storage::exists($icPath)) {

            //Format - PDF
            if (Str::contains($icPath, '.pdf'))
            {
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
            }
            //Format - JPG
            elseif(Str::contains($icPath, '.jpg'))
            {
                $headers = [
                    'Content-Type' => 'application/jpg',
                ];
            }
            //Format - PNG
            elseif(Str::contains($icPath, '.PNG'))
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
                
            return Storage::download($icPath, $appointment->ic_file_name, $headers);
        }
        return redirect('/404');

    }

        //Download Letter
        public function letterDownloadDoc($id)
        {
            $appointment = Appointment::find($id);
    
            $letterPath = $appointment->letter_file_path;
    
            if (Storage::exists($letterPath)) {

                //Format - PDF
                if (Str::contains($letterPath, '.pdf'))
                {
                    $headers = [
                        'Content-Type' => 'application/pdf',
                    ];
                }
                //Format - JPG
                elseif(Str::contains($letterPath, '.jpg'))
                {
                    $headers = [
                        'Content-Type' => 'application/jpg',
                    ];
                }
                //Format - PNG
                elseif(Str::contains($letterPath, '.PNG'))
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
                    
                return Storage::download($letterPath, $appointment->letter_file_name, $headers);
            }
            return redirect('/404');
    
        }

}