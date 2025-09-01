<?php

namespace App\Http\Controllers\NelayanDarat\gantiKulit;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\darat_application;
use App\Models\darat_item_found;
use App\Models\darat_user_equipment;
use App\Models\darat_vessel;
use App\Models\darat_vessel_inspection;
use App\Models\ProfileUsers;
use App\Models\darat_application_temp;
use App\Models\darat_application_log;
use App\Models\darat_base_jetties;
use App\Models\darat_document;
use App\Models\darat_equipment_list;
use App\Models\darat_user_fisherman_info;
use App\Models\darat_vessel_disposals;
use App\Models\darat_vessel_hull_history;
use App\Models\darat_vessel_hull;
use App\Models\darat_vessel_engine_history;
use App\Models\darat_vessel_engine;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class laporanLpiLupusController extends Controller
{

    protected $applicationTypeCode = '6';

    public function index()
    {
        $user     = Auth::user();
        $roleName = $user->roles()->pluck('name')->first();

        $positiveFeedback = ['615'];
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

        return view('app.NelayanDarat.gantiKulit.pegawai.20_laporanLpiLupus.index', compact(
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
        // Fetch the application along with its required relationships.
        $application = darat_application::findOrFail($id);

        $user     = $application->user;
        $roleName = Auth::user()->roles()->pluck('name')->first();

        $applicationType = CodeMaster::getApplicationTypeByCode($this->applicationTypeCode);

        // Get the segments of the URL path
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);

        // Combine the first two segments to create the URL path you want to compare with the slug
        $currentUrlPath = '/' . $segment1 . '/' . $segment2;

        // Fetch the row based on your condition (e.g., `url`)
        $moduleName = DB::table('modules')->where('url', $currentUrlPath)->first();

        // Fetch condition options and other lookups from CodeMaster.
        $jenisKeadaan   = CodeMaster::where('type', 'keadaan')->pluck('name', 'id');

        $jenisKulit     = CodeMaster::where('type', 'jenis_kulit')->pluck('name', 'id');

        $inspection = darat_vessel_inspection::where('user_id', $user->id)->where('is_active', false)->first();

        $foundEquipments = collect(); // default to empty collection

        if ($inspection) {
            $foundEquipments = darat_item_found::where('inspection_id', $inspection->id)->get();
        }

        // Get the user details
        $userDetail = ProfileUsers::where('user_id', $user->id)->where('is_active', 1)->first();

        // Fetch the types of fishing equipment (jenis_peralatan)
        $jenisPeralatan = darat_equipment_list::where('is_active', true)->pluck('name', 'name');

        // Retrieve the temporary application data (form data)
        // $temp = darat_application_temp::where('application_id', $application->id)
        //     ->where('status', 'pending')
        //     ->latest()
        //     ->first();

        // $formData = json_decode($temp->form_data ?? '{}', true);

        // Retrieve the specific data from the form_data
        // $fishermanInfo = $formData['tab2_fisherman_info'] ?? [];

        // $jettyInfo = $formData['tab3_jetty_info'] ?? null;

        // $equipmentList = $formData['tab4_equipment_info'] ?? [];

        // $dispose = $formData['tab7_disposal'] ?? [];

        // $mainEquipment = collect($formData['tab4_equipment_info'] ?? [])
        //     ->filter(fn($item) => is_array($item) && ($item['type'] ?? '') === 'main')
        //     ->values()
        //     ->all();

        // $additionalEquipments = collect($formData['tab4_equipment_info'] ?? [])
        //     ->filter(fn($item) => is_array($item) && ($item['type'] ?? '') === 'additional')
        //     ->values()
        //     ->all();

        // $vesselInfo = $formData['tab5_vessel_info'] ?? [];

        // $documents = $formData['tab6_document'] ?? [];

        // == Off Data ==
        $fishermanInfoOff = darat_user_fisherman_info::where('user_id', $user->id)->where('is_active', 1)->first();
        $aidAgencyOff = $user->fishermanInfo?->aidAgencies ?? collect();
        $jettyOff = darat_base_jetties::where('user_id', $user->id)->where('is_active', 1)->first();
        $equipmentOff = darat_user_equipment::where('user_id', $user->id)->where('is_active', 1)->get();
        $vessel = darat_vessel::where('user_id', $user->id)->where('is_active', 1)->first();
        // $documentOff = darat_document::where('user_id', $user->id)->where('application_type', $this->applicationTypeCode)->where('is_active', 1)->get();
        // $inspectionOff = darat_vessel_inspection::where('vessel_id', $vesselOff->id)->where('is_active', 1)->first();

        $vesselInfoOff = darat_vessel::with(['hull', 'engine'])
            ->where('user_id', $user->id)
            ->where('is_active', 1)
            ->first();

        $dispose = darat_vessel_disposals::where('application_id', $application->id)->first();

        return view('app.NelayanDarat.gantiKulit.pegawai.20_laporanLpiLupus.create', compact(
            'application',
            'user',

            'jenisPeralatan',
            'jenisKulit',
            'jenisKeadaan',

            'applicationType',
            'moduleName',
            'roleName',
            'inspection',

            'userDetail',
            // 'equipmentList',
            // 'mainEquipment',
            // 'additionalEquipments',
            // 'equipmentList',
            'foundEquipments',

            // == Off ==
            // 'fishermanInfoOff',
            // 'aidAgencyOff',
            // 'jettyOff',
            // 'equipmentOff',
            // 'vesselOff',
            // 'vesselInfoOff',
            // 'documentOff',
            'vessel',

            'dispose'
        ));
    }

 public function store_tab1(Request $request, $id)
{
    DB::beginTransaction();

    try {
        $application = darat_application::findOrFail($id);
        $user = $application->user;

        $request->validate([
            'disposal_date'        => 'required|date',
            'disposal_location'    => 'required|string|max:255',
            'disposal_method'      => 'required|in:BAKAR,POTONG,TANAM,TENGGELAM',
            'attendance_form'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'vessel_image_before'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'vessel_image_after'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // === Upload Logic ===
        $uploadedPaths = [];

        $filesToUpload = [
            'attendance_form'     => 'documents',
            'vessel_image_before' => 'images',
            'vessel_image_after'  => 'images',
        ];

        foreach ($filesToUpload as $inputName => $folder) {
            if ($request->hasFile($inputName) && $request->file($inputName)->isValid()) {
                $file = $request->file($inputName);
                $filename = time() . '_' . $file->getClientOriginalName();
                $uploadedPaths[$inputName] = $file->storeAs($folder, $filename, 'public');
            }
        }

        // === Update or Create ===
        darat_vessel_disposals::updateOrCreate(
            ['application_id' => $application->id],
            [
                'user_id'                => $user->id,
                'disposal_time'          => $request->disposal_date,
                'disposal_location'      => $request->disposal_location,
                'disposal_method'        => $request->disposal_method,
                'attendance_form_image'  => $uploadedPaths['attendance_form']     ?? null,
                'before_disposal_image'  => $uploadedPaths['vessel_image_before'] ?? null,
                'after_disposal_image'   => $uploadedPaths['vessel_image_after']  ?? null,
                'is_active'              => true,
                'is_approved'            => false,
                'created_by'             => $user->id,
                'updated_by'             => $user->id,
            ]
        );

        DB::commit();
        return back()->with('success', 'Berjaya disimpan.');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Ralat: ' . $e->getMessage());
    }
}



    public function store($id)
    {
        DB::beginTransaction();

        try {
            // Find the application by ID
            $application = darat_application::findOrFail($id);
            $user = $application->user;

            // Set the status code for the application
            $statusCode = 616;
            $statusId = CodeMaster::where('type', 'application_status')
                ->where('code', $statusCode)
                ->value('id');

            // Update the application status
            $application->update([
                'application_status_id' => $statusId,
                'updated_by' => auth()->id(),
            ]);

            // Log the action
            darat_application_log::create([
                'application_id' => $application->id,
                'application_status_id' => $statusId,
                'created_by' => auth()->id(),
                'is_active' => true,
            ]);

            $vessel = darat_vessel::where('user_id', $user->id)
                ->where('is_active', true)
                ->first();

            darat_vessel_inspection::updateOrCreate(
                ['application_id' => $application->id],
                [
                    'vessel_id'                   => $vessel?->id,
                    'is_active'                   => true,
                    'is_approved'                   => true,
                ]
            );

            DB::commit();

            return redirect()->route('gantiKulit.laporanLpiLupus-06.index')
                ->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function viewEquipmentFile(Request $request)
    {
        $applicationId = $request->query('application_id');
        $type = $request->query('type'); // 'main' or 'additional'
        $index = $request->query('index');

        if (!in_array($type, ['main', 'additional']) || !is_numeric($index)) {
            abort(400, 'Parameter tidak sah.');
        }

        $temp = darat_application_temp::where('application_id', $applicationId)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$temp) {
            abort(404, 'Permohonan tidak dijumpai.');
        }

        $formData = json_decode($temp->form_data, true);
        $equipmentList = collect($formData['tab4_equipment_info'] ?? [])
            ->filter(fn($item) => is_array($item) && isset($item['type']))
            ->values();

        // Filter by type (main or additional), then find the item by index
        $itemsOfType = $equipmentList->filter(fn($item) => $item['type'] === $type)->values();

        if (!isset($itemsOfType[$index])) {
            abort(404, 'Peralatan tidak dijumpai.');
        }

        $filePath = $itemsOfType[$index]['file_path'] ?? null;

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

    public function viewInspectionDocument(Request $request)
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
