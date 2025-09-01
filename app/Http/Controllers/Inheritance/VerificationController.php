<?php

namespace App\Http\Controllers\Inheritance;

use App\Http\Controllers\Controller;
use App\Mail\NewInheritanceAdmin;
use App\Models\Approval;
use App\Models\ProfilePentadbirHarta;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            $query = ProfilePentadbirHarta::select('*'); // remove where() for now


            return datatables()->of($query)
                ->addIndexColumn()
                ->editColumn('status_pengguna', function ($row) {
                    return Str::title(str_replace('_', ' ', $row->status_pengguna));
                })
                ->editColumn('hubungan', function ($row) {
                    return Str::title(str_replace('_', ' ', $row->hubungan));
                })
                ->editColumn('status', function ($row) {
                    if ($row->status === 'submitted') {
                        return '<span class="badge bg-warning">Menunggu Pengesahan</span>';
                    } elseif ($row->status === 'verified') {
                        return '<span class="badge bg-success">Profil Disahkan</span>';
                    } elseif ($row->status === 'unverified') {
                        return '<span class="badge bg-danger">Profil Tidak Disahkan</span>';
                    } else {
                        return '<span class="badge bg-secondary">Status Tidak Diketahui</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="'.route('profile_verification.inheritance.admin.edit', $row->id).'" class="btn btn-light btn-sm">
                            <i class="fas fa-edit text-success"></i>
                        </a>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('app.inheritance.admin.verification.index');
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
        $profile = ProfilePentadbirHarta::find($id);

        abort_unless($profile, 404);

        return view('app.inheritance.admin.verification.verify', [
            'profile' => $profile,
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

        $profile = ProfilePentadbirHarta::find($id);

        DB::beginTransaction();

        try {
            $profile->status = $request->approval_status;
            $profile->updated_by = auth()->id();
            $profile->save();

            $approval = new Approval;
            $approval->object_type = 'profile_pentadbir_harta';
            $approval->object_id = $profile->id;
            $approval->action_by_type = 'user';
            $approval->action_by_id = auth()->id();
            $approval->action = $request->approval_status;
            $approval->remarks = $request->approval_remarks;
            $approval->save();

            DB::commit();

            if (strcasecmp($request->approval_status, ProfilePentadbirHarta::STATUS_VERIFIED) === 0) {
                Mail::to($profile->email)->send(new NewInheritanceAdmin([
                    'name' => $profile->pemilik_vesel,
                    'vessel_no' => $profile->no_vesel,
                ]));
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('sa_error', 'Ralat berlaku. Sila cuba semula.');
        }

        return redirect()->route('profile_verification.inheritance.admin.index')
            ->with('sa_success', 'Pengesahan maklumat pentadbir harta / pewaris ['.$profile->icno.'] telah disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
