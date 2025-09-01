<?php

namespace App\Http\Controllers\MasterData;

use App\Models\CodeMaster;
use App\Models\Parliament;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Audit;
use Exception;
use Helper;

class ParliamentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('parliaments');
        $parliaments = Parliament::sortable()->where('is_deleted', false);

        $filter = !empty($request->txtName) ? $request->txtName : '';

        if (!empty($filter)) {
            Audit::log('parliaments', 'search', json_encode(['filter' => $filter]));
            $parliaments->whereRaw('UPPER(parliaments.parliament_name) like ?', ['%'.strtoupper($filter).'%'])
                ->orWhereRaw('UPPER(parliaments.parliament_code) like ?', ['%'.strtoupper($filter).'%']);
        }

        return view('app.master_data.parliament.index', [
            'parliaments' => $request->has('sort') ? $parliaments->paginate(10) : $parliaments->orderBy('parliament_code')->paginate(10),
            'txtName' => $filter,
            'can_create' => $request->user()->hasAccess('add-parliament'),
            'can_delete' => $request->user()->hasAccess('delete-parliament'),
        ]);
    }

    public function create2()
    {
        return view('app.master_data.parliament.create', [
            
            'states' => Helper::getCodeMastersByType('state'),
        ]);
    }


    public function getParliament($stateId)
    {
        $query = Parliament::query();

        if ($stateId) {
            $parliaments = $query->where('state_id', $stateId)->where('is_deleted',false)->get();
        }
        return $parliaments;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //request()->user()->isAuthorize('add-parliament');

        //dd('Test');

        return view('app.master_data.parliament.create', [
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
        $request->user()->isAuthorize('add-parliament');

        $this->validate($request, [
            'state' => ['required'],
            'code' => ['required', 'string', 'max:150'],
            'name' => ['required', 'string', 'max:150'],
        ]);

        if (Helper::parliamentExists($request->name, $request->code, $request->state)) {
            return redirect()->back()->withErrors(['name' => __('app.data_exists', ['type' => __('app.parliament'), 'data' => $request->code.' - '.$request->name])]);
        }

        $audit_details = json_encode([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        try {

            $parliament = new Parliament;           
            $parliament->parliament_code = $request->code;
            $parliament->parliament_name = $request->name;
            $parliament->state_id = $request->state;
            $parliament->created_by = $request->user()->id;
            $parliament->updated_by = $request->user()->id;
            $parliament->save();

            Audit::log('parliaments', 'add', $audit_details);
        }
        catch (Exception $e) {

            Audit::log('parliaments', 'add', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\ParliamentController@index')->with('t_success', __('app.data_added', ['type' => __('app.parliament')]));
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
        request()->user()->isAuthorize('parliaments');

        return view('app.master_data.parliament.edit', [
            'parliament' => Parliament::find($id),
            'states' => Helper::getCodeMastersByType('state'),
            'can_edit' => request()->user()->hasAccess('edit-parliament'),
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
        $request->user()->isAuthorize('add-parliament');

        $this->validate($request, [
            'state' => ['required'],
            'code' => ['required', 'string', 'max:150'],
            'name' => ['required', 'string', 'max:150'],
        ]);

        /*if (Helper::parliamentExists($request->name, $request->code, $request->state)) {
            return redirect()->back()->withErrors(['name' => __('app.data_exists', ['type' => __('app.parliament'), 'data' => $request->code.' - '.$request->name])]);
        }*/

        $audit_details = json_encode([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        try {
            $parliament = Parliament::find($id);           
            $parliament->parliament_code = $request->code;
            $parliament->parliament_name = $request->name;
            $parliament->state_id = $request->state;
            $parliament->updated_by = $request->user()->id;
            $parliament->save();

            Audit::log('parliaments', 'update', $audit_details);
        }
        catch (Exception $e) {

            Audit::log('parliaments', 'update', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\ParliamentController@index')->with('t_info', __('app.data_updated', ['type' => __('app.parliament'), 'data' => $parliament->name]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        request()->user()->isAuthorize('delete-parliament');

        $parliament = Parliament::find($id);

        $audit_details = json_encode([
            'code' => $parliament->parliament_code,
            'name' => $parliament->parliament_name,
        ]);

        try {

            $parliament->deleted_by = request()->user()->id;
            $parliament->is_deleted = true;
            $parliament->save();

            Audit::log('parliaments', 'delete', $audit_details);
        }
        catch (Exception $e) {

            Audit::log('parliaments', 'delete', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\ParliamentController@index')->with('t_info', __('app.data_deleted', ['type' => __('app.parliament'), 'data' => $parliament->parliament_name]));
    }
}
