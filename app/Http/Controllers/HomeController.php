<?php

namespace App\Http\Controllers;

use App\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $places= Place::orderby('NAME')->get();
        Log::debug('Places = '.$places);
        return view('home',compact('places'));
    }

    public function admin()
    {
        $places= Place::orderby('NAME')->get();
        //Log::debug('Places = '.$places);

        return view('admin.admin',compact('places'));
    }
}
