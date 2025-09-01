<?php

namespace App\Http\Controllers\Systems;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pekeliling;

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

class PekelilingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pekeliling = Pekeliling::whereNull('deleted_by');

        $filterStartDate = !empty($request->txtStartDate) ? $request->txtStartDate : '';
        $filterEndDate = !empty($request->txtEndDate) ? $request->txtEndDate : '';
        $filterName = !empty($request->txtName) ? $request->txtName : '';
        $filterTitle = !empty($request->txtTitle) ? $request->txtTitle : '';
        $filterRefNo = !empty($request->txtRefNo) ? $request->txtRefNo : '';

        if(!empty($filterStartDate)){
            $filterStartDate = Carbon::createFromFormat('Y-m-d', $filterStartDate);
            $pekeliling->whereDate('tarikh', '>=', $filterStartDate);
        }

        if(!empty($filterEndDate)){
            $filterEndDate = Carbon::createFromFormat('Y-m-d', $filterEndDate);
            $pekeliling->whereDate('tarikh', '<=', $filterEndDate);
        }

        if (!empty($filterName)) {
            $pekeliling->where('nama', 'like', '%'.$filterName.'%');
        }

        if (!empty($filterTitle)) {
            $pekeliling->where('tajuk', 'like', '%'.$filterTitle.'%');
        }

        if (!empty($filterRefNo)) {
            $pekeliling->where('no_rujukan', 'like', '%'.$filterRefNo.'%');
        }

        return view('app.admin.pekeliling.index', [		
            'q' => '',
            'pekeliling' => $pekeliling->orderBy('tarikh', 'DESC')->paginate(10),
            'filterStartDate' => !empty($filterStartDate) ? $filterStartDate->format('Y-m-d') : '',
            'filterEndDate' => !empty($filterEndDate) ? $filterEndDate->format('Y-m-d') : '',
            'filterName' => !empty($filterName) ? $filterName : '',
            'filterTitle' => !empty($filterTitle) ? $filterTitle : '',
            'filterRefNo' => !empty($filterRefNo) ? $filterRefNo : '',
		]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.admin.pekeliling.create', [		

		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validation
        $this->validate($request, [
            'fileDoc' => 'required|max:5120',
        ],
        [
            'fileDoc.max' => 'Maksimum saiz fail adalah 5MB.',
        ]);

        DB::beginTransaction();

        try {
            
            if ($request->file('fileDoc')) {
                
                $file = $request->file('fileDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;				
                $path = $request->file('fileDoc')->store('public/pekeliling');

				//store your file into database
				$pekeliling = new Pekeliling();
                $pekeliling->nama = $request->txtName;
                $pekeliling->tajuk = $request->txtTitle;
                $pekeliling->tarikh = $request->txtDate;
                $pekeliling->no_rujukan = $request->txtRefNo;
                $pekeliling->kandungan = strtoupper($request->txtDesc);
				
                //File
                $pekeliling->file_path = $path;
                $pekeliling->file_name = $filename;

                $pekeliling->is_active = true;

				$pekeliling->created_by = $request->user()->id;
                $pekeliling->updated_by = $request->user()->id;

                $pekeliling->save();
                
                $audit_details = json_encode([ 
                    'nama'=> $request->txtName,
                    'tajuk' => $request->txtTitle,
                    'tarikh'=> $request->txtDate,
                    'no_rujukan' => $request->txtRefNo,
                    'kandungan'=> strtoupper($request->txtDesc),
                    'path' => $path,
                ]);

                Audit::log('Pekeliling', 'Tambah', $audit_details);
        	}

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'nama'=> $request->txtName,
                'tajuk' => $request->txtTitle,
                'tarikh'=> $request->txtDate,
                'no_rujukan' => $request->txtRefNo,
                'kandungan'=> strtoupper($request->txtDesc),
                'path' => $path,
            ]);

            Audit::log('Pekeliling', 'Tambah', $audit_details, $e->getMessage());

            //return redirect()->back()->with('t_error', __('app.error_occured'));
            return redirect()->back()->with('pekeliling_failed', 'Pekeliling gagal disimpan !!');
        }

        //return redirect()->action('Systems\PekelilingController@index')->with('t_success', __('app.data_updated'));
        return redirect()->action('Systems\PekelilingController@index')->with('pekeliling_success', 'Pekeliling berjaya disimpan !!');
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
        $pekeliling = Pekeliling::where('id', $id)
        ->get();

        return view('app.admin.pekeliling.edit', [		
            'id' => $id,
            'pekeliling' => $pekeliling,
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {

            $pekeliling = Pekeliling::find($id);
            
            if ($request->file('fileDoc')) {
                
                //File
                $file = $request->file('fileDoc');
                $file_replace = str_replace(' ', '', $file->getClientOriginalName());
                $filename = $file_replace;				
                $path = $request->file('fileDoc')->store('public/pekeliling');
				
                //File
                $pekeliling->file_path = $path;
                $pekeliling->file_name = $filename;

                $pekeliling->nama = $request->txtName;
                $pekeliling->tajuk = $request->txtTitle;
                $pekeliling->tarikh = $request->txtDate;
                $pekeliling->no_rujukan = $request->txtRefNo;
                $pekeliling->kandungan = strtoupper($request->txtDesc);
                $pekeliling->is_active = true;
                
        	}else{

                $pekeliling->nama = $request->txtName;
                $pekeliling->tajuk = $request->txtTitle;
                $pekeliling->tarikh = $request->txtDate;
                $pekeliling->no_rujukan = $request->txtRefNo;
                $pekeliling->kandungan = strtoupper($request->txtDesc);
                $pekeliling->is_active = true;

            }

            $pekeliling->updated_by = $request->user()->id;
            $pekeliling->save();
                
            $audit_details = json_encode([ 
                'nama'=> $request->txtName,
                'tajuk' => $request->txtTitle,
                'tarikh'=> $request->txtDate,
                'no_rujukan' => $request->txtRefNo,
                'kandungan'=> strtoupper($request->txtDesc),
            ]);

            Audit::log('Pekeliling', 'Kemaskini', $audit_details);

            DB::commit();
        }
        catch (Exception $e) {
            DB::rollback();

            $audit_details = json_encode([ 
                'nama'=> $request->txtName,
                'tajuk' => $request->txtTitle,
                'tarikh'=> $request->txtDate,
                'no_rujukan' => $request->txtRefNo,
                'kandungan'=> strtoupper($request->txtDesc),
            ]);

            Audit::log('Pekeliling', 'Kemaskini', $audit_details, $e->getMessage());

            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('Systems\PekelilingController@index')->with('t_success', __('app.data_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //Download Document Pekeliling
    public function downloadDoc($id)
    {
        $pekeliling = Pekeliling::find($id);

        if (Storage::exists($pekeliling->file_path)) {

            //Format - PDF
            if (Str::contains($pekeliling->file_path, '.pdf'))
            {
                $headers = [
                    'Content-Type' => 'application/pdf',
                ];
            }
            //Format - JPG
            elseif(Str::contains($pekeliling->file_path, '.jpg'))
            {
                $headers = [
                    'Content-Type' => 'application/jpg',
                ];
            }
            //Format - PNG
            elseif(Str::contains($pekeliling->file_path, '.PNG'))
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
                
            return Storage::download($pekeliling->file_path, $pekeliling->file_name, $headers);
        }
        return redirect('/404');
    }
}
