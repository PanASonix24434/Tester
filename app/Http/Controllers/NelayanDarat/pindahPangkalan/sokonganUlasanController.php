<?php

namespace App\Http\Controllers\NelayanDarat\pindahPangkalan;

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
use App\Models\darat_user_detail;
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

class sokonganUlasanController extends Controller
{

    protected $applicationTypeCode = '3';

    public function index()
    {
        $user     = Auth::user();
        $roleName = $user->roles()->pluck('name')->first();

        $positiveFeedback = ['706'];
        $negativeFeedback = ['709'];
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

        return view('app.NelayanDarat.pindahPangkalan.pegawai.4_sokonganUlasan.index', compact(
            'applications',
            'positiveFeedback',
            'negativeFeedback',
            'applicationType',
            'moduleName',
            'roleName'
        ));
    }



    // public function create($id)
    // {
    //     $application = darat_application::findOrFail($id);
    //     $user = $application->user->load('fishermanInfo.aidAgencies'); // Load related info here

    //     $roleName = Auth::user()->roles()->pluck('name')->first();
    //     $applicationType = CodeMaster::getApplicationTypeByCode($this->applicationTypeCode);

    //     $segment1 = request()->segment(1);
    //     $segment2 = request()->segment(2);
    //     $currentUrlPath = '/' . $segment1 . '/' . $segment2;
    //     $moduleName = DB::table('modules')->where('url', $currentUrlPath)->first();

    //     $jetty = darat_base_jetties::where('user_id', $user->id)->where('is_active', true)->latest()->first();

    //     $vessel = darat_vessel::where('user_id', $user->id)->where('is_active', true)->latest()->first();

    //     $faultRecord = darat_fault_record::where('user_id', $user->id)->where('is_active', true)->orderBy('fault_date', 'desc')->get();

    //     $applicationLogs = darat_application_log::with(['applicationStatus', 'creator'])
    //         ->where('application_id', $id)
    //         ->orderBy('created_at', 'asc')
    //         ->get();

    //     $userDetail = darat_user_detail::where('user_id', $user->id)->where('is_active', 1)->first();

    //     $equipmentList = darat_equipment_list::where('is_active', true)->pluck('name', 'id');

    //     $temp = darat_application_temp::where('user_id', $user->id)
    //         ->where('status', 'pending')
    //         ->latest()
    //         ->first();

    //     $formData = json_decode($temp->form_data ?? '{}', true);

    //     $fishermanInfo = $formData['tab2_fisherman_info'] ?? [];
    //     $jettyInfo = $formData['tab3_jetty_info'] ?? null;
    //     $equipmentList = $formData['tab4_equipment_info'] ?? [];

    //     $mainEquipment = collect($equipmentList)
    //         ->filter(fn($item) => is_array($item) && ($item['type'] ?? '') === 'main')
    //         ->values()
    //         ->all();

    //     $additionalEquipments = collect($equipmentList)
    //         ->filter(fn($item) => is_array($item) && ($item['type'] ?? '') === 'additional')
    //         ->values()
    //         ->all();

    //     $vesselInfo = $formData['tab5_vessel_info'] ?? [];

    //     $documents = $formData['tab6_document'] ?? [];

    //     // ==

    //     $vesselOff = darat_vessel::where('user_id', $user->id)
    //         ->where('is_active', 1)
    //         ->first();

    //     $inspectionOff = darat_vessel_inspection::where('vessel_id', $vesselOff->id)
    //         ->where('is_active', 1)
    //         ->latest()
    //         ->first(); // Only take the latest one

    //     $isStillValid = false;

    //     if ($inspectionOff && $inspectionOff->valid_date) {
    //         $isStillValid = Carbon::parse($inspectionOff->valid_date)->gte(Carbon::now());
    //     }

    //     // == Off Data ==
    //     $fishermanInfoOff = darat_user_fisherman_info::where('user_id', $user->id)->where('is_active', 1)->first();
    //     $aidAgencyOff = $user->fishermanInfo?->aidAgencies ?? collect();
    //     $jettyOff = darat_base_jetties::where('user_id', $user->id)->where('is_active', 1)->first();
    //     $equipmentOff = darat_user_equipment::where('user_id', $user->id)->where('is_active', 1)->get();
    //     $vesselOff = darat_vessel::where('user_id', $user->id)->where('is_active', 1)->first();
    //     $documentOff = darat_document::where('user_id', $user->id)->where('application_type', $this->applicationTypeCode)->where('is_active', 1)->get();
    //     $vesselInfoOff = darat_vessel::with(['hull', 'engine'])
    //         ->where('user_id', $user->id)
    //         ->where('is_active', 1)
    //         ->first();

    //     $inspection = darat_vessel_inspection::where('vessel_id', $vesselOff->id)
    //         ->where('is_active', 1)
    //         ->get();

    //     return view('app.NelayanDarat.pindahPangkalan.pegawai.4_sokonganUlasan.create', compact(
    //         'application',
    //         'roleName',
    //         'applicationType',
    //         'moduleName',
    //         'vessel',
    //         'userDetail',
    //         'applicationLogs',
    //         'faultRecord',
    //         'jetty',

