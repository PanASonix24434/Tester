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

class UpdateStaffProfileController extends Controller
{
    public function updateProfile(Request $request)
    {

        $userId = Auth::id();

        $user = User::where('users.id', $userId)
        ->where('users.is_active','1')
        ->where('users.watikah_status','3')
        ->where('appointments.status_id','3')
        ->join('appointments','icno','=','users.username')
        ->get();

        return view('app.admin.user.updateStaffProfile', [
            'userId' => $userId,
            'user' =>  $user,
        ]);
    }

    public function updateStaffProfile(Request $request)
    {

        $userId = Auth::id();

        $user = Appointment::where('appointments.user_id', $userId)
        ->get();

        //dd($request->hide_appt);

        $appt = Appointment::find($request->hide_appt);
        $appt->name = $request->txtName;
        $appt->icno = $request->txtICNO;
        $appt->role = $request->txtRole;
        $appt->level = $request->txtLevel;
        $appt->department = $request->txtUnit;
        $appt->office_duty = $request->txtDuty;
        $appt->report_date = $request->txtReportDate;
        $appt->updated_by = $request->user()->id;
        
        $appt->save();

        DB::commit();
        return redirect()->action('Systems\UpdateStaffProfileController@updateprofile')->with('alert', 'Maklumat telah dikemaskini !!');
            
        return view('app.admin.user.updateStaffProfile', [
            'userId' => $userId,
            'user' =>  $user,
        ]);
    }

    
}
