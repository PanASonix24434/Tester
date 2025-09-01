<?php

namespace App\Http\Controllers\VesselManager;

use App\Http\Controllers\Controller;
use App\Mail\VesselManagerRegistered;
use App\Models\ApplicationV2;
use App\Models\Approval;
use App\Models\ProfileUser;
use Carbon\Carbon;
use Exception;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VerificationController extends Controller
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
                ->where('applications_v2.status', ApplicationV2::STATUS_SUBMITTED)
                ->where('profile_users.user_type', $type_vessel_manager)
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
                    DB::raw('GROUP_CONCAT(CONCAT(vessels.vessel_no, " (Zon ", vessels.zone, ")") ORDER BY vessels.vessel_no ASC SEPARATOR ", ") as vessels_with_zones'),
                ]);

            return datatables()->of($query)
                ->addIndexColumn()
                ->filterColumn('vessels_no', function ($q, $keyword) {
                    $q->whereRaw("
                        EXISTS (
                            SELECT 1 FROM vessels
                            WHERE vessels.id = profile_user_vessel.vessel_id
                            AND vessels.vessel_no LIKE ?
                        )", ["%{$keyword}%"]);
                })
                ->orderColumn('vessels_no', function ($query, $direction) {
                    $query->orderByRaw("GROUP_CONCAT(vessels.vessel_no ORDER BY vessels.vessel_no ASC) $direction");
                })
                ->editColumn('status', function ($row) {
                    return '<span class="badge bg-warning">Menunggu Pengesahan</span>';
                })
                ->editColumn('phone', function ($row) {
                    return $row->phone_code.$row->phone;
                })
                ->addColumn('action', function ($row) {
                    $action = '';
                    if ($row->isSubmitted()) {
                        $action .= '
                            <a href="'.route('profile_verification.vesselmanager.edit', $row->id).'" class="btn btn-light btn-sm">
                                <i class="fas fa-edit fa-fw text-success"></i>
                            </a>';
                    } else {
                        $action .= '
                            <button type="button" class="btn btn-light btn-sm" disabled>
                                <i class="fas fa-edit fa-fw text-success"></i>
                            </button>';
                    }
                    return $action;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('app.vessel.manager.verification.index');
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
        $application = ApplicationV2::find($id);

        abort_unless($application, 404);

        return view('app.vessel.manager.verification.verify', [
            'application' => $application,
            'profile' => $application->profileUsers()->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'approval_status' => 'required',
            'approval_remarks' => 'required',
        ], [], [
            'approval_status' => 'Pengesahan',
            'approval_remarks' => 'Ulasan',
        ]);

        $application = ApplicationV2::find($id);
        $profile = $application->profileUsers()->first();
        $is_quota_full = true;

        DB::beginTransaction();

        try {
            $temp_password = Str::random(8);

            $profile->is_active = true;
            $profile->save();

            $user = $profile->user;
            $user->password = Hash::make($temp_password);
            $user->is_active = true;
            $user->save();

            $application->status = $request->approval_status;
            $application->save();

            $approval = new Approval;
            $approval->object_type = 'application_v2';
            $approval->object_id = $application->id;
            $approval->action_by_type = 'user';
            $approval->action_by_id = auth()->id();
            $approval->action = $request->approval_status;
            $approval->remarks = $request->approval_remarks;
            $approval->save();

            if (strcasecmp($request->approval_status, ApplicationV2::STATUS_VERIFIED) === 0) {
                foreach ($application->vessels as $vessel) {
                    if (!$vessel->isQuotaFull($profile->id)) {
                        $vessel->addManager($profile->id);
                        $is_quota_full = false;
                    }
                }

                if ($is_quota_full) {
                    $application->status = ApplicationV2::STATUS_UNVERIFIED;
                    $application->save();
                }

                // copy ic to manager
                $attachment = $application->attachments()
                    ->where('slug', 'salinan-kad-pengenalan')
                    ->first();
                if ($attachment) {
                    $attachment_new = $attachment->replicate();
                    $attachment_new->id = Str::uuid();
                    $attachment_new->object_type = 'profile_user';
                    $attachment_new->object_id = $profile->id;
                    $attachment_new->save();
                }
            }

            if (strcasecmp($request->approval_status, ApplicationV2::STATUS_VERIFIED) === 0 && $is_quota_full) {
                $approval2 = new Approval;
                $approval2->object_type = 'application_v2';
                $approval2->object_id = $application->id;
                $approval2->action_by_type = 'user';
                $approval2->action_by_id = auth()->id();
                $approval2->action = 'unverified';
                $approval2->remarks = 'Kuota vesel telah penuh';
                $approval2->created_at = Carbon::now()->addMinute();
                $approval2->save();
            }

            DB::commit();

            if (strcasecmp($application->status, ApplicationV2::STATUS_VERIFIED) === 0 && !$is_quota_full) {
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

        if ($is_quota_full && strcasecmp($request->approval_status, ApplicationV2::STATUS_VERIFIED) === 0) {
            session()->flash('sa_warning', 'Pengesahan maklumat pengurus vesel ['.$profile->ref.'] tidak dapat disahkan kerana kuota vesel telah penuh.');
        } else {
            session()->flash('sa_success', 'Pengesahan maklumat pengurus vesel ['.$profile->ref.'] telah disimpan.');
        }

        return redirect()->route('profile_verification.vesselmanager.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
