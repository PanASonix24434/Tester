<?php

namespace App\Http\Controllers\LandingDeclaration;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Entity;
use App\Models\Helper;
use App\Models\LandingDeclaration\LandingActivitySpecies;
use App\Models\LandingDeclaration\LandingActivityType;
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingDeclarationLog;
use App\Models\LandingDeclaration\LandingDeclarationMonthly;
use App\Models\LandingDeclaration\LandingDeclareMonthlyLog;
use App\Models\LandingDeclaration\LandingDocument;
use App\Models\LandingDeclaration\LandingInfo;
use App\Models\LandingDeclaration\LandingInfoActivity;
use App\Models\LandingDeclaration\LandingMonthlyDocument;
use App\Models\Species;
use App\Models\Systems\AuditLog;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ApplicationCheckController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $helper = new Helper();
        $statusDihantarId = $helper->getCodeMasterIdByTypeName('landing_status','DIHANTAR');
        
        $user = User::find(Auth::user()->id);

        $app = LandingDeclarationMonthly::leftJoin('users','landing_declaration_monthlies.user_id','users.id')
            // ->groupBy(['users.id','users.name','users.username','year', 'month'])
            // ->where('used_in_monthly',null)
            ->where('landing_status_id',$statusDihantarId)
            ->where('landing_declaration_monthlies.entity_id',$user->entity_id)
            ->orderBy('year','desc')
            ->orderBy('month','desc')
            ->select('landing_declaration_monthlies.id','users.id as user_id','users.name','users.username','year','month','landing_declaration_monthlies.landing_status_id');
            // ->select('landing_declarations.*','users.name','users.username');

        return view('app.landing_declaration.check.index', [
            'app' => $request->has('sort') ? $app->paginate(10) : $app->paginate(10),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show(Request $request,$id)
    {
        $helper = new Helper();

        $statusDihantarId = $helper->getCodeMasterIdByTypeName('landing_status','DIHANTAR');
        $statusTidakLengkapId = $helper->getCodeMasterIdByTypeName('landing_status','TIDAK LENGKAP');
        // $apps = LandingDeclarationMonthly::where('id',$id)
        // ->whereIn('landing_status_id',[$statusDihantarId])
        // ->orderBy('year','asc')
        // ->orderBy('month','asc')->get();

        //general
        // $app = $apps->first();

        $monthly = LandingDeclarationMonthly::find($id);
        $docs = LandingMonthlyDocument::where('landing_declare_monthly_id',$id)->get();
        $applicant = User::find($monthly->user_id);
        $entity = Entity::find($monthly->entity_id);

        $apps = LandingDeclaration::where('landing_declare_monthly_id',$id)->orderBy('week','asc')->get();

        //----------------start summary------------------
        $operatedDays = 0;
        $totalLanding = 0;
        // $speciesData = collect();
        $summaryData = collect();
        $weeklyIds = LandingDeclaration::where('landing_declare_monthly_id', $monthly->id)->select('id')->get()->pluck('id')->toArray();
        $landingInfos = LandingInfo::whereIn('landing_declaration_id',$weeklyIds)->orderBy('landing_date')->get();
        foreach ($landingInfos as $li) {
            $activities = LandingInfoActivity:: where('landing_info_id',$li->id)->get();
            if(!$activities->isEmpty()){
                $operatedDays++;
                foreach ($activities as $act) {
                    $species = LandingActivitySpecies::where('landing_info_activity_id',$act->id)->get();
                    if(!$species->isEmpty()){
                        foreach ($species as $s) {
                            $totalLanding += $s->weight;
                            $hasLocation = $summaryData->where('districtId',$act->district_id )->where('location',$act->location_name)->isNotEmpty();
                            if(!$hasLocation){
                                $summaryData->push(
                                    (object)[
                                    'districtId' => $act->district_id,
                                    'location' => $act->location_name,
                                    'district' => strtoupper(CodeMaster::find($act->district_id)->name),
                                    'species' => collect(),
                                    ]
                                );
                            }
                            $spsInLocation = $summaryData->where('districtId',$act->district_id )->where('location',$act->location_name)->first()->species;
                            $hasSpsInLocation = $spsInLocation->where('speciesId',$s->species_id)->isNotEmpty();
                            if($hasSpsInLocation){
                                $sps = $spsInLocation->where('speciesId',$s->species_id)->first();
                                // $sps = $speciesData->firstWhere('speciesId',$s->species_id);
                                $sps->totalWeight += $s->weight;
                                $sps->totalPrice += $s->weight * $s->price_per_weight;
                            }
                            else{
                                $spsInLocation->push(
                                    (object)[
                                    'speciesId' => $s->species_id,
                                    'speciesName' => Species::find($s->species_id)->common_name,
                                    'totalWeight' => $s->weight,
                                    'totalPrice' => $s->weight * $s->price_per_weight
                                    ]
                                );
                            }
                        }
                    }
                }
            }
        }
        //----------------end summary-----------------------

        $logs = collect();
        if($monthly != null){
            $logs = LandingDeclareMonthlyLog::where('landing_declare_monthly_id',$monthly->id)
            ->where('is_editing',false)
            ->leftJoin('users', 'landing_declare_monthly_logs.created_by', '=', 'users.id')
            ->select('landing_declare_monthly_logs.*','users.name')
            ->orderBy('updated_at','ASC')
            ->get();
        }
        //----------------start statusIds--------------------
        $redStatusIds = CodeMaster::where('type','kru_application_status') //used at logs
        ->whereIn('name',[
            'TIDAK DISOKONG DAERAH',
            'TIDAK DISOKONG WILAYAH',
            'TIDAK DISOKONG NEGERI',
            'DITOLAK',
        ])->select('id')->get();
        $orangeStatusIds = CodeMaster::where('type','kru_application_status') //used at logs
        ->whereIn('name',[
            'TIDAK LENGKAP',
            'BAYARAN TIDAK DISAHKAN',
        ])->select('id')->get();
        //----------------end statusIds--------------------
        return view('app.landing_declaration.check.show', [
            'id' => $id,
            'applicant' => $applicant,
            'entity' => $entity,
            'monthly' => $monthly,
            'apps' => $apps,
            //------------start summary------------
            'operatedDays' => $operatedDays,
            'totalLanding' => $totalLanding,
            'summaryData' => $summaryData,
            //-------------end summary-------------
            'docs' => $docs,
            //------------start logs----------------
            'logs' => $logs,
            'redStatusIds' => $redStatusIds,
            'orangeStatusIds' => $orangeStatusIds,
            //-------------end logs----------------
            'statusTidakLengkapId' => $statusTidakLengkapId,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function showWeek($id)
    {
        $app = LandingDeclaration::leftJoin('users','landing_declarations.created_by','users.id')
        ->select('landing_declarations.*','users.name','users.username')->find($id);
        $landingInfos = LandingInfo::where('landing_declaration_id',$id)->orderBy('landing_date')->get();

        return view('app.landing_declaration.check.showWeek', [
            'app' => $app,
            'landingInfos' => $landingInfos,
            'landingActivityIds' => LandingActivityType::where('has_landing',true)->select('id')->get()->pluck('id')->toArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $helper = new Helper();
            $statusDisokongId = $helper->getCodeMasterIdByTypeName('landing_status','DISOKONG DAERAH');
            $statusTidakDisokongId = $helper->getCodeMasterIdByTypeName('landing_status','TIDAK DISOKONG DAERAH');
            $statusTidakLengkapId = $helper->getCodeMasterIdByTypeName('landing_status','TIDAK LENGKAP');

            // $apps = LandingDeclaration::where('user_id',$id)->where('year',$year)->where('month',$month)->get();
            
            $monthly = LandingDeclarationMonthly::find($id);

            if($request->applicationStatus == 'supported'){
                // foreach($apps as $app){
                //     $app->used_in_monthly = true;
                //     $app->save();
                // }
                $monthly->landing_status_id = $statusDisokongId;
            }
            elseif($request->applicationStatus == 'notSupported'){
                // foreach($apps as $app){
                //     $app->used_in_monthly = true;
                //     $app->save();
                // }
                $monthly->landing_status_id = $statusTidakDisokongId;
            }
            elseif($request->applicationStatus == 'incomplete'){
                $monthly->landing_status_id = $statusTidakLengkapId;
            }
            $monthly->updated_by = Auth::user()->id;
            $monthly->save();


            $appLog = new LandingDeclareMonthlyLog();
            $appLog->landing_declare_monthly_id =  $monthly->id;
            if($request->applicationStatus == 'supported'){
                $appLog->landing_status_id = $statusDisokongId;
            }
            elseif($request->applicationStatus == 'notSupported'){
                $appLog->landing_status_id = $statusTidakDisokongId;
            }
            elseif($request->applicationStatus == 'incomplete'){
                $appLog->landing_status_id = $statusTidakLengkapId;
            }
            $appLog->remark	= $request->remark;
            $appLog->created_by = Auth::id();
            $appLog->updated_by = Auth::id();
            $appLog->save();
        
            $audit_details = json_encode([ 
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratanCheck', 'update',  $audit_details);
        
            DB::commit();
            return redirect()->route('landingdeclaration.check.index')->with('alert', 'Permohonan berjaya dihantar !!');
        } 
        catch (Exception $e) {
            DB::rollback();
        
            $audit_details = json_encode([
                'id' =>  $id,
            ]);	
        
            $auditLog = new AuditLog();
            $auditLog->log('PengisytiharanPendaratanCheck', 'update', $audit_details, $e->getMessage());
    
            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
