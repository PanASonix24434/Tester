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
use App\Models\darat_temporary_pin;
use App\Models\darat_fault_record;
use App\Models\ProfileUsers;
use App\Models\darat_user_equipment;
use App\Models\darat_user_equipment_history;
use App\Models\darat_user_fisherman_info;
use App\Models\darat_vessel;
use App\Models\darat_vessel_engine;
use App\Models\darat_application_temp;
use App\Models\darat_vessel_hull;
use App\Models\darat_vessel_inspection;
use App\Models\FishingLog_nd;
use App\Models\FishLanding_nd;
use App\Models\Entity;
use App\Models\SalesRecord_nd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

// use App\Mail\PemeriksaanLpiNotification;
use App\Mail\ApplicationResultNotification;
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingInfo;
use App\Models\NelayanDarat\darat_inspection_equipment;
use App\Models\NelayanDarat\Jetty;
use App\Models\NelayanDarat\River;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class keputusanController extends Controller
{

    protected $applicationTypeCode = '8';

    public function index()
    {
        $user     = Auth::user();
        $roleName = $user->roles()->pluck('name')->first();

        $positiveFeedback = ['807'];
        $negativeFeedback = ['0'];
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

        return view('app.NelayanDarat.kadPendaftaran.pegawai.8_keputusan.index', compact(
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

        $fishermanType = CodeMaster::where('type','fisherman_type' )->pluck('id','name');

          $inspection = darat_vessel_inspection::where('user_id', $user->id)
            ->where('is_active', 1)
            ->get();

        return view('app.NelayanDarat.kadPendaftaran.pegawai.8_keputusan.create', compact(
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
            'fishermanType',
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
            $request->validate([
                'review_flag'   => 'required|boolean',
                'decision_flag' => 'nullable|string|required_if:review_flag,1',
                'remarks'       => 'required|string',
                'fisherman_type'      => 'nullable|string',
            ]);

            $application = darat_application::with(['applicationType', 'user'])->findOrFail($id);
            $user = $application->user;

            $userDetails = $user->userDetail;

            $entity = $user->entityUser;

            $entityName = $entity->entity_name ?? 'Pejabat';

            $statusCode = match ([$request->input('review_flag'), $request->input('decision_flag')]) {
                ['1', '1'] => '808',
                ['1', '0'] => '807-2',
                ['0', null] => '807-1',
                default => throw new \Exception('Invalid semakan (review_flag) or keputusan (decision_flag)'),
            };


            $statusId = CodeMaster::where('type', 'application_status')
                ->where('code', $statusCode)
                ->value('id');

            $application->update([
                'application_status_id' => $statusId,
                'updated_by'            => auth()->id(),
                'updated_at'            => now(),
            ]);

            $temp = darat_application_temp::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'status'  => 'pending',

                ],
                [
                    'form_data'  => json_encode([]),
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );

            $data = json_decode($temp->form_data, true) ?? [];

            // Ensure the tab2_fisherman_info array exists
            if (!isset($data['tab2_fisherman_info']) || !is_array($data['tab2_fisherman_info'])) {
                $data['tab2_fisherman_info'] = [];
            }

            // Append or update a key within the array
            $data['tab2_fisherman_info']['fisherman_type_id'] = $request->fisherman_type;

            $temp->form_data = json_encode($data);
            $temp->updated_by = $user->id;
            $temp->save();

            darat_application_log::create([
                'application_id'        => $application->id,
                'application_status_id' => $statusId,
                'remarks'               => $request->remarks,
                'review_flag'           => $request->review_flag,
                'decision_flag'         => $request->decision_flag ?? null,
                'created_by'            => auth()->id(),
                'is_active'             => true,
            ]);

            $uniquePin = null;
            if ($request->decision_flag == '1') {
                $uniquePin = $this->generateUniquePin();
                darat_temporary_pin::create([
                    'application_id' => $application->id,
                    'pin_number'     => $uniquePin,
                    'expires_at'     => now()->addDays(7),
                    'created_by'     => auth()->id(),
                ]);
            }

            if ($request->review_flag == '1') {
                $resultMessage = match ($statusCode) {
                    '808' => 'PERMOHONAN ANDA TELAH DI LULUSKAN.',
                    '807-2' => 'PERMOHONAN TIDAK LULUS, SILA LAKUKAN RAYUAN.',
                    default => 'STATUS PERMOHONAN TIDAK DIKETAHUI.',
                };

                $resultDetails = [
                    'no_rujukan'       => $application->no_rujukan,
                    'applicant_icno'   => $userDetails->identity_card_number ?? $user->username,
                    'application_type' => $application->applicationType->name ?? 'Tidak Diketahui',
                    'generate_date'    => now()->format('d-m-Y'),
                    'ulasan'           => $resultMessage,
                    'pin_number'       => $uniquePin,
                    'applicant_name'   => $userDetails->name ?? $user->name ?? 'Pemohon',
                    'phone_number'     => $userDetails->phone_number ?? '-',
                    'address'          => $userDetails->address ?? '-',
                    'office_address'   => $entityName,
                ];

                try {
                    Mail::to($user->email)->send(new ApplicationResultNotification($resultDetails));
                } catch (\Exception $e) {
                    Log::error('Email sending failed: ' . $e->getMessage());
                }
            }

            DB::commit();

            return redirect()->route('kadPendaftaran.keputusan-08.index')
                ->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    private function generateUniquePin()
    {
        do {
            $pin = mt_rand(100000, 999999);
            $exists = darat_temporary_pin::where('pin_number', $pin)->exists();
        } while ($exists);

        return $pin;
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
