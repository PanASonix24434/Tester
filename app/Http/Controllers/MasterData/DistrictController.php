<?php

namespace App\Http\Controllers\MasterData;

use App\Models\CodeMaster;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Audit;
use Exception;
use Helper;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('districts');
        $districts = CodeMaster::sortable()->where('type', 'district');
        
        $filter = !empty($request->txtName) ? $request->txtName : '';
        $filter_state = !empty($request->state) ? $request->state : '';

        if (!empty($filter_state)) {
            $parent_id = Helper::getCodeMasterIdByTypeName('state', $filter_state);
            if (!empty($parent_id)) {
                $districts->where('parent_id', $parent_id);
            }
        }
        if (!empty($filter)) {
            Audit::log('districts', 'search', json_encode(['filter' => $filter]));
            $districts->where('name_ms', 'like', '%'.$filter.'%');
        }

        return view('app.master_data.district.index', [
            'districts' => $request->has('sort') ? $districts->paginate(10) : $districts->orderBy('name_ms')->paginate(10),
            'txtName' => $filter,
            'can_create' => $request->user()->hasAccess('add-district'),
            'can_delete' => $request->user()->hasAccess('delete-district'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        request()->user()->isAuthorize('add-district');
        return view('app.master_data.district.create', [
            'states' => Helper::getCodeMastersByType('state'),
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
        $request->user()->isAuthorize('add-district');

        $this->validate($request, [
            'state' => ['required'],
            'name' => ['required', 'string', 'max:150'],
        ]);

        if (Helper::codeMasterExists('districts', $request->name, null, null, $request->state)) {
            return redirect()->back()->withErrors(['name' => __('app.data_exists', ['type' => __('module.district'), 'data' => $request->name])]);
        }

        $audit_details = json_encode([
            'name' => $request->name,
        ]);

        try {
            $district = new CodeMaster;
            $district->type = 'district';
            $district->parent_id = $request->state;
            $district->name = $request->name;
            $district->name_ms = !empty($request->name_ms) ? $request->name_ms : $request->name;
            $district->created_by = $request->user()->id;
            $district->updated_by = $request->user()->id;
            $district->save();
            Audit::log('districts', 'add', $audit_details);
        }
        catch (Exception $e) {
            Audit::log('districts', 'add', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\DistrictController@index')->with('t_success', __('app.data_added', ['type' => strtolower(__('module.district'))]));
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
        request()->user()->isAuthorize('districts');
        return view('app.master_data.district.edit', [
            'district' => CodeMaster::find($id),
            'states' => Helper::getCodeMastersByType('state'),
            'can_edit' => request()->user()->hasAccess('edit-district'),
        ]);
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
        $request->user()->isAuthorize('edit-district');

        $this->validate($request, [
            'state' => ['required'],
            'name' => ['required', 'string', 'max:150'],
        ]);

        if (Helper::codeMasterExists('districts', $request->name, null, $id, $request->state)) {
            return redirect()->back()->withErrors(['name' => __('app.data_exists', ['type' => __('module.district'), 'data' => $request->name])]);
        }

        $audit_details = json_encode([
            'name' => $request->name,
            'status' => $request->is_active ? 'active' : 'inactive',
        ]);

        try {
            $district = CodeMaster::find($id);
            $district->parent_id = $request->state;
            $district->name = $request->name;
            $district->name_ms = !empty($request->name_ms) ? $request->name_ms : $request->name;
            $district->is_active = !empty($request->active) ? true : false;
            $district->updated_by = $request->user()->id;
            $district->save();
            Audit::log('districts', 'update', $audit_details);
        }
        catch (Exception $e) {
            Audit::log('districts', 'update', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\DistrictController@index')->with('t_info', __('app.data_updated', ['type' => __('module.district'), 'data' => $district->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        request()->user()->isAuthorize('delete-district');

        $district = CodeMaster::find($id);
        $audit_details = json_encode([
            'name' => $district->name,
            'status' => $district->is_active ? 'active' : 'inactive',
        ]);

        try {
            $district->deleted_by = request()->user()->id;
            $district->save();
            $district->delete();
            Audit::log('districts', 'delete', $audit_details);
        }
        catch (Exception $e) {
            Audit::log('districts', 'delete', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\DistrictController@index')->with('t_info', __('app.data_deleted', ['type' => __('module.state'), 'data' => $district->name]));
    }
}
