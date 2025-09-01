<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use Helper;

use App\Models\Complaint;
use App\Models\ComplaintLog;
use App\Models\User;
use App\Models\ProfileUsers; 

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->hasAccess('dashboard')) {
            $this->checkVerificationModal(); // Only flashes 'show_success_modal' if eligible

            if (session()->has('success')) {
                return redirect()->route('dashboard')->with('success', session()->get('success'));
            }
            return redirect()->route('dashboard');
        }
        return view('home', ['page_title' => __('module.home')]);
    }

   public function checkVerificationModal()
    {
        $user = auth()->user()->load('roles', 'profile');
        $profile = $user->profile;

        if ($profile) {
            if ($profile->verify_status == 1 && !$profile->verification_modal_shown) {
                session()->flash('show_success_modal', true);
                ProfileUsers::where('id', $profile->id)->update(['verification_modal_shown' => true]);
            } elseif ($profile->verify_status == 0 && !$profile->verification_modal_shown) {
                session()->flash('show_failed_modal', true);
                ProfileUsers::where('id', $profile->id)->update(['verification_modal_shown' => true]);
            }
        }
    }

   public function markModalSeen(Request $request)
    {
        $user = auth()->user();

        if ($user && $user->profile) {
            ProfileUsers::where('id', $user->profile->id)->update(['verification_modal_shown' => true]);
        }

        return response()->json(['status' => 'ok']);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        //Get user roles
        $user_roles_aduan = Auth::user()->hasRole('PEGAWAI ADUAN');

        $auth_user = User::find(Auth::id());

        //Admin
        if($auth_user->username == '111111111111'){
            $user_roles_admin = true;
        }else{
            $user_roles_admin = false;
        }

        //Modul Aduan - Dihantar & Ditugaskan
        /*$complaintAssigns = Complaint::whereNull('deleted_by')
        ->where('assign_to', Auth::id())
        ->orWhere('assign_to', null)
        ->whereIn('complaint_status', [1,2])
        ->get();*/

        $complaintAssigns = Complaint::whereNull('deleted_by')
        ->leftjoin('user_role','complaints.assign_to','=','user_role.role_id')
        ->where('user_role.user_id', Auth::id())
        ->orwhere('assign_to', null)
        ->whereIn('complaint_status', [1,2])
        ->get();

        //Modul Aduan - Selesai
        $complaintCompleted = Complaint::whereNull('deleted_by')
        ->where('assign_to', null)
        ->where('complaint_status', '3')
        ->get();

        $complaintTotals = Complaint::whereNull('deleted_by')
        ->get();

        return view('dashboard', [		
			'user_roles_admin' => $user_roles_admin,
            'user_roles_aduan' => $user_roles_aduan,
            'apps' => 0,
            'complaintAssigns' => count($complaintAssigns),
            'complaintCompleted' => count($complaintCompleted),
            'complaintTotals' => count($complaintTotals)
		]);

    }
}
