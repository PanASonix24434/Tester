<?php

namespace App\Http\Controllers\NelayanDarat\lesenBaharu;

use App\Http\Controllers\Controller;
use App\Mail\ApplicationResultNotification;
use App\Models\CatchingLocation_nd;
use App\Models\CodeMaster;
use App\Models\darat_application;
use App\Models\darat_application_log;
use App\Models\darat_application_temp;
use App\Models\darat_base_jetties;
use App\Models\darat_base_jetty_history;
use App\Models\darat_document;
use App\Models\darat_equipment_list;
use App\Models\darat_fault_record;
use App\Models\darat_payment_receipt;
use App\Models\darat_temporary_pin;
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
use App\Models\Entity;
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

// use App\Mail\PemeriksaanLpiNotification;

class keputusanController extends Controller
{

    protected $applicationTypeCode = '1';

    public function index()
    {
        $user     = Auth::user();
        $roleName = $user->roles()->pluck('name')->first();

        $positiveFeedback = ['108','116'];
        $negativeFeedback = [''];
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
            ->whereHas('user', function ($query) use ($childEntityIds) {
                $query->whereIn('entity_id', $childEntityIds);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $applicationType = CodeMaster::getApplicationTypeByCode($this->applicationTypeCode);

        $segment1       = request()->segment(1);
        $segment2       = request()->segment(2);
        $currentUrlPath = '/' . $segment1 . '/' . $segment2;

        $moduleName = DB::table('modules')->where('url', $currentUrlPath)->first();

        return view('app.NelayanDarat.lesenBaharu.pegawai.7_keputusan.index', compact(
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

        // $fishermanInfo = $formData['tab2_fisherman_info'] ?? [];
        // $jettyInfo = $formData['tab3_jetty_info'] ?? null;
        $equipmentTemp = $formData['tab4_equipment_info'] ?? [];

        $vesselTemp = $formData['tab5_vessel_info'] ?? [];

        $documents = $formData['tab6_document'] ?? [];

        // $vesselOff = darat_vessel::where('user_id', $user->id)
        //     ->where('is_active', 1)
        //     ->first();

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

        $isStillValid = false;

        if ($inspectionOff && $inspectionOff->valid_date) {
            $isStillValid = Carbon::parse($inspectionOff->valid_date)->gte(Carbon::now());
        }

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

        $vessel = darat_vessel::where('user_id', $user->id)->latest()->first();

        $vesselHullEngine = User::with(['hull', 'engine'])->find($user->id);

        $hull = $vesselHullEngine->hull ?? null;

        $engine = $vesselHullEngine->engine ?? null;

        return view('app.NelayanDarat.lesenBaharu.pegawai.7_keputusan.create', compact(
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

            'isStillValid',
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

    public function store(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'review_flag'    => 'required|boolean',
                'decision_flag'  => 'nullable|string|required_if:review_flag,1',
                'remarks'        => 'required|string',
            ]);

            $application = darat_application::with(['applicationType', 'user'])->findOrFail($id);
            $user        = $application->user;
            $userDetails = $user->userDetail;
            $entityName  = $user->entityUser->entity_name ?? 'Pejabat';

            // Determine application status code
            $reviewFlag   = $request->input('review_flag');
            $decisionFlag = $request->input('decision_flag');

            $statusCode = match ([$reviewFlag, $decisionFlag]) {
                ['1', '1']     => '109',
                ['1', '0']     => '108-2',
                ['0', null]    => '108-1',
                default        => throw new \Exception('Kombinasi semakan dan keputusan tidak sah.'),
            };

            if ($application->is_appeal == true) {
                $statusCode = match ([$reviewFlag, $decisionFlag]) {
                    ['1', '1']     => '109',
                    ['1', '0']     => '116-2',
                    ['0', null]    => '116-1',
                    default        => throw new \Exception('Kombinasi semakan dan keputusan tidak sah.'),
                };
            }
 
            $statusId = CodeMaster::where('type', 'application_status')
                ->where('code', $statusCode)
                ->value('id');

            $application->update([
                'application_status_id' => $statusId,
                'updated_by'            => auth()->id(),
                'is_appeal'            => $statusCode == '108-2' ? true : false,
                'updated_at'            => now(),
            ]);

            darat_application_log::create([
                'application_id'        => $application->id,
                'application_status_id' => $statusId,
                'remarks'               => $request->remarks,
                'review_flag'           => $reviewFlag,
                'decision_flag'         => $decisionFlag ?? null,
                'created_by'            => auth()->id(),
                'is_active'             => true,
            ]);

            $uniquePin = null;

            if ($decisionFlag === '1') {
                $uniquePin = $this->generateUniquePin();
                darat_temporary_pin::create([
                    'application_id' => $application->id,
                    'pin_number'     => $uniquePin,
                    'expires_at'     => now()->addDays(7),
                    'created_by'     => auth()->id(),
                ]);
            }

            if ($reviewFlag === '1') {
                $resultMessage = match ($statusCode) {
                    '109' => 'PERMOHONAN ANDA TELAH DI LULUSKAN.',
                    '108-2' => 'PERMOHONAN TIDAK LULUS, SILA LAKUKAN RAYUAN.',
                    default => 'STATUS PERMOHONAN TIDAK DIKETAHUI.',
                };

                if ($application->is_appeal == true) {
                    $resultMessage = match ($statusCode) {
                        '109' => 'PERMOHONAN ANDA TELAH DI LULUSKAN.',
                        '116-2' => 'PERMOHONAN TIDAK LULUS, SILA LAKUKAN RAYUAN.',
                        default => 'STATUS PERMOHONAN TIDAK DIKETAHUI.',
                    };
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

            return redirect()->route('lesenBaharu.keputusan-01.index')
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
