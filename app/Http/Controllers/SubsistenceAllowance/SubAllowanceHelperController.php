<?php

namespace App\Http\Controllers\SubsistenceAllowance;

use App\Http\Controllers\Controller;
use App\Models\CodeMaster;
use App\Models\Helper;
use App\Models\LandingDeclaration\LandingActivitySpecies;
use App\Models\LandingDeclaration\LandingDeclaration;
use App\Models\LandingDeclaration\LandingDeclarationMonthly;
use App\Models\LandingDeclaration\LandingInfo;
use App\Models\LandingDeclaration\LandingInfoActivity;
use App\Models\Species;
use App\Models\SubsistenceAllowance\SubsistenceDocuments;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubAllowanceHelperController extends Controller
{
    public function previewDoc($id) {
        $doc = SubsistenceDocuments::findOrFail($id); // Assuming you have a Document model
    
        // 1. Check if the file exists
        if (!Storage::exists($doc->file_path)) {
            abort(404, 'File not found.');
        }
    
        // 2. Determine the MIME type (important for browser rendering)
        $mimeType = Storage::mimeType($doc->file_path);
    
        // 3. Create a streamed response (more efficient for large files)
        $response = new StreamedResponse(function () use ($doc) {
            $stream = Storage::readStream($doc->file_path);
            while ($chunk = fread($stream, 1024 * 1024)) { // Read in chunks
                echo $chunk;
                flush(); // Send data immediately
            }
            fclose($stream);
        }, 200, [
            'Content-Type' => $mimeType, // Set the correct MIME type
            'Content-Disposition' => 'inline; filename="' . $doc->file_name . '"', // Crucial for preview
        ]);
    
        return $response;
    }

    public function deleteDoc(Request $request, string $id)
    {
        DB::beginTransaction();

        try 
        {
            //Update status in table applications
            $appDoc = SubsistenceDocuments::find($id);
            // $appDoc->deleted_by=$request->user()->id;
			// $appDoc->save();
			$appDoc->delete();

            DB::commit();

            return redirect()->back()->with('alert', 'Dokumen berjaya dihapus !!');
        }
        catch (Exception $e) {

            DB::rollback();
            return redirect()->back()->with('alert', 'Dokumen gagal dihapus !!');
        }
    }

    public function getLandingSummary(Request $request)
    {
        try{
            $userId = $request->input('landingUserId');
            $year = $request->landingYearSearch;
            $month = $request->landingMonthSearch;

            //search landing
            $helper = new Helper();
            $approvedId = $helper->getCodeMasterIdByTypeName('landing_status','DISAHKAN DAERAH');
            $monthly = LandingDeclarationMonthly::where('user_id',$userId)->where('year',$year)->where('month',$month)->where('landing_status_id',$approvedId)->first();

            $operatedDays = 0;
            $totalLanding = 0;
            // $speciesData = collect();
            $data = collect();
            if($monthly != null){
                $weeklyIds = LandingDeclaration::where('landing_declare_monthly_id', $monthly->id)->select('id')->get()->pluck('id')->toArray();
                $landingInfos = LandingInfo::whereIn('landing_declaration_id',$weeklyIds)->orderBy('landing_date')->get();
                foreach ($landingInfos as $li) {
                    $activities = LandingInfoActivity:: where('landing_info_id',$li->id)->get();
                    if(!$activities->isEmpty()){
                        $operatedDays++;
                        foreach ($activities as $act) {
                            $species = LandingActivitySpecies::where('landing_info_activity_id',$act->id)->get();
                            if(!$species->isEmpty()){
                                foreach ($species as $s) {
                                    $totalLanding += $s->weight;
                                    $hasLocation = $data->where('districtId',$act->district_id )->where('location',$act->location_name)->isNotEmpty();
                                    if(!$hasLocation){
                                        $data->push(
                                            (object)[
                                            'districtId' => $act->district_id,
                                            'location' => $act->location_name,
                                            'district' => strtoupper(CodeMaster::find($act->district_id)->name),
                                            'species' => collect(),
                                            ]
                                        );
                                    }
                                    $spsInLocation = $data->where('districtId',$act->district_id )->where('location',$act->location_name)->first()->species;
                                    $hasSpsInLocation = $spsInLocation->where('speciesId',$s->species_id)->isNotEmpty();
                                    if($hasSpsInLocation){
                                        $sps = $spsInLocation->where('speciesId',$s->species_id)->first();
                                        // $sps = $speciesData->firstWhere('speciesId',$s->species_id);
                                        $sps->totalWeight += $s->weight;
                                        $sps->totalPrice += $s->weight * $s->price_per_weight;
                                    }
                                    else{
                                        $spsInLocation->push(
                                            (object)[
                                            'speciesId' => $s->species_id,
                                            'speciesName' => Species::find($s->species_id)->common_name,
                                            'totalWeight' => $s->weight,
                                            'totalPrice' => $s->weight * $s->price_per_weight
                                            ]
                                        );
                                    }

                                    // $hasSpeciesInArea = $speciesData->where('districtId',$act->district_id )->where('location',$act->location_name)->where('speciesId',$s->species_id)->isNotEmpty();
                                    // if($hasSpeciesInArea){//$speciesData->contains('speciesId',$s->species_id)
                                    //     $sps = $speciesData->where('districtId',$act->district_id )->where('location',$act->location_name)->where('speciesId',$s->species_id)->first();
                                    //     // $sps = $speciesData->firstWhere('speciesId',$s->species_id);
                                    //     $sps->totalWeight += $s->weight;
                                    //     $sps->totalPrice += $s->weight * $s->price_per_weight;
                                    // }
                                    // else{
                                    //     $speciesData->push(
                                    //         (object)[
                                    //         'speciesId' => $s->species_id,
                                    //         'districtId' => $act->district_id,
                                    //         'location' => $act->location_name,
                                    //         'district' => strtoupper(CodeMaster::find($act->district_id)->name),
                                    //         'speciesName' => Species::find($s->species_id)->common_name,
                                    //         'totalWeight' => $s->weight,
                                    //         'totalPrice' => $s->weight * $s->price_per_weight
                                    //         ]
                                    //     );
                                    // }
                                }
                            }
                        }
                    }
                }
            }

            return response()->json([
                'year' => $year,
                'month' => $month,
                'operatedDays' => $operatedDays,
                'totalLanding' => $totalLanding,
                'data' => $data,
                // 'speciesData' => $speciesData->sortBy(function ($item) {
                //     return [$item->districtId, $item->location];
                // }),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'e' => $e,
                // 'year' => $year,
                // 'month' => $month,
                // 'operatedDays' => $operatedDays,
                // 'totalLanding' => $totalLanding,
                // 'speciesData' => $speciesData,
            ]);
        }
    }
}
