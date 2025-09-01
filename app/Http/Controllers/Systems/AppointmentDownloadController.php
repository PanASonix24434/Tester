<?php

namespace App\Http\Controllers\Systems;

use App\Models\User;
use App\Models\Appointment;
use App\Models\AppointmentApprove;
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

use Illuminate\Support\Str;

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

        return view('app.appointmentdownload.index', [
            'apptApprove' => $apptApprove,
            'userId' => $userId,
            'role_id' => $role_id,
        ]);
     }

        /**
     * Export appointments to pdf.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function exportPdf(Request $request) 
    {
        
        Audit::log('appointments', 'export', json_encode(['file_type' => 'PDF']));

        $userId = Auth::id();

        $role_id = $request->hide_roleid;

        $appData = User::where('users.id', $userId)
        ->join('appointments','user_id','=','users.id')
        ->where('users.is_active', 1)
        ->where('appointments.status_id', 3)
        ->get();

        $selState = User::where('users.id', $userId)
        ->join('appointments','user_id','=','users.id')
        ->where('users.is_active', 1)
        ->where('appointments.status_id', 3)
        ->select('appointments.office_duty')
        ->get();

        $rState = $selState[0]->office_duty;

        $text = $rState;
        $keyword = "Negeri";

        $pos = strpos($text, $keyword);

        if ($pos !== false) {
            // Calculate the start position after the keyword
            $start = $pos + strlen($keyword);
            
            // Extract the substring after the keyword
            //$result = trim(substr($text, $start));
            $result = strtoupper(trim(substr($text, $start)));
            
            //dd($result);
        }

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
            'ketuausers'   => $userDataK,
            'approves'     => $certData,
            'states'       => $result,
        ];

        $pdf = PDF::loadView('app.appointmentdownload.pdf', $data);
        $pdf->setPaper('A4', 'potrait');
        $pdf->getDomPDF()->set_option('enable_php', true);

        // View on page
        //return $pdf->stream(__('module.appointments').'_'.Carbon::now()->format('YmdHis').'.pdf');
        return $pdf->stream('appointments.pdf');

    }

    //Download  IC
    public function downloadDoc($id)
    {
        $userId = Auth::id();

        $user = User::where('users.id', $userId)
        ->select('users.username')
        ->get();

        $username = $user[0]->username;

        $approve = AppointmentApprove::where('appointment_approves.username', $username)
        ->select('appointment_approves.file_path')
        ->get();

        $filePath = $approve[0]->file_path;

        $appt_approve = AppointmentApprove::where('appointment_approves.username', $username)
        ->select('appointment_approves.file_name')
        ->get();

        $fileName = $appt_approve[0]->file_name;

        //$filePath = $apptApprove->file_path;

        if (Storage::exists($filePath)) {

            //Format - PDF
            if (Str::contains($filePath, '.pdf'))
            {
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
            }
            //Format - JPG
            elseif(Str::contains($filePath, '.jpg'))
            {
                $headers = [
                    'Content-Type' => 'application/jpg',
                ];
            }
            //Format - PNG
            elseif(Str::contains($filePath, '.PNG'))
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
                
            return Storage::download($filePath, $fileName, $headers);
        }
        return redirect('/404');

    }

}
