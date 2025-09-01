<?php

namespace App\Http\Controllers\Systems;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Hebahan;
use App\Models\Entity;
use App\Models\Authorization\Role;
use App\Models\User;

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

//Mail
use Mail;
use App\Mail\Hebahan as HebahanMail;

class HebahanApproveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $hebahan = Hebahan::whereNull('hebahans.deleted_by')
        ->leftjoin('roles','hebahans.role_id','=','roles.id')
        ->where('hebahans.status', 1)
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

        return view('app.admin.hebahanapprove.index', [		
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

        return view('app.admin.hebahanapprove.edit', [		
            'id' => $id,
            'hebahan' => $hebahan,
		]);
    }

    public function editApprove(string $id)
    {
        $hebahan = Hebahan::where('hebahans.id', $id)
        ->leftjoin('entities as e', 'hebahans.entity_id', '=', 'e.id')
        ->leftjoin('roles as r', 'hebahans.role_id', '=', 'r.id')
        ->select('hebahans.*', 'e.entity_name', 'r.name')
        ->get();

        return view('app.admin.hebahanapprove.editapprove', [		
            'id' => $id,
            'hebahan' => $hebahan,
		]);
    }

    public function editReject(string $id)
    {
        $hebahan = Hebahan::where('hebahans.id', $id)
        ->leftjoin('entities as e', 'hebahans.entity_id', '=', 'e.id')
        ->leftjoin('roles as r', 'hebahans.role_id', '=', 'r.id')
        ->select('hebahans.*', 'e.entity_name', 'r.name')
        ->get();

        return view('app.admin.hebahanapprove.editreject', [		
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

    public function updateReject(Request $request, string $id)
    {
        DB::beginTransaction();

        try {

			//store your file into database
			$hebahan = Hebahan::find($id);
            
            $hebahan->remark_reject = strtoupper($request->txtReject);
            $hebahan->status = 3;

            $hebahan->updated_by = $request->user()->id;

            $hebahan->save();
                
            $audit_details = json_encode([ 
                'ulasan_tolak' => strtoupper($request->txtReject),
                'status' => 'Ditolak',
            ]);

            Audit::log('Hebahan', 'Ditolak', $audit_details);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'ulasan_tolak' => strtoupper($request->txtReject),
                'status' => 'Ditolak',
            ]);

            Audit::log('Hebahan', 'Ditolak', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('Systems\HebahanApproveController@index')->with('t_success', __('app.data_updated'));
    }

    public function updateApprove(Request $request, string $id)
    {
        DB::beginTransaction();

        try {

			//store your file into database
			$hebahan = Hebahan::find($id);
            
            $hebahan->remark_approve = strtoupper($request->txtApprove);
            $hebahan->status = 2;

            $hebahan->updated_by = $request->user()->id;

            $hebahan->save();
                
            $audit_details = json_encode([ 
                'ulasan_lulus' => strtoupper($request->txtApprove),
                'status' => 'Ditolak',
            ]);

            Audit::log('Hebahan', 'Diluluskan', $audit_details);

            DB::commit();

            //Send email hebahan ================================

            $mailDataArr = array(
                'title' => $hebahan->tajuk,
                'content' => $hebahan->kandungan,
            );

            //Get penerima hebahan

            $roles = Role::find($hebahan->role_id);
            $entity = Entity::find($hebahan->entity_id);

            //Level 1 - HQ
            if($entity->entity_level == 1){

                //Dalaman
                if(!empty($roles->entity_id)){

                    $userHQ = User::where('users.is_active', true)
                        ->join('user_role','users.id','=','user_role.user_id')
                        ->join('roles','user_role.role_id','=','roles.id')
                        ->where('roles.id', $hebahan->role_id)
                        ->where('users.entity_id', $hebahan->entity_id)
                        ->where('roles.is_active',true)
                        ->select('users.email')
                        ->get();

                    if(count($userHQ) > 0){

                        for($i = 0; $i < count($userHQ); $i++){

                            //Send email to penerima hebahan
                            Mail::to($userHQ[$i]->email)->queue(new HebahanMail($mailDataArr));
                        }

                    }
                }
                //Luaran
                else{

                    $userHQ = User::where('users.is_active', true)
                        ->join('user_role','users.id','=','user_role.user_id')
                        ->join('roles','user_role.role_id','=','roles.id')
                        ->where('roles.id', $hebahan->role_id)
                        ->where('roles.is_active',true)
                        ->select('users.email')
                        ->get();

                    if(count($userHQ) > 0){

                        for($i = 0; $i < count($userHQ); $i++){

                            //Send email to penerima hebahan
                            Mail::to($userHQ[$i]->email)->queue(new HebahanMail($mailDataArr));
                        }

                    }
                }  
            }
            //Level 2 - Negeri
            elseif($entity->entity_level == 2){
                
                //Dalaman
                if(!empty($roles->entity_id)){

                    $userNegeri = User::where('users.is_active', true)
                        ->join('user_role','users.id','=','user_role.user_id')
                        ->join('roles','user_role.role_id','=','roles.id')
                        ->join('entities','users.entity_id','=','entities.id')
                        ->where('roles.id', $hebahan->role_id)
                        ->where('entities.parent_id', $hebahan->entity_id)
                        ->where('roles.is_active',true)
                        ->select('users.email')
                        ->get();

                    if(count($userNegeri) > 0){

                        for($i = 0; $i < count($userNegeri); $i++){

                            //Send email to penerima hebahan
                            Mail::to($userNegeri[$i]->email)->queue(new HebahanMail($mailDataArr));
                        }
                    }
                }
                //Luaran
                else{

                    $userNegeri = User::where('users.is_active', true)
                        ->join('user_role','users.id','=','user_role.user_id')
                        ->join('roles','user_role.role_id','=','roles.id')
                        ->join('entities','users.entity_id','=','entities.id')
                        ->where('roles.id', $hebahan->role_id)
                        ->where('roles.is_active',true)
                        ->select('users.email')
                        ->get();

                    if(count($userNegeri) > 0){

                        for($i = 0; $i < count($userNegeri); $i++){

                            //Send email to penerima hebahan
                            Mail::to($userNegeri[$i]->email)->queue(new HebahanMail($mailDataArr));
                        }
                    }
                }  
            }
            //Level 3 - Daerah
            elseif($entity->entity_level == 4){

                //Dalaman
                if(!empty($roles->entity_id)){

                    $userDaerah = User::where('users.is_active', true)
                        ->join('user_role','users.id','=','user_role.user_id')
                        ->join('roles','user_role.role_id','=','roles.id')
                        ->where('roles.id', $hebahan->role_id)
                        ->where('users.entity_id', $hebahan->entity_id)
                        ->where('roles.is_active',true)
                        ->select('users.email')
                        ->get();

                    if(count($userDaerah) > 0){

                        for($i = 0; $i < count($userDaerah); $i++){

                            //Send email to penerima hebahan
                            Mail::to($userDaerah[$i]->email)->queue(new HebahanMail($mailDataArr));
                        }
                    }
                }
                //Luaran
                else{

                    $userDaerah = User::where('users.is_active', true)
                        ->join('user_role','users.id','=','user_role.user_id')
                        ->join('roles','user_role.role_id','=','roles.id')
                        ->where('roles.id', $hebahan->role_id)
                        ->where('roles.is_active',true)
                        ->select('users.email')
                        ->get();

                    if(count($userDaerah) > 0){

                        for($i = 0; $i < count($userDaerah); $i++){

                            //Send email to penerima hebahan
                            Mail::to($userDaerah[$i]->email)->queue(new HebahanMail($mailDataArr));
                        }
                    }
                }
                 
            }
            else{

            }
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'ulasan_lulus' => strtoupper($request->txtApprove),
                'status' => 'Ditolak',
            ]);

            Audit::log('Hebahan', 'Diluluskan', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('Systems\HebahanApproveController@index')->with('t_success', __('app.data_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
