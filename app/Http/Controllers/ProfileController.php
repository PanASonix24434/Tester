<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\ProfileCompany;
use App\Models\ProfileCompanyAlp;
use App\Models\ProfileCompanyAsset;
use App\Models\ProfileCompanyAccount;
use App\Models\ProfileUsers;
use App\Models\MaklumatSyarikat;
use App\Models\PendaftaranPerniagaan;
use App\Models\PenglibatanSyarikat;
use App\Models\Parliament;
use App\Models\ParliamentSeat;
use App\Models\CodeMaster;
use Illuminate\Validation\Rule;




// ...existing code...
use Audit;
use Hash;
use DB;
use Exception;
use Carbon\Carbon;
use PDF;
use Storage;
use Image;
use Helper;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{

    public function getDuns(Request $request)
    {
        $duns = ParliamentSeat::where('parliament_id', $request->parliament_id)->get();

        return response()->json($duns);
    }
  
    public function user(Request $request)
    {
        $user = Auth::user();
        $user_roles_skl = Auth::user()->hasRole('PENGUSAHA SKL');
        $user_roles_pentadbir_harta = Auth::user()->hasRole('PENTADBIR HARTA');
        $user_roles_darat = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)');
        $user_roles_laut = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)');

        // Get all parliaments
        $parliaments = \App\Models\Parliament::with('seats')->get();

        // Initialize duns as an empty array
        $duns = [];

        // If a parliament is selected in the request, get the corresponding seats (duns)
        if ($request->has('parliament') && $request->parliament) {
            $duns = \App\Models\ParliamentSeat::where('parliament_id', $request->parliament)->get();
        }

        // Get states with related districts (using the new relationship)
        $states = \App\Models\CodeMaster::where('type', 'state')->with('districts')->get();

        // Initialize districts based on selected state
        $districts = [];
        $selectedState = null;

        if ($request->has('negeri') && $request->negeri) {
            $selectedState = \App\Models\CodeMaster::where('type', 'state')
                            ->where('code', $request->negeri)
                            ->first();

            if ($selectedState) {
                $districts = \App\Models\CodeMaster::where('type', 'district')
                            ->where('parent_id', $selectedState->id)
                            ->get();
            }
        }

        return view('app.profile.user', [
            'userTypes' => Helper::getCodeMastersByType('user_type'),
            'race' => Helper::getCodeMastersByTypeOrder('race'),
            'state' => $states,  // Send states with districts
            'gender' => Helper::getCodeMastersByType('gender'),
            'religion' => Helper::getCodeMastersByTypeOrder('religion'),
            'marital_status' => Helper::getCodeMastersByTypeOrder('marital_status'),
            'user_roles_skl' => $user_roles_skl,
            'user_roles_darat' => $user_roles_darat,
            'user_roles_laut' => $user_roles_laut,
            'parliaments' => $parliaments,
            'duns' => $duns,
            'districts' => $districts,  // Send districts related to selected state
            'selectedState' => $request->negeri ?? null,
        ]);
    }

    public function getDaerah(Request $request)
    {
        $state = \App\Models\CodeMaster::where('type', 'state')->where('code', $request->negeri)->first();
        if (!$state) return response()->json([]);

        // Fetch the related districts using the relationship
        $districts = $state->districts;
        
        return response()->json($districts);
    }

    public function handleProfile(Request $request)
    {
        $user = Auth::user();
        $profile = $user ? $user->profile : null;

        if (!$profile) {
            // Handle the case where there is no profile
            return redirect()->route('profile.user'); // Redirect to profile creation or show a message
        }
        $user_roles_skl = Auth::user()->hasRole('PENGUSAHA SKL');
        $user_roles_pentadbir_harta = Auth::user()->hasRole('PENTADBIR HARTA');
        $user_roles_darat = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)');
        $user_roles_laut = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)');
        $districts = [];

        // If the request contains 'negeri', fetch the list of districts under that negeri
        if ($request->has('negeri') && $request->negeri) {
            $selectedState = \App\Models\CodeMaster::where('type', 'state')
                            ->where('code', $request->negeri)
                            ->first();

            if ($selectedState) {
                $districts = \App\Models\CodeMaster::where('type', 'district')
                            ->where('parent_id', $selectedState->id)
                            ->get();
            }
        }

         // ? Get selected district from profile directly
         $selectedDistrict = $profile->district 
        ? \App\Models\CodeMaster::where('type', 'district')
            ->where('id', $profile->district)
            ->first()
        : null;

        $selectedSecondaryDistrict = $profile->secondary_district 
        ? \App\Models\CodeMaster::where('type', 'district')
            ->where('id', $profile->secondary_district)
            ->first()
        : null;

        // Parliament and DUN setup
        $parliaments = Parliament::all();
        $duns = [];

        $selectedDun = $profile->parliament_seat 
            ? ParliamentSeat::find($profile->parliament_seat)
            : null;


        if ($profile && $profile->race) {
            return view('app.profile.userview', [
                'profile' => $profile,
                'userTypes' => Helper::getCodeMastersByType('user_type'),
                'race' => Helper::getCodeMastersByTypeOrder('race'),
                'states' => Helper::getCodeMastersByType('state'),
                'gender' => Helper::getCodeMastersByType('gender'),
                'religion' => Helper::getCodeMastersByTypeOrder('religion'),
                'marital_status' => Helper::getCodeMastersByTypeOrder('marital_status'),
                'user_roles_skl' => $user_roles_skl,
                'user_roles_darat' => $user_roles_darat,
                'user_roles_laut' => $user_roles_laut,
                'parliaments' => $parliaments,
                'duns' => $duns, // Pass the duns to the view
                'selectedDun' => $selectedDun,
                'districts' => $districts,
                'selectedDistrict' => $selectedDistrict, // ? Pass to view
                'selectedSecondaryDistrict' => $selectedSecondaryDistrict,
                'selectedState' => $request->negeri ?? null,
            ]);
            
        }

        return view('app.profile.user', [
            'userTypes' => Helper::getCodeMastersByType('user_type'),
            'race' => Helper::getCodeMastersByTypeOrder('race'),
            'state' => Helper::getCodeMastersByType('state'),
            'gender' => Helper::getCodeMastersByType('gender'),
            'religion' => Helper::getCodeMastersByTypeOrder('religion'),
            'marital_status' => Helper::getCodeMastersByTypeOrder('marital_status'),
            'user_roles_skl' => $user_roles_skl,
            'user_roles_darat' => $user_roles_darat,
            'user_roles_laut' => $user_roles_laut,
            'parliaments' => $parliaments,
            'duns' => $duns,
            'districts' => $districts,
            'selectedDistrict' => $selectedDistrict,
            'selectedSecondaryDistrict' => $selectedSecondaryDistrict,
            'selectedState' => $request->negeri ?? null,
        ]);
    }


    public function storeprofileuser(Request $request)
    {

       $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('profile_users', 'email')
                    ->ignore(auth()->user()->email, 'email') // Ignore the current user's email
                    ->whereNull('deleted_at'),
            ],
        ], [
            'email.unique' => 'Emel ini telah didaftarkan oleh pengguna lain.',
            'email.required' => 'Emel diperlukan.',
            'email.email' => 'Sila masukkan emel yang sah.',
        ]);

        DB::beginTransaction();

        try {

            // Create a new Profile
            $profile = new ProfileUsers;

            $table_id = Helper::uuid();

            $profile->id = $table_id;
            $profile->name = $request->name;
            $profile->icno = $request->icno;
            $profile->address1 = $request->no_lot;
            $profile->address2 = $request->nama_jalan;
            $profile->address3 = $request->nama_bandar;
            $profile->poskod = $request->poskod;

            $stateId = CodeMaster::where('type', 'state')
            ->where('code', $request->negeri)
            ->first()?->id; // use 'id', not 'code'
 
            $districtId = CodeMaster::where('type', 'district')
                        ->where('code', $request->daerah)
                        ->where('parent_id', $stateId)
                        ->first()?->id; // use 'id', not 'code'
            
            $profile->state = $stateId;
            $profile->district = $districtId;

             $profile->secondary_address_1 = $request->secondary_address_1;
            $profile->secondary_address_2 = $request->secondary_address_2;
            $profile->secondary_address_3 = $request->secondary_address_3;
            $profile->secondary_postcode = $request->secondary_postcode;

            $stateId = CodeMaster::where('type', 'state')
            ->where('code', $request->secondary_state)
            ->first()?->id; // use 'id', not 'code'
 
            $districtId = CodeMaster::where('type', 'district')
                        ->where('code', $request->secondary_district)
                        ->where('parent_id', $stateId)
                        ->first()?->id; // use 'id', not 'code'


            $profile->secondary_state = $stateId;
            $profile->secondary_district = $districtId;

            
            $profile->parliament = $request->parliament;
            $profile->parliament_seat = $request->parliament_seat;

            $profile->age = $request->age;

            $genderValue = $request->gender;
            $genderUuid = match ($genderValue) {
                'LELAKI' => 'c62838ff-b29e-401e-a007-f6abf5a5868c',
                'PEREMPUAN' => 'f624fbcf-7bda-4e95-9e54-b5c205d63172',
                default => null,
            };

            $profile->gender_id = $genderUuid;

            $profile->user_type = $request->user_type;
            $profile->no_phone = "60" . $request->txtPhoneNo;
            $profile->secondary_phone_number = $request->txtPhoneNoSecond ? "60" . $request->txtPhoneNoSecond : null; //CHECK BALIK
            $profile->no_phone_office = $request->txtOfficePhoneNo ? "60" . $request->txtOfficePhoneNo : null;
            $profile->religion = $request->religion;
            $profile->race = $request->race;
            $profile->wedding_status = $request->marital_status;

            if ($request->hasFile('salinan_ic')) {
                $file = $request->file('salinan_ic');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('pengguna/salinan_ic', $filename, 'public');
                $profile->salinan_ic = $path;
            }

            if ($request->status_oku == "bukan_oku") {
                $profile->oku_status = 0;
            } else {
                $profile->oku_status = 1;
            }

            $profile->email = $request->email;
            $profile->is_active = 1;
            $profile->verify_status = null;

            if ($request->status_bumiputera == "tidak_bumiputera") {
                $profile->bumiputera_status = 0;
            } else {
                $profile->bumiputera_status = 1;
            }

            $profile->user_id = Auth::id();
            $profile->created_by = Auth::id();
            $profile->updated_by = Auth::id();

            $profile->save();

            $user = Auth::user();
            $user->email = $request->email;
            $user->updated_by = Auth::id();

            // Handle profile picture upload (if any)
            if ($request->hasFile('profile-picture')) {
                $file = $request->file('profile-picture');
                $profilePictureExt = $file->getClientOriginalExtension();
                $profilePictureName = Auth::id().'.'.$profilePictureExt;

                // Store the original profile picture
                $file->storeAs('public/profile-picture/.original/', $profilePictureName);

                // Resize and save the image using GD
                $img = imagecreatefromjpeg(storage_path('app/public/profile-picture/.original/'.$profilePictureName)); // Assuming it's a JPEG
                list($width, $height) = getimagesize(storage_path('app/public/profile-picture/.original/'.$profilePictureName));

                // Resize to 800x800 (Example)
                $newWidth = 800;
                $newHeight = ($height / $width) * $newWidth;

                $newImage = imagescale($img, $newWidth, $newHeight);
                imagejpeg($newImage, storage_path('app/public/profile-picture/'.$profilePictureName)); // Save resized image

                // Free up memory
                imagedestroy($img);
                imagedestroy($newImage);

                // Update the profile picture in the 'users' table
                $user->profile_picture = $profilePictureName;
        
            }

            $user->save();

            $audit_details = json_encode([ 
                'Nama' => $request->name,
                'No Kad Pengenalan' => $request->icno,
                'Bangsa' => $request->race,
            ]);
            Audit::log('Profil', 'Kemaskini Butiran Am', $audit_details);

            DB::commit();

            // Redirect to the profile view page with a success message
            session()->flash('custom_alert', 'Profil berjaya dikemaskini. Pengesahan profil anda akan diproses oleh pihak Ibu Pejabat. Anda akan menerima emel makluman selepas proses pengesahan selesai. Hanya profil yang telah disahkan sahaja boleh menggunakan keseluruhan fungsi sistem.');
            return redirect()->route('dashboard');
        }
        catch (Exception $e) {
            // Rollback if there's an error
            DB::rollback();

            // Log audit details in case of error
            $audit_details = json_encode([ 
                'Nama' => $request->name,
                'No Kad Pengenalan' => $request->icno,
            ]);
            Audit::log('Profil', 'Kemaskini Butiran Am', $audit_details, $e->getMessage());

            // Return error message
            return redirect()->back()->with('alert', __('app.error_occured'));
        }
    }

    

    public function viewprofileuser(Request $request, string $id)
    {
        $profile = ProfileUsers::findOrFail($id); 

        $user_roles_skl = Auth::user()->hasRole('PENGUSAHA SKL');
        $user_roles_pentadbir_harta = Auth::user()->hasRole('PENTADBIR HARTA');
        $user_roles_darat = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)');
        $user_roles_laut = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)');

        $districts = [];

        // If the request contains 'negeri', fetch the list of districts under that negeri
        if ($request->has('negeri') && $request->negeri) {
            $selectedState = \App\Models\CodeMaster::where('type', 'state')
                            ->where('code', $request->negeri)
                            ->first();

            if ($selectedState) {
                $districts = \App\Models\CodeMaster::where('type', 'district')
                            ->where('parent_id', $selectedState->id)
                            ->get();
            }
        }

          // ? Get selected district from profile directly
          $selectedDistrict = $profile->district 
        ? \App\Models\CodeMaster::where('type', 'district')
            ->where('id', $profile->district)
            ->first()
        : null;

        $selectedSecondaryDistrict = $profile->secondary_district 
        ? \App\Models\CodeMaster::where('type', 'district')
            ->where('id', $profile->secondary_district)
            ->first()
        : null;


        // Parliament and DUN setup
        $parliaments = Parliament::all();
        $duns = [];

        $selectedDun = $profile->parliament_seat 
            ? ParliamentSeat::find($profile->parliament_seat)
            : null;

        return view('app.profile.userview', [
            'profile' => $profile,
            'userTypes' => Helper::getCodeMastersByType('user_type'),
            'race' => Helper::getCodeMastersByTypeOrder('race'),
            'states' => Helper::getCodeMastersByType('state'),
            'gender' => Helper::getCodeMastersByType('gender'),
            'religion' => Helper::getCodeMastersByTypeOrder('religion'),
            'marital_status' => Helper::getCodeMastersByTypeOrder('marital_status'),
            'user_roles_skl' => $user_roles_skl,
            'user_roles_darat' => $user_roles_darat,
            'user_roles_laut' => $user_roles_laut,
            'parliaments' => $parliaments,
            'duns' => $duns,
            'selectedDun' => $selectedDun,
            'districts' => $districts,
            'selectedDistrict' => $selectedDistrict, // ? Pass to view
            'selectedSecondaryDistrict' => $selectedSecondaryDistrict,
            'selectedState' => $request->negeri ?? null,
        ]);
    }



    public function editprofileuser(Request $request, string $id)
    {
        $profile = ProfileUsers::findOrFail($id);
        $user_roles_skl = Auth::user()->hasRole('PENGUSAHA SKL');
        $user_roles_pentadbir_harta = Auth::user()->hasRole('PENTADBIR HARTA');
        $user_roles_darat = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)');
        $user_roles_laut = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)');
        // Get all parliaments
        $parliaments = \App\Models\Parliament::with('seats')->get();

        // Initialize duns as an empty array
        $duns = [];

        // If a parliament is selected in the request, get the corresponding seats (duns)
        if ($request->has('parliament') && $request->parliament) {
            // Fetch duns based on selected parliament
            $duns = \App\Models\ParliamentSeat::where('parliament_id', $request->parliament)->get();
        }
        $selectedDun = $profile->parliament_seat 
            ? ParliamentSeat::find($profile->parliament_seat)
            : null;

       // Get states with related districts (using the new relationship)
        $states = \App\Models\CodeMaster::where('type', 'state')->with('districts')->get();

        // Initialize districts based on selected state
        $districts = [];
        $selectedState = null;

        if ($request->has('negeri') && $request->negeri) {
            $selectedState = \App\Models\CodeMaster::where('type', 'state')
                            ->where('code', $request->negeri)
                            ->first();

            if ($selectedState) {
                $districts = \App\Models\CodeMaster::where('type', 'district')
                            ->where('parent_id', $selectedState->id)
                            ->get();
            }
        }

         // ? Get selected district from profile directly
         $selectedDistrict = $profile->district 
        ? \App\Models\CodeMaster::where('type', 'district')
            ->where('id', $profile->district)
            ->first()
        : null;

        $selectedSecondaryState = $profile->secondary_state 
        ? CodeMaster::where('type', 'state')->where('id', $profile->secondary_state)->first()
        : null;


        $selectedSecondaryDistrict = $profile->secondary_district 
        ? \App\Models\CodeMaster::where('type', 'district')
            ->where('id', $profile->secondary_district)
            ->first()
        : null;

        return view('app.profile.useredit', [
            'profile' => $profile,
            'userTypes' => Helper::getCodeMastersByType('user_type'),
            'race' => Helper::getCodeMastersByTypeOrder('race'),
            'state' => $states,  // Send states with districts
            'gender' => Helper::getCodeMastersByType('gender'),
            'religion' => Helper::getCodeMastersByTypeOrder('religion'),
            'marital_status' => Helper::getCodeMastersByTypeOrder('marital_status'),
            'user_roles_skl' => $user_roles_skl,
            'user_roles_darat' => $user_roles_darat,
            'user_roles_laut' => $user_roles_laut,
            'parliaments' => $parliaments,
            'duns' => $duns,
            'selectedDun' => $selectedDun,
            'districts' => $districts,  // Send districts related to selected state
            'selectedState' => $profile->state ?? null,
            'selectedDistrict' => $selectedDistrict, // ? Pass to view
            'selectedSecondaryState' => $selectedSecondaryState,
            'selectedSecondaryDistrict' => $selectedSecondaryDistrict,
 
            
        ]);
    }
    public function updateprofileuser(Request $request, string $id)
    {

        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('profile_users', 'email')
                    ->ignore(auth()->user()->email, 'email') // Ignore the current user's email
                    ->whereNull('deleted_at'),
            ],
        ], [
            'email.unique' => 'Emel ini telah didaftarkan oleh pengguna lain.',
            'email.required' => 'Emel diperlukan.',
            'email.email' => 'Sila masukkan emel yang sah.',
        ]);
        DB::beginTransaction();

        try {

            $profile = ProfileUsers::findOrFail($id);

            $table_id = Helper::uuid();

            $profile->name = $request->name;
            $profile->icno = $request->icno;
            $profile->address1 = $request->no_lot;
            $profile->address2 = $request->nama_jalan;
            $profile->address3 = $request->nama_bandar;
            $profile->poskod = $request->poskod;

            $stateId = CodeMaster::where('type', 'state')
            ->where('code', $request->negeri)
            ->first()?->id; // use 'id', not 'code'
 
            $districtId = CodeMaster::where('type', 'district')
                        ->where('code', $request->daerah)
                        ->where('parent_id', $stateId)
                        ->first()?->id; // use 'id', not 'code'
            
            $profile->state = $stateId;
            $profile->district = $districtId;

             $profile->secondary_address_1 = $request->secondary_address_1;
            $profile->secondary_address_2 = $request->secondary_address_2;
            $profile->secondary_address_3 = $request->secondary_address_3;
            $profile->secondary_postcode = $request->secondary_postcode;

            $stateId = CodeMaster::where('type', 'state')
            ->where('code', $request->secondary_state)
            ->first()?->id; // use 'id', not 'code'
 
            $districtId = CodeMaster::where('type', 'district')
                        ->where('code', $request->secondary_district)
                        ->where('parent_id', $stateId)
                        ->first()?->id; // use 'id', not 'code'


            $profile->secondary_state = $stateId;
            $profile->secondary_district = $districtId;
            
            $profile->parliament = $request->parliament;
            $profile->parliament_seat = $request->parliament_seat;
            $profile->age = $request->age;

            $genderValue = $request->gender;

            $genderUuid = match ($genderValue) {
                'LELAKI' => 'c62838ff-b29e-401e-a007-f6abf5a5868c',
                'PEREMPUAN' => 'f624fbcf-7bda-4e95-9e54-b5c205d63172',
                default => null,
            };

            $profile->gender_id = $genderUuid;


            $profile->user_type = $request->user_type;
            $profile->no_phone = "60".$request->txtPhoneNo;
            $profile->secondary_phone_number = $request->txtPhoneNoSecond ? "60" . $request->txtPhoneNoSecond : null; //CHECK BALIK
            $profile->no_phone_office = $request->txtOfficePhoneNo 
            ? "60" . $request->txtOfficePhoneNo 
            : null;
            $profile->religion = $request->religion;
            $profile->race = $request->race;
            $profile->wedding_status = $request->marital_status;

            if($request->status_oku == "bukan_oku"){
                $profile->oku_status = 0;
            }else{
                $profile->oku_status = 1;
            }

            $profile->email = $request->email;
            if ($request->hasFile('salinan_ic')) {

                if ($profile->salinan_ic && Storage::disk('public')->exists($profile->salinan_ic)) {
                    Storage::disk('public')->delete($profile->salinan_ic);
                }

                $file = $request->file('salinan_ic');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('pengguna/salinan_ic', $filename, 'public');
                $profile->salinan_ic = $path; 
            }

            $profile->is_active = 1;
            if ($profile->verify_status !== 1) {
                $profile->verify_status = null;
            }
            if($request->status_bumiputera == "tidak_bumiputera"){
                $profile->bumiputera_status = 0;
            }else{
                $profile->bumiputera_status = 1;
            }

            $profile->updated_by = Auth::id();
            $profile->save();


            $user = Auth::user();
            $user->email = $request->email;
            $user->updated_by = Auth::id();

            // Handle profile picture upload (if any)
            if ($request->hasFile('profile-picture')) {
                $file = $request->file('profile-picture');
                $profilePictureExt = $file->getClientOriginalExtension();
                $profilePictureName = Auth::id().'.'.$profilePictureExt;
    
                // Store the original profile picture
                $file->storeAs('public/profile-picture/.original/', $profilePictureName);
    
                // Resize and save the image using GD
                $img = imagecreatefromjpeg(storage_path('app/public/profile-picture/.original/'.$profilePictureName)); // Assuming it's a JPEG
                list($width, $height) = getimagesize(storage_path('app/public/profile-picture/.original/'.$profilePictureName));
    
                // Resize to 800x800 (Example)
                $newWidth = 800;
                $newHeight = ($height / $width) * $newWidth;
    
                $newImage = imagescale($img, $newWidth, $newHeight);
                imagejpeg($newImage, storage_path('app/public/profile-picture/'.$profilePictureName)); // Save resized image
    
                // Free up memory
                imagedestroy($img);
                imagedestroy($newImage);
    
                // Update the profile picture in the 'users' table
                $user->profile_picture = $profilePictureName;
  
            }

            $user->save();

            $audit_details = json_encode([ 
                'Nama' => $request->name,
                'No Kad Pengenalan' => $request->icno,
            ]);

            Audit::log('Profil', 'Kemaskini Butiran Am', $audit_details);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'Nama' => $request->name,
                'No Kad Pengenalan' => $request->icno,
                
            ]);

            Audit::log('Profil', 'Kemaskini Butiran Am', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', __('app.error_occured'));
        }

        //Success
        session()->flash('custom_alert', 'Profil berjaya dikemaskini. Pengesahan profil anda akan diproses oleh pihak Ibu Pejabat. Anda akan menerima emel makluman selepas proses pengesahan selesai. Hanya profil yang telah disahkan sahaja boleh menggunakan keseluruhan fungsi sistem.');
        return redirect()->route('dashboard');
    
    }

    //---------------------------- PROFILE NELAYAN DARAT -------------------------------------

    public function kewanganDarat(Request $request)
    {
        $profile = ProfileUsers::where('user_id', Auth::id())->first();
        $user_roles_skl = Auth::user()->hasRole('PENGUSAHA SKL');
        $user_roles_pentadbir_harta = Auth::user()->hasRole('PENTADBIR HARTA');
        $user_roles_darat = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)');
        $user_roles_laut = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)');
    

        return view('app.profile.kewanganDarat', [
            'profile' => $profile,
            'userTypes' => Helper::getCodeMastersByType('user_type'),
            'race' => Helper::getCodeMastersByTypeOrder('race'),
            'state' => Helper::getCodeMastersByType('state'),
            'gender' => Helper::getCodeMastersByType('gender'),
            'religion' => Helper::getCodeMastersByTypeOrder('religion'),
            'marital_status' => Helper::getCodeMastersByTypeOrder('marital_status'),
            'user_roles_skl' => $user_roles_skl,
            'user_roles_darat' => $user_roles_darat,
            'user_roles_laut' => $user_roles_laut,
        ]);
    }
    

    public function pangkalanDarat(Request $request)
    {

        $profile = ProfileUsers::where('user_id', Auth::id())->first(); 
        $user_roles_skl = Auth::user()->hasRole('PENGUSAHA SKL');
        $user_roles_pentadbir_harta = Auth::user()->hasRole('PENTADBIR HARTA');
        $user_roles_darat = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)');
        $user_roles_laut = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)');

        return view('app.profile.pangkalanDarat', [		

            'profile' => $profile, 
            'userTypes' => Helper::getCodeMastersByType('user_type'),
            'race' => Helper::getCodeMastersByTypeOrder('race'),
            'state' => Helper::getCodeMastersByType('state'),
            'gender' => Helper::getCodeMastersByType('gender'),
            'religion' => Helper::getCodeMastersByTypeOrder('religion'),
            'marital_status' => Helper::getCodeMastersByTypeOrder('marital_status'),
            'user_roles_skl' => $user_roles_skl,
            'user_roles_darat' => $user_roles_darat,
            'user_roles_laut' => $user_roles_laut,
    
        ]);
    }

    public function veselDarat(Request $request)
    {

        $profile = ProfileUsers::where('user_id', Auth::id())->first();
        $user_roles_skl = Auth::user()->hasRole('PENGUSAHA SKL');
        $user_roles_pentadbir_harta = Auth::user()->hasRole('PENTADBIR HARTA');
        $user_roles_darat = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)');
        $user_roles_laut = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)');

        return view('app.profile.veselDarat', [		

            'profile' => $profile, 
            'userTypes' => Helper::getCodeMastersByType('user_type'),
            'race' => Helper::getCodeMastersByTypeOrder('race'),
            'state' => Helper::getCodeMastersByType('state'),
            'gender' => Helper::getCodeMastersByType('gender'),
            'religion' => Helper::getCodeMastersByTypeOrder('religion'),
            'marital_status' => Helper::getCodeMastersByTypeOrder('marital_status'),
            'user_roles_skl' => $user_roles_skl,
            'user_roles_darat' => $user_roles_darat,
            'user_roles_laut' => $user_roles_laut,
    
        ]);
    }

    public function aktivitiDarat(Request $request)
    {

        $profile = ProfileUsers::where('user_id', Auth::id())->first(); 
        $user_roles_skl = Auth::user()->hasRole('PENGUSAHA SKL');
        $user_roles_pentadbir_harta = Auth::user()->hasRole('PENTADBIR HARTA');
        $user_roles_darat = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)');
        $user_roles_laut = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)');

        return view('app.profile.aktivitiDarat', [		

            'profile' => $profile,
            'userTypes' => Helper::getCodeMastersByType('user_type'),
            'race' => Helper::getCodeMastersByTypeOrder('race'),
            'state' => Helper::getCodeMastersByType('state'),
            'gender' => Helper::getCodeMastersByType('gender'),
            'religion' => Helper::getCodeMastersByTypeOrder('religion'),
            'marital_status' => Helper::getCodeMastersByTypeOrder('marital_status'),
            'user_roles_skl' => $user_roles_skl,
            'user_roles_darat' => $user_roles_darat,
            'user_roles_laut' => $user_roles_laut,
    
        ]);
    }

    public function kesalahanDarat(Request $request)
    {

        $profile = ProfileUsers::where('user_id', Auth::id())->first();
        $user_roles_skl = Auth::user()->hasRole('PENGUSAHA SKL');
        $user_roles_pentadbir_harta = Auth::user()->hasRole('PENTADBIR HARTA');
        $user_roles_darat = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)');
        $user_roles_laut = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)');

        return view('app.profile.kesalahanDarat', [		

            'profile' => $profile,
            'userTypes' => Helper::getCodeMastersByType('user_type'),
            'race' => Helper::getCodeMastersByTypeOrder('race'),
            'state' => Helper::getCodeMastersByType('state'),
            'gender' => Helper::getCodeMastersByType('gender'),
            'religion' => Helper::getCodeMastersByTypeOrder('religion'),
            'marital_status' => Helper::getCodeMastersByTypeOrder('marital_status'),
            'user_roles_skl' => $user_roles_skl,
            'user_roles_darat' => $user_roles_darat,
            'user_roles_laut' => $user_roles_laut,
    
        ]);
    }

    //--------------------------- PROFILE SYARIKAT ---------------------------------

    public function maklumatSyarikat(Request $request)
    {
        $user = Auth::user();

        $company = MaklumatSyarikat::where('id', $request->company_id)
                    ->where('user_id', $user->id) 
                    ->first();

        if (!$company) {
            return redirect()->route('profile.indexSyarikat')->with('error', 'Syarikat tidak dijumpai.');
        }

        $states = Helper::getCodeMastersByType('state');
        $ownerships = Helper::getCodeMastersByType('pemilikan_syarikat');

        return view('app.profile.maklumatSyarikat', [
            'company' => $company,
            'company_name' => $company->company_name,
            'company_address1' => $company->address1,
            'company_address2' => $company->address2,
            'company_address3' => $company->address3,
            'poskod' => $company->poskod,
            'district' => $company->district,
            'state_code' => $company->state,
            'states' => $states,
            'ownership_code' => $company->ownership,
            'ownerships' => $ownerships,
            'bumiputera_status' => $company->bumiputera_status,
            'no_phone' => $company->no_phone,
            'no_phone_office' => $company->no_phone_office,
            'fax' => $company->no_fax,
            'email' => $company->email,
            'user_roles_skl' => $user->hasRole('PENGUSAHA SKL'),
            'user_roles_darat' => $user->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)'),
            'user_roles_laut' => $user->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)'),
        ]);
    }

        public function editMaklumatSyarikat(Request $request, string $id)
    {
        $user = Auth::user();

        $company = MaklumatSyarikat::where('id', $id)
                    ->where('user_id', $user->id)
                    ->first();

        if (!$company) {
            return redirect()->route('indexSyarikat')->with('error', 'Syarikat tidak dijumpai.');
        }

        $states = Helper::getCodeMastersByType('state');
        $ownerships = Helper::getCodeMastersByType('pemilikan_syarikat');
        
        return view('app.profile.editMaklumatSyarikat', [
            'company' => $company,
            'company_name' => $company->company_name,
            'company_address1' => $company->address1,
            'company_address2' => $company->address2,
            'company_address3' => $company->address3,
            'poskod' => $company->poskod,
            'district' => $company->district,
            'state_code' => $company->state,
            'states' => $states,
            'ownership_code' => $company->ownership,
            'ownerships' => $ownerships,
            'bumiputera_status' => $company->bumiputera_status,
            'no_phone' => $company->no_phone,
            'no_phone_office' => $company->no_phone_office,
            'fax' => $company->no_fax,
            'email' => $company->email,
            'user_roles_skl' => $user->hasRole('PENGUSAHA SKL'),
            'user_roles_darat' => $user->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)'),
            'user_roles_laut' => $user->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)'),
        ]);
    }

    public function updateMaklumatSyarikat(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
        
            $company = MaklumatSyarikat::findOrFail($id);

            $company->company_name = $request->company_name;
            $company->address1 = $request->company_address1;
            $company->address2 = $request->company_address2;
            $company->address3 = $request->company_address3;
            $company->poskod = $request->poskod;
            $company->district = $request->district;
            $company->state = $request->negeri;
            $company->ownership = $request->ownership;
            $company->no_phone = "60".$request->txtPhoneNo;
            $company->no_phone_office = $request->txtPhoneNoOffice ? "60" . $request->txtPhoneNoOffice : null;
            $company->no_fax = $request->fax;
            $company->email = $request->email;
            if($request->status_bumiputera == "tidak_bumiputera"){
                $company->bumiputera_status = 0;
            }else{
                $company->bumiputera_status = 1;
            }
            
            $company->updated_by = Auth::id();
            $company->save();

            $audit_details = json_encode([
                'Nama Syarikat' => $request->company_name,
                'Alamat' => $request->company_address1 . ', ' . $request->company_address2 . ', ' . $request->company_address3,
                'Negeri' => $request->state_code,
            ]);
            Audit::log('Syarikat', 'Kemaskini Maklumat Syarikat', $audit_details);

            DB::commit();
        } 
        catch (Exception $e) {

            DB::rollback();

            $audit_details = json_encode([
                'Nama Syarikat' => $request->company_name,
            ]);
            Audit::log('Syarikat', 'Kemaskini Maklumat Syarikat Gagal', $audit_details, $e->getMessage());

            // Return error message
            return redirect()->back()->with('alert', __('app.error_occured'));
        }

        return redirect()->route('profile.maklumatSyarikat', ['company_id' => $id])
        ->with('alert', 'Maklumat Am Syarikat Berjaya Dikemaskini.');

    }


    
    public function indexSyarikat()
    {
        $user = auth()->user();
    
        $companies = MaklumatSyarikat::where('user_id', $user->id)
            ->with('pendaftaranPerniagaan') 
            ->get();
            
    
        return view('app.profile.indexSyarikat', [
            'companies' => $companies,
            'state' => Helper::getCodeMastersByType('state')->pluck('name_ms', 'code')->toArray(),
            'ownership' => Helper::getCodeMastersByType('pemilikan_syarikat')->pluck('name_ms', 'code')->toArray(),
        ]);
    }

    public function storeMaklumatSyarikat(Request $request)
    {
        DB::beginTransaction();

        try {

            $company = new MaklumatSyarikat;
            $table_id = Helper::uuid();

            $company->id = $table_id;
            $company->company_name = $request->company_name;
            $company->address1 = $request->company_address1;
            $company->address2 = $request->company_address2;
            $company->address3 = $request->company_address3;
            $company->poskod = $request->poskod;
            $company->district = $request->district;
            $company->state = $request->state_code;
            $company->ownership = $request->ownership_code;
            $company->no_phone = "60" . $request->no_phone;
            $company->no_phone_office = $request->no_phone_office ? "60" . $request->no_phone_office : null;
            $company->no_fax = $request->fax;
            $company->email = $request->email;
            $company->bumiputera_status = $request->bumiputera_status == "tidak_bumiputera" ? 0 : 1;
            
            $company->user_id = Auth::id();
            $company->created_by = Auth::id();
            $company->updated_by = Auth::id();
            
            $company->save();

            $audit_details = json_encode([
                'Nama Syarikat' => $request->company_name,
                'Alamat' => $request->company_address1 . ', ' . $request->company_address2 . ', ' . $request->company_address3,
                'Negeri' => $request->state_code,
            ]);
            Audit::log('Syarikat', 'Tambah Maklumat Syarikat', $audit_details);

            DB::commit();
        } catch (Exception $e) {

            DB::rollback();

            $audit_details = json_encode([
                'Nama Syarikat' => $request->company_name,
            ]);
            Audit::log('Syarikat', 'Tambah Maklumat Syarikat Gagal', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', __('app.error_occured'));
        }

        return redirect()->route('indexSyarikat')->with('alert', 'Maklumat syarikat berjaya disimpan.');
    }

    

    public function penglibatanSyarikat($company_id)
    {
        $company = MaklumatSyarikat::with('involvement')->find($company_id);
        

        if (!$company) {
            return redirect()->back()->with('error', 'Maklumat syarikat tidak dijumpai.');
        }

        $penglibatan_exists = $company->involvement ? true : false;

        return view('app.profile.penglibatanSyarikat', [
            'company' => $company,
            'penglibatan_exists' => $penglibatan_exists,
            'bil_vesel' => $company->involvement->bil_vesel ?? null,
            'jenis_industri' => $company->involvement && $company->involvement->jenis_industri 
            ? json_decode($company->involvement->jenis_industri, true) 
            : [], 
            'industry_options' => Helper::getCodeMastersByType('jenis_industri'),
            'industri_lain' => $company->involvement->industri_lain ?? null,
        ]);
    }

    public function editPenglibatanSyarikat($company_id)
    {
        $company = MaklumatSyarikat::with('involvement')->find($company_id);

        if (!$company) {
            return redirect()->back()->with('error', 'Maklumat syarikat tidak dijumpai.');
        }

        $penglibatan_exists = $company->involvement ? true : false;

        return view('app.profile.editPenglibatanSyarikat', [
            'company' => $company,
            'penglibatan_exists' => $penglibatan_exists,
            'bil_vesel' => $company->involvement->bil_vesel ?? null,
            'jenis_industri' => $company->involvement && $company->involvement->jenis_industri 
            ? json_decode($company->involvement->jenis_industri, true) 
            : [], 
            'industry_options' => Helper::getCodeMastersByType('jenis_industri'),
            'industri_lain' => $company->involvement->industri_lain ?? null,
        ]);
    }

    public function updatePenglibatanSyarikat(Request $request, string $company_id)
    {
        DB::beginTransaction();

        try {
        
            $company = MaklumatSyarikat::findOrFail($company_id);

            $penglibatan = PenglibatanSyarikat::where('company_id', $company_id)->first();

            if ($request->penglibatan == 'pernah_terlibat') {
                $penglibatan->bil_vesel = $request->bilangan_vesel;
                $penglibatan->jenis_industri = $request->has('industri') 
                ? json_encode(array_map('intval', $request->industri)) 
                : null;
                $penglibatan->industri_lain = $request->lain_lain_input;
            } else {
                $penglibatan->bil_vesel = 0;
                $penglibatan->jenis_industri = null;
                $penglibatan->industri_lain = null;
            }

            $penglibatan->updated_by = Auth::id();
            $penglibatan->save();

            $audit_details = json_encode([
                'Nama Syarikat' => $company->company_name,
                'Bilangan Vesel' => $penglibatan->bil_vesel,
                'Industri' => $penglibatan->jenis_industri,
                'Industri Lain' => $penglibatan->industri_lain,
            ]);
            Audit::log('Syarikat', 'Kemaskini Penglibatan Syarikat', $audit_details);

            DB::commit();

            } 
            
            catch (Exception $e) {

                DB::rollback();

                $audit_details = json_encode([
                    'Nama Syarikat' => $company->company_name,
                ]);
                Audit::log('Syarikat', 'Kemaskini Penglibatan Syarikat Gagal', $audit_details, $e->getMessage());

                return redirect()->back()->with('alert', __('app.error_occured'));
            }

        return redirect()->route('profile.penglibatanSyarikat', ['company_id' => $company_id])
        ->with('alert', 'Maklumat Penglibatan Syarikat Berjaya Dikemaskini.');
    }

    

    public function pendaftaranPerniagaan($company_id)
    {
        $user = Auth::user();
        
        $company = MaklumatSyarikat::find($company_id);

        if (!$company) {
            return redirect()->back()->with('error', 'Maklumat syarikat tidak dijumpai.');
        }

        $user_roles_skl = $user->hasRole('PENGUSAHA SKL');
        $user_roles_darat = $user->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)');
        $user_roles_laut = $user->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)');

        return view('app.profile.pendaftaranPerniagaan', [
            'company' => $company,  
            'user_roles_skl' => $user_roles_skl,
            'user_roles_darat' => $user_roles_darat,
            'user_roles_laut' => $user_roles_laut,
        ]);
    }


    public function pemilikanPentadbiran($company_id)
    {

        $user = Auth::user();
    
        $company = MaklumatSyarikat::find($company_id);

        if (!$company) {
            return redirect()->back()->with('error', 'Maklumat syarikat tidak dijumpai.');
        }

        $user_roles_skl = $user->hasRole('PENGUSAHA SKL');
        $user_roles_darat = $user->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)');
        $user_roles_laut = $user->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)');

        return view('app.profile.pemilikanPentadbiran', [
            'company' => $company, 
            'user_roles_skl' => $user_roles_skl,
            'user_roles_darat' => $user_roles_darat,
            'user_roles_laut' => $user_roles_laut,
        
            ]);
    }

    public function kewanganSyarikat($company_id)
    {

        $user = Auth::user();
        
        $company = MaklumatSyarikat::find($company_id);

        if (!$company) {
            return redirect()->back()->with('error', 'Maklumat syarikat tidak dijumpai.');
        }

        $user_roles_skl = $user->hasRole('PENGUSAHA SKL');
        $user_roles_darat = $user->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)');
        $user_roles_laut = $user->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)');

        return view('app.profile.kewanganSyarikat', [
            'company' => $company,  
            'user_roles_skl' => $user_roles_skl,
            'user_roles_darat' => $user_roles_darat,
            'user_roles_laut' => $user_roles_laut,
            'month' => Helper::getCodeMastersByTypeOrder('month'),
        
            ]);
    }

    public function dokumenSyarikat($company_id)
    {

        $user = Auth::user();
        $company = MaklumatSyarikat::find($company_id);

        if (!$company) {
            return redirect()->back()->with('error', 'Maklumat syarikat tidak dijumpai.');
        }
        $user_roles_skl = Auth::user()->hasRole('PENGUSAHA SKL');
        $user_roles_pentadbir_harta = Auth::user()->hasRole('PENTADBIR HARTA');
        $user_roles_darat = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)');
        $user_roles_laut = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)');
        //$profile = ProfileUsers::findOrFail($id);

        return view('app.profile.dokumenSyarikat', [		

            //'profile' => $profile,
            'company' => $company,
            'userTypes' => Helper::getCodeMastersByType('user_type'),
            'user_roles_skl' => $user_roles_skl,
            'user_roles_darat' => $user_roles_darat,
            'user_roles_laut' => $user_roles_laut,
    
        ]);
    }

    //--------------------------- PROJEK SKL ---------------------------------

    public function projekskl(Request $request)
    {

        $user = User::where('id', Auth::id());
        $profile = ProfileUsers::where('user_id', Auth::id())->first();
        $user_roles_skl = Auth::user()->hasRole('PENGUSAHA SKL');
        $user_roles_pentadbir_harta = Auth::user()->hasRole('PENTADBIR HARTA');
        $user_roles_darat = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)');
        $user_roles_laut = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)');

        return view('app.profile.projekskl', [
            'profile' => $profile, 
            'user_roles_skl' => $user_roles_skl,
            'user_roles_darat' => $user_roles_darat,
            'user_roles_laut' => $user_roles_laut,

        ]);
    }

    public function handleprojekskl(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;
        $user_roles_skl = Auth::user()->hasRole('PENGUSAHA SKL');
        $user_roles_pentadbir_harta = Auth::user()->hasRole('PENTADBIR HARTA');
        $user_roles_darat = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN DARAT)');
        $user_roles_laut = Auth::user()->hasRole('PEMOHON LESEN VESEL (NELAYAN LAUT)');

        if ($profile && $profile->race) {
           
            return view('app.profile.userview', [
                'profile' => $profile,
                'userTypes' => Helper::getCodeMastersByType('user_type'),
                'race' => Helper::getCodeMastersByTypeOrder('race'),
                'state' => Helper::getCodeMastersByType('state'),
                'gender' => Helper::getCodeMastersByType('gender'),
                'religion' => Helper::getCodeMastersByTypeOrder('religion'),
                'marital_status' => Helper::getCodeMastersByTypeOrder('marital_status'),
                'user_roles_skl' => $user_roles_skl,
                'user_roles_darat' => $user_roles_darat,
                'user_roles_laut' => $user_roles_laut,
            ]);
            
        }

        return view('app.profile.user', [
            'userTypes' => Helper::getCodeMastersByType('user_type'),
            'race' => Helper::getCodeMastersByTypeOrder('race'),
            'state' => Helper::getCodeMastersByType('state'),
            'gender' => Helper::getCodeMastersByType('gender'),
            'religion' => Helper::getCodeMastersByTypeOrder('religion'),
            'marital_status' => Helper::getCodeMastersByTypeOrder('marital_status'),
            'user_roles_skl' => $user_roles_skl,
            'user_roles_darat' => $user_roles_darat,
            'user_roles_laut' => $user_roles_laut,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function profileCompanyCreate()
    {

        $companies = ProfileCompany::where('user_id', Auth::id());

        return view('app.profile.companyCreate', [		
            'userTypes' => Helper::getCodeMastersByType('user_type'),
            'states' => Helper::getCodeMastersByType('state'),
            'q' => '',
            'companies' => $companies->orderBy('company_name')->paginate(10),
        ]);
    }

    public function profileCompanyAlpList($id)
    {

        $companies = ProfileCompany::find($id);

        $alps = ProfileCompanyAlp::where('company_profile_id', $id);

        return view('app.profile.companyAlpList', [		
            'company_profile_id' => $id,
            'alps' => $alps->orderBy('alp_name')->paginate(10),
        ]);
    }

    public function profileCompanyAlpCreate($id)
    {
        return view('app.profile.companyAlpCreate', [		
            'company_profile_id' => $id,
        ]);
    }

    public function profileCompanyAssetList($id)
    {

        $companies = ProfileCompany::find($id);

        $assets = ProfileCompanyAsset::where('company_profile_id', $id);

        return view('app.profile.companyAssetList', [		
            'company_profile_id' => $id,
            'assets' => $assets->orderBy('asset_name')->paginate(10),
        ]);
    }

    public function profileCompanyAssetCreate($id)
    {
        return view('app.profile.companyAssetCreate', [		
            'company_profile_id' => $id,
        ]);
    }

    public function profileCompanyAccountList($id)
    {

        $companies = ProfileCompany::find($id);

        $accs = ProfileCompanyAccount::where('company_profile_id', $id);

        return view('app.profile.companyAccountList', [		
            'company_profile_id' => $id,
            'accs' => $accs->orderBy('title')->paginate(10),
        ]);
    }

    public function profileCompanyAccountCreate($id)
    {
        return view('app.profile.companyAccountCreate', [		
            'company_profile_id' => $id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    public function profileCompanyStore(Request $request)
    {
        DB::beginTransaction();

        try {

            $comp = new ProfileCompany;

            $comp->company_name = $request->input('txtCompanyName');
            $comp->company_reg_no = $request->input('txtCompanyRegNo');
            $comp->company_reg_date = $request->input('txtCompanyRegDate');
            $comp->lhdn_account_no = $request->input('txtLhdnAccountNo');
            $comp->current_address1 = $request->input('txtCurrentAddress1');
            $comp->current_address2 = $request->input('txtCurrentAddress2');
            $comp->current_address3 = $request->input('txtCurrentAddress3');
            $comp->current_postcode = $request->input('txtCurrentPostcode');
            $comp->current_district = $request->input('txtCurrentCity');
            $comp->current_state_id = $request->input('selCurrentState');
            $comp->letter_address1 = $request->input('txtLetterAddress1');
            $comp->letter_address2 = $request->input('txtLetterAddress2');
            $comp->letter_address3 = $request->input('txtLetterAddress3');
            $comp->letter_postcode = $request->input('txtLetterPostcode');
            $comp->letter_district = $request->input('txtLetterCity');
            $comp->letter_state_id = $request->input('selLetterState');
            $comp->phone_no = $request->input('txtPhoneNo');
            $comp->fax_no = $request->input('txtFaxNo');
            $comp->email = $request->input('txtEmail');
            $comp->comp_sec = $request->input('txtSecretary');
            $comp->ownership = $request->input('txtOwnership');
            $comp->bumiputera_status = $request->input('bumiputera');
            $comp->modal_allow = $request->input('txtModalAllow');
            $comp->modal_paid = $request->input('txtModalPaid');
            $comp->company_business = $request->input('txtCompanyBusiness');
            $comp->company_exp_fish = $request->input('txtCompanyExpFish');
            $comp->company_exp_other = $request->input('txtCompanyExpOther');
            $comp->user_id = Auth::id();

            
            $comp->updated_by = Auth::id();
            $comp->save();

            $audit_details = json_encode([ 
                'company_name' => $request->txtCompanyName,
                'company_reg_no' => $request->txtCompanyRegNo,
                'company_reg_date' => $request->txtCompanyRegDate,
                'lhdn_account_no' => $request->txtLhdnAccountNo,
                'current_address1' => $request->txtCurrentAddress1,
                'current_address2' => $request->txtCurrentAddress2,
                'current_address3' => $request->txtCurrentAddress3,
                'current_postcode' => $request->txtCurrentPostcode,
                'current_district' => $request->txtCurrentDistrict,
                'current_state_id' => $request->selCurrentState,
                'letter_address1' => $request->txtLetterAddress1,
                'letter_address2' => $request->txtLetterAddress2,
                'letter_address3' => $request->txtLetterAddress3,
                'letter_postcode' => $request->txtLetterPostcode,
                'letter_district' => $request->txtLetterDistrict,
                'letter_state_id' => $request->selLetterState,
                'phone_no' => $request->txtPhoneNo,
                'fax_no' => $request->txtFaxNo,
                'email' => $request->txtEmail,
                'company_sec' => $request->txtSecretary,
                'ownership' => $request->txtOwnership,
                'bumiputera_status' => $request->bumiputera,
                'modal_allow' => $request->txtModalAllow,
                'modal_paid' => $request->txtModalPaid,
                'company_business' => $request->txtCompanyBusiness,
                'company_exp_fish' => $request->txtCompanyExpFish,
                'company_exp_other' => $request->txtCompanyExpOther,
                'user_id' => Auth::id(),

            ]);
            Audit::log('profile_company', 'add', $audit_details);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'company_name' => $request->txtCompanyName,
                'company_reg_no' => $request->txtCompanyRegNo,
                'company_reg_date' => $request->txtCompanyRegDate,
                'lhdn_account_no' => $request->txtLhdnAccountNo,
                'current_address1' => $request->txtCurrentAddress1,
                'current_address2' => $request->txtCurrentAddress2,
                'current_address3' => $request->txtCurrentAddress3,
                'current_postcode' => $request->txtCurrentPostcode,
                'current_district' => $request->txtCurrentDistrict,
                'current_state_id' => $request->selCurrentState,
                'letter_address1' => $request->txtLetterAddress1,
                'letter_address2' => $request->txtLetterAddress2,
                'letter_address3' => $request->txtLetterAddress3,
                'letter_postcode' => $request->txtLetterPostcode,
                'letter_district' => $request->txtLetterDistrict,
                'letter_state_id' => $request->selLetterState,
                'phone_no' => $request->txtPhoneNo,
                'fax_no' => $request->txtFaxNo,
                'email' => $request->txtEmail,
                'company_sec' => $request->txtSecretary,
                'ownership' => $request->txtOwnership,
                'bumiputera_status' => $request->bumiputera,
                'modal_allow' => $request->txtModalAllow,
                'modal_paid' => $request->txtModalPaid,
                'company_business' => $request->txtCompanyBusiness,
                'company_exp_fish' => $request->txtCompanyExpFish,
                'company_exp_other' => $request->txtCompanyExpOther,
                'user_id' => Auth::id(),
            ]);
            Audit::log('profile_company', 'add', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('ProfileController@user')->with('t_success', __('app.company_profile_updated'));
    }

    public function profileCompanyAlpStore(Request $request)
    {
        DB::beginTransaction();

        try {

            $alps = new ProfileCompanyAlp;

            $alps->company_profile_id = $request->hide_appid;
            $alps->alp_name = $request->txtFullName;
            $alps->alp_icno = $request->txtICNo;
            $alps->alp_email = $request->txtEmail;
            $alps->alp_phone_no = $request->txtPhoneNo;
            $alps->alp_position = $request->txtPosition;
            $alps->alp_citizenship = $request->citizenship;
            $alps->alp_status = 1;
            
            $alps->created_by = Auth::id();
            $alps->updated_by = Auth::id();
            $alps->save();

            $audit_details = json_encode([ 
                'company_profile_id' => $request->hide_appid,
                'alp_name' => $request->txtFullName,
                'alp_icno' => $request->txtICNo,
                'alp_email' => $request->txtEmail,
                'alp_phone_no' => $request->txtPhoneNo,
                'alp_position' => $request->txtPosition,
                'alp_citizenship' => $request->citizenship,
                'alp_status' => 'Aktif',

            ]);
            Audit::log('profile_company_alp', 'add', $audit_details);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'company_profile_id' => $request->hide_appid,
                'alp_name' => $request->txtFullName,
                'alp_icno' => $request->txtICNo,
                'alp_email' => $request->txtEmail,
                'alp_phone_no' => $request->txtPhoneNo,
                'alp_position' => $request->txtPosition,
                'alp_citizenship' => $request->citizenship,
                'alp_status' => 'Aktif',
            ]);
            Audit::log('profile_company_alp', 'add', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('ProfileController@profileCompanyAlpList', $request->hide_appid)->with('t_success', __('app.company_profile_updated'));
    }

    public function profileCompanyAssetStore(Request $request)
    {
        DB::beginTransaction();

        try {

            $assets = new ProfileCompanyAsset;

            $assets->company_profile_id = $request->hide_appid;
            $assets->asset_name = $request->txtAssetName;
            $assets->asset_status = 1;
            
            $assets->created_by = Auth::id();
            $assets->updated_by = Auth::id();
            $assets->save();

            $audit_details = json_encode([ 
                'company_profile_id' => $request->hide_appid,
                'asset_name' => $request->txtAssetName,
                'asset_status' => 'Aktif',
            ]);
            Audit::log('profile_company_asset', 'add', $audit_details);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'company_profile_id' => $request->hide_appid,
                'asset_name' => $request->txtAssetName,
                'asset_status' => 'Aktif',
            ]);
            Audit::log('profile_company_asset', 'add', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('ProfileController@profileCompanyAssetList', $request->hide_appid)->with('t_success', __('app.company_profile_updated'));
    }

    public function profileCompanyAccountStore(Request $request)
    {
        DB::beginTransaction();

        try {
            
            if ($request->file('fileDoc')) {

                /*$file = $request->file('fileDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $file_lower = strtolower($file_replace);
                $filename = $file_lower;				
                //Store file into public folder
                $file->move(public_path('storage/'), $filename);*/
                
                $file = $request->file('fileDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;				
                $path = $request->file('fileDoc')->store('public/penyataakaun');

                //store your file into database
                $acc = new ProfileCompanyAccount;
                $acc->company_profile_id = $request->hide_appid;            
                $acc->account_year = $request->selAccountYear;
                $acc->title = $request->txtTitle;
                $acc->file_path = $path;
                $acc->filename = $filename;

                $acc->created_by = $request->user()->id;
                $acc->updated_by = $request->user()->id;

                $acc->save();
                
                $audit_details = json_encode([ 
                    'account_year'=> $request->selAccountYear,
                    'title' => $request->txtTitle,
                    'path' => $path,
                ]);

                Audit::log('profile_company_account', 'add', $audit_details);
            }

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'account_year'=> $request->selAccountYear,
                'title' => $request->title,
                'path' => $request->path,
            ]);
            Audit::log('profile_company_account', 'add', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('ProfileController@profileCompanyAccountList', $request->hide_appid)->with('t_success', __('app.company_profile_updated'));
    }

    //Download Account File
    public function profileCompanyAccountDownload($id)
    {
        $acc = ProfileCompanyAccount::find($id);

        if (Storage::exists($acc->file_path)) {
            

            //Format - PDF
            if (Str::contains($acc->file_path, '.pdf'))
            {
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
            }
            //Format - JPG
            elseif(Str::contains($acc->file_path, '.jpg'))
            {
                $headers = [
                    'Content-Type' => 'application/jpg',
                ];
            }
            //Format - PNG
            elseif(Str::contains($acc->file_path, '.PNG'))
            {
                $headers = [
                    'Content-Type' => 'application/PNG',
                ];
            }
            else
            {
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
            }

            return Storage::download($acc->file_path, $acc->filename, $headers);
        }
        return redirect('/404');
    }

    public function profileCompanyAccountDelete(Request $request, $id)
    {

        $acc = ProfileCompanyAccount::find($id);

        $audit_details = json_encode([
            'title' => $request->title,
            'path' => $request->path,
        ]);

        try {

            $acc->deleted_by = request()->user()->id;
            $acc->is_deleted = true;
            $acc->save();

            Audit::log('profile_company_account', 'delete', $audit_details);
        }
        catch (Exception $e) {

            Audit::log('profile_company_account', 'delete', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('ProfileController@profileCompanyAccountList', $request->hide_appid)->with('t_success', __('app.company_profile_updated'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function userUpdate(Request $request)
    {
        DB::beginTransaction();

        try {

            $user = User::find(Auth::id());
            $user->user_type = $request->selUserType;
            $user->email = $request->email;
            $user->bumiputera_type = $request->bumiputera;
            $user->mobile_contact_number = $request->mobilePhone;
            $user->contact_number = $request->phoneNo;
            $user->address1 = $request->address1;
            $user->address2 = $request->address2;
            $user->address3 = $request->address3;
            $user->postcode = $request->postcode;
            $user->district = $request->district;
            $user->state_id = $request->selState;
            
            $user->updated_by = Auth::id();
            $user->save();

            $audit_details = json_encode([ 
                'user_type' => $request->selUserType,
                'email' => $request->email,
                'bumiputera_type' => $request->bumiputera,
                'mobile_contact_number' => $request->mobilePhone,
                'contact_number' => $request->phoneNo,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'address3' => $request->address3,
                'postcode' => $request->postcode,
                'district' => $request->district,
                'state_id' => $request->selState,
            ]);
            Audit::log('users', 'update', $audit_details);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'user_type' => $request->selUserType,
                'email' => $request->email,
                'bumiputera_type' => $request->bumiputera,
                'mobile_contact_number' => $request->mobilePhone,
                'contact_number' => $request->phoneNo,
                'address1' => $request->address1,
                'address2' => $request->address2,
                'address3' => $request->address3,
                'postcode' => $request->postcode,
                'district' => $request->district,
                'state_id' => $request->selState,
            ]);
            Audit::log('users', 'update', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('ProfileController@user')->with('t_success', __('app.user_updated', [ 'user' => $user->name ]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
