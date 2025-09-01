<?php

namespace App\Http\Controllers\Kru\Kru03;

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

        $appTypeId = KruApplicationType::where('code','KRU03')->first()->id;
        $apps = KruApplication::leftJoin('vessels', 'kru_applications.vessel_id', '=', 'vessels.id')
        ->where('kru_application_type_id', $appTypeId)
        ->where('kru_applications.user_id',$request->user()->id)
        ->select('kru_applications.id','reference_number','no_pendaftaran','kru_applications.entity_id','kru_application_status_id','kru_applications.created_at')->sortable();

        return view('app.kru.kru03.index', [
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
        $vessels = Vessel::where('user_id',$user->id)->orderBy('no_pendaftaran')->get();

        return view('app.kru.kru03.create', [
            'vessels' => $vessels,
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
            $appType = KruApplicationType::where('code','KRU03')->first();
            $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DISIMPAN');

            //get vessel's entity (pejabat perikanan daerah)
            $vessel_entity = Vessel::find($request->selVessel)->entity_id;

            //create new application
            $app = new KruApplication();
            $app->kru_application_type_id = $appType->id;
            $app->user_id = $request->user()->id;
            $app->kru_application_status_id = $status_id;
            $app->vessel_id = $request->selVessel;
            $app->entity_id = $vessel_entity;
            $app->created_by = Auth::id();
            $app->updated_by = Auth::id();
            $app->save();


            $audit_details = json_encode([
                'vessel_id' => $request->selVessel,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru03', 'create', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
                'vessel_id' => $request->selVessel,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru03', 'create', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('gantiankadpendaftarannelayan.permohonan.edit', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        $vesel = Vessel::withTrashed()->find($app->vessel_id);
        $selectedKru = KruApplicationKru::where('kru_application_id',$id)->latest()->first();

        $docs = KruDocument::where('kru_application_kru_id',$selectedKru->id)->get();
        
        $statusDilulusId = $helper->getCodeMasterIdByTypeName('kru_application_status','DILULUS');
        $statusRejectedId = $helper->getCodeMasterIdByTypeName('kru_application_status','DITOLAK');
        $statusIncompleteId = $helper->getCodeMasterIdByTypeName('kru_application_status','TIDAK LENGKAP');
        $rejectedLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->where('kru_application_status_id',$statusRejectedId)->latest('updated_at')->first();
        $incompleteLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->where('kru_application_status_id',$statusIncompleteId)->latest('updated_at')->first();

        return view('app.kru.kru03.show', [
            'id' => $id,
            'app' => $app,
            'vesel' => $vesel,
            'selectedKru' => $selectedKru,
            'docs' => $docs,
            'statusDilulusId' => $statusDilulusId,
            'statusRejectedId' => $statusRejectedId,
            'statusIncompleteId' => $statusIncompleteId,
            'rejectedLog' => $rejectedLog,
            'incompleteLog' => $incompleteLog,
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
        $kru = KruApplicationKru::where('kru_application_id',$id)->first();
        $vessel = Vessel::find($app->vessel_id);
        $nelayanMarin = NelayanMarin::where('vessel_id',$vessel->id)->get();
        $selectedKru = KruApplicationKru::where('kru_application_id',$id)->select('ic_number')->latest()->first();

        return view('app.kru.kru03.edit', [
            'id' => $id,
            'app' => $app,
            'kru' => $kru,
            'vessel' => $vessel,
            'krus' => $nelayanMarin,
            'selectedKru' => $selectedKru
        ]);
    }

    public function editB(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        $appKru = KruApplicationKru::where('kru_application_id',$id)->latest()->first();
        
        $districts = null;
        if($appKru->state_id != null){
            $districts = CodeMaster::where('type','district')->where('parent_id',$appKru->state_id)->orderBy('name')->select('id','name')->get();
        }

        return view('app.kru.kru03.editB', [
            'id' => $id,
            'appKru' => $appKru,
            'states' => $helper->getCodeMastersByType('state'),
            'districts' => $districts,
        ]);
    }

    public function editC(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        // $app2 = Kru01Application::where('kru_application_id',$id)->first();
        $appKru = KruApplicationKru::where('kru_application_id',$id)->latest()->first();

        return view('app.kru.kru03.editC', [
            'id' => $id,
            // 'app2' => $app2,
            'appKru' => $appKru,
        ]);
    }

    public function editD(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        $selectedKru = KruApplicationKru::where('kru_application_id',$id)->latest()->first();
        // dd($selectedKru);
        $policeReportDoc = KruDocument::where('kru_application_kru_id',$selectedKru->id)->where('description','LAPORAN POLIS')->latest()->first();
        $kpnDoc = KruDocument::where('kru_application_kru_id',$selectedKru->id)->where('description','GAMBAR KAD PENDAFTARAN NELAYAN')->latest()->first();
        // $extraDoc = KruDocument::where('kru_application_kru_id',$id)->whereNotIn('description',['SALINAN KAD PENGENALAN','GAMBAR KRU','PEMERIKSAAN KESIHATAN NELAYAN'])->latest()->first();

        return view('app.kru.kru03.editD', [
            'id' => $id,
            'app' => $app,
            'selectedKru' => $selectedKru,
            'policeReportDoc' => $policeReportDoc,
            'kpnDoc' => $kpnDoc,
            // 'extraDoc' => $extraDoc,
        ]);
    }

    public function editE(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        $selectedKru = KruApplicationKru::where('kru_application_id',$id)->latest()->first();

        return view('app.kru.kru03.editE', [
            'id' => $id,
            'selectedKru' => $selectedKru,
        ]);
    }

    // public function editDAddDoc(string $id)
    // {
    //     $helper = new Helper();
    //     $user = User::find(Auth::id());
    //     $app = KruApplication::find($id);
    //     $app2 = Kru01Application::where('kru_application_id',$id)->first();
    //     $documents = KruApplicationDocument::where('kru_application_id',$id)->get();

    //     return view('app.kru.kru01.editDAddDoc', [
    //         'id' => $id,
    //         'documents' => $documents,
    //     ]);
    // }

    // public function editE(string $id)
    // {
    //     $helper = new Helper();
    //     $user = User::find(Auth::id());
    //     $app = KruApplication::find($id);
    //     $app2 = Kru01Application::where('kru_application_id',$id)->first();

    //     return view('app.kru.kru01.editE', [
    //         'id' => $id,
    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $app = KruApplication::find($id);
            $app->application_type = $request->selReason;
            $app->updated_by = Auth::id();
            $app->save();

            //delete already selected kru from before if any
            $appKrus = KruApplicationKru::where('kru_application_id',$id)->get();
            // if(!$appKrus->isEmpty()){
                foreach ($appKrus as $appKru) {
                    $appKru->deleted_by = Auth::id();
                    $appKru->save();
                    $appKru->delete();
                }
            // }

            //add selected kru
            $selKru = $request->selKru;
            $nelayan = NelayanMarin::find($selKru);

            //search if there are any deleted kru
            $appKru = KruApplicationKru::withTrashed()->where('kru_application_id',$app->id)->where('ic_number',$nelayan->ic_number)->first();
            if($appKru==null){
                $appKru = new KruApplicationKru();
                $appKru->kru_application_id = $app->id;
                $appKru->ic_number = $nelayan->ic_number;
                $appKru->name = $nelayan->name;
                $appKru->kru_position_id = $nelayan->kru_position_id;
                $appKru->kru_position_id = $nelayan->kru_position_id;
                $appKru->kewarganegaraan_status_id = $nelayan->kewarganegaraan_status_id;

                $appKru->race_id = $nelayan->race_id;
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

            $audit_details = json_encode([
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru03', 'edit', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru03', 'edit', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('gantiankadpendaftarannelayan.permohonan.editB', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
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
        return redirect()->route('gantiankadpendaftarannelayan.permohonan.editC', $appKru->kru_application_id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    public function updateC(Request $request, string $id)
    {
        DB::beginTransaction();

        $appKru = null;
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
        return redirect()->route('gantiankadpendaftarannelayan.permohonan.editD', $appKru->kru_application_id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    public function updateD(Request $request, string $id)
    {
        $request->validate(
        [
            'kruPic' => 'mimes:jpg,bmp,png',
        ],
        [
            'kruPic.mimes' => 'Jenis file dibenarkan adalah jpg,png,bmp.',
        ]);

        DB::beginTransaction();

        $appKru = null;
        try {
            $appKru = KruApplicationKru::find($id);
            $appKru->updated_by = Auth::id();
            $appKru->save();
            
            $app = KruApplication::find($appKru->kru_application_id);
            $app->updated_by = Auth::id();
            $app->save();

            $path='';
            if ($request->file('policeReportDoc')) {

                $file = $request->file('policeReportDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('policeReportDoc')->store('public/kru/krudoc');

                $doc = new KruDocument();
                $doc->kru_application_kru_id = $id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = 'LAPORAN POLIS';
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }
            if ($request->file('kpnDoc')) {

                $file = $request->file('kpnDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('kpnDoc')->store('public/kru/krudoc');

                $doc = new KruDocument();
                $doc->kru_application_kru_id = $id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = 'GAMBAR KAD PENDAFTARAN NELAYAN';
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }

            $audit_details = json_encode([
                // 'path' => $path,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru03', 'editD', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru03', 'editD', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Dokumen gagal disimpan !!');
        }
        // $app = KruApplication::find($appKru->kru_application_id);
        return redirect()->route('gantiankadpendaftarannelayan.permohonan.editE', $appKru->kru_application_id)->with('alert', 'Dokumen berjaya disimpan !!');
    }

    public function updateE(Request $request, string $id)
    {
        // $docs = KruApplicationDocument::where('kru_application_id',$id)->get();
        // if(!$docs->contains('description', 'SALINAN KAD PENGENALAN')){
        //     return redirect()->back()->with('alert', 'Perlukan Dokumen SALINAN KAD PENGENALAN!!');
        // }
        // elseif(!$docs->contains('description', 'GAMBAR KRU')){
        //     return redirect()->back()->with('alert', 'Perlukan Dokumen GAMBAR KRU!!');
        // }
        // elseif(!$docs->contains('description', 'PEMERIKSAAN KESIHATAN NELAYAN')){
        //     return redirect()->back()->with('alert', 'Perlukan Dokumen PEMERIKSAAN KESIHATAN NELAYAN!!');
        // }

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
            $auditLog->log('kru03', 'editE', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru03', 'editE', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal dihantar !!');
        }
        return redirect()->route('gantiankadpendaftarannelayan.permohonan.index')->with('alert', 'Permohonan berjaya dihantar !!');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
