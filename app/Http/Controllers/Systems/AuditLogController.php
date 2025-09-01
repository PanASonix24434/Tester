<?php

namespace App\Http\Controllers\Systems;

use App\Http\Controllers\Controller;
use App\Models\Systems\AuditLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AuditLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$request->user()->isAuthorize('audit-logs');
        $audits = AuditLog::sortable();

        $filterSource = !empty($request->source) ? $request->source : '';
        $filterAction = !empty($request->action) && strcmp($request->action, 'all') !== 0 ? $request->action : '';
        /*$filterDate = !empty($request->date) ? $request->date : '';
        $filterStartDate = !empty($request->date) ? Carbon::createFromFormat('d/m/Y', explode(' - ', $request->date)[0]) : '';
        $filterEndDate = !empty($request->date) ? Carbon::createFromFormat('d/m/Y', explode(' - ', $request->date)[1]) : '';*/

        //$filterAction = !empty($request->action) ? $request->action : '';

        $filterStartDate = !empty($request->txtStartDate) ? $request->txtStartDate : '';
        $filterEndDate = !empty($request->txtEndDate) ? $request->txtEndDate : '';

        if (!empty($filterSource)) {
            $audits->where('source', 'like', '%'.$filterSource.'%');
        }

        if (!empty($filterAction)) {
            $audits->where('action', 'like', '%'.$filterAction.'%');
        }

        /*if (!empty($filterDate)) {
            $audits->whereDate('created_at', '>=', $filterStartDate->format('Y-m-d'))->whereDate('created_at', '<=', $filterEndDate->format('Y-m-d'));
        }
        else {
            $audits->whereDate('created_at', '>=', Carbon::now()->subDays(30))->whereDate('created_at', '<=', Carbon::now());
        }*/

        if(!empty($filterStartDate)){

            $filterStartDate = Carbon::createFromFormat('Y-m-d', $filterStartDate);
            $audits->whereDate('created_at', '>=', $filterStartDate);
        }

        if(!empty($filterEndDate)){
            $filterEndDate = Carbon::createFromFormat('Y-m-d', $filterEndDate);
            $audits->whereDate('created_at', '<=', $filterEndDate);
        }

        if( empty($filterStartDate) && empty($filterEndDate) ){
            $audits->whereDate('created_at', '>=', Carbon::now()->subDays(30))->whereDate('created_at', '<=', Carbon::now());
        }
        
        return view('app.admin.audit_log.index', [
            'audits' => $request->has('sort') ? $audits->paginate(10) : $audits->orderBy('created_at', 'DESC')->paginate(10),
            'action' => $filterAction,
            'source' => $filterSource,
            //'date' => $filterDate,
            'filterStartDate' => !empty($filterStartDate) ? $filterStartDate->format('d/m/Y') : '',
            'filterEndDate' => !empty($filterEndDate) ? $filterEndDate->format('d/m/Y') : '',
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Systems\AuditLog  $auditLog
     * @return \Illuminate\Http\Response
     */
    public function show(AuditLog $auditLog)
    {
        request()->user()->isAuthorize('audit-logs');
        return view('app.admin.audit_log.view_modal', ['audit' => $auditLog]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Systems\AuditLog  $auditLog
     * @return \Illuminate\Http\Response
     */
    public function edit(AuditLog $auditLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Systems\AuditLog  $auditLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuditLog $auditLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Systems\AuditLog  $auditLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuditLog $auditLog)
    {
        //
    }
}
