<?php

namespace App\Http\Controllers\Inheritance;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use App\Models\ProfilePentadbirHarta;
use App\Models\User;
use App\Models\ProfileUsers;
use App\Models\Vessel;
use Exception;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $user = auth()->user();

        if ($user->user_type == 6) { // pewaris
        $pewaris = $user->profilePentadbirHartas()->first();
        if ($pewaris) {
            return redirect()->route('profile.inheritance.admin.edit', $pewaris->id);
        }
        return redirect()->route('profile.inheritance.admin.create');
    }

        if ($user->user_type == 4) { // pentadbir harta
        $pentadbir = $user->profilePentadbirHartas()->first();
        if ($pentadbir) {
            return redirect()->route('profile.inheritance.admin.edit', $pentadbir->id);
        }
        return redirect()->route('profile.inheritance.admin.create');
        } 
        
        // Optional: fallback if user_type is neither 4 nor 6
        //abort(403, 'User type not allowed.');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get users who have at least one active vessel
        $vessel_owners = User::whereHas('vessels', function ($q) {
            $q->where('is_active', true);
        })
        ->where('is_active', true)
        ->select('id', 'name', 'username')
        ->orderBy('name')
        ->get();

        // Get all active vessels (to be filtered on frontend)
        $vessels = Vessel::where('is_active', true)
            ->whereNotNull('vessel_no')
            ->orderBy('vessel_no')
            ->get();

        return view('app.inheritance.admin.create', [
            'vessel_owners' => $vessel_owners,
            'vessels' => $vessels,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'icno' => 'required|string|max:12',
            'address' => 'nullable|string',
            'phone' => 'required|string',
            'email' => 'required|email|max:255',
            'vessel_owner' => 'nullable',
            'user_status' => 'required',
            'vessel' => 'required',
            'relationship' => 'nullable|string',
        ], [], [
            'name' => 'Nama Individu',
            'icno' => 'No. Kad Pengenalan',
            'address' => 'Alamat Semasa',
            'phone' => 'No. Telefon Bimbit',
            'email' => 'Alamat Emel',
            'vessel_owner' => 'Pemilik Vesel',
            'user_status' => 'Status Pengguna',
            'vessel' => 'Vesel Yang Terlibat',
            'relationship' => 'Hubungan Bersama Pemilik Vesel',
        ]);

        DB::beginTransaction();

        try {
            $profile_id = $this->generateIdProfilePentadbirHarta();

            $vesselIds = $request->vessel; // this is assumed to be an array of UUIDs

            // Step 1: Retrieve no_pendaftaran values from vessels table
            $noVeselList = \App\Models\Vessel::whereIn('id', $vesselIds)->pluck('no_pendaftaran')->toArray();

            // Step 2: Convert to comma-separated string
            $noVeselString = implode(',', $noVeselList);

            $profile = new ProfilePentadbirHarta;
            $profile->id = $profile_id;
            $profile->user_id = auth()->id();
            $profile->name = $request->name;
            $profile->icno = $request->icno;
            $profile->address = $request->address;
            $profile->phone = '60'.(int) $request->phone;
            $profile->email = $request->email;
            $profile->vessel_owner_id = $request->vessel_owner;
            $profile->pemilik_vesel = \App\Models\User::find($request->vessel_owner)?->name;
            $profile->status_pengguna = $request->user_status;
            $profile->hubungan = $request->relationship;
            $profile->vessel_id = implode(',', $vesselIds); // Store IDs as comma-separated
            $profile->no_vesel = $noVeselString; // Store corresponding no_pendaftaran
            $profile->status = ProfilePentadbirHarta::STATUS_SUBMITTED;

            if ($request->hasFile('doc1')) {
                $file = $request->file('doc1');
                $file_name = $file->getClientOriginalName();
                $path = $file->storeAs('user/inheritance/'.$profile_id.'/doc1', $file_name, 'public');
                // $profile->surat_pelantikan_pentadbir = $path;
                $profile->dokumen_sokongan_1 = $path;
            }

            if ($request->hasFile('doc2')) {
                $file = $request->file('doc2');
                $file_name = $file->getClientOriginalName();
                $path = $file->storeAs('user/inheritance/'.$profile_id.'/doc2', $file_name, 'public');
                $profile->dokumen_sokongan_2 = $path;
            }

            if ($request->hasFile('doc3')) {
                $file = $request->file('doc3');
                $file_name = $file->getClientOriginalName();
                $path = $file->storeAs('user/inheritance/'.$profile_id.'/doc3', $file_name, 'public');
                $profile->dokumen_sokongan_3 = $path;
            }

            if ($request->hasFile('doc4')) {
                $file = $request->file('doc4');
                $file_name = $file->getClientOriginalName();
                $path = $file->storeAs('user/inheritance/'.$profile_id.'/doc4', $file_name, 'public');
                $profile->dokumen_sokongan_4 = $path;
            }

            $profile->created_by = auth()->id();
            $profile->updated_by = auth()->id();
            $profile->save();
            $profile->vessels()->attach($request->vessel);

            $approval = new Approval;
            $approval->object_type = 'profile_pentadbir_harta';
            $approval->object_id = $profile->id;
            $approval->action_by_type = 'user';
            $approval->action_by_id = auth()->id();
            $approval->action = 'submitted';
            $approval->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('sa_error', 'Ralat berlaku. Sila cuba semula.');
        }

        return redirect()->route('profile.inheritance.admin.edit', auth()->user()->profilePentadbirHartas()->first()?->id)
            ->with('sa_success', 'Maklumat dihantar untuk pengesahan.');
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

        if ($profile->isVerified()) {
            session()->flash('warning', 'Anda hanya boleh mengemaskini Alamat Semasa, No. Telefon Bimbit, dan Emel sahaja.');
        } elseif ($profile->isUnverified()) {
            session()->flash('danger', $profile->approvals()->latest()->first()->remarks);
        }

        // Get owners and vessels (same as create)
        $vessel_owners = User::whereHas('vessels', function ($q) {
                $q->where('is_active', true);
            })
            ->where('is_active', true)
            ->select('id', 'name', 'username')
            ->orderBy('name')
            ->get();

        $vessels = Vessel::where('is_active', true)
            ->whereNotNull('vessel_no')
            ->orderBy('vessel_no')
            ->get();

        return view('app.inheritance.admin.edit', [
            'profile' => $profile,
            'vessel_owners' => $vessel_owners,
            'vessels' => $vessels,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'icno' => 'required|string|max:12',
            'address' => 'nullable|string',
            'phone' => 'required|string',
            'email' => 'required|email|max:255',
            'vessel_owner' => 'nullable',
            'user_status' => 'required',
            'vessel' => 'required',
            'relationship' => 'required',
        ], [], [
            'name' => 'Nama Individu',
            'icno' => 'No. Kad Pengenalan',
            'address' => 'Alamat Semasa',
            'phone' => 'No. Telefon Bimbit',
            'email' => 'Alamat Emel',
            'vessel_owner' => 'Pemilik Vesel',
            'user_status' => 'Status Pengguna',
            'vessel' => 'Vesel Yang Terlibat',
            'relationship' => 'Hubungan Bersama Pemilik Vesel',
        ]);

        DB::beginTransaction();

        try {
            $profile = ProfilePentadbirHarta::find($id);

             $vesselIds = $request->vessel; // this is assumed to be an array of UUIDs

            // Step 1: Retrieve no_pendaftaran values from vessels table
            $noVeselList = \App\Models\Vessel::whereIn('id', $vesselIds)->pluck('no_pendaftaran')->toArray();

            // Step 2: Convert to comma-separated string
            $noVeselString = implode(',', $noVeselList);

            if (!empty($request->action) && strcasecmp($request->action, 'submit') === 0) {
                $profile->user_id = auth()->id();
                $profile->name = $request->name;
                $profile->icno = $request->icno;
                $profile->address = $request->address;
                $profile->phone = '60'.(int) $request->phone;
                $profile->email = $request->email;
                $profile->vessel_owner_id = $request->vessel_owner;
                $profile->status_pengguna = $request->user_status;
                $profile->hubungan = $request->relationship;
                $profile->vessel_id = implode(',', $vesselIds); // Store IDs as comma-separated
                $profile->no_vesel = $noVeselString; // Store corresponding no_pendaftaran
                $profile->status = ProfilePentadbirHarta::STATUS_SUBMITTED;

                if ($request->hasFile('doc1')) {
                    $file = $request->file('doc1');
                    $file_name = $file->getClientOriginalName();
                    $path = $file->storeAs('user/inheritance/'.$profile->id.'/doc1', $file_name, 'public');
                    $profile->surat_pelantikan_pentadbir = $path;
                    $profile->dokumen_sokongan_1 = $path;
                }

                if ($request->hasFile('doc2')) {
                    $file = $request->file('doc2');
                    $file_name = $file->getClientOriginalName();
                    $path = $file->storeAs('user/inheritance/'.$profile->id.'/doc2', $file_name, 'public');
                    $profile->dokumen_sokongan_2 = $path;
                }

                if ($request->hasFile('doc3')) {
                    $file = $request->file('doc3');
                    $file_name = $file->getClientOriginalName();
                    $path = $file->storeAs('user/inheritance/'.$profile->id.'/doc3', $file_name, 'public');
                    $profile->dokumen_sokongan_3 = $path;
                }

                if ($request->hasFile('doc4')) {
                    $file = $request->file('doc4');
                    $file_name = $file->getClientOriginalName();
                    $path = $file->storeAs('user/inheritance/'.$profile->id.'/doc4', $file_name, 'public');
                    $profile->dokumen_sokongan_4 = $path;
                }
            } else if (!empty($request->action) && strcasecmp($request->action, 'update') === 0) {
                $profile->address = $request->address;
                $profile->phone = '60'.(int) $request->phone;
                $profile->email = $request->email;
            }

            $profile->updated_by = auth()->id();
            $profile->save();
            $profile->vessels()->attach($request->vessel);

            if (!empty($request->action) && strcasecmp($request->action, 'submit') === 0) {
                $approval = new Approval;
                $approval->object_type = 'profile_pentadbir_harta';
                $approval->object_id = $profile->id;
                $approval->action_by_type = 'user';
                $approval->action_by_id = auth()->id();
                $approval->action = 'submitted';
                $approval->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('sa_error', 'Ralat berlaku. Sila cuba semula.');
        }

        if (!empty($request->action) && strcasecmp($request->action, 'submit') === 0) {
            session()->flash('sa_success', 'Maklumat dihantar semula untuk pengesahan.');
        } else if (!empty($request->action) && strcasecmp($request->action, 'update') === 0) {
            session()->flash('sa_success', 'Maklumat dikemaskini.');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function generateIdProfilePentadbirHarta()
    {
        do {
            $id = (string) Str::uuid();
        } while (ProfilePentadbirHarta::where('id', $id)->exists());

        return $id;
    }


}
