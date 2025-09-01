<?php

namespace App\Http\Controllers\NelayanDarat\lesenTahunan;

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

class permohonanController extends Controller
{
    protected $applicationTypeCode = '2';

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

        $negativeFeedback = ['201-1'];

        $draftFeedback = ['0'];

        $appealFeedback = ['211-2', '204-2']; // Get the results

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
        return view('app.NelayanDarat.lesenTahunan.pemohon.index', compact('applications', 'draftFeedback', 'negativeFeedback', 'appealFeedback', 'applicationType', 'moduleName', 'roleName'));
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

        return view('app.NelayanDarat.lesenTahunan.pemohon.create', compact(
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

        $userDetail = ProfileUsers::where('user_id', $user->id)
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

        dd($vessel, $hull, $engine);

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

        return view('app.NelayanDarat.lesenTahunan.pemohon.incomplete', compact(
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
                $query->whereIn('code', ['204-2', '211-2']);
            })
            ->first();

        $userDetail = ProfileUsers::where('user_id', $user->id)->where('is_active', 1)->first();

        return view('app.NelayanDarat.lesenTahunan.pemohon.appeal', compact(
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

    // public function storeAppeal(Request $request)
    // {

    //     DB::beginTransaction();

    //     try {

    //         $applicationId = $request->query('application');

    //         $application = darat_application::findOrFail($applicationId);

    //         $userId = $application->user_id;
    //         $now = now()->toDateTimeString();

    //         // Validate user input from Blade
    //         $request->validate([
    //             'appeal_text' => 'required|string|max:1000',
    //             'appeal_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
    //         ], [
    //             'appeal_text.required' => 'Sila nyatakan alasan rayuan.',
    //             '*.file' => 'Fail tidak sah atau melebihi had saiz.',
    //         ]);

    //         $status = 'pending';

    //         // Get or create temp
    //         $temp = darat_application_temp::firstOrCreate(
    //             ['user_id' => $userId, 'status' => $status],
    //             ['form_data' => json_encode([]), 'created_by' => $userId, 'updated_by' => $userId]
    //         );

    //         $data = json_decode($temp->form_data, true) ?? [];
    //         $documentsData = $data['tab6_document'] ?? [];

    //         if ($request->hasFile('appeal_attachment')) {
    //             $file = $request->file('appeal_attachment');
    //             $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
    //             $extension = $file->getClientOriginalExtension();
    //             $finalName = "{$originalName}_" . now()->format('Ymd_His') . ".{$extension}";
    //             $path = $file->storeAs('documents', $finalName, 'public');

    //             $documentsData[] = [
    //                 'application_type' => $this->applicationTypeCode ?? 'default',
    //                 'title'            => 'Dokumen Sokongan Rayuan',
    //                 'file_path'        => $path,
    //                 'original_name'    => $finalName,
    //                 'uploaded_at'      => now()->toDateTimeString(),
    //                 'type'             => 'optional',
    //             ];
    //         }

    //         $data['tab6_document'] = $documentsData;
    //         $temp->form_data = json_encode($data);
    //         $temp->updated_by = $userId;
    //         $temp->save();

    //         // Update temp to link to application
    //         darat_application_temp::where('user_id', $userId)
    //             ->where('status', 'pending')
    //             ->latest()
    //             ->update([
    //                 'application_id' => $applicationId,
    //                 'updated_by' => $userId,
    //             ]);

    //         $statusId = CodeMaster::where('type', 'application_status')->where('code', '209')->value('id');

    //         $application->update([
    //             'application_status_id' => $statusId,
    //             'updated_by'            => auth()->id(),
    //         ]);

    //         darat_application_log::create([
    //             'application_id' => $applicationId,
    //             'application_status_id' => $statusId,
    //             'remark' => $request->appeal_text,
    //             'created_by' => $userId,
    //         ]);

    //         DB::commit();

    //         return redirect()->route('lesenTahunan.permohonan-02.index')->with('success', 'Rayuan berjaya dihantar.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
    //     }
    // }

public function storeAppeal(Request $request)
{
    DB::beginTransaction();

    try {
        $applicationId = $request->query('application');
        $application = darat_application::findOrFail($applicationId);
        $userId = $application->user_id;

        // Validate input
        $request->validate([
            'appeal_text' => 'required|string|max:1000',
            'appeal_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'appeal_text.required' => 'Sila nyatakan alasan rayuan.',
            '*.file' => 'Fail tidak sah atau melebihi had saiz.',
        ]);

        $status = 'pending';

        // Fetch or create the temp record
        $temp = darat_application_temp::updateOrCreate(
            ['status' => $status,'application_id' => $application->id],
            ['form_data' => json_encode([]), 'created_by' => $userId, 'updated_by' => $userId]
        );

        



        $data = json_decode($temp->form_data ?? '{}', true);
        $documentsData = $data['tab6_document'] ?? [];

        if ($request->hasFile('appeal_attachment')) {
            $file = $request->file('appeal_attachment');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $timestamp = now()->format('Ymd_His');
            $finalName = "{$originalName}_{$timestamp}.{$extension}";
            $path = $file->storeAs('documents', $finalName, 'public');

            // Insert or replace document entry
            $found = false;
            foreach ($documentsData as &$doc) {
                if ($doc['title'] === 'Dokumen Sokongan Rayuan') {
                    $doc['file_path'] = $path;
                    $doc['original_name'] = $finalName;
                    $doc['uploaded_at'] = now()->toDateTimeString();
                    $doc['application_type'] = $this->applicationTypeCode ?? 'default';
                    $doc['type'] = 'optional';
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $documentsData[] = [
                    'application_type' => $this->applicationTypeCode ?? 'default',
                    'title'            => 'Dokumen Sokongan Rayuan',
                    'file_path'        => $path,
                    'original_name'    => $finalName,
                    'uploaded_at'      => now()->toDateTimeString(),
                    'type'             => 'optional',
                ];
            }
        }

        // Save back to temp
        $data['tab6_document'] = $documentsData;
        $temp->form_data = json_encode($data);
        $temp->updated_by = $userId;
        $temp->save();

        // Optional: associate temp to application
        $temp->update([
            'application_id' => $applicationId,
            'updated_by'     => $userId,
        ]);

        // Change application status
        $statusId = CodeMaster::where('type', 'application_status')->where('code', '209')->value('id');
        $application->update([
            'application_status_id' => $statusId,
            'updated_by' => auth()->id(),
        ]);

        // Log the appeal
        darat_application_log::create([
            'application_id' => $applicationId,
            'application_status_id' => $statusId,
            'remark' => $request->appeal_text,
            'created_by' => $userId,
        ]);

        DB::commit();
        return redirect()->route('lesenTahunan.permohonan-02.index')->with('success', 'Rayuan berjaya dihantar.');
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
                ->where('code', '201')
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
                return redirect()->route('lesenTahunan.permohonan-02.index')
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

            return redirect()->route('lesenTahunan.permohonan-02.index')
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
}
