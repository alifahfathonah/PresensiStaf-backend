<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\User;
use App\Attendance;
use Yajra\DataTables\Datatables;
use DB;

class PresensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('presensi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('presensi.form', ['action' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public function apiPresensi(){
        $now = Carbon::now();
        $now->addHours(7);

        if(Auth::user()->id == 1) { // jika admin
        $item = Attendance::select('attendance.id', 'users.name', 'attendance.created_at', 'attendance.start', 'attendance.end', 'attendance.hours', 'attendance.status')
                    ->leftJoin('users', 'users.id', '=', 'attendance.user_id')
                    ->whereDate('start', $now->format('Y-m-d'))
                    ->orderBy('attendance.created_at', 'DESC')
                    ->get();
        } else {
        $item = Attendance::select('attendance.id', 'users.name', 'attendance.created_at', 'attendance.start', 'attendance.end', 'attendance.hours', 'attendance.status')
                    ->leftJoin('users', 'users.id', '=', 'attendance.user_id')
                    ->whereDate('start', $now->format('Y-m-d'))
                    ->where('users_id', Auth::user()->id)
                    ->orderBy('attendance.created_at', 'DESC')
                    ->get();
        }

        return Datatables::of($item)
                ->addIndexColumn()
                ->editColumn('start', function ($item) {
                    return date('d-m-Y H:i', strtotime($item->start));
                })
                ->editColumn('end', function ($item) {
                    if($item->hours){
                        return date('d-m-Y H:i', strtotime($item->end));
                    }
                    return '-';
                })
                ->editColumn('hours', function ($item) {
                    if($item->hours){
                        return $item->hours;
                    }
                    return '-';
                })
                ->make(true);
    }

    public function recap(){
        return view('presensi.recap.index');
        // return response()->json(['23']);
    }

    public function apiPresensiRecap(){
        $now = Carbon::now();
        $now->addHours(7);

        // $user = 0;
        if(Auth::user()->id == 1) { // jika admin
        //     $user = 

        $data = User::leftJoin('users_detail', 'users_detail.users_id', '=', 'users.id')
            ->where('users.id', '!=', "1")
            ->select(
                "users.id",
                "users_detail.full_name",
                DB::raw("(SELECT count(user_id) FROM attendance WHERE user_id=users.id AND (attendance.start BETWEEN '" . request("start") . "' AND '" . request("end") . "') ) as present_total"),

                DB::raw("(SELECT count(user_id) FROM attendance WHERE user_id=users.id AND status='hadir' AND start IS NOT NULL AND end IS NOT NULL AND (attendance.start BETWEEN '" . request("start") . "' AND '" . request("end") . "') ) as present_full_time"),
                
                DB::raw("(SELECT count(user_id) FROM attendance WHERE user_id=users.id AND status='hadir' AND note_start != '' AND (attendance.start BETWEEN '" . request("start") . "' AND '" . request("end") . "') ) as present_late"),
                
                DB::raw("(SELECT count(user_id) FROM attendance WHERE user_id=users.id AND status='sakit' AND (attendance.start BETWEEN '" . request("start") . "' AND '" . request("end") . "') ) as sick_present"),
                
                DB::raw("(SELECT count(user_id) FROM attendance WHERE user_id=users.id AND status='izin' AND (attendance.start BETWEEN '" . request("start") . "' AND '" . request("end") . "') ) as permit_present"),
                
                DB::raw("(SELECT count(user_id) FROM attendance WHERE user_id=users.id AND status='cuti' AND (attendance.start BETWEEN '" . request("start") . "' AND '" . request("end") . "') ) as leave_present"),
                
                DB::raw("(SELECT count(user_id) FROM attendance WHERE user_id=users.id AND status='alpha' AND (attendance.start BETWEEN '" . request("start") . "' AND '" . request("end") . "') ) as not_present"),
            )->get();
            
        }else{
            $data = User::leftJoin('users_detail', 'users_detail.users_id', '=', 'users.id')
            ->where('users.id', Auth::user()->id)
            ->select(
                "users.id",
                "users_detail.full_name",
                DB::raw("(SELECT count(user_id) FROM attendance WHERE user_id=users.id AND (attendance.start BETWEEN '" . request("start") . "' AND '" . request("end") . "') ) as present_total"),

                DB::raw("(SELECT count(user_id) FROM attendance WHERE user_id=users.id AND status='hadir' AND start IS NOT NULL AND end IS NOT NULL AND (attendance.start BETWEEN '" . request("start") . "' AND '" . request("end") . "') ) as present_full_time"),
                
                DB::raw("(SELECT count(user_id) FROM attendance WHERE user_id=users.id AND status='hadir' AND note_start != '' AND (attendance.start BETWEEN '" . request("start") . "' AND '" . request("end") . "') ) as present_late"),
                
                DB::raw("(SELECT count(user_id) FROM attendance WHERE user_id=users.id AND status='sakit' AND (attendance.start BETWEEN '" . request("start") . "' AND '" . request("end") . "') ) as sick_present"),
                
                DB::raw("(SELECT count(user_id) FROM attendance WHERE user_id=users.id AND status='izin' AND (attendance.start BETWEEN '" . request("start") . "' AND '" . request("end") . "') ) as permit_present"),
                
                DB::raw("(SELECT count(user_id) FROM attendance WHERE user_id=users.id AND status='cuti' AND (attendance.start BETWEEN '" . request("start") . "' AND '" . request("end") . "') ) as leave_present"),
                
                DB::raw("(SELECT count(user_id) FROM attendance WHERE user_id=users.id AND status='alpha' AND (attendance.start BETWEEN '" . request("start") . "' AND '" . request("end") . "') ) as not_present"),
            )->get();
        }

        // return $data;
        return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('present_total', function ($item) {
                    return $item->present_total ? $item->present_total : 0;
                })
                ->editColumn('present_full_time', function ($item) {
                    return $item->present_full_time ? $item->present_full_time : 0;
                })
                ->editColumn('present_late', function ($item) {
                    return $item->present_late ? $item->present_late : 0;
                })
                ->editColumn('sick_present', function ($item) {
                    return $item->sick_present ? $item->sick_present : 0;
                })
                ->editColumn('permit_present', function ($item) {
                    return $item->permit_present ? $item->permit_present : 0;
                })
                ->editColumn('leave_present', function ($item) {
                    return $item->leave_present ? $item->leave_present : 0;
                })
                ->editColumn('not_present', function ($item) {
                    return $item->not_present ? $item->not_present : 0;
                })
                ->rawColumns([
                    'present_total',
                    'present_full_time',
                    'present_late',
                    'sick',
                    'permit',
                    'leave_present',
                    'not_present',
                ])
                ->make(true);
    }
}
