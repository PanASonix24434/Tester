<?php

namespace App\Http\Controllers\NelayanDarat\gantiKulit;

use App\Http\Controllers\Controller;
use App\Models\CatchingLocation_nd;
use App\Models\CodeMaster;
use App\Models\darat_application;
use App\Models\darat_application_approved;
use App\Models\darat_application_log;
use App\Models\darat_base_jetties;
use App\Models\darat_base_jetty_history;
use App\Models\darat_document;
use App\Models\darat_fault_record;
use App\Models\darat_temporary_pin;
use App\Models\darat_help_agency_fisherman;
use App\Models\darat_user_detail;
use App\Models\darat_user_equipment;
use App\Models\darat_user_equipment_history;
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
use App\Models\darat_payment_receipt;
use App\Models\darat_vessel_disposals;
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingInfo;
use App\Models\NelayanDarat\Jetty;
use App\Models\NelayanDarat\River;
use App\Models\ProfileUsers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class cetakLesenController extends Controller
{

    protected $applicationTypeCode = '6';

    public function index()
    {
        $user     = Auth::user();
        $roleName = $user->roles()->pluck('name')->first();

        $positiveFeedback = ['612'];
        $negativeFeedback = [''];
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

        return view('app.NelayanDarat.gantiKulit.pegawai.10_cetakLesen.index', compact(
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

    //     $jetty = darat_base_jetties::with(['state', 'district', 'jetty', 'river'])->where('user_id', $user->id)->where('is_active', 1)->first();

    //     $vessel = darat_vessel::where('user_id', $user->id)->where('is_active', true)->latest()->first();

    //     $faultRecord = darat_fault_record::where('user_id', $user->id)->where('is_active', true)->orderBy('fault_date', 'desc')->get();

    //     $applicationLogs = darat_application_log::with(['applicationStatus', 'creator'])
    //         ->where('application_id', $id)
    //         ->orderBy('created_at', 'asc')
    //         ->get();

    //     $userDetail = darat_user_detail::where('user_id', $user->id)->where('is_active', 1)->first();

    //     $equipmentList = darat_equipment_list::where('is_active', true)->pluck('name', 'id');

    //     $temp = darat_application_temp::where('application_id', $application->id)
    //         ->where('status', 'pending')
    //         ->latest()
    //         ->first();

    //     $formData = json_decode($temp->form_data ?? '{}', true);

    //     $fishermanInfo = $formData['tab2_fisherman_info'] ?? [];
    //     $jettyInfo = $formData['tab3_jetty_info'] ?? null;
    //     $equipmentList = $formData['tab4_equipment_info'] ?? [];

    //     $dispose = $formData['tab7_disposal'] ?? [];

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

    //     $vesselOff = darat_vessel::where('user_id', $user->id)
    //         ->where('is_active', 1)
    //         ->first();

    //     $inspectionOff = darat_vessel_inspection::where('user_id', $user->id)
    //         ->where('is_active', 1)
    //         ->latest()
    //         ->first(); // Only take the latest one

    //     // $isStillValid = false;

    //     // if ($inspectionOff && $inspectionOff->valid_date) {
    //     //     $isStillValid = Carbon::parse($inspectionOff->valid_date)->gte(Carbon::now());
    //     // }

    //     $fishermanInfoOff = darat_user_fisherman_info::where('user_id', $user->id)->where('is_active', 1)->first();
    //     $aidAgencyOff = $user->fishermanInfo?->aidAgencies ?? collect();

    //     $jettyOff = darat_base_jetties::with(['state', 'district', 'jetty', 'river'])->where('user_id', $user->id)->where('is_active', 1)->first();

    //     $jettyOffColl = darat_base_jetty_history::with(['state', 'district', 'jetty', 'river'])->where('user_id', $user->id)->get();

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

    //     $latestApplicationId = darat_user_equipment::where('user_id', $user->id)
    //         ->where('is_active', 1)
    //         ->orderByDesc('created_at') // or use updated_at if that makes more sense
    //         ->value('application_id');

    //     $latestEquipmentGroup = darat_user_equipment::where('user_id', $user->id)
    //         ->where('is_active', 1)
    //         ->where('application_id', $latestApplicationId)
    //         ->get();

    //     $equipmentGrouped = darat_user_equipment::where('user_id', $user->id)
    //         ->where('is_active', 1)
    //         ->orderByDesc('created_at')
    //         ->get()
    //         ->groupBy('application_id')
    //         ->sortKeysDesc()
    //         ->slice(1);

    //     $declarations = LandingDeclaration::with([
    //         'landingInfo.landingInfoActivities.landingActivitySpecies.species'
    //     ])->get();

    //     $info = LandingInfo::first();
    //     $activities = $info->landingInfoActivities;

    //     $receipt = darat_payment_receipt::where('application_id', $application->id)
    //         ->where('is_active', false)->first();

    //     $receiptItems = $receipt ? $receipt->items : collect();

    //     $disposeOff = darat_vessel_disposals::where('application_id', $application->id)
    //         ->first();

    //     return view('app.NelayanDarat.gantiKulit.pegawai.10_cetakLesen.create', compact(
    //         'application',
    //         'roleName',
    //         'applicationType',
    //         'moduleName',
    //         'vessel',
    //         'userDetail',
    //         'applicationLogs',
    //         'faultRecord',
    //         'jetty',
    //         'declarations',

    //         'fishermanInfo',
    //         'jettyInfo',
    //         'equipmentList',
    //         'mainEquipment',
    //         'additionalEquipments',
    //         'vesselInfo',
    //         'documents',
    //         // 'isStillValid',
    //         'inspection',
    //         'equipmentGrouped',
    //         'latestEquipmentGroup',

    //         'fishermanInfoOff',
    //         'aidAgencyOff',
    //         'jettyOff',
    //         'equipmentOff',
    //         'vesselOff',
    //         'vesselInfoOff',
    //         'documentOff',
    //         'receipt',
    //         'receiptItems',
    //         'jettyOffColl',

    //         'dispose',
    //         'disposeOff'

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

        $userDetail = ProfileUsers::where('user_id', $user->id)->where('is_active', 1)->first();

        $equipmentList = darat_equipment_list::where('is_active', true)->pluck('name', 'id');

        $mainEquipment = collect($equipmentList)
            ->filter(fn($item) => is_array($item) && ($item['type'] ?? '') === 'UTAMA')
            ->values()
            ->all();

        $additionalEquipments = collect($equipmentList)
            ->filter(fn($item) => is_array($item) && ($item['type'] ?? '') === 'TAMBAHAN')
            ->values()
            ->all();

        $temp = darat_application_temp::where('application_id', $application->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        $formData = json_decode($temp->form_data ?? '{}', true);

        // $vesselTemp = $formData['tab5_vessel_info'] ?? [];

        $documents = $formData['tab6_document'] ?? [];

        $disposeTemp = $formData['temp_disposal_info'] ?? [];

        $inspectionOff = darat_vessel_inspection::where('user_id', $user->id)
            ->where('is_active', 1)
            ->latest()
            ->first();

        // $isStillValid = false;

        // if ($inspectionOff && $inspectionOff->valid_date) {
        //     $isStillValid = Carbon::parse($inspectionOff->valid_date)->gte(Carbon::now());
        // }

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

        $inspection = darat_vessel_inspection::where('user_id', $user->id)
            ->where('is_active', 1)
            ->get();

        $latestApplicationId = darat_user_equipment::where('user_id', $user->id)
            ->where('is_active', 1)
            ->orderByDesc('created_at')
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

        // $receipt = darat_payment_receipt::where('application_id', $application->id)
        //     ->where('is_active', false)->first();

        // $receiptItems = $receipt ? $receipt->items : collect();

        $vessel = darat_vessel::where('user_id', $user->id)->latest()->first();

        $vesselHullEngine = User::with(['hull', 'engine'])->find($user->id);

        $hull = $vesselHullEngine->hull ?? null;
        $engine = $vesselHullEngine->engine ?? null;

        $disposeInfo = darat_vessel_disposals::where('application_id', $application->id)->latest()->first();

        return view('app.NelayanDarat.gantiKulit.pegawai.10_cetakLesen.create', compact(
            'application',
            'roleName',
            'applicationType',
            'moduleName',
            'userDetail',
            'applicationLogs',
            'faultRecord',
            'jetty',
            'declarations',

            // 'fishermanInfo',
            // 'jettyInfo',
            'equipmentList',
            // 'mainEquipment',
            // 'additionalEquipments',
            // 'vesselInfo',

            // 'isStillValid',
            'inspection',
            'equipmentGrouped',
            'latestEquipmentGroup',

            'fishermanInfoOff',
            'aidAgencyOff',
            'jettyOff',
            'equipmentOff',
            'vesselOff',
            // 'vesselInfoOff',
            'documentOff',
            // 'receipt',
            // 'receiptItems',

            //New
            'vesselHullEngine',
            'hull',
            'engine',
            'vessel',
            'documents',
            // 'additionalTempt',
            // 'mainTempt',
            // 'equipmentTemp',
            // 'vesselTemp',
            'disposeTemp',
            'disposeInfo'

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

            $user = $application->user;

            $request->validate([
                'pin_number' => 'required|string|max:255',
                'no_ssd'     => 'required|string|max:255',
            ]);

            $temp = darat_application_temp::where('application_id', $application->id)
                ->where('status', 'pending')
                ->latest()
                ->first();



            $formData = json_decode($temp->form_data ?? '{}', true);

            $disposeTemp = $formData['temp_disposal_info'] ?? [];

            if (!empty($disposeTemp)) {
                darat_vessel_disposals::updateOrCreate(
                    ['application_id' => $application->id],
                    [
                        'user_id'           => $application->user_id,
                        'jenis_permohonan'  => $disposeTemp['main_disposal_action'] ?? null,
                        'jenis_jualan'      => $disposeTemp['disposal_type'] ?? null,
                        'owner_name'        => $disposeTemp['new_owner_name'] ?? null,
                        'owner_phone'       => $disposeTemp['new_owner_phone'] ?? null,
                        'owner_ic'          => $disposeTemp['new_owner_ic'] ?? null,
                        'is_active'         => true,
                        'is_approved'       => false,
                        'created_by'        => auth()->id(),
                        'updated_by'        => auth()->id(),
                    ]
                );
            }
;
            $documents = $formData['tab6_document'] ?? [];

            if (!empty($documents) && is_array($documents)) {
                foreach ($documents as $doc) {
                    // Skip if file_path is empty
                    if (empty($doc['file_path'])) {
                        continue;
                    }

                    darat_document::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'title'   => $doc['title'] ?? 'Dokumen', // Unique condition
                        ],
                        [
                            'file_path'        => $doc['file_path'],
                            'application_type' => $doc['application_type'] ?? $this->applicationTypeCode,
                            'description'      => $doc['type'] ?? null,
                            'is_active'        => true,
                            'is_approved'      => true,
                            'created_by'       => auth()->id(),
                            'updated_by'       => auth()->id(),
                        ]
                    );
                }
            }

            $inspection = darat_vessel_inspection::where('application_id', $application->id)->first();


           if ($inspection && !empty($inspection->hull_type)) {
                // Create or update the main hull record
                $hull = darat_vessel_hull::updateOrCreate(
                    [  'user_id' =>  $user->id,  'vessel_id'                   => $inspection->vessel_id,],
                    [

                        'hull_type'                   => $inspection->hull_type,
                        'drilled'                     => $inspection->drilled,
                        'brightly_painted'            => $inspection->brightly_painted,
                        'vessel_registration_remarks' => $inspection->vessel_registration_remarks,
                        'length'                      => $inspection->length,
                        'width'                       => $inspection->width,
                        'depth'                       => $inspection->depth,
                        'overall_image_path'          => $inspection->overall_image_path,
                        'is_active'                   => true,
                        'is_approved'                 => true,
                        'created_by'                  => auth()->id(),
                        'updated_by'                  => auth()->id(),
                    ]
                );

                // Create a hull history snapshot
                darat_vessel_hull_history::create([
                    'vessel_hull_id'               => $hull->id,
                    'hull_type'                    => $hull->hull_type,
                    'drilled'                      => $hull->drilled,
                    'brightly_painted'             => $hull->brightly_painted,
                    'vessel_registration_remarks' => $hull->vessel_registration_remarks,
                    'length'                       => $hull->length,
                    'width'                        => $hull->width,
                    'depth'                        => $hull->depth,
                    'overall_image_path'           => $hull->overall_image_path,
                    'is_active'                    => $hull->is_active,
                    'is_approved'                  => $hull->is_approved,
                    'created_by'                   => auth()->id(),
                    'updated_by'                   => auth()->id(),
                ]);
            }

            // ======================

            $statusCode = 618;
            $statusId   = CodeMaster::where('type', 'application_status')
                ->where('code', $statusCode)
                ->value('id');

            $application->update([
                'application_status_id' => $statusId,
                'updated_by'            => auth()->id(),
                'is_active'             => true,
            ]);

            darat_application_log::create([
                'application_id'        => $application->id,
                'application_status_id' => $statusId,
                'created_by'            => auth()->id(),
                'is_active'             => true,
            ]);

            $validMonths = 6;
            $approvedAt  = now();
            $expiredAt   = $approvedAt->copy()->addMonths($validMonths);

            darat_application_approved::create([
                'application_id'        => $application->id,
                'certificate_number'    => $request->no_ssd,
                'approved_by'           => auth()->id(),
                'approved_at'           => $approvedAt,
                'valid_duration_months' => $validMonths,
                'expired_at'            => $expiredAt,
                'is_active'             => true,
                'created_by'            => auth()->id(),
            ]);

            darat_temporary_pin::where('pin_number', $request->pin_number)
                ->whereNull('deleted_at')
                ->update(['deleted_at' => now()]);

            darat_application_temp::where('application_id', $application->id)
                ->update(['status' => 'approved']);

            DB::commit();

            return redirect()->route('gantiKulit.cetakLesen-06.index')
                ->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function semakPin(Request $request, $id)
    {
        // Trim the pin_number to remove spaces
        $pinNumber = trim($request->input('pin_number'));

        // Validate PIN input
        $request->merge(['pin_number' => $pinNumber]);
        $request->validate([
            'pin_number' => 'required|string|max:80',
        ]);

        // Find Application
        $application = darat_application::findOrFail($id);

        // Check if PIN exists
        $temporaryPinExists = darat_temporary_pin::where([
            ['application_id', $application->id],
            ['pin_number', $pinNumber], // Use trimmed PIN
        ])->exists();

        // Return JSON response
        return response()->json([
            'success' => $temporaryPinExists,
            'message' => $temporaryPinExists ? 'No. Pin Sepadan!' : 'No. Pin Tidak Sah Atau Tidak Sama.',
        ], $temporaryPinExists ? 200 : 400);
    }

    public function viewInspectionDocument(Request $request)
    {

        $inspectionId = $request->query('id');
        $field = $request->query('field');

        $inspection = darat_vessel_inspection::findOrFail($inspectionId);

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

    public function viewFaultDocument(Request $request)
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

    public function viewEquipmentFile(Request $request)
    {

        $userId = $request->query('application_id');
        $type = $request->query('type');
        $index = (int) $request->query('index'); // Ensure it's treated as an integer

        if (!in_array($type, ['main', 'additional'])) {
            abort(400, 'Jenis peralatan tidak sah.');
        }

        $temp = darat_application_temp::where('application_id', $userId)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$temp) {
            abort(404, 'Permohonan tidak dijumpai.');
        }

        $formData = json_decode($temp->form_data, true);
        $equipmentList = collect($formData['tab4_equipment_info'] ?? []);

        // Filter equipment list by type and get by index
        $filtered = $equipmentList->where('type', $type)->values();
        $equipment = $filtered->get($index);

        $filePath = $equipment['file_path'] ?? null;

        if (!$filePath) {
            abort(404, 'Tiada fail tersedia.');
        }

        $fullPath = storage_path('app/public/' . $filePath);

        if (!file_exists($fullPath)) {
            abort(404, 'Fail tidak dijumpai.');
        }

        return response()->file($fullPath, [
            'Content-Type' => mime_content_type($fullPath),
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

    public function viewInspectionDisposal(Request $request)
    {

        $disposalId = $request->query('id');
        $field = $request->query('field'); // 'main' or 'additional'

        $inspection = darat_vessel_disposals::findOrFail($disposalId);

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
}
