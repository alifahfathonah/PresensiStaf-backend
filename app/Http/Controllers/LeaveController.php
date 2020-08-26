<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Yajra\DataTables\Datatables;
use App\Leave;
use App\LeaveStaf;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('leave.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leave.form', ['action' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = explode(" - ", request()->date_leave, 2);
        
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

        $leave = new Leave;
        $leave->users_id = request()->users_id;
        $leave->date_leave = json_encode($dates);
        $leave->amount = count($dates);
        $leave->status = request()->status;
        $leave->note = request()->note;
        $leave->request_to = 1;
        $leave->note_from_manager = 'note_from_manager';
        $leave->save();

        // update balance
        $leaveStaf = LeaveStaf::where('users_id', $leave->users_id)->where('periode_id', request()->periode_id)->first();
        
        if(request()->status == "approved"){
            $leaveStaf->balance = $leaveStaf->balance - $leave->amount;
            $leaveStaf->save();
        } else if(request()->status == "rejected") {
            $leaveStaf->balance = $leaveStaf->balance + $leave->amount;
            $leaveStaf->save();
        }

        if($leave){
            return redirect()->route('leave.index')->with('success','Data berhasil disimpan!');
        }

        return redirect()->route('leave.create')->with('danger','Terjadi masalah!');
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
        $leave = Leave::findOrFail($id);
        return view('leave.form', ['action' => 'edit', 'leave' => $leave]);
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
        $date = explode(" - ", request()->date_leave, 2);
        
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

        $leave = Leave::find($id);
        $leave->users_id = request()->users_id;
        $leave->date_leave = json_encode($dates);
        $leave->amount = count($dates);
        $leave->status = request()->status;
        $leave->note = request()->note;
        $leave->request_to = 1;
        $leave->note_from_manager = 'note_from_manager';
        $leave->save();

        // update balance
        $leaveStaf = LeaveStaf::where('users_id', $leave->users_id)->where('periode_id', request()->periode_id)->first();
        
        if(request()->status == "approved"){
            $leaveStaf->balance = $leaveStaf->balance - $leave->amount;
            $leaveStaf->save();
        } else if(request()->status == "rejected") {
            $leaveStaf->balance = $leaveStaf->balance + $leave->amount;
            $leaveStaf->save();
        }

        if($leave){
            return redirect()->route('leave.index')->with('success','Data berhasil diedit!');
        }

        return redirect()->route('leave.create')->with('danger','Terjadi masalah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Leave::findOrFail($id);
        $data->delete();

        return redirect()->route('leave.index')->with('success','Data berhasil dihapus!');
    }

    public function apiLeave(){
        if(Auth::user()->id == 1) { // jika admin
            $item = Leave::select('leave.id', 'users.name', 'leave.created_at', 'leave.status')
            ->leftJoin('users', 'users.id', '=', 'leave.users_id')
            ->orderBy('leave.created_at', 'DESC')
            ->get();
        } else {
            $item = Leave::select('leave.id', 'users.name', 'leave.created_at', 'leave.status')
            ->leftJoin('users', 'users.id', '=', 'leave.users_id')
            ->where('users_id', Auth::user()->id)
            ->orderBy('leave.created_at', 'DESC')
            ->get();
        }

        return Datatables::of($item)
                ->addIndexColumn()
                ->editColumn('created_at', function ($item) {
                    return date('d-m-Y', strtotime($item->created_at));
                })
                ->addColumn('action', function($item){
                    if($item->status == 'pending') {
                        return 
                        '<a href="'.route("leave.edit", $item->id).'" class="mr-2"><svg viewBox="0 0 24 24" width="18" height="18" stroke="#ffc107" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a> '.
                        '<form id="delete-form-'.$item->id.'" method="post" action="'.route("leave.destroy",$item->id).'" style="display: none">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                        </form>'.
                        '<a
                        onclick="
                        if(confirm(\'Are you sure, You Want to delete '.$item->name. '?\'))
                            {
                                event.preventDefault();
                                document.getElementById(\'delete-form-'.$item->id.'\').submit();
                            }else{
                                event.preventDefault();
                        }" 
                        class=""><svg viewBox="0 0 24 24" width="18" height="18" stroke="#dc3545" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                    }

                    return null;
                })->rawColumns(['action'])->make(true);
    }

    public function getPeriodeByUsers() {
        $data = LeaveStaf::where('users_id', request()->users_id)->with(['periode', 'users'])->get();

        $dataPeriode = [];
        foreach($data as $dataHakCuti){
            array_push($dataPeriode, $dataHakCuti->periode);
        }
        return response()->json(['data' => $dataPeriode]);
    }
}
