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

class ApplicationSupportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $confiscation = Confiscation::whereIn('status', ['Permohonan Lucut Hak Dihantar','Permohonan Lucut Hak Tidak Diluluskan'])
            ->join('subsistence_application','subsistence_application.id','=','confiscation.subsistence_id')
            ->select('confiscation.*', 'subsistence_application.registration_no');

        $filterName = !empty($request->txtName) ? $request->txtName : '';
        $filterNoKP = !empty($request->txtNoKP) ? $request->txtNoKP : '';

       
        if(!empty($filterName)){
         
            $confiscation->where(DB::raw('UPPER(confiscation.fullname)'), 'like', '%'.strtoupper($filterName).'%');
        }

        if (!empty($filterNoKP)) {
            $confiscation->where('confiscation.icno', 'like', '%'.$filterNoKP .'%');
        }
        return view('app.confiscation.confiscationList.index', [
            'confiscation' => $request->has('sort') ? $confiscation->paginate(10) : $confiscation->orderBy('created_at')->paginate(10),
            'filterName' => !empty($filterName) ? $filterName : '',
            'filterNoKP' => !empty($filterNoKP ) ? $filterNoKP  : '',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $helper = new Helper();
        $confiscation = Confiscation::where('confiscation.id', $id)
            ->join('subsistence_application','subsistence_application.id','=','confiscation.subsistence_id')
            ->select('confiscation.*', 'subsistence_application.registration_no', 'subsistence_application.no_account')->first();
        $user = User::withTrashed()->where('username',$confiscation->icno)->first();

        $document = ConfiscationDoc::where('confiscation_id',$confiscation->id)->first();
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

        return view('app.confiscation.confiscationList.edit', [
            'confiscation' => $confiscation,
            'document' => $document,
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
        
        // dd($subApp->sub_application_status);
        $confiscation = Confiscation::find($id);
        $subApp = SubApplication::where('id', $confiscation->subsistence_id)->first();

        $confiscation->support_lucut = $request->keputusan;
        $confiscation->remark_support = $request->txtUlasan;
        $confiscation->support_by = Auth::user()->id;
        if($request->keputusan == 'Ya'){
            $confiscation->status = 'Permohonan Lucut Hak Disokong';
            $subApp->sub_application_status = 'Permohonan Lucut Hak Disokong';
        }
        else{
            $confiscation->status = 'Permohonan Lucut Hak Tidak Disokong';
            $subApp->sub_application_status = 'Permohonan Lucut Hak Tidak Disokong';
        }
        $confiscation->updated_by = Auth::user()->id;
        $confiscation->save();
        $subApp->save();


        return redirect()->action('Confiscation\ApplicationSupportController@index')->with('success', $confiscation->status);  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
