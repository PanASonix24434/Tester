<?php

namespace App\Http\Controllers\VesselManager;

use App\Enums\ApplicationType;
use App\Http\Controllers\Controller;
use App\Mail\VesselManagerRegistered;
use App\Models\ApplicationV2;
use App\Models\Approval;
use App\Models\Attachment;
use App\Models\ProfileUser;
use App\Models\User;
use App\Models\Vessel;
use Exception;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

use Auth;
use Audit;
use Carbon\Carbon;
use PDF;
use Storage;
use Image;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $type_vessel_manager = Helper::getCodeMasterIdByTypeName('user_type', 'PENGURUS VESEL');
            $query = ApplicationV2::join('application_v2_profile_user', 'applications_v2.id', '=', 'application_v2_profile_user.application_id')
                ->join('profile_users', 'profile_users.id', '=', 'application_v2_profile_user.profile_user_id')
                ->join('application_v2_vessel', 'applications_v2.id', '=', 'application_v2_vessel.application_id')
                ->join('vessels', 'vessels.id', '=', 'application_v2_vessel.vessel_id')
                ->where('profile_users.type_id', $type_vessel_manager)
                ->groupBy([
                    'applications_v2.id',
                    'profile_users.ref',
                    'profile_users.name',
                    'profile_users.phone_code',
                    'profile_users.phone',
                    'applications_v2.status',
                ])
                ->select([
                    'applications_v2.id',
                    'profile_users.ref',
                    'profile_users.name',
                    'profile_users.phone_code',
                    'profile_users.phone',
                    'applications_v2.status',
                    DB::raw('GROUP_CONCAT(vessels.vessel_no ORDER BY vessels.vessel_no ASC SEPARATOR ", ") as vessels_no'),
                ]);

            return datatables()->of($query)
                ->addIndexColumn()
                ->filterColumn('vessels_no', function ($query, $keyword) {
                    $query->whereRaw("
                        EXISTS (
                            SELECT 1 FROM vessels
                            WHERE vessels.id = profile_user_vessel.vessel_id
                            AND vessels.vessel_no LIKE ?
                        )", ["%{$keyword}%"]);
                })
                ->orderColumn('vessels_no', function ($query, $direction) {
                    $query->orderByRaw("GROUP_CONCAT(vessels.vessel_no ORDER BY vessels.vessel_no ASC) $direction");
                })
                ->editColumn('phone', function ($row) {
                    return $row->phone_code.$row->phone;
                })
                ->editColumn('status', function ($row) {
                    if (strcasecmp($row->status, ApplicationV2::STATUS_VERIFIED) === 0) {
                        return '<span class="badge bg-success">Disahkan</span>';
                    } else if (strcasecmp($row->status, ApplicationV2::STATUS_UNVERIFIED) === 0) {
                        return '<span class="badge bg-danger">Tidak Disahkan</span>';
                    } else if (strcasecmp($row->status, ApplicationV2::STATUS_SUBMITTED) === 0) {
                        return '<span class="badge bg-warning">Dihantar</span>';
                    } else if (strcasecmp($row->status, ApplicationV2::STATUS_INACTIVE) === 0) {
                        return '<span class="badge bg-secondary">Tidak Aktif</span>';
                    } else {
                        return '-';
                    }
                })
                ->addColumn('action', function ($row) {
                    $action = '';
                    if ($row->isVerified() || $row->isSubmitted()) {
                        $action .= '
                            <a href="'.route('profile.vesselmanager.show', $row->id).'" class="btn btn-light btn-sm">
                                <i class="fas fa-eye fa-fw text-info"></i>
                            </a>';
                    } else {
                        $action .= '
                            <a href="'.route('profile.vesselmanager.edit', $row->id).'" class="btn btn-light btn-sm">
                                <i class="fas fa-edit fa-fw text-info"></i>
                            </a>';
                    }
                    if ($row->isDeactivated()) {
                        $action .= '
                            <button type="button" class="btn btn-light btn-sm" disabled>
                                <i class="fas fa-times fa-fw text-danger"></i>
                            </button>';
                    } else {
                        $action .= '
                            <button type="button" class="btn btn-light btn-sm button-deactivate"
                                data-url="'.route('profile.vesselmanager.deactivate', $row->id).'"
                                data-text="Profil pengurus vesel ['.$row->ref.'] akan dinyahaktif.">
                                <i class="fas fa-times fa-fw text-danger"></i>
                            </button>';
                    }
                    return $action;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('app.vessel.manager.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_vessel_manager = Helper::getCodeMasterIdByTypeName('user_type', 'PENGURUS VESEL');

        return view('app.vessel.manager.create', [
            'managers' => ProfileUser::where('type_id', $type_vessel_manager)
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
            'vessels' => Vessel::orderBy('vessel_no')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //dd('Test ..');

        $type_vessel_manager = Helper::getCodeMasterIdByTypeName('user_type', 'PENGURUS VESEL');

        $email_rule = Rule::unique('profile_users')->where('type_id', $type_vessel_manager);
        if ($request->select_manager) {
            $email_rule->ignore($request->select_manager);
        }

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'icno' => 'required|string|max:12',
            'phone' => 'required|string',
            'vessel.*' => 'required',
            'email' => ['required', 'email', 'max:255', $email_rule],
            'bumiputera_status' => 'required',
        ], [], [
            'name' => 'Nama Pengurus Vesel',
            'icno' => 'No. Kad Pengenalan',
            'phone' => 'No. Telefon Bimbit',
            'vessel.*' => 'No. Pendaftaran Vesel',
            'email' => 'Emel',
            'bumiputera_status' => 'Status Bumiputera',
        ]);

        $new_manager = false;
        $is_quota_full = true;
        $require_verification = false;

        DB::beginTransaction();

        try {
            $temp_password = Str::random(8);

            // insert or update user
            $user = User::where('email', $request->email)->first();
            if ($user == null) {
                $new_manager = true;

                $user = new User;
                $user->email = $request->email;
                $user->email_verified_at = now();
                $user->password = Hash::make($temp_password);
                $user->is_active = false;
            }
            $user->name = $request->name;
            $user->username = $request->icno;
            $user->save();

            // insert or update profile user
            $profile = ProfileUser::where('user_id', $user->id)->first();
            if ($profile == null) {
                $profile = new ProfileUser;
                $profile->user_id = $user->id;
                $profile->is_active = false;
                $profile->created_by = auth()->id();
                $profile->updated_by = auth()->id();
            }
            $profile->type_id = Helper::getCodeMasterIdByTypeName('user_type', 'PENGURUS VESEL');
            $profile->ref = $request->icno;
            $profile->name = $request->name;
            //Asyraf
            $profile->icno = $request->icno;
            $profile->user_type = Helper::getCodeMasterIdByTypeName('user_type', 'PENGURUS VESEL');
            $profile->no_phone = '+60'.$request->phone;
            $profile->is_active = true;
            $profile->is_active_ajim = true;

            $profile->email = $request->email;
            $profile->phone_code = '60';
            $profile->phone = (int) $request->phone;
            $profile->is_bumiputera = strcasecmp($request->bumiputera_status, 'yes') === 0 ? true : false;
            $profile->save();

            // insert application
            $application = new ApplicationV2;
            $application->type = ApplicationType::VESSEL_MANAGER_REGISTRATION;
            $application->status = ApplicationV2::STATUS_SUBMITTED;
            $application->save();

            // sync profile user to application
            $application->profileUsers()->sync($profile->id);

            // sync vessel to application
            $application->vessels()->sync($request->input('vessel'));

            // replicate ic copy
            if ($profile->icCopy()) {
                $attachment_new = $profile->icCopy()->replicate();
                $attachment_new->id = Str::uuid();
                $attachment_new->object_type = 'application_v2';
                $attachment_new->object_id = $application->id;
                $attachment_new->save();
            }

            // insert ic copy
            if ($request->hasFile('ic_copy')) {
                $ic_copy = $request->file('ic_copy');
                $ic_copy_name = 'Salinan Kad Pengenalan';
                $ic_copy_filename = $ic_copy->getClientOriginalName();
                $ic_copy_ext = $ic_copy->getClientOriginalExtension();
                $ic_copy_size = $ic_copy->getSize();

                $path = 'application/vesselmanager/'.$application->id;
                $ic_copy->storeAs($path, $ic_copy_filename, 'public');

                $attachment = new Attachment;
                $attachment->object_type = 'application_v2';
                $attachment->object_id = $application->id;
                $attachment->name = $ic_copy_name;
                $attachment->filename = $ic_copy_filename;
                $attachment->slug = Str::slug($ic_copy_name);
                $attachment->ext = $ic_copy_ext;
                $attachment->size = $ic_copy_size;
                $attachment->path = $path;
                $attachment->uploaded_by = auth()->id();
                $attachment->save();
            }

            // insert surat wakil kuasa
            if ($request->hasFile('surat_wakil_kuasa')) {
                $surat_wakil_kuasa = $request->file('surat_wakil_kuasa');
                $surat_wakil_kuasa_name = 'Surat Wakil Kuasa daripada Pemilik kepada Pengurus Vesel';
                $surat_wakil_kuasa_filename = $surat_wakil_kuasa->getClientOriginalName();
                $surat_wakil_kuasa_ext = $surat_wakil_kuasa->getClientOriginalExtension();
                $surat_wakil_kuasa_size = $surat_wakil_kuasa->getSize();

                $path = 'application/vesselmanager/'.$application->id;
                $surat_wakil_kuasa->storeAs($path, $surat_wakil_kuasa_filename, 'public');

                $attachment = new Attachment;
                $attachment->object_type = 'application_v2';
                $attachment->object_id = $application->id;
                $attachment->name = $surat_wakil_kuasa_name;
                $attachment->filename = $surat_wakil_kuasa_filename;
                $attachment->slug = Str::slug($surat_wakil_kuasa_name);
                $attachment->ext = $surat_wakil_kuasa_ext;
                $attachment->size = $surat_wakil_kuasa_size;
                $attachment->path = $path;
                $attachment->uploaded_by = auth()->id();
                $attachment->save();
            }

            // insert approval
            $approval = new Approval;
            $approval->object_type = 'application_v2';
            $approval->object_id = $application->id;
            $approval->action_by_type = 'user';
            $approval->action_by_id = auth()->id();
            $approval->action = 'submitted';
            $approval->save();

            $require_verification = $new_manager ? true : $require_verification;

            $vessel_array = $request->input('vessel');
            if ($vessel_array && is_array($vessel_array)) {
                $vessels = Vessel::whereIn('id', $vessel_array)->get();

                foreach ($vessels as $vessel) {
                    // checking if vessel is in zone A or B which require verification by KDP
                    if (strcasecmp($vessel->zone, 'A') === 0 || strcasecmp($vessel->zone, 'B') === 0) {
                        $require_verification = true;
                        break;
                    }
                }

                foreach ($vessels as $vessel) {
                    // checking vessel quota
                    if (!$vessel->isQuotaFull()) {
                        $is_quota_full = false;
                        if (!$require_verification) {
                            // assign profile as manager if quota not full and not require verification
                            $vessel->addManager($profile->id);
                        }
                    }
                }
            }

            if ($is_quota_full) {
                $application->status = ApplicationV2::STATUS_INACTIVE;
            } else if ($require_verification) {
                $application->status = ApplicationV2::STATUS_SUBMITTED;
            } else {
                $application->status = ApplicationV2::STATUS_VERIFIED;
            }
            $application->save();

            //Asyraf
            $audit_details = json_encode([ 
                'icno' => $request->icno, 
                'name' => $request->name,
            ]);
            Audit::log('profile_vessel', 'create', $audit_details);

            DB::commit();

            // send email to manager
            if (!$require_verification && !$is_quota_full) {
                if ($new_manager) {
                    Mail::to($user)->send(new VesselManagerRegistered([
                        'name' => $profile->name,
                        'icno' => $profile->icno,
                        'password' => $temp_password,
                        'vessel_no' => $application->vessels()->pluck('vessel_no')->implode(', '),
                    ]));
                } else {
                    Mail::to($user)->send(new VesselManagerRegistered([
                        'name' => $profile->name,
                        'icno' => $profile->icno,
                        'password' => $temp_password,
                        'vessel_no' => $application->vessels()->pluck('vessel_no')->implode(', '),
                    ], 'existing'));
                }
            }

        } catch (Exception $e) {
            DB::rollBack();

            //Asyraf
            $audit_details = json_encode([ 
                'icno' => $request->icno, 
                'name' => $request->name,
            ]);
            Audit::log('profile_vessel', 'create', $audit_details, $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('sa_error', 'Ralat berlaku. Sila cuba semula.');
        }

        if ($is_quota_full) {
            session()->flash('sa_warning', 'Kuota vesel telah penuh.');
        } else if ($require_verification) {
            session()->flash('sa_success', 'Maklumat pengurus vesel dihantar untuk pengesahan.');
        } else {
            session()->flash('sa_success', 'Maklumat pengurus vesel disimpan.');
        }

        return redirect()->route('profile.vesselmanager.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $application = ApplicationV2::find($id);

        abort_unless($application, 404);

        if ($application->isUnverified()) {
            session()->flash('danger', $application->approvals()->latest()->first()?->remarks);
        }

        return view('app.vessel.manager.show', [
            'application' => $application,
            'profile' => $application->profileUsers()->first(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $type_vessel_manager = Helper::getCodeMasterIdByTypeName('user_type', 'PENGURUS VESEL');
        $application = ApplicationV2::find($id);

        abort_unless($application, 404);

        if ($application->isUnverified()) {
            session()->flash('danger', $application->approvals()->latest()->first()?->remarks);
        }

        return view('app.vessel.manager.edit', [
            'application' => $application,
            'profile' => $application->profileUsers()->first(),
            'managers' => ProfileUser::where('type_id', $type_vessel_manager)
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
            'vessels' => Vessel::orderBy('vessel_no')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $application = ApplicationV2::find($id);

        abort_unless($application, 404);

        $profile = $application->profileUsers()->first();
        $type_vessel_manager = Helper::getCodeMasterIdByTypeName('user_type', 'PENGURUS VESEL');

        $email_rule = Rule::unique('profile_users')->where('type_id', $type_vessel_manager)->ignore($profile->id);
        if ($request->select_manager) {
            $email_rule->ignore($request->select_manager);
        }

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'icno' => 'required|string|max:12',
            'phone' => 'required|string',
            'vessel.*' => 'required',
            'email' => ['required', 'email', 'max:255', $email_rule],
            'bumiputera_status' => 'required',
        ], [], [
            'name' => 'Nama Pengurus Vesel',
            'icno' => 'No. Kad Pengenalan',
            'phone' => 'No. Telefon Bimbit',
            'vessel.*' => 'No. Pendaftaran Vesel',
            'email' => 'Emel',
            'bumiputera_status' => 'Status Bumiputera',
        ]);

        $is_quota_full = true;
        $require_verification = (strcasecmp($application->status, ApplicationV2::STATUS_UNVERIFIED) === 0 || strcasecmp($application->status, ApplicationV2::STATUS_INACTIVE) === 0) ? true : false;

        DB::beginTransaction();

        try {
            // update profile user
            $profile->ref = $request->icno;
            $profile->name = $request->name;
            $profile->email = $request->email;
            $profile->phone_code = '60';
            $profile->phone = (int) $request->phone;
            $profile->is_bumiputera = strcasecmp($request->bumiputera_status, 'yes') === 0 ? true : false;
            $profile->updated_by = auth()->id();
            $profile->save();

            $temp_password = Str::random(8);

            // update user
            $user = $profile->user;
            $user->name = $request->name;
            $user->username = $request->icno;
            $user->email = $request->email;
            $user->password = Hash::make($temp_password);
            $user->save();

            // sync vessel to application
            $application->vessels()->sync($request->input('vessel'));

            // replicate ic copy
            if ($profile->icCopy() && !$application->icCopy()->id) {
                $attachment_new = $profile->icCopy()->replicate();
                $attachment_new->id = Str::uuid();
                $attachment_new->object_type = 'application_v2';
                $attachment_new->object_id = $application->id;
                $attachment_new->save();
            }

            // insert ic copy
            if ($request->hasFile('ic_copy')) {
                $ic_copy = $request->file('ic_copy');
                $ic_copy_name = 'Salinan Kad Pengenalan';
                $ic_copy_filename = $ic_copy->getClientOriginalName();
                $ic_copy_ext = $ic_copy->getClientOriginalExtension();
                $ic_copy_size = $ic_copy->getSize();

                $path = 'application/vesselmanager/'.$application->id;
                $ic_copy->storeAs($path, $ic_copy_filename, 'public');

                $attachment = new Attachment;
                $attachment->object_type = 'application_v2';
                $attachment->object_id = $application->id;
                $attachment->name = $ic_copy_name;
                $attachment->filename = $ic_copy_filename;
                $attachment->slug = Str::slug($ic_copy_name);
                $attachment->ext = $ic_copy_ext;
                $attachment->size = $ic_copy_size;
                $attachment->path = $path;
                $attachment->uploaded_by = auth()->id();
                $attachment->save();
            }

            // insert surat wakil kuasa
            if ($request->hasFile('surat_wakil_kuasa')) {
                $surat_wakil_kuasa = $request->file('surat_wakil_kuasa');
                $surat_wakil_kuasa_name = 'Surat Wakil Kuasa daripada Pemilik kepada Pengurus Vesel';
                $surat_wakil_kuasa_filename = $surat_wakil_kuasa->getClientOriginalName();
                $surat_wakil_kuasa_ext = $surat_wakil_kuasa->getClientOriginalExtension();
                $surat_wakil_kuasa_size = $surat_wakil_kuasa->getSize();

                $path = 'application/vesselmanager/'.$application->id;
                $surat_wakil_kuasa->storeAs($path, $surat_wakil_kuasa_filename, 'public');

                $attachment = new Attachment;
                $attachment->object_type = 'application_v2';
                $attachment->object_id = $application->id;
                $attachment->name = $surat_wakil_kuasa_name;
                $attachment->filename = $surat_wakil_kuasa_filename;
                $attachment->slug = Str::slug($surat_wakil_kuasa_name);
                $attachment->ext = $surat_wakil_kuasa_ext;
                $attachment->size = $surat_wakil_kuasa_size;
                $attachment->path = $path;
                $attachment->uploaded_by = auth()->id();
                $attachment->save();
            }

            // insert approval
            $approval = new Approval;
            $approval->object_type = 'application_v2';
            $approval->object_id = $application->id;
            $approval->action_by_type = 'user';
            $approval->action_by_id = auth()->user()->id;
            $approval->action = 'submitted';
            $approval->save();

            $vessel_array = $request->input('vessel');
            if ($vessel_array && is_array($vessel_array)) {
                $vessels = Vessel::whereIn('id', $vessel_array)->get();

                foreach ($vessels as $vessel) {
                    // checking if vessel is in zone A or B which require verification by KDP
                    if (strcasecmp($vessel->zone, 'A') === 0 || strcasecmp($vessel->zone, 'B') === 0) {
                        $require_verification = true;
                        break;
                    } else {
                        $require_verification = false;
                    }
                }

                foreach ($vessels as $vessel) {
                    $vessel->removeManager($profile->id);
                    // checking vessel quota
                    if (!$vessel->isQuotaFull($profile->id)) {
                        $is_quota_full = false;
                        if (!$require_verification) {
                            // assign profile as manager if quota not full and not require verification
                            $vessel->addManager($profile->id);
                        }
                    }
                }
            }

            if ($is_quota_full) {
                $application->status = ApplicationV2::STATUS_INACTIVE;
            } else if ($require_verification) {
                $application->status = ApplicationV2::STATUS_SUBMITTED;
            } else {
                $application->status = ApplicationV2::STATUS_VERIFIED;
            }
            $application->save();

            DB::commit();

            if (!$require_verification && !$is_quota_full) {
                Mail::to($user)->send(new VesselManagerRegistered([
                    'name' => $profile->name,
                    'icno' => $profile->icno,
                    'password' => $temp_password,
                    'vessel_no' => $application->vessels()->pluck('vessel_no')->implode(', '),
                ]));
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('sa_error', 'Ralat berlaku. Sila cuba semula.');
        }

        if ($is_quota_full) {
            session()->flash('sa_warning', 'Kuota vesel telah penuh.');
        } else if ($require_verification) {
            session()->flash('sa_success', 'Maklumat pengurus vesel dihantar untuk pengesahan.');
        } else {
            session()->flash('sa_success', 'Maklumat pengurus vesel dikemaskini.');
        }

        return redirect()->route('profile.vesselmanager.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function deactivate(string $id)
    {
        $application = ApplicationV2::find($id);

        abort_unless($application, 404);

        DB::beginTransaction();

        try {
            $application->status = ApplicationV2::STATUS_INACTIVE;
            $application->save();

            $profile = $application->profileUsers()->first();

            foreach ($application->vessels as $vessel) {
                $vessel->removeManager($profile->id);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('sa_error', 'Ralat berlaku. Sila cuba semula.');
        }

        return redirect()->route('profile.vesselmanager.index')
            ->with('sa_success', 'Profil pengurus vesel telah dinyahaktif.');
    }
}
