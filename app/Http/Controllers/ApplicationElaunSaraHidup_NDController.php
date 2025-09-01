<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationESHRequest;
use App\Models\ESH\ApplicationElaunSaraHidup_ND;
use App\Models\ESH\ApplicationElaunSaraHidup_ND_Dokumen;
use App\Models\ProfileUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\FileUploadService;

class ApplicationElaunSaraHidup_NDController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    /**
     * Display the application form.
     */
    public function index()
    {
        $application = ProfileUsers::where('icno', auth()->user()->username)->first();
        return view('app.application.elaunsarahidup.form', compact('application'));
    }

    /**
     * Store a new application.
     */
    public function store(Request $request, $applicationId = null)
    {
        DB::beginTransaction();

        try {
            // Create application
            $application = ApplicationElaunSaraHidup_ND::create([
                'user_id' => auth()->id(),
                ...$request->validate([
                    'bank_name' => 'required|string|max:255',
                    'bank_account_number' => 'required|string|unique:fisherman_profiles,bank_account_number',
                    'bank_branch' => 'required|string|max:255',
                    'income_fishing' => 'required|numeric|min:0',
                    'income_other' => 'nullable|numeric|min:0',
                    'children_count' => 'required|integer|min:0',
                    'education_level' => 'required|in:none,primary,secondary,tertiary',
                    'agreement' => 'required|boolean',

                    // Document uploads
                    'documents.*.file_type' => 'required|in:bank,kwsp,aadk,support',
                    'documents.*.file_desc' => 'nullable|string',
                    'documents.*.file' => 'required|file|mimes:pdf,jpg,png|max:2048',
                ])
            ]);

            // Handle document uploads
            if ($request->has('documents')) {
                $this->handleDocumentUploads($request->file('documents'), $application);
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Permohonan telah berjaya disimpan',
                'data' => $application,
                // 'redirect' => route('dashboard')
            ], 201);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            Log::error('Database error during ESH application: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Ralat pangkalan data. Sila cuba lagi.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Application ESH store error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan permohonan. Sila cuba lagi.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Retrieve list of applications for the authenticated user's entity.
     */
    public function listAllApplication()
    {
        $user = auth()->user();
        $userRole = $user->roles->first();
        $entityId = $user->entity_id ?? null;

        if (!$userRole || is_null($entityId)) {
            return response()->json(['message' => 'User has no assigned roles or entity'], 403);
        }

        try {
            $applications = ApplicationElaunSaraHidup_ND::where('entity_id', $entityId)
                ->with('user:id,name,email')
                ->paginate(10);

            return response()->json(['data' => $applications]);
        } catch (\Exception $e) {
            Log::error('Application list retrieval error: ' . $e->getMessage());

            return response()->json([
                'error' => 'Something went wrong while fetching applications',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle document uploads
     */
    private function handleDocumentUploads($documentFiles, $application)
    {
        $documents = [];

        foreach ($documentFiles as $doc) {
            if (!isset($doc['file']) || !$doc['file']->isValid()) {
                continue;
            }

            $filePath = $this->fileUploadService->uploadFile(
                $doc['file'],
                'public/esh',
                true
            );

            $documents[] = [
                'application_esh_id' => $application->id,
                'file_type' => $doc['file_type'],
                'file_desc' => $doc['file_desc'] ?? null,
                'file_name' => $doc['file']->getClientOriginalName(),
                'file_path' => $filePath,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($documents)) {
            ApplicationElaunSaraHidup_ND_Dokumen::insert($documents);
        }
    }
}
