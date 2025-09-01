<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Mail\ProfileVerifiedMail;
use App\Mail\ProfileRejectedMail;

use App\Models\User;
use App\Models\ProfileCompany;
use App\Models\ProfileCompanyAlp;
use App\Models\ProfileCompanyAsset;
use App\Models\ProfileCompanyAccount;
use App\Models\ProfileUsers;
use App\Models\MaklumatSyarikat;
use App\Models\Authorization\Role;

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

class VerificationProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = Auth::user();

            // Allow access if:
            // 1. User's name is "Super Admin"
            // 2. User has the role 'PEM. PERIKANAN (PELESENAN)'
            //if (!$user || ($user->name !== 'Super Admin' && !$user->hasRole('PEM PERIKANAN HQ PELESENAN'))) {
               // abort(403, 'Unauthorized action.');
           // }

            return $next($request);
        });
    }



    public function verifyProfiles()
    {
        $pemohonRoles = Role::whereIn('name', [
            'PEMOHON LESEN VESEL (NELAYAN DARAT)',
            'PEMOHON LESEN VESEL (NELAYAN LAUT)',
            'PENGUSAHA SKL',
            'PENTADBIR HARTA'
        ])->pluck('id');

        $profiles = ProfileUsers::whereHas('user.roles', function ($query) use ($pemohonRoles) {
                $query->whereIn('role_id', $pemohonRoles);
            })
            ->get(); // remove ->whereNull('verify_status')

        return view('app.profile.verifyProfiles', compact('profiles'));
    }

    
    
    public function showVerification(ProfileUsers $profile)
    {
        // Get parliaments and selected DUN (Parliament Seat)
        $parliaments = \App\Models\Parliament::with('seats')->get();

        $selectedDun = $profile->parliament_seat 
            ? \App\Models\ParliamentSeat::find($profile->parliament_seat)
            : null;

        // Get selected district
        $selectedDistrict = $profile->district 
            ? \App\Models\CodeMaster::where('type', 'district')->find($profile->district)
            : null;

        $selectedSecondaryDistrict = $profile->secondary_district 
        ? \App\Models\CodeMaster::where('type', 'district')
            ->where('id', $profile->secondary_district)
            ->first()
        : null;

        return view('app.profile.verification', [
            'profile' => $profile,
            'userTypes' => Helper::getCodeMastersByType('user_type'),
            'race' => Helper::getCodeMastersByTypeOrder('race'),
            'states' => Helper::getCodeMastersByType('state'), // this is your $states
            'gender' => Helper::getCodeMastersByType('gender'),
            'religion' => Helper::getCodeMastersByTypeOrder('religion'),
            'marital_status' => Helper::getCodeMastersByTypeOrder('marital_status'),
            'parliaments' => $parliaments,
            'selectedDun' => $selectedDun,
            'selectedDistrict' => $selectedDistrict,
            'selectedSecondaryDistrict' => $selectedSecondaryDistrict,
        ]);
    }



   public function submitVerification(Request $request, ProfileUsers $profile)
{
    $request->validate([
        'verify_status' => 'required|boolean',
        'ulasan' => 'required|string|max:255',
    ]);

    $verifiedAt = $request->input('verify_status') == 1 ? now() : null;

    $profile->update([
        'verified_at' => $verifiedAt,
        'verify_status' => $request->input('verify_status'),
        'ulasan' => $request->input('ulasan'),
        'verification_modal_shown' => false,  // Reset modal flag here!
    ]);

    $user = $profile->user;

    if ($request->input('verify_status') == 1) {
        Mail::to($user->email)->send(new ProfileVerifiedMail($user));
    } else {
        Mail::to($user->email)->send(new ProfileRejectedMail($user));
    }

    return redirect()->route('profile.verifyProfiles')
        ->with('status', 'Pengesahan Profil Berjaya Dihantar!');
}
    
}
