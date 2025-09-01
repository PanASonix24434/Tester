<?php

namespace App\Http\Controllers\Systems;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Announcement;

use Auth;
use Audit;
use Hash;
use DB;
use Exception;
use Carbon\Carbon;
use PDF;
use Storage;
use Image;
use Helper;

use Illuminate\Support\Str;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $anns = Announcement::whereNull('deleted_by');

        $filterStartDate = !empty($request->txtStartDate) ? $request->txtStartDate : '';
        $filterEndDate = !empty($request->txtEndDate) ? $request->txtEndDate : '';
        $filterTitle = !empty($request->txtTitle) ? $request->txtTitle : '';
        $filterDesc = !empty($request->txtDesc) ? $request->txtDesc : '';

        if(!empty($filterStartDate)){
            $filterStartDate = Carbon::createFromFormat('Y-m-d', $filterStartDate);
            $anns->whereDate('start_date', '>=', $filterStartDate);
        }

        if(!empty($filterEndDate)){
            $filterEndDate = Carbon::createFromFormat('Y-m-d', $filterEndDate);
            $anns->whereDate('end_date', '<=', $filterEndDate);
        }

        if (!empty($filterTitle)) {
            $anns->where('title', 'like', '%'.$filterTitle.'%');
        }

        if (!empty($filterDesc)) {
            $anns->where('description', 'like', '%'.$filterDesc.'%');
        }

        return view('app.admin.announcement.index', [		
            'q' => '',
            'anns' => $anns->orderBy('start_date', 'DESC')->paginate(10),
            'filterStartDate' => !empty($filterStartDate) ? $filterStartDate->format('Y-m-d') : '',
            'filterEndDate' => !empty($filterEndDate) ? $filterEndDate->format('Y-m-d') : '',
            'filterTitle' => !empty($filterTitle) ? $filterTitle : '',
            'filterDesc' => !empty($filterDesc) ? $filterDesc : '',
		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.admin.announcement.create', [		

		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'tarikh_mula'    => 'required|date',
            'tarikh_hingga'      => 'required|date|after_or_equal:tarikh_mula',
        ],
        [
            'tarikh_hingga.after_or_equal' => 'Tarikh Hingga mesti sama atau selepas Tarikh Mula.',
        ]);

        DB::beginTransaction();

        try {
            
            //Slider Image
            if ($request->file('fileDoc')) {
                
                $file = $request->file('fileDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;				
                $path = $request->file('fileDoc')->store('public/pengumuman');

				//store your file into database
				$ann = new Announcement();

                $ann->title = $request->txtTitle;
                $ann->description = strtoupper($request->txtDesc);
                $ann->start_date = $request->tarikh_mula;
                
                if(!empty($request->tarikh_hingga)){
                    $ann->end_date = $request->tarikh_hingga;
                }
                else{
                    $ann->end_date = '9999-12-31';
                }
				
                //$ann->file_title = $request->txtTitle;
                $ann->file_path = $path;
                $ann->file_name = $filename;
                $ann->announcement_type = 1;
                $ann->announcement_status = 1;

				$ann->created_by = $request->user()->id;
                $ann->updated_by = $request->user()->id;

                $ann->save();
                
                $audit_details = json_encode([ 
                    'start_date'=> $request->tarikh_mula,
                    'end_date' => $request->tarikh_hingga,
                    'path' => $path,
                ]);

                Audit::log('announcement', 'add', $audit_details);
        	}
            else{
                //Text

                //store your file into database
				$ann = new Announcement();

                $ann->title = $request->txtTitle;
                $ann->description = strtoupper($request->txtDesc);
                $ann->start_date = $request->tarikh_mula;

                if(!empty($request->tarikh_hingga)){
                    $ann->end_date = $request->tarikh_hingga;
                }
                else{
                    $ann->end_date = '9999-12-31';
                }
                
                $ann->announcement_type = 1;
                $ann->announcement_status = 1;

				$ann->created_by = $request->user()->id;
                $ann->updated_by = $request->user()->id;

                $ann->save();
                
                $audit_details = json_encode([ 
                    'title' => $request->txtTitle,
                    'description' => $request->txtDesc,
                    'start_date'=> $request->tarikh_mula,
                    'end_date' => $request->tarikh_hingga, 
                ]);

                Audit::log('announcement', 'add', $audit_details);
            }

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();

            if ($request->file('fileDoc')) {

                $audit_details = json_encode([ 
                    'start_date'=> $request->tarikh_mula,
                    'end_date' => $request->tarikh_hingga,
                ]);
            }
            else{
                $audit_details = json_encode([ 
                    'title' => $request->txtTitle,
                    'description' => $request->txtDesc,
                    'start_date'=> $request->tarikh_mula,
                    'end_date' => $request->tarikh_hingga, 
                ]);
            }

            Audit::log('announcement', 'add', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('Systems\AnnouncementController@index')->with('alert', 'Pengumuman berjaya disimpan !!');
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
        $anns = Announcement::where('id', $id)
        ->get();

        return view('app.admin.announcement.edit', [		
            'id' => $id,
            'anns' => $anns,
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'tarikh_mula'    => 'required|date',
            'tarikh_hingga'  => 'required|date|after_or_equal:tarikh_mula',
        ],
        [
            'tarikh_hingga.after_or_equal' => 'Tarikh Hingga mesti sama atau selepas Tarikh Mula.',
        ]);

        DB::beginTransaction();

        try {
            
            //Slider Image
            if ($request->file('fileDoc')) {
                
                $file = $request->file('fileDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;				
                $path = $request->file('fileDoc')->store('public/pengumuman');

				//store your file into database
				$ann = Announcement::find($id);

                $ann->title = $request->txtTitle;
                $ann->description = strtoupper($request->txtDesc);
                $ann->start_date = $request->tarikh_mula;
                
                if(!empty($request->tarikh_hingga)){
                    $ann->end_date = $request->tarikh_hingga;
                }
                else{
                    $ann->end_date = '9999-12-31';
                }
				
                //$ann->file_title = $request->txtTitle;
                $ann->file_path = $path;
                $ann->file_name = $filename;
                $ann->announcement_type = 2;
                $ann->announcement_status = 1;

				$ann->created_by = $request->user()->id;
                $ann->updated_by = $request->user()->id;

                $ann->save();
                
                $audit_details = json_encode([ 
                    'title' => $request->txtTitle,
                    'description' => strtoupper($request->txtDesc),
                    'start_date'=> $request->tarikh_mula,
                    'end_date' => $request->tarikh_hingga,
                    'path' => $path,
                ]);

                Audit::log('announcement', 'add', $audit_details);
        	}
            else{
                //Text

                //store your file into database
				$ann = Announcement::find($id);

                $ann->title = $request->txtTitle;
                $ann->description = strtoupper($request->txtDesc);
                $ann->start_date = $request->tarikh_mula;

                if(!empty($request->tarikh_hingga)){
                    $ann->end_date = $request->tarikh_hingga;
                }
                else{
                    $ann->end_date = '9999-12-31';
                }
                
                $ann->announcement_type = 1;
                //$ann->announcement_status = $request->selStatus;

                $ann->updated_by = $request->user()->id;

                $ann->save();
                
                $audit_details = json_encode([ 
                    'title' => $request->txtTitle,
                    'description' => $request->txtDesc,
                    'start_date'=> $request->tarikh_mula,
                    'end_date' => $request->tarikh_hingga, 
                    'status' => $request->selStatus,
                ]);

                Audit::log('announcement', 'update', $audit_details);
            }

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();

            if ($request->file('fileDoc')) {

                $audit_details = json_encode([ 
                    'start_date'=> $request->tarikh_mula,
                    'end_date' => $request->tarikh_hingga,
                ]);
            }
            else{
                $audit_details = json_encode([ 
                    'title' => $request->txtTitle,
                    'description' => $request->txtDesc,
                    'start_date'=> $request->tarikh_mula,
                    'end_date' => $request->tarikh_hingga, 
                    'status' => $request->selStatus, 
                ]);
            }

            Audit::log('announcement', 'update', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('Systems\AnnouncementController@index')->with('t_success', __('app.data_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //Download Document Pengumuman
    public function downloadDoc($id)
    {
        $anns = Announcement::find($id);

        if (Storage::exists($anns->file_path)) {

            //Format - PDF
            if (Str::contains($anns->file_path, '.pdf'))
            {
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
            }
            //Format - JPG
            elseif(Str::contains($anns->file_path, '.jpg'))
            {
                $headers = [
                    'Content-Type' => 'application/jpg',
                ];
            }
            //Format - PNG
            elseif(Str::contains($anns->file_path, '.PNG'))
            {
                $headers = [
                    'Content-Type' => 'application/PNG',
                ];
            }
            else
            {
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
            }
                
            return Storage::download($anns->file_path, $anns->file_name, $headers);
        }
        return redirect('/404');
    }
}
