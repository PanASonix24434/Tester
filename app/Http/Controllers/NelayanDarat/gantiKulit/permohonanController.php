<?php

namespace App\Http\Controllers\NelayanDarat\gantiKulit;

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
use App\Models\NelayanDarat\Jetty;
use App\Models\NelayanDarat\River;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\darat_base_jetty_history;
use App\Models\darat_vessel_disposals;
use App\Models\NelayanDarat\state_office_mapping;
use App\Models\ProfileUsers;

class permohonanController extends Controller
{
    protected $applicationTypeCode = '6';

    public function index(Request $request)
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
        return view('app.NelayanDarat.gantiKulit.pemohon.index', compact('applications', 'draftFeedback', 'negativeFeedback', 'appealFeedback', 'applicationType', 'moduleName', 'roleName'));
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

        $vessel = darat_vessel::where('user_id', $user->id)->latest()->first();

        $vesselHullEngine = User::with(['hull', 'engine'])->find($user->id);
        $hull = $vesselHullEngine->hull ?? null;
        $engine = $vesselHullEngine->engine ?? null;

        $temp = darat_application_temp::where('user_id', $user->id)
            ->where('status', 'draft')
            ->latest()
            ->first();

        $formTemp = json_decode($temp->form_data ?? '{}', true);

        $documentsTemp       = $formTemp['tab6_document'] ?? [];

        $disposeTemp = $formTemp['temp_disposal_info'] ?? [];

