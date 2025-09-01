<?php
namespace App\Http\Controllers\NelayanDarat\baharuKadNelayan;

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
use App\Models\darat_vessel_engine_history;
use App\Models\darat_vessel_history;
use App\Models\darat_vessel_hull_history;
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
use App\Models\darat_equipment_list;
use App\Models\darat_payment_receipt;
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingInfo;
use Carbon\Carbon;

class keputusanRController extends Controller
{

    protected $applicationTypeCode = '9';

    public function index()
{
    $user     = Auth::user();
    $roleName = $user->roles()->pluck('name')->first();

    $positiveFeedback = ['911'];
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

    return view('app.NelayanDarat.baharuKadNelayan.pegawai.10_keputusan.index', compact(
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

        // $temp = darat_application_temp::where('application_id', $application->id)
        //     ->where('status', 'pending')
        //     ->latest()
        //     ->first();

        // $formData = json_decode($temp->form_data ?? '{}', true);

        // $fishermanInfo = $formData['tab2_fisherman_info'] ?? [];
        // $jettyInfo = $formData['tab3_jetty_info'] ?? null;
        // $equipmentList = $formData['tab4_equipment_info'] ?? [];

        // $vesselInfo = $formData['tab5_vessel_info'] ?? [];

        // $documents = $formData['tab6_document'] ?? [];

        // $vesselOff = darat_vessel::where('user_id', $user->id)
        //     ->where('is_active', 1)
        //     ->first();

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

        return view('app.NelayanDarat.baharuKadNelayan.pegawai.10_keputusan.create', compact(
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
            // 'documents',
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
            'vessel'

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
                ['1', '1']     => '905',
                ['1', '0']     => '911-2',
                ['0', null]    => '911-1',
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
                    '905' => 'PERMOHONAN ANDA TELAH DI LULUSKAN.',
                    '911-2' => 'PERMOHONAN TIDAK LULUS, SILA LAKUKAN RAYUAN.',
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

            return redirect()->route('baharuKadNelayan.keputusanR-09.index')
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
    public function viewDocument($id)
    {
        $document = darat_document::findOrFail($id);
        $path     = storage_path('app/public/' . $document->file_path);

        if (! file_exists($path)) {
            abort(404, 'Dokumen tidak dijumpai.');
        }

        return response()->file($path);
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

    public function viewFile($id)
    {
        $file = darat_document::findOrFail($id);

        // Build the full path to the file
        $path = storage_path('app/public/' . $file->path);

        // Return a response that displays the file
        return response()->file($path);
    }

}
