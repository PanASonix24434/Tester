<?php

namespace App\Http\Controllers\NelayanDarat\kadPendaftaran;

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
use App\Models\darat_vessel_hull;
use App\Models\darat_payment_receipt;
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingInfo;
use App\Models\NelayanDarat\darat_inspection_equipment;
use App\Models\NelayanDarat\Jetty;
use App\Models\NelayanDarat\River;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class cetakLesenController extends Controller
{

    protected $applicationTypeCode = '8';

    public function index()
    {
        $user     = Auth::user();
        $roleName = $user->roles()->pluck('name')->first();

        $positiveFeedback = ['810'];
        $negativeFeedback = ['0'];
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

        return view('app.NelayanDarat.kadPendaftaran.pegawai.11_cetakLesen.index', compact(
            'applications',
            'positiveFeedback',
            'negativeFeedback',
            'applicationType',
            'moduleName',
            'roleName',

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

        return view('app.NelayanDarat.kadPendaftaran.pegawai.11_cetakLesen.create', compact(
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

            // Fisherman Info
            $fishermanInfo = $formData['tab2_fisherman_info'] ?? [];
            $yearOnly = !empty($fishermanInfo['year_become_fisherman'])
                ? Carbon::parse($fishermanInfo['year_become_fisherman'])->format('Y')
                : null;

            $fishermanRecord = darat_user_fisherman_info::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'year_become_fisherman'            => $yearOnly,
                    'transportaion'                    => $vesselInfo['transport_type'] ?? null,
                    'becoming_fisherman_duration'      => $fishermanInfo['becoming_fisherman_duration'] ?? null,
                    'working_days_fishing_per_month'   => $fishermanInfo['working_days_fishing_per_month'] ?? null,
                    'estimated_income_yearly_fishing'  => $fishermanInfo['estimated_income_yearly_fishing'] ?? null,
                    'estimated_income_other_job'       => $fishermanInfo['estimated_income_other_job'] ?? null,
                    'days_working_other_job_per_month' => $fishermanInfo['days_working_other_job_per_month'] ?? null,
                    'receive_pension'                  => $fishermanInfo['receive_pension'] ?? null,
                    'receive_financial_aid'            => $fishermanInfo['receive_financial_aid'] ?? null,
                    'epf_type'            => $fishermanInfo['epf_type'] ?? null,
                    'epf_contributor'                  => $fishermanInfo['epf_contributor'] ?? null,
                    'fisherman_type_id'                   => $fishermanInfo['fisherman_type_id'] ?? null,
                    'created_by'                       => auth()->id(),
                    'updated_by'                       => auth()->id(),
                    'is_active'                        => true,
                ]
            );

            if (!empty($fishermanInfo['financial_aid_agency']) && is_array($fishermanInfo['financial_aid_agency'])) {
                foreach ($fishermanInfo['financial_aid_agency'] as $agencyName) {
                    darat_help_agency_fisherman::create([
                        'fisherman_info_id' => $fishermanRecord->id,
                        'agency_name'       => $agencyName,
                        'created_by'        => auth()->id(),
                    ]);
                }
            }



            // Jetty Info
            $jettyInfo = $formData['tab3_jetty_info'] ?? null;
            if ($jettyInfo) {
                $jettyRecord =  darat_base_jetties::updateOrCreate(
                    [
                        'user_id'    => $user->id,
                        'jetty_id' => $jettyInfo['jetty_id'] ?? null,
                    ],
                    [
                        'state_id'      => $jettyInfo['state_id'] ?? null,
                        'district_id'   => $jettyInfo['district_id'] ?? null,
                        'river_id'      => $jettyInfo['river_id'] ?? null,
                        'is_active'  => true,
                        'created_by' => auth()->id(),
                        'updated_by' => auth()->id(),
                    ]
                );
            }


            // Signed Document
            $documents = $formData['tab6_document'] ?? [];
            if (!empty($documents) && is_array($documents)) {
                foreach ($documents as $doc) {
                    if (empty($doc['file_path'])) continue;

                    $documentRecord =  darat_document::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'title'   => $doc['title'] ?? 'Dokumen',
                        ],
                        [
                            'file_path'        => $doc['file_path'],
                            'application_type' => $doc['application_type'] ?? 8,
                            'description'      => $doc['type'] ?? null,
                            'is_active'        => true,
                            'is_approved'      => true,
                            'created_by'       => auth()->id(),
                            'updated_by'       => auth()->id(),
                        ]
                    );
                }
            }



            // Vessel Info & Related
            $vesselInfo = $formData['tab5_vessel_info'] ?? null;

            if (!empty($vesselInfo) && ($vesselInfo['has_vessel'] ?? '') === 'yes') {
                $vesselRecord = darat_vessel::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'registration_number'   => $vesselInfo['vessel_registration_number'] ?? null,
                        'own_vessel'            => true,
                        'is_active'             => true,

                        'created_by'            => auth()->id(),
                        'updated_by'            => auth()->id(),
                    ]
                );




                $inspection = darat_vessel_inspection::where('application_id', $application->id)->first();

                if ($inspection) {
                    $hullRecord =   darat_vessel_hull::updateOrCreate(
                        ['user_id' =>  $user->id,],
                        [
                            'vessel_id'                   => $inspection->vessel_id,
                            'user_id' =>  $user->id,
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

                    if (!empty($inspection->engine_number)) {
                   $engineRecord =      $engine = darat_vessel_engine::updateOrCreate(
                            ['user_id' =>  $user->id,],
                            [
                                'vessel_id'                   => $inspection->vessel_id,
                                'model'                      => $inspection->engine_model,
                                'brand'                      => $inspection->engine_brand,
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
                    }
                }


            }

            // Application Status Update
            $statusCode = '811';
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

            return redirect()->route('kadPendaftaran.cetakLesen-08.index')
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
