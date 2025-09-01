<?php

namespace App\Http\Controllers\Kru\Kru01;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Helper;
use App\Models\Kru\KruApplication;
use App\Models\Kru\KruApplicationKru;
use App\Models\Kru\KruApplicationLog;
use App\Models\Kru\KruApplicationType;
use App\Models\Kru\KruDocument;
use App\Models\Kru\NelayanMarin;
use App\Models\Parliament;
use App\Models\ParliamentSeat;
use App\Models\ReferenceNumber;
use App\Models\Systems\AuditLog;
use App\Models\User;
use App\Models\Vessel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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

        $appTypeId = KruApplicationType::where('code','KRU01')->first()->id;
        $apps = KruApplication::leftJoin('vessels', 'kru_applications.vessel_id', '=', 'vessels.id')
        ->where('kru_application_type_id', $appTypeId)
        ->where('kru_applications.user_id',$request->user()->id)
        ->select('kru_applications.id','reference_number','no_pendaftaran','kru_applications.entity_id','kru_application_status_id','kru_applications.created_at')->sortable();

        return view('app.kru.kru01.index', [
            'applications' => $request->has('sort') ? $apps->paginate(10) : $apps->orderBy('kru_applications.created_at','DESC')->paginate(10),
            'statusDisimpanId' => $statusDisimpanId,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::find(Auth::id());
        $vessels = Vessel::where('user_id',$user->id)->orderBy('no_pendaftaran')->get();
        return view('app.kru.kru01.create', [
            'vessels' => $vessels,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $helper = new Helper();
        $request->validate(
        [
            'selVessel' => 'required',
            'icNum' => 'required|string|min:12|max:12',
        ],
        [
            'selVessel.required' => 'Vesel diperlukan.',
            'icNum.required' => 'No. Kad Pengenalan diperlukan.',
            'icNum.min' => 'No. Kad Pengenalan mestilah 12 digit.',
            'icNum.max' => 'No. Kad Pengenalan mestilah 12 digit.',
        ]);

        DB::beginTransaction();

        try {
            //Initiated required data
            $appType = KruApplicationType::where('code','KRU01')->first();
            $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DISIMPAN');

            //age validation
            $ic_first_6_digit = substr($request->icNum, 0, 6);
            $date = Carbon::createFromFormat('ymd', $ic_first_6_digit);
            $age = $date->age;
            if($age<18){
                return redirect()->back()->withInput()->with('alert', 'Kru yang berumur 18 tahun dan keatas sahaja boleh memohon untuk menjadi nelayan !!');
            }
            
            $app = new KruApplication();
            $app->kru_application_type_id = $appType->id;
            $app->user_id = $request->user()->id;
            $app->kru_application_status_id = $status_id;
            $app->vessel_id = $request->selVessel;

            //check if nelayan already applied
            $appliedNelayan = NelayanMarin::where('ic_number',$request->icNum)->first();
            if($appliedNelayan == null){
                $app->application_type = 'KRU BARU';
            }
            else{
                $app->application_type = 'GANTI KRU';
                if($appliedNelayan->vessel_id == $request->selVessel){
                    return redirect()->back()->withInput()->with('alert', 'Kru telah berada di atas vesel berkenaan !!');
                }
            }
            // $vessel_entity = Vessel::find($request->selVessel)->entity_id;
            $app->created_by = Auth::id();
            $app->updated_by = Auth::id();
            $app->save();

            $app2 = new KruApplicationKru();
            $app2->kru_application_id = $app->id;
            $app2->ic_number = $request->icNum;
            if($appliedNelayan == null){
            }
            else{
                $app->application_type = 'GANTI KRU';
                if($appliedNelayan->vessel_id == $request->selVessel){ // if exist on the selected vessel
                    return redirect()->back()->withInput()->with('alert', 'Kru telah berada di atas vesel berkenaan !!');
                }
                elseif($appliedNelayan->vessel_id != null){ // if exist on other vessel

                }
                else{ // if exist but not on any vessel
                    //name
                    $app2->name = strtoupper($appliedNelayan->name);
                    $app2->kru_position_id = $appliedNelayan->kru_position_id;
                    $app2->race_id = $appliedNelayan->race_id;
                    //address
                    $app2->address1 = strtoupper($appliedNelayan->address1);
                    $app2->address2 = strtoupper($appliedNelayan->address2);
                    $app2->address3 = strtoupper($appliedNelayan->address3);
                    $app2->postcode = $appliedNelayan->postcode;
                    $app2->city = strtoupper($appliedNelayan->city);
                    $app2->district_id = $appliedNelayan->district_id;
                    $app2->state_id = $appliedNelayan->state_id;
                    //contact
                    $app2->home_contact_number = $appliedNelayan->home_contact_number;
                    $app2->mobile_contact_number = $appliedNelayan->mobile_contact_number;
                    $app2->email = $appliedNelayan->email;
                }
            }
            $app2->created_by = Auth::id();
            $app2->updated_by = Auth::id();
            $app2->save();

            $audit_details = json_encode([
                'vessel_id' => $request->selVessel,
                'ic_number' => $request->icNum,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru01', 'create', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
                'vessel_id' => $request->selVessel,
                'ic_number' => $request->icNum,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru01', 'create', $audit_details, $e->getMessage());

            return redirect()->back()->withInput()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('kadpendaftarannelayan.permohonan.edit', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        $kru = KruApplicationKru::where('kru_application_id',$id)->first();

        $docs = KruDocument::where('kru_application_kru_id',$kru->id)->whereNotIn('description',KruDocument::DOC_PEGAWAI)->get();
        
        $statusDilulusId = $helper->getCodeMasterIdByTypeName('kru_application_status','DILULUS');
        $statusRejectedId = $helper->getCodeMasterIdByTypeName('kru_application_status','DITOLAK');
        $statusIncompleteId = $helper->getCodeMasterIdByTypeName('kru_application_status','TIDAK LENGKAP');
        $rejectedLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->where('kru_application_status_id',$statusRejectedId)->latest('updated_at')->first();
        $incompleteLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->where('kru_application_status_id',$statusIncompleteId)->latest('updated_at')->first();

        return view('app.kru.kru01.show', [
            'id' => $id,
            'app' => $app,
            'kru' => $kru,
            'docs' => $docs,
            'statusDilulusId' => $statusDilulusId,
            'statusRejectedId' => $statusRejectedId,
            'statusIncompleteId' => $statusIncompleteId,
            'rejectedLog' => $rejectedLog,
            'incompleteLog' => $incompleteLog,
        ]);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store2(Request $request)
    // {
    //     $helper = new Helper();
    //     $request->validate(
    //     [
    //         // 'selAppType' => 'required',
    //         'selVessel' => 'required',
    //         // 'selPosition' => 'required',
    //         // 'selRace' => 'required',
    //         // 'name' => 'required|string|max:255',
    //         'icNum' => 'required|string|min:12|max:12',
    //     ],
    //     [
    //         // 'selAppType.required' => 'Jenis Permohonan diperlukan.',
    //         'selVessel.required' => 'Vesel diperlukan.',
    //         // 'selPosition.required' => 'Jawatan diperlukan.',
    //         // 'name.required' => 'Nama diperlukan.',
    //         // 'race.required' => 'Bangsa diperlukan.',
    //         'icNum.required' => 'No. Kad Pengenalan diperlukan.',
    //         'icNum.min' => 'No. Kad Pengenalan mestilah 12 digit.',
    //         'icNum.max' => 'No. Kad Pengenalan mestilah 12 digit.',
    //     ]);
        
    //     // if($request->selPosition == $helper->getCodeMasterIdByTypeName('kru_position','PEMILIK VESEL')){
    //     //     $vessel = Vessel::find($request->selVessel);
    //     //     $vesselowner = User::find($vessel->user_id);
    //     //     if($vesselowner->username != $request->icNum){
    //     //         return redirect()->back()->withInput()->with('alert', 'No. Kad Pengenalan yang dimasukkan bukan No. Kad Pengenalan Pemilik Vesel !!');
    //     //     }
    //     // }
        
    //     //check if nelayan already applied
    //     $appliedNelayan = NelayanMarin::where('ic_number',$request->icNum)->first();
    //     if($appliedNelayan == null){

    //     }
    //     else{
            
    //     }

    //     if($request->selAppType == 'KRU BARU')
    //     {
    //         $request->validate(
    //         [
    //             'icNum' => 'unique:nelayan_marins,ic_number',
    //         ],
    //         [
    //             'icNum.unique' => 'No. Kad Pengenalan yang dimasukkan sudah pernah berdaftar sebagai nelayan. Sila pilih GANTI KRU untuk mendaftar nelayan sedia ada.',
    //         ]);
    //     }
    //     else{
    //         $request->validate(
    //         [
    //             'icNum' => 'exists:nelayan_marins,ic_number',
    //         ],
    //         [
    //             'icNum.exists' => 'No. Kad Pengenalan yang dimasukkan tidak pernah berdaftar sebagai nelayan. Sila pilih KRU BARU untuk mendaftar nelayan baru.',
    //         ]);

    //         $nelayan = NelayanMarin::where('ic_number',$request->icNum)->first();
    //         if($nelayan->vessel_id == $request->selVessel){
    //             return redirect()->back()->withInput()->with('alert', 'Kru telah berada di atas vesel berkenaan !!');
    //         }
    //     }

    //     $ic_first_6_digit = substr($request->icNum, 0, 6);
    //     $date = Carbon::createFromFormat('ymd', $ic_first_6_digit);
    //     $age = $date->age;
    //     if($age<18){
    //         return redirect()->back()->withInput()->with('alert', 'Kru yang berumur 18 tahun dan keatas sahaja boleh memohon untuk menjadi nelayan !!');
    //     }

    //     DB::beginTransaction();

    //     try {

    //         //Initiated required data
    //         $appType = KruApplicationType::where('code','KRU01')->first();
    //         $status_id = $helper->getCodeMasterIdByTypeName('kru_application_status','DISIMPAN');

    //         //get vessel's entity (pejabat perikanan daerah)
    //         $vessel_entity = Vessel::find($request->selVessel)->entity_id;

    //         //create new application
    //         $app = new KruApplication();
    //         $app->kru_application_type_id = $appType->id;
    //         $app->user_id = $request->user()->id;
    //         $app->kru_application_status_id = $status_id;
    //         $app->vessel_id = $request->selVessel;
    //         // $app->application_type = $request->selAppType;
    //         $app->created_by = Auth::id();
    //         $app->updated_by = Auth::id();
    //         $app->save();

    //         $app2 = new KruApplicationKru();
    //         $app2->kru_application_id = $app->id;
    //         // $app2->kru_position_id = $request->selPosition;
    //         // $app2->race_id = $request->selRace;
    //         $app2->ic_number = $request->icNum;
    //         // $app2->name = strtoupper($request->name);
    //         // if($request->selAppType == 'GANTI KRU'){
    //         //     $nelayan = NelayanMarin::where('ic_number',$request->icNum)->first();
    //         //     $app2->address1 = strtoupper($nelayan->address1);
    //         //     $app2->address2 = strtoupper($nelayan->address2);
    //         //     $app2->address3 = strtoupper($nelayan->address3);
    //         //     $app2->postcode = $nelayan->postcode;
    //         //     $app2->city = strtoupper($nelayan->city);
    //         //     $app2->district_id = $nelayan->district_id;
    //         //     $app2->state_id = $nelayan->state_id;
    //         //     $app2->home_contact_number = $nelayan->home_contact_number;
    //         //     $app2->mobile_contact_number = $nelayan->mobile_contact_number;
    //         //     $app2->email = $nelayan->email;
    //         // }
    //         $app2->created_by = Auth::id();
    //         $app2->updated_by = Auth::id();
    //         $app2->save();

    //         $audit_details = json_encode([
    //             // 'application_type' => $request->selAppType,
    //             'vessel_id' => $request->selVessel,
    //             // 'kru_position_id' => $request->selPosition,
    //             'ic_number' => $request->icNum,
    //             // 'name' => $request->name,
    //         ]);
    //         $auditLog = new AuditLog();
    //         $auditLog->log('kru01', 'create', $audit_details);
    //         DB::commit();
    //     }
    //     catch (Exception $e) {
    //         DB::rollback();
    //         $audit_details = json_encode([
    //             // 'application_type' => $request->selAppType,
    //             'vessel_id' => $request->selVessel,
    //             // 'kru_position_id' => $request->selPosition,
    //             'ic_number' => $request->icNum,
    //             // 'name' => $request->name,
    //         ]);

    //         $auditLog = new AuditLog();
    //         $auditLog->log('kru01', 'create', $audit_details, $e->getMessage());

    //         return redirect()->back()->withInput()->with('alert', 'Permohonan gagal disimpan !!');
    //     }
    //     return redirect()->route('kadpendaftarannelayan.permohonan.editB', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $helper = new Helper();
        $app = KruApplication::find($id);
        $kru = KruApplicationKru::where('kru_application_id',$id)->first();
        
        $isPemilik = false;
        $vessel = Vessel::find($app->vessel_id);
        $vesselowner = User::find($vessel->user_id);
        if($vesselowner->username == $kru->ic_number){
            $isPemilik = true;
        }
        
        $pemastautinTetapId = $helper->getCodeMasterIdByTypeName('kewarganegaraan_status','PEMASTAUTIN TETAP');
        $tiadaId = $helper->getCodeMasterIdByTypeName('bumiputera_status','TIADA');

        return view('app.kru.kru01.edit', [
            'id' => $id,
            'app' => $app,
            'kru' => $kru,
            //start dropdowns
            'kruPositions' => $helper->getCodeMastersByTypeOrder('kru_position'),
            'races' => $helper->getCodeMastersByTypeOrder('race')->whereNotIn('name_ms',['LAIN-LAIN']),
            'bumiputeraStatus' => $helper->getCodeMastersByTypeOrder('bumiputera_status'),
            'kewarganegaraanStatus' => $helper->getCodeMastersByTypeOrder('kewarganegaraan_status'),
            'isPemilik' => $isPemilik,
            'pemilikVeselId' => $helper->getCodeMasterIdByTypeName('kru_position','PEMILIK VESEL'),
            //end dropdowns
            'pemastautinTetapId' => $pemastautinTetapId,
            'tiadaId' => $tiadaId,
        ]);
    }

    public function editB(string $id)
    {
        $helper = new Helper();
        $kru = KruApplicationKru::where('kru_application_id',$id)->first();

        $districts = null;
        $parliaments = Parliament::orderBy('parliament_name')->select('id','parliament_name')->get();
        $duns = null;
        if($kru->state_id != null){
            $districts = CodeMaster::where('type','district')->where('parent_id',$kru->state_id)->orderBy('name')->select('id','name')->get();
            // $parliaments = Parliament::where('state_id',$kru->state_id)->orderBy('parliament_name')->select('id','parliament_name')->get();
        }
        if($kru->parliament_id != null){
            $duns = ParliamentSeat::where('parliament_id',$kru->parliament_id)->orderBy('parliament_seat_name')->select('id','parliament_seat_name')->get();
        }

        $warganegaraId = $helper->getCodeMasterIdByTypeName('kewarganegaraan_status','WARGANEGARA');
        return view('app.kru.kru01.editB', [
            'id' => $id,
            'kru' => $kru,
            'states' => $helper->getCodeMastersByType('state'),
            'districts' => $districts,
            'parliaments' => $parliaments,
            'duns' => $duns,
            // 'wilayahIds' => $wilayahIds,
            'warganegaraId' => $warganegaraId,
        ]);
    }

    public function editC(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        $kru = KruApplicationKru::where('kru_application_id',$id)->first();

        return view('app.kru.kru01.editC', [
            'id' => $id,
            'kru' => $kru,
        ]);
    }

    public function editD(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);
        $kru = KruApplicationKru::where('kru_application_id',$id)->first();
        $docIc = KruDocument::where('kru_application_kru_id',$kru->id)->where('description',KruDocument::DOC_IC)->latest()->first();
        $docPic = KruDocument::where('kru_application_kru_id',$kru->id)->where('description',KruDocument::DOC_PIC)->latest()->first();
        $docPKN = KruDocument::where('kru_application_kru_id',$kru->id)->where('description',KruDocument::DOC_PKN)->latest()->first();
        $docKWSP = KruDocument::where('kru_application_kru_id',$kru->id)->where('description',KruDocument::DOC_KWSP)->latest()->first();
        $docExtra = KruDocument::where('kru_application_kru_id',$kru->id)->whereNotIn('description',KruDocument::DOC_ALL)->latest()->get();
// dd($docExtra);
        return view('app.kru.kru01.editD', [
            'id' => $id,
            'kru' => $kru,
            'docIc' => $docIc,
            'docPic' => $docPic,
            'docPKN' => $docPKN,
            'docKWSP' => $docKWSP,
            'docExtra' => $docExtra,
        ]);
    }

    public function editE(string $id)
    {
        $helper = new Helper();
        $user = User::find(Auth::id());
        $app = KruApplication::find($id);

        return view('app.kru.kru01.editE', [
            'id' => $id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $helper = new Helper();
        DB::beginTransaction();

        try {

            $app = KruApplication::find($id);
            $app->updated_by = Auth::id();
            $app->save();

            $app2 = KruApplicationKru::where('kru_application_id',$id)->first();
            $app2->kru_position_id = $request->selPosition;
            $app2->name = strtoupper($request->name);
            $app2->race_id = $request->selRace;
            $app2->bumiputera_status_id = $request->selBumi;
            $app2->kewarganegaraan_status_id = $request->selWarganegara;
            $app2->updated_by = Auth::id();
            $app2->save();

            $audit_details = json_encode([
                'id' => $id,
                'kru_position_id' => $request->selPosition,
                'name' => $request->name,
                'race_id' => $request->selRace,
                'bumiputera_status_id' => $request->selBumi,
                'kewarganegaraan_status_id' => $request->selWarganegara,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru01', 'edit', $audit_details);
            DB::commit();
            return redirect()->route('kadpendaftarannelayan.permohonan.editB', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
                'id' => $id,
                'kru_position_id' => $request->selPosition,
                'name' => $request->name,
                'race_id' => $request->selRace,
                'bumiputera_status_id' => $request->selBumi,
                'kewarganegaraan_status_id' => $request->selWarganegara,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru01', 'edit', $audit_details, $e->getMessage());
            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
    }

    public function updateB(Request $request, string $id)
    {
        $helper = new Helper();
        DB::beginTransaction();

        try {
            $app = KruApplication::find($id);
            $app->updated_by = Auth::id();
            $app->save();

            $app2 = KruApplicationKru::where('kru_application_id',$id)->first();
            $app2->address1 = strtoupper($request->address1);
            $app2->address2 = strtoupper($request->address2);
            $app2->address3 = strtoupper($request->address3);
            $app2->postcode = $request->postcode;
            if($request->city != null)
                $app2->city = strtoupper($request->city);
            else
                $app2->city = strtoupper($helper->getCodeMasterNameById($request->selDistrict));
            $app2->district_id = $request->selDistrict;
            $app2->state_id = $request->selState;
            $app2->parliament_id = $request->selParliament;
            $app2->parliament_seat_id = $request->selDun;
            $app2->updated_by = Auth::id();
            $app2->save();

            $audit_details = json_encode([
                'address1' => $request->address1,
                'address2' => $request->address2,
                'address3' => $request->address3,
                'postcode' => $request->postcode,
                'city' => $request->city,
                'district_id' => $request->selDistrict,
                'state_id' => $request->selState,
                'parliament_id' => $request->selParliament,
                'parliament_seat_id' => $request->selDun,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru01', 'editB', $audit_details);
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
                'parliament_id' => $request->selParliament,
                'parliament_seat_id' => $request->selDun,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru01', 'editB', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('kadpendaftarannelayan.permohonan.editC', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    public function updateC(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $app = KruApplication::find($id);
            $app->updated_by = Auth::id();
            $app->save();

            $app2 = KruApplicationKru::where('kru_application_id',$id)->first();
            $app2->mobile_contact_number = $request->mobilePhoneNumber;
            $app2->home_contact_number = $request->homePhoneNumber;
            $app2->email = $request->email;
            $app2->updated_by = Auth::id();
            $app2->save();

            $audit_details = json_encode([
                'mobile_contact_number' => $request->mobilePhoneNumber,
                'home_contact_number' => $request->homePhoneNumber,
                'email' => $request->email,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru01', 'editC', $audit_details);
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
            $auditLog->log('kru01', 'editC', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal disimpan !!');
        }
        return redirect()->route('kadpendaftarannelayan.permohonan.editD', $app->id)->with('alert', 'Permohonan berjaya disimpan !!');
    }

    public function updateDAddDoc(Request $request, string $id)
    {
        $request->validate(
        [
            'kruPic' => 'mimes:jpg,jpeg,png',
        ],
        [
            'kruPic.mimes' => 'Jenis file dibenarkan adalah jpg,jpeg,bmp.',
        ]);

        DB::beginTransaction();

        try {
            $app = KruApplication::find($id);
            $app->updated_by = Auth::id();
            $app->save();
            
            $appKru = KruApplicationKru::where('kru_application_id',$id)->first();
            $appKru->updated_by = Auth::id();
            $appKru->save();

            $path='';
            if ($request->file('kadPengenalanDoc')) {

                $file = $request->file('kadPengenalanDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('kadPengenalanDoc')->store('public/kru/krudoc');

                $doc = new KruDocument();
                $doc->kru_application_kru_id = $appKru->id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = KruDocument::DOC_IC;
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }
            if ($request->file('kruPic')) {

                $file = $request->file('kruPic');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('kruPic')->store('public/kru/krudoc');
                
                // Crop image
                // create image manager with desired driver
                // $manager = new ImageManager(
                //     new Driver()
                // );
                // $img = ImageManager::make(storage_path('app/public/application/profile-picture/.original/'.$profilePictureName));
                // $width = $img->width();
                // $height = $img->height();
                // $path = public_path('storage/application/profile-picture/'.$profilePictureName);
                
                // $img = ImageManager::make(storage_path('app/public/application/profile-picture/.original/'.$profilePictureName));
                // $width = $img->width();
                // $height = $img->height();
                // $path = public_path('storage/application/profile-picture/'.$profilePictureName);

                // //$img->crop($request->input('w'), $request->input('h'), $request->input('x1'), $request->input('y1'));
                // if ($width > 800 && $height > 800) {
                //     $img->orientate()->fit(800);
                // }
                // else {
                //     if ($width > $height) {
                //         $img->orientate()->fit($height);
                //     }
                //     else {
                //         $img->orientate()->fit($width);
                //     }
                // }
                // $img->save($path);

                $doc = new KruDocument();
                $doc->kru_application_kru_id = $appKru->id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = KruDocument::DOC_PIC;
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }
            if ($request->file('kesihatanNelayan')) {

                $file = $request->file('kesihatanNelayan');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('kesihatanNelayan')->store('public/kru/krudoc');

                $doc = new KruDocument();
                $doc->kru_application_kru_id = $appKru->id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = KruDocument::DOC_PKN;
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }
            if ($request->file('kwsp')) {

                $file = $request->file('kwsp');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('kwsp')->store('public/kru/krudoc');

                $doc = new KruDocument();
                $doc->kru_application_kru_id = $appKru->id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = KruDocument::DOC_KWSP;
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }
            if ($request->file('extraDoc')) {
                if($request->description == null){
                    return redirect()->back()->with('alert', 'Dokumen Tambahan Perlu Keterangan !!');
                }

                $file = $request->file('extraDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;
                $path = $request->file('extraDoc')->store('public/kru/krudoc');

                $doc = new KruDocument();
                $doc->kru_application_kru_id = $appKru->id;
                $doc->file_name = $filename;
                $doc->file_path = $path;
                $doc->description = strtoupper($request->description);
				$doc->created_by = $request->user()->id;
                $doc->updated_by = $request->user()->id;
                $doc->save();
            }

            $audit_details = json_encode([
                'path' => $path,
            ]);
            $auditLog = new AuditLog();
            $auditLog->log('kru01', 'editD', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru01', 'editD', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Dokumen gagal disimpan !!');
        }
        return redirect()->route('kadpendaftarannelayan.permohonan.editE', $app->id)->with('alert', 'Dokumen berjaya disimpan !!');
    }

    public function updateE(Request $request, string $id)
    {
        $appKru = KruApplicationKru::where('kru_application_id',$id)->first();
        $appKru->updated_by = Auth::id();
        $appKru->save();

        $docs = KruDocument::where('kru_application_kru_id',$appKru->id)->get();
        if(!$docs->contains('description', KruDocument::DOC_IC)){
            return redirect()->back()->with('alert', 'Perlukan Dokumen SALINAN KAD PENGENALAN!!');
        }
        elseif(!$docs->contains('description', KruDocument::DOC_PIC)){
            return redirect()->back()->with('alert', 'Perlukan Dokumen GAMBAR KRU!!');
        }
        elseif(!$docs->contains('description', KruDocument::DOC_PKN)){
            return redirect()->back()->with('alert', 'Perlukan Dokumen PEMERIKSAAN KESIHATAN NELAYAN!!');
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
            $auditLog->log('kru01', 'editE', $audit_details);
            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();
            $audit_details = json_encode([
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('kru01', 'editE', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Permohonan gagal dihantar !!');
        }
        return redirect()->route('kadpendaftarannelayan.permohonan.index')->with('alert', 'Permohonan berjaya dihantar !!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
