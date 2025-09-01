<?php

//namespace App\Http\Controllers;
namespace App\Http\Controllers\Systems;

use App\Models\User;
use App\Models\Appointment;
use App\Models\CodeMaster;
use App\Models\Entity;
use App\Models\Authorization\Role;
use App\Http\Controllers\Controller;
use App\Exports\AppointmentExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
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

class AppointmentDownloadController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        $apptApprove = User::where('users.id', $userId)
        ->join('appointments','icno','=','users.username')
        ->where('users.is_active','1')
        ->where('users.watikah_status','3')
        ->get();

        $role_id = User::where('users.id', $userId)
        ->join('user_role','user_role.user_id','=','users.id')
        ->select('user_role.role_id')
        ->get();

        $role = User::where('users.id', $userId)
        ->join('user_role','user_role.user_id','=','users.id')
        ->join('user_role','user_role.role_id','=','roles.id')
        ->join('appointments','icno','=','users.username')
        ->where('user_role', $role_id)
        ->where('users.is_active', 1)
        ->where('appointments.status_id', 3)
        ->get();

        return view('app.appointmentdownload.index', [
            'apptApprove' => $apptApprove,
            'userId' => $userId,
            'role_id' => $role_id,
        ]);
     }

        /**
     * Export users to pdf.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function exportPdf(Request $request) 
    {
        
        Audit::log('appointments', 'export', json_encode(['file_type' => 'PDF']));

        $userId = Auth::id();

        $role_id = User::where('users.id', $userId)
        ->join('user_role','user_role.user_id','=','users.id')
        ->select('user_role.role_id')
        ->get();

        $appData = User::where('users.id', $userId)
        ->join('appointments','user_id','=','users.id')
        ->where('users.is_active', 1)
        ->where('appointments.status_id', 3)
        ->get();

        $userData = User::where('users.id', $userId)
        ->join('user_role','user_id','=','users.id')
        ->where('users.is_active', 1)
        ->get();

        $certData = AppointmentApprove::join('appointments','icno','=','appointment_approves.username')        
        ->where('appointments.user_id', $userId)
        ->where('appointments.status_id', 3)
        ->get();


        if (!empty($request->q)) {
            $filter = $request->q;
        }
        
        // Combine the data into a single array
        $data = [
            'appointments' => $appData,
            'users'        => $userData,
            'cert'      => $certData,
        ];

        $pdf = PDF::loadView('app.appointmentdownload.pdf', $data);
        $pdf->setPaper('A4', 'potrait');
        $pdf->getDomPDF()->set_option('enable_php', true);

        // View on page
        //return $pdf->stream(__('module.appointments').'_'.Carbon::now()->format('YmdHis').'.pdf');
        return $pdf->stream('appointments.pdf');

    }

}
