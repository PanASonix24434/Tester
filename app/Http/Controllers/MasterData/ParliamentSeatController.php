<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Parliament;
use App\Models\ParliamentSeat;
use Audit;
use Exception;
use Helper;

class ParliamentSeatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->isAuthorize('aduns');
        $parliamentSeats = ParliamentSeat::where('parliament_seats.is_deleted', false)
        ->join('parliaments', 'parliaments.id', '=', 'parliament_seats.parliament_id');

        $filter = !empty($request->txtName) ? $request->txtName : '';

        if (!empty($filter)) {
            Audit::log('parliament_seats', 'search', json_encode(['filter' => $filter]));
            $parliamentSeats->whereRaw('UPPER(parliament_seats.parliament_seat_name) like ?', ['%'.strtoupper($filter).'%'])
                ->orWhereRaw('UPPER(parliament_seats.parliament_seat_code) like ?', ['%'.strtoupper($filter).'%']);
        }

        return view('app.master_data.parliamentSeat.index', [
            //'parliamentSeats' => $request->has('sort') ? $parliamentSeats->paginate(10) : $parliamentSeats->orderBy('parliaments.parliament_code')->paginate(10),
            'parliamentSeats' => $parliamentSeats->orderBy('parliaments.parliament_code')->orderBy('parliament_seats.parliament_seat_code')->select('parliament_seats.*','parliaments.parliament_name','parliaments.parliament_code','parliaments.state_id')->paginate(10),
            'txtName' => $filter,
            'can_create' => $request->user()->hasAccess('add-adun'),
            'can_delete' => $request->user()->hasAccess('delete-adun'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        request()->user()->isAuthorize('add-adun');
        $parliament = Parliament::where('parliaments.is_deleted', false)->get();

        return view('app.master_data.parliamentSeat.create', [
            
            'states' => Helper::getCodeMastersByType('state'),
            'parliament'=>$parliament,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->isAuthorize('add-adun');

        $this->validate($request, [
            'parliament' => ['required'],
            'code' => ['required', 'string', 'max:150'],
            'name' => ['required', 'string', 'max:150'],
        ]);

        if (Helper::parliamentSeatExists($request->name, $request->code, $request->parliament)) {
            return redirect()->back()->withErrors(['name' => __('app.data_exists', ['type' => __('app.parliament'), 'data' => $request->code.' - '.$request->name])]);
        }

        $audit_details = json_encode([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        try {

            $adun = new ParliamentSeat;           
            $adun->parliament_seat_code = $request->code;
            $adun->parliament_seat_name = $request->name;
            $adun->parliament_id = $request->parliament;
            $adun->created_by = $request->user()->id;
            $adun->updated_by = $request->user()->id;
            $adun->save();

            Audit::log('aduns', 'add', $audit_details);
        }
        catch (Exception $e) {

            Audit::log('aduns', 'add', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\ParliamentSeatController@index')->with('t_success', __('app.data_added', ['type' => __('app.aduns')]));
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
    public function edit($id)
    {
        request()->user()->isAuthorize('aduns');
        
        $adun = ParliamentSeat::find($id) ? ParliamentSeat::find($id)->parliament_id:'';
        $parliament = Parliament::find($adun);

        $negeri = Parliament::find($adun) ?  Parliament::find($adun)->state_id:'';

        $listParliament = Parliament::where('parliaments.state_id',$negeri)
        ->select('parliaments.id', 'parliaments.parliament_name','parliament_code')->get();

        //dd( $listParliament);
        return view('app.master_data.parliamentSeat.edit', [
            'parliamentSeat' => ParliamentSeat::find($id),
            // 'states' => Helper::getCodeMasterById('id', $parliament),
            'states' => Helper::getCodeMastersByType('state'),
            'parliament'=>$parliament,
            'listParliament'=>$listParliament,
            'can_edit' => request()->user()->hasAccess('edit-adun'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$request->user()->isAuthorize('add-adun');

        $this->validate($request, [
            'parliament' => ['required'],
            'code' => ['required', 'string', 'max:150'],
            'name' => ['required', 'string', 'max:150'],
        ]);

        /*if (Helper::parliamentSeatExists($request->name, $request->code, $request->parliament)) {
            return redirect()->back()->withErrors(['name' => __('app.data_exists', ['type' => __('app.parliament'), 'data' => $request->code.' - '.$request->name])]);
        }*/

        $audit_details = json_encode([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        try {

            $adun = ParliamentSeat::find($id);           
            $adun->parliament_seat_code = $request->code;
            $adun->parliament_seat_name = $request->name;
            $adun->parliament_id = $request->parliament;
            $adun->updated_by = $request->user()->id;
            $adun->save();

            Audit::log('aduns', 'add', $audit_details);
        }
        catch (Exception $e) {

            Audit::log('aduns', 'add', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\ParliamentSeatController@index')->with('t_success', __('app.data_added', ['type' => __('app.aduns')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        request()->user()->isAuthorize('delete-adun');

        $adun = ParliamentSeat::find($id);

        $audit_details = json_encode([
            'code' => $adun->parliament_seat_code,
            'name' => $adun->parliament_seat_name,
        ]);

        try {

            $adun->deleted_by = request()->user()->id;
            $adun->is_deleted = true;
            $adun->save();

            Audit::log('parliaments', 'delete', $audit_details);
        }
        catch (Exception $e) {

            Audit::log('parliaments', 'delete', $audit_details, $e->getMessage());
            return redirect()->back()->with('t_error', __('app.error_occured'));
        }

        return redirect()->action('MasterData\ParliamentSeatController@index')->with('t_info', __('app.data_deleted', ['type' => __('app.aduns'), 'data' => $adun->parliament_seat_name]));
    }
}
