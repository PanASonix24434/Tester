<?php

namespace App\Http\Controllers\NelayanDarat\gantiKulit;

use App\Http\Controllers\Controller;
use App\Models\CatchingLocation_nd;
use App\Models\CodeMaster;
use App\Models\darat_application;
use App\Models\darat_application_log;
use App\Models\darat_base_jetties;
use App\Models\darat_base_jetty_history;
use App\Models\darat_document;
use App\Models\darat_fault_record;
use App\Models\darat_payment_receipt;
use App\Models\ProfileUsers;
use App\Models\darat_user_equipment;
use App\Models\darat_user_equipment_history;
use App\Models\darat_user_fisherman_info;
use App\Models\darat_vessel;
use App\Models\darat_vessel_engine_history;
use App\Models\darat_vessel_history;
use App\Models\darat_vessel_hull_history;
use App\Models\darat_application_temp;
use App\Models\darat_equipment_list;
use App\Models\darat_vessel_hull;
use App\Models\darat_vessel_inspection;
use App\Models\FishingLog_nd;
use App\Models\FishLanding_nd;
use App\Models\SalesRecord_nd;
use App\Models\darat_vessel_engine;
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingInfo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class sokonganUlasan2Controller extends Controller
{

    protected $applicationTypeCode = '6'; // Changed for gantiKulit

    public function index()
    {
        $user     = Auth::user();
        $roleName = $user->roles()->pluck('name')->first();

        $positiveFeedback = ['105','113'];
        $negativeFeedback = ['106-1'];
        $statusCodes      = array_merge($positiveFeedback, $negativeFeedback);

        $statusIds = CodeMaster::where('type', 'application_status')
            ->whereIn('code', $statusCodes)
            ->pluck('id');

        $applications = darat_application::with(['applicationType', 'applicationStatus', 'user', 'fetchPin'])
            ->whereIn('application_status_id', $statusIds)
            ->whereHas('applicationType', function ($query) {
                $query->where('code', $this->applicationTypeCode);
            })
            ->whereHas('user', function ($query) {
                $query->where('entity_id', auth()->user()->entity_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $applicationType = CodeMaster::getApplicationTypeByCode($this->applicationTypeCode);

        $segment1       = request()->segment(1);
        $segment2       = request()->segment(2);
        $currentUrlPath = '/' . $segment1 . '/' . $segment2;

        $moduleName = DB::table('modules')->where('url', $currentUrlPath)->first();

        return view('app.NelayanDarat.gantiKulit.pegawai.4_sokonganUlasan2.index', compact(
            'applications',
            'positiveFeedback',
            'negativeFeedback',
            'applicationType',
            'moduleName',
            'roleName'
        ));
    }

    public function create($id)
    {
        $application = darat_application::findOrFail($id);
        $user = $application->user->load('fishermanInfo.aidAgencies');

        $roleName = Auth::user()->roles()->pluck('name')->first();
        $applicationType = CodeMaster::getApplicationTypeByCode($this->applicationTypeCode);

        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
        $currentUrlPath = '/' . $segment1 . '/' . $segment2;
        $moduleName = DB::table('modules')->where('url', $currentUrlPath)->first();

        return view('app.NelayanDarat.gantiKulit.pegawai.4_sokonganUlasan2.create', compact(
            'application',
            'user',
            'roleName',
            'applicationType',
            'moduleName'
        ));
    }

    public function store(Request $request, $id)
    {
        // Implementation for store method
        return redirect()->back()->with('success', 'Data berjaya disimpan');
    }

    public function updateFault(Request $request)
    {
        // Implementation for updateFault method
        return redirect()->back()->with('success', 'Data berjaya dikemaskini');
    }

    public function viewInspectionDocument(Request $request)
    {
        // Implementation for viewInspectionDocument method
        return response()->json(['success' => true]);
    }

    public function viewEquipment(Request $request)
    {
        // Implementation for viewEquipment method
        return response()->json(['success' => true]);
    }

    public function viewDocument(Request $request)
    {
        // Implementation for viewDocument method
        return response()->json(['success' => true]);
    }

    public function viewFaultDocument(Request $request)
    {
        // Implementation for viewFaultDocument method
        return response()->json(['success' => true]);
    }
} 