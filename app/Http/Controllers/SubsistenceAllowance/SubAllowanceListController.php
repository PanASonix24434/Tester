<?php

namespace App\Http\Controllers\SubsistenceAllowance;
use Illuminate\Http\Request;


use App\Models\SubsistenceAllowance\SubApplication;
use App\Models\SubsistenceAllowance\SubsistenceDocuments;
use App\Models\SubsistenceAllowance\SubsistenceAuditLogStatus;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Exception;
use Helper;
use App\Models\CodeMaster;
use App\Models\LandingDeclaration\LandingDeclarationMonthly;

class SubAllowanceListController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $subApplication = SubApplication::where('type_registration', ['Baru', 'Rayuan'])->where('entity_id',$user->entity_id)->whereIn('sub_application_status', ['Permohonan Dihantar','Permohonan Dihantar Semula','Permohonan Disemak KDP (TIDAK LENGKAP)']);
        $filterName = !empty($request->txtName) ? $request->txtName : '';
        $filterNoFail = !empty($request->txtNoFail) ? $request->txtNoFail : '';
        $filterNoKP = !empty($request->txtNoKP) ? $request->txtNoKP : '';
        
        if(!empty($filterName)){

            $subApplication->where('fullname', 'like', '%'.$filterName.'%');
        }

        if (!empty($filterNoFail)) {
            $subApplication->where('registration_no', 'like', '%'.$filterNoFail.'%');
        }

        if (!empty($filterNoKP )) {
            $subApplication->where('icno', 'like', '%'.$filterNoKP .'%');
        }

        return view('app.subsistence_allowance.listapp.index', [
            'q' => '',
            'subApplication' => $request->has('sort') ? $subApplication->paginate(10) : $subApplication->orderBy('created_at')->paginate(10),
            // 'filterNoAccount' => !empty($filterNoAccount) ? $filterNoAccount : '',
            'filterName' => !empty($filterName) ? $filterName : '',
            'filterNoFail' => !empty($filterNoFail) ? $filterNoFail : '',
            'filterNoKP' => !empty($filterNoKP ) ? $filterNoKP  : '',
        ]);
    }

    public function show($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();
        $docs = SubsistenceDocuments::where('subsistence_application_id', $id)->get();
        $logs = SubsistenceAuditLogStatus::where('subsistence_application_id', $id)
        ->leftJoin('users', 'subsistence_audit_log_status.created_by', '=', 'users.id')
        ->select('subsistence_audit_log_status.*','users.name')
        ->orderBy('updated_at','ASC')->get();

        $approvedId = Helper::getCodeMasterIdByTypeName('landing_status','DISAHKAN DAERAH');
        $landings = LandingDeclarationMonthly::where('user_id',$subApplication->user_id)->where('landing_status_id',$approvedId)->orderBy('year','desc')->orderBy('month','desc')->get();//->take(3)
        
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

        return view('app.subsistence_allowance.listapp.show', [
            'subApplication' => $subApplication,
            'docs' => $docs,
            'logs' => $logs,
            'landings' => $landings,
            //------------start logs----------------
            'logs' => $logs,
            'redStatusIds' => $redStatusIds,
            'orangeStatusIds' => $orangeStatusIds,
            // 'savedLog' => $savedLog,
            //-------------end logs----------------
        ]);
    }

    // public function verifyDoc(Request $request)
    // {
    //     // Find the document
    //     $document = SubsistenceDocuments::findOrFail($request->document_id);

    //     // Update the verification status
    //     $document->status = $request->status; // Either 'verified' or 'rejected'
    //     $document->verified_by = Auth::user()->id; // Save user who verified
    //     $document->verified_at = now(); // Save timestamp
    //     $document->save();

    //     // Redirect back with success message
    //     return back()->with('success', 'Status dokumen berjaya dikemaskini!');
    // }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $subApplication= SubApplication::where('id',  $request->application_id)->first();

            if($request->dokumen == "lengkap"){
                $subApplication->status_checked = 'Permohonan Disemak (LENGKAP)';
                $subApplication->checked_remarks = $request->ulasan ?? '';
                $subApplication->checked_by = Auth::user()->id;
                $subApplication->sub_application_status = 'Permohonan Disemak (LENGKAP)';

                //save in log audit status
                $subAuditLog = new SubsistenceAuditLogStatus;
                $subAuditLog->subsistence_application_id =  $request->application_id;
                $subAuditLog->status = 'Permohonan Disemak (LENGKAP)';
                $subAuditLog->remark = $request->ulasan ?? '';
                $subAuditLog->created_by = Auth::user()->id;
                $subAuditLog->save();
            }
            else if($request->dokumen == "tidak_lengkap"){
                $subApplication->status_checked = 'Permohonan Disemak (TIDAK LENGKAP)';
                $subApplication->checked_remarks = $request->ulasan ?? '';
                $subApplication->checked_by = Auth::user()->id;
                $subApplication->sub_application_status = 'Permohonan Disemak (TIDAK LENGKAP)';

                //save in log audit status
                $subAuditLog = new SubsistenceAuditLogStatus;
                $subAuditLog->subsistence_application_id =  $request->application_id;
                $subAuditLog->status = 'Permohonan Disemak (TIDAK LENGKAP)';
                $subAuditLog->remark = $request->ulasan ?? '';
                $subAuditLog->created_by = Auth::user()->id;
                $subAuditLog->save();
            }

            $subApplication->save(); // This will insert a new record

            return redirect()->route('subsistence-allowance.list-application.index')->with('alert', 'Permohonan Berjaya Dihantar !!');
        }catch(Exception $e){
            return  redirect()->back()->with('alert', 'Maklumat Gagal Dihantar !!');
        }
    }
}
