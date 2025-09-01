<?php

namespace App\Http\Controllers\SubsistenceAllowanceRenewal;
use Illuminate\Http\Request;
use App\Models\SubsistenceAllowance\SubsistenceList;
use App\Models\SubsistenceAllowance\SubApplication;

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
use Illuminate\Support\Str;

use Barryvdh\DomPDF\Facade\Pdf;


class SubAllowanceRenewalGenerateNameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
              
        if(Auth::user()->name == 'Super Admin') {
			$lists = SubsistenceList::sortable();
		} else {
           // view by pejabat negeri
            $lists = SubsistenceList::where('entities_id', Auth::user()->entity_id)->sortable();
		}

        return view('app.subsistence_allowance_renewal.generatename.index',  [
            // 'lists' =>  $lists,
            'lists' => $request->has('sort') ? $lists->paginate(10) : $lists->orderBy('created_at','desc')->paginate(10), 
            
        ]);
    }

    public function listNameRenewal(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $subApplication = SubApplication::leftJoin('entities','entities.id','subsistence_application.entity_id')
        ->wherein('type_registration', ['Renew', 'Rayuan Pembaharuan'])
        ->wherein('sub_application_status', ['Permohonan Disokong KDP', 'Permohonan Tidak Disokong KDP'])
        ->where('entities.parent_id',$user->entity_id)
        ->select('subsistence_application.*');


        return view('app.subsistence_allowance_renewal.generatename.listNameRenewal', [		
           
            'subApplication' => $request->has('sort') ? $subApplication->paginate(10) : $subApplication->orderBy('created_at')->paginate(10), 
            
		]);
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

    

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    public function storeJana(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $totalApplicants = SubApplication::leftJoin('entities','entities.id','subsistence_application.entity_id')
        ->wherein('type_registration', ['Renew', 'Rayuan Pembaharuan'])
        ->wherein('sub_application_status', ['Permohonan Disokong KDP', 'Permohonan Tidak Disokong KDP'])
        ->where('entities.parent_id',$user->entity_id)->count();

        // Ambil jumlah yang telah digunakan dari jadual 'subsistence_list'
        // $used = SubsistenceList::sum('total_applicants'); 
        

        $entity = User::where('users.id', Auth::id())
        ->select('users.entity_id')->first();


        $listq = SubsistenceList::create([
            'id' => Str::uuid(),  // Generate UUID manually
            'generated_date' => now()->format('Y-m-d'),
            'total_applicants' => $totalApplicants,
            'entities_id' => $entity ? $entity->entity_id : null, 
            'status' => 'Dijana'
        ]);

       


        // Fetch and lock pending applications up to the given limit
        $pendingApps = SubApplication::leftJoin('entities','entities.id','subsistence_application.entity_id')
            // ->orwhere('subsistence_application.status_quota', 'layak tidak diluluskan')
            ->where('subsistence_application.status_quota', 'menunggu')
            ->wherein('subsistence_application.sub_application_status', ['Permohonan Disokong KDP', 'Permohonan Tidak Disokong KDP'])
            ->wherein('subsistence_application.type_registration', ['Renew', 'Rayuan Pembaharuan'])
            ->where('entities.parent_id', $listq->entities_id)   // sementara guna users entities - perlu tukar
            ->orderBy('subsistence_application.created_at', 'asc')
            ->lockForUpdate()
            ->select('subsistence_application.id')
            ->get();


            //dd($pendingApps);


            $pendingAppIds = $pendingApps->pluck('id')->toArray(); 

            // \Log::info('Pending Application IDs:', $pendingAppIds); // Debugging log
            
            if (!empty($pendingAppIds)) { 
                SubApplication::whereIn('id', $pendingAppIds)
                    ->update([
                        'status_quota' => 'senarai_menunggu',
                        'batch_id' => $listq->id,
                        'sub_application_status' => 'Permohonan Dalam Senarai Menunggu',
                    ]);
            }

        

        return redirect()->action('SubsistenceAllowanceRenewal\SubAllowanceRenewalGenerateNameController@index')->with('success', 'Senarai berjaya dijana!');
    }

    public function storeListName($id, Request $request)
    {
        $lists = SubsistenceList::findOrFail($id);
        $lists->update(['status' => 'Dihantar']);

        // return view('app.subsistence_allowance_renewal.generatename.index',  [
        //     // 'lists' =>  $lists,
        //     'lists' => $request->has('sort') ? $lists->paginate(10) : $lists->orderBy('created_at')->paginate(10), 
        // ]);
        return redirect()->route('subsistence-allowance-renewal.index')->with('alert', 'Senarai nama berjaya dihantar !!');
    }

    public function updateStatus($id, $status)
    {
        $list = SubsistenceList::findOrFail($id);
        $list->update(['status' => $status]);

        return redirect()->back()->with('success', 'Status berjaya dikemaskini!');
    }

    public function destroy($id)
    {
        SubApplication::where('batch_id', $id)
        ->update([
            'status_quota' => 'menunggu',
            'batch_id' => null,
            'sub_application_status' => 'Permohonan Disokong KDP',
        ]);
        SubsistenceList::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Senarai berjaya dipadam!');
    }

    public function generatePDF($id)
    {
        // Ambil senarai permohonan dari database
        $applications = SubApplication::orderBy('created_at', 'desc')
        ->where('batch_id', $id)->get();


        $pdf = PDF::loadView('app.subsistence_allowance_renewal.generatename.applistpdf',  compact('applications'));
        $pdf->setPaper('A4', 'portrait');
        $pdf->getDomPDF()->set_option('enable_php', true);

        // View on page
        return $pdf->stream('senarai_permohonan.pdf');
    }

    public function generateListNamePDF($id)
    {
        // Ambil senarai permohonan dari database
        $applications = SubApplication::orderBy('created_at', 'asc')
        ->where('batch_id', $id)->get();

        
        $list = SubsistenceList::findOrFail($id);
        $list->update(['status' => 'Dicetak']);


        $pdf = PDF::loadView('app.subsistence_allowance_renewal.generatename.applistnamepdf',  compact('applications'));
        $pdf->setPaper('A4', 'landscape');
        $pdf->getDomPDF()->set_option('enable_php', true);
        

        // View on page
        return $pdf->stream('senarai_permohonan.pdf');
    }

    public function verifyListName(Request $request)
    {
        // Ensure request is received
        if (!$request->has('application_id')) {
            return back()->with('error', 'Application ID missing!');
        }
    
        // Find the application
        $application = SubApplication::findOrFail($request->application_id);
    
        // Get batch details
        $appq = SubsistenceList::findOrFail($application->batch_id);
    
        // Get all applications under the same batch
        $applications = SubApplication::where('batch_id', $application->batch_id)
            ->orderBy('created_at', 'asc')
            ->get();


        if ($request->status == 'ditolak') {
            $application->status_quota = 'ditolak';

            $application->sub_application_status = 'Permohonan Ditolak Peringkat Negeri';
        } 
        else {
          
                $application->status_quota = 'layak diluluskan';  // Approve 

                $application->sub_application_status = 'Permohonan Diluluskan Peringkat Negeri';
           
            }
        

        $application->save();
    
        return back()->with('success', 'Status berjaya dikemaskini!');
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
    public function edit(Request $request, $id)
    {   

        /// Ambil senarai permohonan dari database
        $allApplicationHaveUpdated = !(SubApplication::where('batch_id', $id)->where('status_quota','senarai_menunggu')->count() > 0);
        
        $applications = SubApplication::orderBy('registration_no', 'asc')
        ->where('batch_id', $id);

        $canUpdate = SubsistenceList::find($id)->status != 'Dihantar';

        return view('app.subsistence_allowance_renewal.generatename.edit', [
            'applications' => $request->has('sort') ? $applications->paginate(10) : $applications->orderBy('created_at')->paginate(10), 
            'id' => $id,
            'allApplicationHaveUpdated' => $allApplicationHaveUpdated,
            'canUpdate' => $canUpdate
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

   
}
