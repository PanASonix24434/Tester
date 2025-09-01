<?php

namespace App\Http\Controllers\NelayanDarat\kadPendaftaran;

use App\Http\Controllers\Controller;
use App\Models\CatchingLocation_nd;
use App\Models\CodeMaster;
use App\Models\darat_application;
use App\Models\darat_application_log;
use App\Models\darat_base_jetties;
use App\Models\darat_base_jetty_history;
use App\Models\darat_document;
use App\Models\darat_fault_record;
use App\Models\ProfileUsers;
use App\Models\darat_user_equipment;
use App\Models\darat_user_equipment_history;
use App\Models\darat_user_fisherman_info;
use App\Models\darat_vessel;
use App\Models\darat_vessel_hull;
use App\Models\darat_vessel_engine;
use App\Models\darat_application_temp;
use App\Models\darat_vessel_inspection;
use App\Models\FishingLog_nd;
use App\Models\FishLanding_nd;
use App\Models\Entity;
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingInfo;
use App\Models\NelayanDarat\Jetty;
use App\Models\NelayanDarat\River;
use App\Models\SalesRecord_nd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class semakanUlasanController extends Controller
{

    protected $applicationTypeCode = '8';

    public function index()
    {
        $user     = Auth::user();
        $roleName = $user->roles()->pluck('name')->first();

        $positiveFeedback = ['805'];
        $negativeFeedback = ['807-1'];
        $statusCodes      = array_merge($positiveFeedback, $negativeFeedback);

        $statusIds = CodeMaster::where('type', 'application_status')
            ->whereIn('code', $statusCodes)
            ->pluck('id');

        $userEntity = Entity::find($user->entity_id);
        $childEntityIds = $userEntity ? $userEntity->getChildEntities() : [];

        $applications = darat_application::with(['applicationType', 'applicationStatus', 'user', 'fetchPin'])
            ->whereIn('application_status_id', $statusIds)
            ->whereHas('applicationType', function ($query) {
                $query->where('code', $this->applicationTypeCode);
            })
            // ->whereHas('user', function ($query) use ($childEntityIds) {
            //     $query->whereIn('entity_id', $childEntityIds);
            // })
            ->orderBy('created_at', 'desc')
            ->get();

        $applicationType = CodeMaster::getApplicationTypeByCode($this->applicationTypeCode);

        $segment1       = request()->segment(1);
        $segment2       = request()->segment(2);
        $currentUrlPath = '/' . $segment1 . '/' . $segment2;

        $moduleName = DB::table('modules')->where('url', $currentUrlPath)->first();

        return view('app.NelayanDarat.kadPendaftaran.pegawai.6_semakanUlasan.index', compact(
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
        $user        = $application->user;

        $roleName        = Auth::user()->roles()->pluck('name')->first();
        $applicationType = CodeMaster::getApplicationTypeByCode($this->applicationTypeCode);

        $segment1       = request()->segment(1);
        $segment2       = request()->segment(2);
        $currentUrlPath = '/' . $segment1 . '/' . $segment2;
        $moduleName     = DB::table('modules')->where('url', $currentUrlPath)->first();

        $jetty = darat_base_jetties::where('user_id', $user->id)
            ->where('is_active', true)
            ->latest()
            ->first();

        $vessel = darat_vessel::where('user_id', $user->id)
            ->where('is_active', true)
            ->latest()
            ->first();

        $faultRecord = darat_fault_record::where('user_id', $user->id)
            ->where('is_active', true)
            ->orderBy('fault_date', 'desc')
            ->get();

        $applicationLogs = darat_application_log::with(['applicationStatus', 'creator'])
            ->where('application_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Get the user details
        $userDetail = ProfileUsers::where('user_id', $user->id)->where('is_active', 1)->first();

        //
        // Retrieve the temporary application data (form data)
        $temp = darat_application_temp::where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        $formData = json_decode($temp->form_data ?? '{}', true);

        // Retrieve the specific data from the form_data
        $fishermanInfo = $formData['tab2_fisherman_info'] ?? [];

        $jettyInfoRaw = $formData['tab3_jetty_info'] ?? [];

        $jettyInfo = [
            'state'       => CodeMaster::find($jettyInfoRaw['state_id'])->name ?? 'Tidak Diketahui',
            'district'    => CodeMaster::find($jettyInfoRaw['district_id'])->name ?? 'Tidak Diketahui',
            'jetty_name'  => Jetty::find($jettyInfoRaw['jetty_id'])->name ?? 'Tidak Diketahui',
            'river'       => River::find($jettyInfoRaw['river_id'])->name ?? 'Tidak Diketahui',
        ];

        $equipmentList = $formData['tab4_equipment_info'] ?? [];

        $mainEquipment = collect($formData['tab4_equipment_info'] ?? [])
            ->filter(fn($item) => is_array($item) && ($item['type'] ?? '') === 'main')
            ->values()
            ->all();

        $additionalEquipments = collect($formData['tab4_equipment_info'] ?? [])
            ->filter(fn($item) => is_array($item) && ($item['type'] ?? '') === 'additional')
            ->values()
            ->all();

        $vesselInfo = $formData['tab5_vessel_info'] ?? [];

        $documents = $formData['tab6_document'] ?? [];

        $declarations = LandingDeclaration::with([
            'landingInfo.landingInfoActivities.landingActivitySpecies.species'
        ])->where('user_id', $user->id)->get();

        $info = LandingInfo::first();
        $activities = $info->landingInfoActivities;

        $inspection = darat_vessel_inspection::where('user_id', $user->id)
            ->where('is_active', 1)
            ->get();

        return view('app.NelayanDarat.kadPendaftaran.pegawai.6_semakanUlasan.create', compact(
            'application',
            'roleName',
            'applicationType',
            'moduleName',
            'vessel',
            'userDetail',
            'applicationLogs',
            'faultRecord',
            'jetty',

            'fishermanInfo',
            'jettyInfo',
            'equipmentList',
            'mainEquipment',
            'additionalEquipments',
            'vesselInfo',
            'documents',
            'declarations',
            'inspection'
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
                'review_flag' => 'required|in:1,0',
                'remarks'     => 'required|string',
            ]);

            $statusCode = $request->review_flag ? '806' : '805-1';
            $statusId = CodeMaster::where('type', 'application_status')
                ->where('code', $statusCode)
                ->value('id');

            // Update the application status
            $application->update([
                'application_status_id' => $statusId,
                'updated_by'            => auth()->id(),
            ]);

            // Log entry
            darat_application_log::create([
                'application_id'        => $application->id,
                'application_status_id' => $statusId,
                'review_flag'           => $request->review_flag,
                'remarks'               => $request->remarks,
                'created_by'            => auth()->id(),
                'is_active'             => true,
            ]);

            DB::commit();

            return redirect()->route('kadPendaftaran.semakanUlasan-08.index')
                ->with('success', 'Berjaya dihantar.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    // NEW -------------------------------------------------------------------------------------------------

    public function viewFaultRecord(Request $request)
    {
        $applicationId = $request->query('application_id');

        $application = darat_application::findOrFail($applicationId);
        $userId = $application->user_id;

        $record =  darat_fault_record::where('user_id', $userId)
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

        $mimeType = File::mimeType($fullPath);

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"',
        ]);
    }

    public function viewTempDocument(Request $request)
    {
        $applicationId = $request->query('application_id');
        $index = $request->query('index');

        if (!is_numeric($index) || (int)$index < 0) {
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
            abort(404, 'Fail tidak dijumpai dalam storan.');
        }

        $mimeType = File::mimeType($fullPath);

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"',
        ]);
    }

    public function viewTempEquipment(Request $request)
    {
        $applicationId = $request->query('application_id');
        $index = $request->query('index');

        if (!is_numeric($index)) {
            abort(400, 'Index tidak sah.');
        }

        $application = darat_application::find($applicationId);
        if (!$application || !$application->user) {
            abort(404, 'Permohonan atau pengguna tidak dijumpai.');
        }

        $temp = darat_application_temp::where('user_id', $application->user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$temp) {
            abort(404, 'Permohonan tidak dijumpai.');
        }

        $formData = json_decode($temp->form_data, true);
        $equipmentList = $formData['tab4_equipment_info'] ?? [];

        $equipment = $equipmentList[$index] ?? null;
        $filePath = $equipment['file_path'] ?? null;

        if (!$filePath) {
            abort(404, 'Fail tidak dijumpai.');
        }

        $fullPath = storage_path('app/public/' . ltrim($filePath, '/'));

        if (!file_exists($fullPath)) {
            abort(404, 'Fail tidak wujud di storan.');
        }

        $mimeType = File::mimeType($fullPath);

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"',
        ]);
    }

    public function viewInspection(Request $request)
    {
        $inspectionId = $request->query('id');
        $field = $request->query('field');

        if (!$inspectionId || !$field) {
            abort(400, 'Parameter tidak lengkap.');
        }

        $inspection = darat_vessel_inspection::findOrFail($inspectionId);
        $filePath = ltrim($inspection->{$field}, '/');

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'Fail tidak dijumpai dalam storan.');
        }

        return response()->file(
            Storage::disk('public')->path($filePath),
            [
                'Content-Type' => Storage::disk('public')->mimeType($filePath),
                'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
            ]
        );
    }

    // NEW -------------------------------------------------------------------------------------------------
}
