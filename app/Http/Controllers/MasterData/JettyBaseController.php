<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Parliament;
use App\Models\ParliamentSeat;
use Illuminate\Http\Request;

use App\Models\NelayanDarat\Jetty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JettyBaseController extends Controller
{
    public function index(Request $request)
    {
        // Get all states
        $states = CodeMaster::where('type', 'state')->pluck('name', 'id');

        // Get districts if state is selected
        $districts = [];
        if ($request->filled('state_id')) {
            $districts = CodeMaster::where('type', 'district')
                ->where('parent_id', $request->state_id)
                ->pluck('name', 'id');
        }

        // Get parliaments for dropdown
        $parliaments = Parliament::pluck('parliament_name', 'id');

        // Get DUNs if parliament is selected
        $duns = [];
        if ($request->filled('parliament_id')) {
            $duns = ParliamentSeat::where('parliament_id', $request->parliament_id)
                ->pluck('parliament_seat_name', 'id');
        }

        // Build query
        $query = Jetty::with(['district', 'state', 'parliament', 'dun']);

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('district_id')) {
            $query->where('district_id', $request->district_id);
        }

        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        if ($request->filled('parliament_id')) {
            $query->where('parliament_id', $request->parliament_id);
        }

        if ($request->filled('dun_id')) {
            $query->where('dun_id', $request->dun_id);
        }

        $jettyList = $query->get();

        return view('app.master_data.jettyBase.index', compact(
            'jettyList',
            'states',
            'districts',
            'parliaments',
            'duns'
        ));
    }


    public function create(Request $request)
    {
        $states = CodeMaster::where('type', 'state')->pluck('name', 'id');

        return view('app.master_data.jettyBase.create', compact(
            'states'
        ));
    }

    public function store(Request $request)
    {

      
        $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|uuid|exists:code_masters,id',
            'district_id' => 'required|uuid|exists:code_masters,id',
            'parliament_id' => 'required|uuid|exists:parliaments,id',
            'dun_id' => 'required|uuid|exists:parliament_seats,id',
        ], [
            'name.required' => 'Nama jeti / pangkalan diperlukan.',
            'state_id.required' => 'Sila pilih negeri.',
            'district_id.required' => 'Sila pilih daerah.',
            'parliament_id.required' => 'Sila pilih parlimen.',
            'dun_id.required' => 'Sila pilih DUN.',
        ]);

           

        DB::beginTransaction();

        try {
            Jetty::create([
                'name' => $request->name,
                'state_id' => $request->state_id,
               'district_id' => $request->district_id,
               'parliament_id' => $request->parliament_id,
                'parliament_seat_id' => $request->dun_id,
              'is_active' => true,
              'created_by' => Auth::id(),
               'updated_by' => Auth::id(),
            ]);

 

            DB::commit();

            return redirect()->route('master-data.jetty-base.index')
                ->with('success', 'Jeti / Pangkalan berjaya ditambah.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Ralat : ' . $e->getMessage()]);
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

    public function getParliaments($state_id)
    {
        $parliaments = Parliament::where('state_id', $state_id)
            ->whereNull('deleted_at') // optional: respect soft delete
            ->pluck('parliament_name', 'id');

        return response()->json($parliaments);
    }

    public function getDuns($parliament_id)
    {
        $duns = ParliamentSeat::where('parliament_id', $parliament_id)
            ->whereNull('deleted_at') // ensure only active records
            ->pluck('parliament_seat_name', 'id'); // display name as label, ID as value

        return response()->json($duns);
    }
}
