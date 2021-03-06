<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Schedule;
use App\User;
use Yajra\DataTables\Datatables;
use Helper;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::find($id);
        return view('schedule.index', ['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $user = User::find($id);
        return view('schedule.form', ['user' => $user, 'action' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $userid)
    {
        $schedule = new Schedule;
        $schedule->users_id = $userid;
        $schedule->days_id = request()->days_id;

        $clockIn = Carbon::parse(request()->clock_in);
        $clockOut = Carbon::parse(request()->clock_out);

        $schedule->clock_in = $clockIn->format('H:i:s');
        $schedule->clock_out = $clockOut->format('H:i:s');
        $schedule->hours = '0'.$clockOut->diffInHours($clockIn).':00:00';
        $schedule->save();

        if($schedule){
            return redirect()->route('schedule.index', $userid)->with('success','Data berhasil disimpan!');
        }

        return redirect()->route('schedule.create')->with('danger','Terjadi masalah!');
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
    public function edit($userid, $id)
    {
        $user = User::find($userid);
        $schedule = Schedule::find($id);
        return view('schedule.form', ['user' => $user, 'action' => 'edit', 'schedule' => $schedule]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userid, $id)
    {
        $schedule = Schedule::find($id);
        $schedule->days_id = request()->days_id;

        $clockIn = Carbon::parse(request()->clock_in);
        $clockOut = Carbon::parse(request()->clock_out);

        $schedule->clock_in = $clockIn->format('H:i:s');
        $schedule->clock_out = $clockOut->format('H:i:s');
        $schedule->hours = '0'.$clockOut->diffInHours($clockIn).':00:00';
        $schedule->save();

        if($schedule){
            return redirect()->route('schedule.index', $userid)->with('success','Data berhasil disimpan!');
        }

        return redirect()->route('schedule.create')->with('danger','Terjadi masalah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($userid, $id)
    {
        $data = Schedule::findOrFail($id);
        $data->delete();

        return redirect()->route('schedule.index', $userid)->with('success','Data berhasil dihapus!');
    }

    public function apiSchedule($id){
        $item = Schedule::select('schedule.id', 'users.id as idUser','users.name', 'schedule.created_at', 'schedule.hours', 'schedule.clock_in', 'schedule.clock_out', 'days.name_day')
                    ->leftJoin('users', 'users.id', '=', 'schedule.users_id')
                    ->leftJoin('days', 'days.id', '=', 'schedule.days_id')
                    ->where('users.id', $id)
                    ->orderBy('users.name', 'ASC')
                    ->get();

        return Datatables::of($item)
                ->addIndexColumn()
                ->editColumn('created_at', function ($item) {
                    return date('d-m-Y', strtotime($item->created_at));
                })
                ->editColumn('name_day', function ($item) {

                    return Helper::getDayIndo($item->name_day);
                })
                ->addColumn('total_jam', function ($item) {
                    $clockIn = Carbon::parse($item->clock_in);
                    $clockOut = Carbon::parse($item->clock_out);
                    return $clockOut->diffInHours($clockIn);
                })
                ->addColumn('action', function($item){
                        return 
                        // '<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> '.
                        '<a href="'.route("schedule.edit", ['userid' => $item->idUser, 'id' => $item->id]).'" class="mr-2"><svg viewBox="0 0 24 24" width="18" height="18" stroke="#ffc107" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a> '.
                        '<form id="delete-form-'.$item->id.'" method="post" action="'.route("schedule.destroy",['userid' => $item->idUser, 'id' => $item->id]).'" style="display: none">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                        </form>'.
                        '<a
                        onclick="
                        if(confirm(\'Are you sure, You Want to delete '.$item->name_day.'?\'))
                            {
                                event.preventDefault();
                                document.getElementById(\'delete-form-'.$item->id.'\').submit();
                            }else{
                                event.preventDefault();
                        }" 
                        class=""><svg viewBox="0 0 24 24" width="18" height="18" stroke="#dc3545" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>';
                })->rawColumns(['action', 'total_jam'])->make(true);
    }
}
