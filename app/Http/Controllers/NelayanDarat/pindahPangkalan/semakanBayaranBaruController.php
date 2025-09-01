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
use App\Models\darat_user_detail;
use App\Models\darat_user_equipment;
use App\Models\darat_user_equipment_history;
use App\Models\darat_payment_receipt;
use App\Models\darat_user_fisherman_info;
use App\Models\darat_vessel;
use App\Models\darat_vessel_engine_history;
use App\Models\darat_vessel_history;
use App\Models\darat_vessel_hull_history;
use App\Models\darat_vessel_inspection;
use App\Models\FishingLog_nd;
use App\Models\FishLanding_nd;
use App\Models\SalesRecord_nd;
use App\Models\darat_vessel_engine;
use App\Models\darat_application_temp;
use App\Models\darat_equipment_list;
use App\Models\darat_vessel_hull;
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingInfo;
use App\Models\NelayanDarat\Jetty;
use App\Models\NelayanDarat\River;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// use App\Mail\PemeriksaanLpiNotification;
// use App\Mail\ApplicationResultNotification;

class semakanBayaranBaruController extends Controller
{

    protected $applicationTypeCode = '3';

    public function index()
    {
        $user     = Auth::user();
        $roleName = $user->roles()->pluck('name')->first();

        $positiveFeedback = ['318'];
        $negativeFeedback = [''];
        $statusCodes      = array_merge($positiveFeedback, $negativeFeedback);

        $statusIds = CodeMaster::where('type', 'application_status')
            ->whereIn('code', $statusCodes)
            ->pluck('id');

        $userEntityId = $user->entity_id;

        // Get all applications with matching status & entity_id
        $applications = darat_application::with(['applicationType', 'applicationStatus', 'user', 'fetchPin'])
            ->whereIn('application_status_id', $statusIds)
            ->whereHas('applicationType', function ($query) {
                $query->where('code', $this->applicationTypeCode);
            })
            ->where('new_entity_id', $userEntityId)
            ->orderBy('created_at', 'desc')
            ->get();

        $applicationType = CodeMaster::getApplicationTypeByCode($this->applicationTypeCode);

        $segment1       = request()->segment(1);
        $segment2       = request()->segment(2);
        $currentUrlPath = '/' . $segment1 . '/' . $segment2;

        $moduleName = DB::table('modules')->where('url', $currentUrlPath)->first();

        return view('app.NelayanDarat.pindahPangkalan.pegawai.13_semakanBayaranBaru.index', compact(
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

        $inspectionOff = darat_vessel_inspection::where('user_id', $user->id)
            ->where('is_active', 1)
            ->latest()
            ->first(); // Only take the latest one

        $isStillValid = false;

        if ($inspectionOff && $inspectionOff->valid_date) {
            $isStillValid = Carbon::parse($inspectionOff->valid_date)->gte(Carbon::now());
        }

        $fishermanInfoOff = darat_user_fisherman_info::where('user_id', $user->id)->where('is_active', 1)->first();
        $aidAgencyOff = $user->fishermanInfo?->aidAgencies ?? collect();

        $jettyOff = darat_base_jetties::with(['state', 'district', 'jetty', 'river'])->where('user_id', $user->id)->where('is_active', 1)->first();

        $jettyOffColl = darat_base_jetties::with(['state', 'district', 'jetty', 'river'])->where('user_id', $user->id)->where('is_active', 1)->get();

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
            ->where('is_active', true)->first();

        $receiptItems = $receipt ? $receipt->items : collect();

        $stateName = CodeMaster::find($jettyInfo['state_id'])->name ?? 'Tidak Diketahui';
        $districtName = CodeMaster::find($jettyInfo['district_id'])->name ?? 'Tidak Diketahui';
        $jettyName = Jetty::find($jettyInfo['jetty_id'])->name ?? 'Tidak Diketahui';
        $riverName = River::find($jettyInfo['river_id'])->name ?? 'Tidak Diketahui';

        return view('app.NelayanDarat.pindahPangkalan.pegawai.13_semakanBayaranBaru.create', compact(
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
            'receiptItems',
            'jettyOffColl',

            'stateName',
            'districtName',
            'jettyName',
            'riverName'

        ));
    }

    public function fetchData(Request $request, $id)
    {
        $application = darat_application::findOrFail($id);

        $user = $application->user;

        $pangkalan = darat_base_jetties::with(['state', 'district', 'river', 'jetty'])->where('user_id', $user->id)->first();

        $year  = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));

        $fishingLogs = FishingLog_nd::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        $catchingLocations = CatchingLocation_nd::whereIn('fishing_log_id', $fishingLogs->pluck('fishing_log_id'))
            ->select('district_name', 'river_name', DB::raw('COUNT(*) as total'))
            ->groupBy('district_name', 'river_name')
            ->get();

        $fishLandings = FishLanding_nd::whereIn('fishing_log_id', $fishingLogs->pluck('fishing_log_id'))
            ->join('fish_species_nds', 'fish_landing_nds.fish_species_id', '=', 'fish_species_nds.fish_species_id')
            ->select(
                'fish_species_nds.species_name',
                'fish_landing_nds.fish_landing_id',
                DB::raw('SUM(fish_landing_nds.total_weight_kg) as total_weight')
            )
            ->groupBy('fish_species_nds.species_name', 'fish_landing_nds.fish_landing_id')
            ->get();

        $fishType = FishLanding_nd::whereIn('fishing_log_id', $fishingLogs->pluck('fishing_log_id'))
            ->join('fish_species_nds', 'fish_landing_nds.fish_species_id', '=', 'fish_species_nds.fish_species_id')
            ->select(
                'fish_species_nds.species_name',
                DB::raw('SUM(fish_landing_nds.total_weight_kg) as total_weight')
            )
            ->groupBy('fish_species_nds.species_name')
            ->get();

        $salesData = SalesRecord_nd::whereIn('fish_landing_id', $fishLandings->pluck('fish_landing_id'))
            ->join('fish_species_nds', 'sales_record_nds.fish_species_id', '=', 'fish_species_nds.fish_species_id')
            ->select(
                'fish_species_nds.species_name',
                DB::raw('SUM(sales_record_nds.sold_weight_kg) as total_sold_weight'),
                DB::raw('AVG(sales_record_nds.price_per_kg) as avg_price_per_kg'),
                DB::raw('SUM(sales_record_nds.total_sale_amount) as total_sales')
            )
            ->groupBy('fish_species_nds.species_name')
            ->get();

        $daysOfOperation = FishingLog_nd::where('user_id', $user->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->distinct('date')
            ->count();

        return response()->json([
            'daysOfOperation'   => $daysOfOperation,
            'catchingLocations' => $catchingLocations,
            'fishLandings'      => $fishLandings,
            'salesData'         => $salesData,
            'year'              => $year,
            'month'             => $month,
            'fishType'          => $fishType,
            'pangkalan'         => $pangkalan,
        ]);
    }

    public function store(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $application = darat_application::findOrFail($id);

            $request->validate([
                'review_flag'       => 'required|in:0,1',
                'confirmation_flag' => 'nullable|in:0,1|required_if:review_flag,1',
                'remarks'           => 'nullable|string',
            ]);

            $statusCode = $request->review_flag == '1' ? 320 : 319;

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
                'review_flag'           => $request->review_flag,
                'confirmation_flag'     => $request->confirmation_flag,
                'remarks'               => $request->remarks,
                'created_by'            => auth()->id(),
                'is_active'             => true,
            ]);

