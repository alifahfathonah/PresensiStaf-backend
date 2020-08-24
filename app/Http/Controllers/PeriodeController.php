<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Periode;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('periode.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('periode.form', ['action' => 'create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $periode = new Periode;
        $periode->name = request()->name;
        $periode->periode_start = request()->periode_start;
        $periode->periode_end = request()->periode_end;
        $periode->save();

        if($periode){
            return redirect()->route('periode.index')->with('success','Data berhasil disimpan!');
        }

        return redirect()->route('periode.create')->with('danger','Terjadi masalah!');
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
        $periode = Periode::find($id);
        return view('periode.form', ['action' => 'edit', 'periode' => $periode]);
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
        $periode = Periode::find($id);
        $periode->name = request()->name;
        $periode->periode_start = request()->periode_start;
        $periode->periode_end = request()->periode_end;
        $periode->save();

        if($periode){
            return redirect()->route('periode.index')->with('success','Data berhasil diedit!');
        }

        return redirect()->route('periode.create')->with('danger','Terjadi masalah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Periode::findOrFail($id);
        $data->delete();

        return redirect()->route('periode.index')->with('success','Data berhasil dihapus!');
    }

    public function apiPeriode(){
        $item = Periode::all();

        return Datatables::of($item)
                ->addIndexColumn()
                ->addColumn('date_expire', function ($item) {
                    return date('d-m-Y', strtotime($item->periode_start)). ' - ' .date('d-m-Y', strtotime($item->periode_end));
                })
                ->addColumn('action', function($item){
                    return 
                    // '<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Show</a> '.
                    '<a href="'.route("periode.edit", $item->id).'" class="mr-2"><svg viewBox="0 0 24 24" width="18" height="18" stroke="#ffc107" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a> '.
                    '<form id="delete-form-'.$item->id.'" method="post" action="'.route("periode.destroy",$item->id).'" style="display: none">
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
                })->rawColumns(['date_expire','action'])->make(true);
    }
}
