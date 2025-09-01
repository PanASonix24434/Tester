<?php

namespace App\Http\Controllers\Kru\Kru02;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Helper;
use App\Models\Kru\KruApplication;
use App\Models\Kru\KruApplicationKru;
use App\Models\Kru\KruApplicationLog;
use App\Models\Kru\KruApplicationType;
use App\Models\Kru\KruDocument;
use App\Models\Kru\NelayanMarin;
use App\Models\ReferenceNumber;
use App\Models\Systems\AuditLog;
use App\Models\User;
use App\Models\Vessel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('permohonan');

        $helper = new Helper();
        $statusDisimpanId = $helper->getCodeMasterIdByTypeName('kru_application_status','DISIMPAN');

        $appTypeId = KruApplicationType::where('code','KRU02')->first()->id;
        $apps = KruApplication::leftJoin('vessels', 'kru_applications.vessel_id', '=', 'vessels.id')
        ->where('kru_application_type_id', $appTypeId)
        ->where('kru_applications.user_id',$request->user()->id)
        ->select('kru_applications.id','reference_number','no_pendaftaran','kru_applications.entity_id','kru_applications.kru_application_status_id','kru_applications.created_at')->sortable();

        return view('app.kru.kru02.index', [
            'applications' => $request->has('sort') ? $apps->paginate(10) : $apps->orderBy('kru_applications.created_at','DESC')->paginate(10),
            'statusDisimpanId' => $statusDisimpanId,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $helper = new Helper();
        $user = User::find(Auth::id());

        return view('app.kru.kru02.create', [
            'vessels' => Vessel::where('user_id',$user->id)->orderBy('no_pendaftaran')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $helper = new Helper();

            //Initiated required data
            $appType = KruApplicationType::where('code','KRU02')->first();
            $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DISIMPAN');

            //get vessel's entity (pejabat perikanan daerah)
            $vessel_entity = Vessel::find($request->selVessel)->entity_id;

            //create new application
            $app = new KruApplication();
            $app->kru_application_type_id = $appType->id;
            $app->user_id = $request->user()->id;
            $app->vessel_id = $request->selVessel;
            $app->kru_application_status_id = $status_id;
            $app->entity_id = $vessel_entity;
            $app->created_by = Auth::id();
            $app->updated_by = Auth::id();
            $app->save();

            $audit_details = json_encode([
                'vessel_id' => $request->selVessel,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru02', 'create', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
                'vessel_id' => $request->selVessel,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru02', 'create', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('pembaharuankadpendaftarannelayan.permohonan.edit', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        $vessel = Vessel::withTrashed()->find($app->vessel_id);
        $selectedKrus = KruApplicationKru::where('kru_application_id',$id)->get();
        
        $statusDilulusId = $helper->getCodeMasterIdByTypeName('kru_application_status','DILULUS');
        $statusRejectedId = $helper->getCodeMasterIdByTypeName('kru_application_status','DITOLAK');
        $statusIncompleteId = $helper->getCodeMasterIdByTypeName('kru_application_status','TIDAK LENGKAP');
        $rejectedLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->where('kru_application_status_id',$statusRejectedId)->latest('updated_at')->first();
        $incompleteLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->where('kru_application_status_id',$statusIncompleteId)->latest('updated_at')->first();

        $decisionStatusIds = CodeMaster::where('type','kru_application_status') //used at decision to enable/disable tab
        ->whereIn('name',[
            'DILULUS',
            'BAYARAN DITERIMA',
            'BAYARAN DISAHKAN',
            'BAYARAN TIDAK DISAHKAN',
            'PERMOHONAN SELESAI'
        ])->select('id')->get();
        
        return view('app.kru.kru02.show', [
            'id' => $id,
            'app' => $app,
            // 'app2' => $app2,
            'vessel' => $vessel,
            'selectedKrus' => $selectedKrus,
            
            'statusDilulusId' => $statusDilulusId,
            'statusRejectedId' => $statusRejectedId,
            'statusIncompleteId' => $statusIncompleteId,
            'rejectedLog' => $rejectedLog,
            'incompleteLog' => $incompleteLog,
            //-----------start decision------------
            'decisionStatusIds' => $decisionStatusIds,
            //------------end decision-------------
        ]);
    }
    
    public function showKru(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());

        $appKru = KruApplicationKru::find($id);
        $app = KruApplication::find($appKru->kru_application_id);
        // $app2 = Kru02Application::where('kru_application_id',$appKru->kru_application_id)->first();
        $vessel = Vessel::withTrashed()->find($app->vessel_id);
        $kruDocs = KruDocument::where('kru_application_kru_id',$id)->get();

        return view('app.kru.kru02.showKru', [
            'id' => $appKru->kru_application_id,
            'appKru' => $appKru,
            'vessel' => $vessel,
            'kruDocs' => $kruDocs,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        // $app2 = Kru02Application::where('kru_application_id',$id)->first();
        $vessel = Vessel::find($app->vessel_id);
        $nelayanMarin = NelayanMarin::where('vessel_id',$vessel->id)->get();
        $selectedKrus = KruApplicationKru::where('kru_application_id',$id)->select('id','ic_number','health_declaration')->get();

        return view('app.kru.kru02.edit', [
            'id' => $id,
            // 'app2' => $app2,
            'vessel' => $vessel,
            'krus' => $nelayanMarin,
            'selectedKrus' => $selectedKrus
        ]);
    }

    public function editB(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $appKru = KruApplicationKru::find($id);
        
        $districts = null;
        if($appKru->state_id != null){
            $districts = CodeMaster::where('type','district')->where('parent_id',$appKru->state_id)->orderBy('name')->select('id','name')->get();
        }

        return view('app.kru.kru02.editB', [
            'id' => $appKru->kru_application_id,
            'appKru' => $appKru,
            'states' => $helper->getCodeMastersByType('state'),
            'districts' => $districts,
        ]);
    }

    public function editC(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $appKru = KruApplicationKru::find($id);

        return view('app.kru.kru02.editC', [
            'id' => $appKru->kru_application_id,
            'appKru' => $appKru,
        ]);
    }

    public function editD(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $appKru = KruApplicationKru::find($id);
        $healthDoc = KruDocument::where('kru_application_kru_id',$id)->where('description','PEMERIKSAAN KESIHATAN NELAYAN')->latest()->first();

        return view('app.kru.kru02.editD', [
            'id' => $appKru->kru_application_id,
            'appKru' => $appKru,
            'healthDoc' => $healthDoc,
        ]);
    }

    public function editE(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $appKru = KruApplicationKru::find($id);
        $icDoc = KruDocument::where('kru_application_kru_id',$id)->where('description','SALINAN KAD PENGENALAN')->latest()->first();
        $picDoc = KruDocument::where('kru_application_kru_id',$id)->where('description','GAMBAR KRU')->latest()->first();
        $extraDoc = KruDocument::where('kru_application_kru_id',$id)->whereNotIn('description',['SALINAN KAD PENGENALAN','GAMBAR KRU','PEMERIKSAAN KESIHATAN NELAYAN'])->latest()->first();

        return view('app.kru.kru02.editE', [
            'id' => $appKru->kru_application_id,
            'appKru' => $appKru,
            'icDoc' => $icDoc,
            'picDoc' => $picDoc,
            'extraDoc' => $extraDoc,
        ]);
    }

    // public function editEAddDoc(string $id)
    // {
    //     $helper = new Helper();
    //     $user = User::find(Auth::id());
    //     $app = KruApplication::find($id);
    //     $app2 = Kru02Application::where('kru_application_id',$id)->first();
    //     $documents = KruApplicationDocument::where('kru_application_id',$id)->get();

    //     return view('app.kru.kru02.editEAddDoc', [
    //         'id' => $id,
    //         'documents' => $documents,
    //     ]);
    // }

    public function editF(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);

        return view('app.kru.kru02.editF', [
            'id' => $id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $selKrus = $request->selKrus;
        if($selKrus==null){
            return redirect()->back()->with('alert', 'Permohonan Perlu Minimun Seorang Kru Dipilih untuk Diperbaharui !!');
        }
        DB::beginTransaction();

        try {
            $app = KruApplication::find($id);
            $app->updated_by = Auth::id();
            $app->save();

            //delete already selected kru from before if any
            $appKrus = KruApplicationKru::where('kru_application_id',$id)->get();
            foreach ($appKrus as $appKru) {
                $appKru->deleted_by = Auth::id();
                $appKru->save();
                $appKru->delete();
            }

            //add selected kru
            foreach ($selKrus as $selKru) {
                $nelayan = NelayanMarin::find($selKru);

                //search if there are any deleted kru
                $appKru = KruApplicationKru::withTrashed()->where('kru_application_id',$app->id)->where('ic_number',$nelayan->ic_number)->first();
                if($appKru==null){
                    $appKru = new KruApplicationKru();
                    $appKru->kru_application_id = $app->id;
                    $appKru->ic_number = $nelayan->ic_number;
                    $appKru->name = $nelayan->name;
                    $appKru->kru_position_id = $nelayan->kru_position_id;
                    $appKru->race_id = $nelayan->race_id;
                    $appKru->kewarganegaraan_status_id = $nelayan->kewarganegaraan_status_id;

                    $appKru->address1 = $nelayan->address1;
                    $appKru->address2 = $nelayan->address2;
                    $appKru->address3 = $nelayan->address3;
                    $appKru->postcode = $nelayan->postcode;
                    $appKru->city = $nelayan->city;
                    $appKru->district_id = $nelayan->district_id;
                    $appKru->state_id = $nelayan->state_id;

                    $appKru->home_contact_number = $nelayan->home_contact_number;
                    $appKru->mobile_contact_number = $nelayan->mobile_contact_number;
                    $appKru->email = $nelayan->email;
                    $appKru->created_by = Auth::id();
                    $appKru->updated_by = Auth::id();
                    $appKru->save();
                    
                    $kruOriginalDocs = KruDocument::where('kru_application_kru_id',$nelayan->kru_application_kru_id)->whereIn('description',[KruDocument::DOC_IC,KruDocument::DOC_PIC])->get();
                    if(!$kruOriginalDocs->isEmpty()){
                        foreach ($kruOriginalDocs as $kruOriginalDoc) {
                            $doc = new KruDocument();
                            $doc->kru_application_kru_id = $appKru->id;
                            $doc->file_name = $kruOriginalDoc->file_name;
                            $doc->file_path = $kruOriginalDoc->file_path;
                            $doc->description = $kruOriginalDoc->description;
                            $doc->created_by = $request->user()->id;
                            $doc->updated_by = $request->user()->id;
                            $doc->save();
                        }
                    }
                }
                else{
                    $appKru->deleted_by = null;
                    $appKru->deleted_at = null;
                    $appKru->created_by = Auth::id();
                    $appKru->updated_by = Auth::id();
                    $appKru->save();
                }
            }

            $audit_details = json_encode([
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru02', 'edit', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru02', 'edit', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('pembaharuankadpendaftarannelayan.permohonan.edit', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    public function updateB(Request $request, string $id)
    {
        DB::beginTransaction();
        $appKru = null;
        try {
            $appKru = KruApplicationKru::find($id);
            $appKru->address1 = strtoupper($request->address1);
            $appKru->address2 = strtoupper($request->address2);
            $appKru->address3 = strtoupper($request->address3);
            $appKru->postcode = $request->postcode;
            $appKru->city = strtoupper($request->city);
            $appKru->district_id = $request->selDistrict;
            $appKru->state_id = $request->selState;
            $appKru->updated_by = Auth::id();
            $appKru->save();
            
            $app = KruApplication::find($appKru->kru_application_id);
            $app->updated_by = Auth::id();
            $app->save();

            $audit_details = json_encode([
                'address1' => $request->address1,
                'address2' => $request->address2,
                'address3' => $request->address3,
                'postcode' => $request->postcode,
                'city' => $request->city,
                'district_id' => $request->selDistrict,
                'state_id' => $request->selState,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru02', 'editB', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
                'address1' => $request->address1,
                'address2' => $request->address2,
                'address3' => $request->address3,
                'postcode' => $request->postcode,
                'city' => $request->city,
                'district_id' => $request->selDistrict,
                'state_id' => $request->selState,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru02', 'editB', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('pembaharuankadpendaftarannelayan.permohonan.editC', $id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    public function updateC(Request $request, string $id)
    {
        DB::beginTransaction();

        try {

            $appKru = KruApplicationKru::find($id);
            $appKru->mobile_contact_number = $request->mobilePhoneNumber;
            $appKru->home_contact_number = $request->homePhoneNumber;
            $appKru->email = $request->email;
            $appKru->updated_by = Auth::id();
            $appKru->save();
            
            $app = KruApplication::find($appKru->kru_application_id);
            $app->updated_by = Auth::id();
            $app->save();

            $audit_details = json_encode([
                'mobile_contact_number' => $request->mobilePhoneNumber,
                'home_contact_number' => $request->homePhoneNumber,
                'email' => $request->email,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru02', 'editC', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
                'mobile_contact_number' => $request->mobilePhoneNumber,
                'home_contact_number' => $request->homePhoneNumber,
                'email' => $request->email,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru02', 'editC', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('pembaharuankadpendaftarannelayan.permohonan.editD', $id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    public function updateD(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $appKru = KruApplicationKru::find($id);
            $appKru->health_declaration = $request->health;
            $appKru->updated_by = Auth::id();
            $appKru->save();
            
            $app = KruApplication::find($appKru->kru_application_id);
            $app->updated_by = Auth::id();
            $app->save();

            $path='';
            if ($request->file('healthDoc')) {

                $file = $request->file('healthDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('healthDoc')->store('public/kru/krudoc');

                $doc = new KruDocument();
                $doc->kru_application_kru_id = $id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = 'PEMERIKSAAN KESIHATAN NELAYAN';
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }

            $audit_details = json_encode([
                'health_declaration' => $request->health,
                'path' => $path,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru02', 'editD', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
                'health_declaration' => $request->health,
                'path' => $path,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru02', 'editD', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('pembaharuankadpendaftarannelayan.permohonan.editE', $id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    public function updateE(Request $request, string $id)
    {
        $request->validate(
        [
            'kruPic' => 'mimes:jpg,bmp,png',
        ],
        [
            'kruPic.mimes' => 'Jenis file dibenarkan adalah jpg,png,bmp.',
        ]);

        DB::beginTransaction();

        try {
            $appKru = KruApplicationKru::find($id);
            $appKru->updated_by = Auth::id();
            $appKru->save();
            
            $app = KruApplication::find($appKru->kru_application_id);
            $app->updated_by = Auth::id();
            $app->save();

            $path='';
            if ($request->file('kadPengenalanDoc')) {

                $file = $request->file('kadPengenalanDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('kadPengenalanDoc')->store('public/kru/krudoc');

                $doc = new KruDocument();
                $doc->kru_application_kru_id = $id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = 'SALINAN KAD PENGENALAN';
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }
            if ($request->file('kruPic')) {

                $file = $request->file('kruPic');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('kruPic')->store('public/kru/krudoc');

                $doc = new KruDocument();
                $doc->kru_application_kru_id = $id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = 'GAMBAR KRU';
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }

            if ($request->file('extraDoc')) {

                $file = $request->file('extraDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('extraDoc')->store('public/kru/krudoc');

                $doc = new KruDocument();
                $doc->kru_application_kru_id = $id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = $request->description;
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }

            $audit_details = json_encode([
                'path' => $path,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru02', 'editE', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru02', 'editE', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Dokumen gagal disimpan !!');
        }
        return redirect()->route('pembaharuankadpendaftarannelayan.permohonan.edit', $appKru->kru_application_id)->with('alert', 'Dokumen berjaya disimpan !!');
    }

    public function updateF(Request $request, string $id)
    {
        $selectedKrus = KruApplicationKru::where('kru_application_id',$id)->select('health_declaration')->get();
        if($selectedKrus->isEmpty()){
            return redirect()->back()->with('alert', 'Permohonan Perlu Minimun Seorang Kru Dipilih untuk Diperbaharui !!');
        }

        $allSelectedKrusHasHealthDeclaration = $selectedKrus->every(function ($kru) {
            return $kru['health_declaration'] !== null;
        });
        if(!$allSelectedKrusHasHealthDeclaration){
            return redirect()->back()->with('alert', 'Semua Kru Yang Dipilih Perlu Mengisi Perakuan Kesihatan !!');
        }


        DB::beginTransaction();

        try {
            $helper = new Helper();
            $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DIHANTAR');

            $app = KruApplication::find($id);
            $veselEntity = Vessel::find($app->vessel_id)->entity_id;

            $app->kru_application_status_id = $status_id;
            $app->entity_id = $veselEntity;
            if($app->submitted_at == null){
                $app->submitted_at = Carbon::now()->toDateTimeString();
            }
            if($app->reference_number == null){
                $refNum = new ReferenceNumber();
                $app->reference_number = $refNum->generateReferenceNumber($request->user()->id);
            }
            $app->updated_by = Auth::id();
            $app->save();
            
            $appLog = new KruApplicationLog();
            $appLog->kru_application_id =  $id;
            $appLog->kru_application_status_id = $status_id;
            $appLog->remark	= 'Pemohon';
            $appLog->created_by = Auth::id();
            $appLog->updated_by = Auth::id();
            $appLog->save();

            $audit_details = json_encode([
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru02', 'editF', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru02', 'editF', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal dihantar !!');
        }
        return redirect()->route('pembaharuankadpendaftarannelayan.permohonan.index')->with('alert', 'Permohonan berjaya dihantar !!');
    }
}
