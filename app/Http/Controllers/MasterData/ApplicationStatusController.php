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

class ApplicationStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('application_status');
        $application_status = CodeMaster::sortable()->where('type', 'application_status');
        
        $filter = !empty($request->q) ? $request->q : '';

       
        if (!empty($filter)) {
            Audit::log('application_status', 'search', json_encode(['filter' => $filter]));
            $application_status->where('name', 'like', '%'.$filter.'%');
        }

        return view('app.master_data.application_status.index', [
            'application_status' => $request->has('sort') ? $application_status->paginate(10) : $application_status->orderBy('name')->paginate(10),
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
        request()->user()->isAuthorize('application_status');
        return view('app.master_data.application_status.create', [
            'application_status' => Helper::getCodeMastersByType('application_status'),
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
        $request->user()->isAuthorize('application_status');

        if (Helper::codeMasterExists('application_status', $request->txtApplicationStatus)) {
            return redirect()->back()->withErrors(['name' => __('app.data_exists', ['type' => __('module.application_status'), 'data' => $request->name])]);
        }

        $audit_details = json_encode([
            'name' => $request->txtApplicationStatus,
        ]);

        try {
            $application_status = new CodeMaster;
            $application_status->type = 'application_status';
            $application_status->name = $request->txtApplicationStatus;
            $application_status->name_ms = !empty($request->name_ms) ? $request->name_ms : $request->txtApplicationStatus;
            $application_status->created_by = $request->user()->id;
            $application_status->updated_by = $request->user()->id;
            $application_status->save();
            Audit::log('application_status', 'add', $audit_details);
        }
        catch (Exception $e) {
            Audit::log('application_status', 'add', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\ApplicationStatusController@index');
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
        request()->user()->isAuthorize('application_status');

        $application_status = CodeMaster::find($id);
        $audit_details = json_encode([
            'name' => $application_status->name,
            'status' => $application_status->is_active ? 'active' : 'inactive',
        ]);

        try {
            $application_status->deleted_by = request()->user()->id;
            $application_status->save();
            $application_status->delete();
            Audit::log('application_status', 'delete', $audit_details);
        }
        catch (Exception $e) {
            Audit::log('application_status', 'delete', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\ApplicationStatusController@index');
    }
}
