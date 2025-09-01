<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\NelayanDarat\River;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RiverLakeController extends Controller
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

        $query = River::with(['district', 'state']);

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $riverList = $query->get();

        return view('app.master_data.riverLake.index', compact('riverList', 'states', 'districts'));
    }

    public function create(Request $request)
    {
        $states = CodeMaster::where('type', 'state')->pluck('name', 'id');

        return view('app.master_data.riverLake.create', compact(
            'states'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|uuid|exists:code_masters,id',
            'district_id' => 'required|uuid|exists:code_masters,id',
        ], [
            'name.required' => 'Nama Sungai / Tasik diperlukan.',
            'state_id.required' => 'Sila pilih negeri.',
            'district_id.required' => 'Sila pilih daerah.',
        ]);

        DB::beginTransaction();

        try {
            River::create([
                'name' => $request->name,
                'state_id' => $request->state_id,
                'district_id' => $request->district_id,
                'is_active' => true,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            DB::commit();

            return redirect()->route('master-data.river-lake.index')->with('success', 'Sungai / Tasik berjaya ditambah.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withInput()->withErrors(['error' => 'Ralat : ' . $e->getMessage()]);
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
