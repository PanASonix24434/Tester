<?php

namespace App\Http\Controllers;

use App\Models\CodeMaster;
use App\Models\Kru\ImmigrationGate;
use App\Models\Kru\ImmigrationOffice;
use App\Models\Parliament;
use App\Models\ParliamentSeat;
use App\Models\Systems\AuditLog;
use Exception;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function getDistricts(Request $request)
    {
        $stateId = $request->input('state_id');
        try{
            if ($stateId) {
                $districts = CodeMaster::where('parent_id', $stateId)->orderBy('name')->pluck('name','id');
                return response()->json($districts);
            }
            return response()->json([]);
        }
        catch(Exception $e){
            $audit_details = json_encode([
                'state_id' => $stateId,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('helper', 'getDistricts', $audit_details, $e->getMessage());
            return response()->json([]);
        }
    }

    public function getParliaments(Request $request)
    {
        $stateId = $request->input('state_id');
        try{
            if ($stateId) {
                $parliaments = Parliament::where('state_id', $stateId)->orderBy('parliament_name')->pluck('parliament_name','id');
                return response()->json($parliaments);
            }
            return response()->json([]);
        }
        catch(Exception $e){
            $audit_details = json_encode([
                'state_id' => $stateId,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('helper', 'getParliaments', $audit_details, $e->getMessage());
            return response()->json([]);
        }
    }

    public function getDuns(Request $request)
    {
        $parliamentId = $request->input('parliament_id');
        try{
            if ($parliamentId) {
                $parliaments = ParliamentSeat::where('parliament_id', $parliamentId)->orderBy('parliament_seat_name')->pluck('parliament_seat_name','id');
                return response()->json($parliaments);
            }
            return response()->json([]);
        }
        catch(Exception $e){
            $audit_details = json_encode([
                'parliament_id' => $parliamentId,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('helper', 'getDuns', $audit_details, $e->getMessage());
            return response()->json([]);
        }
    }

    public function getImmigrationGates(Request $request)
    {
        $immigrationOfficeId = $request->input('immigration_office_id');
        try{
            if($immigrationOfficeId){
                $stateId = optional(ImmigrationOffice::find($immigrationOfficeId))->state_id;
                if ($stateId) {
                    $gates = ImmigrationGate::where('state_id', $stateId)->orderBy('immigration_gates.gate_type')->orderBy('immigration_gates.name')->get()
                    ->mapWithKeys(function ($gate) {
                        return [$gate->id => ['name' => $gate->name, 'gate_type' => $gate->gate_type]];
                    });//->pluck('name','id','gate_type'); pluck to json is not compactible, maximum pluck is 2 column for json
                    return response()->json($gates);
                }
                return response()->json([]);
            }
            return response()->json([]);
        }
        catch(Exception $e){
            $audit_details = json_encode([
                'immigration_office_id' => $immigrationOfficeId,
            ]);

            $auditLog = new AuditLog();
            $auditLog->log('helper', 'getImmigrationGates', $audit_details, $e->getMessage());
            return response()->json([]);
        }
    }
}
