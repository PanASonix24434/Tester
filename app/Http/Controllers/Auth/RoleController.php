<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Authorization\Role;
use App\Models\Entity;
use Illuminate\Http\Request;
use Auth;
use Audit;
use DB;
use Exception;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        //$roles = Role::sortable();

        $roles = Role::whereNotNull('roles.created_by')
        ->leftjoin('entities as e','roles.entity_id','=','e.id')
        ->select('roles.*', 'e.entity_name', 'e.entity_level');

        $entities = Entity::orderBy('entity_level')
        ->orderBy('state_code')
        ->get();

        $filterName = !empty($request->name) ? $request->name : '';
        $filterEntity = !empty($request->selEntity) ? $request->selEntity : '';

        if (!empty($filterName)) {
            $roles->where('roles.name', 'like', '%'.$filterName.'%');
        }

        if (!empty($filterEntity)) {
            $roles->where('roles.entity_id', '=', $filterEntity);
        }

        return view('app.admin.role.index', [
            'roles' => $request->has('sort') ? $roles->paginate(10) : $roles->orderBy('roles.name')->paginate(10),
            'filterName' => $filterName,
            'filterEntity' => $filterEntity,
            'entities' => $entities,
            'can_create' => Auth::user()->hasAccess('create-role'),
            'can_delete' => Auth::user()->hasAccess('delete-role'),
            'create_failed' => false,
            'create_success' => false,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //request()->user()->isAuthorize('create-role');

        $entities = Entity::orderBy('entity_level')
        ->orderBy('state_code')
        ->get();

        return view('app.admin.role.create',[
            'entities' => $entities,
            'validate_lblquota' => false,
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
        //$request->user()->isAuthorize('create-role');

        /*if($request->selEntity == 1 && empty($request->txtQuota)){
            return view('app.admin.role.create', [		
                'validate_lblquota' => true,
            ]);
        }*/

        $this->validate($request, 
            //['name' => 'required|regex:/^[\p{L}\s-]+$/u|string|max:150|unique:roles']
            [
                'name' => 'required|max:150|unique:roles'
            ],
            [
                'name.unique' => 'Nama Peranan sudah digunakan.',
            ]
        );
        
        
        DB::beginTransaction();

        try {
            $role = new Role;
            $role->name = $request->name;
            $role->quota = $request->txtQuota;
            $role->entity_id = $request->selEntity;
            $role->created_by = Auth::id();
            $role->updated_by = Auth::id();
            $role->save();
            if (!empty($request->permissions)) {
                $role->modules()->attach(array_unique(explode(', ', $request->permissions)));
            }

            Audit::log('roles', 'create', json_encode([
                'name' => $request->name,
                'quota' => $request->txtQuota,
                'entity_id' => $request->selEntity,
            ]));
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            Audit::log('roles', 'create', json_encode([
                'name' => $request->name,
                'quota' => $request->txtQuota,
                'entity_id' => $request->selEntity,
            ]), $e->getMessage());

            //return redirect()->back()->with('t_error', __('app.error_occured'));
            return redirect()->back()->with('alert', 'Peranan gagal dicipta !!');

        }

        //return redirect()->action('Auth\RoleController@index')->with('t_success', __('app.role_created').' '.$request->name);
        return redirect()->action('Auth\RoleController@index')->with('alert', 'Peranan berjaya dicipta !!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Authorization\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Authorization\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $entities = Entity::orderBy('entity_level')
        ->orderBy('state_code')
        ->get();

        if ($role->is_admin) {
            request()->session()->now('danger', __('app.admin_role_cannot_be_edited'));
        }

        return view('app.admin.role.edit', [
            'role' => $role,
            'entities' => $entities, 
            'can_edit' => Auth::user()->hasAccess('edit-role'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Authorization\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //$request->user()->isAuthorize('edit-role');

        $this->validate($request, ['name' => 'required|string|max:150|unique:roles,name,'.$role->id]);
        
        DB::beginTransaction();

        try {
            $role->name = $request->name;
            $role->quota = $request->txtQuota;
            $role->entity_id = $request->selEntity;
            $role->updated_by = Auth::id();
            $role->save();
            $role->modules()->detach();
            if (!empty($request->permissions)) {
                $role->modules()->attach(array_unique(explode(', ', $request->permissions)));
            }

            Audit::log('roles', 'update', json_encode([
                'name' => $request->name,
                'quota' => $request->txtQuota,
                'entity_id' => $request->selEntity,
            ]));
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            Audit::log('roles', 'update', json_encode([
                'name' => $request->name,
                'quota' => $request->txtQuota,
                'entity_id' => $request->selEntity,
            ]), $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('Auth\RoleController@index')->with('t_success', __('app.role_updated', [ 'role' => $role->name ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Authorization\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //request()->user()->isAuthorize('delete-role');

        $roleName = $role->name;
        try {
            // $role->deleted_by = Auth::id();
            // $role->save();
            // $role->delete();
            $role->forceDelete();
            Audit::log('roles', 'delete', json_encode(['name' => $roleName]));
        }
        catch (Exception $e) {
            Audit::log('roles', 'delete', json_encode(['name' => $roleName]), $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }
        return redirect()->action('Auth\RoleController@index')->with('t_info', __('app.role_deleted', ['role' => $roleName]));
    }
}
