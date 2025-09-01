<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Entity;
use Illuminate\Http\Request;

use App\Models\NelayanDarat\Jetty;
use App\Models\NelayanDarat\state_office_mapping;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FisherisOfficeController extends Controller
{
    public function index(Request $request)
    {
        $states = CodeMaster::where('type', 'state')->pluck('name', 'id');

        $districts = [];
        if ($request->filled('state_id')) {
            $districts = CodeMaster::where('type', 'district')
                ->where('parent_id', $request->state_id)
                ->pluck('name', 'id');
        }

        $query = state_office_mapping::with(['district', 'state', 'officeName']);

        if ($request->filled('name')) {
            $query->whereHas('officeName', function ($q) use ($request) {
                $q->where('entity_name', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        $stateOffice = $query->get();

        return view('app.master_data.fisheriesOffice.index', compact('stateOffice', 'states', 'districts'));
    }

    public function create(Request $request)
    {
        $states = CodeMaster::where('type', 'state')->pluck('name', 'id');

        $stateOffices = Entity::where('entity_level', '2')->pluck('id', 'entity_name');
        $districtOffices = Entity::where('entity_level', '4')->pluck('id', 'entity_name');

        return view('app.master_data.fisheriesOffice.create', compact(
            'states',
            'stateOffices',
            'districtOffices'
        ));
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try {

            $rules = [
                'state_id' => 'required|uuid|exists:code_masters,id',
                'district_id' => 'nullable|uuid|exists:code_masters,id',
                'office_type' => 'required|in:state,district',
            ];

            // Conditional validation based on office_type
            if ($request->office_type === 'state') {
                $rules['negeri_office_id'] = 'required|uuid|exists:entities,id';
            } elseif ($request->office_type === 'district') {
                $rules['negeri_office_id'] = 'required|uuid|exists:entities,id';
                $rules['daerah_office_id'] = 'required|uuid|exists:entities,id';
            }

            $messages = [
                'state_id.required' => 'Sila pilih negeri.',

                'office_type.required' => 'Sila pilih jenis pejabat.',
                'negeri_office_id.required' => 'Sila pilih Pejabat Perikanan Negeri.',
                'daerah_office_id.required' => 'Sila pilih Pejabat Perikanan Daerah.',
            ];

            $request->validate($rules, $messages);

            state_office_mapping::create([
                'state_id' => $request->state_id,
                'district_id' => $request->district_id,
                'office_id' => $request->office_type === 'state'
                    ? $request->negeri_office_id
                    : $request->daerah_office_id,
                'parent_id' => $request->office_type === 'district'
                    ? $request->negeri_office_id
                    : null,
                'is_active' => true,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            DB::commit();

            return redirect()->route('master-data.fisheries-office.index')
                ->with('success', 'Pemetaan pejabat berjaya ditambah.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()
                ->withErrors(['error' => 'Ralat: ' . $e->getMessage()]);
        }
    }

    public function getDistricts($state_id)
    {
        // Filter CodeMaster by type and parent_id (state)
        $districts = CodeMaster::where('type', 'district')
            ->where('parent_id', $state_id)
            ->pluck('name', 'id');

        // Return as JSON
        return response()->json($districts);
    }
}
