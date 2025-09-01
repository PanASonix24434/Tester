<?php

namespace App\Http\Controllers\Kru\CrewVessel;

use App\Http\Controllers\Controller;
use App\Models\Entity;
use App\Models\Helper;
use App\Models\Kru\ForeignCrew;
use App\Models\Kru\ImmigrationOffice;
use App\Models\Kru\KruApplication;
use App\Models\Kru\KruApplicationForeign;
use App\Models\Kru\KruApplicationForeignKru;
use App\Models\Kru\KruApplicationKru;
use App\Models\Kru\KruDocument;
use App\Models\Kru\NelayanMarin;
use App\Models\Systems\AuditLog;
use App\Models\User;
use App\Models\Vessel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;

class CrewVesselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('crewvessel');

        $helper = new Helper();

        //all vessel id under user 
        $vesselIds = Vessel::where('user_id',Auth::id())->select('id')->get()->pluck('id')->toArray();

        $warganegaraId = $helper->getCodeMasterIdByTypeName('kewarganegaraan_status','WARGANEGARA');
        $pemastautinId = $helper->getCodeMasterIdByTypeName('kewarganegaraan_status','PEMASTAUTIN TETAP');

        // dd($warganegaraId,$pemastautinId);
        
        $localCrew = NelayanMarin::query()->select('id', 'ic_number as identity_no', 'name', 'vessel_id',
            // DB::raw("'Tempatan' as crew_type")
            DB::raw('(
                CASE WHEN kewarganegaraan_status_id = "'.$warganegaraId.'" THEN "Tempatan"
                WHEN kewarganegaraan_status_id = "'.$pemastautinId.'" THEN "Pemastautin"
                ELSE "-" END) AS crew_type')
            // DB::raw("(CASE
            //     WHEN kewarganegaraan_status_id = '?' THEN 'Tempatan'
            //     WHEN kewarganegaraan_status_id = '?' THEN 'Pemastautin'
            //     ELSE 'null'dd
            // END) as crew_type", [$warganegaraId, $pemastautinId])
        );
        $foreignCrew = ForeignCrew::query()->select('id', 'passport_number as identity_no', 'name', 'vessel_id',
            DB::raw("'Asing' as crew_type")
        );

        //Filter Vessel
        $filterVessel = !empty($request->selVessel) ? $request->selVessel : '';
        if (!empty($filterVessel)) {
            $localCrew->where('vessel_id',$filterVessel);
            $foreignCrew->where('vessel_id',$filterVessel);
        }
        else{
            $localCrew->whereIn('vessel_id',$vesselIds);
            $foreignCrew->whereIn('vessel_id',$vesselIds);
        }

        $crews = $localCrew->unionAll($foreignCrew);

        return view('app.kru.crewvessel.index', [
            'userId' => Auth::id(),
            'crews' => $crews->orderBy('name','DESC')->paginate(10),

            //filter dropdowns
            'vessels' 	=> Vessel::where('user_id',Auth::id())->select('id','no_pendaftaran','peralatan_utama','grt')->orderBy('no_pendaftaran')->get(),

            //filter
            'filterVessel' => $filterVessel,

            //others
            'warganegaraId' => $warganegaraId,
            'pemastautinId' => $pemastautinId,

        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $type, string $id)
    {
        $helper = new Helper();

        DB::beginTransaction();
        try{
            if($type == 'Tempatan' || $type == 'Pemastautin'){
                $nelayan = NelayanMarin::find($id);
                // $kru = KruApplicationKru::where('kru_application_id',$nelayan)->first();
        
                // $docs = KruDocument::where('kru_application_kru_id',$kru->id)->get();
                
                // $statusDilulusId = $helper->getCodeMasterIdByTypeName('kru_application_status','DILULUS');
                // $statusRejectedId = $helper->getCodeMasterIdByTypeName('kru_application_status','DITOLAK');
                // $statusIncompleteId = $helper->getCodeMasterIdByTypeName('kru_application_status','TIDAK LENGKAP');
                // $rejectedLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->where('kru_application_status_id',$statusRejectedId)->latest('updated_at')->first();
                // $incompleteLog = KruApplicationLog::where('kru_application_id',$id)->where('is_editing',false)->where('kru_application_status_id',$statusIncompleteId)->latest('updated_at')->first();
        
                DB::commit();
                return view('app.kru.crewvessel.showwarganegara', [
                    'id' => $id,
                    'nelayan' => $nelayan,
                    // 'app' => $app,
                    // 'kru' => $kru,
                    'docs' => collect(),

                    // 'statusDilulusId' => $statusDilulusId,
                    // 'statusRejectedId' => $statusRejectedId,
                    // 'statusIncompleteId' => $statusIncompleteId,
                    // 'rejectedLog' => $rejectedLog,
                    // 'incompleteLog' => $incompleteLog,
                ]);

            }
            elseif($type == 'Asing'){
                DB::commit();

            }
            else{
                DB::commit();
                return redirect()->back()->with('alert', 'Jenis Kru Tidak Dapat Dipastikan !!');
            }
        }
        catch(Exception $e){
            DB::rollback();
            $audit_details = json_encode([
                'crew_type' => $type,
                'id' => $id,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('CrewVessel', 'show', $audit_details, $e->getMessage());

            return redirect()->back()->with('alert', 'Maklumat gagal dipaparkan !!');
        }
    }
    
    //Export approval letter PDF
    public function exportApprovalLetter(Request $request, $id) 
    {
        // $app = KruApplication::find($id);
        // $appForeign = KruApplicationForeign::where('kru_application_id',$id)->first();
        // $vessel = Vessel::find($app->vessel_id);
        // $foreignKrus = KruApplicationForeignKru::where('kru_application_id',$id)->where('selected_for_approval',true)->get();
        

        $owner = User::find(Auth::id());
        $allVessel = Vessel::where('user_id',$owner->id)->get();
        $vesselIds = Vessel::where('user_id',$owner->id)->select('id')->get()->pluck('id')->toArray();
        $foreignCrews = ForeignCrew::whereIn('vessel_id',$vesselIds)->get();

        $data = [
            // 'immigrationOffice' => ImmigrationOffice::find($appForeign->immigration_office_id)->name,
            'owner' => $owner->name,

            // 'vessel' => $vessel,
            'foreignCrews' => $foreignCrews,
            // 'foreignCrews' => $foreignKrus,

            // 'immigrationDate' => optional($appForeign->immigration_date)->format('d-m-Y'),
            // 'immigrationGate' => strtoupper($appForeign->immigration_gate),
            // 'entity' => Entity::find($app->entity_id),

            'allVessel' => $allVessel,
        ];

        $pdf = Pdf::loadView('app.kru.crewvessel.approvalletterpdf', $data);
        $pdf->setPaper('letter');//setPaper('A4', 'portrait');
        $pdf->getDomPDF()->set_option('enable_php', true);

        // View on page
        return $pdf->stream('suratkelulusan.pdf');
    }
}
