<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\User;
use App\Attendance;
use Yajra\DataTables\Datatables;

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
}
