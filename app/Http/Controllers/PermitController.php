<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\User;
use App\Permit;
use App\Days;
use App\Attendance;
use App\Schedule;
use Yajra\DataTables\Datatables;

class PermitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permit.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permit.form', ['action' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dateInput = explode(",", request()->date_permit);
        
        // $dateStart = Carbon::parse($date[0]);
        // $dateEnd = Carbon::parse($date[1]);
        // $date1 = date('Y-m-d', strtotime($dateStart->toDateTimeString()));
        // $date2 = date('Y-m-d', strtotime($dateEnd->toDateTimeString()));

        // $period = CarbonPeriod::create($date1, $date2);

        // Iterate over the period
        // $dates = [];
        // foreach ($period as $date) {
        //     array_push($dates, $date->format('Y-m-d'));
        // }

        $permit = new Permit;
        $permit->users_id = request()->users_id;
        $permit->type_permit = request()->type_permit;
        $permit->date_permit = json_encode($dateInput);
        $permit->amount = count($dateInput);
        $permit->status = request()->status;

        if(request()->hasFile('foto') && request()->type_permit == 'akademis'){
            $file = request()->file('foto');
     
            $nama_file = Carbon::now().'.'.$file->getClientOriginalExtension();
     
            $tujuan_upload = 'foto/izin';
            $file->move($tujuan_upload,$nama_file);
            $permit->foto = $nama_file;
        }

        if(request()->status == 'approved'){
            foreach($dateInput as $date){
                $datePermit = Carbon::parse($date);
                $getDays = Days::where('name_day', $datePermit->format('l'))->first();
                $getSchedule = Schedule::where('users_id', $permit->users_id)->where('days_id', $getDays->id)->first();
                
                if($getSchedule){ // jika ada jadwalnya, maka create
                    Attendance::create([
                        "user_id" => $permit->users_id,
                        // "user_id" => 1,
                        "start" => Carbon::parse($date.' '.$getSchedule->clock_in)->addHour(7),
                        "end" => Carbon::parse($date.' '.$getSchedule->clock_out)->addHour(7),
                        "is_on_area" => "0",
                        "hours" => $getSchedule->hours,
                        "note_start" => '',
                        "note_end" => '',
                        "status" => 'izin'
                    ]);
                }
            }
        }

        $permit->note = request()->note;
        $permit->request_to = 1;
        $permit->note_from_manager = 'note_from_manager';
        $permit->save();

        if($permit){
            return redirect()->route('permit.index')->with('success','Data berhasil disimpan!');
        }

        return redirect()->route('permit.create')->with('danger','Terjadi masalah!');
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
        $permit = Permit::findOrFail($id);
        return view('permit.form', ['action' => 'edit', 'permit' => $permit]);
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
        $datePermitInput = explode(",", request()->date_permit);
        
        // $dateStart = Carbon::parse($date[0]);
        // $dateEnd = Carbon::parse($date[1]);
        // $date1 = date('Y-m-d', strtotime($dateStart->toDateTimeString()));
        // $date2 = date('Y-m-d', strtotime($dateEnd->toDateTimeString()));

        // $period = CarbonPeriod::create($date1, $date2);

        // // Iterate over the period
        // $dates = [];
        // foreach ($period as $date) {
        //     array_push($dates, $date->format('Y-m-d'));
        // }

        $permit = Permit::findOrFail($id);
        $permit->users_id = request()->users_id;
        $permit->type_permit = request()->type_permit;
        $permit->date_permit = json_encode($datePermitInput);
        $permit->amount = count($datePermitInput);
        $permit->status = request()->status;

        if(request()->hasFile('foto') && request()->type_permit == 'akademis'){
            $file = request()->file('foto');
     
            $nama_file = Carbon::now().'.'.$file->getClientOriginalExtension();
     
            $tujuan_upload = 'foto/izin';
            $file->move($tujuan_upload,$nama_file);
            $permit->foto = $nama_file;
        } else {
            $permit->foto = null;
        }
        
        // bersihkan data sebelumnya
        $permitOld = Permit::findOrFail($id);
        foreach(json_decode($permitOld->date_permit) as $date){
            $datePermit = Carbon::parse($date);
            $getDays = Days::where('name_day', $datePermit->format('l'))->first();
            $getSchedule = Schedule::where('users_id', $permit->users_id)->where('days_id', $getDays->id)->first();
            
            if($getSchedule){ // jika ada jadwalnya, maka create
                $dataAttendance = Attendance::whereDate('start',$date)->where('user_id', $permit->users_id)->first();
                if($dataAttendance){
                    $dataAttendance->delete();
                }
            }
        }
        
        if(request()->status == 'approved'){
            foreach($datePermitInput as $date){
                $datePermit = Carbon::parse($date);
                $getDays = Days::where('name_day', $datePermit->format('l'))->first();
                $getSchedule = Schedule::where('users_id', $permit->users_id)->where('days_id', $getDays->id)->first();
                
                if($getSchedule){ // jika ada jadwalnya, maka create
                    Attendance::create([
                        "user_id" => $permit->users_id,
                        // "user_id" => 1,
                        "start" => Carbon::parse($date.' '.$getSchedule->clock_in)->addHour(7),
                        "end" => Carbon::parse($date.' '.$getSchedule->clock_out)->addHour(7),
                        "is_on_area" => "0",
                        "hours" => $getSchedule->hours,
                        "note_start" => '',
                        "note_end" => '',
                        "status" => 'izin'
                    ]);
                }
            }
        } else {
            foreach($datePermitInput as $date){
                $datePermit = Carbon::parse($date);
                $getDays = Days::where('name_day', $datePermit->format('l'))->first();
                $getSchedule = Schedule::where('users_id', $permit->users_id)->where('days_id', $getDays->id)->first();
                
                if($getSchedule){ // jika ada jadwalnya, maka create
                    $dataAttendance = Attendance::whereDate('start',$date)->where('user_id', $permit->users_id)->first();
                    if($dataAttendance){
                        $dataAttendance->delete();
                    }
                }
            }
        }

        $permit->note = request()->note;
        $permit->request_to = 1;
        $permit->note_from_manager = 'note_from_manager';
        $permit->save();

        if($permit){
            return redirect()->route('permit.index')->with('success','Data berhasil dirubah!');
        }

        return redirect()->route('permit.create')->with('danger','Terjadi masalah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Permit::findOrFail($id);


        foreach(json_decode($data->date_permit) as $date){
            $datePermit = Carbon::parse($date);
            $getDays = Days::where('name_day', $datePermit->format('l'))->first();
            $getSchedule = Schedule::where('users_id', $data->users_id)->where('days_id', $getDays->id)->first();
            
            if($getSchedule){ // jika ada jadwalnya, maka create
                $dataAttendance = Attendance::whereDate('start',$date)->where('user_id', $data->users_id)->first();
                if($dataAttendance){
                    $dataAttendance->delete();
                }
            }
        }

        $data->delete();

        return redirect()->route('permit.index')->with('success','Data berhasil dihapus!');
    }

    public function apiPermit(){
        if(Auth::user()->id == 1) { // jika admin
        $item = Permit::select('permit.id', 'users.name', 'permit.created_at', 'permit.status')
                    ->leftJoin('users', 'users.id', '=', 'permit.users_id')
                    ->orderBy('permit.created_at', 'DESC')
                    ->get();
        } else {
        $item = Permit::select('permit.id', 'users.name', 'permit.created_at', 'permit.status')
                    ->leftJoin('users', 'users.id', '=', 'permit.users_id')
                    ->where('users_id', Auth::user()->id)
                    ->orderBy('permit.created_at', 'DESC')
                    ->get();
        }

        return Datatables::of($item)
                ->addIndexColumn()
                ->editColumn('created_at', function ($item) {
                    return date('d-m-Y', strtotime($item->created_at));
                })
                ->addColumn('action', function($item){
                    // if($item->status == 'pending') {
                        return 
                        // '<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> '.
                        '<a href="'.route("permit.edit", $item->id).'" class="mr-2"><svg viewBox="0 0 24 24" width="18" height="18" stroke="#ffc107" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a> '.
                        '<form id="delete-form-'.$item->id.'" method="post" action="'.route("permit.destroy",$item->id).'" style="display: none">
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
                    // }
                })->rawColumns(['action'])->make(true);
    }
}
