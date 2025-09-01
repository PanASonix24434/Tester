<?php

namespace App\Http\Controllers\NelayanDarat\tukarEnjin;

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
use App\Models\darat_temporary_pin;
use App\Models\ProfileUsers;
use App\Models\darat_payment_receipt;
use App\Models\User;
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
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingInfo;
use App\Models\SalesRecord_nd;
 use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

// use App\Mail\PemeriksaanLpiNotification;

class keputusanController extends Controller
{

    protected $applicationTypeCode = '5';

    public function index()
    {
        $user     = Auth::user();
        $roleName = $user->roles()->pluck('name')->first();

        $positiveFeedback = ['505'];
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

        return view('app.NelayanDarat.tukarEnjin.pegawai.4_keputusan.index', compact(
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

        return view('app.NelayanDarat.tukarEnjin.pegawai.4_keputusan.create', compact(
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
                ['1', '1']     => 508,
                ['1', '0']     => 507,
                ['0', null]    => 506,
                default        => throw new \Exception('Kombinasi semakan dan keputusan tidak sah.'),
            };

            $statusId = CodeMaster::where('type', 'application_status')
                ->where('code', $statusCode)
                ->value('id');

            $application->update([
                'application_status_id' => $statusId,
                'updated_by'            => auth()->id(),
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
                    508 => 'PERMOHONAN ANDA TELAH DI LULUSKAN.',
                    507 => 'PERMOHONAN TIDAK LULUS, SILA LAKUKAN RAYUAN.',
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

            return redirect()->route('tukarEnjin.keputusan-05.index')
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

    public function viewFaultDocument(Request $request)
    {
        $applicationId = $request->query('application_id');

        $application = darat_application::findOrFail($applicationId);

        $userId = $application->user_id;

        $record = darat_fault_record::where('user_id', $userId)
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

    public function viewInspectionDocument($id, $field)
    {
        $inspection = darat_vessel_inspection::findOrFail($id);

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
    public function viewEquipmentFile(Request $request)
    {
        $index = (int) $request->query('index');
        $applicationId = $request->query('application_id');

        // Get draft application by application_id
        $temp = darat_application_temp::where('application_id', $applicationId)->first();

        // Decode form data and retrieve equipment list
        $formData = json_decode($temp->form_data ?? '{}', true);

        $equipmentList = collect($formData['tab4_equipment_info'] ?? [])
            ->filter(fn($item) => is_array($item))
            ->values();

        // Get equipment item at index
        $item = $equipmentList[$index] ?? null;

        if (!$item || empty($item['file_path'])) {
            abort(404, 'Fail tidak ditemui.');
        }

        $filePath = $item['file_path'];
        $fullPath = storage_path('app/public/' . $filePath);

        if (!file_exists($fullPath)) {
            abort(404, 'Fail tidak wujud di pelayan.');
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
}
