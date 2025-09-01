<?php

namespace App\Http\Controllers\Confiscation;

use App\Http\Controllers\Controller;
use App\Models\SubsistenceAllowance\SubApplication;
use App\Models\Confiscation;
use App\Models\ConfiscationDoc;
use App\Models\Helper;
use App\Models\LandingDeclaration\LandingDeclarationMonthly;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $confiscation = SubApplication::whereIn('subsistence_application.sub_application_status', ['Permohonan Diluluskan Peringkat HQ', 'Permohonan Lucut Hak Tidak Disokong'])
            ->select('subsistence_application.*');
            

        $filterName = !empty($request->txtName) ? $request->txtName : '';
        $filterNoKP = !empty($request->txtNoKP) ? $request->txtNoKP : '';

       
        if(!empty($filterName)){
         
            $confiscation->where(DB::raw('UPPER(fullname)'), 'like', '%'.strtoupper($filterName).'%');
        }

        if (!empty($filterNoKP)) {
            $confiscation->where('icno', 'like', '%'.$filterNoKP .'%');
        }
        return view('app.confiscation.applicationUpdate.index', [
            'confiscation' => $request->has('sort') ? $confiscation->paginate(10) : $confiscation->orderBy('created_at')->paginate(10),
            'filterName' => !empty($filterName) ? $filterName : '',
            'filterNoKP' => !empty($filterNoKP ) ? $filterNoKP  : '',
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $helper = new Helper();
        $confiscation = SubApplication::find($id);
        $user = User::withTrashed()->where('username',$confiscation->icno)->first();
        //==========landing==========
        $statusSahId = $helper->getCodeMasterIdByTypeName('landing_status','DISAHKAN DAERAH');
        $statusTidakSahId = $helper->getCodeMasterIdByTypeName('landing_status','TIDAK DISAHKAN DAERAH');

        $latestLanding = LandingDeclarationMonthly::where('user_id',$user->id)
        ->whereIn('landing_status_id',[$statusSahId,$statusTidakSahId])
        ->orderBy('year','desc')->orderBy('month','desc')->first();

        $month = null;
        if($latestLanding!=null){
            $givenDate = Carbon::parse($latestLanding->year.'-'.$latestLanding->month);
            $startOfCurrentMonth = Carbon::now()->startOfMonth();
            $startOfGivenMonth = $givenDate->copy()->startOfMonth();
            $month = $startOfCurrentMonth->diffInMonths($startOfGivenMonth);
        }

        return view('app.confiscation.applicationUpdate.edit', [
            'confiscation' => $confiscation,
            'reasons' => $helper->getCodeMastersByTypeOrder('confiscation_reason'),
            'latestLanding' => $latestLanding,
            'month' => $month,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $subApp = SubApplication::where('id',$id)->first();

        $confiscation = new Confiscation;
        // $confiscation->id = Helper::uuid();
        $confiscation->subsistence_id = $subApp->id;
        $confiscation->fullname = $subApp->fullname;
        $confiscation->icno = $subApp->icno;
        $confiscation->lucut_hak = $request->keputusan;
        $confiscation->confiscation_reason_id = $request->selReason;
        $confiscation->remark_lucut = $request->txtUlasan;
        $confiscation->status = 'Permohonan Lucut Hak Dihantar';
        $confiscation->created_by = Auth::user()->id;
        $confiscation->update_by = Auth::user()->id;
        $confiscation->save();

        if($request->hasFile('doc')){ 

            $file = $request->file('doc');
            $file_replace = str_replace(' ', '', $file->getClientOriginalName());
            $filename = $file_replace;				
            $path = $request->file('doc')->store('public/LucutHak/DokumanSokongan');

            $subDocument = new ConfiscationDoc();

            $subDocument->confiscation_id =  $confiscation->id;
            $subDocument->title = 'DOKUMEN SOKONGAN'; 
            $subDocument->file_path =  $path;
            $subDocument->file_detail = $filename;
            $subDocument->created_by = Auth::user()->id;
            $subDocument->updated_by = Auth::user()->id;

            $subDocument->save();
           
        }

        $subApp->sub_application_status = 'Permohonan Lucut Hak Dihantar';
        $subApp->save();

        return redirect()->action('Confiscation\ApplicationUpdateController@index')->with('success', 'Permohonan Lucut Hak Dihantar');  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
