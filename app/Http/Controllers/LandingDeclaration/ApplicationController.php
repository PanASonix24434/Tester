<?php

namespace App\Http\Controllers\LandingDeclaration;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\darat_application;
use App\Models\darat_user_equipment;
use App\Models\Helper;
use App\Models\LandingDeclaration\LandingActivitySpecies;
use App\Models\LandingDeclaration\LandingActivityType;
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingDeclarationMonthly;
use App\Models\LandingDeclaration\LandingDeclareMonthlyLog;
use App\Models\LandingDeclaration\LandingDocument;
use App\Models\LandingDeclaration\LandingInfo;
use App\Models\LandingDeclaration\LandingInfoActivity;
use App\Models\LandingDeclaration\LandingMonthlyDocument;
use App\Models\LandingDeclaration\LandingWaterType;
use App\Models\Species;
use App\Models\Systems\AuditLog;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $helper = new Helper();
        $app = LandingDeclarationMonthly::where('user_id',Auth::id())
        ->orderBy('year','desc')
        ->orderBy('month','desc');

        $permohonanPendaftaranKadNelayanDaratId = $helper->getCodeMasterIdByTypeName('application_type','PERMOHONAN PENDAFTARAN KAD NELAYAN DARAT');
        $hasApprovedKadPendaftaranNelayan = darat_application::where('user_id',Auth::id())->where('application_type_id',$permohonanPendaftaranKadNelayanDaratId)->where('application_type_id',$permohonanPendaftaranKadNelayanDaratId)->where('is_approved',true)->exists();
        
        return view('app.landing_declaration.application.index', [
            'app' => $app->paginate(10),
            'disimpanId' => $helper->getCodeMasterIdByTypeName('landing_status','DISIMPAN'),
            'tidakLengkapId' => $helper->getCodeMasterIdByTypeName('landing_status','TIDAK LENGKAP'),
            'hasApprovedKadPendaftaranNelayan' => !$hasApprovedKadPendaftaranNelayan,
        ]);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function create()
    {
        $backdatedAmount = 3; //only allow to fill in current month and the previous month
        $months = collect(); //empty collection

        $carbon = Carbon::now();
        for($i=0 ; $i<=$backdatedAmount ; $i++){
            $monthTxt = Carbon::create($carbon->year, $carbon->month, 1)->isoFormat('MMMM');
            //check if not exist
            if(!LandingDeclarationMonthly::where('user_id',Auth::id())->where('year',$carbon->year)->where('month',$carbon->month)->exists()){
                $months->push((object)['year'=>$carbon->year,'month'=>$carbon->month,'monthTxt'=>$monthTxt,'available'=>true]);
            }
            else{
                $months->push((object)['year'=>$carbon->year,'month'=>$carbon->month,'monthTxt'=>$monthTxt,'available'=>false]);
            }
            $carbon->subMonth();
        }

        return view('app.landing_declaration.application.create', [
            'months' => $months,
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
        DB::beginTransaction();

        try {
            $helper = new Helper();
            $statusDisimpanId = $helper->getCodeMasterIdByTypeName('landing_status','DISIMPAN');

            //check if already exists
            if(LandingDeclarationMonthly::where('user_id',Auth::id())->where('year',$request->year)->where('month',$request->selMonth)->exists()){
                return redirect()->back()->with('alert', 'Bulan tersebut telah dipilih !!');
            }

            $monthDeclare = new LandingDeclarationMonthly();
            $monthDeclare->user_id = Auth::user()->id;
            $monthDeclare->year = $request->year;
            $monthDeclare->month = $request->selMonth;
            
            $monthDeclare->created_by = Auth::user()->id;
            $monthDeclare->updated_by = Auth::user()->id;
            $monthDeclare->landing_status_id = $statusDisimpanId;
            $monthDeclare->save();


            $noOfWeeks = LandingDeclarationMonthly::getNumberOfWeekInMonth($request->year,$request->selMonth);
            $daysInMonth = Carbon::create($request->year, $request->selMonth)->daysInMonth;

            for($weekCount=0; $weekCount<$noOfWeeks; $weekCount++){
                $startDay = 1 + $weekCount * 7;
                $endDay = 7 + $weekCount * 7;

                $app2 = new LandingDeclaration();
                $app2->user_id = Auth::user()->id;
                $app2->landing_declare_monthly_id = $monthDeclare->id;
                $app2->year = $request->year;
                $app2->month = $request->selMonth;
                $app2->week = $weekCount+1;
                $app2->startDay = $startDay;
                $app2->endDay = $endDay > $daysInMonth ? $daysInMonth : $endDay;
                $app2->created_by = Auth::user()->id;
                $app2->updated_by = Auth::user()->id;
                // $app2->landing_status_id = $statusDisimpanId;
                $app2->save();

                for ($day=$app2->startDay; $day <= $app2->endDay; $day++) {
                    $landing = new LandingInfo();
                    $landing->landing_declaration_id = $app2->id;
                    $landing->landing_date = Carbon::create($request->year, $request->selMonth, $day);
                    $landing->updated_by = Auth::user()->id;
                    $landing->created_by = Auth::user()->id;
                    $landing->save();
                }
            }
            
            $audit_details = json_encode([ 
                'id' =>  $monthDeclare->id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'store',  $audit_details);
        
            DB::commit();
            return redirect()->route('landingdeclaration.application.edit',$monthDeclare->id)->with('alert', 'Permohonan berjaya disimpan !!');
        } 
        catch (Exception $e) {
            DB::rollback();
        
            $audit_details = json_encode([
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'store', $audit_details, $e->getMessage());
    
            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $app = LandingDeclarationMonthly::leftJoin('users','user_id','users.id')
        ->select('landing_declaration_monthlies.*','users.name','users.username')->find($id);

        $weeks = LandingDeclaration::where('landing_declare_monthly_id',$id)->orderBy('week','asc')->get();

        return view('app.landing_declaration.application.edit', [
            'app' => $app,
            'weeks' => $weeks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editD($id)
    {
        $helper = new Helper();
        $app = LandingDeclarationMonthly::find($id);
        $docSalesReceipt = LandingMonthlyDocument::where('landing_declare_monthly_id',$id)->where('description',LandingDocument::DOC_SALES_RECEIPT)->first();
        $docReason = LandingMonthlyDocument::where('landing_declare_monthly_id',$id)->where('description',LandingDocument::DOC_REASON)->first();
        return view('app.landing_declaration.application.editD', [
            'app' => $app,
            'docSalesReceipt' => $docSalesReceipt,
            'docReason' => $docReason,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editF($id)
    {
        $helper = new Helper();
        $app = LandingDeclarationMonthly::find($id);
        return view('app.landing_declaration.application.editF', [
            'app' => $app,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateD(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $helper = new Helper();
            $app = LandingDeclarationMonthly::find($id);
            $app->updated_by = Auth::user()->id;
            $app->save();

            if ($request->file('salesReceipt')) {

                $file = $request->file('salesReceipt');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('salesReceipt')->store('public/landing/landingdoc');

                $doc = new LandingMonthlyDocument();
                $doc->landing_declare_monthly_id = $app->id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = LandingMonthlyDocument::DOC_SALES_RECEIPT;
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }
            if ($request->file('kruPic')) {

                $file = $request->file('kruPic');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('kruPic')->store('public/landing/landingdoc');

                $doc = new LandingMonthlyDocument();
                $doc->landing_declare_monthly_id = $app->id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = LandingMonthlyDocument::DOC_REASON;
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }
        
            $audit_details = json_encode([ 
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'updateD',  $audit_details);
        
            DB::commit();
            return redirect()->route('landingdeclaration.application.editF',$app->id)->with('alert', 'Permohonan berjaya disimpan !!');
        } 
        catch (Exception $e) {
            DB::rollback();
        
            $audit_details = json_encode([
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'updateD', $audit_details, $e->getMessage());
    
            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateF(Request $request, string $id)
    {
        $app = LandingDeclarationMonthly::find($id);
        $weeks = LandingDeclaration::where('landing_declare_monthly_id',$id)->orderBy('week','asc')->get();
        $allWeekSubmitted = true;
        foreach ($weeks as $week) {
            if($week->landing_status_id == null){
                $allWeekSubmitted = false;
            }
        }
        if(!$allWeekSubmitted){
            return redirect()->back()->with('alert', 'Semua minggu perlu lengkap diisi sebelum menghantar permohonan!!');
        }

        DB::beginTransaction();

        try {
            $user = User::find(Auth::user()->id);

            $helper = new Helper();
            $statusDihantarId = $helper->getCodeMasterIdByTypeName('landing_status','DIHANTAR');

            $app = LandingDeclarationMonthly::find($id);
            if($app->submitted_at == null)
                $app->submitted_at = Carbon::now()->toDateTimeString();
            $app->entity_id = $user->entity_id;
            $app->landing_status_id = $statusDihantarId;
            $app->updated_by = Auth::user()->id;
            $app->save();
            
            $appLog = new LandingDeclareMonthlyLog();
            $appLog->landing_declare_monthly_id =  $id;
            $appLog->landing_status_id = $statusDihantarId;
            $appLog->remark	= 'Pemohon';
            $appLog->created_by = Auth::id();
            $appLog->updated_by = Auth::id();
            $appLog->save();
        
            $audit_details = json_encode([ 
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'updateE',  $audit_details);
        
            DB::commit();
            return redirect()->route('landingdeclaration.application.index')->with('alert', 'Permohonan berjaya dihantar !!');
        } 
        catch (Exception $e) {
            DB::rollback();
        
            $audit_details = json_encode([
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'updateE', $audit_details, $e->getMessage());
    
            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    //////////////////////////////week////////////////////////////////
    
    /**
     * Show the form for editing the specified resource.
     */
    public function editWeek($id)
    {
        $app = LandingDeclaration::find($id);
        $landingInfos = LandingInfo::where('landing_declaration_id',$id)->orderBy('landing_date')->get();
        return view('app.landing_declaration.application.editWeek', [
            'app' => $app,
            'landingInfos' => $landingInfos,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editWeekAddActivity($id)
    {
        $helper = new Helper();
        $landingInfo = LandingInfo::find($id);
        // $landingInfo = LandingInfo::find($id);
        return view('app.landing_declaration.application.editWeekAddActivity', [
            'landingInfo' => $landingInfo,
            'activityTypes' => LandingActivityType::orderBy('order')->get(),
            'equipments' => darat_user_equipment::where('user_id',Auth::id())->where('is_active',true)->get(),
            'states' => $helper->getCodeMastersByType('state'),
            'districts' => $helper->getCodeMastersByType('district'),
            'waterTypes' => LandingWaterType::orderBy('order')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editWeekEditActivity($id)
    {
        $helper = new Helper();
        $landingInfoActivity = LandingInfoActivity::find($id);
        $landingInfo = LandingInfo::find($landingInfoActivity->landing_info_id);
        return view('app.landing_declaration.application.editWeekEditActivity', [
            'landingInfoActivity' => $landingInfoActivity,
            'landingInfo' => $landingInfo,
            
            'activityTypes' => LandingActivityType::orderBy('order')->get(),
            'equipments' => darat_user_equipment::where('user_id',Auth::id())->where('is_active',true)->get(),
            'states' => $helper->getCodeMastersByType('state'),
            'districts' => CodeMaster::where('parent_id',$landingInfoActivity->state_id)->orderBy('name')->get(),
            'waterTypes' => LandingWaterType::orderBy('order')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editWeekB($id)
    {
        $helper = new Helper();
        $app = LandingDeclaration::find($id);
        $landingInfos = LandingInfo::where('landing_declaration_id',$id)->orderBy('landing_date')->get();
        return view('app.landing_declaration.application.editWeekB', [
            'app' => $app,
            'landingInfos' => $landingInfos,
            'landingActivityIds' => LandingActivityType::where('has_landing',true)->select('id')->get()->pluck('id')->toArray(),
        ]);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function editWeekBAddSpecies($id)
    {
        // $helper = new Helper();
        $landingInfoActivity = LandingInfoActivity::find($id);
        $landingInfo = LandingInfo::find($landingInfoActivity->landing_info_id);
        $selectedSpecies = LandingActivitySpecies::where('landing_info_activity_id',$id)->get()->pluck('species_id')->toArray();
        return view('app.landing_declaration.application.editWeekBAddSpecies', [
            'landingInfoActivity' => $landingInfoActivity,
            'landingInfo' => $landingInfo,
            
            'species' => Species::whereNotIn('id',$selectedSpecies)->orderBy('common_name')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editWeekBEditSpecies($id)
    {
        // $helper = new Helper();
        $landingSpecies = LandingActivitySpecies::find($id);
        $landingInfoActivity = LandingInfoActivity::find($landingSpecies->landing_info_activity_id);
        $landingInfo = LandingInfo::find($landingInfoActivity->landing_info_id);
        $selectedSpecies = LandingActivitySpecies::where('landing_info_activity_id',$landingInfoActivity->id)->whereNot('id',$id)->get()->pluck('species_id')->toArray(); // other than the current one
        return view('app.landing_declaration.application.editWeekBEditSpecies', [
            'landingSpecies' => $landingSpecies,
            'landingInfo' => $landingInfo,
            
            'species' => Species::whereNotIn('id',$selectedSpecies)->orderBy('common_name')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editWeekC($id)
    {
        $helper = new Helper();
        $app = LandingDeclaration::find($id);
        $landingInfos = LandingInfo::where('landing_declaration_id',$id)->orderBy('landing_date')->get();
        return view('app.landing_declaration.application.editWeekC', [
            'app' => $app,
            'landingInfos' => $landingInfos,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateWeekAdd(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $landing = LandingInfo::find($id);

            $landingActivity = new LandingInfoActivity();
            $landingActivity->landing_info_id = $id;
            $landingActivity->landing_activity_type_id = $request->selActivity;
            $landingActivity->time = $request->time;
            $landingActivity->equipment = strtoupper($request->selEquipment);
            $landingActivity->state_id = $request->selState;
            $landingActivity->district_id  = $request->selDistrict;
            $landingActivity->landing_water_type_id  = $request->selWaterType;
            $landingActivity->location_name  = strtoupper( trim($request->location) );
            $landingActivity->created_by = Auth::user()->id;
            $landingActivity->updated_by = Auth::user()->id;
            $landingActivity->save();
        
            $audit_details = json_encode([ 
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'updateBAdd',  $audit_details);
        
            DB::commit();
            return redirect()->route('landingdeclaration.application.editWeek',$landing->landing_declaration_id)->with('alert', 'Permohonan berjaya disimpan !!');
        } 
        catch (Exception $e) {
            DB::rollback();
        
            $audit_details = json_encode([
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'updateBAdd', $audit_details, $e->getMessage());
    
            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateWeekEditActivity(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $landingActivity = LandingInfoActivity::find($id);
            $landingActivity->landing_activity_type_id = $request->selActivity;
            $landingActivity->time = $request->time;
            $landingActivity->equipment = $request->selEquipment;
            $landingActivity->state_id = $request->selState;
            $landingActivity->district_id  = $request->selDistrict;
            $landingActivity->landing_water_type_id  = $request->selWaterType;
            $landingActivity->location_name  = $request->location;
            $landingActivity->updated_by = Auth::user()->id;
            $landingActivity->save();
            
            $landing = LandingInfo::find($landingActivity->landing_info_id);
        
            $audit_details = json_encode([ 
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'updateBEditActivity',  $audit_details);
        
            DB::commit();
            return redirect()->route('landingdeclaration.application.editWeek',$landing->landing_declaration_id)->with('alert', 'Permohonan berjaya disimpan !!');
        } 
        catch (Exception $e) {
            DB::rollback();
        
            $audit_details = json_encode([
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'updateBEditActivity', $audit_details, $e->getMessage());
    
            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }
    
    public function deleteActivity(Request $request, string $id)
    {
        DB::beginTransaction();

        try 
        {
            //Update status in table applications
            $appKru = LandingInfoActivity::find($id);
            $appKru->deleted_by = $request->user()->id;
			$appKru->save();
			$appKru->delete();

            DB::commit();

            return redirect()->back()->with('alert', 'Aktiviti berjaya dipadam !!');
        }
        catch (Exception $e) {

            DB::rollback();
            return redirect()->back()->with('alert', 'Aktiviti berjaya dipadam !!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateWeekBAdd(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $landingActivity = LandingInfoActivity::find($id);

            $landingSpecies = new LandingActivitySpecies();
            $landingSpecies->landing_info_activity_id = $id;
            $landingSpecies->species_id  = $request->selSpecies;
            $landingSpecies->weight  = $request->weight;
            $landingSpecies->price_per_weight  = $request->price;
            $landingSpecies->created_by = Auth::user()->id;
            $landingSpecies->updated_by = Auth::user()->id;
            $landingSpecies->save();
            
            $landing = LandingInfo::find($landingActivity->landing_info_id);
        
            $audit_details = json_encode([ 
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'updateCAdd',  $audit_details);
        
            DB::commit();
            return redirect()->route('landingdeclaration.application.editWeekB',$landing->landing_declaration_id)->with('alert', 'Permohonan berjaya disimpan !!');
        } 
        catch (Exception $e) {
            DB::rollback();
        
            $audit_details = json_encode([
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'updateCAdd', $audit_details, $e->getMessage());
    
            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateWeekBEditSpecies(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $landingSpecies = LandingActivitySpecies::find($id);
            $landingSpecies->species_id  = $request->selSpecies;
            $landingSpecies->weight  = $request->weight;
            $landingSpecies->price_per_weight  = $request->price;
            $landingSpecies->updated_by = Auth::user()->id;
            $landingSpecies->save();
            
            $landingActivity = LandingInfoActivity::find($landingSpecies->landing_info_activity_id);
            $landing = LandingInfo::find($landingActivity->landing_info_id);
        
            $audit_details = json_encode([ 
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'updateCEditSpecies',  $audit_details);
        
            DB::commit();
            return redirect()->route('landingdeclaration.application.editWeekB',$landing->landing_declaration_id)->with('alert', 'Permohonan berjaya disimpan !!');
        } 
        catch (Exception $e) {
            DB::rollback();
        
            $audit_details = json_encode([
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'updateCEditSpecies', $audit_details, $e->getMessage());
    
            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }
    
    public function deleteSpecies(Request $request, string $id)
    {
        DB::beginTransaction();

        try 
        {
            $appKru = LandingActivitySpecies::find($id);
			$appKru->delete();

            DB::commit();

            return redirect()->back()->with('alert', 'Spesis berjaya dipadam !!');
        }
        catch (Exception $e) {

            DB::rollback();
            return redirect()->back()->with('alert', 'Spesis berjaya dipadam !!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateWeekC(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $user = User::find(Auth::user()->id);

            $helper = new Helper();
            $statusDihantarId = $helper->getCodeMasterIdByTypeName('landing_status','Disimpan');

            $app = LandingDeclaration::find($id);
            $app->submitted_at = Carbon::now()->toDateTimeString();
            $app->entity_id = $user->entity_id;
            $app->landing_status_id = $statusDihantarId;
            $app->updated_by = Auth::user()->id;
            $app->save();
            
            // $appLog = new LandingDeclarationLog();
            // $appLog->landing_declaration_id =  $id;
            // $appLog->landing_status_id = $statusDihantarId;
            // $appLog->remark	= 'Pemohon';
            // $appLog->created_by = Auth::id();
            // $appLog->updated_by = Auth::id();
            // $appLog->save();
        
            $audit_details = json_encode([ 
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'updateE',  $audit_details);
        
            DB::commit();
            return redirect()->route('landingdeclaration.application.edit',$app->landing_declare_monthly_id)->with('alert', 'Permohonan berjaya dihantar !!');
        } 
        catch (Exception $e) {
            DB::rollback();
        
            $audit_details = json_encode([
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratan', 'updateE', $audit_details, $e->getMessage());
    
            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function show($id)
    {
        $helper = new Helper();
        $app = LandingDeclarationMonthly::leftJoin('users','landing_declaration_monthlies.user_id','users.id')
        ->select('landing_declaration_monthlies.*','users.name','users.username')->find($id);
        $weeks = LandingDeclaration::where('landing_declare_monthly_id',$id)->orderBy('week','asc')->get();
        
        $docs = LandingMonthlyDocument::where('landing_declare_monthly_id',$id)->get();

        $statusTidakLengkapId = $helper->getCodeMasterIdByTypeName('landing_status','TIDAK LENGKAP');
        $incompleteLog = LandingDeclareMonthlyLog::where('landing_declare_monthly_id',$id)->where('is_editing',false)->where('landing_status_id',$statusTidakLengkapId)->latest('updated_at')->first();
        return view('app.landing_declaration.application.show', [
            'app' => $app,
            'weeks' => $weeks,
            'landingActivityIds' => LandingActivityType::where('has_landing',true)->select('id')->get()->pluck('id')->toArray(),
            'docs' => $docs,
            'statusTidakLengkapId' => $statusTidakLengkapId,
            'incompleteLog' => $incompleteLog,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function showWeek($id)
    {
        $helper = new Helper();
        $app = LandingDeclaration::leftJoin('users','landing_declarations.created_by','users.id')
        ->select('landing_declarations.*','users.name','users.username')->find($id);
        // $monthly = LandingDeclarationMonthly::find($app->landing_declare_monthly_id);
        // $weeklyIds = LandingDeclaration::where('landing_declare_monthly_id',$monthly->id)->select('id')->get()->pluck('id')->toArray();
        $landingInfos = LandingInfo::where('landing_declaration_id',$id)->orderBy('landing_date')->get();
        // $landingInfos = LandingInfo::whereIn('landing_declaration_id',$weeklyIds)->orderBy('landing_date')->get();

        return view('app.landing_declaration.application.showWeek', [
            'app' => $app,
            'landingInfos' => $landingInfos,
            'landingActivityIds' => LandingActivityType::where('has_landing',true)->select('id')->get()->pluck('id')->toArray(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
