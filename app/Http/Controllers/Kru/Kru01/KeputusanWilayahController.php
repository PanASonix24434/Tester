<?php

namespace App\Http\Controllers\Kru\Kru01;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Kru\KruHelperController;
use App\Mail\Kru\Kru01Approved;
use App\Models\Entity;
use App\Models\Helper;
use App\Models\Kru\Kru01Application;
use App\Models\Kru\KruApplication;
use App\Models\Kru\KruApplicationDocument;
use App\Models\Kru\KruApplicationLog;
use App\Models\Kru\KruApplicationType;
use App\Models\Kru\NelayanMarin;
use App\Models\SerialNumber;
use App\Models\Systems\AuditLog;
use App\Models\User;
use App\Models\Vesel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Mail;

class KeputusanWilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('keputusanwilayah');
        $user = $request->user();

        $helper = new Helper();
        $statusId = $helper->getCodeMasterIdByTypeName('kru_application_status','DISOKONG DAERAH');
        $statusId2 = $helper->getCodeMasterIdByTypeName('kru_application_status','TIDAK DISOKONG DAERAH');
        $sarawakEntityId = Entity::where('entity_name','Pejabat Perikanan Negeri Sarawak')->first()->id;

        $appTypeId = KruApplicationType::where('code','KRU01')->first()->id;
        $apps = KruApplication::leftJoin('kru01_applications', 'kru_applications.id', '=', 'kru01_applications.kru_application_id')
        ->leftJoin('entities', 'kru_applications.entity_id', '=', 'entities.id')
        // ->where('entities.parent_id',$user->entity_id)
        ->whereNotIn(DB::raw('SUBSTRING(kru01_applications.ic_number, 7, 2)'), KruHelperController::mykadbirthplacecode())
        
        ->where(function ($query) use ($appTypeId,$statusId,$statusId2,$sarawakEntityId,$user) {
            $query->where('kru_application_type_id', $appTypeId)
                ->where('kru01_applications.application_type','KRU BARU')
                ->whereIn('kru_applications.kru_application_status_id',[$statusId,$statusId2])
                ->where('entities.parent_id', $sarawakEntityId)
                ->whereNotIn(DB::raw('SUBSTRING(kru01_applications.ic_number, 7, 2)'), KruHelperController::mykadbirthplacecode());
        })->orWhere(function ($query) use ($appTypeId,$statusId,$statusId2,$sarawakEntityId,$user) {
            $query->where('kru_application_type_id', $appTypeId)
                ->where('kru01_applications.application_type','GANTI KRU')
                ->whereIn('kru_applications.kru_application_status_id',[$statusId,$statusId2])
                ->where('entities.parent_id', $sarawakEntityId);
        })
        ->select('kru_applications.id','reference_number','vessel_id','name','entity_id','kru_application_status_id','kru_applications.created_at')->sortable();

        return view('app.kru.kru01.keputusanwilayah.index', [
            'applications' => $request->has('sort') ? $apps->paginate(10) : $apps->orderBy('kru_applications.created_at','DESC')->paginate(10),
            'statusDisimpanId' => $statusId,
        ]);
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
        $user = User::find(Auth::id());
        $helper = new Helper();
        $app = KruApplication::find($id);
        $app2 = Kru01Application::where('kru_application_id',$id)->first();
        $vesel = Vesel::withTrashed()->find($app2->vessel_id);
        $applicant = User::find($app->user_id);
        $docs = KruApplicationDocument::where('kru_application_id',$id)->latest()->get();

        $logs = KruApplicationLog::where('kru_application_id',$id)
        ->where('is_editing',false)
        ->leftJoin('users', 'kru_application_logs.created_by', '=', 'users.id')
        ->select('kru_application_logs.*','users.name')
        ->orderBy('updated_at','ASC')
        ->get();

        $latestLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->latest('updated_at')->first();

        //try find saved log if any
        $savedLog = KruApplicationLog::where('kru_application_id',$id)
        ->where('is_editing',true)
        ->where('created_by',$user->id)
        ->where('created_at','>',$latestLog->updated_at)
        ->latest('created_at')
        ->first();

        return view('app.kru.kru01.keputusanwilayah.show', [
            'id' => $id,
            'app' => $app,
            'app2' => $app2,
            'vesel' => $vesel,
            'applicant' => $applicant,
            'docs' => $docs,
            'logs' => $logs,
            'savedLog' => $savedLog,
        ]);
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
    public function update(Request $request, string $id)
    {
        if ($request->action=='save'){
            DB::beginTransaction();
    
            try {
                $latestLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->latest('updated_at')->first();

                //try find saved log if any
                $savedLog = KruApplicationLog::where('kru_application_id',$id)
                ->where('is_editing',true)
                ->where('created_by',$request->user()->id)
                ->where('created_at','>',$latestLog->updated_at)
                ->latest('created_at')
                ->first();

                if($savedLog != null){
                    $savedLog->remark = $request->remark;
                    $savedLog->completed = $request->applicationStatus == 'approved' || $request->applicationStatus == 'rejected' ? true : 
                                        ( $request->applicationStatus == 'incomplete' ? false : null);
                    $savedLog->approved = $request->applicationStatus == 'approved' ? true : 
                                        ( $request->applicationStatus == 'rejected' ? false : null);
                    $savedLog->updated_by = $request->user()->id;
                    $savedLog->save();
                }
                else{
                    $newLog = new KruApplicationLog();
                    $newLog->kru_application_id = $id;
                    $newLog->remark = $request->remark;
                    $newLog->completed = $request->applicationStatus == 'approved' || $request->applicationStatus == 'rejected' ? true : 
                                        ( $request->applicationStatus == 'incomplete' ? false : null);
                    $newLog->approved = $request->applicationStatus == 'approved' ? true : 
                                        ( $request->applicationStatus == 'rejected' ? false : null);
                    $newLog->is_editing = true;
                    $newLog->created_by = $request->user()->id;
                    $newLog->updated_by = $request->user()->id;
                    $newLog->save();
                }
    
                $audit_details = json_encode([
                    'action' => $request->action,
                    'applicationStatus' => $request->applicationStatus,
                    // 'remark' => $request->remark,
                ]);
                $auditLog = new AuditLog();
                $auditLog->log('kru01KeputusanWilayah', 'update', $audit_details);
                DB::commit();
            }
            catch (Exception $e) {
                DB::rollback();
                $audit_details = json_encode([
                    'action' => $request->action,
                    'applicationStatus' => $request->applicationStatus,
                    // 'remark' => $request->remark,
                ]);
    
                $auditLog = new AuditLog();
                $auditLog->log('kru01KeputusanWilayah', 'update', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Maklumat gagal disimpan !!');
            }
            return redirect()->back()->with('alert', 'Maklumat berjaya disimpan !!');
        }
        else if ($request->action=='submit'){
            DB::beginTransaction();
    
            try {
                $helper = new Helper();
                $status_id='';//for application
                $status_id2='';//for log
                if($request->applicationStatus == 'approved'){
                    $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DILULUS');
                    $status_id2 = $status_id;
                }
                else if($request->applicationStatus == 'rejected'){
                    $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DITOLAK');
                    $status_id2 = $status_id;
                }
                else if($request->applicationStatus == 'incomplete'){
                    $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DISEMAK DAERAH');
                    $status_id2 = $helper->getCodeMasterIdByTypeName('kru_application_status','TIDAK LENGKAP');
                }

                $latestLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->latest('updated_at')->first();

                //try find saved log if any
                $savedLog = KruApplicationLog::where('kru_application_id',$id)
                ->where('is_editing',true)
                ->where('created_by',$request->user()->id)
                ->where('created_at','>',$latestLog->updated_at)
                ->latest('created_at')
                ->first();

                if($savedLog != null){
                    $savedLog->remark = $request->remark;
                    $savedLog->completed = $request->applicationStatus == 'approved' || $request->applicationStatus == 'rejected' ? true : 
                                        ( $request->applicationStatus == 'incomplete' ? false : null);
                    $savedLog->approved = $request->applicationStatus == 'approved' ? true : 
                                        ( $request->applicationStatus == 'rejected' ? false : null);
                    $savedLog->is_editing = false;
                    $savedLog->kru_application_status_id = $status_id2;
                    $savedLog->updated_by = $request->user()->id;
                    $savedLog->save();
                }
                else{
                    $newLog = new KruApplicationLog();
                    $newLog->kru_application_id = $id;
                    $newLog->remark = $request->remark;
                    $newLog->completed = $request->applicationStatus == 'approved' || $request->applicationStatus == 'rejected' ? true : 
                                        ( $request->applicationStatus == 'incomplete' ? false : null);
                    $newLog->approved = $request->applicationStatus == 'approved' ? true : 
                                        ( $request->applicationStatus == 'rejected' ? false : null);
                    $newLog->is_editing = false;
                    $newLog->kru_application_status_id = $status_id2;
                    $newLog->created_by = $request->user()->id;
                    $newLog->updated_by = $request->user()->id;
                    $newLog->save();
                }

                $app = KruApplication::find($id);
                $app2 = Kru01Application::where('kru_application_id',$id)->first();
                $vessel = Vesel::find($app2->vessel_id);
                if($request->applicationStatus == 'approved'){

                    //check nelayan sedia ada untuk nombor pendaftaran
                    $nelayanMarin = NelayanMarin::where('ic_number',$app2->ic_number)->first();
                    if(($nelayanMarin != null) && ($nelayanMarin->registration_number!=null)){
                        $app->registration_number = $nelayanMarin->registration_number;
                    }
                    else{
                        $serialNumber = new SerialNumber();
                        $app->registration_number = $serialNumber->generateKPNRegistrationNumber($request->user()->id);
                    }

                    //today start date and vessel end date
                    $app->registration_start = Carbon::now()->toDateTimeString();
                    $app->registration_end = $vessel->license_end;
                    $app->pin_number = KruHelperController::generatePinNumber();

                    //insert/update nelayan_marins table
                    if($nelayanMarin == null){
                        $nelayanMarin = new NelayanMarin();
                        $nelayanMarin->ic_number = $app2->ic_number;
                    }
                    $nelayanMarin->name = $app2->name;
                    $nelayanMarin->vessel_id = $app2->vessel_id;
                    $nelayanMarin->address1 = $app2->address1;
                    $nelayanMarin->address2 = $app2->address2;
                    $nelayanMarin->address3 = $app2->address3;
                    $nelayanMarin->postcode = $app2->postcode;
                    $nelayanMarin->city = $app2->city;
                    $nelayanMarin->district_id = $app2->district_id;
                    $nelayanMarin->state_id = $app2->state_id;
                    $nelayanMarin->home_contact_number = $app2->home_contact_number;
                    $nelayanMarin->mobile_contact_number = $app2->mobile_contact_number;
                    $nelayanMarin->email = $app2->email;

                    $nelayanMarin->registration_number = $app->registration_number;
                    $nelayanMarin->registration_start = $app->registration_start;
                    $nelayanMarin->registration_end = $app->registration_end;
                    $nelayanMarin->save();
                }
                $app->kru_application_status_id = $status_id;
                $app->updated_by = $request->user()->id;
                $app->save();

                $audit_details = json_encode([
                    'action' => $request->action,
                    'applicationStatus' => $request->applicationStatus,
                    // 'remark' => $request->remark,
                ]);
                $auditLog = new AuditLog();
                $auditLog->log('kru01KeputusanNegeri', 'update', $audit_details);
                DB::commit();
                
                if($request->applicationStatus == 'approved'){

                    //Send email pendaftaran / pin ================================
                    $pemilikVesel = User::find($vessel->user_id);
                    $entity = Entity::find($app->entity_id);

                    $mailDataArr = array(
                        'ref_no' => $app->reference_number,
                        'owner' => strtoupper($pemilikVesel->name),
                        'vessel' => strtoupper($vessel->vessel_number),
                        'kru' => strtoupper($app2->name),
                        'kru_ic' => strtoupper($app2->ic_number),
                        'entity_name' => $entity->entity_name,
                        
                        'reg_no' => $app->registration_number,
                        'start_date' => $app->registration_start->format('d/m/Y'),
                        'end_date' => $app->registration_end->format('d/m/Y'),

                        'pin_number' => $app->pin_number,
                    );

                    //Send email to penerima hebahan
                    Mail::to($pemilikVesel->email)->queue(new Kru01Approved($mailDataArr));

                }
            }
            catch (Exception $e) {
                DB::rollback();
                $audit_details = json_encode([
                    'action' => $request->action,
                    'applicationStatus' => $request->applicationStatus,
                    // 'remark' => $request->remark,
                ]);
    
                $auditLog = new AuditLog();
                $auditLog->log('kru01KeputusanNegeri', 'update', $audit_details, $e->getMessage());
    
                return redirect()->back()->with('alert', 'Maklumat gagal dihantar !!');
            }
            return redirect()->route('kadpendaftarannelayan.keputusanwilayah.index')->with('alert', 'Maklumat berjaya dihantar !!');
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
