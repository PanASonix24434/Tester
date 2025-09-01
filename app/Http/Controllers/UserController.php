<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MyIdentity;
use App\Models\Authorization\Role;
use App\Exports\UserExport;
use App\Models\Entity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
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
use App\Mail\CreateUser;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $users = User::sortable();

        $roles = Role::sortable();

        $entities = Entity::orderBy('entity_level')
        ->orderBy('state_code')
        ->get();

        //$filter = !empty($request->q) ? $request->q : '';
        $filterName = !empty($request->txtName) ? $request->txtName : '';
        $filterICNo = !empty($request->txtICNo) ? $request->txtICNo : '';
        $filterSelRole = !empty($request->selRole) ? $request->selRole : '';
        $filterSelEntity = !empty($request->selEntity) ? $request->selEntity : '';
        $filterSelStatus = !empty($request->selStatus) ? $request->selStatus : '';

        //dd($filterSelStatus);

        if (!empty($filterSelRole)) {
            // Audit::log('users', 'search', json_encode(['filter' => $filter]));

            $users->whereHas('roles', function ($query) use ($filterSelRole) {
                    $query->where('name', 'like', '%'.$filterSelRole.'%'); 
                });
                // ->orWhere('name', 'like', '%'.$filter.'%')
                // ->orWhere('username', 'like', '%'.$filter.'%')
                // ->orWhere('email', 'like', '%'.$filter.'%');
        }

        if (!empty($filterName)) {
            $users->where('name', 'like', '%'.$filterName.'%');
        }

        if (!empty($filterICNo)) {
            $users->where('username', 'like', '%'.$filterICNo.'%');
        }

        if (!empty($filterSelEntity)) {
            $users->where('entity_id', '=', $filterSelEntity);
        }

        if (!empty($filterSelStatus)) {

            if($filterSelStatus == 1){
                $users->where('is_active', '=', true);
            }
            else{
                $users->where('is_active', '=', false);
            }
            
        }
        
        $users->where('is_admin', false);

        return view('app.admin.user.index', [
            'users' => $users->orderBy('name')->paginate(10),
            'roles' => $roles->orderBy('roles.name')->get(), 
            'entities' => $entities,
            'filterName' => $filterName,
            'filterICNo' => $filterICNo,
            'filterSelEntity' => $filterSelEntity,
            'filterSelStatus' => $filterSelStatus,
            'filterSelRole' => $filterSelRole,
            'can_create' => Auth::user()->hasAccess('create-user'),
            'can_delete' => Auth::user()->hasAccess('delete-user'),
            'can_export' => Auth::user()->hasAccess('export-user'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $entities = Entity::orderBy('entity_level')
        ->orderBy('state_code')
        ->get();

        return view('app.admin.user.create', [
            'roles' => Role::all()->sortBy('name'),
            'entities' => $entities,
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
            // dd('test');

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:50',
            'username' => 'required|min:12|max:12|unique:users,username',
            'txtStartDate' => 'required',
        ], [
            'username.required' => 'No Kad Pengenalan diperlukan.',
            'username.min' => 'No Kad Pengenalan mestilah 12 digit.',
            'username.max' => 'No Kad Pengenalan mestilah 12 digit.',
            'username.unique' => 'No. Kad Pengenalan sudah digunakan.',
           ]);
        

        DB::beginTransaction();

        try {
            
            if (!empty($request->input('roles_id'))) {

                $rls = Role::where('id',$request->input('roles_id'))
                ->get();

                //Check quota
                $usrQuota = User::join('user_role','users.id','=','user_role.user_id')
                ->join('roles','user_role.role_id','=','roles.id')
                ->where('users.is_active',true)
                ->where('users.entity_id',$request->selEntity)
                ->where('roles.id',$request->input('roles_id'))
                ->whereNotNull('users.email_verified_at')
                ->select('users.*')
                ->get();

                if(count($usrQuota) < $rls[0]->quota || $rls[0]->quota == null){
                    //Proceed, got quota
                    $user = new User;

                    $aid = Helper::uuid();

                    $user->id = $aid;

                    $user->name = strtoupper($request->name);
                    $user->username = $request->username;
                    $user->email = $request->email;
                    $user->email_verified_at = Carbon::now();
                    $user->password = '$2y$10$yTDOfD1VhG/i0.VOCa4W.eFL6uJChubkEaeovAHrM1B94y/x6t8vq'; //Hash::make($request->password);
                    //$user->password = Hash::make($request->password);
                    $user->is_active = true;
                    $user->entity_id = $request->selEntity;
                    $user->start_date = $request->txtStartDate;
                    $user->watikah_status = 1;

                    if(!empty($request->txtMobileNo)){
                        $user->mobile_contact_number = "+60".$request->txtMobileNo;
                    }else{
                        $user->mobile_contact_number = $request->txtMobileNo;
                    }

                    if(!empty($request->txtOfficePhoneNo)){
                        $user->contact_number = "+60".$request->txtOfficePhoneNo; //OfficePhoneNo
                    }else{
                        $user->contact_number = $request->txtOfficePhoneNo; //OfficePhoneNo
                    }
                    
                    $user->created_by = Auth::id();
                    $user->updated_by = Auth::id();
                    $user->save();

                    //Assign role
                    $user->roles()->attach($request->input('roles_id'));

                    $audit_details = json_encode([ 
                        'name' => strtoupper($request->name),
                        'username' => $request->identification_card_number, 
                        'email' => $request->email,
                        'mobile_contact_number' => $request->txtMobileNo,
                        'contact_number' => $request->txtOfficePhoneNo,
                    ]);
                    Audit::log('users', 'create', $audit_details);
        
                    DB::commit();

                    //Send email ================================

                    $entity = Entity::find($request->selEntity);

                    $mailDataArr = array(
                        'user_id' => $aid,
                        'name' => strtoupper($request->name),
                        'icno' => $request->identification_card_number,
                        'entity_name' => $entity->entity_name,
                        'start_date' => Carbon::createFromFormat('Y-m-d', $request->txtStartDate)->format('d/m/Y'),
                    );

                    //Send email to penerima hebahan
                    Mail::to($request->email)->queue(new CreateUser($mailDataArr));

                }
                else{
                    //Block, quota full
                    //dd("KUOTA BAGI JAWATAN YANG DIPILIH SUDAH PENUH.");
                    return redirect()->back()->with('alert', 'KUOTA BAGI JAWATAN YANG DIPILIH SUDAH PENUH !!');
                }    
            }
            else{

                //dd('alert2');

                return redirect()->back()->with('alert2', 'Sila pilih maklumat Peranan !!');
            }  
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'name' => $request->name,
                'username' => $request->identification_card_number,
                'email' => $request->email,
                'mobile_contact_number' => $request->txtMobileNo,
                'contact_number' => $request->txtOfficePhoneNo,
            ]);
            Audit::log('users', 'create', $audit_details, $e->getMessage());

            //return redirect()->back()->with('alert', 'Pengguna gagal dicipta !!');
	    return redirect()->action('UserController@index')->with('alert', 'Pengguna gagal dicipta !!');

        }

        return redirect()->action('UserController@index')->with('alert', 'Pengguna berjaya dicipta !!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //request()->user()->isAuthorize('users');
        return view('app.admin.user.edit', [
            'user' => $user,
            'roles' => Role::all()->sortBy('name'),
            'can_edit' => Auth::user()->hasAccess('edit-user'),
            'entities' => Entity::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //$request->user()->isAuthorize('edit-user');

        /*$this->validate($request, [
            'name' => 'required|string|max:255',
            'identification_card_number' => 'required|string|min:12|max:255|unique:users,username,'.$user->id.',id,deleted_at,NULL',
            'email' => 'required|string|email|max:50',
            'password' => 'confirmed',
        ]);*/

        if (!empty($request->password)) {

            //With password changes
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:50',
                'identification_card_number' => 'required|min:12|max:12',
                'txtStartDate' => 'required',
                'password' => [
                            'required',
                            'string',
                            'confirmed',
                            'min:12', // Minimum length of 12 characters
                            //'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/', // At least one uppercase, one number, one special character
                            'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#,.])[A-Za-z\d@$!%*?&#,.]{12,}$/', // At least one uppercase, one number, one special character
                ],
                'password_confirmation' => 'required|string',
            ],
            [
                'name.required' => 'Nama Penuh diperlukan.',
                'identification_card_number.required' => 'No Kad Pengenalan diperlukan.',
                'identification_card_number.min' => 'No Kad Pengenalan mestilah 12 digit.',
                'identification_card_number.max' => 'No Kad Pengenalan mestilah 12 digit.',
                'email.required' => 'Emel diperlukan.',
                'email.email' => 'Format emel yang dimasukkan tidak sah.',
                'txtStartDate.required' => 'Tarikh Lapor Diri diperlukan.',
                'password.min' => 'Kata Laluan mesti sekurang-kurangnya 12 aksara.',
                'password.regex' => 'Minimum 1 huruf kecil, 1 huruf besar, 1 nombor dan 1 simbol.',
                'password.confirmed' => 'Kata Laluan dan Pengesahan Kata Laluan tidak sepadan.',
            ]);
        }
        else{

            //No password changes
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:50',
                'identification_card_number' => 'required|min:12|max:12',
                'txtStartDate' => 'required',
            ],
            [
                'name.required' => 'Nama Penuh diperlukan.',
                'identification_card_number.required' => 'No Kad Pengenalan diperlukan.',
                'identification_card_number.min' => 'No Kad Pengenalan mestilah 12 digit.',
                'identification_card_number.max' => 'No Kad Pengenalan mestilah 12 digit.',
                'email.required' => 'Emel diperlukan.',
                'email.email' => 'Format emel yang dimasukkan tidak sah.',
                'txtStartDate.required' => 'Tarikh Lapor Diri diperlukan.',
            ]);
        }

        DB::beginTransaction();

        try {
            $user->name = $request->name;
            $user->username = $request->identification_card_number;
            $user->email = $request->email;
            $user->entity_id = $request->selEntity;

            if(!empty($request->txtMobileNo)){
                $user->mobile_contact_number = "+60".$request->txtMobileNo;
            }else{
                $user->mobile_contact_number = $request->txtMobileNo;
            }

            if(!empty($request->txtOfficePhoneNo)){
                $user->contact_number = "+60".$request->txtOfficePhoneNo; //OfficePhoneNo
            }else{
                $user->contact_number = $request->txtOfficePhoneNo; //OfficePhoneNo
            }
            
            if (!$user->is_admin) {
                if (!empty($user->email_verified_at)) {
                    $user->email_verified_at = empty($request->verified) ? null : $user->email_verified_at;
                }
                else {
                    $user->email_verified_at = empty($request->verified) ? null : Carbon::now();
                }
            }

            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            if (!$user->is_admin) {
                $user->is_active = !empty($request->active) ? '1' : '0';                
            }

            $user->updated_by = Auth::id();
            $user->save();

            $user->roles()->detach();
            if ($user->is_admin) {
                $user->roles()->attach(Role::getAdminRole());
            }
            if (!empty($request->input('roles_id'))) {
                $user->roles()->attach($request->input('roles_id'));
            }

            $audit_details = json_encode([ 
                'name' => $request->name,
                'username' => $request->identification_card_number,
                'email' => $request->email,
                'mobile_contact_number' => $request->txtMobileNo,
                'contact_number' => $request->txtOfficePhoneNo,
                'new_password' => ($user->is_admin ? 'no' : !empty($request->password)) ? 'yes' : 'no',
                'status' => !empty($request->active) ? 'active' : 'inactive',
            ]);
            Audit::log('users', 'update', $audit_details);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'name' => $request->name,
                'username' => $request->identification_card_number,
                'email' => $request->email,
                'mobile_contact_number' => $request->txtMobileNo,
                'contact_number' => $request->txtOfficePhoneNo,
                'new_password' => !empty($request->password) ? 'yes' : 'no',
                'status' => !empty($request->active) ? 'active' : 'inactive',
            ]);
            Audit::log('users', 'update', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        //return redirect()->action('UserController@index')->with('t_success', __('app.user_updated', [ 'user' => $user->name ]));
        return redirect()->action('UserController@index')->with('alert', 'Pengguna berjaya disimpan !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //request()->user()->isAuthorize('delete-user');

        try {
            $user->deleted_by = Auth::id();
            $user->save();
            $user->delete();

            $audit_details = json_encode([ 
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'status' => $user->is_active ? 'active' : 'inactive',
            ]);
            Audit::log('users', 'delete', $audit_details);
        }
        catch (Exception $e) {
            $audit_details = json_encode([ 
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'status' => $user->is_active ? 'active' : 'inactive',
            ]);
            Audit::log('users', 'delete', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }
        return redirect()->action('UserController@index')->with('t_info', __('app.user_deleted', [ 'user' => $user->name ]));
    }

    /**
     * Export users to excel.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function exportExcel(Request $request) 
    {
        //$request->user()->isAuthorize('export-user');

        Audit::log('users', 'export', json_encode(['file_type' => 'Excel']));

        $filter = !empty($request->q) ? $request->q : '';
        return Excel::download(new UserExport($filter), __('module.users').'_'.Carbon::now()->format('YmdHis').'.xlsx');
    }

    /**
     * Export users to pdf.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function exportPdf(Request $request) 
    {
        //$request->user()->isAuthorize('export-user');
        
        Audit::log('users', 'export', json_encode(['file_type' => 'PDF']));
        
        $data['users'] = User::where('is_admin', false)->orderBy('name')->get();
        if (!empty($request->q)) {
            $filter = $request->q;
            $data['users'] = User::whereHas('roles', 
                function ($query) use ($filter) {
                    $query->where('name', 'like', '%'.$filter.'%');
                })
                ->orWhere('name', 'like', '%'.$filter.'%')
                ->orWhere('username', 'like', '%'.$filter.'%')
                ->orWhere('email', 'like', '%'.$filter.'%')
                ->where('is_admin', false)
                ->orderBy('name')
                ->get();
        }
        
        $pdf = PDF::loadView('app.admin.user.pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        $pdf->getDomPDF()->set_option('enable_php', true);

        // View on page
        return $pdf->stream(__('module.users').'_'.Carbon::now()->format('YmdHis').'.pdf');

        // Download
        // return $pdf->download(__('module.users').'_'.Carbon::now()->format('YmdHis').'.pdf');
    }

    /**
     * Display user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return view('auth.profile');
    }

    /**
     * Update user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'identification_card_number' => 'required|string|min:12|max:255|unique:users,username,'.Auth::id(),
            'email' => 'required|string|email|max:50|unique:users,email,'.Auth::id(),
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        //$user->last_name = $request->last_name;
        $user->username = $request->identification_card_number;
        $user->email = $request->email;
        $user->updated_by = Auth::id();
        $user->save();

        $audit_details = json_encode([ 
            'name' => $user->name,
            'username' => $user->identification_card_number,
            'email' => $user->email,
        ]);

        Audit::log('profile', 'update', $audit_details);

        return redirect()->back()->with('t_success', __('auth.profile_updated'));
    }

    /**
     * Update profile picture.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function updateProfilePicture(Request $request)
    {
        $this->validate($request, [
            'profile-picture' => 'image|mimes:jpeg,jpg,png,gif|max:65536'
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile-picture')) {
            if (Storage::exists('public/profile-picture/'.$user->profile_picture)) {
                Storage::delete('public/profile-picture/'.$user->profile_picture);
                if (Storage::exists('public/profile-picture/.original/'.$user->profile_picture)) {
                    Storage::delete('public/profile-picture/.original/'.$user->profile_picture);                
                }
            }

            $profilePictureExt = request()->file('profile-picture')->getClientOriginalExtension();
            $profilePictureName = Auth::id().'.'.$profilePictureExt;

            if (strcasecmp($profilePictureExt, 'jpeg') === 0 || strcasecmp($profilePictureExt, 'jpg') === 0 || strcasecmp($profilePictureExt, 'png') === 0 || strcasecmp($profilePictureExt, 'gif') === 0) {
                // Upload File
                $request->file('profile-picture')->storeAs('public/profile-picture/.original/', $profilePictureName);

                // Crop image
                $img = Image::make(public_path('storage/profile-picture/.original/'.$profilePictureName));
                $width = Image::make(public_path('storage/profile-picture/.original/'.$profilePictureName))->width();
                $height = Image::make(public_path('storage/profile-picture/.original/'.$profilePictureName))->height();
                $path = public_path('storage/profile-picture/'.$profilePictureName);

                //$img->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));
                if ($width > 800 && $height > 800) {
                    $img->fit(800);
                }
                else {
                    if ($width > $height) {
                        $img->fit($height);
                    }
                    else {
                        $img->fit($width);
                    }
                }
                $img->save($path);
            }
            else {
                $request->file('profile-picture')->storeAs('public/profile-picture/', $profilePictureName);
                $request->file('profile-picture')->storeAs('public/profile-picture/.original/', $profilePictureName);
            }

            $user->profile_picture = $profilePictureName;
            $user->updated_by = Auth::id();
            $user->save();

            Audit::log('profile_picture', 'update');

            return redirect()->back()->with('t_info', __('auth.profile_picture_updated'));
        }
    }

    /**
     * Rotate profile picture.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function rotateProfilePicture(Request $request)
    {
        $info = pathinfo(storage_path().'/profile-picture/'.Auth::user()->profile_picture);
        $ext = $info['extension'];

        if (strcasecmp($ext, 'jpeg') === 0 || strcasecmp($ext, 'jpg') === 0 || strcasecmp($ext, 'png') === 0 || strcasecmp($ext, 'gif') === 0) {
            $img = Image::make(public_path('storage/profile-picture/'.Auth::user()->profile_picture));
            $img->rotate(-90);
            Storage::delete('public/profile-picture/'.Auth::user()->profile_picture);
            $img->save(public_path('storage/profile-picture/'.Auth::user()->profile_picture));

            // original
            $img2 = Image::make(public_path('storage/profile-picture/.original/'.Auth::user()->profile_picture));
            $img2->rotate(-90);
            Storage::delete('public/profile-picture/.original/'.Auth::user()->profile_picture);
            $img2->save(public_path('storage/profile-picture/.original/'.Auth::user()->profile_picture));

            $request->session()->flash('t_info', __('auth.profile_picture_rotated'));
        }
        else {
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->back();
    }

    /**
     * Delete profile picture.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function deleteProfilePicture()
    {
        $user = Auth::user();

        if (Storage::exists('public/profile-picture/'.$user->profile_picture)) {
            Storage::delete('public/profile-picture/'.$user->profile_picture);
            if (Storage::exists('public/profile-picture/.original/'.$user->profile_picture)) {
                Storage::delete('public/profile-picture/.original/'.$user->profile_picture);                
            }
        }
            
        $user->profile_picture = null;
        $user->updated_by = Auth::id();
        $user->save();

        Audit::log('profile_picture', 'delete');

        return redirect()->back()->with('t_info', __('auth.profile_picture_deleted'));
    }

    /**
     * Change password.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword()
    {
        return view('auth.change_password', [
            'breadcrumb_parent_name' => __('module.profile'),
            'breadcrumb_parent_url' => route('profile'),
        ]);
    }
 
    /**
     * Change password.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function postChangePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        if (!(Hash::check($request->current_password, Auth::user()->password))) {
            // Passwords not matches
            Audit::log('profile', 'change_password', json_encode(['new_password' => 'yes']), 'Current password do not match.');
            return redirect()->back()->withErrors(['current_password' => __('auth.current_password_error')]);
        }
        if (strcmp($request->current_password, $request->new_password) === 0) {
            // Current password and new password cannot be same
            Audit::log('profile', 'change_password', json_encode(['new_password' => 'yes']), 'New password cannot be same as current password.');
            return redirect()->back()->withErrors(['new_password' => __('auth.new_and_current_password_error')]);
        }

        // Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->updated_by = Auth::id();
        $user->save();

        Audit::log('profile', 'change_password', json_encode(['new_password' => 'yes']));

        return redirect()->back()->with('success', __('auth.password_changed'));
    }

    public function getIcno(Request $request)
    {
		 // Assume you have a User model with an 'icno' field
         $icno = $request->input('icno');
         $user = MyIdentity::where('username', $icno)->first();
     
         if ($user) {
             return response()->json([
                 'success' => true,
                 'owner' => [
                     'icno' => $user->username,
                     'name' => $user->name

                    
                 ]
             ]);
         } else {
             return response()->json(['success' => false]);
         }
    }

    public function registerpassword($id)
    {
        $user = User::find($id);

        return view('app.admin.user.user_password', [
            'id' => $id,
            'user' => $user,
        ]);
    }

    public function updateregisterpassword(Request $request, $id)
    {
        $this->validate($request, [
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:12', // Minimum length of 12 characters
                //'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/', // At least one uppercase, one number, one special character
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#,.])[A-Za-z\d@$!%*?&#,.]{12,}$/',
            ],
            'password_confirmation' => 'required|string',
        ],
        [
            'password.min' => 'Kata Laluan mesti sekurang-kurangnya 12 aksara.',
            'password.regex' => 'Minimum 1 huruf kecil, 1 huruf besar, 1 nombor dan 1 simbol.',
            'password.confirmed' => 'Kata Laluan dan Pengesahan Kata Laluan tidak sepadan.',
        ]);

        DB::beginTransaction();

        try {

            $user = User::find($id);

            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('Auth\AuthenticatedSessionController@create')->with('status_reset', 'Pengesahan Kata Laluan berjaya !!');

        //return redirect()->action('Auth\AuthenticatedSessionController@welcome')->with('t_success', __('app.user_updated', [ 'user' => $user->name ]));
        /*return view('auth.login', [

        ]);*/

    }

}
