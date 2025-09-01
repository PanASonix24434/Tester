<?php

namespace App\Http\Controllers\SubsistenceAllowance;
use Illuminate\Http\Request;
use App\Models\SubsistenceAllowance\SubsistenceListQuota;
use App\Models\SubsistenceAllowance\SubApplication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SubAllowanceGenerateNameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->name == 'Super Admin') {
            $lists = SubsistenceListQuota::sortable();
        } else {
           // view by pejabat negeri
            $lists = SubsistenceListQuota::where('entities_id', Auth::user()->entity_id)->sortable();
        }
        $user = User::find(Auth::user()->id);
        $entity_id = $user->entity_id;

        return view('app.subsistence_allowance.generatename.index',  [
            'lists' => $request->has('sort') ? $lists->paginate(10) : $lists->orderBy('created_at')->paginate(10),
            'entity_id' =>  $entity_id,
        ]);
    }

    public function listName(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $subApplication = SubApplication::leftJoin('entities','entities.id','subsistence_application.entity_id')
        ->wherein('type_registration', ['Baru', 'Rayuan'])
        ->wherein('sub_application_status', ['Permohonan Disokong KDP', 'Permohonan Tidak Disokong KDP'])
        ->where(function ($query) {
            $query->where('status_quota', 'menunggu')
            ->orwhere('status_quota', 'layak tidak diluluskan');
        })
        ->where('entities.parent_id',$user->entity_id)
        ->select('subsistence_application.*');
        $curYear = Carbon::now()->year;
        $years = collect([$curYear-1,$curYear,$curYear+1]);
        $phases = collect(['Separuh Pertama','Separuh Kedua']);

        return view('app.subsistence_allowance.generatename.listName', [
            'subApplication' => $request->has('sort') ? $subApplication->paginate(10) : $subApplication->orderBy('created_at')->paginate(10),
            'years' => $years,
            'phases' => $phases,
		]);
    }

    public function storeJana(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $entityId = $user->entity_id;

        //check if already exist
        $quota = SubsistenceListQuota::where('year',$request->selYear)->where('phase',$request->selPhase)->where('entities_id',$entityId)->get();
        if(!$quota->isEmpty()){
            return redirect()->back()->with('alert', 'Mesyuarat untuk tahun tersebut telah diisi!');
        }

        $totalApplicants = SubApplication::leftJoin('entities','entities.id','subsistence_application.entity_id')
        ->wherein('type_registration', ['Baru', 'Rayuan'])
        ->wherein('sub_application_status', ['Permohonan Disokong KDP']) //'Permohonan Tidak Disokong KDP'
        ->where(function ($query) {
            $query->where('subsistence_application.status_quota', 'menunggu')
            ->orwhere('subsistence_application.status_quota', 'layak tidak diluluskan');
        })
        ->where('entities.parent_id',$user->entity_id)->count();

        if($totalApplicants<=0){
            return redirect()->back()->with('alert', 'Tiada Pemohon!');
        }


        $listq = SubsistenceListQuota::create([
            'id' => Str::uuid(),  // Generate UUID manually
            'generated_date' => now()->format('Y-m-d'),
            'total_applicants' => $totalApplicants,
            'entities_id' => $entityId,
            'quota' => 100,
            'status' => 'Dijana',
            'year' => $request->selYear,
            'phase' => $request->selPhase,
        ]);

        // Fetch and lock pending applications up to the given limit
        $pendingApps = SubApplication::join('users', 'subsistence_application.icno', '=', 'users.username')
        ->leftJoin('entities','entities.id','subsistence_application.entity_id')
        ->whereIn('type_registration', ['Baru', 'Rayuan'])
        ->whereIn('subsistence_application.sub_application_status', ['Permohonan Disokong KDP']) //'Permohonan Tidak Disokong KDP'
        ->where(function ($query) {
            $query->where('subsistence_application.status_quota', 'menunggu')
            ->orwhere('subsistence_application.status_quota', 'layak tidak diluluskan');
        })
        ->where('entities.parent_id', $listq->entities_id)   // sementara guna users entities - perlu tukar
        ->orderBy('subsistence_application.submitted_at', 'asc')
        // ->limit( $limits )
        ->lockForUpdate()
        ->select('subsistence_application.id')
        ->get();

        $pendingAppIds = $pendingApps->pluck('id')->toArray();

        if (!empty($pendingAppIds)) {
            SubApplication::whereIn('id', $pendingAppIds)
                ->update([
                    'status_quota' => 'senarai_menunggu',
                    'batch_id' => $listq->id,
                    'sub_application_status' => 'Permohonan Dalam Senarai Menunggu',
                ]);
        }
        return redirect()->route('subsistence-allowance.generate-name-state.index')->with('success', 'Senarai berjaya dijana!');
    }

    public function storeListName($id, Request $request)
    {
        $lists = SubsistenceListQuota::findOrFail($id);
        $lists->update(['status' => 'Dihantar']);

        return redirect()->route('subsistence-allowance.generate-name-state.index')->with('alert', 'Senarai nama berjaya dihantar !!');
    }

    public function updateStatus($id, $status)
    {
        $list = SubsistenceListQuota::findOrFail($id);
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
        SubsistenceListQuota::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Senarai berjaya dipadam!');
    }

    public function generateListNamePDF($id)
    {
        // Ambil senarai permohonan dari database
        $applications = SubApplication::orderBy('created_at', 'asc')
        ->where('batch_id', $id)->get();


        $list = SubsistenceListQuota::findOrFail($id);
        if($list->status == 'Dijana') $list->update(['status' => 'Dicetak']);


        $pdf = PDF::loadView('app.subsistence_allowance.generatename.applistnamepdf',  compact('applications'));
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
        $appq = SubsistenceListQuota::findOrFail($application->batch_id);

        // Get all applications under the same batch
        $applications = SubApplication::where('batch_id', $application->batch_id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Count already approved applications
        $approvedCount = $applications->where('status_quota', 'layak diluluskan')->count();

        if ($request->status == 'ditolak') {
            $application->status_quota = 'ditolak';

            $application->sub_application_status = 'Permohonan Ditolak Peringkat Negeri';
        }
        else {
            if ($approvedCount < $appq->quota) {
                $application->status_quota = 'layak diluluskan';  // Approve if quota is available

                $application->sub_application_status = 'Permohonan Diluluskan Peringkat Negeri';

            } else {
                $application->status_quota = 'layak tidak diluluskan';  // Reject if quota exceeded

                $application->sub_application_status = 'Permohonan Tidak Diluluskan Peringkat Negeri';


                // Get an existing batch_id from the latest quota record
                // $existingBatch = SubsistenceListQuota::whereNotNull('id')->where('status', 'Dijana')->latest('created_at')->value('id');

                // if ($existingBatch) {
                //     $application->batch_id = $existingBatch; // Assign the latest existing batch_id
                // } else {
                //     $application->batch_id = null;  // Fallback to a new batch_id if none exist
                // }
            }
        }
        $application->save();

        return back()->with('success', 'Status berjaya dikemaskini!');
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

        $canUpdate = SubsistenceListQuota::find($id)->status != 'Dihantar';

        return view('app.subsistence_allowance.generatename.edit', [
            'applications' => $request->has('sort') ? $applications->paginate(10) : $applications->orderBy('created_at')->paginate(10),
            'id' => $id,
            'allApplicationHaveUpdated' => $allApplicationHaveUpdated,
            'canUpdate' => $canUpdate
        ]);
    }
}
