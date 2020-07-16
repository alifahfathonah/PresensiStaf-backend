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
}