            DB::commit();

            return redirect()->route('pindahPangkalan.semakanBayaranBaru-03.index')
                ->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    //== view
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

    public function viewInspectionDocument(Request $request)
    {
        $inspectionId = $request->query('id');
        $field        = $request->query('field');

        // Find the inspection
        $inspection = darat_vessel_inspection::findOrFail($inspectionId);

        // Dynamically read that field
        $filePath = $inspection->{$field};

        if (! $filePath || ! file_exists(storage_path('app/public/' . $filePath))) {
            abort(404, 'Fail tidak dijumpai.');
        }

        return response()->file(storage_path('app/public/' . $filePath));
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

    public function viewReceipt(Request $request)
    {
        $receiptId = $request->query('receipt_id');

        $receiptFile = darat_payment_receipt::where('id', $receiptId)
            ->latest()
            ->first();

        if (!$receiptFile || empty($receiptFile->uploaded_file_path)) {
            abort(404, 'Peralatan tidak dijumpai atau fail tiada.');
        }

        $fullPath = storage_path('app/public/' . ltrim($receiptFile->uploaded_file_path, '/'));

        if (!file_exists($fullPath)) {
            abort(404, 'Fail tidak dijumpai dalam storan.');
        }

        return response()->file($fullPath, [
            'Content-Type' => mime_content_type($fullPath),
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"',
        ]);
    }
}
