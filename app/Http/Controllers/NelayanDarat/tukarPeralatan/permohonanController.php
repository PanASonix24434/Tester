<?php

namespace App\Http\Controllers\NelayanDarat\tukarPeralatan;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\darat_application;
use App\Models\darat_application_log;
use App\Models\darat_base_jetties;
use App\Models\darat_document;
use App\Models\darat_equipment_set;
use App\Models\darat_user_detail;
use App\Models\darat_user_equipment;
use App\Models\darat_user_fisherman_info;
use App\Models\darat_vessel;
use App\Models\darat_vessel_engine;
use App\Models\darat_vessel_hull;
use App\Models\User;
use App\Models\darat_equipment_list;
use App\Models\darat_application_temp;
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingInfo;
use App\Models\NelayanDarat\Jetty;
use App\Models\NelayanDarat\River;
use App\Models\NelayanDaratModels\darat_vessel_inspection;
use App\Models\ProfileUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class permohonanController extends Controller
{
    protected $applicationTypeCode = '4';

    public function index()
    {

        $userId = auth()->id();

        $applicationTypeId = CodeMaster::where('type', 'application_type')
            ->where('code', $this->applicationTypeCode)
            ->value('id');

        $applications = darat_application::with(['applicationType', 'applicationStatus', 'user', 'fetchPin'])
            ->where('application_type_id', $applicationTypeId)
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $negativeFeedback = ['0'];

        $draftFeedback = ['0'];

        $appealFeedback = ['0']; // Get the results

        $user = Auth::user();

        $roleName = $user->roles()->pluck('name')->first();

        $applicationType = CodeMaster::getApplicationTypeByCode($this->applicationTypeCode);

        $roleName = $user->roles()->pluck('name')->first();

        // Get the segments of the URL path
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);

        // Combine the first two segments to create the URL path you want to compare with the slug
        $currentUrlPath = '/' . $segment1 . '/' . $segment2;

        // Fetch the row based on your condition (e.g., `url`)
        $moduleName = DB::table('modules')->where('url', $currentUrlPath)->first();

        // Return the view with the necessary data
        return view('app.NelayanDarat.tukarPeralatan.pemohon.index', compact('applications', 'draftFeedback', 'negativeFeedback', 'appealFeedback', 'applicationType', 'moduleName', 'roleName'));
    }

    public function create()
    {
        $user = Auth::user();

        $roleName = $user->roles()->pluck('name')->first();

        $applicationTypeCode = $this->applicationTypeCode;
        $applicationType = CodeMaster::getApplicationTypeByCode($applicationTypeCode);
        $applicationTypeId = CodeMaster::where('code', $applicationTypeCode)->value('id');
        $engineBrand = CodeMaster::where('type', 'engine_brand')->pluck('name', 'id');

        $currentUrlPath = '/' . request()->segment(1) . '/' . request()->segment(2);
        $moduleName = DB::table('modules')->where('url', $currentUrlPath)->first();

        $states        = CodeMaster::where('type', 'state')->pluck('name', 'id');
        $districts     = CodeMaster::where('type', 'district')->pluck('name', 'id');
        $hullTypes     = CodeMaster::where('type', 'jenis_kulit')->pluck('name', 'id');
        $jetties       = Jetty::where('is_active', true)->pluck('name', 'id');
        $rivers        = River::where('is_active', true)->pluck('name', 'id');
        $engineBrandList = CodeMaster::where('type', 'engine_brand')->pluck('name', 'id');
        $equipmentList = darat_equipment_list::where('is_active', true)->pluck('name', 'id');

        $userDetail = ProfileUsers::where('user_id', $user->id)->where('is_active', 1)->first();
        $fishermanDetail = darat_user_fisherman_info::where('user_id', $user->id)->where('is_active', 1)->first();
        $baseDetail = darat_base_jetties::with(['state', 'district', 'jetty', 'river'])->where('user_id', $user->id)->where('is_active', 1)->latest()->first();

        $equipmentDetail = darat_user_equipment::where('user_id', $user->id)->where('is_active', 1)->get();

        $equipmentDetailMain = $equipmentDetail->where('type', 'UTAMA');
        $equipmentDetailAdditional = $equipmentDetail->where('type', 'TAMBAHAN');

        $equipmentGroupLatest = darat_user_equipment::where('user_id', $user->id)
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc') // get newest records first
            ->get()
            ->groupBy('application_id')
            ->first(); // take only the latest application_id group

        $equipmentAllGroup = darat_user_equipment::where('user_id', $user->id)
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc') // latest records appear first within each group
            ->get()
            ->groupBy('application_id');

        $userWithFisherman = $user->load('fishermanInfo.aidAgencies');
        $aidAgencies = $userWithFisherman->fishermanInfo?->aidAgencies ?? collect();

        $temp = darat_application_temp::where('user_id', $user->id)
            ->where('status', 'draft')
            ->latest()
            ->first();

        $vessel = darat_vessel::where('user_id', $user->id)->latest()->first();

        $vesselHullEngine = User::with(['hull', 'engine'])->find($user->id);
        $hull = $vesselHullEngine->hull ?? null;
        $engine = $vesselHullEngine->engine ?? null;

        $formData = json_decode($temp->form_data ?? '{}', true);

        $equipmentData     = $formData['tab4_equipment_info'] ?? [];
        $vesselData        = $formData['tab5_vessel_info'] ?? [];
        $documentsData         = $formData['tab6_document'] ?? [];
        $agencyData            = $formData['financial_aid_agencyData'] ?? [];

        $mainEquipment = collect($equipmentData)
            ->where('type', 'UTAMA')
            ->values()
            ->all();

        $additionalEquipments = collect($equipmentData)
            ->where('type', 'TAMBAHAN')
            ->values()
            ->all();

        return view('app.NelayanDarat.tukarPeralatan.pemohon.create', compact(
            'user',
            'roleName',
            'applicationType',
            'applicationTypeId',
            'moduleName',
            'userDetail',
            'equipmentList',
            'states',
            'districts',
            'jetties',
            'rivers',

            'aidAgencies',
            'hullTypes',

            // LATEST
            'fishermanDetail',
            'baseDetail',
            'equipmentDetail',
            'equipmentDetailMain',
            'equipmentDetailAdditional',
            'equipmentData',
            'mainEquipment',
            'additionalEquipments',
            'engineBrandList',
            'vesselData',
            'documentsData',
            'equipmentAllGroup',
            'equipmentGroupLatest',
            'vesselHullEngine',
            'engine',
            'hull',
            'vessel'

        ));
    }

    public function negativeFeedback($id)
    {

        $application = darat_application::findOrFail($id);

        $user = $application->user;

        $roleName = $user->roles()->pluck('name')->first();

        $applicationType = CodeMaster::getApplicationTypeByCode($this->applicationTypeCode);

        // Get the segments of the URL path
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);

        // Combine the first two segments to create the URL path you want to compare with the slug
        $currentUrlPath = '/' . $segment1 . '/' . $segment2;

        // Fetch the row based on your condition (e.g., `url`)
        $moduleName = DB::table('modules')->where('url', $currentUrlPath)->first();

        // Fetch documents for the authenticated user
        $applicationTypeId = CodeMaster::where('code', $this->applicationTypeCode)
            ->value('id');

        $transportations = CodeMaster::where('type', 'transportation')->pluck('name', 'id');

        $hullTypes = CodeMaster::where('type', 'jenis_kulit')->pluck('name', 'id');

        $userDetail = darat_user_detail::where('user_id', $user->id)
            ->where('is_active', '1')
            ->first();

        $fishermanInfo = darat_user_fisherman_info::where('user_id', $user->id)
            ->where('is_active', '1')
            ->first();

        $jettyInfo = darat_base_jetties::where('user_id', $user->id)
            ->where('is_active', '0')
            ->first();

        $equipmentSet         = darat_equipment_set::where('user_id', $user->id)->first();
        $mainEquipment        = darat_user_equipment::where('equipment_set_id', $equipmentSet->id ?? null)->where('type', 'Utama')->first();
        $additionalEquipments = darat_user_equipment::where('equipment_set_id', $equipmentSet->id ?? null)->where('type', 'Tambahan')->get();

        $vessel = darat_vessel::where('user_id', $user->id)->latest()->first();

        $hull = $vessel ? $vessel->hull()->latest()->first() : null;

        $engine = $vessel ? $vessel->engine()->latest()->first() : null;

        $documents = darat_document::where('user_id', $user->id)
            ->where('application_type', $this->applicationTypeCode)
            ->whereNull('deleted_at')
            ->get();

        $applicationLogs = darat_application_log::with(['applicationStatus', 'creator'])
            ->where('application_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        $logStatusCode = CodeMaster::where('type', 'application_status')
            ->where('code', 813)
            ->value('id');

        $applicationLogs = darat_application_log::with(['applicationStatus', 'creator'])
            ->where('application_id', $id)
            ->where('application_status_id', $logStatusCode)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('app.NelayanDarat.tukarPeralatan.pemohon.incomplete', compact(
            'user',
            'applicationType',
            'application',
            'moduleName',
            'documents',
            'roleName',
            'transportations',
            'hullTypes',
            'userDetail',
            'fishermanInfo',
            'jettyInfo',
            'equipmentSet',
            'mainEquipment',
            'additionalEquipments',
            'vessel',
            'hull',
            'engine',
            'applicationLogs'
        ));
    }

    public function appealFeedback($id)
    {

        $application = darat_application::findOrFail($id);

        $user = $application->user;

        $roleName = $user->roles()->pluck('name')->first();

        $applicationType = CodeMaster::getApplicationTypeByCode($this->applicationTypeCode);

        // Get the segments of the URL path
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);

        // Combine the first two segments to create the URL path you want to compare with the slug
        $currentUrlPath = '/' . $segment1 . '/' . $segment2;

        // Fetch the row based on your condition (e.g., `url`)
        $moduleName = DB::table('modules')->where('url', $currentUrlPath)->first();

        // Fetch documents for the authenticated user
        $applicationTypeId = CodeMaster::where('code', $this->applicationTypeCode)
            ->value('id');

        $transportations = CodeMaster::where('type', 'transportation')->pluck('name', 'id');

        $hullTypes = CodeMaster::where('type', 'jenis_kulit')->pluck('name', 'id');

        $userDetail = darat_user_detail::where('user_id', $user->id)
            ->where('is_active', '1')
            ->first();

        $fishermanInfo = darat_user_fisherman_info::where('user_id', $user->id)
            ->where('is_active', '1')
            ->first();

        $jettyInfo = darat_base_jetties::where('user_id', $user->id)
            ->where('is_active', '0')
            ->first();

        $equipmentSet         = darat_equipment_set::where('user_id', $user->id)->first();
        $mainEquipment        = darat_user_equipment::where('equipment_set_id', $equipmentSet->id ?? null)->where('type', 'Utama')->first();
        $additionalEquipments = darat_user_equipment::where('equipment_set_id', $equipmentSet->id ?? null)->where('type', 'Tambahan')->get();

        $vessel = darat_vessel::where('user_id', $user->id)->latest()->first();

        $hull = $vessel ? $vessel->hull()->latest()->first() : null;

        $engine = $vessel ? $vessel->engine()->latest()->first() : null;

        $documents = darat_document::where('user_id', $user->id)
            ->where('application_type', $this->applicationTypeCode)
            ->whereNull('deleted_at')
            ->get();

        $applicationLogs = darat_application_log::with(['applicationStatus', 'creator'])
            ->where('application_id', $id)
            ->orderBy('created_at', 'asc')
            ->get();

        $logStatusCode = CodeMaster::where('type', 'application_status')
            ->where('code', 815)
            ->value('id');

        $applicationLogs = darat_application_log::with(['applicationStatus', 'creator'])
            ->where('application_id', $id)
            ->where('application_status_id', $logStatusCode)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('app.NelayanDarat.tukarPeralatan.pemohon.incomplete', compact(
            'user',
            'applicationType',
            'application',
            'moduleName',
            'documents',
            'roleName',
            'transportations',
            'hullTypes',
            'userDetail',
            'fishermanInfo',
            'jettyInfo',
            'equipmentSet',
            'mainEquipment',
            'additionalEquipments',
            'vessel',
            'hull',
            'engine',
            'applicationLogs'
        ));
    }

    public function storeAppeal(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'user_statement' => 'required|string|max:1000',
            ]);

            $statusId = CodeMaster::where('type', 'application_status')
                ->where('code', '801')
                ->value('id');

            $application = darat_application::where('user_id', auth()->id())
                ->latest()
                ->firstOrFail();

            $application->update([
                'application_status_id' => $statusId,
                'is_appeal'             => true,
                'updated_by'            => auth()->id(),
            ]);

            darat_application_log::create([
                'application_id'        => $application->id,
                'application_status_id' => $statusId,
                'remarks'               => $request->user_statement,
                'created_by'            => auth()->id(),
                'is_active'             => true,
            ]);

            DB::commit();

            return redirect()->route('tukarPeralatan.permohonan-04.index')
                ->with('success', 'Kenyataan rayuan berjaya dihantar.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function store_tab4(Request $request)
    {

        DB::beginTransaction();
        $userId = auth()->id();

        try {
            // Validation rules
            $request->validate([
                // Main equipment validation (expects array with one item)
                'main' => 'nullable|array',
                'main.*.name' => 'nullable|string|max:255',
                'main.*.quantity' => 'nullable|integer|min:1',
                'main.*.file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:5120',

                // Additional equipment validation (up to 5 items)
                'additional' => 'nullable|array|max:5',
                'additional.*.name' => 'nullable|string|max:255',
                'additional.*.quantity' => 'nullable|integer|min:1|required_if:additional.*.name,!=,',
                'additional.*.file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:5120|required_if:additional.*.name,!=,',
            ]);

            // Retrieve or create draft temporary data
            $temp = darat_application_temp::firstOrCreate(
                ['user_id' => $userId, 'status' => 'draft'],
                ['form_data' => json_encode([]), 'created_by' => $userId, 'updated_by' => $userId]
            );

            $data = json_decode($temp->form_data ?? '{}', true);
            $existingEquipment = $data['tab4_equipment_info'] ?? [];
            $equipment = [];

            // MAIN
            foreach ($request->input('main', []) as $index => $item) {
                if (!empty($item['name']) && !empty($item['quantity'])) {
                    $existing = collect($existingEquipment)->firstWhere(
                        fn($old) => ($old['type'] === 'UTAMA' || $old['type'] === 'main') && $old['name'] === $item['name']
                    );

                    $entry = [
                        'name'     => $item['name'],
                        'quantity' => $item['quantity'] ?? $existing['quantity'] ?? 1,
                        'type'     => 'UTAMA',
                        'file_path'     => $existing['file_path'] ?? null,
                        'original_name' => $existing['original_name'] ?? null,
                        'uploaded_at'   => $existing['uploaded_at'] ?? null,
                    ];

                    if ($request->hasFile("main.{$index}.file")) {
                        $file = $request->file("main.{$index}.file");
                        $original = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $ext = $file->getClientOriginalExtension();
                        $timestamp = now()->format('Ymd_His');
                        $finalName = $original . '_' . $timestamp . '.' . $ext;

                        $entry['file_path']     = $file->storeAs('equipment', $finalName, 'public');
                        $entry['original_name'] = $finalName;
                        $entry['uploaded_at']   = now()->toDateTimeString();
                    }

                    $equipment[] = $entry;
                }
            }

            foreach ($request->input('additional', []) as $index => $item) {
                if (!empty($item['name']) && !empty($item['quantity'])) {
                    $existing = collect($existingEquipment)->firstWhere(
                        fn($old) => ($old['type'] === 'TAMBAHAN' || $old['type'] === 'additional') && $old['name'] === $item['name']
                    );

                    $entry = [
                        'name'     => $item['name'],
                        'quantity' => $item['quantity'] ?? $existing['quantity'] ?? 1,
                        'type'     => 'TAMBAHAN',
                        'file_path'     => $existing['file_path'] ?? null,
                        'original_name' => $existing['original_name'] ?? null,
                        'uploaded_at'   => $existing['uploaded_at'] ?? null,
                    ];

                    if ($request->hasFile("additional.{$index}.file")) {
                        $file = $request->file("additional.{$index}.file");
                        $original = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                        $ext = $file->getClientOriginalExtension();
                        $timestamp = now()->format('Ymd_His');
                        $finalName = $original . '_' . $timestamp . '.' . $ext;

                        $entry['file_path']     = $file->storeAs('equipment', $finalName, 'public');
                        $entry['original_name'] = $finalName;
                        $entry['uploaded_at']   = now()->toDateTimeString();
                    }

                    $equipment[] = $entry;
                }
            }

            if (!empty($equipment)) {
                $data['tab4_equipment_info'] = $equipment;
                $temp->form_data = json_encode($data);
                $temp->updated_by = $userId;
                $temp->save();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function store_tab6(Request $request)
    {

        DB::beginTransaction();

        try {
            $request->validate([
                'additional_documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'additional_titles.*'    => 'nullable|string|max:255',
                'hidden_field'           => 'nullable|in:1',
            ]);

            $userId = auth()->id();
            $status = ($request->hidden_field == 1) ? 'pending' : 'draft';

            $temp = darat_application_temp::firstOrCreate(
                ['user_id' => $userId, 'status' => $status],
                ['form_data' => json_encode([]), 'created_by' => $userId, 'updated_by' => $userId]
            );

            $data = json_decode($temp->form_data, true) ?? [];
            $documents = $data['tab6_document'] ?? [];

            $titles = $request->input('additional_titles', []);
            $files  = $request->file('additional_documents', []);

            foreach ($titles as $index => $title) {
                $file = $files[$index] ?? null;

                if (empty($title) && !$file) {
                    continue;
                }

                if (!empty($title) && $file && $file->isValid()) {
                    $path = $file->store('documents', 'public');

                    // Check if title already exists
                    $existingIndex = collect($documents)->search(function ($doc) use ($title) {
                        return $doc['title'] === $title && $doc['type'] === 'additional';
                    });

                    if ($existingIndex !== false) {
                        // Update the existing entry
                        $documents[$existingIndex]['file_path'] = $path;
                    } else {
                        // Add new document
                        $documents[] = [
                            'application_type' => $this->applicationTypeCode,
                            'title'            => $title,
                            'file_path'        => $path,
                            'type'             => 'additional',
                        ];
                    }
                }
            }

            $data['tab6_document'] = $documents;

            $temp->form_data  = json_encode($data);
            $temp->updated_by = $userId;
            $temp->save();

            DB::commit();

            return redirect()->back()->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'user_statement' => 'nullable|string|max:1000',

            ]);

            $statusId = CodeMaster::where('type', 'application_status')
                ->where('code', '401')
                ->value('id');

            if ($request->filled('user_statement')) {
                $application = darat_application::where('user_id', auth()->id())
                    ->latest()
                    ->firstOrFail();

                $application->update([
                    'application_status_id' => $statusId,
                    'updated_by'            => auth()->id(),
                ]);

                darat_application_log::create([
                    'application_id'        => $application->id,
                    'application_status_id' => $statusId,
                    'remarks'               => $request->user_statement,
                    'created_by'            => auth()->id(),
                    'is_active'             => true,
                ]);

                DB::commit();
                return redirect()->route('tukarPeralatan.permohonan-04.index')
                    ->with('success', 'Berjaya dihantar.');
            }

            $applicationTypeId = CodeMaster::where('type', 'application_type')
                ->where('code', $this->applicationTypeCode)
                ->value('id');

            do {
                $noRujukan = strtoupper(Str::random(6));
            } while (darat_application::where('no_rujukan', $noRujukan)->exists());

            $application = darat_application::create([
                'user_id'               => auth()->id(),
                'application_type_id'   => $applicationTypeId,
                'application_status_id' => $statusId,
                'no_rujukan'            => $noRujukan,
                'is_approved'           => false,
                'is_active'             => true,
                'created_by'            => auth()->id(),
                'updated_by'            => auth()->id(),
            ]);

            darat_application_temp::where('user_id', auth()->id())
                ->where('status',  'draft')
                ->latest()
                ->update([
                    'application_id' => $application->id,
                    'status'               =>  'pending',
                    'updated_by'           => auth()->id(),
                ]);

            darat_application_log::create([
                'application_id'        => $application->id,
                'application_status_id' => $statusId,
                'created_by'            => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('tukarPeralatan.permohonan-04.index')
                ->with('success', 'Berjaya dihantar.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function viewFile($id)
    {
        $file = darat_document::findOrFail($id);

        // Build the full path to the file
        $path = storage_path('app/public/' . $file->path);

        // Return a response that displays the file
        return response()->file($path);
    }

    public function viewOffEquipment(Request $request)
    {
        $equipmentId = $request->query('equipment_id');

        if (!$equipmentId) {
            abort(400, 'Perlatan Tidak Dijumpai.');
        }

        $equipment = darat_user_equipment::where('id', $equipmentId)
            ->where('is_active', true)
            ->first();

        if (!$equipment) {
            abort(404, 'Peralatan tidak dijumpai.');
        }

        $filePath = $equipment->file_path ?? null;

        if (!$filePath) {
            abort(404, 'Tiada fail tersedia.');
        }

        $fullPath = storage_path('app/public/' . ltrim($filePath, '/'));

        if (!file_exists($fullPath)) {
            abort(404, 'Fail tidak dijumpai dalam storan.');
        }

        return response()->file($fullPath, [
            'Content-Type' => mime_content_type($fullPath),
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"',
        ]);
    }

    public function viewTempEquipment(Request $request)
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
}
