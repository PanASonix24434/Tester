<?php

namespace App\Http\Controllers\SubsistenceAllowanceRenewal;
use Illuminate\Http\Request;
use App\Models\SerialNumber;

use App\Http\Controllers\Controller;

use App\Models\SubsistenceAllowance\SubApplication;
use App\Models\SubsistenceAllowance\SubsistenceDocuments;
use App\Models\SubsistenceAllowance\SubsistenceAuditLogStatus;

use Auth;
use Audit;
use Hash;
use Exception;
use Carbon\Carbon;
use Storage;
use Module;
use Helper;
use DB;
use App\Models\CodeMaster;
use App\Models\User;

class SubAllowanceRenewalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function form(Request $request)
    {
        
        if(Auth::user()->name == 'Super Admin') {
			$subApplication = SubApplication::wherein('type_registration', ['Renew', 'Rayuan Pembaharuan'])->sortable();
            $subApplicationList = SubApplication::whereBetween('application_expired_date', [now(), now()->addMonths(3)])
            // ->where('type_registration', 'Renew')
            ->orderBy('application_expired_date', 'asc')
            ->first();

            $hasApplication = SubApplication::where('type_registration', 'Baru') // Semak jika pernah buat permohonan asal
                ->exists();

            $hasRenew = SubApplication::where('type_registration', 'Renew') // Semak jika sudah buat pembaharuan
                ->where('created_at', '>=', now()->subMonths(3))
                ->exists();

            $hasRejectedRenew = SubApplication::where('type_registration', 'Renew') // Mesti permohonan 'Renew'
            ->wherein('sub_application_status', ['Permohonan Ditolak Peringkat Negeri','Permohonan Tidak Diluluskan Peringkat HQ']) 
            ->exists();

            $hasAppeal = SubApplication::where('type_registration', 'Rayuan Pembaharuan') // Mesti jenis permohonan Rayuan
            ->exists();

            $hasRejectedAppeal = SubApplication::where('type_registration', 'Rayuan Pembaharuan')
            ->where('sub_application_status', 'Permohonan Tidak Diluluskan Peringkat HQ')
            ->exists();

             // Dapatkan Rayuan Pembaharuan terbaru user
            $latestAppeal = SubApplication::where('type_registration', 'Rayuan Pembaharuan')
            ->latest('created_at')
            ->first();

            // Semak jika ada Rayuan Pembaharuan (mana-mana status)
            $hasAppeal = !is_null($latestAppeal);

            // Semak jika rayuan terbaru user ditolak oleh HQ
            $hasRejectedLatestAppeal = optional($latestAppeal)->sub_application_status == 'Permohonan Tidak Diluluskan Peringkat HQ';

            // Semak jika rayuan terbaru user masih dalam proses (Permohonan Dihantar)
            $hasOngoingLatestAppeal = optional($latestAppeal)->sub_application_status == 'Permohonan Dihantar';



		} else {
            $subApplication = SubApplication::where('created_by', Auth::id())
            ->whereIn('type_registration', ['Renew', 'Rayuan Pembaharuan'])
            ->sortable();

        $subApplicationList = SubApplication::where('created_by', Auth::id())
            ->whereBetween('application_expired_date', [now(), now()->addMonths(3)])
            ->orderBy('application_expired_date', 'asc')
            ->first();

        // Semak jika user pernah buat permohonan asal (Baru)
        $hasApplication = SubApplication::where('created_by', Auth::id())
            ->where('type_registration', 'Baru')
            ->exists();

        // Semak jika user pernah buat permohonan pembaharuan dalam 3 bulan terakhir
        $hasRenew = SubApplication::where('created_by', Auth::id())
            ->where('type_registration', 'Renew')
            ->where('created_at', '>=', now()->subMonths(3))
            ->exists();

        // Semak jika pembaharuan telah ditolak
        $hasRejectedRenew = SubApplication::where('created_by', Auth::id())
            ->where('type_registration', 'Renew')
            ->whereIn('sub_application_status', ['Permohonan Ditolak Peringkat Negeri', 'Permohonan Tidak Diluluskan Peringkat HQ'])
            ->exists();

        // Dapatkan Rayuan Pembaharuan terbaru user
        $latestAppeal = SubApplication::where('created_by', Auth::id())
            ->where('type_registration', 'Rayuan Pembaharuan')
            ->latest('created_at')
            ->first();

        // Semak jika ada Rayuan Pembaharuan (mana-mana status)
        $hasAppeal = !is_null($latestAppeal);

        // Semak jika rayuan terbaru user ditolak oleh HQ
        $hasRejectedLatestAppeal = optional($latestAppeal)->sub_application_status == 'Permohonan Tidak Diluluskan Peringkat HQ';

        // Semak jika rayuan terbaru user masih dalam proses (Permohonan Dihantar)
        $hasOngoingLatestAppeal = optional($latestAppeal)->sub_application_status == 'Permohonan Dihantar';
                    


		}
        
        return view('app.subsistence_allowance_renewal.form', [		
            'subApplication' => $request->has('sort') ? $subApplication->paginate(10) : $subApplication->orderBy('created_at')->paginate(10), 
            'subApplicationList' => $subApplicationList, 
            'hasApplication' => $hasApplication,
            'hasRenew' => $hasRenew,
            'hasRejectedRenew' => $hasRejectedRenew,
            'hasAppeal' => $hasAppeal,
            'hasRejectedLatestAppeal' => $hasRejectedLatestAppeal,
            'hasOngoingLatestAppeal' => $hasOngoingLatestAppeal,
            'latestAppeal' => $latestAppeal,

        ]);
    }

    public function formdetails()
    {
        $kru_jawatan_kru = CodeMaster::where('type','kru_jawatan')
        ->where('code','2')->get();

        $previousApp = SubApplication::where('sub_application_status','Permohonan Diluluskan Peringkat HQ')->latest()->first();

        return view('app.subsistence_allowance_renewal.kru.form', [		
            'kru_jawatan' => Helper::getCodeMastersByTypeOrder('kru_jawatan'),
            'kru_jawatan_kru' => $kru_jawatan_kru,
            'states' => Helper::getCodeMastersByType('state'),
            'bank' => Helper::getCodeMastersByType('bank'),
            'previousApp' => $previousApp,
		]);
    }

    public function formdetails_appeal()
    {
        $kru_jawatan_kru = CodeMaster::where('type','kru_jawatan')
        ->where('code','2')->get();

        return view('app.subsistence_allowance_renewal.kru.form_appeal', [		
            'kru_jawatan' => Helper::getCodeMastersByTypeOrder('kru_jawatan'),
            'kru_jawatan_kru' => $kru_jawatan_kru,
            'states' => Helper::getCodeMastersByType('state'),
            'bank' => Helper::getCodeMastersByType('bank'),
		]);
    }

    public function formwork($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        $previousApp = SubApplication::where('sub_application_status','Permohonan Diluluskan Peringkat HQ')->latest()->first();

        return view('app.subsistence_allowance_renewal.kru.formwork', [		
            'subApplication' => $subApplication,	
            'previousApp' => $previousApp,

		]);
    }

    public function formdependent($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();
        $previousApp = SubApplication::where('sub_application_status','Permohonan Diluluskan Peringkat HQ')->latest()->first();

        return view('app.subsistence_allowance_renewal.kru.formdependent', [		
            'subApplication' => $subApplication,
            'previousApp' => $previousApp,
		]);
    }

    public function formeducation($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();
        $previousApp = SubApplication::where('sub_application_status','Permohonan Diluluskan Peringkat HQ')->latest()->first();

        return view('app.subsistence_allowance_renewal.kru.formeducation', [		
             'subApplication' => $subApplication,
             'previousApp' => $previousApp,
		]);
    }

    public function formdoc($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        $documentADK = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
        ->where('title','Keputusan AADK')->latest()->first();

        
        $documentKWSP = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
        ->where('title','Keputusan Surat KWSP')->latest()->first();

         
        $documentSupport = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
        ->where('title','Surat Sokongan')->latest()->first();

        $documentBank = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
        ->where('title','Salinan Penyata Bank')->latest()->first();
        
        $documentAkuan = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
        ->where('title','Akuan Sumpah')->latest()->first();

        return view('app.subsistence_allowance_renewal.kru.formdoc', [		
             'subApplication' => $subApplication,
             'documentADK' => $documentADK,
             'documentKWSP' => $documentKWSP,
             'documentSupport' => $documentSupport,
             'documentBank' => $documentBank,
             'documentAkuan' => $documentAkuan,
		]);
    }

    public function formdeclaration($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance_renewal.kru.formdeclaration', [		
           'subApplication' => $subApplication,
		]);
    }

    public function editformdetails($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();


        return view('app.subsistence_allowance_renewal.kru.editform', [		
            'subApplication' => $subApplication,
            'bank' => Helper::getCodeMastersByType('bank'),
            'states' => Helper::getCodeMastersByType('state'),
		]);
    }


   

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
                'bank_id' => $data['bank_id'],
                'no_account' => $data['no_account'],
                'state_bank_id' => $data['state_bank_id'],
                'uploaded_at' => now()->toDateTimeString(),
            ]);
    
            Audit::log('Permohonan Pembaharuan ESH Nelayan', $isNew ? 'Simpan Maklumat Permohonan' : 'Kemas Kini Maklumat Permohonan', $audit_details);
    
            DB::commit();
    
            return redirect()->action('SubsistenceAllowanceRenewal\SubAllowanceRenewalController@formwork', $subApplication->id)
                ->with('alert', 'Permohonan berjaya ' . ($isNew ? 'disimpan' : 'dikemaskini') . ' !!');
        } catch (Exception $e) {
            DB::rollback();
    
            Audit::log('Permohonan  Pembaharuan ESH Nelayan', 'Gagal Simpan Maklumat Permohonan', json_encode($data), $e->getMessage());
    
            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
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

    public function store(Request $request)
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
            $subApplication->type_registration = 'Renew';
            
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

        
            $audit_details = json_encode([ 
                'id' =>  $subApplication->id,   	
                'fullname' => $data['fullname'],  			
                'icno' => $data['icno'],
                'bank_id' => $data['bank_id'],
                'no_account' => $data['no_account'], 
                'state_bank_id' => $data['state_bank_id'],
            ]);		
        
            Audit::log('Permohonan Pembaharuan ESH Nelayan', 'Simpan Maklumat',  $audit_details);
        
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

            ]);	
        
            Audit::log('Permohonan Elaun Sara Diri Nelayan', 'Simpan Maklumat Permohonan', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
            }


            return redirect()->action('SubsistenceAllowanceRenewal\SubAllowanceRenewalController@formwork', $subApplication->id)->with('alert', 'Permohonan berjaya disimpan !!');
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
            $subApplication->type_registration = 'Rayuan Pembaharuan';
            
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

           
        
            $audit_details = json_encode([ 
                'id' =>  $subApplication->id,   	
                'fullname' => $data['fullname'],  			
                'icno' => $data['icno'],
                'bank_id' => $data['bank_id'],
                'no_account' => $data['no_account'], 
                'state_bank_id' => $data['state_bank_id'],

            ]);		
        
            Audit::log('Permohonan Rayuan Pembaharuan ESH Nelayan', 'Simpan Maklumat Permohonan',  $audit_details);
        
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

               
            ]);	
        
            Audit::log('Permohonan Rayuan Pembaharuan ESH Nelayan', 'Simpan Maklumat Permohonan', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
            }


            return redirect()->action('SubsistenceAllowanceRenewal\SubAllowanceRenewalController@formwork', $subApplication->id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

   


    public function storeWork(Request $request)
    {
        // Retrieve all request data
        $data = $request->all();


        DB::beginTransaction();

        try {
          
            // Find existing record by application_id
            $subApplication= SubApplication::where('id',  $request->application_id)->first();
            
           
            $subApplication->tot_incomefish = $data['fishing_income'];
            $subApplication->tot_incomeother = $data['other_income'];
            $subApplication->tot_allincome = $data['total_income'];
            $subApplication->updated_by = Auth::user()->id;
        
            $subApplication->save(); // This will insert a new record

            
        
            $audit_details = json_encode([ 
                'id' =>  $request->application_id,   	
                'tot_incomefish' => $data['fishing_income'],  			
                'tot_incomeother' => $data['other_income'],
                'tot_allincome' => $data['total_income'],
               

            ]);		
        
            Audit::log('Permohonan Pembaharuan ESH Nelayan', 'Simpan Maklumat Pekerjaan',  $audit_details);
        
            DB::commit();
        } 
        catch (Exception $e) {
            DB::rollback();
        
            $audit_details = json_encode([ 
                'id' =>  $request->application_id,   	
                'tot_incomefish' => $data['fishing_income'],  			
                'tot_incomeother' => $data['other_income'],
                'tot_allincome' => $data['total_income'],

            ]);	
        
            Audit::log('Permohonan Pembaharuan ESH Nelayan', 'Simpan Maklumat Pekerjaan', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
            }


            return redirect()->action('SubsistenceAllowanceRenewal\SubAllowanceRenewalController@formdependent', $request->application_id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    public function storeDependent(Request $request)
    {
        // Retrieve all request data
        $data = $request->all();


        DB::beginTransaction();

        try {
          
            // Find existing record by application_id
            $subApplication= SubApplication::where('id',  $request->application_id)->first();
            
           
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
        
            Audit::log('Permohonan Pembaharuan ESH Nelayan', 'Simpan Maklumat Tanggungan',  $audit_details);
        
            DB::commit();
        } 
        catch (Exception $e) {
            DB::rollback();
        
            $audit_details = json_encode([ 
                'id' =>  $request->application_id,   	
                'tot_child' => $data['tot_child'],  			
                'tot_otherchild' => $data['child_other'],
                'tot_allchild' => $data['total_allchild'],

            ]);	
        
            Audit::log('Permohonan Pembaharuan ESH Nelayan', 'Simpan Maklumat Tanggungan', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
            }


            return redirect()->action('SubsistenceAllowanceRenewal\SubAllowanceRenewalController@formeducation', $request->application_id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    public function storeEducation(Request $request)
    {
        // Retrieve all request data
        $data = $request->all();


        DB::beginTransaction();

        try {
          
            // Find existing record by application_id
            $subApplication= SubApplication::where('id',  $request->application_id)->first();
            
           
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
        
            Audit::log('Permohonan Pembaharuan ESH Nelayan', 'Simpan Maklumat Pendidikan',  $audit_details);
        
            DB::commit();
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
        
            Audit::log('Permohonan Pembaharuan ESH Nelayan', 'Simpan Maklumat Pendidikan', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
            }


            return redirect()->action('SubsistenceAllowanceRenewal\SubAllowanceRenewalController@formdoc', $request->application_id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    public function storeDoc(Request $request)
    {
        // Retrieve all request data
        $data = $request->all();


        DB::beginTransaction();

        try {

            $subApplication = SubApplication::find($request->application_id);
          

        if ($request->hasFile('fileResult')) { 

            $file = $request->file('fileResult');
            $filename = str_replace(' ', '', $file->getClientOriginalName());
            $path2 = $file->store('public/PermohonanElaunSara/KWSP');
        
            // Find the existing document
            $subDocument = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
                ->where('title', 'Keputusan Surat KWSP')
                ->first();
        
            if ($subDocument) {
                // Delete old file if it exists
                if (Storage::exists($subDocument->file_path)) {
                    Storage::delete($subDocument->file_path);
                }
        
                // Update only this document
                $subDocument->update([
                    'file_path' => $path2,
                    'file_detail' => $filename,
                    'updated_by' => Auth::user()->id,
                ]);
            } else {
                // Jika dokumen tiada, simpan dokumen baru
                
                $subDocument = new SubsistenceDocuments;
    
                $subDocument->subsistence_application_id =  $subApplication->id;
                $subDocument->title = 'Keputusan Surat KWSP'; 
                $subDocument->file_path =  $path2;
                $subDocument->file_detail = $filename;
                $subDocument->created_by = Auth::user()->id;
                $subDocument->updated_by = Auth::user()->id;
    
                $subDocument->save();
            }  
        }


        if ($request->hasFile('fileAADK')) { 

            $file = $request->file('fileAADK');
            $filename = str_replace(' ', '', $file->getClientOriginalName());
            $path2 = $file->store('public/PermohonanElaunSara/AADK');
        
            // Cari dokumen sedia ada
            $subDocument = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
                ->where('title', 'Keputusan AADK')
                ->first();
        
            if ($subDocument) {
                // Jika dokumen wujud, padam fail lama dan update
                if (Storage::exists($subDocument->file_path)) {
                    Storage::delete($subDocument->file_path);
                }
        
                $subDocument->update([
                    'file_path' => $path2,
                    'file_detail' => $filename,
                    'updated_by' => Auth::user()->id,
                ]);
            } else {
                // Jika dokumen tiada, simpan dokumen baru
                
                $subDocument = new SubsistenceDocuments;
    
                $subDocument->subsistence_application_id =  $subApplication->id;
                $subDocument->title = 'Keputusan AADK'; 
                $subDocument->file_path =  $path2;
                $subDocument->file_detail = $filename;
                $subDocument->created_by = Auth::user()->id;
                $subDocument->updated_by = Auth::user()->id;
    
                $subDocument->save();
            }
        }
        

        

        if ($request->hasFile('fileSupport')) { 

            $file = $request->file('fileSupport');
            $filename = str_replace(' ', '', $file->getClientOriginalName());
            $path2 = $file->store('public/PermohonanElaunSara/Sokongan');
        
            // Find the existing document
            $subDocument = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
                ->where('title', 'Surat Sokongan')
                ->first();
        
            if ($subDocument) {
                // Delete old file if it exists
                if (Storage::exists($subDocument->file_path)) {
                    Storage::delete($subDocument->file_path);
                }
        
                // Update only this document
                $subDocument->update([
                    'file_path' => $path2,
                    'file_detail' => $filename,
                    'updated_by' => Auth::user()->id,
                ]);
            } else {
                // Jika dokumen tiada, simpan dokumen baru
                
                $subDocument = new SubsistenceDocuments;
    
                $subDocument->subsistence_application_id =  $subApplication->id;
                $subDocument->title = 'Surat Sokongan'; 
                $subDocument->file_path =  $path2;
                $subDocument->file_detail = $filename;
                $subDocument->created_by = Auth::user()->id;
                $subDocument->updated_by = Auth::user()->id;
    
                $subDocument->save();
            }
        }


        if ($request->hasFile('fileBank')) { 

            $file = $request->file('fileBank');
            $filename = str_replace(' ', '', $file->getClientOriginalName());
            $path2 = $file->store('public/PermohonanElaunSara/PenyataBank');
        
            // Find the existing document
            $subDocument = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
                ->where('title', 'Salinan Penyata Bank')
                ->first();
        
            if ($subDocument) {
                // Delete old file if it exists
                if (Storage::exists($subDocument->file_path)) {
                    Storage::delete($subDocument->file_path);
                }
        
                // Update only this document
                $subDocument->update([
                    'file_path' => $path2,
                    'file_detail' => $filename,
                    'updated_by' => Auth::user()->id,
                ]);
            } else {
                // Jika dokumen tiada, simpan dokumen baru
                
                $subDocument = new SubsistenceDocuments;
    
                $subDocument->subsistence_application_id =  $subApplication->id;
                $subDocument->title = 'Salinan Penyata Bank'; 
                $subDocument->file_path =  $path2;
                $subDocument->file_detail = $filename;
                $subDocument->created_by = Auth::user()->id;
                $subDocument->updated_by = Auth::user()->id;
    
                $subDocument->save();
            } 
        }

        //Save Dokumen
        if($request->hasFile('fileAkuan')){ 

            $file = $request->file('fileAkuan');
            $file_replace = str_replace(' ', '', $file->getClientOriginalName());
            $filename = $file_replace;				
            $path1 = $request->file('fileAkuan')->store('public/PermohonanElaunSara/AkuanSumpah');
        
            // Find the existing document
            $subDocument = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
                ->where('title', 'Akuan Sumpah')
                ->first();
                
            if ($subDocument) {
                // Delete old file if it exists
                if (Storage::exists($subDocument->file_path)) {
                    Storage::delete($subDocument->file_path);
                }
        
                // Update only this document
                $subDocument->update([
                    'file_path' => $path1,
                    'file_detail' => $filename,
                    'updated_by' => Auth::user()->id,
                ]);
            } else {

                $subDocument = new SubsistenceDocuments;

                $subDocument->subsistence_application_id =  $subApplication->id;
                $subDocument->title = 'Akuan Sumpah'; 
                $subDocument->file_path =  $path1;
                $subDocument->file_detail = $filename;
                $subDocument->created_by = Auth::user()->id;
                $subDocument->updated_by = Auth::user()->id;

                $subDocument->save();
            }
            
        }
        
    

            $audit_details = json_encode([ 
                'id' =>  $request->application_id,   	
                
                 // First Document Upload
                 'document1_name' => 'Keputusan AADK',
                 'document1_path' =>'public/PermohonanElaunSara/AADK',
 
                 // Second Document Upload
                 'document2_name' =>'Keputusan Surat KWSP',
                 'document2_path' =>'public/PermohonanElaunSara/KWSP',

                 // Third Document Upload
                 'document3_name' =>'Surat Sokongan',
                 'document3_path' =>'public/PermohonanElaunSara/Sokongan',

                 // Four Document Upload
                 'document4_name' =>'Salinan Penyata Bank',
                 'document4_path' =>'public/PermohonanElaunSara/PenyataBank',
 
                 'uploaded_at' => now()->toDateTimeString(),
               

            ]);		
        
            Audit::log('Permohonan Pembaharuan ESH Nelayan', 'Simpan Maklumat Dokumen',  $audit_details);
        
            DB::commit();
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

                 // Third Document Upload
                 'document3_name' =>'Surat Sokongan',
                 'document3_path' =>'public/PermohonanElaunSara/Sokongan',

                 // Four Document Upload
                 'document4_name' =>'Salinan Penyata Bank',
                 'document4_path' =>'public/PermohonanElaunSara/PenyataBank',
 
                 'uploaded_at' => now()->toDateTimeString(),

            ]);	
        
            Audit::log('Permohonan Pembaharuan ESH Nelayan', 'Simpan Maklumat Dokumen', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
            }


            return redirect()->action('SubsistenceAllowanceRenewal\SubAllowanceRenewalController@formdeclaration', $request->application_id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    public function storeDeclaration(Request $request)
    {
        // Retrieve all request data
        $data = $request->all();


        DB::beginTransaction();

        try {
          
            // Find existing record by application_id
            $subApplication= SubApplication::where('id',  $request->application_id)->first();
            
            if($request->confirmation == "Setuju"){
                $subApplication->declaration = 1;
            }
            else if($request->confirmation == "Tidak Setuju"){
                $subApplication->declaration= 0;
            }

            if ($request->input('action') === 'save') {
                $subApplication->sub_application_status = 'Permohonan Disimpan';
            }
                
            else if ($request->input('action') === 'send'){
                $user = User::find(Auth::user()->id);
                $subApplication->entity_id = $user->entity_id;
                $subApplication->sub_application_status = 'Permohonan Dihantar';

                //save in log audit status
                $subAuditLog = new SubsistenceAuditLogStatus;
                $subAuditLog->id = Helper::uuid();
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
                $subAuditLog->id = Helper::uuid();
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
        
            Audit::log('Permohonan embaharuan ESH  Nelayan', 'Simpan Maklumat Pengisytiharan',  $audit_details);
        
            DB::commit();
        } 
        catch (Exception $e) {
            DB::rollback();
        
            $audit_details = json_encode([ 
                'id' =>  $request->application_id,   	
                'is_declaration' =>   $subApplication->is_declaration ,  
                'sub_application_status' =>   $subApplication->sub_application_status, 

            ]);	
        
            Audit::log('Permohonan Pembaharuan ESH Nelayan', 'Simpan Maklumat Pengisytiharan', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
            }


            return redirect()->action('SubsistenceAllowanceRenewal\SubAllowanceRenewalController@form', $request->application_id)->with('alert', 'Permohonan berjaya disimpan !!');
    }


    public function showformdetails($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();


        return view('app.subsistence_allowance_renewal.kru.showform', [		
            'subApplication' => $subApplication,
            'bank' => Helper::getCodeMastersByType('bank'),
            'states' => Helper::getCodeMastersByType('state'),
           
		]);
    }

    public function showformwork($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance_renewal.kru.showformwork', [		
            'subApplication' => $subApplication,

		]);
    }

    public function showformdependent($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance_renewal.kru.showformdependent', [		
            'subApplication' => $subApplication,
		]);
    }

    public function showformeducation($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance_renewal.kru.showformeducation', [		
             'subApplication' => $subApplication,
		]);
    }

    public function showformdoc($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        $documentADK = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
        ->where('title','Keputusan AADK')->latest()->first();

        
        $documentKWSP = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
        ->where('title','Keputusan Surat KWSP')->latest()->first();

         
        $documentSupport = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
        ->where('title','Surat Sokongan')->latest()->first();

        $documentBank = SubsistenceDocuments::where('subsistence_application_id', $subApplication->id)
        ->where('title','Salinan Penyata Bank')->latest()->first();

        return view('app.subsistence_allowance_renewal.kru.showformdoc', [		
             'subApplication' => $subApplication,
              'documentADK' => $documentADK,
             'documentKWSP' => $documentKWSP,
             'documentSupport' => $documentSupport,
             'documentBank' => $documentBank,
		]);
    }

    public function showformdeclaration($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance_renewal.kru.showformdeclaration', [		
           'subApplication' => $subApplication,
		]);
    }

    

  
    
}




    

  
    

