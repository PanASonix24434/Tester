<?php

namespace App\Http\Controllers\NelayanDarat\lesenTahunan;

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
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingInfo;
use App\Models\ProfileUsers;
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
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class cetakLesenController extends Controller
{

    protected $applicationTypeCode = '2';

    public function index()
    {
        $user     = Auth::user();
        $roleName = $user->roles()->pluck('name')->first();

        $positiveFeedback = ['207'];
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

        return view('app.NelayanDarat.lesenTahunan.pegawai.7_cetakLesen.index', compact(
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

        $equipmentTemp = $formData['tab4_equipment_info'] ?? [];

        $vesselTemp = $formData['tab5_vessel_info'] ?? [];

        $documents = $formData['tab6_document'] ?? [];

        $mainTempt = collect($equipmentTemp)
            ->where('type', 'UTAMA')
            ->values()
            ->all();

        $additionalTempt = collect($equipmentTemp)
            ->where('type', 'TAMBAHAN')
            ->values()
            ->all();

        $inspectionOff = darat_vessel_inspection::where('user_id', $user->id)
            ->where('is_active', 1)
            ->latest()
            ->first();

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

        $receipt = darat_payment_receipt::where('application_id', $application->id)
            ->where('is_active', false)->first();

        $receiptItems = $receipt ? $receipt->items : collect();

        $vessel = darat_vessel::where('user_id', $user->id)->latest()->first();

        $vesselHullEngine = User::with(['hull', 'engine'])->find($user->id);

        $hull = $vesselHullEngine->hull ?? null;

        $engine = $vesselHullEngine->engine ?? null;

        return view('app.NelayanDarat.lesenTahunan.pegawai.7_cetakLesen.create', compact(
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
            'mainEquipment',
            'additionalEquipments',
            // 'vesselInfo',


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
            'receipt',
            'receiptItems',

            //New
            'vesselHullEngine',
            'hull',
            'engine',
            'vessel',
            'documents',
            'additionalTempt',
            'mainTempt',
            'equipmentTemp',
            'vesselTemp'

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

            $equipmentGroup = $formData['tab4_equipment_info'] ?? [];

            foreach ($equipmentGroup as $equipment) {
                darat_user_equipment::create([
                    'user_id'     => $user->id,
                    'application_id' => $application->id,
                    'name'        => $equipment['name'] ?? null,
                    'quantity'    => $equipment['quantity'] ?? null,
                    'type'        => $equipment['type'] ?? null,
                    'condition'   => $equipment['condition'] ?? null,
                    'file_path'   => $equipment['file_path'] ?? null,
                    'is_approved' => true, // or false if pending
                    'is_active'   => true,
                    'created_by'  => auth()->id(),
                    'updated_by'  => auth()->id(),
                ]);
            }

            // $fishermanInfo = $formData['tab2_fisherman_info'] ?? [];

            // // Create or update fisherman info and get the record
            // $fishermanRecord = darat_user_fisherman_info::updateOrCreate(
            //     ['user_id' => $user->id],
            //     [
            //         'year_become_fisherman'             => $fishermanInfo['year_become_fisherman'] ?? null,
            //         'becoming_fisherman_duration'       => $fishermanInfo['becoming_fisherman_duration'] ?? null,
            //         'working_days_fishing_per_month'    => $fishermanInfo['working_days_fishing_per_month'] ?? null,
            //         'estimated_income_yearly_fishing'   => $fishermanInfo['estimated_income_yearly_fishing'] ?? null,
            //         'estimated_income_other_job'        => $fishermanInfo['estimated_income_other_job'] ?? null,
            //         'days_working_other_job_per_month'  => $fishermanInfo['days_working_other_job_per_month'] ?? null,
            //         'receive_pension'                   => $fishermanInfo['receive_pension'] ?? null,
            //         'receive_financial_aid'             => $fishermanInfo['receive_financial_aid'] ?? null,
            //         'epf_contributor'                   => $fishermanInfo['epf_contributor'] ?? null,
            //         'type'                              => 'approved',
            //         'created_by'                        => auth()->id(),
            //         'updated_by'                        => auth()->id(),
            //         'is_active'                         => true,
            //     ]
            // );

            // // Use the ID from the above result
            // if (!empty($fishermanInfo['financial_aid_agency']) && is_array($fishermanInfo['financial_aid_agency'])) {
            //     foreach ($fishermanInfo['financial_aid_agency'] as $agencyName) {
            //         darat_help_agency_fisherman::create([
            //             'fisherman_info_id' => $fishermanRecord->id,
            //             'agency_name'       => $agencyName,
            //             'created_by'        => auth()->id(),
            //         ]);
            //     }
            // }

            // $jettyInfo = $formData['tab3_jetty_info'] ?? null;

            // if ($jettyInfo) {
            //     darat_base_jetties::updateOrCreate(
            //         [
            //             'user_id' => $user->id,
            //             'jetty_name' => $jettyInfo['jetty_name'] ?? null,
            //         ],
            //         [
            //             'state'      => $jettyInfo['state'] ?? null,
            //             'district'   => $jettyInfo['district'] ?? null,
            //             'river'      => $jettyInfo['river'] ?? null,
            //             'is_active'  => true,
            //             'created_by' => auth()->id(),
            //             'updated_by' => auth()->id(),
            //         ]
            //     );
            // }

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

            // ======================

            // Retrieve vessel inspection data from darat_vessel_inspection table
            $inspection = darat_vessel_inspection::where('application_id', $application->id)->first();

            if ($inspection && !empty($inspection->vessel_id)) {
                // Create or update the main hull record
                $hull = darat_vessel_hull::updateOrCreate(
                    ['vessel_id' => $inspection->vessel_id],
                    [
                        'vessel_id'                   => $inspection->vessel_id,
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
                    // 'right_side_image_path'     => removed
                    'is_active'                    => $hull->is_active,
                    'is_approved'                  => $hull->is_approved,
                    'created_by'                   => auth()->id(),
                    'updated_by'                   => auth()->id(),
                ]);
            }

            if ($inspection && !empty($inspection->engine_number)) {
                // 1. Create or update the main engine record
                $engine = darat_vessel_engine::updateOrCreate(
                    ['engine_number' => $inspection->engine_number],
                    [
                        'vessel_id'                  => $inspection->vessel_id,
                        'engine_model'               => $inspection->engine_model,
                        'engine_brand'               => $inspection->engine_brand,
                        'horsepower'                 => $inspection->horsepower,
                        'engine_number'              => $inspection->engine_number,
                        'engine_image_path'          => $inspection->engine_image_path,
                        'engine_number_image_path'   => $inspection->engine_number_image_path,
                        'is_active'                  => true,
                        'is_approved'                => true,
                        'created_by'                 => auth()->id(),
                        'updated_by'                 => auth()->id(),
                    ]
                );

                // 2. Create the history record (snapshot)
                darat_vessel_engine_history::create([
                    'vessel_engine_id'            => $engine->id,
                    'engine_model'                => $engine->engine_model,
                    'engine_brand'                => $engine->engine_brand,
                    'engine_number'               => $engine->engine_number,
                    'engine_image_path'           => $engine->engine_image_path,
                    'engine_number_image_path'    => $engine->engine_number_image_path,
                    'horsepower'                  => $engine->horsepower,
                    'is_active'                   => $engine->is_active,
                    'is_approved'                 => $engine->is_approved,
                    'created_by'                  => auth()->id(),
                    'updated_by'                  => auth()->id(),
                ]);
            }

            // ======================

            $statusCode = '208';
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

            return redirect()->route('lesenTahunan.cetakLesen-02.index')
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

      // new---------------------------------------------------------------------------------------------------

    public function createFaultRecord(Request $request)
    {

        DB::beginTransaction();

        try {

            $request->validate([
                'case_number'      => 'nullable|string|max:255',
                'fault_type'       => 'required|string|max:255',
                'fault_date'       => 'required|date',
                'method'           => 'nullable|string',
                'method_section'   => 'nullable|string|max:255',
                'decision'         => 'nullable|string',
                'case_document'    => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
            ]);

            $applicationId = $request->query('application_id');

            $application = darat_application::findOrFail($applicationId);
            $userId = $application->user_id;

            $documentPath = null;
            if ($request->hasFile('case_document')) {
                $documentPath = $request->file('case_document')->store('documents/fault_cases', 'public');
            }

            darat_fault_record::create([
                'user_id'         => $userId,
                'case_number'     => $request->case_number,
                'fault_type'      => $request->fault_type,
                'fault_date'      => $request->fault_date,
                'method'          => $request->method,
                'method_section'  => $request->method_section,
                'decision'        => $request->decision,
                'document_path'   => $documentPath,
                'is_active'       => true,
                'created_by'      => auth()->id(),
                'updated_by'      => auth()->id(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function viewFaultRecord(Request $request)
    {
        $recordId = $request->query('id');

        // Get the fault record where active and matches ID
        $record = darat_fault_record::where('id', $recordId)
            ->where('is_active', true)
            ->first();

        if (!$record || empty($record->document_path)) {
            abort(404, 'Dokumen kes tidak dijumpai.');
        }

        $filePath = ltrim($record->document_path, '/');

        // Check if the file exists in the public disk
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'Fail tidak dijumpai dalam storan.');
        }

        // Get full file content path for display
        $fullPath = Storage::disk('public')->path($filePath);

        return response()->file($fullPath, [
            'Content-Type' => mime_content_type($fullPath),
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

    public function viewEquipment(Request $request)
    {
        $equipmentId = $request->query('id');

        $equipment = darat_user_equipment::findOrFail($equipmentId);
        $filePath = $equipment->file_path;

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'Fail tidak dijumpai.');
        }

        $fullPath = Storage::disk('public')->path($filePath);

        return response()->file($fullPath, [
            'Content-Type' => mime_content_type($fullPath),
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"',
        ]);
    }

    public function viewTempDocument(Request $request)
    {
        $applicationId = $request->query('application_id');
        $index = $request->query('index');

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

        $filePath = ltrim($documents[$index]['file_path'], '/');

        // Use Laravel's Storage facade
        if (!Storage::disk('public')->exists($filePath)) {
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

    // new---------------------------------------------------------------------------------------------------
}
