<?php

namespace App\Http\Controllers\NelayanDarat\kadPendaftaran;

use App\Http\Controllers\Controller;
use App\Models\CatchingLocation_nd;
use App\Models\CodeMaster;
use App\Models\darat_application;
use App\Models\darat_application_log;
use App\Models\darat_base_jetties;
use App\Models\darat_base_jetty_history;
use App\Models\darat_document;
use App\Models\darat_fault_record;
use App\Models\NelayanDarat\darat_inspection_equipment;
use App\Models\ProfileUsers;
use App\Models\darat_user_equipment;
use App\Models\darat_payment_receipt_item;
use App\Models\darat_payment_receipt;
use App\Models\darat_user_equipment_history;
use App\Models\darat_user_fisherman_info;
use App\Models\darat_vessel;
use App\Models\darat_vessel_engine;
use App\Models\darat_application_temp;
use App\Models\darat_vessel_hull;
use App\Models\darat_vessel_inspection;
use App\Models\FishingLog_nd;
use App\Models\FishLanding_nd;
use App\Models\Entity;
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingInfo;
use App\Models\NelayanDarat\Jetty;
use App\Models\NelayanDarat\River;
use App\Models\SalesRecord_nd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class resitPembayaranController extends Controller
{

    protected $applicationTypeCode = '8';

    public function index()
    {
        $user     = Auth::user();
        $roleName = $user->roles()->pluck('name')->first();

        $positiveFeedback = ['808'];
        $negativeFeedback = ['809-1'];
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

        return view('app.NelayanDarat.kadPendaftaran.pegawai.9_resitPembayaran.index', compact(
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
            ->orderBy('created_at', 'asc')
            ->get();

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

        $receipt = darat_payment_receipt::where('application_id', $application->id)
            ->where('is_active', false)->first();

        $receiptItems = $receipt ? $receipt->items : collect();

        $inspection = darat_vessel_inspection::where('user_id', $user->id)
            ->where('is_active', 1)
            ->get();

        return view('app.NelayanDarat.kadPendaftaran.pegawai.9_resitPembayaran.create', compact(
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
            'declarations',
            'receipt',
            'receiptItems',
            'inspection'
        ));
    }

    public function store(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $application = darat_application::findOrFail($id);

            $request->validate([
                'receipt_number' => 'required|string|max:255',
                'date'           => 'required|date',
                'total_amount'   => 'required|numeric|min:0',
                'receipt_file'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'item_name'      => 'nullable|array|min:1',
                'item_name.*'    => 'nullable|string|max:255',
                'price'          => 'nullable|array',
                'price.*'        => 'nullable|numeric|min:0',
            ]);

            // Handle file upload (if present)
            $filePath = null;
            if ($request->hasFile('receipt_file')) {
                $file = $request->file('receipt_file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('receipts', $filename, 'public');
            }

            // Prepare update data
            $updateData = [
                'receipt_number'      => $request->receipt_number,
                'payment_date'        => $request->date,
                'amount'              => $request->total_amount,
                'created_by'          => auth()->id(),
                'is_active'           => false,
            ];

            // Only update file path if a new file was uploaded
            if ($filePath) {
                $updateData['uploaded_file_path'] = $filePath;
            }

            // Create or update the receipt record
            $receipt = darat_payment_receipt::updateOrCreate(
                ['application_id' => $application->id],
                $updateData
            );

            // Remove old items and insert new ones
            $receipt->items()->delete();

            if (is_array($request->item_name)) {
                foreach ($request->item_name as $index => $name) {
                    $price = $request->price[$index] ?? 0;

                    if (!empty($name)) {
                        darat_payment_receipt_item::updateOrCreate(
                            [
                                'receipt_id' => $receipt->id,
                                'item_name'  => $name,
                            ],
                            [
                                'price'      => $price,
                                'created_by' => auth()->id(),
                                'is_active'  => false,
                            ]
                        );
                    }
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function submit($id)
    {
        DB::beginTransaction();

        try {
            $application = darat_application::findOrFail($id);

            $receipt = darat_payment_receipt::where('application_id', $application->id)->first();

            // If receipt exists, activate it and its items
            if ($receipt) {
                $receipt->update(['is_active' => true]);
                $receipt->items()->update(['is_active' => true]);
            }

            // Update application status
            $statusCode = '809';
            $statusId = CodeMaster::where('type', 'application_status')
                ->where('code', $statusCode)
                ->value('id');

            $application->update([
                'application_status_id' => $statusId,
                'updated_by'            => auth()->id(),
            ]);

            // Log submission
            darat_application_log::create([
                'application_id'        => $application->id,
                'application_status_id' => $statusId,
                'created_by'            => auth()->id(),
                'is_active'             => true,
            ]);

            DB::commit();

            return redirect()->route('kadPendaftaran.resitBayaran-08.index')
                ->with('success', 'Berjaya dihantar');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function viewReceipt(Request $request)
    {
        $receiptId = $request->query('receipt_id');

        $receiptFile = darat_payment_receipt::where('id', $receiptId)->latest()->first();

        if (!$receiptFile || empty($receiptFile->uploaded_file_path)) {
            abort(404, 'Resit tidak dijumpai atau fail tiada.');
        }

        $filePath = ltrim($receiptFile->uploaded_file_path, '/');

        // Ensure the file exists in the 'public' disk
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'Fail tidak dijumpai dalam storan.');
        }

        // Return file for inline viewing
        return response()->file(
            Storage::disk('public')->path($filePath),
            [
                'Content-Type' => Storage::disk('public')->mimeType($filePath),
                'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
            ]
        );
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