    //         'fishermanInfo',
    //         'jettyInfo',
    //         'equipmentList',
    //         'mainEquipment',
    //         'additionalEquipments',
    //         'vesselInfo',
    //         'documents',
    //         'isStillValid',
    //         'inspection',

    //         // == Off ==
    //         'fishermanInfoOff',
    //         'aidAgencyOff',
    //         'jettyOff',
    //         'equipmentOff',
    //         'vesselOff',
    //         'vesselInfoOff',
    //         'documentOff'
    //     ));
    // }

    public function create($id)
    {
        $application = darat_application::findOrFail($id);
        $user = $application->user->load('fishermanInfo.aidAgencies'); // Load related info here

        $roleName = Auth::user()->roles()->pluck('name')->first();
        $applicationType = CodeMaster::getApplicationTypeByCode($this->applicationTypeCode);

        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
        $currentUrlPath = '/' . $segment1 . '/' . $segment2;
        $moduleName = DB::table('modules')->where('url', $currentUrlPath)->first();

        $jetty = darat_base_jetties::with(['state', 'district', 'jetty', 'river'])->where('user_id', $user->id)->where('is_active', 1)->first();

        $vessel = darat_vessel::where('user_id', $user->id)->where('is_active', true)->latest()->first();

        $faultRecord = darat_fault_record::where('user_id', $user->id)->where('is_active', true)->orderBy('fault_date', 'desc')->get();

        $applicationLogs = darat_application_log::with(['applicationStatus', 'creator'])
            ->where('application_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        $userDetail = darat_user_detail::where('user_id', $user->id)->where('is_active', 1)->first();

        $equipmentList = darat_equipment_list::where('is_active', true)->pluck('name', 'id');

        $temp = darat_application_temp::where('application_id', $application->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        $formData = json_decode($temp->form_data ?? '{}', true);

        $fishermanInfo = $formData['tab2_fisherman_info'] ?? [];
        $jettyInfo = $formData['tab3_jetty_info'] ?? null;
        $equipmentList = $formData['tab4_equipment_info'] ?? [];

        $mainEquipment = collect($equipmentList)
            ->filter(fn($item) => is_array($item) && ($item['type'] ?? '') === 'main')
            ->values()
            ->all();

        $additionalEquipments = collect($equipmentList)
            ->filter(fn($item) => is_array($item) && ($item['type'] ?? '') === 'additional')
            ->values()
            ->all();

        $vesselInfo = $formData['tab5_vessel_info'] ?? [];

        $documents = $formData['tab6_document'] ?? [];

        $vesselOff = darat_vessel::where('user_id', $user->id)
            ->where('is_active', 1)
            ->first();

        $inspectionOff = darat_vessel_inspection::where('vessel_id', $vesselOff->id)
            ->where('is_active', 1)
            ->latest()
            ->first(); // Only take the latest one

        $isStillValid = false;

        $fishermanInfoOff = darat_user_fisherman_info::where('user_id', $user->id)->where('is_active', 1)->first();
        $aidAgencyOff = $user->fishermanInfo?->aidAgencies ?? collect();
        $jettyOff = darat_base_jetties::with(['state', 'district', 'jetty', 'river'])->where('user_id', $user->id)->where('is_active', 1)->first();

        $equipmentOff = darat_user_equipment::where('user_id', $user->id)->where('is_active', 1)->get();
        $vesselOff = darat_vessel::where('user_id', $user->id)->where('is_active', 1)->first();
        $documentOff = darat_document::where('user_id', $user->id)->where('application_type', $this->applicationTypeCode)->where('is_active', 1)->get();
        $vesselInfoOff = darat_vessel::with(['hull', 'engine'])
            ->where('user_id', $user->id)
            ->where('is_active', 1)
            ->first();

        // dd($vesselInfoOff);

        $inspection = darat_vessel_inspection::where('vessel_id', $vesselOff->id)
            ->where('is_active', 1)
            ->get();

        $latestApplicationId = darat_user_equipment::where('user_id', $user->id)
            ->where('is_active', 1)
            ->orderByDesc('created_at') // or use updated_at if that makes more sense
            ->value('application_id');

        $latestEquipmentGroup = darat_user_equipment::where('user_id', $user->id)
            ->where('is_active', 1)
            ->where('application_id', $latestApplicationId)
            ->get();

        $equipmentGrouped = darat_user_equipment::where('user_id', $user->id)
            ->where('is_active', 1)
            ->orderByDesc('created_at')
            ->get()
            ->groupBy('application_id')
            ->sortKeysDesc()
            ->slice(1);

        $declarations = LandingDeclaration::with([
            'landingInfo.landingInfoActivities.landingActivitySpecies.species'
        ])->get();

        $info = LandingInfo::first();
        $activities = $info->landingInfoActivities;

        $receipt = darat_payment_receipt::where('application_id', $application->id)
            ->where('is_active', false)->first();

        $receiptItems = $receipt ? $receipt->items : collect();

        return view('app.NelayanDarat.pindahPangkalan.pegawai.4_sokonganUlasan.create', compact(
            'application',
            'roleName',
            'applicationType',
            'moduleName',
            'vessel',
            'userDetail',
            'applicationLogs',
            'faultRecord',
            'jetty',
            'declarations',

            'fishermanInfo',
            'jettyInfo',
            'equipmentList',
            'mainEquipment',
            'additionalEquipments',
            'vesselInfo',
            'documents',
            'isStillValid',
            'inspection',
            'equipmentGrouped',
            'latestEquipmentGroup',

            'fishermanInfoOff',
            'aidAgencyOff',
            'jettyOff',
            'equipmentOff',
            'vesselOff',
            'vesselInfoOff',
            'documentOff',
            'receipt',
            'receiptItems'
        ));
    }


    public function store(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $application = darat_application::findOrFail($id);

            $request->validate([
                'review_flag'   => 'required|in:0,1',
                'support_flag'  => 'nullable|in:0,1|required_if:review_flag,1', // support_flag required if review_flag is 1
                'remarks'       => 'required|string',
            ]);

            $statusCode = $request->review_flag ? 708 : 707;
            $statusId = CodeMaster::where('type', 'application_status')
                ->where('code', $statusCode)
                ->value('id');

            $application->update([
                'application_status_id' => $statusId,
                'updated_by'            => auth()->id(),
            ]);

            darat_application_log::create([
                'application_id'        => $application->id,
                'application_status_id' => $statusId,
                'remarks'               => $request->remarks,
                'review_flag'           => $request->review_flag,
                'support_flag'          => $request->review_flag == '1' ? $request->support_flag : null,
                'created_by'            => auth()->id(),
                'is_active'             => true,
            ]);

            DB::commit();

            return redirect()->route('pindahPangkalan.sokonganUlasan-03.index')
                ->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function viewInspectionDocument(Request $request )
    {
        $inspectionID = $request->query('id');

        $field = $request->query('field');

        $inspection = darat_vessel_inspection::findOrFail($inspectionID);

        $filePath = $inspection->{$field};

        if (! $filePath) {
            abort(404, 'Fail tidak dijumpai.');
        }

        $path = storage_path('app/public/' . $filePath);

        if (! file_exists($path)) {
            abort(404, 'Fail tidak dijumpai dalam storan.');
        }

        return response()->file($path);
    }

    public function viewCrimeRecord(Request $request)
    {

        $recordId = $request->query('record_id');


        $record = darat_fault_record::where('id', $recordId)
            ->latest()
            ->first();

        if (!$record || empty($record->document_path)) {
            abort(404, 'Dokumen kes tidak dijumpai.');
        }

        $fullPath = storage_path('app/public/' . ltrim($record->document_path, '/'));

        if (!file_exists($fullPath)) {
            abort(404, 'Fail tidak dijumpai dalam storan.');
        }

        return response()->file($fullPath, [
            'Content-Type' => mime_content_type($fullPath),
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"',
        ]);
    }

    public function viewEquipment(Request $request)
    {
        $equipmentId = $request->query('id');

        $equipment = darat_user_equipment::findOrFail($equipmentId);

        $filePath = $equipment->file_path;

        if (!$filePath) {
            abort(404, 'Fail tidak dijumpai.');
        }

        $fullPath = storage_path('app/public/' . $filePath);

        if (!file_exists($fullPath)) {
            abort(404, 'Fail tidak dijumpai dalam storan.');
        }

        return response()->file($fullPath);
    }
    public function viewDocument(Request $request)
    {
        $applicationId = $request->query('application_id');
        $index = $request->query('index'); // index in tab6_document array

        if (!is_numeric($index) || $index < 0) {
            abort(400, 'Index tidak sah.');
        }

        // Retrieve the latest pending application temp data by user_id (application_id is user_id here)
        $temp = darat_application_temp::where('application_id', $applicationId)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$temp) {
            abort(404, 'Permohonan tidak dijumpai.');
        }

        $formData = json_decode($temp->form_data, true);
        $documents = $formData['tab6_document'] ?? [];

        if (!isset($documents[$index]) || empty($documents[$index]['file_path'])) {
            abort(404, 'Dokumen tidak dijumpai.');
        }

        $filePath = $documents[$index]['file_path'];
        $fullPath = storage_path('app/public/' . ltrim($filePath, '/'));

        if (!file_exists($fullPath)) {
            abort(404, 'Fail tidak dijumpai.');
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($fullPath);

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"',
        ]);
    }

    public function viewFaultDocument(Request $request)
    {
        $recordId = $request->query('record_id');

        $record = darat_fault_record::where('id', $recordId)
            ->where('is_active', true)
            ->latest()
            ->first();

        if (!$record || empty($record->document_path)) {
            abort(404, 'Dokumen kes tidak dijumpai.');
        }

        $fullPath = storage_path('app/public/' . ltrim($record->document_path, '/'));

        if (!file_exists($fullPath)) {
            abort(404, 'Fail tidak dijumpai dalam storan.');
        }

        return response()->file($fullPath, [
            'Content-Type' => mime_content_type($fullPath),
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"',
        ]);
    }
}
