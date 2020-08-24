<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\User;
use App\Sick;
use Yajra\DataTables\Datatables;

class SickController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sick.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sick.form', ['action' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = explode(" - ", request()->date_sick, 2);
        
        $dateStart = Carbon::parse($date[0]);
        $dateEnd = Carbon::parse($date[1]);
        $date1 = date('Y-m-d', strtotime($dateStart->toDateTimeString()));
        $date2 = date('Y-m-d', strtotime($dateEnd->toDateTimeString()));

        $period = CarbonPeriod::create($date1, $date2);

        // Iterate over the period
        $dates = [];
        foreach ($period as $date) {
            array_push($dates, $date->format('Y-m-d'));
        }

        $sick = new Sick;
        $sick->users_id = request()->users_id;
        $sick->date_sick = json_encode($dates);
        $sick->amount = count($dates);
        $sick->status = request()->status;
        $sick->is_sick_letter = 1;
        $sick->note = request()->note;
        $sick->request_to = 1;
        $sick->note_from_manager = 'note_from_manager';
        $sick->save();

        if($sick){
            return view('sick.index')->with('success','Data berhasil disimpan!');
        }

        return view('sick.form')->with('danger','Terjadi masalah!');
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
        $sick = Sick::findOrFail($id);
        return view('sick.form', ['action' => 'edit', 'sick' => $sick]);
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
        $date = explode(" - ", request()->date_sick, 2);
        
        $dateStart = Carbon::parse($date[0]);
        $dateEnd = Carbon::parse($date[1]);
        $date1 = date('Y-m-d', strtotime($dateStart->toDateTimeString()));
        $date2 = date('Y-m-d', strtotime($dateEnd->toDateTimeString()));

        $period = CarbonPeriod::create($date1, $date2);

        // Iterate over the period
        $dates = [];
        foreach ($period as $date) {
            array_push($dates, $date->format('Y-m-d'));
        }

        $sick = Sick::findOrFail($id);
        $sick->users_id = request()->users_id;
        $sick->date_sick = json_encode($dates);
        $sick->amount = count($dates);
        $sick->status = request()->status;
        $sick->is_sick_letter = 1;
        $sick->note = request()->note;
        $sick->request_to = 1;
        $sick->note_from_manager = 'note_from_manager';
        $sick->save();

        if($sick){
            return view('sick.index')->with('success','Data berhasil dirubah!');
        }

        return view('sick.form')->with('danger','Terjadi masalah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function apiSick(){
        $item = Sick::select('sicks.id', 'users.name', 'sicks.created_at', 'sicks.status')
                    ->leftJoin('users', 'users.id', '=', 'sicks.users_id')
                    ->orderBy('sicks.created_at', 'DESC')
                    ->get();

        return Datatables::of($item)
                ->addIndexColumn()
                ->editColumn('created_at', function ($item) {
                    return date('d-m-Y', strtotime($item->created_at));
                })
                ->addColumn('action', function($item){
                    return 
                    // '<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> '.
                    '<a href="'.route("sick.edit", $item->id).'" class="mr-2"><svg viewBox="0 0 24 24" width="18" height="18" stroke="#ffc107" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a> '.
                    '<form id="delete-form-'.$item->id.'" method="post" action="'.route("sick.destroy",$item->id).'" style="display: none">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                    </form>'.
                    '<a
                    onclick="
                    if(confirm(\'Are you sure, You Want to delete '.$item->name.'?\'))
                        {
                            event.preventDefault();
                            document.getElementById(\'delete-form-'.$item->id.'\').submit();
                        }else{
                            event.preventDefault();
                    }" 
                    class=""><svg viewBox="0 0 24 24" width="18" height="18" stroke="#dc3545" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                })->rawColumns(['action'])->make(true);
    }
}
