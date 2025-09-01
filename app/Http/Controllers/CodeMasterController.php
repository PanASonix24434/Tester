<?php

namespace App\Http\Controllers;

use App\Models\CodeMaster;
use Illuminate\Http\Request;
use Audit;
use Exception;
use Module;
use Helper;

class CodeMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $slug)
    {
        if (Module::get($slug) == null) {
            return abort(404);
        }

        //$request->user()->isAuthorize($slug);

        $code_masters = CodeMaster::sortable()->where('type', Helper::getSingularSnake($slug));

        $filter = !empty($request->txtName) ? $request->txtName : '';

        if (!empty($filter)) {
            Audit::log(Helper::getSingularSnake($slug), 'search', json_encode(['filter' => $filter]));
            $code_masters->where('name_ms', 'like', '%'.$filter.'%');
        }

        return view('app.code_master.index', [
            'code_masters' => ($request->has('sort') ? $code_masters->paginate(10) : CodeMaster::isOrder(Helper::getSingularSnake($slug))) ? $code_masters->orderBy('order')->paginate(10) : $code_masters->orderBy('name_ms')->paginate(10),
            'slug' => $slug,
            'txtName' => $filter,
            'can_create' => $request->user()->hasAccess('add-'.Helper::getSingularSlug($slug)),
            'can_delete' => $request->user()->hasAccess('delete-'.Helper::getSingularSlug($slug)),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        request()->user()->isAuthorize('add-'.Helper::getSingularSlug($slug));

        return view('app.code_master.create', [
            'slug' => $slug,
            'page_title' => __('app.add').' '.Helper::getSingular($slug, true),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
        $request->user()->isAuthorize('add-'.Helper::getSingularSlug($slug));

        $this->validate($request, [
            'name' => ['required', 'string', 'max:150'],
        ]);

        if (Helper::codeMasterExists($slug, $request->name, $request->code)) {
            return redirect()->back()->withErrors(['name' => __('app.data_exists', ['type' => Helper::getSingular($slug, true), 'data' => $request->name])]);
        }

        $total = CodeMaster::where('type', Helper::getSingular($slug))->get()->count();
        $audit_details = json_encode([
            'name' => $request->name,
        ]);

        try {
            $code_master = new CodeMaster;
            $code_master->type = Helper::getSingular($slug);
            $code_master->parent_id = !empty($request->parent_id) ? $request->parent_id : null;
            $code_master->code = !empty($request->code) ? strtoupper($request->code) : null;
            $code_master->name_ms = $request->name;
            $code_master->name = $request->name;
            //$code_master->name_ms = $request->name_ms;
            $code_master->order = CodeMaster::isOrder(Helper::getSingularSnake($slug)) ? $total + 1 : null;
            $code_master->created_by = $request->user()->id;
            $code_master->updated_by = $request->user()->id;
            $code_master->save();
            //Audit::log(Helper::getSnake($slug), 'add', $audit_details);
        }
        catch (Exception $e) {
            //Audit::log(Helper::getSnake($slug), 'add', $audit_details, $e->getMessage());
            //return redirect()->back()->with('t_error', __('app.error_occured'));
            return redirect()->back()->with('cm_success', 'Data Utama gagal dicipta !!');
        }

        //return redirect()->action('CodeMasterController@index', $slug)->with('t_success', __('app.data_added', ['type' => Helper::getSingular($slug, true)]));
        return redirect()->action('CodeMasterController@index', $slug)->with('cm_success', 'Data Utama berjaya dicipta !!');
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
    public function edit($slug, $id)
    {
        request()->user()->isAuthorize($slug);

        return view('app.code_master.edit', [
            'code_master' => CodeMaster::find($id),
            'slug' => $slug,
            'page_title' => __('app.edit').' '.Helper::getSingular($slug, true),
            'can_edit' => request()->user()->hasAccess('edit-'.Helper::getSingular($slug)),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug, $id)
    {
        $request->user()->isAuthorize('edit-'.Helper::getSingularSlug($slug));

        $this->validate($request, [
            'name' => ['required', 'string', 'max:150'],
        ]);

        if (Helper::codeMasterExists($slug, $request->name, $request->code, $id)) {
            return redirect()->back()->withErrors(['name' => __('app.data_exists', ['type' => Helper::getSingular($slug, true), 'data' => $request->name])]);
        }
        
        $code_master = CodeMaster::find($id);
        $audit_details = json_encode([
            'name' => $request->name,
            'status' => $request->is_active ? 'active' : 'inactive',
        ]);

        try {
            $code_master->parent_id = !empty($request->parent_id) ? $request->parent_id : $code_master->parent_id;
            $code_master->code = !empty($request->code) ? strtoupper($request->code) : null;
            $code_master->name = $request->name;
            $code_master->name_ms = $request->name;
            $code_master->is_active = !empty($request->active) ? true : false;
            $code_master->updated_by = $request->user()->id;
            $code_master->save();
            //Audit::log(Helper::getSnake($slug), 'update', $audit_details);
        }
        catch (Exception $e) {
            //Audit::log(Helper::getSnake($slug), 'update', $audit_details, $e->getMessage());
            //return redirect()->back()->with('t_error', __('app.error_occured'));
            return redirect()->back()->with('cm_failed', 'Data Utama gagal disimpan !!');
        }

        //return redirect()->action('CodeMasterController@index', $slug)->with('t_info', __('app.data_updated', ['type' => Helper::getSingular($slug, true), 'data' => $code_master->name]));
        return redirect()->action('CodeMasterController@index', $slug)->with('cm_success', 'Data Utama berjaya disimpan !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, $id)
    {
        //request()->user()->isAuthorize('delete-'.Helper::getSingularSlug($slug));

        $code_master = CodeMaster::find($id);
        $audit_details = json_encode([
            'name' => $code_master->name,
            'status' => $code_master->is_active ? 'active' : 'inactive',
        ]);

        try {
            $code_master->deleted_by = request()->user()->id;
            $code_master->save();
            $code_master->delete();
            //Audit::log(Helper::getSnake($slug), 'delete', $audit_details);
        }
        catch (Exception $e) {
            //Audit::log(Helper::getSnake($slug), 'delete', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('CodeMasterController@index', $slug)->with('t_info', __('app.data_deleted', ['type' => Helper::getSingular($slug, true), 'data' => $code_master->name]));
    }
}
