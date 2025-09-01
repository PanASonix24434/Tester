<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Entity;
use App\Models\Systems\AuditLog;
use App\Models\User;
use App\Models\Vessel;
use Illuminate\Http\Request;

use Auth;
use Exception;
use DB;

class TempVesselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Vessel::sortable();

        return view('app.tempVessel.index', [
            'data' => $request->has('sort') ? $data->paginate(10) : $data->orderBy('no_pendaftaran')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereNot('username','111111111111')->orderBy('name')->get();
        $equipments = CodeMaster::where('type','peralatan')->get();
        $entities = Entity::where('entity_level','4')->get();
        return view('app.tempVessel.create', [
            'users' => $users,
            'equipments' => $equipments,
            'entities' => $entities,
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        DB::beginTransaction();

        try {
            $data = new Vessel();
            $data->user_id = $request->selOwner;
            $data->zon = $request->selZon;
            $data->grt = $request->grt;
            $data->peralatan_utama = $request->selEquipment;
            $data->no_pendaftaran = $request->vesselNumber;
            $data->vessel_no = $request->vesselNumber;
            $data->license_end = $request->dateEnd;
            $data->entity_id = $request->selEntity;
            $data->created_by = Auth::id();
            $data->updated_by = Auth::id();
            $data->save();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
                'action' => $request->action,
                'applicationStatus' => $request->applicationStatus,
                // 'remark' => $request->remark,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('tempvesel', 'store', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Data gagal dicipta !!');
        }

        return redirect()->action('TempVesselController@index')->with('alert', 'Data berjaya dicipta !!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $vessel = Vessel::find($id);

        try {
            $vessel->deleted_by = request()->user()->id;
            $vessel->save();
            $vessel->delete();
        }
        catch (Exception $e) {
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('TempVesselController@index')->with('alert', 'Data berjaya dihapus !!');
    }
}
