<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CodeMaster;
use App\Models\User;
use Audit;
use Helper;
use Auth;
use Storage;

class EntityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('entity');
        $entity = CodeMaster::sortable()->where('type', 'type_of_entity');
        
        $filter = !empty($request->q) ? $request->q : '';

       
        if (!empty($filter)) {
            Audit::log('entity', 'search', json_encode(['filter' => $filter]));
            $entity->where('name', 'like', '%'.$filter.'%');
        }

        return view('app.master_data.entity.index', [
            'entity' => $request->has('sort') ? $entity->paginate(10) : $entity->orderBy('name')->paginate(10),
            'q' => $filter,
           
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        request()->user()->isAuthorize('entity');
        return view('app.master_data.entity.create', [
            'entity' => Helper::getCodeMastersByType('type_of_entity'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->isAuthorize('entity');

        if (Helper::codeMasterExists('entities', $request->txtEntity)) {
            return redirect()->back()->withErrors(['name' => __('app.data_exists', ['type' => __('module.entity'), 'data' => $request->name])]);
        }

        $audit_details = json_encode([
            'name' => $request->txtEntity,
        ]);

        try {
            $entity = new CodeMaster;
            $entity->type = 'type_of_entity';
            $entity->name = $request->txtEntity;
            $entity->name_ms = !empty($request->name_ms) ? $request->name_ms : $request->txtEntity;
            $entity->created_by = $request->user()->id;
            $entity->updated_by = $request->user()->id;
            $entity->save();
            Audit::log('entities', 'add', $audit_details);
        }
        catch (Exception $e) {
            Audit::log('entities', 'add', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\EntityController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        request()->user()->isAuthorize('entity');

        $entity = CodeMaster::find($id);
        $audit_details = json_encode([
            'name' => $entity->name,
            'status' => $entity->is_active ? 'active' : 'inactive',
        ]);

        try {
            $entity->deleted_by = request()->user()->id;
            $entity->save();
            $entity->delete();
            Audit::log('entities', 'delete', $audit_details);
        }
        catch (Exception $e) {
            Audit::log('entities', 'delete', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\EntityController@index');
    }
}
