<?php

namespace App\Http\Controllers\NelayanDarat\pindahPangkalan;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\darat_application;
use App\Models\darat_item_found;
use App\Models\darat_user_equipment;
use App\Models\darat_vessel;
use App\Models\darat_vessel_inspection;
use App\Models\darat_user_detail;
use App\Models\darat_application_temp;
use App\Models\darat_application_log;
use App\Models\darat_base_jetties;
use App\Models\darat_document;
use App\Models\darat_equipment_list;
use App\Models\darat_user_fisherman_info;
use App\Models\darat_vessel_hull_history;
use App\Models\darat_vessel_hull;
use App\Models\darat_vessel_engine_history;
use App\Models\darat_vessel_engine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class laporanLpiController extends Controller
{

    protected $applicationTypeCode = '3';

    public function index()
    {
        $user     = Auth::user();
        $roleName = $user->roles()->pluck('name')->first();

        $positiveFeedback = ['304'];
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

        return view('app.NelayanDarat.pindahPangkalan.pegawai.3_laporanLpi.index', compact(
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
        $userDetail = darat_user_detail::where('user_id', $user->id)->where('is_active', 1)->first();

        // Fetch the types of fishing equipment (jenis_peralatan)
        $jenisPeralatan = darat_equipment_list::where('is_active', true)->pluck('name', 'name');

        // Retrieve the temporary application data (form data)
        $temp = darat_application_temp::where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        $formData = json_decode($temp->form_data ?? '{}', true);

        // Retrieve the specific data from the form_data
        $fishermanInfo = $formData['tab2_fisherman_info'] ?? [];

        $jettyInfo = $formData['tab3_jetty_info'] ?? null;

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

        // == Off Data ==
        $fishermanInfoOff = darat_user_fisherman_info::where('user_id', $user->id)->where('is_active', 1)->first();
        $aidAgencyOff = $user->fishermanInfo?->aidAgencies ?? collect();
        $jettyOff = darat_base_jetties::where('user_id', $user->id)->where('is_active', 1)->first();
        $equipmentOff = darat_user_equipment::where('user_id', $user->id)->where('is_active', 1)->get();
        $vesselOff = darat_vessel::where('user_id', $user->id)->where('is_active', 1)->first();
        $documentOff = darat_document::where('user_id', $user->id)->where('application_type', $this->applicationTypeCode)->where('is_active', 1)->get();
        $inspectionOff = darat_vessel_inspection::where('vessel_id', $vesselOff->id)->where('is_active', 1)->first();

        $vesselInfoOff = darat_vessel::with(['hull', 'engine'])
            ->where('user_id', $user->id)
            ->where('is_active', 1)
            ->first();

        return view('app.NelayanDarat.pindahPangkalan.pegawai.3_laporanLpi.create', compact(
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
            'equipmentList',
            'mainEquipment',
            'additionalEquipments',
            'equipmentList',
            'foundEquipments',

            // == Off ==
            'fishermanInfoOff',
            'aidAgencyOff',
            'jettyOff',
            'equipmentOff',
            'vesselOff',
            'vesselInfoOff',
            'documentOff'
        ));
    }

    public function storeMaklumatVesel(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'vessel_origin'                => 'nullable|in:1,2',
                'jenis_kulit'                 => 'nullable|string',
                'ditebuk'                     => 'nullable|in:0,1',
                'dicat_dengan_terang'         => 'nullable|in:0,1',
                'no_pendaftaran_vesel_ulasan' => 'nullable|string',
                'panjang'                     => 'nullable|numeric',
                'lebar'                       => 'nullable|numeric',
                'dalam'                       => 'nullable|numeric',
                'overall_image_path'          => 'nullable|image|mimes:jpg,jpeg,png|max:2047',
            ]);

            $application = darat_application::findOrFail($id);

            $user = $application->user;

            $vessel = darat_vessel::where('user_id', $user->id)
                ->where('is_active', true)
                ->first();

            $inspection = darat_vessel_inspection::updateOrCreate(
                ['application_id' => $application->id, 'user_id' => $user->id,],
                [
                    'vessel_id'                   => $vessel?->id,
                    'vessel_origin'               => $request->vessel_origin,
                    'hull_type'                   => $request->jenis_kulit,
                    'drilled'                     => $request->ditebuk,
                    'brightly_painted'            => $request->dicat_dengan_terang,
                    'vessel_registration_remarks' => $request->no_pendaftaran_vesel_ulasan,
                    'length'                      => $request->panjang,
                    'width'                       => $request->lebar,
                    'depth'                       => $request->dalam,
                    'updated_by'                  => auth()->id(),
                    'created_by'                  => auth()->id(),
                    'is_active' => false,

                ]
            );

            if ($request->hasFile('overall_image_path')) {
                $file = $request->file('overall_image_path');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('inspection', $filename, 'public');

                $inspection->update([
                    'overall_image_path' => $path,
                ]);
            }

            $temp = darat_application_temp::where('application_id', $application->id)
                ->where('status', 'pending')
                ->latest()
                ->first();

            if ($temp) {
                $formData = json_decode($temp->form_data ?? '{}', true);

                $existingVesselInfo = $formData['tab5_vessel_info'] ?? [];

                $formData['tab5_vessel_info'] = array_merge($existingVesselInfo, [
                    'vessel_origin'               => $request->vessel_origin,
                    'hull_type'                   => $request->jenis_kulit,
                    'drilled'                     => $request->ditebuk,
                    'brightly_painted'            => $request->dicat_dengan_terang,
                    'vessel_registration_remarks' => $request->no_pendaftaran_vesel_ulasan,
                    'length'                      => $request->panjang,
                    'width'                       => $request->lebar,
                    'depth'                       => $request->dalam,
                    'overall_image_path'          => $inspection->overall_image_path ?? null,
                ]);

                $temp->update([
                    'form_data'  => json_encode($formData),
                    'updated_by' => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function storeMaklumatEnjin(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $application = darat_application::findOrFail($id);
            $user = $application->user;

            $request->validate([
                'engine_brand'             => 'nullable|string|max:255',
                'engine_model'             => 'nullable|string|max:255',
                'horsepower'               => 'nullable|string|max:255',
                'engine_number'            => 'nullable|string|max:255',
                'engine_image_path'        => 'nullable|image|mimes:jpg,jpeg,png|max:2047',
                'engine_number_image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2047',
            ]);

            $inspection = darat_vessel_inspection::where('application_id', $application->id)->first();

            $engineImagePath       = $inspection->engine_image_path ?? null;
            $engineNumberImagePath = $inspection->engine_number_image_path ?? null;

            if ($request->hasFile('engine_image_path')) {
                $file            = $request->file('engine_image_path');
                $filename        = time() . '_' . $file->getClientOriginalName();
                $engineImagePath = $file->storeAs('inspection', $filename, 'public');
            }

            if ($request->hasFile('engine_number_image_path')) {
                $file                  = $request->file('engine_number_image_path');
                $filename              = time() . '_' . $file->getClientOriginalName();
                $engineNumberImagePath = $file->storeAs('inspection', $filename, 'public');
            }

            darat_vessel_inspection::updateOrCreate(
                ['application_id' => $application->id, 'user_id' => $user->id,],
                [
                    'engine_brand'             => $request->engine_brand,
                    'engine_model'             => $request->engine_model,
                    'horsepower'               => $request->horsepower,
                    'engine_number'            => $request->engine_number,
                    'engine_image_path'        => $engineImagePath,
                    'engine_number_image_path' => $engineNumberImagePath,
                    'updated_by'               => auth()->id(),
                    'created_by'               => $inspection?->created_by ?? auth()->id(),
                    'is_active' => false,

                ]
            );

            // Get or create temp row
            $temp = darat_application_temp::firstOrCreate(
                ['application_id' => $application->id, 'status' => 'pending'],
                ['form_data' => json_encode([]), 'created_by' => auth()->id()]
            );

            // Decode and update form data
            $formData = json_decode($temp->form_data ?? '{}', true);

            $formData['tab5_vessel_info'] = array_merge($formData['tab5_vessel_info'] ?? [], [
                'engine_brand'              => $request->engine_brand,
                'engine_model'              => $request->engine_model,
                'horsepower'                => $request->horsepower,
                'engine_number'             => $request->engine_number,
                'engine_image_path'         => $engineImagePath,
                'engine_number_image_path'  => $engineNumberImagePath,

            ]);

            $temp->form_data = json_encode($formData);
            $temp->updated_by = auth()->id();
            $temp->save();

            DB::commit();

            return back()->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function storePeralatanKeselamatan(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $application = darat_application::findOrFail($id);
            $user = $application->user;

            $request->validate([
                'safety_jacket_status'     => 'required|in:0,1',
                'safety_jacket_quantity'   => 'nullable|integer|min:0',
                'safety_jacket_condition'  => 'nullable|string',
                'safety_jacket_image_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2047',
            ]);

            $inspection = darat_vessel_inspection::where('application_id', $application->id)->first();

            $imagePath = $inspection?->safety_jacket_image_path;

            if ($request->hasFile('safety_jacket_image_path')) {
                $file      = $request->file('safety_jacket_image_path');
                $filename  = time() . '_' . $file->getClientOriginalName();
                $imagePath = $file->storeAs('inspection', $filename, 'public');
            }

            darat_vessel_inspection::updateOrCreate(
                ['application_id' => $application->id,  'user_id'                   => $user->id,],
                [
                    'safety_jacket_status'     => $request->safety_jacket_status,
                    'safety_jacket_quantity'   => $request->safety_jacket_status == '1' ? $request->safety_jacket_quantity : null,
                    'safety_jacket_condition'  => $request->safety_jacket_status == '1' ? $request->safety_jacket_condition : null,
                    'safety_jacket_image_path' => $request->safety_jacket_status == '1' ? $imagePath : null,
                    'updated_by'               => auth()->id(),
                    'created_by'               => $inspection?->created_by ?? auth()->id(),
                    'is_active' => false,

                ]
            );

            DB::commit();

            return back()->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function storePeralatanMenangkapIkan(Request $request, $id)
    {
        DB::beginTransaction();

        $application = darat_application::findOrFail($id);
        $inspection = darat_vessel_inspection::where('application_id', $application->id)->firstOrFail();
        $inspectionId = $inspection->id;
        $userId = $application->user_id;

        try {
            // Validate incoming request
            $validated = $request->validate([
                'main' => 'required|array',
                'main.*.name' => 'required|string|max:255',
                'main.*.quantity' => 'required|integer|min:1',
                'main.*.condition' => 'required|string|max:255',
                'main.*.file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:5120',

                'additional' => 'nullable|array|max:5',
                'additional.*.name' => 'nullable|string|max:255',
                'additional.*.quantity' => 'nullable|integer|min:1',
                'additional.*.condition' => 'nullable|string|max:255',
                'additional.*.file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:5120',

                'found_item_name' => 'nullable|array',
                'found_item_name.*' => 'nullable|string|max:255',
                'found_item_quantity' => 'nullable|array',
                'found_item_quantity.*' => 'nullable|integer|min:1',
            ]);


            // Get or create temp application
            $temp = darat_application_temp::firstOrCreate(
                ['application_id' => $application->id, 'status' => 'pending'],
                ['form_data' => json_encode([]), 'created_by' => $userId, 'updated_by' => $userId]
            );

            $data = json_decode($temp->form_data ?? '{}', true);
            $equipment = [];

            // Process Main Equipment
            $existingMain = collect($data['tab4_equipment_info'] ?? [])
                ->filter(fn($e) => $e['type'] === 'main')
                ->values();

            foreach ($validated['main'] as $index => $main) {
                $entry = $existingMain[$index] ?? ['type' => 'main'];

                // Only add valid data to the equipment array
                if (!empty($main['name']) && !empty($main['quantity']) && !empty($main['condition'])) {
                    $entry['name'] = $main['name'];
                    $entry['quantity'] = $main['quantity'];
                    $entry['condition'] = $main['condition'];

                    if ($request->hasFile("main.$index.file")) {
                        $file = $request->file("main.$index.file");
                        $originalName = $file->getClientOriginalName();
                        $uniqueName = time() . '_' . $originalName;
                        $filePath = $file->storeAs("equipment", $uniqueName, 'public');

                        $entry['file_path'] = $filePath;
                    }

                    $equipment[] = $entry;
                }
            }

            // Process Additional Equipment
            $existingAdditional = collect($data['tab4_equipment_info'] ?? [])
                ->filter(fn($e) => $e['type'] === 'additional')
                ->values();

            foreach ($validated['additional'] as $index => $additional) {
                $entry = $existingAdditional[$index] ?? ['type' => 'additional'];

                // Only add valid data to the equipment array
                if (!empty($additional['name']) && !empty($additional['quantity']) && !empty($additional['condition'])) {
                    $entry['name'] = $additional['name'];
                    $entry['quantity'] = $additional['quantity'];
                    $entry['condition'] = $additional['condition'];

                    if ($request->hasFile("additional.$index.file")) {
                        $file = $request->file("additional.$index.file");
                        $originalName = $file->getClientOriginalName();
                        $uniqueName = time() . '_' . $originalName;
                        $filePath = $file->storeAs("equipment", $uniqueName, 'public');

                        $entry['file_path'] = $filePath;
                    }

                    $equipment[] = $entry;
                }
            }

            // Save Equipment Data
            if (!empty($equipment)) {
                $data['tab4_equipment_info'] = $equipment;
                $temp->form_data = json_encode($data);
                $temp->updated_by = $userId;
                $temp->save();
            }

            // Clear Previous Found Items
            darat_item_found::where('application_id', $application->id)->delete();

            // Insert New Found Items
            if (!empty($validated['found_item_name'])) {
                foreach ($validated['found_item_name'] as $index => $itemName) {
                    darat_item_found::updateOrCreate(
                        [
                            'application_id' => $application->id,
                            'item' => $itemName,
                        ],
                        [

                            'inspection_id' => $inspection->id,
                            'quantity' => $validated['found_item_quantity'][$index],
                            'is_active' => true,
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id(),
                        ]
                    );
                }
            }

            DB::commit();
            return back()->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ralat: ' . $e->getMessage());
        }
    }

    public function storePengesahanPemeriksaan(Request $request, $id)
    {
        DB::beginTransaction();

        $application = darat_application::findOrFail($id);
        $user = $application->user;
        $inspection = darat_vessel_inspection::where('application_id', $application->id)->firstOrFail();

        try {
            $application = darat_application::findOrFail($id);

            $request->validate([
                'keadaan_vesel'              => 'required|string|max:255',
                'inspection_date'            => 'required|date',
                'inspection_location'        => 'required|string|max:255',
                'is_support'                 => 'required|in:1,0',
                'inspection_summary'         => 'nullable|string',

                'attendance_form_path'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2047',
                'vessel_image_path'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2047',
                'inspector_owner_image_path' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2047',
            ]);

            $attendanceForm = $inspection->attendance_form_path ?? null;
            $vesselImage    = $inspection->vessel_image_path ?? null;
            $ownerImage     = $inspection->inspector_owner_image_path ?? null;

            if ($request->hasFile('attendance_form_path')) {
                $file = $request->file('attendance_form_path');
                $originalName = $file->getClientOriginalName();
                $uniqueName = time() . '_' . $originalName;
                $attendanceForm = $file->storeAs('inspection', $uniqueName, 'public');
            }

            if ($request->hasFile('vessel_image_path')) {
                $file = $request->file('vessel_image_path');
                $originalName = $file->getClientOriginalName();
                $uniqueName = time() . '_' . $originalName;
                $vesselImage = $file->storeAs('inspection', $uniqueName, 'public');
            }

            if ($request->hasFile('inspector_owner_image_path')) {
                $file = $request->file('inspector_owner_image_path');
                $originalName = $file->getClientOriginalName();
                $uniqueName = time() . '_' . $originalName;
                $ownerImage = $file->storeAs('inspection', $uniqueName, 'public');
            }

            // Set valid_date based on inspection_date
            $validDate = Carbon::parse($request->inspection_date)->addMonths(6)->toDateString();

            darat_vessel_inspection::updateOrCreate(
                ['application_id' => $application->id, 'user_id'                   => $user->id,],
                [

                    'vessel_condition'           => $request->keadaan_vesel,
                    'inspection_date'            => $request->inspection_date,
                    'valid_date'                 => $validDate,
                    'inspection_location'        => $request->inspection_location,
                    'is_support'                 => $request->is_support,
                    'inspection_summary'         => $request->inspection_summary,
                    'attendance_form_path'       => $attendanceForm,
                    'vessel_image_path'          => $vesselImage,
                    'inspector_owner_image_path' => $ownerImage,
                    'is_active' => false,

                    'updated_by'                 => auth()->id(),
                    'created_by'                 => $inspection?->created_by ?? auth()->id(),
                ]
            );

            DB::commit();

            return redirect()->back()->with('success', 'Berjaya disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ralat: ' . $e->getMessage());
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
            $statusCode = 305;
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

            return redirect()->route('pindahPangkalan.laporanLpi-03.index')
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
}
