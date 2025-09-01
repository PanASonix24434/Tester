<?php

namespace App\Http\Controllers\SubsistenceAllowance;
use Illuminate\Http\Request;
use App\Models\SerialNumber;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;

use App\Models\SubsistenceAllowance\SubApplication;
use App\Models\SubsistenceAllowance\SubsistenceDocuments;
use App\Models\SubsistenceAllowance\SubsistenceAuditLogStatus;

use Audit;
use Exception;
use Carbon\Carbon;
use Storage;
use Helper;
use DB;
use App\Models\CodeMaster;
use App\Models\darat_user_fisherman_info;
use App\Models\LandingDeclaration\LandingDeclarationMonthly;
use App\Models\ProfileUser;
use App\Models\Systems\AuditLog;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class SubAllowanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->name == 'Super Admin') {
			$subApplication = SubApplication::whereNotIn('type_registration', ['Renew', 'Rayuan Pembaharuan'])->sortable();
            $canApply = false;
            $subApplicationList = SubApplication::first();

		} else {
            $curMonth = Carbon::now();
            $prev1Month = $curMonth->copy()->subMonth();//use copy or it will substract at the original
            $prev2Month = $prev1Month->copy()->subMonth();
            $prev3Month = $prev2Month->copy()->subMonth();
            $verifiedPrev3MonthlyLandings = LandingDeclarationMonthly::where('user_id', Auth::id())
            ->where(function ($query) use ($prev1Month,$prev2Month,$prev3Month) {
                $query->where(function ($query) use ($prev1Month) {
                    $query->where('year', $prev1Month->year)
                        ->where('month', $prev1Month->month);
                })->orWhere(function ($query) use ($prev2Month) {
                    $query->where('year', $prev2Month->year)
                        ->where('month', $prev2Month->month);
                })->orWhere(function ($query) use ($prev3Month) {
                    $query->where('year', $prev3Month->year)
                        ->where('month', $prev3Month->month);
                });
            })
            ->where('is_verified',true)->get();
            $canApply = $verifiedPrev3MonthlyLandings->count() >= 3;
            $subApplication = SubApplication::where('created_by', Auth::id())
            ->whereNotIn('type_registration',  ['Renew', 'Rayuan Pembaharuan'])->sortable();

            $subApplicationList = SubApplication::where('created_by', Auth::id())->first();
		}

        return view('app.subsistence_allowance.index', [
            'subApplication' => $request->has('sort') ? $subApplication->paginate(10) : $subApplication->orderBy('created_at')->paginate(10),
		    'subApplicationList' =>  $subApplicationList,
            'canApply' => $canApply
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
        // Retrieve all request data
        $data = $request->all();
        
        DB::beginTransaction();

        try {
            $subApplication = new SubApplication();
            $subApplication->user_id = Auth::user()->id;
            $subApplication->fullname = $data['fullname'];
            $subApplication->icno = $data['icno'];

            $subApplication->address1 = $data['address1'];
            $subApplication->address2 = $data['address2'];
            $subApplication->address3 = $data['address3'];
            $subApplication->postcode = $data['postcode'];
            $subApplication->district_id = $data['districtId'];
            $subApplication->state_id = $data['stateId'];
            $subApplication->contact_number = $data['phoneNo'];

            $subApplication->bank_id = $data['bank_id'];
            $subApplication->no_account = $data['no_account'];
            $subApplication->state_bank_id = $data['state_bank_id'];
            $subApplication->created_by = Auth::user()->id;
            $subApplication->save();

            $audit_details = json_encode([
                'id' =>  $subApplication->id,
                'fullname' => $data['fullname'],
                'icno' => $data['icno'],

                'address1' => $data['address1'],
                'address2' => $data['address2'],
                'address3' => $data['address3'],
                'postcode' => $data['postcode'],
                'district_id' => $data['districtId'],
                'state_id' => $data['stateId'],
                'contact_number' => $data['phoneNo'],

                'bank_id' => $data['bank_id'],
                'no_account' => $data['no_account'],
                'state_bank_id' => $data['state_bank_id'],
            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Simpan Maklumat Permohonan',  $audit_details);

            DB::commit();
            return redirect()->route('subsistence-allowance.application.formwork', $subApplication->id)->with('alert', 'Permohonan berjaya disimpan !!');
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([
                'id' =>  $subApplication->id,
                'fullname' => $data['fullname'],
                'icno' => $data['icno'],

                'address1' => $data['address1'],
                'address2' => $data['address2'],
                'address3' => $data['address3'],
                'postcode' => $data['postcode'],
                'district_id' => $data['districtId'],
                'state_id' => $data['stateId'],
                'contact_number' => $data['phoneNo'],

                'bank_id' => $data['bank_id'],
                'no_account' => $data['no_account'], // Fixed issue here
                'state_bank_id' => $data['state_bank_id'],
            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Simpan Maklumat Permohonan', $audit_details, $e->getMessage());
            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    public function store_appeal(Request $request)
    {
        // Retrieve all request data
        $data = $request->all();


        DB::beginTransaction();

        try {
            $subApplication = new SubApplication;
            $subApplication->id = Helper::uuid();
            $subApplication->fullname = $data['fullname'];
            $subApplication->icno = $data['icno'];
            $subApplication->bank_id = $data['bank_id'];
            $subApplication->no_account = $data['no_account'];
            $subApplication->state_bank_id = $data['state_bank_id'];
            $subApplication->created_by = Auth::user()->id;
            $subApplication->type_registration = 'Rayuan';

           // Running Number Registeration
            // $runningNumberInt = (SerialNumber::max('running_number') ?? 0) + 1;
            $runningNumberInt = (SerialNumber::lockForUpdate()->max('running_number') ?? 0) + 1;
            $runningNumber = str_pad($runningNumberInt, 7, '0', STR_PAD_LEFT);
            $subApplication->registration_no = $runningNumber;

            $subApplication->save(); // This will insert a new record



            $appRunningNumber = new SerialNumber;
            $appRunningNumber->id = Helper::uuid();
            $appRunningNumber->application_id =  Auth::id();
            $appRunningNumber->prefix = '';
            $appRunningNumber->running_number = $runningNumberInt;
            $appRunningNumber->suffix = '';
            $appRunningNumber->created_by = Auth::id();
            $appRunningNumber->updated_by = Auth::id();
            $appRunningNumber->save();

            //Save Dokumen
            if($request->hasFile('fileResult')){

                $file = $request->file('fileResult');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path2 = $request->file('fileResult')->store('public/PermohonanElaunSara/KWSP');

                $subDocument = new SubsistenceDocuments;

                $subDocument->subsistence_application_id =  $subApplication->id;
                $subDocument->title = 'Keputusan Surat KWSP';
                $subDocument->file_path =  $path2;
                $subDocument->file_detail = $filename;
                $subDocument->created_by = Auth::user()->id;
                $subDocument->updated_by = Auth::user()->id;

                $subDocument->save();

            }

            //Save Dokumen
            if($request->hasFile('fileAADK')){

                $file = $request->file('fileAADK');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path1 = $request->file('fileAADK')->store('public/PermohonanElaunSara/AADK');

                $subDocument = new SubsistenceDocuments;

                $subDocument->subsistence_application_id =  $subApplication->id;
                $subDocument->title = 'Keputusan AADK';
                $subDocument->file_path =  $path1;
                $subDocument->file_detail = $filename;
                $subDocument->created_by = Auth::user()->id;
                $subDocument->updated_by = Auth::user()->id;

                $subDocument->save();

            }

            $audit_details = json_encode([
                'id' =>  $subApplication->id,
                'fullname' => $data['fullname'],
                'icno' => $data['icno'],
                'bank_id' => $data['bank_id'],
                'no_account' => $data['no_account'],
                'state_bank_id' => $data['state_bank_id'],

                // First Document Upload
                'document1_name' => 'Keputusan AADK',
                'document1_path' => 'public/PermohonanElaunSara/AADK',

                // Second Document Upload
                'document2_name' =>'Keputusan Surat KWSP',
                'document2_path' => 'public/PermohonanElaunSara/KWSP',

                'uploaded_at' => now()->toDateTimeString(),
            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Simpan Maklumat Permohonan',  $audit_details);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([
                'id' =>  $subApplication->id,
                'fullname' => $data['fullname'],
                'icno' => $data['icno'],
                'bank_id' => $data['bank_id'],
                'no_account' => $data['no_account'], // Fixed issue here
                'state_bank_id' => $data['state_bank_id'],

                // First Document Upload
                'document1_name' => 'Keputusan AADK',
                'document1_path' =>'public/PermohonanElaunSara/AADK',

                // Second Document Upload
                'document2_name' =>'Keputusan Surat KWSP',
                'document2_path' =>'public/PermohonanElaunSara/KWSP',

                'uploaded_at' => now()->toDateTimeString(),
            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Simpan Maklumat Permohonan', $audit_details, $e->getMessage());

                return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
            }


            return redirect()->action('SubsistenceAllowance\SubAllowanceController@formwork', $subApplication->id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    public function storeWork(Request $request)
    {
        // Retrieve all request data
        $data = $request->all();


        DB::beginTransaction();

        try {

            // Find existing record by application_id
            $subApplication= SubApplication::find($request->application_id);


            $subApplication->fisherman_type_id  = $data['statusNelayanId'];
            $subApplication->year_become_fisherman = $data['startYear'];
            $subApplication->becoming_fisherman_duration = $data['duration'];
            $subApplication->working_days_fishing_per_month = $data['fishDays'];
            $subApplication->tot_incomefish = $data['fishing_income'];
            $subApplication->tot_incomeother = $data['other_income'];
            $subApplication->tot_allincome = $data['total_income'];
            $subApplication->updated_by = Auth::user()->id;

            $subApplication->save(); // This will insert a new record



            $audit_details = json_encode([
                'id' =>  $request->application_id,
                'fisherman_type_id' => $data['statusNelayanId'],
                'year_become_fisherman' => $data['startYear'],
                'becoming_fisherman_duration' => $data['duration'],
                'working_days_fishing_per_month' => $data['fishDays'],
                'tot_incomefish' => $data['fishing_income'],
                'tot_incomeother' => $data['other_income'],
                'tot_allincome' => $data['total_income'],
            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Simpan Maklumat Pekerjaan',  $audit_details);

            DB::commit();
            return redirect()->route('subsistence-allowance.application.formdependent', $request->application_id)->with('alert', 'Permohonan berjaya disimpan !!');
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([
                'id' =>  $request->application_id,
                'fisherman_type_id' => $data['statusNelayanId'],
                'year_become_fisherman' => $data['startYear'],
                'becoming_fisherman_duration' => $data['duration'],
                'working_days_fishing_per_month' => $data['fishDays'],
                'tot_incomefish' => $data['fishing_income'],
                'tot_incomeother' => $data['other_income'],
                'tot_allincome' => $data['total_income'],

            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Simpan Maklumat Pekerjaan', $audit_details, $e->getMessage());
            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    public function storeDependent(Request $request)
    {
        // Retrieve all request data
        $data = $request->all();

        DB::beginTransaction();

        try {
            // Find existing record by application_id
            $subApplication= SubApplication::find($request->application_id);
            $subApplication->tot_child = $data['tot_child'];
            $subApplication->tot_otherchild = $data['child_other'];
            $subApplication->tot_allchild = $data['total_allchild'];
            $subApplication->updated_by = Auth::user()->id;
            $subApplication->save(); // This will insert a new record

            $audit_details = json_encode([
                'id' =>  $request->application_id,
                'tot_child' => $data['tot_child'],
                'tot_otherchild' => $data['child_other'],
                'tot_allchild' => $data['total_allchild'],


            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Simpan Maklumat Tanggungan',  $audit_details);

            DB::commit();
            return redirect()->route('subsistence-allowance.application.formeducation', $request->application_id)->with('alert', 'Permohonan berjaya disimpan !!');
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([
                'id' =>  $request->application_id,
                'tot_child' => $data['tot_child'],
                'tot_otherchild' => $data['child_other'],
                'tot_allchild' => $data['total_allchild'],

            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Simpan Maklumat Tanggungan', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    public function storeEducation(Request $request)
    {
        // Retrieve all request data
        $data = $request->all();

        DB::beginTransaction();

        try {

            // Find existing record by application_id
            $subApplication= SubApplication::find($request->application_id);

            $subApplication->is_primary = false;
            $subApplication->is_secondary = false;
            $subApplication->is_uni = false;
            $subApplication->is_notschool = false;

            if($request->education == 'is_primary') $subApplication->is_primary = true;
            if($request->education == 'is_secondary') $subApplication->is_secondary = true;
            if($request->education == 'is_uni') $subApplication->is_uni = true;
            if($request->education == 'no_school') $subApplication->is_notschool = true;

            $subApplication->updated_by = Auth::user()->id;

            $subApplication->save(); // This will insert a new record

            $audit_details = json_encode([
                'id' =>  $request->application_id,
                'is_primary' =>  $request->has('is_primary') ,
                'is_secondary' => $request->has('is_secondary'),
                'is_uni' => $request->has('is_uni'),
                'is_notschool' => $request->has('is_notschool'),
            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Simpan Maklumat Pendidikan',  $audit_details);

            DB::commit();
            return redirect()->route('subsistence-allowance.application.formdoc', $request->application_id)->with('alert', 'Permohonan berjaya disimpan !!');
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([
                'id' =>  $request->application_id,
                'is_primary' =>  $request->has('is_primary') ,
                'is_secondary' => $request->has('is_secondary'),
                'is_uni' => $request->has('is_uni'),
                'is_notschool' => $request->has('is_notschool'),

            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Simpan Maklumat Pendidikan', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    public function storeDoc(Request $request)
    {
        $subApplication = SubApplication::find($request->application_id);
        DB::beginTransaction();

        try {

            //Save Dokumen
            if($request->hasFile('fileResult')){

                $file = $request->file('fileResult');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path2 = $request->file('fileResult')->store('public/PermohonanElaunSara/KWSP');

                $subDocument = new SubsistenceDocuments;

                $subDocument->subsistence_application_id =  $subApplication->id;
                $subDocument->title = 'Keputusan Surat KWSP';
                $subDocument->file_path =  $path2;
                $subDocument->file_detail = $filename;
                $subDocument->created_by = Auth::user()->id;
                $subDocument->updated_by = Auth::user()->id;

                $subDocument->save();

            }

            //Save Dokumen
            if($request->hasFile('fileAADK')){

                $file = $request->file('fileAADK');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path1 = $request->file('fileAADK')->store('public/PermohonanElaunSara/AADK');

                $subDocument = new SubsistenceDocuments;

                $subDocument->subsistence_application_id =  $subApplication->id;
                $subDocument->title = 'Keputusan AADK';
                $subDocument->file_path =  $path1;
                $subDocument->file_detail = $filename;
                $subDocument->created_by = Auth::user()->id;
                $subDocument->updated_by = Auth::user()->id;

                $subDocument->save();

            }

            //Save Dokumen
            if($request->hasFile('fileAkuan')){

                $file = $request->file('fileAkuan');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path1 = $request->file('fileAkuan')->store('public/PermohonanElaunSara/AkuanSumpah');

                $subDocument = new SubsistenceDocuments;

                $subDocument->subsistence_application_id =  $subApplication->id;
                $subDocument->title = 'Akuan Sumpah';
                $subDocument->file_path =  $path1;
                $subDocument->file_detail = $filename;
                $subDocument->created_by = Auth::user()->id;
                $subDocument->updated_by = Auth::user()->id;

                $subDocument->save();

            }

            $audit_details = json_encode([

                // First Document Upload
                'document1_name' => 'Keputusan AADK',
                'document1_path' => 'public/PermohonanElaunSara/AADK',

                // Second Document Upload
                'document2_name' =>'Keputusan Surat KWSP',
                'document2_path' => 'public/PermohonanElaunSara/KWSP',

                // Second Document Upload
                'document3_name' =>'Akuan Sumpah',
                'document3_path' => 'public/PermohonanElaunSara/AkuanSumpah',

                'uploaded_at' => now()->toDateTimeString(),
            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Simpan Maklumat Permohonan',  $audit_details);

            DB::commit();
            return redirect()->route('subsistence-allowance.application.formdeclaration', $request->application_id)->with('alert', 'Permohonan berjaya disimpan !!');
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([
                'id' =>  $request->application_id,

                // First Document Upload
                'document1_name' => 'Keputusan AADK',
                'document1_path' =>'public/PermohonanElaunSara/AADK',

                // Second Document Upload
                'document2_name' =>'Keputusan Surat KWSP',
                'document2_path' =>'public/PermohonanElaunSara/KWSP',

                // Second Document Upload
                'document3_name' =>'Akuan Sumpah',
                'document3_path' => 'public/PermohonanElaunSara/AkuanSumpah',

                'uploaded_at' => now()->toDateTimeString(),
            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Simpan Maklumat Permohonan', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    public function storeDeclaration(Request $request)
    {
        // Retrieve all request data
        $data = $request->all();


        DB::beginTransaction();

        try {

            // Find existing record by application_id
            $subApplication= SubApplication::where('id',  $request->application_id)->first();
            $subApplication->declaration = 1;

            if ($request->input('action') === 'send'){
                $user = User::find(Auth::user()->id);
                $subApplication->entity_id = $user->entity_id;
                if($subApplication->submitted_at == null){
                    $subApplication->submitted_at = Carbon::now()->toDateTimeString();
                }

                if($subApplication->reference_number == null){
                    $runningNumberInt = (SerialNumber::lockForUpdate()->max('running_number') ?? 0) + 1;
                    $runningNumber = str_pad($runningNumberInt, 7, '0', STR_PAD_LEFT);
                    $subApplication->registration_no = $runningNumber;
                    // $refNum = new ReferenceNumber();
                    // $subApplication->reference_number = $refNum->generateReferenceNumber($request->user()->id);
                    $appRunningNumber = new SerialNumber;
                    $appRunningNumber->application_id =  Auth::id();
                    $appRunningNumber->prefix = '';
                    $appRunningNumber->running_number = $runningNumberInt;
                    $appRunningNumber->suffix = '';
                    $appRunningNumber->created_by = Auth::id();
                    $appRunningNumber->updated_by = Auth::id();
                    $appRunningNumber->save();
                }
                $subApplication->sub_application_status = 'Permohonan Dihantar';

                //save in log audit status
                $subAuditLog = new SubsistenceAuditLogStatus;
                $subAuditLog->subsistence_application_id =  $subApplication->id;
                $subAuditLog->status = 'Permohonan Dihantar';
                $subAuditLog->remark = '-';
                $subAuditLog->created_by = Auth::user()->id;
                $subAuditLog->save();
            }
            else if ($request->input('action') === 'send_again'){
                $subApplication->sub_application_status = 'Permohonan Dihantar Semula';

                //save in log audit status
                $subAuditLog = new SubsistenceAuditLogStatus;
                $subAuditLog->subsistence_application_id =  $subApplication->id;
                $subAuditLog->status = 'Permohonan Dihantar Semula';
                $subAuditLog->remark = '-';
                $subAuditLog->created_by = Auth::user()->id;
                $subAuditLog->save();
            }
            else if ($request->input('action') === 'send_appeal'){
                $subApplication->sub_application_status = 'Permohonan Rayuan Dihantar';

                //save in log audit status
                $subAuditLog = new SubsistenceAuditLogStatus;
                $subAuditLog->id = Helper::uuid();
                $subAuditLog->subsistence_application_id =  $subApplication->id;
                $subAuditLog->status = 'Permohonan Rayuan Dihantar';
                $subAuditLog->remark = '-';
                $subAuditLog->created_by = Auth::user()->id;
                $subAuditLog->save();
            }
            $subApplication->updated_by = Auth::user()->id;

            $subApplication->save(); // This will insert a new record
            $audit_details = json_encode([
                'id' =>  $request->application_id,
                'is_declaration' =>   $subApplication->is_declaration,
                'sub_application_status' =>   $subApplication->sub_application_status,
            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Simpan Maklumat Pengisytiharan',  $audit_details);

            DB::commit();
            return redirect()->route('subsistence-allowance.application.index')->with('alert', 'Permohonan berjaya disimpan !!');
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([
                'id' =>  $request->application_id,
                'is_declaration' =>   $subApplication->is_declaration ,
                'sub_application_status' =>   $subApplication->sub_application_status,
            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Simpan Maklumat Pengisytiharan', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    public function updateform(Request $request)
    {
        // Retrieve all request data
        $data = $request->all();

        DB::beginTransaction();

        try {
            // Find existing subApplication or create a new one
            $subApplication = SubApplication::find($request->application_id) ?? new SubApplication;
            $isNew = !$subApplication->exists; // Check if it's a new record

            if ($isNew) {
                $subApplication->id = Helper::uuid();
                $subApplication->created_by = Auth::user()->id;
            }

            $subApplication->fullname = $data['fullname'];
            $subApplication->icno = $data['icno'];

            $subApplication->address1 = $data['address1'];
            $subApplication->address2 = $data['address2'];
            $subApplication->address3 = $data['address3'];
            $subApplication->postcode = $data['postcode'];
            $subApplication->district_id = $data['districtId'];
            $subApplication->state_id = $data['stateId'];
            $subApplication->contact_number = $data['phoneNo'];

            $subApplication->bank_id = $data['bank_id'];
            $subApplication->no_account = $data['no_account'];
            $subApplication->state_bank_id = $data['state_bank_id'];
            $subApplication->updated_by = Auth::user()->id;
            $subApplication->save();

            // Logging Audit
            $audit_details = json_encode([
                'id' => $subApplication->id,
                'fullname' => $data['fullname'],
                'icno' => $data['icno'],

                'address1' => $data['address1'],
                'address2' => $data['address2'],
                'address3' => $data['address3'],
                'postcode' => $data['postcode'],
                'district_id' => $data['districtId'],
                'state_id' => $data['stateId'],
                'contact_number' => $data['phoneNo'],

                'bank_id' => $data['bank_id'],
                'no_account' => $data['no_account'],
                'state_bank_id' => $data['state_bank_id'],
                // 'uploaded_at' => now()->toDateTimeString(),
            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', $isNew ? 'Simpan Maklumat Permohonan' : 'Kemas Kini Maklumat Permohonan', $audit_details);

            DB::commit();
            return redirect()->route('subsistence-allowance.application.formwork', $subApplication->id)->with('alert', 'Permohonan berjaya disimpan !!');
        } catch (Exception $e) {
            DB::rollback();

            // Logging Audit
            $audit_details = json_encode([
                'id' => $subApplication->id,
                'fullname' => $data['fullname'],
                'icno' => $data['icno'],

                'address1' => $data['address1'],
                'address2' => $data['address2'],
                'address3' => $data['address3'],
                'postcode' => $data['postcode'],
                'district_id' => $data['districtId'],
                'state_id' => $data['stateId'],
                'contact_number' => $data['phoneNo'],

                'bank_id' => $data['bank_id'],
                'no_account' => $data['no_account'],
                'state_bank_id' => $data['state_bank_id'],
                // 'uploaded_at' => now()->toDateTimeString(),
            ]);

            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Gagal Simpan Maklumat Permohonan', json_encode($data), $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function create()
    {
        $user = User::find(Auth::id());
        $userProfile = ProfileUser::where('user_id',Auth::id())->where('is_active',true)->first();
        //age from ic
        $ic_first_6_digit = substr($user->username, 0, 6);
        $date = Carbon::createFromFormat('ymd', $ic_first_6_digit);
        $age = $date->age;

        return view('app.subsistence_allowance.kru.create', [
            'states' => Helper::getCodeMastersByType('state'),
            'bank' => Helper::getCodeMastersByType('bank'),
            'userProfile' => $userProfile,
            'age' => $age,
		]);
    }

    public function formdetails_appeal()
    {
        $kru_jawatan_kru = CodeMaster::where('type','kru_jawatan')
        ->where('code','2')->get();

        return view('app.subsistence_allowance.kru.form_appeal', [
            'kru_jawatan' => Helper::getCodeMastersByTypeOrder('kru_jawatan'),
            'kru_jawatan_kru' => $kru_jawatan_kru,
            'states' => Helper::getCodeMastersByType('state'),
            'bank' => Helper::getCodeMastersByType('bank'),
		]);
    }

    public function formwork($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        $fishermanInfo = darat_user_fisherman_info::where('user_id', $subApplication->user_id)->first();

        return view('app.subsistence_allowance.kru.formwork', [
            'subApplication' => $subApplication,
            'fishermanInfo' => $fishermanInfo,
		]);
    }

    public function formdependent($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance.kru.formdependent', [
            'subApplication' => $subApplication,
		]);
    }

    public function formeducation($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance.kru.formeducation', [
             'subApplication' => $subApplication,
		]);
    }

    public function formdoc($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        $documentADK = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
        ->where('title','Keputusan AADK')->latest()->first();
        $documentKWSP = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
        ->where('title','Keputusan Surat KWSP')->latest()->first();
        $documentAkuan = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
        ->where('title','Akuan Sumpah')->latest()->first();

        return view('app.subsistence_allowance.kru.formdoc', [
             'subApplication' => $subApplication,
             'documentADK' => $documentADK,
             'documentKWSP' => $documentKWSP,
             'documentAkuan' => $documentAkuan,
		]);
    }

    public function formdeclaration($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance.kru.formdeclaration', [
           'subApplication' => $subApplication,
		]);
    }

    public function editformdetails($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();
        $userProfile = ProfileUser::where('user_id',Auth::id())->where('is_active',true)->first();
        //age from ic
        $ic_first_6_digit = substr($subApplication->icno, 0, 6);
        $date = Carbon::createFromFormat('ymd', $ic_first_6_digit);
        $age = $date->age;

        return view('app.subsistence_allowance.kru.editform', [
            'subApplication' => $subApplication,
            'bank' => Helper::getCodeMastersByType('bank'),
            'states' => Helper::getCodeMastersByType('state'),
            'userProfile' => $userProfile,
            'age' => $age,
		]);
    }

    public function downloadDoc($id)
    {
        // $doc = MortgageDocuments::find($id);

        $doc = SubsistenceDocuments::find($id);

        if (Storage::exists($doc->file_path)) {

            //Format - PDF
            if (Str::contains($doc->file_path, '.pdf')) {
                $headers = [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline',                 ];
            }
            // Format for JPG
            elseif (Str::contains($doc->file_path, '.jpg')) {
                $headers = [
                    'Content-Type' => 'image/jpeg',
                    'Content-Disposition' => 'inline',
                ];
            }
            // Format for PNG
            elseif (Str::contains($doc->file_path, '.png')) {
                $headers = [
                    'Content-Type' => 'image/png',
                    'Content-Disposition' => 'inline',
                ];
            } else {
                // Fallback format
                $headers = [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline',
                ];
            }

            // Display the file in the browser
            return response()->file(storage_path('app/' . $doc->file_path), $headers);
        }

        return redirect('/404');
    }

    public function downloadDocApp(Request $request, string $id)
    {
        //$request->user()->isAuthorize('export-user');

        // $auditLog = new AuditLog();
        // $auditLog->log('kru01CetakanKad', 'print', json_encode(['file_type' => 'PDF']));

        $application = SubApplication::find($id);
        // $data['appKru'] = $selectedKru;
        $data['app'] = $application;
        // $data['vessel'] = Vessel::find($data['app']->vessel_id);

        $pdf = Pdf::loadView('app.subsistence_allowance.applicationpdf', $data);
        $pdf->setPaper('A4', 'potrait');
        $pdf->getDomPDF()->set_option('enable_php', true);

        // View on page
        return $pdf->stream('kadpendaftarannelayan'.'_'.$data['app']->registration_no.'.pdf');
    }

    public function show($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        $docs = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)->get();

        return view('app.subsistence_allowance.kru.show', [
            'subApplication' => $subApplication,
            'bank' => Helper::getCodeMastersByType('bank'),
            'states' => Helper::getCodeMastersByType('state'),
            'docs' => $docs,
		]);
    }

    public function showformwork($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance.kru.showformwork', [
            'subApplication' => $subApplication,

		]);
    }

    public function showformdependent($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance.kru.showformdependent', [
            'subApplication' => $subApplication,
		]);
    }

    public function showformeducation($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance.kru.showformeducation', [
             'subApplication' => $subApplication,
		]);
    }

    public function showformdeclaration($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance.kru.showformdeclaration', [
           'subApplication' => $subApplication,
		]);
    }
}
