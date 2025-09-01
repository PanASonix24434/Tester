<?php

namespace App\Http\Controllers\MasterData;

use App\Models\CodeMaster;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Audit;
use Exception;
use Helper;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('states');
        $states = CodeMaster::sortable()->where('type', 'state');
        $filter = !empty($request->txtName) ? $request->txtName : '';
        if (!empty($filter)) {
            Audit::log('states', 'search', json_encode(['filter' => $filter]));
            $states->where('name_ms', 'like', '%'.$filter.'%');
        }

        return view('app.master_data.state.index', [
            'states' => $request->has('sort') ? $states->paginate(10) : $states->orderBy('name')->paginate(10),
            'txtName' => $filter,
            'can_create' => $request->user()->hasAccess('add-state'),
            'can_delete' => $request->user()->hasAccess('delete-state'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        request()->user()->isAuthorize('add-state');
        return view('app.master_data.state.create', [
            'countries' => Helper::getCodeMastersByType('country'),
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
        $request->user()->isAuthorize('add-state');

        $this->validate($request, [
            'country' => ['required'],
            'name' => ['required', 'string', 'max:150'],
        ]);

        if (Helper::codeMasterExists('states', $request->name)) {
            return redirect()->back()->withErrors(['name' => __('app.data_exists', ['type' => __('module.state'), 'data' => $request->name])]);
        }

        $audit_details = json_encode([
            'name' => $request->name,
        ]);

        try {
            $state = new CodeMaster;
            $state->type = 'state';
            $state->parent_id = $request->country;
            $state->name = $request->name;
            $state->name_ms = !empty($request->name_ms) ? $request->name_ms : $request->name;
            $state->created_by = $request->user()->id;
            $state->updated_by = $request->user()->id;
            $state->save();
            Audit::log('states', 'add', $audit_details);
        }
        catch (Exception $e) {
            Audit::log('states', 'add', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\StateController@index')->with('t_success', __('app.data_added', ['type' => strtolower(__('module.state'))]));
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
        request()->user()->isAuthorize('states');
        return view('app.master_data.state.edit', [
            'state' => CodeMaster::find($id),
            'countries' => Helper::getCodeMastersByType('country'),
            'can_edit' => request()->user()->hasAccess('edit-state'),
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
        $request->user()->isAuthorize('edit-state');

        $this->validate($request, [
            'country' => ['required'],
            'name' => ['required', 'string', 'max:150'],
        ]);

        if (Helper::codeMasterExists('states', $request->name, null, $id)) {
            return redirect()->back()->withErrors(['name' => __('app.data_exists', ['type' => __('module.state'), 'data' => $request->name])]);
        }

        $audit_details = json_encode([
            'name' => $request->name,
            'status' => $request->is_active ? 'active' : 'inactive',
        ]);

        try {
            $state = CodeMaster::find($id);
            $state->parent_id = $request->country;
            $state->name = $request->name;
            $state->name_ms = !empty($request->name_ms) ? $request->name_ms : $request->name;
            $state->is_active = !empty($request->active) ? true : false;
            $state->updated_by = $request->user()->id;
            $state->save();
            Audit::log('states', 'update', $audit_details);
        }
        catch (Exception $e) {
            Audit::log('states', 'update', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\StateController@index')->with('t_info', __('app.data_updated', ['type' => __('module.state'), 'data' => $state->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        request()->user()->isAuthorize('delete-state');

        $state = CodeMaster::find($id);
        $audit_details = json_encode([
            'name' => $state->name,
            'status' => $state->is_active ? 'active' : 'inactive',
        ]);

        try {
            $state->deleted_by = request()->user()->id;
            $state->save();
            $state->delete();
            Audit::log('states', 'delete', $audit_details);
        }
        catch (Exception $e) {
            Audit::log('states', 'delete', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\StateController@index')->with('t_info', __('app.data_deleted', ['type' => __('module.state'), 'data' => $state->name]));
    }
}
