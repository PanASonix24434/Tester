<?php

namespace App\Http\Controllers\Systems;

use App\Models\User;
use App\Models\Appointment;
use App\Models\CodeMaster;
use App\Models\Entity;
use App\Models\Authorization\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Audit;
use Exception;
use Module;
use Helper;

use Auth;
use Hash;
use DB;
use Carbon\Carbon;
use PDF;
use Storage;
use Image;

//Mail
use Mail;
use App\Mail\InactiveStaff as InactiveStaffMail;

class AppointmentController extends Controller
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$users = User::sortable();

        $codemasters = CodeMaster::sortable();

        $apptInactive = User::join('appointments','icno','=','users.username')
        ->where('users.is_active','0')
        ->where('users.watikah_status','3')
        ->get();
                
        $stateFilter = 'state';        

        $state = CodeMaster::where('type', $stateFilter)
        ->orderBy('code')
        ->get();

        $districtFilter = 'district';        

        $district = CodeMaster::where('type', $districtFilter)
        ->orderBy('code')
        ->get();

        $departmentFilter = 'department';        

        $department = CodeMaster::where('type', $departmentFilter)
        ->get(); 

        $request->user();
        $role = Role::sortable();
        $filter = !empty($request->txtName) ? $request->txtName : '';
        if (!empty($filter)) {
            Audit::log('name', 'search', json_encode(['filter' => $filter]));
            $role->where('name', 'like', '%'.$filter.'%');
        }

       /* $request->user();
        $appt = User::join('appointments','icno','=','users.username')
        ->where('users.is_active','1')
        ->where('users.watikah_status','3')
        ->where('appointments.status_id','3')
        ->get();*/

        $appt = Appointment::where('status_id', 3)
        ->orderBy('name')
        ->get();

        $filter = !empty($request->txtName) ? $request->txtName : '';
        if (!empty($filter)) {
            Audit::log('name', 'search', json_encode(['filter' => $filter]));
            $appt->where('name', 'like', '%'.$filter.'%');
        }

        $filterDepartment = !empty($request->selDepartType) ? $request->selDepartType : '';
        $filterselStateType = !empty($request->selStateType) ? $request->selStateType : '';
        $filterselDistrictType = !empty($request->selDistrictType) ? $request->selDistrictType : '';
        $filterselStateType = !empty($request->selStateType) ? $request->selStateType : '';  
    
        $level = CodeMaster::where('type','level')
        ->get();

        return view('app.appointment.index', [
            //'role' => $role,
            'role' => $request->has('sort') ? $role->paginate(10) : $role->orderBy('name')->paginate(10),
            //'appt' => $appt,
            //'appt' => $request->has('sort') ? $appt : $appt,
            'apptInactive' => $apptInactive,
            'state' => $state,
            'district' => $district,
            'department' => $department,
            'level' => $level,
            'filterDepartment' => $request->has('sort') ? $appt : $appt,
            'txtName' => $filter,
            //'filterselDepartType' => $filterDepartment,
            'filterselStateType' => $filterselStateType,
            'filterselDistrictType' => $filterselDistrictType,
            'appt' => $appt,
        ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $role = Role::get();

        $entities = Entity::orderBy('entity_level')
        ->get();

        $depart = CodeMaster::where('type','department')
        ->get();

       /*$level = Entity::where('entity_level','1')
        ->orWhere('entity_level', '2')
        ->where('is_active','1')
        ->orderBy('entity_level')
        ->get();*/

        return view('app.appointment.create', [		
            'role' => $role,
            'entities' => $entities,
            'depart' => $depart,
            //'level' => $level,
	]);    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $action = $request->input('action'); // Retrieve the value of the clicked button

        // Get the selected value (it's a string with multiple values)
        $selectedLevel = $request->input('selLevel');

        // Split the string into an array using the delimiter
        $levelData = explode('|', $selectedLevel);

        // array for peringkat
        $stateCode = $levelData[0];
        $levelName = $levelData[1];
        $levelId   = $levelData[2];

        //Validation
        $this->validate($request, [
            'icDoc' => 'max:5120',
        ],
        [
            'icDoc.max' => 'Maksimum saiz fail adalah 5MB.',
        ]);

        //Validation
        $this->validate($request, [
            'letterDoc' => 'max:5120',
        ],
        [
            'letterDoc.max' => 'Maksimum saiz fail adalah 5MB.',
        ]);

        DB::beginTransaction();
        //dd('Test Store');
        try {

            if (($request->file('icDoc')) && ($request->file('letterDoc'))) {

               //store your file into database
				$appt = new Appointment();

                $appt_id = Helper::uuid();

                $icfile = $request->file('icDoc');
                $icfile_replace = str_replace(' ', '', $icfile->getClientOriginalName());
                $icfilename = $icfile_replace;				
                $icpath = $request->file('icDoc')->store('public/appointment');

                $letterfile = $request->file('letterDoc');
                $letterfile_replace = str_replace(' ', '', $letterfile->getClientOriginalName());
                $letterfilename = $letterfile_replace;				
                $letterpath = $request->file('letterDoc')->store('public/appointment');

                $appt->id = $appt_id;
                $appt->username = $request->txtICNO;
                $appt->name = $request->txtName;
                $appt->role = $request->selRole;
                $appt->email = $request->txtEmail;
                $appt->icno = $request->txtICNO;
                $appt->level = $levelName;
                $appt->state = $stateCode;
                $appt->department = $request->selUnit;
                $appt->office_duty = $request->selEntity;
                $appt->report_date = $request->txtReportDate;
                $appt->inactive_date = '1970-01-01';

                //IC
                $appt->ic_file_path = $icpath;
                $appt->ic_file_name = $icfilename;

                //Letter
                $appt->letter_file_path = $letterpath;
                $appt->letter_file_name = $letterfilename;

                if ($action == 'save') {
                    $appt->status_id = 1;
                }else if ($action == 'submit'){
                    $appt->status_id = 2;
                }

                //$appt->created_by = $request->appointment()->id;      

                if ($action == 'save') {
                    //dd('save');
                    $appt->save();
                    DB::commit();
                    return redirect()->action('Systems\AppointmentController@edit2', $appt_id)->with('alert', 'Pengguna berjaya dicipta !!');    
                }else if ($action == 'submit'){
                    //dd('hantar');
                    $appt->save();
                    DB::commit();
                    //dd('dah hantar');
                    return redirect()->action('Systems\AppointmentController@index')->with('alert', 'Permohonan telah berjaya dihantar !!');
                }

            }
                
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'name' => $request->txtName,
                'role' => $request->selRole,
                'email' => $request->txtEmail,
                'icno' => $request->txtICNO,
                'level' => $request->selLevel,
                'department' => $request->selUnit,
                'office_duty' => $request->selEntity,
                'report_date'=> $request->txtReportDate,
            ]);

            Audit::log('appointment', 'add', $audit_details, $e->getMessage());
    
            return redirect()->back()->with('appointment_failed', 'Pengguna gagal disimpan !!');
        }

    }

      public function edit2(string $id)
    {
        $appt = Appointment::find($id);
        $appt2 = Appointment::where('id', $id)
        //->where('',)
        ->get();

        $appointment = Appointment::where('id', $id)
        ->select('appointments.role')
        ->get();

        $appt_role = $appointment[0]->role;

        $roleAppt = Role::where('roles.name',$appt_role)
        ->get();

        $role = Role::where('roles.name','!=',$appt_role)
        ->get();

        $appointment_office = Appointment::where('id', $id)
        ->select('appointments.office_duty')
        ->get();

        $appt_duty = $appointment_office[0]->office_duty;

        $entities_office = Entity::where('entity_name',$appt_duty)
        ->get();

        $entities = Entity::where('entity_name','!=',$appt_duty)
        ->orderBy('entity_level')
        ->orderBy('state_code')

        ->get();

        $appointment_depart = Appointment::where('id', $id)
        ->select('appointments.department')
        ->get();

        $appt_depart = $appointment_depart[0]->department;

        $depart_appt = CodeMaster::where('name',$appt_depart)
        ->get();

        $depart = CodeMaster::where('type','department')
        ->where('name','!=',$appt_depart)
        ->get();

        $appointment_level = Appointment::where('id', $id)
        ->select('appointments.level')
        ->get();

        $apptLevel = $appointment_level[0]->level;

        $appt_level = Entity::where('entities.entity_name',$apptLevel)
        ->get();

        $level = Entity::where('entity_level','1')
        ->orWhere('entity_level', '2')
        ->where('is_active','1')
        ->where('entities.entity_name','!=',$apptLevel)
        ->get();

        return view('app.appointment.edit2', [
            'appt' => $appt,
            'appt2' => $appt2,
            'role' => $role,
            'entities' => $entities,
            'depart' => $depart,
            'level' =>  $level,
            'roleAppt' => $roleAppt,
            'appt_level' => $appt_level,
            'depart_appt' => $depart_appt,
            'entities_office' => $entities_office,
        ]);

        
    } 

        public function edit3(string $id)
     {

        //dd('edittt');
        $appt = Appointment::find($id);
        $appt2 = Appointment::where('id', $id)
        //->where('',)
        ->get();

        $role = Role::get();

        $entities = Entity::orderBy('entity_level')
        ->orderBy('state_code')
        ->get();

        $depart = CodeMaster::where('type','department')
        ->get();

        $entities = Entity::join('appointments','office_duty','=','entities.id') 
        ->get();   

        /*$apptInactive = User::join('appointments','icno','=','users.username')
        ->where('users.is_active','0')
        ->where('users.is_active','0')
        ->where('users.watikah_status','3')
        ->get();*/

        $apptInactive = Appointment::whereNotNull('appointments.inactive_date')
        ->get();
        
        return view('app.appointment.edit3', [
            'appt' => $appt,
            'appt2' => $appt2,
            'role' => $role,
            'entities' => $entities,
            'depart' => $depart,
            'apptInactive' => $apptInactive
        ]);
     }

      /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,string $id)
    {
        $user = User::find($id);
        $user->is_active = false;
        $user->updated_by = $request->user()->id;

        $user->save();

        $appt_id = $request->hide_appt;

        $appt = Appointment::find($appt_id);

        $inactivefile = $request->file('inactiveDoc');
        $inactivefile_replace = str_replace(' ', '', $inactivefile->getClientOriginalName());
        $inactivefilename = $inactivefile_replace;				
        $inactivepath = $request->file('inactiveDoc')->store('public/appointment');

        $appt->inactive_date = $request->txtRetire;
        $appt->inactive_note = $request->txtNote;
        $appt->updated_by = $request->user()->id;

        $appt->inactive_file_path = $inactivepath;
        $appt->inactive_file_name = $inactivefilename;

        $appt->save();

        DB::commit();

        //Send email nyahaktif  ================================

        $mailDataArr = array(
            'name' => $request->hide_name,
            'icno' => $request->hide_icno,
            'inactive_date' => $request->txtRetire,
        );

        $user_data = User::where('users.id',$id)
        ->join('appointments','appointments.username','=','users.username') 
        ->select('users.email')
        ->get();

        //dd('hantar emel');
        //dd($user_email[0]->email);

        //Send email to user
        //Mail::to($user_email[0]->email)->queue(new InactiveStaffMail($mailDataArr));
        Mail::to($user_data[0]->email)->queue(new InactiveStaffMail($mailDataArr));

        return redirect()->action('Systems\AppointmentController@index')->with('alert', 'Kakitangan telah berjaya dinyahaktifkan !!');

    }

    public function updateappt(Request $request,string $id)
     {
        $action = $request->input('action'); // Retrieve the value of the clicked button

        //dd($action);
        $appt = Appointment::find($id);
        $appt2 = Appointment::where('id', $id)
        //->where('',)
        ->get();

        $role = Role::get();

        $entities = Entity::orderBy('entity_level')
        ->orderBy('state_code')
        ->get();

        $depart = CodeMaster::where('type','department')
        ->get();

        $entities = Entity::join('appointments','office_duty','=','entities.id') 
        ->get();   

        $apptInactive = User::join('appointments','icno','=','users.username')
        ->where('users.is_active','0')
        ->where('users.watikah_status','3')
        ->get();

        $level = CodeMaster::where('type','level')
        ->get();

        //dd($request->selRole);

        $appt_upd = Appointment::find($id);

        /*$icfile = $request->file('icDoc');
        $icfile_replace = str_replace(' ', '', $icfile->getClientOriginalName());
        $icfilename = $icfile_replace;				
        $icpath = $request->file('icDoc')->store('public/appointment');

        $letterfile = $request->file('letterDoc');
        $letterfile_replace = str_replace(' ', '', $icfile->getClientOriginalName());
        $letterfilename = $letterfile_replace;				
        $letterpath = $request->file('letterDoc')->store('public/appointment');*/

        $appt_upd->username = $request->txtICNO;
        $appt_upd->name = $request->txtName;
        $appt_upd->role = $request->selRole;
        $appt_upd->email = $request->txtEmail;
        $appt_upd->icno = $request->txtICNO;
        $appt_upd->level = $request->selLevel;
        $appt_upd->department = $request->selUnit;
        $appt_upd->office_duty = $request->selEntity;
        $appt_upd->report_date = $request->txtReportDate;
        $appt_upd->updated_by = $request->user()->id;

        //IC
       // $appt->ic_file_path = $icpath;
       // $appt->ic_file_name = $icfilename;

        //Letter
       // $appt->letter_file_path = $letterpath;
       // $appt->letter_file_name = $letterfilename;
        

        if ($action == 'save') {
            $appt_upd->status_id = 1;
        }else if ($action == 'submit'){
            $appt_upd->status_id = 2;
        }        
        
        if ($action == 'save') {
            $appt_upd->save();
            DB::commit();
            return redirect()->action('Systems\AppointmentController@edit2', $id)->with('alert', 'Kakitangan telah berjaya dikemaskini !!');    
        }else if ($action == 'submit'){
            //dd('hantar');
            $appt_upd->save();
            DB::commit();
            //dd('dah hantar');
            return redirect()->action('Systems\AppointmentController@index')->with('alert', 'Permohonan telah berjaya dihantar !!');
        }

        //DB::commit();
        //return redirect()->action('Systems\AppointmentController@edit2', $id)->with('alert', 'Kakitangan telah berjaya dikemaskini !!');
        
        return view('app.appointment.updateappt', [
            'appt' => $appt,
            'appt2' => $appt2,
            'role' => $role,
            'entities' => $entities,
            'depart' => $depart,
            'apptInactive' => $apptInactive,
            'level' => $level,
        ]);
     }

    public function view(Request $request,string $id)
    {
        $appt = Appointment::find($id);

        //dd($id);

        $appt2 = Appointment::where('id', $id)
        //->where('',)
        ->get();

        $role = Role::get();

        $entities = Entity::orderBy('entity_level')
        ->orderBy('state_code')
        ->get();

        $depart = CodeMaster::where('type','department')
        ->get();

        $entities = Entity::join('appointments','office_duty','=','entities.id') 
        ->get();   
        
        return view('app.appointment.view', [
            'appt' => $appt,
            'appt2' => $appt2,
            'role' => $role,
            'entities' => $entities,
            'depart' => $depart,
        ]);
    }
}