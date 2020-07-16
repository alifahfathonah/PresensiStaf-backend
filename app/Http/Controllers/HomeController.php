<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $entity = Entity::first();
        return view('home', ['entity' => $entity]);
    }

    public function updateEntity($id)
    {
        $entity = Entity::findOrFail($id);
        $entity->lat = request("lat");
        $entity->lng = request("lng");
        $entity->radius = request("radius");
        $entity->save();

        // return view('home', ['entity' => $entity, 'msg' => 'Success Update Data!']);
        return redirect()->route('home')
        ->with('success','Success Update Data!');
    }
}
