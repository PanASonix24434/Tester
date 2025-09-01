<?php

namespace App\Http\Controllers\SubsistenceAllowance;
use Illuminate\Http\Request;


use App\Models\SubsistenceAllowance\SubApplication;
use App\Models\SubsistenceAllowance\SubsistenceDocuments;
use App\Models\SubsistenceAllowance\SubsistenceAuditlogStatus;

use App\Http\Controllers\Controller;
use App\Models\User;
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
use App\Models\LandingDeclaration\LandingDeclarationMonthly;

class SubAllowanceListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    

    public function formlistApp(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $subApplication = SubApplication::where('type_registration', ['Baru', 'Rayuan'])->where('entity_id',$user->entity_id)->whereNotIn('sub_application_status', ['Permohonan Disimpan', 'Permohonan Rayuan Dihantar']);

        $filterNoAccount = !empty($request->txtNoAccount) ? $request->txtNoAccount : '';
        $filterName = !empty($request->txtName) ? $request->txtName : '';
        $filterNoFail = !empty($request->txtNoFail) ? $request->txtNoFail : '';
        $filterNoKP = !empty($request->txtNoKP) ? $request->txtNoKP : '';

        if(!empty($filterNoAccount)){
            
            $subApplication->where('no_account', 'like', '%'.$filterNoAccount.'%');
        }

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
            'filterNoAccount' => !empty($filterNoAccount) ? $filterNoAccount : '',
            'filterName' => !empty($filterName) ? $filterName : '',
            'filterNoFail' => !empty($filterNoFail) ? $filterNoFail : '',
            'filterNoKP' => !empty($filterNoKP ) ? $filterNoKP  : '',
		]);
    }

    public function details($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance.listapp.edit', [	
            'subApplication' => $subApplication,	
            'states' => Helper::getCodeMastersByType('state'),
            'bank' => Helper::getCodeMastersByType('bank'),
			
		]);
    }

    public function detailswork($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance.listapp.editwork', [		
			'subApplication' => $subApplication,	
		]);
    }

    public function detailsdependent($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance.listapp.editdependent', [		
			'subApplication' => $subApplication,	
		]);
    }

    public function detailseducation($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        return view('app.subsistence_allowance.listapp.editeducation', [		
			'subApplication' => $subApplication,	
		]);
    }

    public function detailsdoc($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        $doc = SubsistenceDocuments::where('subsistence_application_id', $id)->get();

        return view('app.subsistence_allowance.listapp.editdoc', [		
			'subApplication' => $subApplication,
            'doc' => $doc,
		]);
    }

    public function detailsStatus($id)
    {
        $subApplication = SubApplication::where('id', $id)->first();

        $subAuditLog = SubsistenceAuditLogStatus::where('subsistence_application_id', $id)->orderBy('created_at', 'asc')->get();

        return view('app.subsistence_allowance.listapp.editstatus', [	
            'subApplication' => $subApplication,
            'subAuditLog' => $subAuditLog,	
			
		]);
    }

    public function detailscheck($id)
    {

        $approvedId = Helper::getCodeMasterIdByTypeName('landing_status','DISAHKAN DAERAH');

        $subApplication = SubApplication::where('id', $id)->first();
        $applicant = User::where('username',$subApplication->icno)->first();
        $landings = LandingDeclarationMonthly::where('user_id',$applicant->id)->where('landing_status_id',$approvedId)->orderBy('year','desc')->orderBy('month','desc')->take(3)->get();

        return view('app.subsistence_allowance.listapp.editcheck', [	
            'subApplication' => $subApplication,
            'landings' => $landings,
		]);
    }

    public function verifyDoc(Request $request)
    {
        // Find the document
        $document = SubsistenceDocuments::findOrFail($request->document_id);

        // Update the verification status
        $document->status = $request->status; // Either 'verified' or 'rejected'
        $document->verified_by = Auth::user()->id; // Save user who verified
        $document->verified_at = now(); // Save timestamp
        $document->save();

        // Redirect back with success message
        return back()->with('success', 'Status dokumen berjaya dikemaskini!');
    }


    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCheck(Request $request)
    {
        
        // Find existing record by application_id
            $subApplication= SubApplication::where('id',  $request->application_id)->first();
            if($request->jkk == 'peraku')
                $subApplication->is_approved_jkk = true;
            else if($request->jkk == 'peraku'){
                $subApplication->is_approved_jkk = false;
            }

            if($request->dokumen == "lengkap"){
                $subApplication->status_checked = 'Permohonan Disemak (LENGKAP)';
                $subApplication->checked_remarks = $request->ulasan ?? '';
                $subApplication->checked_by = Auth::user()->id;
                $subApplication->sub_application_status = 'Permohonan Disemak (LENGKAP)';

                //save in log audit status
                $subAuditLog = new SubsistenceAuditLogStatus;
                $subAuditLog->id = Helper::uuid();
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
                $subAuditLog->id = Helper::uuid();
                $subAuditLog->subsistence_application_id =  $request->application_id;
                $subAuditLog->status = 'Permohonan Disemak (TIDAK LENGKAP)';
                $subAuditLog->remark = $request->ulasan ?? '';
                $subAuditLog->created_by = Auth::user()->id;
                $subAuditLog->save(); 
            }

            $subApplication->save(); // This will insert a new record

            // Redirect back with success message
        return back()->with('success', 'Status dokumen berjaya dikemaskini!');

    }

    

   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

   
}
