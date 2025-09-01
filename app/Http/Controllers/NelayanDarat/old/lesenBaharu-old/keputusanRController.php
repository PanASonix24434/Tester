<?php
namespace App\Http\Controllers\NelayanDarat\lesenBaharu;



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

class keputusanRController extends Controller
{

    protected $applicationTypeCode = '1';

    public function index()
{
    $user     = Auth::user();
    $roleName = $user->roles()->pluck('name')->first();

    $positiveFeedback = ['917'];
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

    return view('app.NelayanDarat.lesenBaharu.pegawai.10_keputusan.index', compact(
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

        $user_detail = ProfileUsers::where('user_id', $user->id)->first();
        if (! $user_detail) {
            return redirect()->back()->with('error', 'Maklumat pengguna tidak dijumpai.');
        }

        $jetty = darat_base_jetties::where('user_id', $user->id)
            ->where('is_active', false)
            ->latest()
            ->first();

        $jettyHistory = [];
        if ($jetty) {
            $jettyHistory = darat_base_jetty_history::with('creator')
                ->where('jetty_id', $jetty->id)
                ->latest()
                ->get();
        }

        $equipments = darat_user_equipment::where('user_id', $user->id)
            ->where('is_active', true)
            ->get();

        $equipmentHistory = [];
        if ($equipments->isNotEmpty()) {
            $equipmentIds     = $equipments->pluck('id')->toArray();
            $equipmentHistory = darat_user_equipment_history::whereIn('equipment_id', $equipmentIds)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        $vessel = darat_vessel::where('user_id', $user->id)
            ->where('is_active', true)
            ->first();

        $hull          = null;
        $engine        = null;
        $vesselHistory = $hullHistory = $engineHistory = [];

        if ($vessel && $vessel->id) {
            $hull   = $vessel->hull;
            $engine = $vessel->engine;

            $vesselHistory = darat_vessel_history::where('vessel_id', $vessel->id)
                ->with('creator')
                ->latest()
                ->get();

            $hullHistory = darat_vessel_hull_history::where('vessel_hull_id', $vessel->id)
                ->with('creator')
                ->latest()
                ->get();

            $engineHistory = darat_vessel_engine_history::where('vessel_engine_id', $vessel->id)
                ->with('creator')
                ->latest()
                ->get();
        }

        $documents = darat_document::where('user_id', $user->id)
        ->where('is_active', true)
        ->where('application_type', $this->applicationTypeCode)
        ->latest()
        ->get();

        $fishermanInfo = darat_user_fisherman_info::where('user_id', $user->id)->first();

        $inspections = [];
        if ($vessel) {
            $inspections = darat_vessel_inspection::where('vessel_id', $vessel->id)
                ->latest()
                ->get();
        }

        $faultRecord = darat_fault_record::where('user_id', $user->id)
            ->where('is_active', true)
            ->orderBy('fault_date', 'desc')
            ->get();

        $applicationLogs = darat_application_log::with(['applicationStatus', 'creator'])
            ->where('application_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('app.NelayanDarat.lesenBaharu.pegawai.10_keputusan.create', compact(
            'application',
            'user',
            'vessel',
            'hull',
            'engine',
            'applicationLogs',
            'documents',
            'roleName',
            'applicationType',
            'moduleName',
            'jetty',
            'jettyHistory',
            'user_detail',
            'equipments',
            'equipmentHistory',
            'vesselHistory',
            'hullHistory',
            'engineHistory',
            'fishermanInfo',
            'inspections',
            'faultRecord'
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
        ]);

        $application = darat_application::with(['applicationType', 'user'])->findOrFail($id);
        $user = $application->user;

        $userDetails = $user->userDetail;

        $entity = $user->entityUser;
        $entityName = $entity->entity_name ?? 'Pejabat';

        $statusCode = match ([$request->input('review_flag'), $request->input('decision_flag')]) {
            ['1', '1'] => 920,
            ['1', '0'] => 916,
            ['0', null] => 918,
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
                920 => 'PERMOHONAN ANDA TELAH DI LULUSKAN.',
                919 => 'PERMOHONAN TIDAK LULUS, SILA LAKUKAN RAYUAN.',
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

        return redirect()->route('lesenBaharu.keputusanR-09.index')
            ->with('success', 'Maklumat keputusan berjaya disimpan.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
    }
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

    private function generateUniquePin()
    {
        do {
            $pin = mt_rand(100000, 999999);
            $exists = darat_temporary_pin::where('pin_number', $pin)->exists();
        } while ($exists);

        return $pin;
    }

}
