<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CfgLicense;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Audit;
use Exception;
use Helper;
use Auth;
use Storage;
use PDF;
use Carbon\Carbon;

class CfgLicenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        /*$licenses = CfgLicense::whereNotNull('cfg_licenses.license_parameter')
            ->select('cfg_licenses.*')
            ->orderBy('cfg_licenses.updated_at','DESC')
            ->paginate(10);*/

        $licenses = CfgLicense::sortable();

        $filter = !empty($request->txtName) ? $request->txtName : '';

        if (!empty($filter)) {
            //Audit::log('loan_duration', 'search', json_encode(['filter' => $filter]));
            $licenses->orWhere('license_parameter', 'like', '%'.$filter.'%');
            $licenses->orWhere('desc', 'like', '%'.$filter.'%');
            $licenses->orWhere('license_duration', 'like', '%'.$filter.'%');
            $licenses->orWhere('license_amount', 'like', '%'.$filter.'%');
        }

        return view('app.master_data.cfgLicense.index', [
            'licenses' => $licenses->orderBy('license_parameter')->paginate(10),
            'txtName' => $filter,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.master_data.cfgLicense.create', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $audit_details = json_encode([
            'license_parameter' => $request->txtParameter,
            'desc' => $request->txtDesc,
            'license_duration' => $request->txtDuration,
            'license_amount' => $request->txtAmount,
            'start_date' => $request->txtStartDate,
        ]);

        try {

            $dt = Carbon::now();

            $cfgLicense = new CfgLicense();           
            $cfgLicense->license_parameter = $request->txtParameter;
            $cfgLicense->desc = $request->txtDesc;
            $cfgLicense->license_duration = $request->txtDuration;
            $cfgLicense->license_amount = $request->txtAmount;
            //$cfgLicense->start_date = $dt->format('Y-m-d');
            $cfgLicense->start_date = $request->txtStartDate;
            $cfgLicense->end_date = null;
            $cfgLicense->is_active = true;

            $cfgLicense->created_by = $request->user()->id;
            $cfgLicense->updated_by = $request->user()->id;
            
            $cfgLicense->save();
            
            Audit::log('cfg_license', 'add', $audit_details);
        }
        catch (Exception $e) {

            Audit::log('cfg_license', 'add', $audit_details, $e->getMessage());
            //return redirect()->back()->with('t_error', __('app.error_occured'));
            return redirect()->back()->with('lcn_failed', 'Data Utama gagal dicipta !!');
        }

        //return redirect()->action('CfgLicenseController@index')->with('t_success', __('app.data_added'));
        return redirect()->action('CfgLicenseController@index')->with('lcn_success', 'Data Utama berjaya dicipta !!');
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
    public function edit(string $id)
    {

        return view('app.master_data.cfgLicense.edit', [
            'license' => CfgLicense::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $cfgLicense = CfgLicense::find($id);
        $sts = "";

        if($request->status == '1'){
            $sts = "AKTIF";
        }
        else{
            $sts = "TIDAK AKTIF";
        }

        $audit_details = json_encode([
            'license_parameter' => $request->txtParameter,
            'desc' => $request->txtDesc,
            'license_duration' => $request->txtDuration,
            'license_amount' => $request->txtAmount,
            'status' => $sts,
        ]);

        try {

            if($request->status == '0'){

                $dt = Carbon::now();
                $cfgLicense->end_date = $dt->format('Y-m-d');
                $cfgLicense->is_active = false;

            }

            $cfgLicense->updated_by = request()->user()->id;
            $cfgLicense->save();

            Audit::log('cfgLicense', 'update', $audit_details);
        }
        catch (Exception $e) {

            Audit::log('cfgLicense', 'update', $audit_details, $e->getMessage());
            //return redirect()->back()->with('t_error', __('app.error_occured'));
            return redirect()->back()->with('lcn_failed', 'Data Utama gagal disimpan !!');
        }

        //return redirect()->action('CfgLicenseController@index')->with('t_success', __('app.data_updated'));
        return redirect()->action('CfgLicenseController@index')->with('lcn_success', 'Data Utama berjaya disimpan !!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
