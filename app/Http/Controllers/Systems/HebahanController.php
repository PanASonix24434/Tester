<?php

namespace App\Http\Controllers\Systems;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Hebahan;
use App\Models\Entity;
use App\Models\Authorization\Role;

use Auth;
use Audit;
use Hash;
use DB;
use Exception;
use Carbon\Carbon;
use PDF;
use Storage;
use Image;
use Helper;

class HebahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $hebahan = Hebahan::whereNull('hebahans.deleted_by')
        ->leftjoin('roles','hebahans.role_id','=','roles.id')
        ->select('hebahans.*', 'roles.name');

        $filterStartDate = !empty($request->txtStartDate) ? $request->txtStartDate : '';
        $filterEndDate = !empty($request->txtEndDate) ? $request->txtEndDate : '';
        $filterTitle = !empty($request->txtTitle) ? $request->txtTitle : '';
        $filterDesc = !empty($request->txtDesc) ? $request->txtDesc : '';

        if(!empty($filterStartDate)){
            $filterStartDate = Carbon::createFromFormat('Y-m-d', $filterStartDate);
            $hebahan->whereDate('tarikh', '>=', $filterStartDate);
        }

        if(!empty($filterEndDate)){
            $filterEndDate = Carbon::createFromFormat('Y-m-d', $filterEndDate);
            $hebahan->whereDate('tarikh', '<=', $filterEndDate);
        }

        if (!empty($filterTitle)) {
            $hebahan->where('tajuk', 'like', '%'.$filterTitle.'%');
        }

        if (!empty($filterDesc)) {
            $hebahan->where('kandungan', 'like', '%'.$filterDesc.'%');
        }

        return view('app.admin.hebahan.index', [		
            'q' => '',
            'hebahan' => $hebahan->orderBy('tarikh', 'DESC')->paginate(10),
            'filterStartDate' => !empty($filterStartDate) ? $filterStartDate->format('Y-m-d') : '',
            'filterEndDate' => !empty($filterEndDate) ? $filterEndDate->format('Y-m-d') : '',
            'filterTitle' => !empty($filterTitle) ? $filterTitle : '',
            'filterDesc' => !empty($filterDesc) ? $filterDesc : '',
		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $entities = Entity::orderBy('entity_level')
        ->where('is_active', true)
        ->orderBy('state_code')
        ->get();

        $roles = Role::orderBy('level')
        ->where('is_active', true)
        ->get();

        return view('app.admin.hebahan.create', [		
            'entities' => $entities,
            'roles' => $roles,
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

			//store your file into database
			$hebahan = new Hebahan();
            
            $hebahan->tajuk = $request->txtTitle;
            $hebahan->kandungan = strtoupper($request->txtDesc);
            $hebahan->tarikh = $request->txtDate;
            $hebahan->role_id = $request->selRoles;
            $hebahan->entity_id = $request->selEntity;
            $hebahan->status = 1;

			$hebahan->created_by = $request->user()->id;
            $hebahan->updated_by = $request->user()->id;

            $hebahan->save();
                
            $audit_details = json_encode([ 
                'tajuk' => $request->txtTitle,
                'kandungan'=> strtoupper($request->txtDesc),
                'tarikh'=> $request->txtDate,
                'role_id' => $request->selRoles,
                'entity_id' => $request->selEntity,
                'status' => 'Dihantar',
            ]);

            Audit::log('Hebahan', 'Tambah', $audit_details);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'tajuk' => $request->txtTitle,
                'kandungan'=> strtoupper($request->txtDesc),
                'tarikh'=> $request->txtDate,
                'role_id' => $request->selRoles,
                'entity_id' => $request->selEntity,
                'status' => 'Dihantar',
            ]);

            Audit::log('Hebahan', 'Tambah', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('Systems\HebahanController@index')->with('t_success', __('app.data_updated'));
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
        $hebahan = Hebahan::where('hebahans.id', $id)
        ->leftjoin('entities as e', 'hebahans.entity_id', '=', 'e.id')
        ->leftjoin('roles as r', 'hebahans.role_id', '=', 'r.id')
        ->select('hebahans.*', 'e.entity_name', 'r.name')
        ->get();

        return view('app.admin.hebahan.edit', [		
            'id' => $id,
            'hebahan' => $hebahan,
		]);
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
        //
    }
}
