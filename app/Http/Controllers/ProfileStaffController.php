<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProfileStaff;

//Copy
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
use App\Mail\TestProfileStaff;

class ProfileStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function stafflist(Request $request)
    {
        $staffs = ProfileStaff::sortable();

        //Filter Carian
        $filterName = !empty($request->txtName) ? $request->txtName : '';
        $filterICNO = !empty($request->txtICNO) ? $request->txtICNO : '';

        if (!empty($filterName)) {
            $staffs->where('name', 'like', '%'.$filterName.'%');
        }

        if (!empty($filterICNO)) {
            $staffs->where('icno', 'like', '%'.$filterICNO.'%');
        }

        //return view
        return view('app.profile.stafflist', [
            'staffs' => $staffs->orderBy('name')->paginate(10),
            'filterName' => $filterName,
            'filterICNO' => $filterICNO,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function staffcreate()
    {
        //return view
        return view('app.profile.staffcreate', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function staffstore(Request $request)
    {

        //Validation
        $this->validate($request, [
            'txtName' => 'required|string|max:10',
            'txtEmail' => 'required|string|email|max:50',
        ],
        [
            'txtName.max' => 'Nama mestilah maksimum 10 karakter.',
        ]);

        DB::beginTransaction();

        try {
            
            $staff = new ProfileStaff();

            $staff->name = $request->txtName;
            $staff->icno = $request->txtICNO;
            $staff->email = $request->txtEmail;
            $staff->phone_no = $request->txtPhoneNo;
            $staff->is_active = true;

            $staff->created_by = Auth::id();
            $staff->updated_by = Auth::id();
            $staff->save();

            //Audit Log
            $audit_details = json_encode([ 
                'Nama' => $request->txtName,
                'No. Kad Pengenalan' => $request->txtICNO, 
                'Emel' => $request->txtEmail,
                'No. Telefon' => $request->txtPhoneNo,
            ]);

            Audit::log('Profil Kakitangan', 'Tambah', $audit_details);

            //Execute
            DB::commit();

            //============================ EMEL ======================== 

            $mailDataArr = array(
                'name' => strtoupper($request->txtName),
            );

            //Send email to penerima hebahan
            Mail::to($request->txtEmail)->queue(new TestProfileStaff($mailDataArr));

            //============================ TAMAT EMEL ======================== 
        }
        catch (Exception $e) {
            
            DB::rollback();

            $audit_details = json_encode([ 
                'Nama' => $request->txtName,
                'No. Kad Pengenalan' => $request->txtICNO, 
                'Emel' => $request->txtEmail,
                'No. Telefon' => $request->txtPhoneNo,
            ]);
            Audit::log('Profil Kakitangan', 'Tambah', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Kakitangan gagal dicipta !!');
        }

        return redirect()->action('ProfileStaffController@stafflist')->with('alert', 'Kakitangan berjaya dicipta !!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function staffview(string $id)
    {
        $staff = ProfileStaff::find($id);

        //return view
        return view('app.profile.staffview', [
            'id' => $id,
            'staff' => $staff,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function staffedit(string $id)
    {
        $staff = ProfileStaff::find($id);

        //return view
        return view('app.profile.staffedit', [
            'id' => $id,
            'staff' => $staff,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function staffupdate(Request $request, string $id)
    {
        //Validation
        $this->validate($request, [
            'txtName' => 'required|string|max:10',
            'txtEmail' => 'required|string|email|max:50',
        ],
        [
            'txtName.max' => 'Nama mestilah maksimum 10 karakter.',
        ]);

        DB::beginTransaction();

        try {
            
            $staff = ProfileStaff::find($id);

            $staff->name = $request->txtName;
            $staff->icno = $request->txtICNO;
            $staff->email = $request->txtEmail;
            $staff->phone_no = $request->txtPhoneNo;

            if($request->selStatus == 1){
                $staff->is_active = true;
            }
            else{
                $staff->is_active = false;
            }
            
            $staff->updated_by = Auth::id();
            $staff->save();

            //Audit Log
            $audit_details = json_encode([ 
                'Nama' => $request->txtName,
                'No. Kad Pengenalan' => $request->txtICNO, 
                'Emel' => $request->txtEmail,
                'No. Telefon' => $request->txtPhoneNo,
            ]);

            Audit::log('Profil Kakitangan', 'Kemaskini', $audit_details);

            //Execute
            DB::commit();
        }
        catch (Exception $e) {
            
            DB::rollback();

            $audit_details = json_encode([ 
                'Nama' => $request->txtName,
                'No. Kad Pengenalan' => $request->txtICNO, 
                'Emel' => $request->txtEmail,
                'No. Telefon' => $request->txtPhoneNo,
            ]);
            Audit::log('Profil Kakitangan', 'Kemaskini', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Kakitangan gagal disimpan !!');
        }

        return redirect()->action('ProfileStaffController@stafflist')->with('alert', 'Kakitangan berjaya disimpan !!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function staff(Request $request)
    {
        // For now, just reuse the stafflist logic
        return $this->stafflist($request);
    }
}
