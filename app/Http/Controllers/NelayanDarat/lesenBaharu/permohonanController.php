<?php

namespace App\Http\Controllers\NelayanDarat\lesenBaharu;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\darat_application;
use App\Models\darat_application_log;
use App\Models\darat_base_jetties;
use App\Models\darat_document;
use App\Models\darat_equipment_set;
use App\Models\ProfileUsers;
use App\Models\darat_user_equipment;
use App\Models\darat_user_fisherman_info;
use App\Models\darat_vessel;
use App\Models\darat_vessel_engine;
use App\Models\darat_vessel_hull;
use App\Models\darat_application_temp;
use App\Models\User;
use App\Models\darat_equipment_list;
use App\Models\darat_help_agencyData_fisherman;
use App\Models\LandingDeclaration;
use App\Models\LandingInfo;
use App\Models\NelayanDarat\Jetty;
use App\Models\NelayanDarat\River;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class permohonanController extends Controller
{
    protected $applicationTypeCode = '1';

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

        $negativeFeedback = ['101-1'];
        $draftFeedback = [' '];
        $appealFeedback = ['108-2','113-2'];

        $user = auth()->user();
        $roleName = $user->roles()->pluck('name')->first();

        $applicationType = CodeMaster::getApplicationTypeByCode($this->applicationTypeCode);

        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
        $currentUrlPath = '/' . $segment1 . '/' . $segment2;

        $moduleName = DB::table('modules')
            ->where('url', $currentUrlPath)
            ->first();

        $landingRequirementMet = User::hasMinimumLanding($userId);

        return view('app.NelayanDarat.lesenBaharu.pemohon.index', compact(
            'applications',
            'draftFeedback',
            'negativeFeedback',
            'appealFeedback',
            'applicationType',
            'moduleName',
            'roleName',
            'landingRequirementMet'
        ));
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

        $userWithFisherman = $user->load('fishermanInfo.aidAgencies');
        $aidAgencies = $userWithFisherman->fishermanInfo?->aidAgencies ?? collect();

        $temp = darat_application_temp::where('user_id', $user->id)
            ->where('status',  'draft')
            ->latest()
            ->first();

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

        return view('app.NelayanDarat.lesenBaharu.pemohon.create', compact(
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
            'documentsData'

        ));
    }

    public function negativeFeedback($id)
    {

        $user = Auth::user();

        $roleName = $user->roles()->pluck('name')->first();

        $application = darat_application::findOrFail($id);

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

        $userWithFisherman = $user->load('fishermanInfo.aidAgencies');
        $aidAgencies = $userWithFisherman->fishermanInfo?->aidAgencies ?? collect();

        $temp = darat_application_temp::where('user_id', $user->id)
            ->where('application_id', $application->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

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

        return view('app.NelayanDarat.lesenBaharu.pemohon.negative', compact(
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
            'application',

        ));
    }

    public function appealFeedback($id)
    {
        $application = darat_application::with('fetchApplicationLog', 'applicationStatus')->findOrFail($id);
        $user = $application->user->load('fishermanInfo.aidAgencies'); // Load related info here

        $roleName = Auth::user()->roles()->pluck('name')->first();
        $applicationType = CodeMaster::getApplicationTypeByCode($this->applicationTypeCode);

        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
        $currentUrlPath = '/' . $segment1 . '/' . $segment2;
        $moduleName = DB::table('modules')->where('url', $currentUrlPath)->first();

        $applicationType = CodeMaster::getApplicationTypeByCode($this->applicationTypeCode);

        $jetty = darat_base_jetties::with(['state', 'district', 'jetty', 'river'])->where('user_id', $user->id)->where('is_active', 1)->first();

        $vessel = darat_vessel::where('user_id', $user->id)->where('is_active', true)->latest()->first();

        $applicationLogs = darat_application_log::with(['applicationStatus', 'creator'])
            ->where('application_id', $application->id)
            ->whereHas('applicationStatus', function ($query) {
                $query->where('code', '108-2');
            })
            ->first();

        $userDetail = ProfileUsers::where('user_id', $user->id)->where('is_active', 1)->first();

        return view('app.NelayanDarat.lesenBaharu.pemohon.appeal', compact(
            'application',
            'user',
            'roleName',
            'segment1',
            'segment2',
            'currentUrlPath',
            'moduleName',
            'jetty',
            'vessel',
            'applicationLogs',
            'userDetail',
            'applicationType'
        ));
    }

    public function storeAppeal(Request $request)
    {
        DB::beginTransaction();

        try {

            $applicationId = $request->query('application');

            $application = darat_application::findOrFail($applicationId);

            $userId = $application->user_id;
            $now = now()->toDateTimeString();

            // Validate user input from Blade
            $request->validate([
                'appeal_text' => 'required|string|max:1000',
                'appeal_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            ], [
                'appeal_text.required' => 'Sila nyatakan alasan rayuan.',
                '*.file' => 'Fail tidak sah atau melebihi had saiz.',
            ]);

            $status = 'pending';

            // Get or create temp
            $temp = darat_application_temp::firstOrCreate(
                ['user_id' => $userId, 'status' => $status],
                ['form_data' => json_encode([]), 'created_by' => $userId, 'updated_by' => $userId]
            );

            $data = json_decode($temp->form_data, true) ?? [];
            $documentsData = $data['tab6_document'] ?? [];

            if ($request->hasFile('appeal_attachment')) {
                $file = $request->file('appeal_attachment');
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $finalName = "{$originalName}_" . now()->format('Ymd_His') . ".{$extension}";
                $path = $file->storeAs('documents', $finalName, 'public');

                $documentsData[] = [
                    'application_type' => $this->applicationTypeCode ?? 'default',
                    'title'            => 'Dokumen Sokongan Rayuan',
                    'file_path'        => $path,
                    'original_name'    => $finalName,
                    'uploaded_at'      => now()->toDateTimeString(),
                    'type'             => 'optional',
                ];
            }

            $data['tab6_document'] = $documentsData;
            $temp->form_data = json_encode($data);
            $temp->updated_by = $userId;
            $temp->save();

            // Update temp to link to application
            darat_application_temp::where('user_id', $userId)
                ->where('status', 'pending')
                ->latest()
                ->update([
                    'application_id' => $applicationId,
                    'updated_by' => $userId,
                ]);

            $statusId = CodeMaster::where('type', 'application_status')->where('code', '113')->value('id');

            $application->update([
                'application_status_id' => $statusId,
                'updated_by'            => auth()->id(),
            ]);

            darat_application_log::create([
                'application_id' => $applicationId,
                'application_status_id' => $statusId,
                'remark' => $request->appeal_text,
                'created_by' => $userId,
            ]);

            DB::commit();

            return redirect()->route('lesenBaharu.permohonan-01.index')->with('success', 'Rayuan berjaya dihantar.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function store_tab2(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate(
                [
                    'year_become_fisherman'            => 'required|date',
                    'becoming_fisherman_duration'      => 'nullable|integer',
                    'working_days_fishing_per_month'   => 'required|integer',
                    'estimated_income_yearly_fishing'  => 'required|numeric',
                    'estimated_income_other_job'       => 'nullable|numeric',
                    'days_working_other_job_per_month' => 'nullable|integer',
                    'receive_pension'                  => 'required|boolean',
                    'receive_financial_aid'            => 'required|boolean',
                    'financial_aid_agencyData'             => 'nullable|array',
                    'financial_aid_agencyData.*'           => 'nullable|string|max:255',
                    'epf_contributor'                  => 'required|boolean',
                    'status' => 'nullable|string'
                ],
                [
                    '*.required' => 'Sila isi semua maklumat yang diperlukan.',
                    '*.integer'  => 'Sila isi semua maklumat yang diperlukan.',
                    '*.numeric'  => 'Sila isi semua maklumat yang diperlukan.',
                    '*.boolean'  => 'Sila isi semua maklumat yang diperlukan.',
                    '*.array'    => 'Sila isi semua maklumat yang diperlukan.',
                    '*.string'   => 'Sila isi semua maklumat yang diperlukan.',
                    '*.max'      => 'Sila isi semua maklumat yang diperlukan.',
                ]
            );

            $userId = auth()->id();

            $status = $request->status ? 'pending' : 'draft';

            $temp = darat_application_temp::firstOrCreate(
                [
                    'user_id' => $userId,
                    'status'  =>  $status,
                ],
                [
                    'form_data'  => json_encode([]),
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]
            );

            $data = json_decode($temp->form_data, true) ?? [];

            $data['tab2_fisherman_info'] = [
                'year_become_fisherman'            => $request->year_become_fisherman,
                'becoming_fisherman_duration'      => $request->becoming_fisherman_duration,
                'working_days_fishing_per_month'   => $request->working_days_fishing_per_month,
                'estimated_income_yearly_fishing'  => $request->estimated_income_yearly_fishing,
                'estimated_income_other_job'       => $request->estimated_income_other_job,
                'days_working_other_job_per_month' => $request->days_working_other_job_per_month,
                'receive_pension'                  => $request->receive_pension,
                'receive_financial_aid'            => $request->receive_financial_aid,
                'financial_aid_agencyData'             => array_values(array_filter($request->financial_aid_agencyData ?? [])),
                'epf_contributor'                  => $request->epf_contributor,
            ];

            $temp->form_data = json_encode($data);
            $temp->updated_by = $userId;
            $temp->save();

            DB::commit();

            return redirect()->back()
                ->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function store_tab3(Request $request)
    {
        DB::beginTransaction();

        $request->validate(
            [
                'state_id'    => 'required|string',
                'district_id' => 'required|string',
                'jetty_id'    => 'required|string',
                'river_id'    => 'required|string',
                'status' => 'nullable|string'
            ],
            [
                '*.required' => 'Sila isi semua maklumat yang diperlukan.',
                '*.integer'  => 'Sila isi semua maklumat yang diperlukan.',
                '*.numeric'  => 'Sila isi semua maklumat yang diperlukan.',
                '*.boolean'  => 'Sila isi semua maklumat yang diperlukan.',
                '*.array'    => 'Sila isi semua maklumat yang diperlukan.',
                '*.string'   => 'Sila isi semua maklumat yang diperlukan.',
                '*.max'      => 'Sila isi semua maklumat yang diperlukan.',
            ]

        );

        $status = $request->status ? 'pending' : 'draft';

        try {
            $status = ($request->hidden_field == 1) ? 'pending' :  $status;

            $temp = darat_application_temp::firstOrCreate(
                [
                    'user_id' => auth()->id(),
                    'status'  => $status,
                ],
                [
                    'form_data'  => json_encode([]),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]
            );

            $data = json_decode($temp->form_data, true) ?? [];

            $data['tab3_jetty_info'] = [
                'state_id'      => $request->state_id,
                'district_id'   => $request->district_id,
                'jetty_id' => $request->jetty_id,
                'river_id'      => $request->river_id,
            ];

            $temp->form_data  = json_encode($data);
            $temp->updated_by = auth()->id();
            $temp->save();

            DB::commit();

            return redirect()->back()
                ->with('success', 'Berjaya disimpan');
        } catch (\Exception $e) {
            DB::rollback();

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

                'status' => 'nullable|string'

            ]);

            $status = $request->status ? 'pending' : 'draft';

            // Retrieve or create draft temporary data
            $temp = darat_application_temp::firstOrCreate(
                ['user_id' => $userId, 'status' =>  $status],
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

    public function store_tab5(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'has_vessel' => 'required|in:yes,no',
                'transport_type' => 'nullable|required_if:has_vessel,no|string|max:255',

                'vessel_registration_number' => 'nullable|string|max:255',
                'hull_type'                  => 'nullable|required_if:has_vessel,yes|string|max:255',
                'length'                     => 'nullable|required_if:has_vessel,yes|numeric',
                'width'                      => 'nullable|required_if:has_vessel,yes|numeric',
                'depth'                      => 'nullable|required_if:has_vessel,yes|numeric',

                'has_engine'   => 'nullable|required_if:has_vessel,yes|in:yes,no',

                'engine_model' => 'nullable|required_if:has_engine,yes|string|max:255',
                'engine_power' => 'nullable|required_if:has_engine,yes|string|max:255',

                'engine_brand' => 'nullable|string|max:255',

                'has_registration_number' => 'nullable|required_if:has_vessel,yes|in:yes,no',
                'status' => 'nullable|string'

            ]);

            $status = $request->status ? 'pending' : 'draft';

            $temp = darat_application_temp::firstOrCreate(
                [
                    'user_id' => auth()->id(),
                    'status'  =>  $status,
                ],
                [
                    'form_data'  => json_encode([]),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ]
            );

            $data = json_decode($temp->form_data, true) ?? [];

            $vesselData = [
                'has_vessel' => $request->has_vessel,
            ];

            if ($request->has_vessel === 'no') {
                $vesselData['transport_type'] = $request->transport_type;
            }

            if ($request->has_vessel === 'yes') {
                $vesselData['has_registration_number'] = $request->has_registration_number;
                $vesselData['vessel_registration_number'] = $request->vessel_registration_number;
                $vesselData['hull_type'] = $request->hull_type;
                $vesselData['length'] = $request->length;
                $vesselData['width'] = $request->width;
                $vesselData['depth'] = $request->depth;
                $vesselData['has_engine'] = $request->has_engine;

                if ($request->has_engine === 'yes') {
                    $vesselData['engine_model'] = $request->engine_model;
                    $vesselData['horsepower'] = $request->engine_power;
                    $vesselData['engine_brand'] = $request->engine_brand;
                }
            }

            $data['tab5_vessel_info'] = $vesselData;

            $temp->form_data = json_encode($data);
            $temp->updated_by = auth()->id();
            $temp->save();

            DB::commit();

            return redirect()->back()
                ->with('success', 'Berjaya disimpan');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Ralat:' . $e->getMessage());
        }
    }

    public function store_tab6(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'vessel_picture' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'engine_picture' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'status' => 'nullable|string'
            ]);

            $userId = auth()->id();

            $status = $request->status ? 'pending' : 'draft';

            $temp = darat_application_temp::firstOrCreate(
                ['user_id' => $userId, 'status' =>  $status],
                ['form_data' => json_encode([]), 'created_by' => $userId, 'updated_by' => $userId]
            );

            $data = json_decode($temp->form_data ?? '{}', true);
            $documentsData = $data['tab6_document'] ?? [];

            $uploads = [
                'vessel_picture' => 'Gambar Vesel',
                'engine_picture' => 'Gambar Enjin',
            ];

            foreach ($uploads as $fieldName => $title) {
                if ($request->hasFile($fieldName)) {
                    $file = $request->file($fieldName);
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $timestamp = now()->format('Ymd_His');
                    $finalName = $originalName . '_' . $timestamp . '.' . $extension;
                    $path = $file->storeAs('documents', $finalName, 'public');

                    $uploadedAt = now()->toDateTimeString();

                    // Check if this title already exists and update it
                    $found = false;
                    foreach ($documentsData as &$doc) {
                        if (($doc['title'] ?? '') === $title) {
                            $doc['file_path']        = $path;
                            $doc['original_name']    = $finalName;
                            $doc['uploaded_at']      = $uploadedAt;
                            $doc['application_type'] = $this->applicationTypeCode;
                            $doc['type']             = 'required';
                            $found = true;
                            break;
                        }
                    }

                    if (!$found) {
                        $documentsData[] = [
                            'application_type' => $this->applicationTypeCode,
                            'title'            => $title,
                            'file_path'        => $path,
                            'original_name'    => $finalName,
                            'uploaded_at'      => $uploadedAt,
                            'type'             => 'required',
                        ];
                    }
                }
            }

            $data['tab6_document'] = $documentsData;

            $temp->form_data = json_encode($data);
            $temp->updated_by = $userId;
            $temp->save();

            DB::commit();

            return redirect()->back()->with('success', 'Berjaya Disimpan.');
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
                'status' => 'nullable|string'
            ]);

            $statusId = CodeMaster::where('type', 'application_status')
                ->where('code', '101')
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
                return redirect()->route('lesenBaharu.permohonan-01.index')
                    ->with('success', 'Kenyataan berjaya dihantar.');
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
                ->where('status',   'pending')
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

            return redirect()->route('lesenBaharu.permohonan-01.index')
                ->with('success', 'Permohonan baru berjaya dihantar.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function submitNegativeFeedback(Request $request)
    {
        DB::beginTransaction();

        try {;

            $applicationId = $request->query('id');

            $application = darat_application::where('id', $applicationId)->firstOrFail();

            $statusId = CodeMaster::where('type', 'application_status')
                ->where('code', '101')
                ->value('id');

            $application->update([
                'application_status_id' => $statusId,
                'updated_by'            => auth()->id(),
            ]);



            // Also log the status update
            darat_application_log::create([
                'application_id'        => $application->id,
                'application_status_id' => $statusId,
                'created_by'            => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('lesenBaharu.permohonan-01.index')
                ->with('success', 'Permohonan berjaya dikemaskini.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function viewEquipment(Request $request)
    {
        $userId = auth()->id();

        $type = $request->query('type');
        $index = $request->query('index');

        $temp = darat_application_temp::where('user_id', $userId)
            ->whereIn('status', ['draft', 'pending'])
            ->latest()
            ->first();

        if (!$temp) {
            abort(404, 'Permohonan tidak dijumpai.');
        }

        $formData = json_decode($temp->form_data, true);
        $equipmentList = collect($formData['tab4_equipment_info'] ?? [])
            ->filter(fn($item) => is_array($item))
            ->values();

        $filePath = null;

        if ($type === 'UTAMA') {
            $filePath = $equipmentList->firstWhere('type', 'UTAMA')['file_path'] ?? null;
        } elseif ($type === 'TAMBAHAN' && is_numeric($index)) {
            $additionalItems = $equipmentList->filter(fn($item) => $item['type'] === 'TAMBAHAN')->values();
            $filePath = $additionalItems[$index]['file_path'] ?? null;
        }

        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'Fail tidak dijumpai.');
        }

        return response()->file(
            Storage::disk('public')->path($filePath),
            [
                'Content-Type' => Storage::disk('public')->mimeType($filePath),
                'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
            ]
        );
    }

    public function printApplication(Request $request)
    {
        $userId = auth()->id();

        $temp = darat_application_temp::where('user_id', $userId)
            ->whereIn('status', ['draft', 'pending'])
            ->latest()
            ->first();

        if (!$temp) {
            return redirect()->back()->with('error', 'Tiada data permohonan untuk dicetak.');
        }

        $userDetail = ProfileUsers::where('user_id', $userId)
            ->where('is_active', 1)
            ->first();

        $formData = json_decode($temp->form_data ?? '{}', true);

        // Validation for completeness
        if (
            empty($formData['tab4_equipment_info']) ||
            empty($formData['tab5_vessel_info'])
        ) {
            return redirect()->back()->with('error', 'Sila lengkapkan semua maklumat permohonan sebelum mencetak borang.');
        }

        $equipmentData = $formData['tab4_equipment_info'];

        $vesselData = $formData['tab5_vessel_info'];

        // Fetch from darat_base_jetties instead of resolving individual IDs

        $jettyData = darat_base_jetties::with(['state', 'district', 'river'])->where('user_id', $userId)->latest()->first();

        $fishermanInfoData = darat_user_fisherman_info::where('user_id', $userId)->latest()->first();

        // Split equipment by type
        $equipmentList = collect($formData['tab4_equipment_info'] ?? []);

        $mainEquipment = $equipmentList
            ->filter(fn($item) => ($item['type'] ?? '') === 'UTAMA')
            ->values()
            ->all();

        $additionalEquipments = $equipmentList
            ->filter(fn($item) => ($item['type'] ?? '') === 'TAMBAHAN')
            ->values()
            ->all();

        // Build data array for PDF
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
            'jettyData'            => $jettyData,
            'fishermanInfo'        => $fishermanInfoData,
            'mainEquipments'       => $mainEquipment,
            'additionalEquipments' => $additionalEquipments,
            'vesselData'           => $vesselData,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('app.NelayanDarat.lesenBaharu.pemohon.print-application', $data)
            ->setPaper('A4', 'portrait');

        return $pdf->stream('Borang Permohonan.pdf');
    }

    public function getDistricts($state_id)
    {
        $districts = CodeMaster::where('type', 'district')
            ->where('parent_id', $state_id)
            ->pluck('name', 'id');

        return response()->json($districts);
    }

    public function getJetties($district_id)
    {
        $jetties = Jetty::where('district_id', $district_id)->pluck('name', 'id');
        return response()->json($jetties);
    }
    public function getRivers($district_id)
    {
        $rivers = River::where('district_id', $district_id)->pluck('name', 'id');
        return response()->json($rivers);
    }

    public function viewTempDocument(Request $request)
    {
        $title = $request->query('title');

        // Fetch document by title from the temp application
        $userId = auth()->id();
        $temp = darat_application_temp::where('user_id', $userId)->latest()->first();

        if (! $temp) {
            abort(404, 'Permohonan tidak dijumpai.');
        }

        $formData = json_decode($temp->form_data, true);
        $documents = $formData['tab6_document'] ?? [];

        $document = collect($documents)->firstWhere('title', $title);

        if (! $document || empty($document['file_path'])) {
            abort(404, 'Dokumen tidak dijumpai.');
        }

        $path = 'public/' . $document['file_path'];

        if (! Storage::exists($path)) {
            abort(404, 'Fail tidak wujud dalam storan.');
        }

        return response()->file(storage_path('app/' . $path));
    }
}
