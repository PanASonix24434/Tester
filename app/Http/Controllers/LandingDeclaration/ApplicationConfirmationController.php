<?php

namespace App\Http\Controllers\LandingDeclaration;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Entity;
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
use App\Models\Species;
use App\Models\Systems\AuditLog;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationConfirmationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $helper = new Helper();
        $statusSahId = $helper->getCodeMasterIdByTypeName('landing_status','DISOKONG DAERAH');
        $statusTidakSahId = $helper->getCodeMasterIdByTypeName('landing_status','TIDAK DISOKONG DAERAH');

        $app = LandingDeclarationMonthly::leftJoin('users','user_id','users.id')
            ->whereIn('landing_status_id',[$statusSahId,$statusTidakSahId])
            ->select('landing_declaration_monthlies.id','user_id','users.name','users.username','year','month','landing_declaration_monthlies.landing_status_id');

        return view('app.landing_declaration.confirmation.index', [
            'app' => $request->has('sort') ? $app->paginate(10) : $app->orderBy('landing_declaration_monthlies.created_at')->paginate(10),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function show($id)
    {
        $helper = new Helper();
        $monthly = LandingDeclarationMonthly::find($id);
        $docs = LandingMonthlyDocument::where('landing_declare_monthly_id',$id)->get();
        $apps = LandingDeclaration::where('user_id',$monthly->user_id)->where('year',$monthly->year)->where('month',$monthly->month)->orderBy('week','asc')->get();
        
        //general
        $applicant = User::find($monthly->user_id);
        $entity = Entity::find($monthly->entity_id);

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

        $logs = LandingDeclareMonthlyLog::where('landing_declare_monthly_id',$monthly->id)
        ->where('is_editing',false)
        ->leftJoin('users', 'landing_declare_monthly_logs.created_by', '=', 'users.id')
        ->select('landing_declare_monthly_logs.*','users.name')
        ->orderBy('updated_at','ASC')
        ->get();
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
        
        return view('app.landing_declaration.confirmation.show', [
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
        return view('app.landing_declaration.confirmation.showWeek', [
            'app' => $app,
            'landingInfos' => $landingInfos,
            'landingActivityIds' => LandingActivityType::where('has_landing',true)->select('id')->get()->pluck('id')->toArray(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function showWeeks($id)
    // {
    //     $helper = new Helper();
    //     $app = LandingDeclaration::leftJoin('users','landing_declarations.created_by','users.id')
    //     ->select('landing_declarations.*','users.name','users.username')->find($id);
    //     $landingInfos = LandingInfo::where('landing_declaration_id',$id)->orderBy('landing_date')->get();
    //     return view('app.landing_declaration.confirmation.show', [
    //         'app' => $app,
    //         'landingInfos' => $landingInfos,
    //         'landingActivityIds' => LandingActivityType::where('has_landing',true)->select('id')->get()->pluck('id')->toArray(),
    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $helper = new Helper();
            $statusSahId = $helper->getCodeMasterIdByTypeName('landing_status','DISAHKAN DAERAH');
            $statusTidakSahId = $helper->getCodeMasterIdByTypeName('landing_status','TIDAK DISAHKAN DAERAH');
            $statusDihantarId = $helper->getCodeMasterIdByTypeName('landing_status','DIHANTAR');
            $statusTidakLengkapId = $helper->getCodeMasterIdByTypeName('landing_status','TIDAK LENGKAP');
            $app = LandingDeclarationMonthly::find($id);

            $apps = LandingDeclaration::where('user_id',$app->user_id)->where('year',$app->year)->where('month',$app->month)->get();

            if($request->applicationStatus == 'sah'){
                $app->is_verified = true;
                $app->landing_status_id = $statusSahId;
                $app->decision_by = Auth::user()->id;

                foreach($apps as $a){
                    $a->is_verified = true;
                    $a->landing_status_id = $statusSahId;
                    $a->decision_by = Auth::user()->id;
                    $a->save();
                }
            }
            elseif($request->applicationStatus == 'tidak_sah'){
                $app->is_verified = false;
                $app->landing_status_id = $statusTidakSahId;
                $app->decision_by = Auth::user()->id;

                foreach($apps as $a){
                    $a->is_verified = false;
                    $a->landing_status_id = $statusTidakSahId;
                    $a->decision_by = Auth::user()->id;
                    $a->save();
                }
            }
            elseif($request->applicationStatus == 'tidak_lengkap'){
                $app->landing_status_id = $statusDihantarId;

                // foreach($apps as $a){
                //     $a->is_verified = null;
                //     $a->used_in_monthly = null;
                //     $a->landing_status_id = $statusDihantarId;
                //     // $a->decision_by = Auth::user()->id;
                //     $a->save();
                // }
            }
            $app->updated_by = Auth::user()->id;
            $app->save();

            $appLog = new LandingDeclareMonthlyLog();
            $appLog->landing_declare_monthly_id =  $id;
            if($request->applicationStatus == 'sah'){
                $appLog->landing_status_id = $statusSahId;
            }
            elseif($request->applicationStatus == 'tidak_sah'){
                $appLog->landing_status_id = $statusTidakSahId;
            }
            elseif($request->applicationStatus == 'tidak_lengkap'){
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
            return redirect()->route('landingdeclaration.confirmation.index')->with('alert', 'Permohonan berjaya dihantar !!');
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
