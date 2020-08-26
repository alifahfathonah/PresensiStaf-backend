<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Datatables;
use App\LeaveStaf;

class LeaveStafController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('leave_staf.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leave_staf.form', ['action' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $leaveStaf = new LeaveStaf;
        $leaveStaf->users_id = request()->users_id;
        $leaveStaf->periode_id = request()->periode_id;
        $leaveStaf->balance = request()->balance;
        $leaveStaf->save();

        if($leaveStaf){
            return redirect()->route('leave_staf.index')->with('success','Data berhasil disimpan!');
        }

        return redirect()->route('leave_staf.create')->with('danger','Terjadi masalah!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leaveStaf = LeaveStaf::find($id);
        return view('leave_staf.form', ['action' => 'edit','leaveStaf' => $leaveStaf]);
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
        $leaveStaf = LeaveStaf::find($id);
        $leaveStaf->users_id = request()->users_id;
        $leaveStaf->periode_id = request()->periode_id;
        $leaveStaf->balance = request()->balance;
        $leaveStaf->save();

        if($leaveStaf){
            return redirect()->route('leave_staf.index')->with('success','Data berhasil diedit!');
        }

        return redirect()->route('leave_staf.create')->with('danger','Terjadi masalah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = LeaveStaf::findOrFail($id);
        $data->delete();

        return redirect()->route('leave_staf.index')->with('success','Data berhasil dihapus!');
    }

    public function apiLeaveStaf(){
        if(Auth::user()->id == 1) { // jika admin
            $item = LeaveStaf::select('leave_staf.id', 'users.name', 'leave_staf.created_at', 'periode.name as nama_periode', 'leave_staf.balance')
                        ->leftJoin('users', 'users.id', '=', 'leave_staf.users_id')
                        ->leftJoin('periode', 'periode.id', '=', 'leave_staf.periode_id')
                        ->orderBy('leave_staf.created_at', 'DESC')
                        ->get();
        } else {
            $item = LeaveStaf::select('leave_staf.id', 'users.name', 'leave_staf.created_at', 'periode.name as nama_periode', 'leave_staf.balance')
                        ->leftJoin('users', 'users.id', '=', 'leave_staf.users_id')
                        ->leftJoin('periode', 'periode.id', '=', 'leave_staf.periode_id')
                        ->where('users_id', Auth::user()->id)
                        ->orderBy('leave_staf.created_at', 'DESC')
                        ->get();
        }

        return Datatables::of($item)
                ->addIndexColumn()
                ->editColumn('created_at', function ($item) {
                    return date('d-m-Y', strtotime($item->created_at));
                })
                ->addColumn('action', function($item){
                    return 
                    '<a href="'.route("leave_staf.edit", $item->id).'" class="mr-2"><svg viewBox="0 0 24 24" width="18" height="18" stroke="#ffc107" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a> '.
                    '<form id="delete-form-'.$item->id.'" method="post" action="'.route("leave_staf.destroy",$item->id).'" style="display: none">
                        '.csrf_field().'
                        '.method_field("DELETE").'
                    </form>'.
                    '<a
                    onclick="
                    if(confirm(\'Are you sure, You Want to delete '.$item->name. ' Periode ' .$item->nama_periode.'?\'))
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