        return view('app.NelayanDarat.gantiKulit.pemohon.create', compact(
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

            'fishermanDetail',
            'baseDetail',
            'equipmentDetail',
            'equipmentDetailMain',
            'equipmentDetailAdditional',

            'engineBrandList',

            'documentsTemp',
            'equipmentAllGroup',
            'equipmentGroupLatest',
            'vesselHullEngine',
            'engine',
            'hull',
            'vessel',

            'disposeTemp'
        ));
    }

    public function create2()
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

        $vessel = darat_vessel::where('user_id', $user->id)->latest()->first();

        $vesselHullEngine = User::with(['hull', 'engine'])->find($user->id);
        $hull = $vesselHullEngine->hull ?? null;
        $engine = $vesselHullEngine->engine ?? null;

        $temp = darat_application_temp::where('user_id', $user->id)
            ->where('status', 'draft')
            ->latest()
            ->first();

        $formTemp = json_decode($temp->form_data ?? '{}', true);

        $documentsTemp       = $formTemp['tab6_document'] ?? [];

        $disposeTemp = $formTemp['temp_disposal_info'] ?? [];

        return view('app.NelayanDarat.gantiKulit.pemohon.create2', compact(
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
            // 'equipmentData',
            // 'mainEquipment',
            // 'additionalEquipments',
            'engineBrandList',
            'vesselTemp',
            'documentsTemp',
            'equipmentAllGroup',
            'equipmentGroupLatest',
            'vesselHullEngine',
            'engine',
            'hull',
            'vessel',

            'disposeTemp'
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

        return view('app.NelayanDarat.gantiKulit.pemohon.incomplete', compact(
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

        return view('app.NelayanDarat.gantiKulit.pemohon.incomplete', compact(
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

            return redirect()->route('gantiKulit.permohonan-06.index')
                ->with('success', 'Kenyataan rayuan berjaya dihantar.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function store_tab6(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate input
            $request->validate([
                'jenisPermohonan' => 'required|string',
                'vesselOld'       => 'required_if:jenisPermohonan,lupus,gantikulit|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'vesselNew'       => 'required_if:jenisPermohonan,gantikulit|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ], [
                'required'     => 'Sila isi ruangan yang diperlukan dan bertanda (*).',
                'required_if'  => 'Sila isi ruangan yang diperlukan dan bertanda (*).',
                'file'         => 'Sila isi ruangan yang diperlukan dan bertanda (*).',
                'mimes'        => 'Sila isi ruangan yang diperlukan dan bertanda (*).',
                'max'          => 'Sila isi ruangan yang diperlukan dan bertanda (*).',
            ]);

            $userId = auth()->id();
            $status = 'draft';

            $temp = darat_application_temp::firstOrCreate(
                ['user_id' => $userId, 'status' => $status],
                ['form_data' => json_encode([]), 'created_by' => $userId, 'updated_by' => $userId]
            );

            $data = json_decode($temp->form_data, true) ?? [];
            $documents = $data['tab6_document'] ?? [];

            $filesToUpload = [
                'vesselOld' => 'Gambar Vesel Asal',
                'vesselNew' => 'Gambar Vesel Baharu',
            ];

            foreach ($filesToUpload as $inputName => $title) {
                if ($request->hasFile($inputName) && $request->file($inputName)->isValid()) {
                    $file = $request->file($inputName);
                    $filename = time() . "_" . $file->getClientOriginalName(); // <-- timestamp_originalfilename.ext
                    $path = $file->storeAs(
                        'documents',
                        $filename,
                        'public'
                    );

                    $existingIndex = collect($documents)->search(function ($doc) use ($title) {
                        return isset($doc['title'], $doc['type']) &&
                            $doc['title'] === $title &&
                            $doc['type'] === 'required';
                    });

                    $documents[$existingIndex !== false ? $existingIndex : count($documents)] = [
                        'application_type' => $this->applicationTypeCode,
                        'title'            => $title,
                        'file_path'        => $path,
                        'type'             => 'required',
                    ];
                }
            }

            $data['tab6_document'] = $documents;
            $temp->form_data = json_encode($data);
            $temp->updated_by = $userId;
            $temp->save();

            DB::commit();
            return redirect()->back()->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }



    public function store_tab7(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'main_disposal_action' => 'required|string',
            'disposal_type'        => 'required_if:main_disposal_action,jual|string|nullable',
            'new_owner_name'       => 'required_if:main_disposal_action,jual|string|max:255|nullable',
            'new_owner_phone'      => 'required_if:main_disposal_action,jual|string|max:20|nullable',
            'new_owner_ic'         => 'required_if:main_disposal_action,jual|string|max:20|nullable',
        ]);

        DB::beginTransaction();

        try {
            $status = 'draft';

            $temp = darat_application_temp::firstOrCreate(
                ['user_id' => $user->id, 'status' => $status],
                ['form_data' => json_encode([]), 'created_by' => $user->id, 'updated_by' => $user->id]
            );

            $data = json_decode($temp->form_data ?? '{}', true);
            $disposalInfo = $data['temp_disposal_info'] ?? [];

            $disposalInfo['main_disposal_action'] = $request->main_disposal_action;
            $disposalInfo['disposal_type']        = $request->disposal_type;
            $disposalInfo['new_owner_name']       = $request->new_owner_name;
            $disposalInfo['new_owner_phone']      = $request->new_owner_phone;
            $disposalInfo['new_owner_ic']         = $request->new_owner_ic;

            $data['temp_disposal_info'] = $disposalInfo;

            $temp->form_data  = json_encode($data);
            $temp->updated_by = $user->id;
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
                ->where('code', '601')
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
                return redirect()->route('gantiKulit.permohonan-06.index')
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

            return redirect()->route('gantiKulit.permohonan-06.index')
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

    public function viewEquipmentFile(Request $request)
    {
        $equipmentId = $request->query('equipment_id');

        $equipment = darat_user_equipment::findOrFail($equipmentId);

        $path = storage_path('app/public/' . $equipment->file_path);

        if (! file_exists($path)) {
            abort(404, 'Fail tidak dijumpai.');
        }

        return response()->file($path);
    }

    public function viewDocument(Request $request)
    {
        $userId = auth()->id();
        $index = $request->query('index'); // Index of the required document

        $temp = darat_application_temp::where('user_id', $userId)
            ->where('status', 'draft')
            ->latest()
            ->first();

        if (!$temp) {
            abort(404, 'Permohonan tidak dijumpai.');
        }

        $formData = json_decode($temp->form_data, true);
        $documents = $formData['tab6_document'] ?? [];

        if (!is_array($documents) || !isset($documents[$index])) {
            abort(404, 'Dokumen tidak dijumpai.');
        }

        $doc = $documents[$index];

        $fullPath = storage_path('app/public/' . ltrim($doc['file_path'], '/'));

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

    //  public function printApplication(Request $request)
    // {
    //     $userId = auth()->id();
    //     $status = ($request->hidden_field == 1) ? 'pending' : 'draft';

    //     $temp = darat_application_temp::where('user_id', $userId)
    //         ->where('status', $status)
    //         ->latest()
    //         ->first();

    //     if (!$temp) {
    //         return redirect()->back()->with('error', 'Tiada data permohonan untuk dicetak.');
    //     }

    //     $userDetail = darat_user_detail::where('user_id', $userId)
    //         ->where('is_active', 1)
    //         ->first();

    //     $formData = json_decode($temp->form_data ?? '{}', true);

    //     // Validation for completeness
    //     if (
    //         empty($formData['tab3_jetty_info']) ||
    //         empty($formData['tab2_fisherman_info']) ||
    //         empty($formData['tab4_equipment_info']) ||
    //         empty($formData['tab5_vessel_info'])
    //     ) {
    //         return redirect()->back()->with('error', 'Sila lengkapkan semua maklumat permohonan sebelum mencetak borang.');
    //     }

    //     // Convert jetty info IDs to names
    //     $jettyInfoRaw = $formData['tab3_jetty_info'] ?? [];

    //     $jettyInfo = [
    //         'state'      => CodeMaster::find($jettyInfoRaw['state_id'])->name ?? '-',
    //         'district'   => CodeMaster::find($jettyInfoRaw['district_id'])->name ?? '-',
    //         'jetty_name' => Jetty::find($jettyInfoRaw['jetty_id'])->name ?? '-',
    //         'river'      => River::find($jettyInfoRaw['river_id'])->name ?? '-',
    //     ];

    //     // Split equipment by type
    //     $equipmentList = collect($formData['tab4_equipment_info'] ?? []);

    //     $mainEquipment = $equipmentList
    //         ->filter(fn($item) => ($item['type'] ?? '') === 'main')
    //         ->values()
    //         ->all();

    //     $additionalEquipments = $equipmentList
    //         ->filter(fn($item) => ($item['type'] ?? '') === 'additional')
    //         ->values()
    //         ->all();

    //     // Build data array for PDF
    //     $data = [
    //         'personalInfo' => [
    //             'name'                   => $userDetail->name ?? '-',
    //             'identity_card_number'   => $userDetail->identity_card_number ?? '-',
    //             'phone_number'           => $userDetail->phone_number ?? '-',
    //             'secondary_phone_number' => $userDetail->secondary_phone_number ?? '-',
    //             'address'                => $userDetail->address ?? '-',
    //             'postcode'               => $userDetail->postcode ?? '-',
    //             'district'               => $userDetail->district ?? '-',
    //             'state'                  => $userDetail->state ?? '-',
    //             'mailing_address'        => $userDetail->mailing_address ?? '-',
    //             'mailing_postcode'       => $userDetail->mailing_postcode ?? '-',
    //             'mailing_district'       => $userDetail->mailing_district ?? '-',
    //             'mailing_state'          => $userDetail->mailing_state ?? '-',
    //         ],
    //         'jettyInfo'            => $jettyInfo,
    //         'fishermanInfo'        => $formData['tab2_fisherman_info'],
    //         'mainEquipments'       => $mainEquipment,
    //         'additionalEquipments' => $additionalEquipments,
    //         'vesselInfo'           => $formData['tab5_vessel_info'],
    //     ];

    //     // Generate PDF
    //     $pdf = Pdf::loadView('app.NelayanDarat.gantiKulit.pemohon.print-application', $data)
    //         ->setPaper('A4', 'portrait');

    //     return $pdf->stream('Borang Permohonan.pdf');
    // }

    public function printApplication(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;

        // Get latest official application ID (optional: filter by approved/final status if needed)
        $latestApplicationId = darat_application::where('user_id', $userId)
            ->latest()
            ->value('id');

        if (!$latestApplicationId) {
            return redirect()->back()->with('error', 'Tiada permohonan rasmi untuk dicetak.');
        }

        // 1. Personal user details
        $userDetail = darat_user_detail::where('user_id', $userId)
            ->where('is_active', 1)
            ->first();

        // 2. Fisherman info (official)
        $fishermanInfoOff = darat_user_fisherman_info::where('user_id', $userId)
            ->where('is_active', 1)
            ->first();

        // 3. Jetty info with relationships
        $jettyOff = darat_base_jetties::with(['state', 'district', 'jetty', 'river'])
            ->where('user_id', $userId)
            ->where('is_active', 1)
            ->first();

        $jettyInfo = [
            'state'      => $jettyOff->state->name ?? '-',
            'district'   => $jettyOff->district->name ?? '-',
            'jetty_name' => $jettyOff->jetty->name ?? '-',
            'river'      => $jettyOff->river->name ?? '-',
        ];

        // 4. Equipment list (official)
        $latestEquipmentGroup = darat_user_equipment::where('user_id', $userId)
            ->where('application_id', $latestApplicationId)
            ->where('is_active', 1)
            ->get();

        $mainEquipment = $latestEquipmentGroup
            ->filter(fn($item) => ($item->type ?? '') === 'main')
            ->values()
            ->all();

        $additionalEquipments = $latestEquipmentGroup
            ->filter(fn($item) => ($item->type ?? '') === 'additional')
            ->values()
            ->all();

        // 5. Vessel info with hull and engine
        $vesselInfoOff = darat_vessel::with(['hull', 'engine'])
            ->where('user_id', $userId)
            ->where('is_active', 1)
            ->first();

        //  6. Compile final data
        $data = [
            'personalInfo' => [
                'name'                   => $userDetail->name ?? '-',
                'identity_card_number'   => $userDetail->identity_card_number ?? '-',
                'phone_number'           => $userDetail->phone_number ?? '-',
                'secondary_phone_number' => $userDetail->secondary_phone_number ?? '-',
                'address'                => $userDetail->address ?? '-',
                'postcode'               => $userDetail->postcode ?? '-',
                'district'               => $userDetail->district ?? '-',
                'state'                  => $userDetail->state ?? '-',
                'mailing_address'        => $userDetail->mailing_address ?? '-',
                'mailing_postcode'       => $userDetail->mailing_postcode ?? '-',
                'mailing_district'       => $userDetail->mailing_district ?? '-',
                'mailing_state'          => $userDetail->mailing_state ?? '-',
            ],
            'jettyInfo'            => $jettyInfo,
            'fishermanInfo'        => $fishermanInfoOff,
            'mainEquipments'       => $mainEquipment,
            'additionalEquipments' => $additionalEquipments,
            'vesselInfo'           => $vesselInfoOff,
        ];

        // 7. Generate and stream the PDF
        $pdf = Pdf::loadView('app.NelayanDarat.gantiKulit.pemohon.print-application', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream('Borang Permohonan.pdf');
    }

    public function getDistricts($stateId)
    {
        $districts = CodeMaster::where('type', 'district')
            ->where('parent_id', $stateId)
            ->pluck('name', 'id');

        return response()->json($districts);
    }

    public function getJettyAndRiver($districtId)
    {
        $jetty = Jetty::where('district_id', $districtId)->pluck('name', 'id');
        $river = River::where('district_id', $districtId)->pluck('name', 'id');

        return response()->json([
            'jetty' => $jetty,
            'river' => $river,
        ]);
    }
}
