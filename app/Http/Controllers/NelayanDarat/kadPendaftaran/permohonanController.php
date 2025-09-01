<?php

namespace App\Http\Controllers\NelayanDarat\kadPendaftaran;

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
use App\Models\NelayanDarat\state_office_mapping;
use App\Models\User;
use App\Models\darat_equipment_list;
use App\Models\darat_fault_record;
use App\Models\darat_help_agencyData_fisherman;
use App\Models\Entity;
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingInfo;
use App\Models\NelayanDarat\Jetty;
use App\Models\NelayanDarat\River;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

use GuzzleHttp\Psr7\Query;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class permohonanController extends Controller
{
    protected $applicationTypeCode = '8';

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

        $negativeFeedback = ['801-1'];
        $draftFeedback = ['0'];
        $appealFeedback = ['807-2'];

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

        return view('app.NelayanDarat.kadPendaftaran.pemohon.index', compact(
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
        $equipmentList = darat_equipment_list::where('is_active', true)->pluck('name', 'id');

        $userDetail = ProfileUsers::where('user_id', $user->id)->where('is_active', 1)->first();
        $userWithFisherman = $user->load('fishermanInfo.aidAgencies');
        $aidAgencies = $userWithFisherman->fishermanInfo?->aidAgencies ?? collect();

        $temp = darat_application_temp::where('user_id', $user->id)
            ->where('status', 'draft')
            ->latest()
            ->first();

        $formData = json_decode($temp->form_data ?? '{}', true);

        $fishermanData     = $formData['tab2_fisherman_info'] ?? [];
        $jettyData         = $formData['tab3_jetty_info'] ?? [];
        $equipmentData     = $formData['tab4_equipment_info'] ?? [];
        $vesselData        = $formData['tab5_vessel_info'] ?? [];
        $documentsData         = $formData['tab6_document'] ?? [];

        $agencyData            = $fishermanData['financial_aid_agencyData'] ?? [];

        $mainEquipment = collect($equipmentData)
            ->where('type', 'UTAMA')
            ->values()
            ->all();

        $additionalEquipments = collect($equipmentData)
            ->where('type', 'TAMBAHAN')
            ->values()
            ->all();

        $signedDocumentsData = array_filter($documentsData, fn($doc) => ($doc['type'] ?? null) === 'required');

        return view('app.NelayanDarat.kadPendaftaran.pemohon.create', compact(
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
            'mainEquipment',
            'additionalEquipments',
            'aidAgencies',
            'hullTypes',
            'signedDocumentsData',

            'engineBrand',

            'fishermanData',
            'jettyData',
            'vesselData',
            'documentsData',
            'agencyData',
        ));
    }

    public function negativeFeedback($id)
    {

        $application = darat_application::findOrFail($id);

        $user = $application->user;

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
        $equipmentList = darat_equipment_list::where('is_active', true)->pluck('name', 'id');

        $userDetail = ProfileUsers::where('user_id', $user->id)->where('is_active', 1)->first();
        $userWithFisherman = $user->load('fishermanInfo.aidAgencies');
        $aidAgencies = $userWithFisherman->fishermanInfo?->aidAgencies ?? collect();

        $temp = darat_application_temp::where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        $formData = json_decode($temp->form_data ?? '{}', true);

        $fishermanData     = $formData['tab2_fisherman_info'] ?? [];
        $jettyData         = $formData['tab3_jetty_info'] ?? [];
        $equipmentData     = $formData['tab4_equipment_info'] ?? [];
        $vesselData        = $formData['tab5_vessel_info'] ?? [];
        $documentsData         = $formData['tab6_document'] ?? [];

        $agencyData            = $fishermanData['financial_aid_agencyData'] ?? [];

        $mainEquipment = collect($equipmentData)
            ->where('type', 'UTAMA')
            ->values()
            ->all();

        $additionalEquipments = collect($equipmentData)
            ->where('type', 'TAMBAHAN')
            ->values()
            ->all();

        $signedDocumentsData = array_filter($documentsData, fn($doc) => ($doc['type'] ?? null) === 'required');

        return view('app.NelayanDarat.kadPendaftaran.pemohon.negativeFeedback', compact(
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
            'mainEquipment',
            'additionalEquipments',
            'aidAgencies',
            'hullTypes',
            'signedDocumentsData',

            'engineBrand',

            'fishermanData',
            'jettyData',
            'vesselData',
            'documentsData',
            'agencyData',
        ));
    }

    public function appealFeedback($id)
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
            ->whereHas('applicationStatus', function ($query) {
                $query->where('code', '807-2');
            })
            ->first();

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

        return view('app.NelayanDarat.kadPendaftaran.pemohon.appeal', compact(
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
            'declarations'
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

            $statusId = CodeMaster::where('type', 'application_status')->where('code', '806')->value('id');

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

            return redirect()->route('kadPendaftaran.permohonan-08.index')->with('success', 'Rayuan berjaya dihantar.');
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
                    'epf_type'                         => 'nullable|string', // dah tukar
                    'financial_aid_agency' => 'nullable|array',
                    'financial_aid_agency.*' => 'nullable|string|max:255',
                    'epf_contributor'                  => 'nullable|boolean',

                    'status'        => 'nullable|string|max:255',
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

            // Determine the status: 'pending' if provided, otherwise 'draft'
            $status = !empty($request->status) ? 'pending' : 'draft';

            $temp = darat_application_temp::firstOrCreate(
                [
                    'user_id' => $userId,
                    'status'  => $status,
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
                'epf_type'                         => $request->epf_type,
                'receive_pension'                  => $request->receive_pension,
                'receive_financial_aid'            => $request->receive_financial_aid,
                'financial_aid_agencyData' => array_values(array_filter($request->financial_aid_agency ?? [])),
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

        try {

            $request->validate(
                [
                    'state_id'    => 'required|string',
                    'district_id' => 'required|string',
                    'jetty_id'    => 'required|string',
                    'river_id'    => 'required|string',

                    'status'    => 'nullable|string',
                ],
                [
                    '*.required' => 'Sila isi semua maklumat yang diperlukan.',
                    '*.string'   => 'Sila isi semua maklumat yang diperlukan.',
                ]
            );

            $user = auth()->user();

            $entityMapping = state_office_mapping::where('state_id', $request->state_id)
                ->where('district_id', $request->district_id)
                ->first();

            $entity = Entity::find($entityMapping->office_id);

            if (!$entity) {
                throw new \Exception('Padanan negeri dan daerah tidak dijumpai.');
            }

            $user->update([
                'entity_id'  => $entity->id,
                'updated_by' => $user->id,
            ]);

            $status = !empty($request->status) ? 'pending' : 'draft';

            $temp = darat_application_temp::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'status'  => $status,
                ],
                [
                    'form_data'  => json_encode([]),
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );

            $data = json_decode($temp->form_data, true) ?? [];

            $data['tab3_jetty_info'] = [
                'state_id'    => $request->state_id,
                'district_id' => $request->district_id,
                'jetty_id'    => $request->jetty_id,
                'river_id'    => $request->river_id,
            ];

            $temp->form_data  = json_encode($data);
            $temp->updated_by = $user->id;
            $temp->save();

            DB::commit();

            return redirect()->back()->with('success', 'Berjaya disimpan');
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
            $request->validate([

                'status'    => 'nullable|string',
                'needItem'  => 'nullable|string',

                // Main is required only if needItem is empty/null
                'main' => 'nullable|required_if:needItem,""|array',
                'main.*.name' => 'nullable|required_if:needItem,""|string|max:255',
                'main.*.quantity' => 'nullable|required_if:needItem,""|integer|min:1',
                'main.*.file' => 'nullable|required_if:needItem,""|file|mimes:jpg,jpeg,png,pdf,docx|max:5120',

                'additional' => 'nullable|array|max:5',
                'additional.*.name' => 'nullable|string|max:255',
                'additional.*.quantity' => 'nullable|integer|min:1|required_if:additional.*.name,!=,',
                'additional.*.file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:5120|required_if:additional.*.name,!=,',

            ], [
                '*.required' => 'Sila isi semua maklumat yang diperlukan.',
                '*.max' => 'Sila isi semua maklumat yang diperlukan.',
                '*.integer' => 'Sila isi semua maklumat yang diperlukan.',
                '*.file' => 'Fail tidak sah atau melebihi had saiz.',
            ]);

            $status = !empty($request->status) ? 'pending' : 'draft';

            // Create or get temp record
            $temp = darat_application_temp::firstOrCreate(
                ['user_id' => $userId, 'status' => $status],
                ['form_data' => json_encode([]), 'created_by' => $userId, 'updated_by' => $userId]
            );

            $data = json_decode($temp->form_data ?? '{}', true);
            $existing = $data['tab4_equipment_info'] ?? [];
            $equipment = [];

            // Handle all items
            foreach (['main' => 'UTAMA', 'additional' => 'TAMBAHAN'] as $group => $type) {
                foreach ($request->input($group, []) as $i => $item) {
                    if (!empty($item['name']) && !empty($item['quantity'])) {
                        $entry = [
                            'name'     => $item['name'],
                            'quantity' => $item['quantity'],
                            'type'     => $type,
                            'file_path' => null,
                            'uploaded_at' => null,
                        ];

                        if ($request->hasFile("{$group}.{$i}.file")) {
                            $file = $request->file("{$group}.{$i}.file");
                            $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                            $ext = $file->getClientOriginalExtension();
                            $timestamp = now()->format('Ymd_His');
                            $finalName = "{$name}_{$timestamp}.{$ext}";

                            $entry['file_path'] = $file->storeAs('equipment', $finalName, 'public');
                            $entry['uploaded_at'] = now()->toDateTimeString();
                        } else {
                            foreach ($existing as $old) {
                                if ($old['type'] === $type && $old['name'] === $item['name']) {
                                    $entry['file_path'] = $old['file_path'] ?? null;
                                    $entry['uploaded_at'] = $old['uploaded_at'] ?? null;
                                    break;
                                }
                            }
                        }

                        $equipment[] = $entry;
                    }
                }
            }

            // Save if any equipment exists
            if ($equipment) {
                $data['tab4_equipment_info'] = $equipment;
                $temp->form_data = json_encode($data);
                $temp->updated_by = $userId;
                $temp->save();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
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
                'status'    => 'nullable|string',

            ]);

            $status = !empty($request->status) ? 'pending' : 'draft';

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
                'signed_application'         => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
                'landing_declaration_form'   => 'required|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
                'status'                     => 'nullable|string',
            ]);

            $userId = auth()->id();
            $status = !empty($request->status) ? 'pending' : 'draft';

            $temp = darat_application_temp::firstOrCreate(
                [
                    'user_id' => $userId,
                    'status'  => $status,
                ],
                [
                    'form_data'  => json_encode([]),
                    'created_by' => $userId,
                    'updated_by' => $userId,
                ]
            );

            $data = json_decode($temp->form_data, true) ?? [];
            $documentsData = $data['tab6_document'] ?? [];
            $now = now()->toDateTimeString();

            $documentConfigs = [
                [
                    'field' => 'signed_application',
                    'title' => 'Borang Pengesahan Penghulu/Ketua Kampung/JKKK/JKOA/MyKP',
                ],
                [
                    'field' => 'landing_declaration_form',
                    'title' => 'Borang Pengisytiharan Pendaratan',
                ],
            ];

            foreach ($documentConfigs as $config) {
                if ($request->hasFile($config['field'])) {
                    $file = $request->file($config['field']);
                    $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $timestamp = now()->format('Ymd_His');
                    $finalName = $originalName . '_' . $timestamp . '.' . $extension;
                    $path = $file->storeAs('documentsData', $finalName, 'public');

                    $found = false;
                    foreach ($documentsData as &$doc) {
                        if (($doc['title'] ?? '') === $config['title']) {
                            $doc['file_path']        = $path;
                            $doc['original_name']    = $finalName;
                            $doc['uploaded_at']      = $now;
                            $doc['application_type'] = $this->applicationTypeCode;
                            $doc['type']             = 'required';
                            $found = true;
                            break;
                        }
                    }

                    if (! $found) {
                        $documentsData[] = [
                            'application_type' => $this->applicationTypeCode,
                            'title'            => $config['title'],
                            'file_path'        => $path,
                            'original_name'    => $finalName,
                            'uploaded_at'      => $now,
                            'type'             => 'required',
                        ];
                    }
                }
            }

            $data['tab6_document'] = $documentsData;

            $temp->form_data  = json_encode($data);
            $temp->updated_by = $userId;
            $temp->save();

            DB::commit();

            return redirect()->back()->with('success', 'Dokumen berjaya dimuat naik.');
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
                'status'    => 'nullable|string',
            ]);

            $statusId = CodeMaster::where('type', 'application_status')
                ->where('code', '801')
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
                return redirect()->route('kadPendaftaran.permohonan-08.index')
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

            $status = !empty($request->status) ? 'pending' : 'draft';

            darat_application_temp::where('user_id', auth()->id())
                ->where('status',  $status)
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

            return redirect()->route('kadPendaftaran.permohonan-08.index')
                ->with('success', 'Permohonan baru berjaya dihantar.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function printApplication(Request $request)
    {
        $userId = auth()->id();
        $status = $request->status ? 'pending' : 'draft';

        $temp = darat_application_temp::where('user_id', $userId)
            ->where('status', $status)
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
            empty($formData['tab3_jetty_info']) ||
            empty($formData['tab2_fisherman_info']) ||
            empty($formData['tab4_equipment_info']) ||
            empty($formData['tab5_vessel_info'])
        ) {
            return redirect()->back()->with('error', 'Sila lengkapkan semua maklumat permohonan sebelum mencetak borang.');
        }

        // Convert jetty info IDs to names
        $jettyDataRaw = $formData['tab3_jetty_info'] ?? [];

        $jettyData = [
            'state'      => CodeMaster::find($jettyDataRaw['state_id'])->name ?? '-',
            'district'   => CodeMaster::find($jettyDataRaw['district_id'])->name ?? '-',
            'jetty_name' => Jetty::find($jettyDataRaw['jetty_id'])->name ?? '-',
            'river'      => River::find($jettyDataRaw['river_id'])->name ?? '-',
        ];

        // Split equipment by type
        $equipmentList = collect($formData['tab4_equipment_info'] ?? []);

        $mainEquipment = $equipmentList
            ->filter(fn($item) => ($item['type'] ?? '') === 'main')
            ->values()
            ->all();

        $additionalEquipments = $equipmentList
            ->filter(fn($item) => ($item['type'] ?? '') === 'additional')
            ->values()
            ->all();

        // Build data array for PDF
        $data = [
            'personalInfo' => [
                'name'                   => $userDetail->name ?? '-',
                'identity_card_number'   => $userDetail->icno ?? '-',
                'phone_number'           => $userDetail->no_phone ?? '-',
                'secondary_phone_number' => $userDetail->secondary_phone_number ?? '-',
                'address' => implode(', ', array_filter([
                    $userDetail->address1 ?? null,
                    $userDetail->address2 ?? null,
                    $userDetail->address3 ?? null,
                ])) ?: '-',
                'postcode'               => $userDetail->poskod ?? '-',
                'district'               => $userDetail->district_name ?? '-',
                'state'                  => $userDetail->state ?? '-',
                // 'mailing_address'        => $userDetail->mailing_address ?? '-',
                // 'mailing_postcode'       => $userDetail->mailing_postcode ?? '-',
                // 'mailing_district'       => $userDetail->mailing_district ?? '-',
                // 'mailing_state'          => $userDetail->mailing_state ?? '-',
            ],
            'jettyData'            => $jettyData,
            'fishermanInfo'        => $formData['tab2_fisherman_info'],
            'mainEquipments'       => $mainEquipment,
            'additionalEquipments' => $additionalEquipments,
            'vesselData'           => $formData['tab5_vessel_info'],
        ];

        // Generate PDF

        $pdf = Pdf::loadView('app.NelayanDarat.kadPendaftaran.pemohon.print-application', $data)
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

    // NEW -------------------------------------------------------------------------------------------------

    public function viewTempEquipment(Request $request)
    {
        $userId = auth()->id();
        $type = strtoupper($request->query('type'));
        $index = (int) $request->query('index');

        if (!in_array($type, ['UTAMA', 'TAMBAHAN'])) {
            abort(400, 'Jenis peralatan tidak sah.');
        }

        $temp = darat_application_temp::where('user_id', $userId)
            ->where('status', 'draft')
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
        } elseif ($type === 'TAMBAHAN') {
            $additionalItems = $equipmentList->filter(fn($item) => $item['type'] === 'TAMBAHAN')->values();
            $filePath = $additionalItems[$index]['file_path'] ?? null;
        }

        if (!$filePath) {
            abort(404, 'Tiada fail tersedia.');
        }

        $fullPath = storage_path('app/public/' . ltrim($filePath, '/'));

        if (!file_exists($fullPath)) {
            abort(404, 'Fail tidak dijumpai.');
        }

        return response()->file($fullPath, [
            'Content-Type' => mime_content_type($fullPath),
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"',
        ]);
    }

    public function viewTempDocument(Request $request)
    {
        $title = $request->query('title');
        $userId = auth()->id();

        if (empty($title)) {
            abort(400, 'Parameter title diperlukan.');
        }

        $temp = darat_application_temp::where('user_id', $userId)
            ->whereIn('status', ['draft', 'pending'])
            ->latest()
            ->first();

        if (!$temp) {
            abort(404, 'Permohonan tidak dijumpai.');
        }

        $documentsData = json_decode($temp->form_data, true)['tab6_document'] ?? [];

        $doc = collect($documentsData)->firstWhere('title', $title);

        if (!$doc || empty($doc['file_path'])) {
            abort(404, 'Dokumen tidak dijumpai.');
        }

        $fullPath = storage_path('app/public/' . ltrim($doc['file_path'], '/'));

        if (!file_exists($fullPath)) {
            abort(404, 'Fail tidak dijumpai.');
        }

        $mimeType = File::mimeType($fullPath);

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($fullPath) . '"',
        ]);
    }

    // NEW -------------------------------------------------------------------------------------------------
}
